<?php

namespace Stopka\Assetor\Package;
use Nette\NotSupportedException;
use Nette\Object;
use Stopka\Assetor\Asset\BaseAsset;

/**
 * Virtual package
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class VirtualPackage extends Object implements IPackage {

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
        return [$this->selected];
    }

    /**
     * @return string[] package names
     */
    public function getSelects(): array {
        return [];
    }

    /**
     * @return string[] package names
     */
    public function getProvides(): array {
        throw new NotSupportedException("Virtual assetor package can't be used in 'selects' statement!");
    }

    public function getAssets(string $groupName): array {
        return [];
    }


}
