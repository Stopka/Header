<?php

namespace Stopka\Assetor\Control;

/**
 * @copyright (c) Roman Mátyus 2015
 * @license MIT
 * @package HeaderControl
 */
interface IHeadControlFactory {
    /** @return HeadControl */
    public function create();
}