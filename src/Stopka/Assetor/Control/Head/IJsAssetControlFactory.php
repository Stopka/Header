<?php

namespace Stopka\Assetor\Control\Head;

/**
 * @author Štěpán Škorpil
 * @license MIT
 */
interface IJsAssetControlFactory extends IHeadComponentFactory {
    public function create(): JsAssetControl;
}