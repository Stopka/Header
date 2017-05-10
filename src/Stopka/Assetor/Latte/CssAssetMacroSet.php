<?php

namespace Stopka\Assetor\Latte;

use Stopka\Assetor\Control\Head\CssAssetControl;

/**
 * Css controling macros
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class CssAssetMacroSet extends AbstractAssetMacroSet {

    protected function getAssetGroupId(): string {
        return CssAssetControl::GROUP_ID;
    }

    protected function getContentTagName() {
        return 'style';
    }
}
