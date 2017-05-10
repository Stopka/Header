<?php

namespace Stopka\Assetor\Package;

/**
 * @author Štěpán Škorpil
 * @license MIT
 */
interface IPackageFactory {

    public function create(array $details): IPackage;
}