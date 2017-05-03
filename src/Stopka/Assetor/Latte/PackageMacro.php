<?php

namespace Stopka\Assetor\Latte;

use Latte\MacroNode;
use Latte\Macros\MacroSet;
use Latte\Compiler;
use Latte\PhpWriter;
use Stopka\Assetor\Collector\AssetsCollector;

/**
 * Class defined macros for AssetsCollector.
 *
 * @author Roman Mátyus
 * @copyright (c) Roman Mátyus 2012
 * @license MIT
 */
class PackageMacro extends MacroSet {
    /**
     * Method install macros.
     * @param Compiler $compiler
     */
    public static function install(Compiler $compiler) {
        $set = new static($compiler);
        $set->addMacro('usePackage', [$set, 'macroPackage']);
    }

    public function macroPackage(MacroNode $node, PhpWriter $writer) {
        $class = AssetsCollector::class;
        $code = <<<'EOT'
        $presenter->getContext()->getByType('CLASS')->usePackages(%node.array)
EOT;
        $code = str_replace('CLASS', $class, $code);
        return $writer->write($code);
    }
}
