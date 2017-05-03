<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 21.4.17
 * Time: 16:41
 */

namespace Stopka\Assetor\Asset;

/**
 * Asset as a standalone file
 *
 * @author Štěpán Škorpil
 * @license MIT
 */
class FileAsset extends BaseAsset {
    /** @var  string */
    private $file;

    public function __construct(string $file) {
        $this->setFile($file);
    }


    /**
     * @param string $file
     * @return FileAsset
     */
    public function setFile(string $file): self{
        $this->file = $file;
        return $this;
    }

    /**
     * @return string
     */
    public function getFile(): string {
        return $this->file;
    }
}