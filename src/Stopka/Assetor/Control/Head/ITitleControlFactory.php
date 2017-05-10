<?php

namespace Stopka\Assetor\Control\Head;

/**
 * @author Štěpán Škorpil
 * @license MIT
 */
interface ITitleControlFactory extends IHeadComponentFactory {
    public function create():TitleControl;
}