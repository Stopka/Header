<?php

namespace Stopka\Assetor\Collector;

use Nette\Object;

/**
 * Creates asset collection from config array
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class AssetCollectionFactory extends Object {

    /**
     * @param array $config
     * @return AssetCollection
     */
    public function create(array $config): AssetCollection{
        $collection = new AssetCollection();
        return $collection;
    }
}