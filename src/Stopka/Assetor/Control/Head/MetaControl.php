<?php

namespace Stopka\Assetor\Control\Head;

use Nette\Application\UI\Control;
use Nette\Utils\Html;

/**
 *
 * @author Štěpán Škorpil
 * @copyright (c) Štěpán Škorpil 2017
 * @license MIT
 * @package HeaderControl
 */
class MetaControl extends Control implements IHeadComponent {
    /** @var  IMetaCollector */
    private $metaCollector;

    public function __construct(IMetaCollector $metaCollector) {
        parent::__construct();
        $this->setMetaCollector($metaCollector);
    }

    /**
     * @param IMetaCollector $metaCollector
     * @return self
     */
    public function setMetaCollector(IMetaCollector $metaCollector): self {
        $this->metaCollector = $metaCollector;
        return $this;
    }

    /**
     * @return IMetaCollector
     */
    public function getMetaCollector(): IMetaCollector {
        return $this->metaCollector;
    }

    /**
     * @param $name
     * @return bool
     */
    protected function isHttpEquiv(string $name): bool {
        return in_array($name, [
            IMetaCollector::META_REFRESH,
            IMetaCollector::META_CONTENT_TYPE,
            IMetaCollector::META_DEFAULT_STYLE
        ]);
    }

    /**
     * @param $name
     * @return bool
     */
    protected function isCharset(string $name): bool {
        return $name === IMetaCollector::META_CHARSET;
    }

    public function render(): void {
        foreach ($this->getMetaCollector()->getMetas() as $name => $content) {
            if (!$content)
                continue;
            if ($this->isCharset($name)) {
                $this->renderCharsetMeta($name, $content);
                continue;
            }
            if ($this->isHttpEquiv($name)) {
                $this->renderHttpEquivMeta($name, $content);
                continue;
            }
            $this->renderMeta($name, $content);
        }
    }

    public function renderCharsetMeta(string $name, string $content): void {
        echo Html::el('meta', [
                $name => $content
            ]) . "\n";
    }

    public function renderHttpEquivMeta(string $name, string $content): void {
        echo Html::el('meta', [
                'http-equiv' => $name,
                'content' => $content
            ]) . "\n";
    }

    public function renderMeta(string $name, string $content): void {
        echo Html::el('meta', [
                'name' => $name,
                'content' => $content
            ]) . "\n";
    }
}
