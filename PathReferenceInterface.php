<?php

namespace WebImage\StorageService;

interface PathReferenceInterface
{
    public function getStorageService(): StorageService;
    public function exists(): bool;

    public function isDirectory(): bool;
    public function isFile(): bool;
    public function isSymLink(): bool;
}