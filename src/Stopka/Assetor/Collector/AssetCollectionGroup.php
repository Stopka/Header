<?php

namespace Stopka\Assetor\Collector;

use Nette\Object;

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

    protected function getCollection(string $name): AssetCollection {
        return $this->collections[$name];
    }

    public function addFile($groupName, $file) {
        $this->getCollection($groupName)->addFile($file);
    }
}