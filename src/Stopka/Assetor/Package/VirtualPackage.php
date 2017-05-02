<?php

namespace Stopka\Assetor\Package;

/**
 * Virtual package
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class VirtualPackage extends BasePackage {

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

    public function select(string $packageName): self {
        $this->selected = $packageName;
        return $this;
    }
}
