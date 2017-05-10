<?php

namespace Stopka\Assetor\Latte;

use Latte\Compiler;
use Latte\Macros\MacroSet;
use Stopka\Assetor\Collector\AssetsCollector;

/**
 * Common basics of macros
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
abstract class AbstractMacroSet extends MacroSet {

    /**
     * Method install macros.
     * @param Compiler $compiler
     */
    public static function install(Compiler $compiler) {
        $set = new static($compiler);
        $set->addMacros();
    }

    abstract public function addMacros(): void;

    protected function getTokens(): array {
        return [
            '%assetor.class' => AssetsCollector::class,
            '%assetor.service' => '$presenter->getContext()->getByType("' . AssetsCollector::class . '")',
            '%assetor.debug' => 'class_exists("\Tracy\Debugger")&&!\Tracy\Debugger::$productionMode'
        ];
    }

    protected function processTokens(string $code): string {
        $replacements = $this->getTokens();
        $code = str_replace(array_keys($replacements), array_values($replacements), $code);
        return $code;
    }
}
