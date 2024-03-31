<?php

namespace WebImage\Storage\Refs;

use WebImage\Storage\FileRepositoryInterface;
use WebImage\Storage\Utils\PathUtil;

abstract class AbstractPathReference implements PathReferenceInterface
{
	private ?string $repository;
	private string                   $path;

	public function __construct(?string $repository, string $path)
	{
		$this->repository = $repository;
		$this->path       = PathUtil::normalizePath($path);
	}

//	public function getRepository(): ?FileRepositoryInterface
	public function getRepository(): ?string
	{
		return $this->repository;
	}

	public function getPath(): string
	{
		return $this->path;
	}

//	/**
//	 * Get a public URL for the file
//	 * @return string|null
//	 */
//	public function getUrl(): ?string
//	{
//		return $this->getRepository()->getUrl($this);
//	}
	public function toString(): string
	{
		if ($this->getRepository() === null) {
			return $this->getPath();
		}

		return sprintf('%s%s%s',
//					   $this->getRepository()->getName(),
					   $this->getRepository(),
					   PathReferenceInterface::SEPARATOR,
					   $this->getPath());
	}
}
