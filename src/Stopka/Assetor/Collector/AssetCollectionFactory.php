<?php

namespace Stopka\Assetor\Collector;

use Nette\SmartObject;

/**
 * Creates asset collection from config array
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class AssetCollectionFactory {
    use SmartObject;

    /**
     * @param array $config
     * @return AssetCollection
     */
    public function create(array $config): AssetCollection{
        /** @noinspection PhpExpressionResultUnusedInspection */
        $config;
        $collection = new AssetCollection();
        return $collection;
    }
}