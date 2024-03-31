<?php

namespace WebImage\Storage\Repositories;

use DateTime;
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\StreamInterface;
use WebImage\Storage\Refs\DirectoryReference;
use WebImage\Storage\Refs\FileReference;
use WebImage\Storage\Refs\PathReferenceInterface;
use WebImage\Storage\Utils\PathUtil;

class LocalDirectoryRepository extends AbstractDirectoryFileRepository
{
	public function getFiles(string $path = ''): array
	{
		$fileRefs = [];
		$files = glob($this->getFullPath($path) . '/*');

		foreach ($files as $file) {
			if (is_file($file)) {
				$fileRefs[] = new FileReference($this, $this->mockRoot($file));
			}
		}

		return $fileRefs;
	}

	public function getDirectories(string $path = ''): array
	{
		$directoryRefs = [];
		$dirs = glob($this->getFullPath($path) . '/*', GLOB_ONLYDIR);

		foreach ($dirs as $dir) {
			$directoryRefs[] = new DirectoryReference($this, $this->mockRoot($dir));
		}

		return $directoryRefs;
	}

	public function createReadStream(FileReference $file): StreamInterface
	{
		return new Stream(fopen($this->getFullPath($file->getPath()), 'r'));
	}

	public function createWriteStream(FileReference $file): StreamInterface
	{
		$this->ensureFileReferenceDirectoryExists($file);
		return new Stream(fopen($this->getFullPath($file->getPath()), 'w'));
	}

	public function exists(PathReferenceInterface $path): bool
	{
		if ($path instanceof DirectoryReference) {
			return $this->directoryExists($path->getPath());
		} else {
			return $this->fileExists($path->getPath());
		}
	}

	public function directoryExists(string $path): bool
	{
		return is_dir($this->getFullPath($path));
	}

	public function createDirectory(DirectoryReference $directory): DirectoryReference
	{
		mkdir($this->getFullPath($directory->getPath()), 0777, true);
		return $directory;
	}

	public function fileExists(string $path): bool
	{
		return file_exists($this->getFullPath($path));
	}

	public function delete(PathReferenceInterface $pathRef): void
	{
		unlink($this->getFullPath($pathRef->getPath()));
	}

	public function move(FileReference $source, string $path): FileReference
	{
		if (!rename($this->getFullPath($source->getPath()), $this->getFullPath($path))) {
			throw new \RuntimeException('Unable to move file ' . $source->getPath() . ' to ' . $path);
		}

		return new FileReference($this, $path);
	}

	protected function getFullPath(string $path): string
	{
		return $this->getRoot()->getPath() . $this->normalizePath($path);
	}

	public function getFileSize(FileReference $file): int
	{
		return filesize($this->getFullPath($file->getPath()));
	}

	public function getLastModified(FileReference $file): DateTime
	{
		return new DateTime('@' . filemtime($this->getFullPath($file->getPath())));
	}

	public function normalizePath(string $path): string
	{
		$path = PathUtil::normalizePath($path);
		$path = str_replace('/', DIRECTORY_SEPARATOR, $path);

		return $path;
	}

	private function mockRoot(string $path): string
	{
		if (substr($path, 0, strlen($this->getRoot()->getPath())) == $this->getRoot()->getPath()) {
			$path = substr($path, strlen($this->getRoot()->getPath()));
		}

		return $path;
	}
}
