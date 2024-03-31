<?php

namespace WebImage\Storage;

use Psr\Http\Message\StreamInterface;
use WebImage\Storage\Refs\DirectoryReference;
use WebImage\Storage\Refs\FileReference;
use WebImage\Storage\Refs\PathReferenceInterface;

interface FileRepositoryInterface
{
	public function getName(): string;

	public function getRoot(): DirectoryReference;

	/** @var FileReference[] */
	public function getFiles(string $path = ''): array;

	/** @return DirectoryReference[] */
	public function getDirectories(string $path = ''): array;

	public function createDirectoryReference(string $path): DirectoryReference;

	public function createReadStream(FileReference $file): StreamInterface;

	public function createWriteStream(FileReference $file): StreamInterface;

	public function exists(PathReferenceInterface $file): bool;

	public function move(FileReference $source, string $path): FileReference;

	public function fileExists(string $path): bool;

	public function directoryExists(string $path): bool;

	public function createDirectoryFromPath(string $path): DirectoryReference;

	public function createDirectory(DirectoryReference $directory): DirectoryReference;

	public function createFileReference(string $path): FileReference;

	public function delete(PathReferenceInterface $pathRef): void;

	public function getFileSize(FileReference $file): int;

	public function getLastModified(FileReference $file): \DateTime;

	public function getUrl(PathReferenceInterface $ref): ?string;
}
