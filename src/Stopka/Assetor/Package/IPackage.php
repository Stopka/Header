<?php

namespace Stopka\Assetor\Package;
use Stopka\Assetor\Asset\BaseAsset;

/**
 * Common base of packages
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
interface IPackage {
    /**
     * @return string[] package names
     */
    public function getDependencies(): array;

    /**
     * @return string[] package names
     */
    public function getSelects(): array;

    /**
     * @throws NotSupportedException
     * @return string[] package names
     */
    public function getProvides(): array;

    /**
     * @param string $packageName
     * @return self
     * @throws NotSupportedException
     */
    public function select(string $packageName): self;

    /**
     * @param string $groupName
     * @return BaseAsset[]
     */
    public function getAssets(string $groupName): array;
}
