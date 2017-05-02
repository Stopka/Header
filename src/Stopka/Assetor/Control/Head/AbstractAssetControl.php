<?php

namespace Stopka\Assetor\Control\Head;

use Nette\Application\UI\Control;
use Stopka\Assetor\Collector\AssetsCollector;

/**
 * @author Štěpán Škorpil
 * @copyright (c) Štěpán Škorpil 2017
 * @license MIT
 * @package HeaderControl
 */
abstract class AbstractAssetControl extends Control {
    /** @var  AssetsCollector */
    private $assetsCollector;

    public function __construct(AssetsCollector $assetsCollector) {
        parent::__construct();
        $this->assetsCollector = $assetsCollector;
    }

    /**
     * @return AssetsCollector
     */
    protected function getAssetsCollector(): AssetsCollector {
        return $this->assetsCollector;
    }

    abstract protected function getAssetGroupId(): string;

    abstract protected function renderAsset($item);

    public function render() {
        foreach ($this->assetsCollector->getAssets($this->getAssetGroupId()) as $item) {
            $this->renderAsset($item);
        }
    }
}
