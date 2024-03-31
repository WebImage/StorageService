<?php

namespace WebImage\Storage\Utils;

class PathUtil
{
	/**
	 * Always use forward slashes to reference paths.  Local repositories can convert the character back to backslash, as necessary
	 * @param string $path
	 * @return string
	 */
	public static function normalizePath(string $path): string
	{
		$path = str_replace('\\', '/', $path); // Use forward slashes
		return rtrim($path, '/'); // Ensure no trailing slash
	}
}
