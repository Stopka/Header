<?php

namespace Stopka\Assetor\Control;


/*
 * @copyright (c) Roman Mátyus
 * @license MIT
 * @package HeaderControl
 */
interface IIcon
{
	public function __toString();
	public function getString() : string;
}
