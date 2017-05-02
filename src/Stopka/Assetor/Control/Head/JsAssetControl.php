<?php

namespace Stopka\Assetor\Control\Head;

use Nette\Utils\Html;

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

    protected function renderAsset($item) {
        $link = Html::el('script');
        $link->attrs['src'] = $item;
        echo $link . "\n";
    }
}
