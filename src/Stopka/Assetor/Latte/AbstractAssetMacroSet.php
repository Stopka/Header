<?php

namespace Stopka\Assetor\Latte;

use Latte\CompileException;
use Latte\MacroNode;
use Latte\PhpWriter;

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
        $service = %assetor.service;
        $file = %node.word
        $service->addFile('%assetor.groupId',$file,%node.array);
        if(%assetor.debug){
            echo("<!-- assetor-%assetor.groupIdFile %node.array -->"); 
        }
EOT;
        $code = $this->processTokens($code);
        return $writer->write($code);
    }

    public function macroContentBegin(MacroNode $node, PhpWriter $writer) {
        if($node->prefix===$node::PREFIX_TAG){
            throw new CompileException('Unknown ' . $node->getNotation() . ", use n:".$node->name." attribute.");
        }
        if($node->htmlNode && $node->htmlNode->name != $this->getContentTagName()){
            throw new CompileException("Macro " . $node->getNotation() . " can be used on <style> element only");
        }
        if ($node->modifiers) {
            throw new CompileException('Modifiers are not allowed in ' . $node->getNotation());
        }
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
        $packageName = $service->addContent('%assetor.groupId',$content,%node.array);
        if(%assetor.debug){
            echo("<!-- assetor-%assetor.groupIdContent $packageName -->\n");
        }
EOT;
        if($node->htmlNode && $node->prefix==$node::PREFIX_NONE){
            //\Tracy\Debugger::barDump($node);
        }
        $code = $this->processTokens($code);
        return $writer->write($code);
    }

    abstract protected function getContentTagName();

    protected function getTokens(): array {
        $tokens = parent::getTokens();
        $tokens['%assetor.groupId'] = $this->getAssetGroupId();
        return $tokens;
    }
}
