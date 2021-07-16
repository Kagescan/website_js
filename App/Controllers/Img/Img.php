<?php
namespace App\Controllers\Img;

use App\Models\ImgModel;
use CodeIgniter\Controller;

class Img extends Controller
{
	private static string $IMAGE_FOLDER = WRITEPATH."images";
	private static string $SVG_MIME = 'image/svg+xml';
	private static array $ALLOWED_MIMES = ['image/png', 'image/jpeg', 'image/gif', 'image/svg+xml'];

	/**
	* Route : /img/
	*/
	public function index()
	{
		$this->error("Not implemented", "this feature is still not implemented.");
		echo view('templates/header', ["title"=>"Image upload"]);
		echo "tba";
		echo view('templates/footer', ["title"=>"name"]);
	}

	/**
	* Prints an error as svg image.
	*/
	public function error($title = "404 error", $description = "File not found.") {
		$data = ["title"=>$title, "description"=>$description];

		$this->response->setContentType(self::$SVG_MIME);
		//$this->response->setStatusCode(404);
		echo view("errors/svg", $data);
		$this->response->send();
		die();
	}

	/**
	 * Displays the image (or a special page)
	 * Route : /img/{name}
	 */
	public function view($name, $thumb=false) {
		$model = new ImgModel();
		$image = $model->getImage($name);
		if (empty($image)) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException("Cannot find in the database the following image: $name.");
		}
		// todo : (secutity) path traversal + correct filename
		$filename = self::$IMAGE_FOLDER;
		if ($thumb) $filename .= "thumb_";
		$filename .= $image["file_path"];
		if ( ! file_exists($filename)) {
			$this->error("Not found", "The image [$name] is registered in the database, but physically unavailable in the storage. This should not happen !");
			//throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		$mime = mime_content_type($filename); // todo (security) : should I trust this ?
		if (! in_array($mime, self::$ALLOWED_MIMES)) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException("This file type ($mime) is not allowed. This should not happen, this file might have been corrupted.");
		}
		header('Content-Length: '.filesize($filename));
		header("Content-Type: $mime");
		header('Content-Disposition: inline; filename="'.$filename.'";');
		readfile($filename); //<--reads and outputs the file onto the output buffer
		exit();
	}

	public function thumb($name) {
		return $this->view($name, true);
		// todo : better implementation
	}

	/**
	 * Upload page
	 * Route : /img/upload/
	 */
	public function upload() {
		$model = new ImgModel();

		if ($this->request->getMethod() !== 'post' || ! $this->validate([
				'image'  => 'uploaded[image]|max_size[image,2048]|mime_in[image,'.implode(",", self::$ALLOWED_MIMES).']',
				'name' => 'max_length[255]',
				'alt' => 'max_length[255]',
				'description' => 'max_length[65535]',
				'upload_comment' => 'max_length[255]'
			])
		)
		{
			echo view('templates/header', ['title' => 'Upload image']);
			echo view('img/upload');
			echo view('templates/footer');
			exit();
		}

		$file = $this->request->getFile('image');
		$newFileName = $file->getRandomName();

		$fullPath = $file->move(self::$IMAGE_FOLDER, $newFileName);

		\Config\Services::image()
			->withFile(self::$IMAGE_FOLDER."/".$newFileName)
			->fit(100, 100, 'top')
			->save(self::$IMAGE_FOLDER."/thumb_".$newFileName);
		$imageIdentifier = url_title($this->request->getPost('name') | $file->getName(), '-', TRUE);
		$model->save([
			'file_path' => $newFileName,
			'name'  => $imageIdentifier,
			'alt'  => $this->request->getPost('alt'),
			'description'  => $this->request->getPost('description'),
			'upload_comment'  => $this->request->getPost('upload_comment'),
		]);
		// todo (security) : is getName validated ?
		echo view('img/success', ["src"=>"view/$imageIdentifier"]);
	}

	public function all() {
		$model = new ImgModel();
		$data["images"] = $model->getImage();
		$data["title"] = "All uploaded medias";
		echo view('templates/header', $data);
		echo view('img/all', $data);
		echo view('templates/footer', $data);
	}
}
