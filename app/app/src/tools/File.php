<?php 

namespace App\Tools;

use App\Database;
use Intervention\Image\ImageManager;

class File {

	private $db;

	public array  $upload_img_types      = ['image/jpeg', 'image/png'];
	public int    $upload_image_min_size = 50000;
	public int    $upload_image_max_size = 10000000;

	public string $name     = '';
	public string $type     = '';
	public string $tmp_name = '';
	public int    $size     = 0;

	public bool   $submitted = false;
	public bool   $invalid   = false;

	public string $err_message = '';

	public function __construct() {
		$this->db      = new Database;
		$this->manager = new ImageManager(['driver' => 'imagick']);

		if(isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
			$this->submitted = true;
			$this->name      = remove_special_chars($_FILES['file']['name']);
			$this->type      = $_FILES['file']['type'];
			$this->tmp_name  = $_FILES['file']['tmp_name'];
			$this->size      = (int)$_FILES['file']['size'];
		}
	}

	public function save_uploaded_img_to_db(string $table, array $data) : void {
		$sql_query = "INSERT INTO {$table}
					  SET 
					  	name       = :name,
					  	size       = :size,
					  	type       = :type,
					  	post_id    = :id,
					  	image_src  = :image_src,
					  	image_root = :image_root";

		$this->db->prepare($sql_query);
		$this->db->bind(':name',       $data['unique_name']);
		$this->db->bind(':size',       $data['file_size']);
		$this->db->bind(':type',       $data['file_type']);
		$this->db->bind(':id',         $data['id']);
		$this->db->bind(':image_src',  $data['image_src']);
		$this->db->bind(':image_root', $data['image_root']);
		$this->db->execute();
	}

	public function remove($location) {
		if(file_exists($location)) {
			if(is_executable($location)) {
				unlink($location);
			}
		}
	}

	public function save_uploaded_img_to_disk(string $destination) : void {
		$image = $this->manager->make($this->tmp_name)->resize(900, 600);
		$image->save($destination);

		chmod($destination, 0775);
	}

	public function upload_image_validate(Log $log) {
		$finfo     = finfo_open(FILEINFO_MIME_TYPE);
	    $file_type = finfo_file($finfo, $this->tmp_name);

	    if(!in_array($this->type, $this->upload_img_types)) {
	        $this->invalid     = true;
	        $this->err_message = 'Image format not supported';
	        $log->reason('File .' . pathinfo($this->name, PATHINFO_EXTENSION) . ' not supported');
	    }
	    elseif($this->size < $this->upload_image_min_size) {
	        $this->invalid     = true;
	        $this->err_message = 'Image must be minimum ' . ($this->upload_image_min_size / 1000) . 'Kb size';
	        $log->reason('Image is too small');
	    }
	    elseif($this->size > $this->upload_image_max_size) {
	        $this->invalid     = true;
	        $this->err_message = 'Image must be maximum ' . ($this->upload_image_max_size / 1000000) . 'Mb size';
	        $log->reason('Image is too large');
	    }
	}
}