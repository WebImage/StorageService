<?php

namespace WebImage\Storage\Services;

use WebImage\Config\Config;
use WebImage\Storage\FileRepositoryInterface;

interface RepositoryFactoryInterface
{
	public function createRepository(Config $config): FileRepositoryInterface;
}
