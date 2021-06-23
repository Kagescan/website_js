<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class About extends Controller
{
	/**
	* @Route("/about/", name="about_nothing")
	*/
	public function index()
	{
		return view('welcome_message');
	}

	/**
	* @Route("/about/view/{page}", name="aboutPages")
	*/
	public function view($page = "home") {
		if ( ! is_file(APPPATH.'/Views/staticPages/'.$page.'.php')){
			// vulnerable to path traversal ?
			throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		}

		$data['title'] = ucfirst($page); // Capitalize the first letter

		echo view('templates/header', $data);
		echo view('staticPages/'.$page, $data);
		echo view('templates/footer', $data);
	}
}
