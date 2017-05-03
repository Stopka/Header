<?php

namespace Stopka\Assetor\Collector;

use Nette\Object;
use Nette\FileNotFoundException;
use Nette\InvalidArgumentException;
use Nette\Utils\Finder;
use Nette\Utils\Strings;
use Nette\Utils\Validators;
use Stopka\Assetor\Package\IPackage;
use Stopka\Assetor\Package\IPackageFactory;

/**
 * Class for collecting CSS and JS files in PHP framework Nette.
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class AssetsCollector extends Object {

    /** @var  IPackageFactory */
    protected $packageFactory;

    /** @var AssetCollectionGroup directly attached files */
    protected $collectionGroup;

    /** @var IPackage[] */
    private $packages;

    /** @var string[] used packages */
    private $usedPackages;

    /** @var string[] dependent packages */
    private $dependentPackages;

    public function __construct(IPackageFactory $packageFactory) {
        $this->setPackageFactory($packageFactory);
    }

    /**
     * @param IPackageFactory $packageFactory
     * @return $this
     */
    public function setPackageFactory(IPackageFactory $packageFactory): self {
        $this->packageFactory = $packageFactory;
        return $this;
    }

    public function getPackage(string $name, bool $needed = false): ?IPackage {
        if ($needed && !isset($this->packages[$name])) {
            throw new InvalidArgumentException("Assetor package '$name' not found");
        }
        return $this->packages[$name] ?? NULL;
    }

    /**
     * @param string $name
     * @param IPackage $package
     * @return self
     */
    public function registerPackage(string $name, IPackage $package): self {
        $this->packages[$name] = $package;
        $this->rebuildDependencies();
        return $this;
    }

    /**
     * Set packages to service from array.
     * @param  array $packages packages configuration array
     * @return self
     */
    public function registerPackages(array $packages): self {
        foreach ($packages as $name => $details) {
            $package = $this->packageFactory->create($details);
            $this->registerPackage($name, $package);
        }
        return $this;
    }

    /**
     * Add package to service.
     * @param string $packageName string with name of package
     * @return self
     */
    public function usePackage(string $packageName): self {
        if (in_array($packageName, $this->usedPackages)) {
            return $this;
        }
        $this->usedPackages[] = $packageName;
        $this->rebuildDependencies();
        return $this;
    }

    private function resolveDependeciesRecursively(string $packageName, array &$resolved, array &$unresolved) {
        $unresolved[] = $packageName;
        $package = $this->getPackage($packageName, true);
        foreach ($package->getDependencies() as $dependecy) {
            if (!in_array($dependecy, $resolved)) {
                if (in_array($dependecy, $unresolved)) {
                    throw new InvalidArgumentException("Circular reference detected: $packageName -> $dependecy");
                }
                $this->resolveDependeciesRecursively($packageName, $resolved, $unresolved);
            }
            $resolved[] = $packageName;
            $index = array_search($packageName, $unresolved);
            if ($index) {
                unset($unresolved[$index]);
            }
        }
    }

    private function resolveSelection(array $packagesNames): array {
        foreach ($packagesNames as $packagesName) {
            $package = $this->getPackage($packagesName, true);
            $selectNames = $package->getSelects();
            foreach ($selectNames as $selectName) {
                $selection = $this->getPackage($selectName, true);
                $providedNames = $selection->getProvides();
                foreach ($providedNames as $providedName) {
                    $provided = $this->getPackage($providedName);
                    $provided->select($selectName);
                }
            }
        }
    }

    /**
     * @param string[] $packageNames
     * @return string[]
     */
    private function resolveDependecies(array $packageNames): array {
        $this->resolveSelection($packageNames);
        $resolved = [];
        foreach ($packageNames as $packageName) {
            $unresolved = [];
            $this->resolveDependeciesRecursively($packageNames, $resolved, $unresolved);
        }
        return $resolved;
    }

    public function rebuildDependencies(): self {
        $this->dependentPackages = null;
        return $this;
    }

    /**
     * @return \string[]
     */
    public function getUsedPackages(): array {
        return $this->usedPackages;
    }

    /**
     * @return IPackage[]
     */
    public function getDependentPackages(): array {
        if (!$this->dependentPackages) {
            $this->dependentPackages = $this->resolveDependecies($this->getUsedPackages());
        }
        return $this->dependentPackages;
    }

    public function getAssets(string $groupName) {
        $assets = [];
        foreach ($this->getDependentPackages() as $dependentPackage) {
            $assets += $dependentPackage->getAssets($groupName);
        }
        return $assets;
    }


}
