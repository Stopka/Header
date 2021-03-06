<?php

namespace Stopka\Assetor\Collector;

use Nette\SmartObject;
use Stopka\Assetor\Asset\BaseAsset;
use Stopka\Assetor\Package\IPackage;
use Stopka\Assetor\Package\IPackageFactory;
use Stopka\Assetor\Package\NotFoundException;
use Stopka\Assetor\Package\NotSupportedException;
use Stopka\Assetor\Package\PackageException;

/**
 * Class for collecting assets in PHP framework Nette.
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class AssetsCollector {
    use SmartObject;

    /** @var  IPackageFactory */
    protected $packageFactory;

    /** @var IPackage[] */
    private $packages;

    /** @var string[] used packages */
    private $usedPackages = [];

    /** @var string[] dependent packages */
    private $dependentPackages;

    public function __construct(IPackageFactory $packageFactory) {
        $this->setPackageFactory($packageFactory);
    }

    /**
     * @param IPackageFactory $packageFactory
     * @return self
     */
    public function setPackageFactory(IPackageFactory $packageFactory): self {
        $this->packageFactory = $packageFactory;
        return $this;
    }

    /**
     * @param string $name
     * @param bool $needed
     * @return null|IPackage
     * @throws NotFoundException
     */
    public function getPackage(string $name, bool $needed = false): ?IPackage {
        if ($needed && !isset($this->packages[$name])) {
            throw new NotFoundException("Assetor package '$name' not found");
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

    /**
     * @param string $packageName
     * @param array $resolved
     * @param array $unresolved
     * @throws NotFoundException
     * @throws NotSupportedException
     */
    private function resolveDependeciesRecursively(string $packageName, array &$resolved, array &$unresolved) {
        $unresolved[] = $packageName;
        $package = $this->getPackage($packageName, true);
        foreach ($package->getDependencies() as $dependecyName) {
            if (in_array($dependecyName, $resolved)) {
                continue;
            }
            if (in_array($dependecyName, $unresolved)) {
                throw new NotSupportedException("Circular extends statement detected: $packageName -> $dependecyName");
            }
            $this->resolveDependeciesRecursively($dependecyName, $resolved, $unresolved);
        }
        if(!in_array($packageName,$resolved)) {
            $resolved[] = $packageName;
        }
        $index = array_search($packageName, $unresolved);
        if ($index!==false) {
            unset($unresolved[$index]);
        }
    }

    /**
     * @param array $packagesNames
     * @throws NotFoundException
     * @throws PackageException
     */
    private function resolveSelection(array $packagesNames): void {
        foreach ($packagesNames as $packagesName) {
            $package = $this->getPackage($packagesName, true);
            $selectNames = $package->getSelects();
            foreach ($selectNames as $selectName) {
                try {
                    $selection = $this->getPackage($selectName, true);
                    $providedNames = $selection->getProvides();
                } catch (PackageException $e) {
                    throw new PackageException("Assetor package '$packagesName' can't select package '$selectName'", 0, $e);
                }
                foreach ($providedNames as $providedName) {
                    try {
                        $provided = $this->getPackage($providedName, true);
                        $provided->select($selectName);
                    } catch (PackageException $e) {
                        throw new PackageException("Assetor package '$selectName' can't provide package '$providedName'", 0, $e);
                    }
                }
            }
        }
    }

    /**
     * @param string[] $packageNames
     * @return string[]
     * @throws NotFoundException
     * @throws PackageException
     */
    private function resolveDependecies(array $packageNames): array {
        $this->resolveSelection($packageNames);
        $resolved = [];
        $unresolved = [];
        foreach ($packageNames as $packageName) {
            $this->resolveDependeciesRecursively($packageName, $resolved, $unresolved);
        }
        //\Tracy\Debugger::barDump($resolved,'resolved');
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
        //\Tracy\Debugger::barDump($this->usedPackages,'used');
        return $this->usedPackages;
    }

    /**
     * @return string[]
     * @throws NotFoundException
     * @throws PackageException
     */
    public function getDependentPackages(): array {
        if (!$this->dependentPackages) {
            $this->dependentPackages = $this->resolveDependecies($this->getUsedPackages());
        }
        return $this->dependentPackages;
    }

    /**
     * @param string $groupName
     * @return BaseAsset[]
     * @throws PackageException
     */
    public function getAssets(string $groupName): array {
        $result = [];
        foreach ($this->getDependentPackages() as $packageName) {
            $package = $this->getPackage($packageName, true);
            $assets = $package->getAssets($groupName);
            $result = array_merge($result, $assets);
        }
        return $result;
    }

    /**
     * @param string $groupName
     * @param string $content
     * @param array $params
     * @return string
     */
    public function addContent(string $groupName, string $content, array $params = []): string {
        $packageName = $params['name'] ?? 'content_' . sha1($content);
        $use = $params['use'] ?? true;
        unset($params['name'],$params['use']);
        $package = $this->packageFactory->create($params);
        $package->addContent($groupName, $content);
        $this->registerPackage($packageName, $package);
        if($use){
            $this->usePackage($packageName);
        }
        return $packageName;
    }

}
