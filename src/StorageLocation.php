<?php

namespace WebImage\StorageService;

class StorageLocation
{
    const SEPARATOR = '://';
    private StorageProviderInterface $provider;
    private string $path;

    /**
     * @param StorageProviderInterface $provider
     * @param string $path
     */
    public function __construct(StorageProviderInterface $provider, string $path)
    {
        $this->provider = $provider;
        $this->path     = $path;
    }

    public function getFilePath(): ?string
    {
        return $this->provider->getFileSystemPath($this);
    }

    public function getUrl(): ?string
    {
        return $this->provider->getURL($this);
    }
    /**
     * @return string
     */
    public function getProvider(): StorageProviderInterface
    {
        return $this->provider;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    public function __toString()
    {
        return sprintf('%s%s%s', $this->provider->getName(), self::SEPARATOR, $this->path);
    }
}