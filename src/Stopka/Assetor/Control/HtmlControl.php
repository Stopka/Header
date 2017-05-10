<?php

namespace Stopka\Assetor\Control;

use Nette\Application\UI\Control;
use Nette\Utils\Html;

/**
 * Renders basic html page with headers
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class HtmlControl extends Control {
    /**
     * languages
     */
    const LANG_CZECH = 'cs';
    const LANG_SLOVAK = 'sk';
    const LANG_ENGLISH = 'en';
    const LANG_GERMAN = 'de';

    /** @var string document language */
    private $language;

    /** @var Html */
    private $htmlTag;

    /** @var  IHeadControlFactory */
    protected $headControlFactory;

    public function __construct(IHeadControlFactory $headControlFactory) {
        parent::__construct();
        $this->headControlFactory = $headControlFactory;
    }

    /**
     * @param string $language
     * @return self
     */
    public function setLanguage(string $language): self {
        $this->language = $language;
        return $this; //fluent interface
    }

    /**
     * @return string
     */
    public function getLanguage(): string {
        return $this->language;
    }

    /**
     * @return Html
     */
    public function getHtmlTag(): Html {
        if ($this->htmlTag == NULL) {
            $html = Html::el('html');
            $html->setAttribute('lang', $this->language);
            $this->htmlTag = $html;
        }

        return $this->htmlTag;
    }

    /**
     * @param Html $htmlTag
     * @return self
     */
    public function setHtmlTag(Html $htmlTag): self {
        $this->htmlTag = $htmlTag;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocType(): string {
        return '<!DOCTYPE html>';
    }

    public function render($body, $headers = null) {
        $this->renderBegin();
        $this->renderHead($headers);
        $this->renderBody($body);
        $this->renderEnd();
    }

    public function renderBegin() {
        echo $this->getDocType() . "\n";

        echo $this->getHtmlTag()->startTag() . "\n";
    }

    public function renderEnd() {
        echo $this->getHtmlTag()->endTag();
    }

    public function renderHead($headers = null) {
        /** @var HeadControl $head */
        $head = $this->getComponent('head');
        $head->render($headers);
    }

    public function renderBody($body) {
        echo $body;
    }

    /**
     * @return HeadControl
     */
    protected function createComponentHead() {
        return $this->headControlFactory->create();
    }
}
