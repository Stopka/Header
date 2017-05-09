<?php

namespace Stopka\Assetor\Collector;

/**
 * @copyright (c) Roman Mátyus 2015
 * @license MIT
 * @package HeaderControl
 */
interface ITitleCollector {
    
    /**
     * @param string $title
     * @param int|null $index
     * @return self
     */
    public function setTitle(string $title, int $index = null): self;

    /**
     * @param int|null $index
     * @return string|null
     */
    public function getTitle(int $index = null): string;

    /**
     * @param string $title
     * @return self
     */
    public function addTitle(string $title): self;

    /**
     * @return string[]
     */
    public function getTitles(): array;
}