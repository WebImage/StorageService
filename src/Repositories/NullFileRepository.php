<?php
/**
 * Serves as a placeholder for files that do not have a repository
 */
namespace WebImage\Storage\Repositories;

use Psr\Http\Message\StreamInterface;
use WebImage\Storage\FileRepositoryInterface;
use WebImage\Storage\Refs\DirectoryReference;
use WebImage\Storage\Refs\FileReference;
use WebImage\Storage\Refs\PathReferenceInterface;

class NullFileRepository implements FileRepositoryInterface
{
	public function getName(): string
	{
		return '';
	}

	public function getUrl(PathReferenceInterface $ref): ?string
	{
		return $ref->getPath();
	}

	public function move(FileReference $source, string $path): FileReference
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function getRoot(): DirectoryReference
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function getFiles(string $path = ''): array
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function getDirectories(string $path = ''): array
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function createDirectoryReference(string $path): DirectoryReference
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function createReadStream(FileReference $file): StreamInterface
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function createWriteStream(FileReference $file): StreamInterface
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function exists(PathReferenceInterface $file): bool
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function fileExists(string $path): bool
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function directoryExists(string $path): bool
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function createDirectoryFromPath(string $path): DirectoryReference
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function createDirectory(DirectoryReference $directory): DirectoryReference
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function createFileReference(string $path): FileReference
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function delete(PathReferenceInterface $pathRef): void
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function getFileSize(FileReference $file): int
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}

	public function getLastModified(FileReference $file): \DateTime
	{
		throw NotImplementedException::unsupportedMethod(__METHOD__);
	}
}
