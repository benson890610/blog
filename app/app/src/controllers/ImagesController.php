<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Image;
use Intervention\Image\ImageManager;

class ImagesController extends Controller {

	private Image        $image;
	private ImageManager $manager;

	private string $upload_location;

	private const MAX_UPLOAD_SIZE   = 10000000;

	public function __construct() {
		$this->image   = $this->model('Image');
		$this->manager = new ImageManager(['driver' => 'imagick']);
	}

	public function valid() {
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(!empty($_FILES['file']['name'])) {

				$this->image->name     = $_FILES['file']['name'];
				$this->image->tmp_name = $_FILES['file']['tmp_name'];
				$this->image->type     = $_FILES['file']['type'];
				$this->image->size     = (int) $_FILES['file']['size'];

				if(is_real_image($this->image->tmp_name)) {

					echo json_encode(['status' => 'fail', 'message' => 'Unsupported image file']);
					exit;

				}
				elseif($this->image->size > self::MAX_UPLOAD_SIZE) {

					echo json_encode(['status' => 'fail', 'message' => (self::MAX_UPLOAD_SIZE / 1000000) . 'Mb allowed size exceeded']);
					exit;

				}
				else {
					echo json_encode(['status' => 'ok', 'message' => '']);
					exit;
				}
			}
		}
	}
}