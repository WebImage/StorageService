<?php

namespace WebImage\Storage\Services;

use WebImage\Storage\FileRepositoryInterface;
use WebImage\Storage\Refs\DirectoryReference;
use WebImage\Storage\Refs\FileReference;
use WebImage\Storage\Refs\PathReferenceInterface;
use WebImage\Storage\Repositories\InvalidRepositoryException;

class StorageService
{
	const SEPARATOR = '://';
	/**
	 * @var FileRepositoryInterface[]
	 */
	private $repos = [];

	public function addRepository(FileRepositoryInterface $repository)
	{
		$this->repos[$repository->getName()] = $repository;
	}

	/**
	 * Parse a file reference in the format of repo://path
	 * @param string $repoAndPath
	 * @return FileReference
	 */
	public function parseFileReference(string $repoAndPath): FileReference
	{
		list($repo, $path) = $this->parsePathReference($repoAndPath);
		return new FileReference($repo, $path);
	}

	/**
	 * Parse a directory reference in the format of repo://path
	 * @param string $repoAndPath
	 * @return DirectoryReference
	 */
	public function parseDirectoryReference(string $repoAndPath): DirectoryReference
	{
		list($repo, $path) = $this->parsePathReference($repoAndPath);
		return new DirectoryReference($repo, $path);
	}

	/**
	 * Parse a path reference in the format of repo://path
	 * @param string $repoAndPath
	 * @return array
	 */
	private function parsePathReference(string $repoAndPath): array
	{
		list($repoKey, $path) = array_pad(explode(PathReferenceInterface::SEPARATOR, $repoAndPath), 2, '');

		// If no path is provided, then the location is the repository key
		if (empty($path)) {
			$path    = $repoKey;
			$repoKey = null;
		}

		return [$repoKey, $path];
	}

	/**
	 * Create a file reference
	 * @param string $repoKey
	 * @param string $path
	 * @return FileReference
	 */
	public function createFileReference(string $repoKey, string $path): FileReference
	{
		if (!$this->hasRepository($repoKey)) {
			throw new InvalidRepositoryException('Invalid repository: ' . $repoKey);
		}

		return new FileReference($repoKey, $path);
	}

	/**
	 * Move a file from one repository to another.
	 * If the source and destination are in the same repository,
	 * then the repository's move method is used.  Otherwise,
	 * copy the file by their streams.
	 * @param FileReference $source
	 * @param FileReference $destination
	 * @return FileReference
	 */
	public function move(FileReference $source, FileReference $destination): FileReference
	{
		/**
		 * If the source and destination are in the same repository,
		 * then we can use the repository's move method.
		 */
		if ($source->getRepository() == $destination->getRepository()) {
			return $this->getRepository($source->getRepository())->move($source, $destination->getPath());
		}

		/**
		 * If the source and destination are in different repositories,
		 * then we need to copy the file and then delete the source.
		 */
		$sourceRepo = $this->getRepository($source->getRepository());
		$this->copy($source, $destination);

		// Delete source
		$sourceRepo->delete($source);

		return $destination;
	}

	/**
	 * Copy files via streams
	 * @param FileReference $source
	 * @param FileReference $destination
	 * @return FileReference
	 */
	public function copy(FileReference $source, FileReference $destination): FileReference
	{
		/**
		 * If the source and destination are in different repositories,
		 * then we need to copy the file and then delete the source.
		 */
		$sourceRepo        = $this->getRepository($source->getRepository());
		$sourceStream      = $sourceRepo->createReadStream($source);
		$destinationRepo   = $this->getRepository($destination->getRepository());
		$destinationStream = $destinationRepo->createWriteStream($destination);

		// Copy file via streams
		while (!$sourceStream->eof()) {
			$destinationStream->write($sourceStream->read(1024));
		}

		// Close streams
		$sourceStream->close();
		$destinationStream->close();

		// Delete source
		$sourceRepo->delete($source);

		return $destination;
	}

	public function getUrl(FileReference $file): ?string
	{
		if ($file->getRepository() === null) {
			return null;
		}

		return $this->getRepository($file->getRepository())->getUrl($file);
	}

	public function getRepository(string $repoKey): FileRepositoryInterface
	{
		if (!$this->hasRepository($repoKey)) {
			throw new InvalidRepositoryException('Missing storage repository: ' . $repoKey);
		}

		return $this->repos[$repoKey];
	}

	private function hasRepository(string $repoKey): bool
	{
		return array_key_exists($repoKey, $this->repos);
	}
}
