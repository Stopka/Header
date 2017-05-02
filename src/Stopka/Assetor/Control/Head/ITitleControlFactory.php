<?php

namespace Stopka\Assetor\Control\Head;

/**
 * @copyright (c) Roman Mátyus 2015
 * @license MIT
 * @package HeaderControl
 */
interface ITitleControlFactory {
    /** @return TitleControl */
    public function create();
}