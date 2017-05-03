<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 3.5.17
 * Time: 22:33
 */

namespace Stopka\Assetor\Control\Head;


interface ICssAssetControlFactory extends IHeadComponentFactory {
    public function create(): CssAssetControl;
}