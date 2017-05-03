<?php

namespace Stopka\Assetor\Control\Head;

use Nette\Application\UI\Control;
use Nette\Utils\Html;

/**
 * @author Štěpán Škorpil
 * @copyright (c) Ondřej Mirtes 2009, 2010
 * @copyright (c) Roman Mátyus 2012
 * @copyright (c) Štěpán Škorpil 2017
 * @license MIT
 * @package HeaderControl
 */
class TitleControl extends Control implements IHeadComponent {
    const META_APP_TITLES = ['apple-mobile-web-app-title', 'application-name'];

    /** @var string title separator */
    private $separator = '';

    /** @var bool whether title should be rendered in reverse order or not */
    private $reverseOrder = TRUE;

    /** @var string[] document hierarchical titles */
    private $titles = array('');

    /** @var  IMetaCollector|null */
    private $metaCollector;

    /**
     * TitleControl constructor.
     * @param string $defaultTitle
     */
    public function __construct(string $defaultTitle = '') {
        parent::__construct();
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
     * @return self
     */
    public function setTitle(string $title, int $index = null): self {
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
     * @return self
     */
    public function addTitle(string $title): self {
        if(count($this->titles)==1&&!$this->titles[0]){
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

    /**
     * @param string $separator
     * @return self
     */
    public function setSeparator(string $separator): self {
        $this->separator = $separator;
        return $this; //fluent interface
    }

    /**
     * @return string
     */
    public function getSeparator(): string {
        return $this->separator;
    }

    /**
     * @param bool $reverseOrder
     * @return self
     */
    public function setReverseOrder(bool $reverseOrder = true): self {
        $this->reverseOrder = $reverseOrder;

        return $this; //fluent interface
    }

    public function isOrderReversed(): bool {
        return $this->reverseOrder;
    }

    /**
     * @return string
     */
    public function getTitleString(): string {
        $titles = $this->getTitles();
        if ($this->isOrderReversed()) {
            $titles = array_reverse($titles);
        }
        return implode($this->getSeparator(), $titles);
    }

    public function render() {
        echo Html::el('title')->setText($this->getTitleString());
        echo "\n";
    }
}
