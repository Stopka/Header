<?php

namespace Stopka\Assetor\Latte;

use Stopka\Assetor\Control\Head\JsAssetControl;

/**
 * Class defined macros for AssetsCollector.
 *
 * @author Roman Mátyus
 * @copyright (c) Roman Mátyus 2012
 * @license MIT
 */
class JsAssetMacroSet extends AbstractAssetMacroSet {

    protected function getAssetGroupId(): string {
        return JsAssetControl::GROUP_ID;
    }


}
