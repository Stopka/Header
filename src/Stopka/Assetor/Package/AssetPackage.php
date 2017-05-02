<?php

namespace Stopka\Assetor\Package;

use Stopka\Assetor\Collector\AssetCollectionGroup;

/**
 * Package of assets
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class AssetPackage extends BasePackage {

    /** @var string[] */
    protected $extends = [];

    /** @var  string[] */
    protected $provides = [];

    /** @var  string[] */
    protected $selects = [];

    /** @var  AssetCollectionGroup */
    protected $assetCollectionGroup;

    public function addExtendsPackage(string $packageName): self {
        if (in_array($packageName, $this->extends))
            return $this;
        $this->extends[] = $packageName;
        return $this;
    }

    /**
     * @return AssetCollectionGroup
     */
    public function getAssetCollectionGroup(): AssetCollectionGroup {
        return $this->assetCollectionGroup;
    }

    /**
     * @param AssetCollectionGroup $assetCollectionGroup
     * @return self
     */
    public function setAssetCollectionGroup(AssetCollectionGroup $assetCollectionGroup): self {
        $this->assetCollectionGroup = $assetCollectionGroup;
        return $this;
    }

    public function addProvidesPackage(string $packageName): self {
        if (in_array($packageName, $this->provides))
            return $this;
        $this->provides[] = $packageName;
        return $this;
    }

    public function addSelectsPackage(string $packageName): self {
        if (in_array($packageName, $this->selects))
            return $this;
        $this->selects[] = $packageName;
        return $this;
    }
}
