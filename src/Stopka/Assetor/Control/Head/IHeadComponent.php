<?php

namespace Stopka\Assetor\Control\Head;

/**
 * @author Štěpán Škorpil
 * @license MIT
 */
use Nette\ComponentModel\IComponent;

interface IHeadComponent extends IComponent{
    public function render();
}
