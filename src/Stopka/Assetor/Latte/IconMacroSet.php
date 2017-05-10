<?php

namespace Stopka\Assetor\Latte;

use Latte\MacroNode;
use Latte\PhpWriter;
use Stopka\Assetor\Collector\IIconCollector;

/**
 * Icon setting macro
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class IconMacroSet extends AbstractMacroSet {
    public function addMacros(): void {
        $this->addMacro('setIcon', [$this, 'macroSet']);
    }

    public function macroSet(MacroNode $node, PhpWriter $writer) {
        $code = <<<'EOT'
        $service = %assetor.service;
        $service->setIcon(%node.word);
EOT;
        $code = $this->processTokens($code);
        return $writer->write($code);
    }

    protected function getTokens(): array {
        $tokens = parent::getTokens();
        $tokens['%assetor.class'] = IIconCollector::class;
        $tokens['%assetor.service'] = '$presenter->getContext()->getByType("' . IIconCollector::class . '")';
        return $tokens;
    }


}
