<?php

namespace Stopka\Assetor\Latte;

use Stopka\Assetor\Control\Head\JsAssetControl;

/**
 * Js controling macros
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class JsAssetMacroSet extends AbstractAssetMacroSet {

    protected function getAssetGroupId(): string {
        return JsAssetControl::GROUP_ID;
    }


    protected function getContentTagName() {
        return 'script';
    }
}
