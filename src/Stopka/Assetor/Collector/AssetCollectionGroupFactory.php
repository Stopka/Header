<?php

namespace Stopka\Assetor\Collector;

use Nette\Object;

/**
 * Class of Packages for AssetsCollector.
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class AssetCollectionGroupFactory extends Object implements IAssetCollectionGroupFactory {

    protected $groupNames;

    /**
     * AssetCollectionGroup constructor.
     * @param string[] $groupNames
     */
    public function __construct(array $groupNames) {
        $this->groupNames = $groupNames;
    }

    /**
     * @param array $assets
     * @return AssetCollectionGroup
     */
    public function create(array $assets): AssetCollectionGroup{
        $group = new AssetCollectionGroup($this->groupNames);
        return $this->addAssets($group, $assets);
    }

    /**
     * @param AssetCollectionGroup $group
     * @param array $assets
     * @return AssetCollectionGroup
     */
    public function addAssets(AssetCollectionGroup $group,array $assets): AssetCollectionGroup{
        foreach ($group->getCollectionNames() as $collectionName){
            if(!isset($assets[$collectionName])){
                continue;
            }
            foreach ($assets[$collectionName] as $asset){
                $group->addFile($collectionName, $asset);
            }
        }
        return $group;
    }
}