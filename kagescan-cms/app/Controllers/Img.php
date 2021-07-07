<?php
namespace App\Controllers;

use App\Models\ImageModel;
use CodeIgniter\Controller;

class Img extends Controller
{
	private static string $IMAGE_FOLDER = WRITEPATH."images/";
	private static array $ALLOWED_MIMES = ['image/png', 'image/jpeg', 'image/gif', 'image/svg+xml'];

	/**
	* Route : /img/
	*/
	public function index()
	{
		// Pour le moment on reste sur l'affichage de toutes les images, mais ce comportement sera à modifier.

		$model = new ImageModel();
		$data["images"] = $model->getImage();
		$data["title"] = "Uploaded images";

		echo view('templates/header', $data);
		echo view('templates/img', $data);
		echo view('templates/footer', $data);
	}

	/**
	 * Displays the image (or a special page)
	 * Route : /img/{name}
	 */
	public function view($name) {
		$model = new ImageModel();
		$image = $model->getImage($name);
		if (empty($image)) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException("Cannot find in the database the following image: $name.");
		}
		// todo : (secutity) path traversal + correct filename
		$filename = self::$IMAGE_FOLDER . $image["file_path"];
		if ( ! file_exists($filename)) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException("The image [$name] is registered in the database, but physically unavailable in the storage. This should not happen !");
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

	/**
	 * Upload page
	 * Route : /img/upload/
	 */
	public function upload() {
		// todo
	}

}
