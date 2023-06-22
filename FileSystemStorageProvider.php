<?php

namespace WebImage\StorageService;

class FileSystemStorageProvider implements StorageProviderInterface
{
    private string $name = '';
    private string $fileSystemBase = '';
    private ?string $urlBase = '';

    public function __construct(string $name, string $fileSystemBase = null, string $urlBase = null)
    {
        $this->name           = $name;
        $this->fileSystemBase = $fileSystemBase;
        $this->urlBase        = $urlBase;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFileSystemPath(StorageLocation $location): ?string
    {
        if (empty($this->fileSystemBase)) return null;

        return $this->fileSystemBase . $location->getPath();
    }

    public function getURL(StorageLocation $location): ?string
    {
        if (empty($this->urlBase)) return null;

        return $this->urlBase . $location->getPath();
    }
}