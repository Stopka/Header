<?php

namespace RM\AssetsCollector\Compilers;

use Nette\SmartObject;

/**
 * Base class for CSS/JS file compilers.
 *
 * @author Roman Mátyus
 * @copyright (c) Roman Mátyus 2012
 * @license MIT
 */
abstract class BaseAssetsCompiler {
    use SmartObject;
    /** @var string content of processed file */
    protected $input;

    /** @var string input after compile */
    protected $output;

    /** @var string base path for css files */
    public $cssPath;

    /** @var string base path for css files */
    public $jsPath;

    /** @var string */
    public $wwwDir;

    /** @var string webTemp folder */
    public $webTemp;

    /**
     * Get smaller variable from input/output
     * @return string    output string
     */
    public function getSmaller() {
        return (strlen($this->output) < strlen($this->input)) ? $this->output : $this->input;
    }
}
