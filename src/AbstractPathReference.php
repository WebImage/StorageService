<?php

namespace WebImage\StorageService;

abstract class AbstractPathReference implements PathReferenceInterface
{
    protected StorageService $storageService;
    protected StorageLocation $location;

    /**
     * @param StorageService $storageService
     */
    public function __construct(StorageService $storageService, StorageLocation $location)
    {
        $this->storageService = $storageService;
        $this->location = $location;
    }

    public function getStorageService(): StorageService
    {
        return $this->storageService;
    }
}