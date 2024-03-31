<?php

namespace WebImage\Storage\Repositories;

use DateTime;
use Psr\Http\Message\StreamInterface;
use WebImage\Storage\FileRepositoryInterface;
use WebImage\Storage\Refs\DirectoryReference;
use WebImage\Storage\Refs\FileReference;
use WebImage\Storage\Refs\PathReferenceInterface;
use WebImage\Storage\Utils\PathUtil;

abstract class AbstractDirectoryFileRepository implements FileRepositoryInterface
{
	private string             $name;
	private DirectoryReference $rootDirectory;
	private ?string            $urlBase;

	public function __construct(string $name, string $rootDirectory, ?string $urlBase = null)
	{
		$this->name          = $name;
		$this->rootDirectory = $this->createDirectoryReference($rootDirectory);
		$this->urlBase       = $urlBase ? PathUtil::normalizePath($urlBase) : null;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getRoot(): DirectoryReference
	{
		return $this->rootDirectory;
	}

	public function createFileReference(string $path): FileReference
	{
		return new FileReference($this->getName(), PathUtil::normalizePath($path));
	}

	public function createDirectoryFromPath(string $path): DirectoryReference
	{
		return $this->createDirectory($this->createDirectoryReference($path));
	}

	public function createDirectoryReference(string $path): DirectoryReference
	{
		return new DirectoryReference($this->getName(), PathUtil::normalizePath($path));
	}

	protected function ensureFileReferenceDirectoryExists(FileReference $file): void
	{
		$parts = explode('/', $file->getPath());
		if (count($parts) > 0 && strlen($parts[0]) == 0) {
			array_shift($parts);
		}
		array_pop($parts);
		$path = "";

		foreach ($parts as $part) {
			$path .= "/" . $part;
			if (!$this->directoryExists($path)) {
				$this->createDirectory($this->createDirectoryReference($path));
			}
		}
	}

	public function getUrlBase(): ?string
	{
		return $this->urlBase;
	}

	public function getUrl(PathReferenceInterface $ref): ?string
	{
		if ($this->getUrlBase() === null) {
			return null;
		}

		return $this->getUrlBase() . $ref->getPath();
	}

	abstract public function createReadStream(FileReference $file): StreamInterface;

	abstract public function createWriteStream(FileReference $file): StreamInterface;

	abstract public function delete(PathReferenceInterface $pathRef): void;

	abstract public function directoryExists(string $path): bool;

	abstract public function exists(PathReferenceInterface $file): bool;

	abstract public function fileExists(string $path): bool;

	abstract public function getDirectories(string $path = ''): array;

	abstract public function createDirectory(DirectoryReference $directory): DirectoryReference;

	abstract public function getFiles(string $path = ''): array;

	abstract public function getFileSize(FileReference $file): int;

	abstract public function getLastModified(FileReference $file): DateTime;
}
