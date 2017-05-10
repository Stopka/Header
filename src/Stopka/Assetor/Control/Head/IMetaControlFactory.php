<?php

namespace Stopka\Assetor\Control\Head;

/**
 * @author Štěpán Škorpil
 * @license MIT
 */
interface IMetaControlFactory extends IHeadComponentFactory{
    public function create(): MetaControl;
}