<?php

namespace Stopka\Assetor\Collector;

use Nette\Object;

/**
 *
 * @author Štěpán Škorpil
 * @copyright (c) Štěpán Škorpil 2017
 * @license MIT
 * @package HeaderControl
 */
class IconCollector extends Object implements IIconCollector {

    /** @var string */
    private $icon;

    public function __construct(?string $defaultIcon = null) {
        $this->setIcon($defaultIcon);
    }

    /**
     * @param string $filename
     * @return string[]
     */
    protected function getIconPathCandidates(string $filename): array {
        return [
            $filename,
            __DIR__ . DIRECTORY_SEPARATOR . $filename,
            $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $filename,
        ];
    }

    /**
     * @param null|string $filename
     * @return IIconCollector
     */
    public function setIcon(?string $filename): IIconCollector {
        $this->icon = $filename;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getIcon(): ?string {
        return $this->icon;
    }
}
