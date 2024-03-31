<?php

namespace WebImage\Storage\Refs;

use DateTime;
use Psr\Http\Message\StreamInterface;

class FileReference extends AbstractPathReference
{
//	public function delete(): void
//	{
//		$this->getRepository()->delete($this);
//	}

	public function getDirectory(): DirectoryReference
	{
		throw new \Exception('Not implemented');
	}

//	public function createReadStream(): StreamInterface
//	{
//		return $this->getRepository()->createReadStream($this);
//	}
//
//	public function createWriteStream(): StreamInterface
//	{
//		return $this->getRepository()->createWriteStream($this);
//	}
//
//	public function exists(): bool
//	{
//		return $this->getRepository()->exists($this);
//	}
//
//	public function getSize(): int
//	{
//		return $this->getRepository()->getFileSize($this);
//	}
//
//	public function getModified(): DateTime
//	{
//		return $this->getRepository()->getLastModified($this);
//	}
//
//	public function getUrl(): ?string
//	{
//		return $this->getRepository() === null ? null : $this->getRepository()->getUrl($this);
//	}
}
