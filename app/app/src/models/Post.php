<?php 

namespace App\Models;

use App\Utilities\ClassNameInterface;
use App\Database;

class Post implements ClassNameInterface {

    private Database $db;

    public const PAGE_LIMIT        = 5;
    public const POST_MAX_WORDS    = 600;

    public ?int   $id              = null;
    public int    $user_id         = 0;
    public int    $category_id;
    public int    $is_approved;
    public int    $views;
    public int    $total           = 0;
    public ?int   $current_page    = null;

    public string $title           = '';
    public string $description     = '';
    public string $created_at      = '';
    public string $category_name   = '';
    public string $user            = '';
    public string $username        = '';
    public string $class_name      = '';

    public int     $image_size     = 0;
    public string  $image_type     = '';
    public ?string $image_name     = '';
    public ?string $image_src      = '';
    public ?string $image_root     = '';

    public array  $all             = [];
    public array  $categories      = [];

    public string $title_err       = '';
    public string $description_err = '';
    public string $category_err    = '';
    public string $file_err        = '';

    public bool   $validated       = true;

    public function __construct() {
        $this->db   = new Database;
        $this->generate_class_name();
    }

    public function generate_class_name() {
        if(!property_exists($this, "class_name")) {
            trigger_error('Required property "class_name" does not exists');
            return;
        }

        $this->class_name = __CLASS__;

        $class_array = explode("\\", $this->class_name);
        $this->class_name = strtolower(end($class_array));
    }

    public function save() : void {
        $sql_query = "INSERT INTO posts
                      SET 
                      title       = :title,
                      description = :description,
                      category_id = :category_id,
                      user_id     = :user_id,
                      admin_id    = 2";

        $this->db->prepare($sql_query);
        $this->db->bind(':title',       $this->title);
        $this->db->bind(':description', $this->description);
        $this->db->bind(':category_id', $this->category_id);
        $this->db->bind(':user_id',     $this->user_id);
        $this->db->execute();
    }

    public function remove() : void {
        $sql_query = "DELETE FROM posts WHERE post_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $this->id);
        $this->db->execute();
    }

    public function update() : void {
        $sql_query = "UPDATE posts SET 
                      title       = :title,
                      description = :description,
                      category_id = :category_id,
                      is_approved = 0
                      WHERE post_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':title',       $this->title);
        $this->db->bind(':description', $this->description);
        $this->db->bind(':id',          $this->id);
        $this->db->bind(':category_id', $this->category_id);
        $this->db->execute();
    }

    public function find(int $id) : void {
        $sql_query = "SELECT 
                        p.post_id,
                        p.title,
                        p.description,
                        p.is_approved,
                        p.views,
                        p.created_at,
                        u.user_id,
                        CONCAT_WS(' ', u.first_name, u.last_name) user,
                        u.username,
                        pc.category_name,
                        pi.name as image_name,
                        pi.image_src,
                        pi.image_root
                    FROM posts p
                    INNER JOIN users u 
                    ON p.user_id = u.user_id
                    INNER JOIN post_categories pc 
                    ON p.category_id = pc.category_id
                    LEFT JOIN post_images pi 
                    ON p.post_id = pi.post_id
                    WHERE p.post_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $id);
        $this->db->execute();

        $result_set = $this->db->single();

        if($result_set) {
            $this->id            = (int) $result_set['post_id'];
            $this->title         = $result_set['title'];
            $this->description   = $result_set['description'];
            $this->is_approved   = (int) $result_set['is_approved'];
            $this->views         = (int) $result_set['views'];
            $this->created_at    = create_readable_date($result_set['created_at']);
            $this->user_id       = (int) $result_set['user_id'];
            $this->user          = $result_set['user'];
            $this->username      = $result_set['username'];
            $this->category_name = $result_set['category_name'];
            $this->image_name    = $result_set['image_name'];
            $this->image_src     = $result_set['image_src'];
            $this->image_root    = $result_set['image_root'];
        }
    }

    public function find_user_posts(int $user_id) : void {
        $sql_query = "SELECT 
                        p.post_id,
                        p.title,
                        p.description,
                        p.is_approved,
                        p.views,
                        p.created_at,
                        u.user_id,
                        CONCAT_WS(' ', u.first_name, u.last_name) user,
                        u.username,
                        pc.category_name,
                        pi.name as image_name,
                        pi.image_src,
                        pi.image_root
                    FROM posts p
                    INNER JOIN users u 
                    ON p.user_id = u.user_id
                    INNER JOIN post_categories pc 
                    ON p.category_id = pc.category_id
                    LEFT JOIN post_images pi 
                    ON p.post_id = pi.post_id
                    WHERE u.user_id = :id ORDER BY p.post_id DESC";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $user_id);
        $this->db->execute();

        $result_set = $this->db->all();

        $this->all = $result_set;
    }

    public function find_user_id_by_post_id() : void {
        $sql_query = "SELECT user_id FROM posts WHERE post_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $this->id);
        $this->db->execute();

        $result_set = $this->db->single();

        if($result_set) $this->user_id = $result_set['user_id'];
    }

    public function search($category_id, int $offset) {
        $sql_query = "SELECT 
                        p.post_id,
                        p.title,
                        p.description,
                        p.is_approved,
                        p.views,
                        p.created_at,
                        u.user_id,
                        CONCAT_WS(' ', u.first_name, u.last_name) as user,
                        u.username,
                        pc.category_id,
                        pc.category_name,
                        pi.image_src,
                        pi.image_root
                    FROM posts p 
                    INNER JOIN users u 
                        ON p.user_id = u.user_id
                    INNER JOIN post_categories pc 
                        ON p.category_id = pc.category_id
                    LEFT JOIN post_images pi 
                        ON p.post_id = pi.post_id
                    WHERE pc.category_id = :id AND p.is_approved > 0
                    ORDER BY p.created_at DESC LIMIT :offset," . self::PAGE_LIMIT;

        $this->db->prepare($sql_query);
        $this->db->bind(':id',     $category_id);
        $this->db->bind(':offset', $offset);
        $this->db->execute();

        $result_set = $this->db->all();

        $this->all = $result_set;
    }

    public function get_image_details() {
        $sql_query = "SELECT * FROM post_images WHERE post_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $this->id);
        $this->db->execute();

        $result_set = $this->db->single();

        if($result_set) {
            $this->image_src  = $result_set['image_src'];
            $this->image_root = $result_set['image_root'];
            $this->image_name = $result_set['name'];
        }
    }

    public function get_all(int $offset = 0) : void {
        $sql_query = "SELECT 
                        p.post_id,
                        p.title,
                        CONCAT(LEFT(p.description, 200), ' ...') as description,
                        p.is_approved,
                        p.views,
                        p.created_at,
                        u.user_id,
                        CONCAT_WS(' ', u.first_name, u.last_name) as user,
                        u.username,
                        pc.category_id,
                        pc.category_name,
                        pi.image_src,
                        pi.image_root
                    FROM posts p 
                    INNER JOIN users u 
                        ON p.user_id = u.user_id
                    INNER JOIN post_categories pc 
                        ON p.category_id = pc.category_id
                    LEFT JOIN post_images pi 
                        ON p.post_id = pi.post_id
                    WHERE p.is_approved > 0
                    ORDER BY p.created_at DESC LIMIT {$offset}," . self::PAGE_LIMIT;

        $this->db->prepare($sql_query);
        $this->db->execute();

        $result_set = $this->db->all();

        $this->all = $result_set;
    }

    public function get_categories() {
        $sql_query = "SELECT category_id, category_name FROM post_categories";

        $this->db->prepare($sql_query);
        $this->db->execute();

        $result_set = $this->db->all();

        $this->categories = $result_set;
    }

    public function remove_image() {
        $sql_query = "DELETE FROM post_images WHERE post_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $this->id);
        $this->db->execute();
    }

    public function exists(int $id) {

        $sql_query = "SELECT 1 FROM posts WHERE post_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $id);
        $this->db->execute();

        $result_set = $this->db->single();

        if($result_set) return true;

        return false;
    }

    public function category_exists() {
        $sql_query = "SELECT 1 FROM post_categories WHERE category_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $this->category_id);
        $this->db->execute();

        $result_set = $this->db->single();

        if($result_set) return true;

        return false;
    }

    public function total_user_posts(int $user_id) : void {
        $sql_query = "SELECT COUNT(*) total FROM posts WHERE user_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $user_id);
        $this->db->execute();

        $result_set = $this->db->single();

        $this->total = (int) $result_set['total'];

    }

    public function total($category_id = null) : void {
        if(is_null($category_id)) {
            $sql_query = "SELECT COUNT(post_id) total FROM posts";
            $this->db->prepare($sql_query);
            $this->db->execute();
        } else {
            $sql_query = "SELECT COUNT(post_id) total FROM posts WHERE category_id = :id";
            $this->db->prepare($sql_query);
            $this->db->bind(':id', $category_id);
            $this->db->execute();
        }

        $result_set = $this->db->single();

        $this->total = (int) $result_set['total'];
    }

    public function total_approved($category_id = null) : void {
        if(is_null($category_id)) {
            $sql_query = "SELECT COUNT(post_id) total FROM posts WHERE is_approved > 0";
            $this->db->prepare($sql_query);
            $this->db->execute();
        } else {
            $sql_query = "SELECT COUNT(post_id) total FROM posts WHERE category_id = :id AND is_approved > 0";
            $this->db->prepare($sql_query);
            $this->db->bind(':id', $category_id);
            $this->db->execute();
        }

        $result_set = $this->db->single();

        $this->total = (int) $result_set['total'];
    }

    public function add_view() {
        $sql_query = "UPDATE posts SET views = views + 1 WHERE post_id = :id";

        $this->db->prepare($sql_query);
        $this->db->bind(':id', $this->id);
        $this->db->execute();
    }

    public function last_id() {

        return $this->db->last_id();

    }

}