<?php

namespace Stopka\Assetor\Control\Head;

/*
 * @copyright (c) Roman Mátyus
 * @license MIT
 * @package HeaderControl
 */
interface IHeadComponentFactory {
    /**
     * @return IHeadComponent
     */
    public function create();
}
