<?php

namespace Stopka\Assetor\Control\Head;

use Nette\Application\UI\Control;
use Nette\InvalidArgumentException;
use Nette\Utils\Html;

/**
 *
 * @author Štěpán Škorpil
 * @copyright (c) Štěpán Škorpil 2017
 * @license MIT
 * @package HeaderControl
 */
class MetaControl extends Control {
    const META_CHARSET = 'charset';

    const META_REFRESH = 'refresh';
    const META_CONTENT_TYPE = 'content-type';
    const META_DEFAULT_STYLE = 'default-style';

    const META_KEYWORDS = 'keywords';
    const META_AUTHOR = 'author';
    const META_DESCRIPTION = 'description';
    const META_ROBOTS = 'robots';

    const CT_TEXT_HTML = 'text/html';
    const CHARSET_UTF8 = 'UTF-8';

    /** @var array header meta tags */
    private $metas = array();

    /**
     * @param string $name
     * @param string|null $value
     * @return self
     */
    public function setMeta(string $name, string $value = null): self {
        if (!$value) {
            unset($this->metas[$name]);
        } else {
            $this->metas[$name] = $value;
        }
        return $this; //fluent interface
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getMeta(string $name): string {
        return $this->metas[$name] ?? NULL;
    }

    /**
     * @return string[] $name=>$value
     */
    public function getMetas() {
        return $this->metas;
    }

    /**
     * @param string|null $valueString
     * @return array
     */
    protected function explodeValues(string $valueString): array {
        if (!$valueString) {
            return [];
        }
        $values = explode(',', $valueString);
        return array_map(function ($kw) {
            return trim($kw);
        }, $values);
    }

    /**
     * @param array $values
     * @return string|null
     */
    protected function implodeValues(array $values): string {
        if (!count($values)) {
            return NULL;
        }
        return implode(', ', $values);
    }

    /**
     * @param string[]|string $values
     * @return array
     */
    protected function getPlainValueArray($values): array {
        if (is_string($values)) {
            $values = $this->explodeValues($values);
        }
        if (!is_array($values)) {
            throw new InvalidArgumentException('Type of argument is not supported.');
        }
        $values = array_values($values);
        return $values;
    }

    /**
     * @param string $name
     * @param string[]|string $values
     * @return self
     */
    public function addMetaArrayItems(string $name, $values): self {
        $values = $this->getPlainValueArray($values);
        $oldValues = $this->getMetaArrayItems($name);
        $newKeywords = array_merge($oldValues, $values);
        $newKeywords = $this->implodeValues($newKeywords);
        return $this->setMeta($name, $newKeywords);
    }

    /**
     * @param string $name
     * @param string[]|string $values
     * @return self
     */
    public function setMetaArrayItems(string $name, $values): self {
        $values = $this->getPlainValueArray($values);
        $this->setMeta($name);
        return $this->addMetaArrayItems($name, $values);
    }

    /**
     * @param string $name
     * @return string[]
     */
    public function getMetaArrayItems(string $name): array {
        $values = $this->getMeta($name);
        return $this->explodeValues($values);
    }

    /**
     * @param string $author
     * @return self
     */
    public function setAuthor(string $author): self {
        $this->setMeta(self::META_AUTHOR, $author);
        return $this; //fluent interface
    }

    /**
     * @return string
     */
    public function getAuthor(): string {
        return $this->getMeta(self::META_AUTHOR);
    }

    /**
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self {
        $this->setMeta(self::META_DESCRIPTION, $description);
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->getMeta(self::META_DESCRIPTION);
    }

    /**
     * @param array|string $keywords
     * @return self
     */
    public function addKeywords($keywords): self {
        $this->addMetaArrayItems(self::META_KEYWORDS, $keywords);
        return $this;
    }

    public function getKeywords() {
        return $this->getMeta(self::META_KEYWORDS);
    }

    public function setRobots($robots): self {
        $this->setMeta(self::META_ROBOTS, $robots);
        return $this;
    }

    public function getRobots() {
        return $this->getMeta(self::META_ROBOTS);
    }

    /**
     * @param string $value
     * @return self
     */
    public function setContentType(string $value): self {
        $this->setMeta(self::META_CONTENT_TYPE, $value);
        return $this;
    }

    /**
     * @return string
     */
    public function getContentType(): string {
        return $this->getMeta(self::META_CONTENT_TYPE);
    }

    /**
     * @param string $value
     * @return self
     */
    public function setCharset(string $value): self {
        $this->setMeta(self::META_CHARSET, $value);
        return $this;
    }

    /**
     * @return string
     */
    public function getCharset(): string {
        return $this->getMeta(self::META_CHARSET);
    }

    /**
     * @param int $seconds
     * @return self
     */
    public function setRefresh(int $seconds): self {
        $this->setMeta(self::META_REFRESH, (string)$seconds);
        return $this;
    }

    /**
     * @return int
     */
    public function getRefresh(): int {
        return $this->getMeta(self::META_REFRESH);
    }

    /**
     * @param $name
     * @return bool
     */
    protected function isHttpEquiv(string $name): bool {
        return in_array($name, [
            self::META_REFRESH,
            self::META_CONTENT_TYPE,
            self::META_DEFAULT_STYLE
        ]);
    }

    /**
     * @param $name
     * @return bool
     */
    protected function isCharset(string $name): bool {
        return $name === self::META_CHARSET;
    }

    public function render() {
        foreach ($this->getMetas() as $name => $content) {
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

    public function renderCharsetMeta(string $name, string $content) {
        echo Html::el('meta', [
                $name => $content
            ]) . "\n";
    }

    public function renderHttpEquivMeta(string $name, string $content) {
        echo Html::el('meta', [
                'http-equiv' => $name,
                'content' => $content
            ]) . "\n";
    }

    public function renderMeta(string $name, string $content) {
        echo Html::el('meta', [
                'name' => $name,
                'content' => $content
            ]) . "\n";
    }
}
