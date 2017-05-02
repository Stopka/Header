<?php

namespace Stopka\Assetor\Control;

/*
 * @copyright (c) Roman Mátyus
 * @license MIT
 * @package HeaderControl
 */
interface IIconFactory
{
	public function create(string $source) : IIcon;
}
