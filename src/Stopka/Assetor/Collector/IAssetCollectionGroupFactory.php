<?php

namespace Stopka\Assetor\Collector;


/**
 * @author Štěpán Škorpil
 * @license MIT
 */
interface IAssetCollectionGroupFactory {

    /**
     * @param array $assets
     * @return AssetCollectionGroup
     */
    public function create(array $assets): AssetCollectionGroup;

    /**
     * @param AssetCollectionGroup $group
     * @param array $assets
     * @return AssetCollectionGroup
     */
    public function addAssets(AssetCollectionGroup $group,array $assets): AssetCollectionGroup;
}