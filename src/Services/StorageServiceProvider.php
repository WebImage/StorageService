<?php

namespace WebImage\Storage\Services;

use WebImage\Config\Config;
use WebImage\Container\ServiceProvider\AbstractServiceProvider;
use WebImage\Storage\FileRepositoryInterface;

class StorageServiceProvider extends AbstractServiceProvider
{
	protected $provides = [
		StorageService::class
	];

	public function register(): void
	{
		$this->getContainer()->addShared(StorageService::class, function () {
			$service = new StorageService();
			$repos = $this->getApplicationConfig()->get('webimage/storage.repositories');

			/** @var Config $factoryConfig */
			foreach($repos as $name => $factoryConfig) {
				if (!$factoryConfig->get('name')) $factoryConfig->set('name', $name);
				$class = $factoryConfig->get('class');
				if (empty($class)) throw new \RuntimeException('Storage repository ' . $name . ' is missing a class');

				if ($this->getContainer()->has($class)) {
					$service->addRepository($this->getContainer()->get($class));
				} else if (!is_a($class, RepositoryFactoryInterface::class, true)) {
					throw new \RuntimeException('Storage provider ' . $name . ' class ' . $class . ' does not implement ' . RepositoryFactoryInterface::class);
				} else {
					$repo = call_user_func(sprintf('%s::%s', $class, 'createRepository'), $factoryConfig);
					if (!($repo instanceof FileRepositoryInterface)) {
						throw new \RuntimeException('Storage provider ' . $name . ' class ' . $class . ' does not implement ' . FileRepositoryInterface::class);
					}
					$service->addRepository($repo);
				}
			}

			return $service;
		});
	}
}
