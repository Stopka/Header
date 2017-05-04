<?php

namespace Stopka\Assetor\Latte;

use Stopka\Assetor\Control\Head\CssAssetControl;

/**
 * Class defined macros for AssetsCollector.
 *
 * @author Roman Mátyus
 * @copyright (c) Roman Mátyus 2012
 * @license MIT
 */
class CssAssetMacroSet extends AbstractAssetMacroSet {

    protected function getAssetGroupId(): string {
        return CssAssetControl::GROUP_ID;
    }
}
