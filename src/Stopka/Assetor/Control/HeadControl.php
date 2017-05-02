<?php

namespace Stopka\Assetor\Control;

use Nette\Application\UI\Control;
use Nette\Utils\Html;
use Stopka\Assetor\Control\Head\IHeadComponent;
use Stopka\Assetor\Control\Head\IHeadComponentFactory;

/**
 * HeaderControl
 * This renderable component is ultimate solution for valid and complete HTML headers.
 *
 * @author Štěpán Škorpil
 * @copyright (c) Ondřej Mirtes 2009, 2010
 * @copyright (c) Roman Mátyus 2012
 * @copyright (c) Štěpán Škorpil 2017
 * @license MIT
 * @package HeaderControl
 */
class HeadControl extends Control {

    /** @var  IHeadComponentFactory[] */
    private $componentFactories;

    public function render() {
        $this->renderBegin();
        $this->renderContents();
        $this->renderEnd();
    }

    public function renderBegin() {
        echo Html::el('head')->startTag();
        echo "\n";
    }

    public function renderContents(){
        //TODO
    }

    public function renderEnd() {
        echo Html::el('head')->endTag();
        echo "\n";
    }

    /**
     * @param IHeadComponentFactory $componentFactory
     * @return self
     */
    public function addComponentFactory(IHeadComponentFactory $componentFactory): self {
        $this->componentFactories[] = $componentFactory;
        return $this;
    }
}
