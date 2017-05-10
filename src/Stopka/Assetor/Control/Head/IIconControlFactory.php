<?php

namespace Stopka\Assetor\Control\Head;

/**
 * @author Štěpán Škorpil
 * @license MIT
 */
interface IIconControlFactory extends IHeadComponentFactory {
    public function create(): IconControl;
}