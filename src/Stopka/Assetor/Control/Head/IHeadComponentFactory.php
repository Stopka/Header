<?php

namespace Stopka\Assetor\Control\Head;

/**
 * @author Štěpán Škorpil
 * @license MIT
 */
interface IHeadComponentFactory {
    /**
     * @return IHeadComponent
     */
    public function create();
}
