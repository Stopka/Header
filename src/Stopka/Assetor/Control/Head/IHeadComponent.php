<?php

namespace Stopka\Assetor\Control\Head;

/*
 * @copyright (c) Roman Mátyus
 * @license MIT
 * @package HeaderControl
 */
use Nette\ComponentModel\IComponent;

interface IHeadComponent extends IComponent{
    public function render();
}
