<?php

namespace Stopka\Assetor\Control;

/**
 * @author Štěpán Škorpil
 * @license MIT
 */
interface IHeadControlFactory {
    /** @return HeadControl */
    public function create();
}