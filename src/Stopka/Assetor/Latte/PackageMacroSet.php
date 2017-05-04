<?php

namespace Stopka\Assetor\Latte;

use Latte\MacroNode;
use Latte\PhpWriter;

/**
 * Class defined macros for AssetsCollector.
 *
 * @author Roman Mátyus
 * @copyright (c) Roman Mátyus 2012
 * @license MIT
 */
class PackageMacroSet extends AbstractMacroSet {
    public function addMacros(): void {
        $this->addMacro('usePackage', [$this, 'macroPackage'], NULL, [$this, 'macroPackage']);
    }

    public function macroPackage(MacroNode $node, PhpWriter $writer) {
        $code = <<<'EOT'
        $service = %assetor.service;
        $service->usePackage(%node.word);
        if(%assetor.debug){
            echo("<!-- assetor-usePackage ".%node.word." -->\n");
        }
EOT;
        $code = $this->processTokens($code);
        return $writer->write($code);
    }
}
