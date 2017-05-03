<?php

namespace Stopka\Assetor\Control\Head;

/**
 * @copyright (c) Roman Mátyus 2015
 * @license MIT
 * @package HeaderControl
 */
interface IMetaCollector {
    const META_CHARSET = 'charset';

    const META_REFRESH = 'refresh';
    const META_CONTENT_TYPE = 'content-type';
    const META_DEFAULT_STYLE = 'default-style';

    const META_KEYWORDS = 'keywords';
    const META_AUTHOR = 'author';
    const META_DESCRIPTION = 'description';
    const META_ROBOTS = 'robots';

    public function getMetas(): array;

    public function setMeta(string $name, ?string $value = null): self;

    public function getMeta(string $name): ?string;
}