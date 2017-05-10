<?php

namespace Stopka\Assetor\Collector;

/**
 * @author Štěpán Škorpil
 * @license MIT
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