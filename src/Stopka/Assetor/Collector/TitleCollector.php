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
class TitleCollector extends Object implements ITitleCollector {
    const META_APP_TITLES = ['apple-mobile-web-app-title', 'application-name'];

    /** @var string[] document hierarchical titles */
    private $titles = array('');

    /** @var  IMetaCollector|null */
    private $metaCollector;

    public function __construct(string $defaultTitle = "") {
        $this->setTitle($defaultTitle);
    }

    /**
     * @param IMetaCollector|null $metaCollector
     * @return self
     */
    public function setMetaCollector(?IMetaCollector $metaCollector): self {
        $this->metaCollector = $metaCollector;
        $this->updateMeta();
        return $this;
    }

    protected function updateMeta() {
        if (!$this->metaCollector) {
            return;
        }
        $appTitle = $this->getTitle(0);
        foreach (self::META_APP_TITLES as $name) {
            $this->metaCollector->setMeta($name, $appTitle);
        }
    }


    /**
     * @param string $title
     * @param int|null $index
     * @return ITitleCollector
     */
    public function setTitle(string $title, int $index = null): ITitleCollector {
        if ($index === null) {
            $this->titles = [$title];
        } else {
            $this->titles[$index] = $title;
        }
        $this->updateMeta();
        return $this; //fluent interface
    }

    /**
     * @param int|null $index
     * @return string|null
     */
    public function getTitle(int $index = null): string {
        if ($index === null) {
            return $this->getTitle(count($this->titles) - 1);
        }
        if (!isset($this->titles[$index])) {
            return '';
        }
        return (string)$this->titles[$index];
    }

    /**
     * @param string $title
     * @return ITitleCollector
     */
    public function addTitle(string $title): ITitleCollector {
        if (count($this->titles) == 1 && !$this->titles[0]) {
            return $this->setTitle($title);
        }
        $this->titles[] = $title;
        $this->updateMeta();
        return $this;
    }

    /**
     * @return string[]
     */
    public function getTitles(): array {
        return $this->titles;
    }
}
