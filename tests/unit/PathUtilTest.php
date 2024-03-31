<?php

use PHPUnit\Framework\TestCase;
use WebImage\Storage\Utils\PathUtil;

class PathUtilTest extends TestCase
{
	public function testPathNormalization()
	{
		$path = '/path/withtrailingslash/';
		$expected = '/path/withtrailingslash';
		$this->assertEquals($expected, PathUtil::normalizePath($path), 'Trailing slashes should be removed');
	}

	public function testWindowsPathNormalization()
	{
		$path = 'C:\\Users\\user';
		$expected = 'C:/Users/user';
		$this->assertEquals($expected, PathUtil::normalizePath($path), 'Windows paths should be normalized to use forward slashes');
	}
}
