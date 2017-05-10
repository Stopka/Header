<?php

namespace Stopka\Assetor\Latte;

use Latte\MacroNode;
use Latte\PhpWriter;
use Stopka\Assetor\Collector\IMetaCollector;

/**
 * Icon setting macro
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class MetaMacroSet extends AbstractMacroSet {
    public function addMacros(): void {
        $this->addMacro('setMeta', [$this, 'macroSet']);
    }

    public function macroSet(MacroNode $node, PhpWriter $writer) {
        $code = <<<'EOT'
        $service = %assetor.service;
        $service->setMeta(%node.args);
EOT;
        $code = $this->processTokens($code);
        return $writer->write($code);
    }

    protected function getTokens(): array {
        $tokens = parent::getTokens();
        $tokens['%assetor.class'] = IMetaCollector::class;
        $tokens['%assetor.service'] = '$presenter->getContext()->getByType("' . IMetaCollector::class . '")';
        return $tokens;
    }


}
