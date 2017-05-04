<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 21.4.17
 * Time: 16:41
 */

namespace Stopka\Assetor\Asset;

/**
 * Asset as direct content
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class ContentAsset extends BaseAsset {
    /** @var  string */
    private $content;

    public function __construct(string $content) {
        $this->setContent($content);
    }


    /**
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): self {
        $this->content = $content;
        return $this;
    }

}