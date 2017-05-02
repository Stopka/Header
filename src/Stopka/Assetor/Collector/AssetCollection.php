<?php

namespace Stopka\Assetor\Collector;

use Nette\Object;
use Stopka\Assetor\Asset\BaseAsset;
use Stopka\Assetor\Asset\ContentAsset;
use Stopka\Assetor\Asset\FileAsset;

/**
 * Class of Packages for AssetsCollector.
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class AssetCollection extends Object {

    /** @var BaseAsset[] attached assets */
    protected $assets = array();

    /** @var string base path for files */
    public $path;

    public function addFile($file){
        $this->assets[] = new FileAsset($file);
    }

    public function addContent($content){
        $this->assets[] = new ContentAsset($content);
    }
}