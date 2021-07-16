<?php

namespace App\Controllers\Img;

use CodeIgniter\Exceptions\ExceptionInterface;
use RuntimeException;

class ImageException extends RuntimeException implements ExceptionInterface
{
	protected $log = false;
	protected $code = 404;

	public static function forPageNotFound(string $message = null)
	{
		return view("img/404");
		//return new static($message ?? lang('HTTP.pageNotFound'));
	}
}
