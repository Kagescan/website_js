<?php
/**
 * Kagescan image module - A standalone image uploader and viewer for your CodeIgniter website.
 * @author LoganTann
 */

namespace App\Controllers\Img;

use App\Models\ImgModel;
use CodeIgniter\Controller;

class Img extends Controller
{
	private static string $IMAGE_FOLDER = WRITEPATH."images";
	private static string $TRASH_FOLDER = WRITEPATH."trash";
	private static string $SVG_MIME = 'image/svg+xml';
	private static array $ALLOWED_MIMES = ["png" =>'image/png', "jpeg" => 'image/jpeg', "gif" => 'image/gif', "webp" => 'image/webp', "svg" => 'image/svg+xml'];
	private static string $HOME_URL = "/Img/Img/";

	private $parser;
	public function __construct()
	{
		$this->parser = \Config\Services::parser();
	}


	// -- general pages

	/**
	 * Actually, holds every supported routes. All responses are in HTML (or raw images).
	 * @Route : Img/
	 */
	public function index()
	{
		$lf = "<br> - ";
		$this->render("Image upload - API ref",
			"Supported URLs : <br> - ".
			anchor(self::$HOME_URL.'all', 'All images (+ delete)').$lf.
			anchor(self::$HOME_URL.'upload', 'upload')." - & ".anchor(self::$HOME_URL.'success', 'success').$lf.
			anchor(self::$HOME_URL.'error', 'test default svg error').$lf.
			anchor(self::$HOME_URL.'view/redbeansoup', 'View image redbeansoup')." + ".
			anchor(self::$HOME_URL.'thumb/redbeansoup', 'Thumb').$lf.
			"maybe in the future : image renaming<br>"
		);
	}

	/**
	 * Shows the "upload success" page. Requires a valid image identifier.
	 * @Route Img/success(/{imageIdentifier})
	 * @Param string $imageIdentifier the stored image identifier
	 */
	public function success($imageIdentifier = ">") {
		$title = ($imageIdentifier === ">") ? 'No upload ??' : 'Upload Complete';
		$this->render($title,
			$this->parser
				->setData(["src"=>"$imageIdentifier", "backURL" => self::$HOME_URL])
				->render('img/success')
		);
	}

	/**
	 * Shows all stored images.
	 * @Route Img/all
	 */
	public function all($successMsg = "none") {
		switch ($successMsg) {
			case "deleteSuccess":
				$data["successMsg"] = "Image deleted successfully";
				break;
			default:
				break;
		}
		$model = new ImgModel();
		$data["images"] = $model->getImage();
		$data["title"] = "All uploaded medias";
		$data["backURL"] = self::$HOME_URL;
		$this->render("All uploaded medias",
			view('img/all', $data)
		);
	}

	/**
	 * Prints an error as svg image. Params are self explanatory.
	 * @Route Img/error(/{text})(/{code})(/{title})
	 */
	public function error($text = "File not found.", $error="404", $title = "Not found") {
		$data = ["error"=>$error, "title"=>$title, "text"=>$text];

		$this->response->setContentType(self::$SVG_MIME);
		//$this->response->setStatusCode(404); <<< Browsers won't show if the status is 404
		echo view("img/error", $data);
		$this->response->send();
		die();
	}

	/**
	 * Moves an image to the trash.
	 * @Route Img/delete/{name}
	 * @param string $name The image identifier
	 */
	public function delete($name = '>') {
		$model = new ImgModel();
		$image = $model->getImage($name);
		$imageDontExists = empty($image);
		if ($this->request->getMethod() !== 'post' || ! $this->validate(["confirm"=>"max_length[255]"]) || $imageDontExists)
		{
			$this->render("Confirm delete",
				$this->parser
					->setData(["src"=>$name, "backURL" => self::$HOME_URL, "imageDontExists" =>$imageDontExists])
					->render('img/confirmDelete')
			);
			exit();
		}
		$this->moveImageToTrash($image["file_path"]);
		$model->deleteImage($name);
		$this->response->redirect("../all/deleteSuccess", 'auto', 303);
	}

	// ---- Image display methods

	/**
	 * Displays the image (or a special page in the future)
	 * @Route Img/view/{name}
	 * @param $name String The image identifier
	 * @see $this->view_private
	 */
	public function view($name = '>') {
		if ($name === '>') {
			$this->error("ArgumentCountError : Please provide a valid image identifier \n(ie. expecting [Img/view/{imageId}] )", "400", "Bad Request");
		}
		$this->view_private($name, false);
	}
	/**
	 * Same as view but display it's stored thumbnail.
	 * @Route Img/thumb/{name}
	 * @param $name String The image identifier
	 * @see $this->view_private
	 */
	public function thumb($name = '>') {
		if ($name === '>') {
			$this->error("ArgumentCountError : Please provide a valid image identifier \n(ie. expecting [Img/thumb/{imageId}] )", "400", "Bad Request");
		}
		$this->view_private($name, true);
	}
	/**
	 * The code for both Img/view/ and Img/thumb/. Defined as private so the last argument is not registered in auto-routing.
	 * @param $name String The image identifier
	 * @param $thumb Bool if true, outputs the image's stored thumbnail instead of the original file.
	 */
	private function view_private($name, $thumb) {
		$model = new ImgModel();
		$image = $model->getImage($name);
		if (empty($image)) {
			$this->error("Cannot find in the database the following image: $name.");
		}

		// todo : (secutity) path traversal + correct filename ?
		$filename = self::$IMAGE_FOLDER.DIRECTORY_SEPARATOR;
		if ($thumb)  {
			$filename .= "thumb_";
		}
		$filename .= $image["file_path"];
		if ( ! file_exists($filename)) {
			$this->error("The image [$name] is registered in the database, but physically unavailable in the storage ($filename). This should not happen !");
		}

		$mime = mime_content_type($filename);
		if (! in_array($mime, self::$ALLOWED_MIMES)) {
			$this->error("This file type ($mime) is not allowed. This should not happen, this file might have been corrupted.", "403", "Image not allowed");
		}
		header('Content-Length: '.filesize($filename));
		header("Content-Type: $mime");
		header('Content-Disposition: inline; filename="'.$image["file_path"].'";');
		readfile($filename); //<--reads and outputs the file onto the output buffer
		exit();
	}


	// ---- Image Uploading methods

	/**
	* Upload page
	* @Route : Img/upload
	* @Todo : better error handling
	*/
	public function upload() {
		$model = new ImgModel();

		if ($this->request->getMethod() !== 'post' || ! $this->validate([
			'image'  => 'uploaded[image]|max_size[image,2048]|mime_in[image,'.implode(",", self::$ALLOWED_MIMES).']',
			'name' => 'max_length[255]', //todo : invalid name handling
			'alt' => 'max_length[255]',
			'description' => 'max_length[65535]',
			'upload_comment' => 'max_length[255]'
		])
		)
		{
			$this->render("Upload Image", view('img/upload', ["backURL" => self::$HOME_URL]));
			exit();
		}

		$file = $this->request->getFile('image');
		$userFilename = $this->request->getPost('name');
		$userFilename = url_title((empty($userFilename)) ? $file->getName() : $userFilename);
		$serverFileName = $file->getRandomName();

		$this->createFolderIfDontExist(self::$IMAGE_FOLDER);
		$file->move(self::$IMAGE_FOLDER, $serverFileName);

		\Config\Services::image()
		->withFile(self::$IMAGE_FOLDER.DIRECTORY_SEPARATOR.$serverFileName)
		->resize(250, 150, true)
		->save(self::$IMAGE_FOLDER."/thumb_".$serverFileName);

		$model->save([
			'file_path' => $serverFileName,
			'name'  => $userFilename,
			'alt'  => $this->request->getPost('alt'),
			'description'  => $this->request->getPost('description'),
			'upload_comment'  => $this->request->getPost('upload_comment'),
		]);

		$this->response->redirect("success/$userFilename", 'auto', 303);
	}


	// --- helpers

	/**
	 * Renders the header and the footer, then inserts the HTML provided in the second argument and output all.
	 * @param string $title The title of the page
	 * @param string $injectedHTML The HTML to be injected between the header and the footer
	 */
	private function render($title = "kagescan", $injectedHTML = "") {
		echo $this->parser->setData(["title"=>$title])->render('templates/header');
		echo $injectedHTML;
		echo $this->parser->setData(["title"=>$title])->render('templates/footer');
	}

	/**
	 * Self explanatory. If the folder provided don't exist, creates it with ugo=rwx permissions.
	 * @param $folder String the absolute folder path
	 */
	private function createFolderIfDontExist($folder) {
		if(!is_dir($folder) )
		{
			mkdir($folder,0777,TRUE);
		}
	}

	/**
	 * Given the image file path, moves it to the trash folder.
	 * @param $filePath String the absolute file path
	 */
	private function moveImageToTrash($filePath) {
		$prefix = self::$IMAGE_FOLDER.DIRECTORY_SEPARATOR;
		$thumbInstance = new \CodeIgniter\Files\File($prefix.'thumb_'.$filePath);
		$imageInstance = new \CodeIgniter\Files\File($prefix.$filePath);

		$trashPrefix = self::$TRASH_FOLDER.DIRECTORY_SEPARATOR;
		$this->createFolderIfDontExist(self::$TRASH_FOLDER);
		$thumbInstance->move($trashPrefix);
		$imageInstance->move($trashPrefix);
	}
}
