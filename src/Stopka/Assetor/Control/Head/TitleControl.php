<?php

namespace Stopka\Assetor\Control\Head;

use Nette\Application\UI\Control;
use Nette\Utils\Html;
use Stopka\Assetor\Collector\ITitleCollector;

/**
 * Rendering of collected titles
 * @author Štěpán Škorpil
 * @license MIT
 */
class TitleControl extends Control implements IHeadComponent {

    /** @var string title separator */
    private $separator = ' - ';

    /** @var bool whether title should be rendered in reverse order or not */
    private $reverseOrder = TRUE;

    /** @var ITitleCollector */
    private $titleCollector;

    /**
     * TitleControl constructor.
     * @param ITitleCollector $titleCollector
     */
    public function __construct(ITitleCollector $titleCollector) {
        parent::__construct();
        $this->setTitleCollector($titleCollector);
    }

    /**
     * @return ITitleCollector
     */
    public function getTitleCollector(): ITitleCollector {
        return $this->titleCollector;
    }

    /**
     * @param ITitleCollector $titleCollector
     * @return self
     */
    public function setTitleCollector(ITitleCollector $titleCollector): self {
        $this->titleCollector = $titleCollector;

        return $this;
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
        $titles = $this->getTitleCollector()->getTitles();
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
