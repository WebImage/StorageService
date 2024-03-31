<?php

namespace WebImage\Storage\Repositories;

class NotImplementedException extends \RuntimeException
{
	public static function unsupportedMethod(string $method)
	{
		return new static('Method ' . $method . ' is not supported');
	}
}
