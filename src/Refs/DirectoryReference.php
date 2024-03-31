<?php

namespace WebImage\Storage\Refs;

use WebImage\Storage\Utils\PathUtil;

class DirectoryReference extends AbstractPathReference
{
//	public function getFiles(string $directory = ''): array
//	{
//		return $this->getRepository()->getFiles($this->appendedPath($directory));
//	}

//	public function getDirectories(string $directory = ''): array
//	{
//		return $this->getRepository()->getDirectories($this->appendedPath($directory));
//	}

//	public function delete(): void
//	{
//		$this->getRepository()->delete($this);
//	}
//
//	public function exists(): bool
//	{
//		return $this->getRepository()->exists($this);
//	}

//	public function createDirectory(string $path): DirectoryReference
//	{
//		$ref = new DirectoryReference($this->getRepository(), $this->appendedPath($path));
//		return $this->getRepository()->createDirectory($ref);
//	}
//
//	public function createFileReference(string $path): FileReference
//	{
//		return $this->getRepository()->createFileReference($this->appendedPath($path));
//	}

	private function appendedPath(string $path): string
	{
		$result = $this->getPath() . PathUtil::normalizePath($path);
		$result = ltrim($result, '/');

		return $result;
	}
//
//	public function create(): DirectoryReference
//	{
//		return $this->getRepository()->createDirectory($this);
//	}
//
//	public function getUrl(): ?string
//	{
//		return $this->getRepository()->getUrl($this);
//	}
}
