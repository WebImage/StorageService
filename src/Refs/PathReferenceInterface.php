<?php

namespace WebImage\Storage\Refs;

use WebImage\Storage\FileRepositoryInterface;

interface PathReferenceInterface
{
	const SEPARATOR = '://';
//	public function getRepository(): ?FileRepositoryInterface;
	public function getRepository(): ?string;
	public function getPath(): string;
//	public function delete(): void;
//	public function exists(): bool;

	public function toString(): string;

//	public function getUrl(): ?string;
}
