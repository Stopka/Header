<?php

namespace Stopka\Assetor\Latte;

use Latte\MacroNode;
use Latte\PhpWriter;
use Stopka\Assetor\Collector\AssetsCollector;

/**
 * Class defined macros for AssetsCollector.
 *
 * @author Roman Mátyus
 * @copyright (c) Roman Mátyus 2012
 * @license MIT
 */
abstract class AbstractAssetMacroSet extends AbstractMacroSet {
    abstract protected function getAssetGroupId(): string;

    public function addMacros(): void {
        $groupId = $this->getAssetGroupId();
        $this->addMacro($groupId . 'File', [$this, 'macroFileBegin'], NULL);
        $this->addMacro($groupId . 'Content', [$this, 'macroContentBegin'], [$this, 'macroContentEnd']);
    }

    public function macroFileBegin(MacroNode $node, PhpWriter $writer) {
        $code = <<<'EOT'
        if(%assetor.debug){
            echo("<!-- assetor-%assetor.groupIdFile %node.array -->"); 
        }
EOT;
        $code = $this->processTokens($code);
        return $writer->write($code);
    }

    public function macroContentBegin(MacroNode $node, PhpWriter $writer) {
        $code = <<<'EOT'
        ob_start();
EOT;
        $code = $this->processTokens($code);
        return $writer->write($code);
    }

    public function macroContentEnd(MacroNode $node, PhpWriter $writer) {
        $code = <<<'EOT'
        $content = ob_get_contents();
        ob_end_clean();
        $service = %assetor.service;
        if(%assetor.debug){
            echo("<!-- assetor-%assetor.groupIdContent %node.array -->\n");
        }
EOT;
        $code = $this->processTokens($code);
        return $writer->write($code);
    }

    protected function getTokens(): array {
        $tokens = parent::getTokens();
        $tokens['%assetor.groupId'] = $this->getAssetGroupId();
        return $tokens;
    }
}
