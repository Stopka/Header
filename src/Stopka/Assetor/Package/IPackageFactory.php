<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 21.4.17
 * Time: 19:32
 */

namespace Stopka\Assetor\Package;

interface IPackageFactory {

    public function create(array $details): IPackage;
}