<?php

namespace Stopka\Assetor\Package;

use Stopka\Assetor\Asset\BaseAsset;
use Stopka\Assetor\Collector\AssetCollectionGroup;

/**
 * Package of assets
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class AssetPackage implements IPackage {

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

    public function getDependencies(): array {
        return $this->extends;
    }


    /**
     * @return string[] package names
     */
    public function getSelects(): array {
        return $this->selects;
    }

    /**
     * @return string[] package names
     */
    public function getProvides(): array {
        return $this->provides;
    }

    /**
     * @param string $packageName
     * @return IPackage
     */
    public function select(string $packageName): IPackage {
        throw new NotSupportedException("Assetor package of type asset can't be in 'provides' statement");
    }

    /**
     * @param string $groupName
     * @return BaseAsset[]
     */
    public function getAssets(string $groupName): array {
        return $this->getAssetCollectionGroup()->getAssets($groupName);
    }
}
