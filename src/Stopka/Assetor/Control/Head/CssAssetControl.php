<?php

namespace Stopka\Assetor\Control\Head;

use Nette\Utils\Html;
use Stopka\Assetor\Asset\BaseAsset;
use Stopka\Assetor\Asset\ContentAsset;
use Stopka\Assetor\Asset\FileAsset;

/**
 * @author Štěpán Škorpil
 * @copyright (c) Štěpán Škorpil 2017
 * @license MIT
 * @package HeaderControl
 */
class CssAssetControl extends AbstractAssetControl {
    const GROUP_ID = 'css';

    protected function getAssetGroupId(): string {
        return self::GROUP_ID;
    }

    protected function renderAsset(BaseAsset $item): void {
        $element = "";
        if ($item instanceof FileAsset) {
            $element = Html::el('link', [
                'rel' => 'stylesheet',
                'href' => $item->getFile()
            ]);
        }
        if ($item instanceof ContentAsset) {
            $element = Html::el('style')
                ->setHtml($item->getContent());
        }
        echo $element . "\n";
    }
}
