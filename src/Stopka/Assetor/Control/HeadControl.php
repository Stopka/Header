<?php

namespace Stopka\Assetor\Control;

use Nette\Application\ApplicationException;
use Nette\Application\UI\Control;
use Nette\ComponentModel\IComponent;
use Nette\Utils\Html;
use Stopka\Assetor\Control\Head\IHeadComponent;
use Stopka\Assetor\Control\Head\IHeadComponentFactory;

/**
 * Renders html head element with all header tags as additional controls
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class HeadControl extends Control {

    /** @var  IHeadComponentFactory[] */
    private $componentFactories;

    public function render($headers = null) {
        $this->renderBegin();
        $this->renderContents();
        $this->renderAdditionals($headers);
        $this->renderEnd();
    }

    public function renderBegin() {
        echo Html::el('head')->startTag();
        echo "\n";
    }

    public function renderAdditionals($headers = null){
        echo $headers;
    }

    public function renderContents() {
        foreach (array_keys($this->componentFactories) as $name) {
            /** @var IHeadComponent $component */
            $component = $this->getComponent($name);
            $component->render();
            echo "\n";
        }
    }

    /**
     * @param $name
     * @return IComponent
     */
    protected function createComponent($name) {
        if($component = $this->createComponentByFactory($name)){
            return $component;
        }
        return parent::createComponent($name);
    }

    /**
     * @param string $name
     * @return IHeadComponent
     */
    protected function createComponentByFactory(string $name): IHeadComponent {
        if(!isset($this->componentFactories[$name])){
            return NULL;
        }
        $componentFactory = $this->componentFactories[$name];
        return $componentFactory->create();
    }

    public function renderEnd() {
        echo Html::el('head')->endTag();
        echo "\n";
    }

    /**
     * @param IHeadComponentFactory $componentFactory
     * @return self
     */
    public function addComponentFactory(IHeadComponentFactory $componentFactory, string $name): self {
        if (isset($this->componentFactories[$name])) {
            throw new ApplicationException("Component factory '$name' already exists");
        }
        $this->componentFactories[$name] = $componentFactory;
        return $this;
    }
}
