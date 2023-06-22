<?php

namespace WebImage\StorageService;

interface StorageProviderInterface {
    public function getName(): string;
    public function getFileSystemPath(StorageLocation $location): ?string;
    public function getURL(StorageLocation $location): ?string;

//    public function createFileReference(string $path): PathReferenceInterface;
//    public function createDirectoryReference(string $path): PathReferenceInterface;
}