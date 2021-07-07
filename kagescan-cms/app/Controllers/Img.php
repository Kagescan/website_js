<?php
namespace App\Controllers;

use App\Models\ImageModel;
use CodeIgniter\Controller;

class Img extends Controller
{
	/**
	* @Route("/img/", name="")
	*/
	public function index()
	{
		$model = new ArticleModel();
		$data["news"] = $model->getArticles();
		$data["title"] = "Article list";

		echo view('templates/header', $data);
		echo view('templates/article', $data);
		echo view('templates/footer', $data);
	}

	public function send() {

	}

	/**
	* @Route("/blog/{page}", name="")
	*/
	public function view($slug = null) {
		$model = new ArticleModel();
		$data["news"] = $model->getArticles($slug);
    if (empty($data['news']))
    {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: '. $slug);
    }
    $data['title'] = $data['news']['title'];
		echo view('templates/header', $data);
		echo view('templates/article', $data);
		echo view('templates/footer', $data);
	}
}
