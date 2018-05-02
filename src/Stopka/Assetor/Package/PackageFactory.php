<?php

namespace Stopka\Assetor\Package;

use Nette\SmartObject;
use Stopka\Assetor\Collector\IAssetCollectionGroupFactory;

/**
 * Factory of packages from config array
 * @package Stopka\Assetor\Package
 * @author Štěpán Škorpil
 * @license MIT
 */
class PackageFactory implements IPackageFactory {
    use SmartObject;

    const CONFIG_VIRTUAL = 'defaults';
    const CONFIG_EXTEND = 'extends';
    const CONFIG_PROVIDE = 'provides';
    const CONFIG_SELECT = 'selects';

    /** @var  IAssetCollectionGroupFactory */
    private $assetCollectionGroupFactory;

    public function __construct(IAssetCollectionGroupFactory $assetCollectionGroupFactory) {
        $this->setAssetCollectionGroupFactory($assetCollectionGroupFactory);
    }

    public function setAssetCollectionGroupFactory(IAssetCollectionGroupFactory $assetCollectionGroupFactory): self {
        $this->assetCollectionGroupFactory = $assetCollectionGroupFactory;
        return $this;
    }

    /**
     * @param array $details
     * @return IPackage
     * @throws InvalidPackageException
     */
    public function create(array $details): IPackage {
        if (isset($details[self::CONFIG_VIRTUAL])) {
            return $this->createVirtualPackage($details);
        }
        return $this->createAssetPackage($details);
    }

    public function createAssetPackage(array $details): AssetPackage {
        $package = new AssetPackage();
        if (isset($details[self::CONFIG_EXTEND])) {
            foreach ($details[self::CONFIG_EXTEND] as $extends) {
                $package->addExtendsPackage($extends);
            }
            unset($details[self::CONFIG_EXTEND]);
        }
        if (isset($details[self::CONFIG_PROVIDE])) {
            foreach ($details[self::CONFIG_PROVIDE] as $provides) {
                $package->addProvidesPackage($provides);
            }
            unset($details[self::CONFIG_PROVIDE]);
        }
        if (isset($details[self::CONFIG_SELECT])) {
            foreach ($details[self::CONFIG_SELECT] as $provides) {
                $package->addSelectsPackage($provides);
            }
            unset($details[self::CONFIG_SELECT]);
        }
        $assetGroup = $this->assetCollectionGroupFactory->create($details);
        $package->setAssetCollectionGroup($assetGroup);
        return $package;
    }

    /**
     * @param array $details
     * @return VirtualPackage
     * @throws InvalidPackageException
     */
    public function createVirtualPackage(array $details): VirtualPackage {
        $default = $details[self::CONFIG_VIRTUAL];
        unset($details[self::CONFIG_VIRTUAL]);
        if (count($details) > 0) {
            $args = implode(', ', array_keys($details));
            throw new InvalidPackageException("Invalid arguments for virtual package: $args");
        }
        return new VirtualPackage($default);
    }
}