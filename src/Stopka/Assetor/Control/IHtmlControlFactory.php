<?php

namespace Stopka\Assetor\Control;

/**
 * @author Štěpán Škorpil
 * @license MIT
 */
interface IHtmlControlFactory {
    /** @return HtmlControl */
    public function create();
}