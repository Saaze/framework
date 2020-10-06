<?php

namespace Saaze\Collections;

use Saaze\Interfaces\CollectionInterface;
use Saaze\Interfaces\CollectionParserInterface;
use Symfony\Component\Finder\Finder;

class Collection implements CollectionInterface
{
    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $entries;

    /**
     * @param string $filePath
     */
    public function __construct($filePath, CollectionParserInterface $collectionParser)
    {
        $this->filePath = $filePath;

        $this->data = $collectionParser->parseCollection($this->filePath);
    }

    /**
     * @return string
     */
    public function filePath()
    {
        return $this->filePath;
    }

    /**
     * @return array
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function slug()
    {
        return basename($this->filePath, '.yml');
    }

    /**
     * @return string|null
     */
    public function indexRoute()
    {
        return $this->data['index_route'] ?? null;
    }

    /**
     * @return string|null
     */
    public function entryRoute()
    {
        return $this->data['entry_route'] ?? null;
    }

    /**
     * @return bool
     */
    public function indexIsEntry()
    {
        return (bool) (new Finder())
            ->in(content_path() . '/' . $this->slug())
            ->files()
            ->name('index.md')
            ->count();
    }
}
