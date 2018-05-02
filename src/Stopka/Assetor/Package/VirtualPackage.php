<?php

namespace Stopka\Assetor\Package;

use Nette\SmartObject;
use Stopka\Assetor\Asset\BaseAsset;

/**
 * Virtual package
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class VirtualPackage implements IPackage {
    use SmartObject;

    /** @var string default selected subpackage */
    protected $default;

    /** @var  string actually selected package */
    protected $selected;

    public function __construct(string $defaultPackageName) {
        $this->setDefault($defaultPackageName);
    }

    public function setDefault(string $packageName): self{
        $this->default = $packageName;
        return $this;
    }

    public function getDefault(){
        return $this->default;
    }

    public function getSelected(){
        if(!$this->selected){
            return $this->getDefault();
        }
        return $this->selected;
    }

    public function select(string $packageName): IPackage {
        $this->selected = $packageName;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array {
        return [$this->getSelected()];
    }

    /**
     * @return string[] package names
     */
    public function getSelects(): array {
        return [];
    }

    /**
     * @return string[] package names
     * @throws NotSupportedException
     */
    public function getProvides(): array {
        throw new NotSupportedException("Assetor package of type virtual can't be used in 'selects' statement!");
    }

    /**
     * @param string $groupName
     * @return BaseAsset[]
     */
    public function getAssets(string $groupName): array {
        return [];
    }

    /**
     * @param string $groupName
     * @param string $content
     * @return IPackage
     * @throws NotSupportedException
     */
    public function addContent(string $groupName, string $content): IPackage {
        throw new NotSupportedException("Assetor package of type virtual can't have contents");
    }

    /**
     * @param string $groupName
     * @param string $file
     * @return IPackage
     * @throws NotSupportedException
     */
    public function addFile(string $groupName, string $file): IPackage {
        throw new NotSupportedException("Assetor package of type virtual can't have files");
    }
}
