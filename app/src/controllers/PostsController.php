<?php 

namespace App\Controllers;

use App\Controller;
use App\Models\Post;
use App\Tools\Log;
use App\Tools\Data;
use App\Tools\Session;
use App\Tools\Input;
use App\Tools\Auth;
use App\Tools\File;

class PostsController extends Controller {

    private Data  $data;
    private Post  $post;
    private Log   $log;

    private const DESC_PATTERN = "/(&lt;script&gt;|&lt;script\s.*?&gt;)|(&lt;\/script&gt;)|(&lt;img&gt;|(&lt;img\s.*?&gt;))/";
    
    public function __construct() {
        
        if(!Auth::is_logged()) redirect('');

        $this->data  = new Data;
        $this->post  = $this->model('Post');
        $this->log   = $this->logs('post');
        
        $this->data->css = 'public/css/post.css';
    }

    public function index() {
        $this->data->title   = 'Posts';
        $this->data->message = Session::message_output();

        $this->post->get_all();
        $this->post->get_categories();
        $this->post->total_approved();

        $this->post->all = array_map(function($post){

            $post['created_at'] = create_readable_date($post['created_at']); 
            return $post;

        }, $this->post->all);

        $this->view('posts/index')->import([$this->data, $this->post])->display();
    }

    public function show($id = 0) {
        if(!is_whole_positive_integer($id)) redirect('posts');

        if(!$this->post->exists($id)) redirect('posts');

        $this->post->find($id);

        if(!isset($this->post->id) || $this->post->is_approved === 0) redirect('posts');

        if(!Auth::user_post($this->post->user_id)) $this->post->add_view();

        $this->data->title = $this->post->title;

        $this->view('posts/show')->import([$this->data, $this->post])->display();
    }

    public function create() {
        $this->data->title = 'Create Post';

        $this->post->get_categories();

        $this->view('posts/create')->import([$this->data, $this->post])->display();
    }

    public function store() {
        $input = new Input;
        $input->check(['title', 'description', 'category']);

        if($input->invalid) {
            $this->log->status('FAIL')->method('POST CREATE')->message('Not enough post parameters')->write();
            redirect('post/create');
        }

        $this->post->title       = $input->post('title')->chars()->retrieve();
        $this->post->description = $input->post('description')->safe(self::DESC_PATTERN)->retrieve();
        $this->post->category_id = $input->post('category')->integer()->retrieve();
        $this->post->user_id     = (int) Session::get('user', 'id');

        $input->validate_title($this->post, $this->log);
        $input->validate_description($this->post, $this->log);
        $input->validate_category($this->post, $this->log);

        $this->complete_create($input);
    }

    public function remove() {
        $input      = new Input;
        $user_email = Session::get('user', 'email');

        $input->check(['post_id']);

        if($input->invalid) {
            $this->log->status('FAIL')->method('POST REMOVE')->reason('Post id not provided')->message($user_email)->write();
            redirect('posts');
        }

        $input->validate_id('post_id');

        if($input->invalid) {
            $this->log->status('FAIL')->method('POST REMOVE')->reason('Post id value is not valid')->message($user_email)->write();
            redirect('posts');
        }

        $id = $input->post('post_id')->integer()->retrieve();

        $this->post->find($id);

        if(is_null($this->post->id)) {
            $this->log->status('FAIL')->method('POST REMOVE')->reason('Post id manualy changed')->message($user_email)->write();
            redirect('posts');
        }

        $user_id = $this->post->user_id;

        if(!Auth::user_post($user_id)) {
           $this->log->status('FAIL')->method('POST REMOVE')->reason('User tried to remove other user post')->message($user_email)->write();
           redirect('posts');
        }

        $this->complete_remove();
    }

    public function edit($id = 0) {
        if(!is_whole_positive_integer($id)) redirect('posts');

        $this->post->find($id);

        if(is_null($this->post->id)) redirect('posts');
        if(!Auth::user_post($this->post->user_id) || $this->post->is_approved === 0) redirect('posts');

        $this->post->get_categories();

        $this->data->title = $this->post->title;

        $this->view('posts/edit')->import([$this->data, $this->post])->display();
    }

    public function update() {
        $input = new Input;
        $input->filter(['post_id' => FILTER_SANITIZE_NUMBER_INT, 'category_id' => FILTER_SANITIZE_NUMBER_INT, 'title' => FILTER_SANITIZE_STRING, 'description' => '', 'delete_image' => '']);
        $input->check(['post_id', 'category_id', 'title', 'description']);

        if($input->invalid) redirect_referer();
        
        $pattern = "/(&lt;script&gt;|&lt;script\s.*?&gt;)|(&lt;\/script&gt;)|(&lt;img&gt;|(&lt;img\s.*?&gt;))/";

        $this->post->id          = $input->post('post_id')->integer()->retrieve();
        $this->post->title       = $input->post('title')->chars()->retrieve();
        $this->post->description = $input->post('description')->safe($pattern)->retrieve();
        $this->post->category_id = $input->post('category_id')->integer()->retrieve();

        $input->validate_post_id($this->post, $this->log);
        $input->validate_title($this->post, $this->log);
        $input->validate_description($this->post, $this->log);
        $input->validate_category($this->post, $this->log);

        if($this->post->validated) {
           
            $this->post->find_user_id_by_post_id();

            if(Auth::user_post($this->post->user_id)) {
                $this->post->update();
                $this->log->status('SUCCESS')->method('POST UPDATE')->remote(true, true)->write();

                $delete_image = $input->post('delete_image')->retrieve();

                if(!empty($delete_image)) {
                    $this->delete_image();
                    $this->log->status('SUCCESS')->method('POST IMAGE DELETE')->remote(true, true)->write();
                }

                Session::message_set("Post {$this->post->title} has been updated. Waiting for approval", 'success');
                redirect('posts');
            }

            $this->log->status('FAIL')->method('POST UPDATE')->message('Post id not belong to ' . Session::get('user', 'id'))->write();
        }

        $this->log->status('FAIL')->method('POST UPDATE')->write();

        redirect_referer();
    }

    private function complete_create(Input $input) {
        $user_email = Session::get('user', 'email');

        if($this->post->validated) {
            if($input->file->submitted) {
                $input->file->upload_image_validate($this->log);

                if(!$input->file->invalid) {
                    $this->post->save();
                    $this->log->status('SUCCESS')->method('POST CREATE')->reason('ADDED IMAGE')->message($user_email)->write();

                    $unique_name = unique_name($input->file->name);
                    $data        = array(
                        'id'          => $this->post->last_id(),
                        'unique_name' => $unique_name,
                        'file_size'   => $input->file->size,
                        'file_type'   => $input->file->type,
                        'image_src'   => $_ENV['APP_SRC']  . 'public/images/posts/' . $unique_name,
                        'image_root'  => dirname($_ENV['APP_ROOT']) . '/public/images/posts/' . $unique_name
                    );

                    $input->file->save_uploaded_img_to_db('post_images', $data);
                    $input->file->save_uploaded_img_to_disk($data['image_root']);

                    Session::message_set('Your post has been submited. Please wait for admin approval', 'success');
                    redirect('posts');
                }

                $this->post->file_err = $input->file->err_message;
                $this->log->status('FAIL')->method('POST CREATE')->message($user_email)->write();
            } else {
                $this->post->save();
                $this->log->status('SUCCESS')->method('POST CREATE')->message($user_email)->write();

                Session::message_set('Your post has been submited. Please wait for admin approval', 'success');
                redirect('posts');
            }
        } else {
            $this->log->status('FAIL')->method('POST CREATE')->message($user_email)->write();
        }
    }

    private function complete_remove() {
        $this->post->remove();
        
        if(!is_null($this->post->image_root)) {
            $location = $this->post->image_root;
            $file = new File;
            $file->remove($location);
        }

        $message = "Your post <strong>{$this->post->title}</strong> has been removed";

        Session::message_set($message, 'success');

        redirect('posts');
    }

    private function delete_image() {
        $this->post->get_image_details();

        $file = new File;
        $file->remove($this->post->image_root);

        $this->post->remove_image();
    }

    // ======================================================== //
    // JS Fetch API's
    // ======================================================== //
    public function my_posts($id = 0) {
        if(!is_basic_ajax_request()) {
            header('Content-Type: application/json');
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Page Not Found');
            echo json_encode(['response' => '404', 'message' => 'Page Not Found']);
            exit;
        }
        if(!is_whole_positive_integer($id) || !Auth::user_post($id)) {
            header('Content-Type: application/json');
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Access Forbidden');
            echo json_encode(['response' => 'unauthorized', 'posts' => $this->post->all, 'total' => $this->post->total]);
            exit;
        }

        $this->post->find_user_posts($id);
        
        if(count($this->post->all) > 0) {
            $this->post->total_user_posts($id);

            $this->post->all = array_map(function($post){
                $post['created_at'] = create_readable_date($post['created_at']);
                $post['post_url'] = $_ENV['APP_SRC'] . 'post/show/' . $post['post_id'];
                return $post;

            }, $this->post->all);
        }
        
        header('Access-Control-Allow-Origin: ' . $_ENV['APP_SRC']);
        header('Access-Control-Allow-Methods: GET');
        header('Content-Type: application/json');
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
        echo json_encode(['response' => 'valid', 'posts' => $this->post->all, 'total' => $this->post->total]);
        exit;
    }

    public function page($page) {
        if(is_valid_ajax_request('posts')) {
            if(!is_whole_positive_integer($page)) {
                header('Content-Type: application/json');
                header($_SERVER['SERVER_PROTOCOL'] . ' 404 Page Not Found');
                echo json_encode(['response' => '404', 'message' => 'Page Not Found']);
                exit;
            }

            $page        = (int) $page;
            $page_offset = $page * $this->post::PAGE_LIMIT - $this->post::PAGE_LIMIT;

            $this->post->current_page = $page;
            $this->post->get_all($page_offset);
            $this->post->total_approved();

            $this->post->all = array_map(function($post){
                $post['created_at'] = create_readable_date($post['created_at']); 
                return $post;
            }, $this->post->all);
            
            header('Access-Control-Allow-Origin: ' . $_ENV['APP_SRC']);
            header('Access-Control-Allow-Methods: GET');
            header('Content-Type: application/json');
            header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
            echo json_encode([
                'current_page' => $this->post->current_page, 
                'total'        => $this->post->total,
                'limit'        => $this->post::PAGE_LIMIT,
                'posts'        => $this->post->all
            ]);
            exit;
        }

        header('Content-Type: application/json');
        header($_SERVER['SERVER_PROTOCOL'] . '404 Page Not Found');
        echo json_encode(['response' => '404', 'message' => 'Page Not Found']);
    }

    public function search($category_id, $page = 1) {
        if(is_valid_ajax_request('posts')) {
            $page        = (int) $page;
            $page_offset = $page * $this->post::PAGE_LIMIT - $this->post::PAGE_LIMIT;

            $this->post->current_page = $page;
            $this->post->total_approved($category_id);
            $this->post->search($category_id, $page_offset);

            $this->post->all = array_map(function($post){
                $post['created_at'] = create_readable_date($post['created_at']);
                return $post;
            }, $this->post->all);
            
            header('Access-Control-Allow-Origin: ' . $_ENV['APP_SRC']);
            header('Access-Control-Allow-Methods: GET');
            header('Content-Type: application/json');
            header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
            echo json_encode([
                'category_id'  => $category_id,
                'current_page' => $this->post->current_page,
                'total'        => $this->post->total, 
                'limit'        => $this->post::PAGE_LIMIT, 
                'posts'        => $this->post->all
            ]);
            exit;
        }

        header('Content-Type: application/json');
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Page Not Found');
        echo json_encode(['response' => '404', 'message' => 'Page Not Found']);
        exit;
    }

}
