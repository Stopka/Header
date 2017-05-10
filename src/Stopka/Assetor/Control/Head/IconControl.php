<?php

namespace Stopka\Assetor\Control\Head;

use Nette\Application\UI\Control;
use Nette\Utils\Html;
use Stopka\Assetor\Collector\IIconCollector;

/**
 * Renders app icon in various forms
 * @author Štěpán Škorpil
 * @license MIT
 */
class IconControl extends Control implements IHeadComponent {

    /** @var IIconCollector */
    private $iconCollector;

    public function __construct(IIconCollector $iconCollector) {
        parent::__construct();
        $this->setIconCollector($iconCollector);
    }

    /**
     * @return IIconCollector
     */
    public function getIconCollector(): IIconCollector {
        return $this->iconCollector;
    }

    /**
     * @param IIconCollector $iconCollector
     */
    public function setIconCollector(IIconCollector $iconCollector) {
        $this->iconCollector = $iconCollector;
    }

    public function render() {
        $icon = $this->getIconCollector()->getIcon();
        if (!$icon) {
            return;
        }
        echo Html::el('link', [
                'rel' => 'icon',
                'href' => $icon
            ]) . "\n";
        echo Html::el('link', [
                'rel' => 'apple-touch-startup-image',
                'href' => $icon
            ]) . "\n";
        echo Html::el('link', [
                'rel' => 'apple-touch-icon',
                'href' => $icon
            ]) . "\n";
    }
}
