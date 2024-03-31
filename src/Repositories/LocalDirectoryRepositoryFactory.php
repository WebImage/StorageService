<?php

namespace WebImage\Storage\Repositories;

use WebImage\Config\Config;
use WebImage\Storage\FileRepositoryInterface;
use WebImage\Storage\Services\RepositoryFactoryInterface;

class LocalDirectoryRepositoryFactory implements RepositoryFactoryInterface
{
	public function createRepository(Config $config): FileRepositoryInterface
	{
		$name    = $config['name'];
		$path    = $config['path'];
		$urlBase = $config['url'];

		return new LocalDirectoryRepository($name, $path, $urlBase);
	}
}
