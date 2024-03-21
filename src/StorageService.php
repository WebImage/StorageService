<?php

namespace WebImage\StorageService;

class StorageService
{
    private $providers = [];

    public function addProvider(StorageProviderInterface $provider)
    {
        $this->providers[$provider->getName()] = $provider;
    }

    public function parseLocation(string $location): StorageLocation
    {
        list($provider, $path) = array_pad(explode(StorageLocation::SEPARATOR, $location), 2, '');

        if (empty($path)) {
            $path = $provider;
            $provider = '';
        }

        return new StorageLocation($this->getProvider($provider), $path);
    }

    public function createLocation(string $provider, string $path=''): StorageLocation
    {
        return new StorageLocation($this->getProvider($provider), $path);
    }

    public function getProvider(string $providerKey): StorageProviderInterface
    {
        if (!$this->hasProvider($providerKey)) {
            throw new \InvalidArgumentException('Missing storage provider: ' . $providerKey);
        }

        return $this->providers[$providerKey];
    }

    public function hasProvider(string $providerKey)
    {
        return array_key_exists($providerKey, $this->providers);
    }
}
