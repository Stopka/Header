<?php

namespace Stopka\Assetor\Collector;

/**
 * @copyright (c) Roman Mátyus 2015
 * @license MIT
 * @package HeaderControl
 */
interface IIconCollector {

    /**
     * @param null|string $filename
     * @return IIconCollector
     */
    public function setIcon(?string $filename): self;

    /**
     * @return null|string
     */
    public function getIcon(): ?string;
}