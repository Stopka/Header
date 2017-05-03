<?php

namespace Stopka\Assetor\Collector;

use Nette\Object;
use Stopka\Assetor\Asset\BaseAsset;

/**
 * Class of Packages for AssetsCollector.
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class AssetCollectionGroup extends Object {

    /** @var AssetCollection[] attached collections */
    protected $collections = array();

    /**
     * AssetCollectionGroup constructor.
     * @param string[] $groupNames
     */
    function __construct(array $groupNames) {
        foreach ($groupNames as $groupName) {
            $this->addCollection($groupName);
        }
    }

    /**
     * @return string[]
     */
    public function getCollectionNames() {
        return array_keys($this->collections);
    }

    /**
     * @param string $name
     * @return self
     */
    public function addCollection(string $name): self {
        $this->collections[$name] = new AssetCollection();
        return $this;
    }

    /**
     * @param string $name
     * @return AssetCollection
     */
    protected function getCollection(string $name): AssetCollection {
        return $this->collections[$name];
    }

    /**
     * @param string $groupName
     * @param string $file
     * @return self
     */
    public function addFile(string $groupName, string $file): self {
        $this->getCollection($groupName)->addFile($file);
        return $this;
    }

    /**
     * @param string $groupName
     * @param string $content
     * @return self
     */
    public function addContent(string $groupName, string $content): self {
        $this->getCollection($groupName)->addContent($content);
        return $this;
    }

    /**
     * @param string $groupName
     * @return BaseAsset[]
     */
    public function getAssets(string $groupName): array {
        return $this->getCollection($groupName)->getAssets();
    }
}