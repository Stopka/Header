<?php

namespace Stopka\Assetor\Control\Head;

use Nette\Utils\Html;
use Stopka\Assetor\Asset\BaseAsset;

/**
 * @author Štěpán Škorpil
 * @copyright (c) Štěpán Škorpil 2017
 * @license MIT
 * @package HeaderControl
 */
class JsAssetControl extends AbstractAssetControl {
    const GROUP_ID = 'js';

    protected function getAssetGroupId(): string {
        return self::GROUP_ID;
    }

    protected function renderAsset(BaseAsset $item): void {
        $link = Html::el('script');
        $link->attrs['src'] = $item->getFile();
        echo $link . "\n";
    }
}
