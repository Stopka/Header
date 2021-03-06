<?php

namespace Stopka\Assetor\Control\Head;

use Nette\Utils\Html;
use Stopka\Assetor\Asset\BaseAsset;
use Stopka\Assetor\Asset\ContentAsset;
use Stopka\Assetor\Asset\FileAsset;

/**
 * Rendering of collected JS assets
 * @author Štěpán Škorpil
 * @license MIT
 */
class JsAssetControl extends AbstractAssetControl {
    const GROUP_ID = 'js';

    protected function getAssetGroupId(): string {
        return self::GROUP_ID;
    }

    protected function renderAsset(BaseAsset $item): void {
        $element = Html::el('script',[
            'type'=>'text/javascript'
        ]);
        if ($item instanceof FileAsset) {
            $element->setAttribute('src', $item->getFile());
        }
        if ($item instanceof ContentAsset) {
            $element->setHtml($item->getContent());
        }
        echo $element . "\n";
    }
}
