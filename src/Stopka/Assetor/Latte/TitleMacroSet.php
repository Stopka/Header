<?php

namespace Stopka\Assetor\Latte;

use Latte\MacroNode;
use Latte\PhpWriter;
use Stopka\Assetor\Collector\ITitleCollector;

/**
 * Class defined macros for AssetsCollector.
 *
 * @author Roman Mátyus
 * @copyright (c) Roman Mátyus 2012
 * @license MIT
 */
class TitleMacroSet extends AbstractMacroSet {
    public function addMacros(): void {
        $this->addMacro('addTitle', [$this, 'macroAdd']);
    }

    public function macroAdd(MacroNode $node, PhpWriter $writer) {
        $code = <<<'EOT'
        $service = %assetor.service;
        $service->addTitle(%node.word);
EOT;
        $code = $this->processTokens($code);
        return $writer->write($code);
    }

    public function macroSet(MacroNode $node, PhpWriter $writer) {
        $code = <<<'EOT'
        $service = %assetor.service;
        $service->setTitle(%node.word);
EOT;
        $code = $this->processTokens($code);
        return $writer->write($code);
    }

    protected function getTokens(): array {
        $tokens = parent::getTokens();
        $tokens['%assetor.class'] = ITitleCollector::class;
        $tokens['%assetor.service'] = '$presenter->getContext()->getByType("' . ITitleCollector::class . '")';
        return $tokens;
    }


}
