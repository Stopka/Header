<?php

namespace Stopka\Assetor\Control\Head;

use Nette\Utils\Html;

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

    protected function renderAsset($item) {
        $link = Html::el('link');
        $link->attrs['rel'] = 'stylesheet';
        $link->attrs['href'] = $item;
        echo $link . "\n";
    }
}
