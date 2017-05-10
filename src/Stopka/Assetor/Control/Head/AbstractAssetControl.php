<?php

namespace Stopka\Assetor\Control\Head;

use Nette\Application\UI\Control;
use Stopka\Assetor\Asset\BaseAsset;
use Stopka\Assetor\Collector\AssetsCollector;

/**
 * Basic control for rendering assets
 * @author Štěpán Škorpil
 * @license MIT
 * @package HeaderControl
 */
abstract class AbstractAssetControl extends Control implements IHeadComponent {
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

    abstract protected function renderAsset(BaseAsset $item): void;

    public function render() {
        foreach ($this->assetsCollector->getAssets($this->getAssetGroupId()) as $item) {
            $this->renderAsset($item);
        }
    }
}
