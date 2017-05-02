<?php

namespace Stopka\Assetor\Control\Head;

use Nette\Application\UI\Control;
use Nette\FileNotFoundException;
use Nette\Utils\Html;
use Stopka\Assetor\Control\IIcon;
use Stopka\Assetor\Control\IIconFactory;

/**
 *
 * @author Štěpán Škorpil
 * @copyright (c) Štěpán Škorpil 2017
 * @license MIT
 * @package HeaderControl
 */
class IconControl extends Control {

    /** @var IIcon */
    private $favicon;

    /** @var IIconFactory */
    private $iconFactory;

    public function __construct(IIconFactory $iconFactory = NULL) {
        $this->iconFactory = $iconFactory;
    }

    /**
     * @param string $filename
     */
    public function setFavicon($filename) {
        foreach ([
                     $filename,
                     __DIR__ . DIRECTORY_SEPARATOR . $filename,
                     $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $filename,
                 ] as $path) {
            if (file_exists($path)) {
                $this->favicon = ($this->iconFactory instanceof IIconFactory)
                    ? $this->iconFactory->create(realpath($path))->setTitle((string)$this->getTitle())
                    : realpath($path);
                return $this;
            }
        }
        throw new FileNotFoundException('Favicon ' . $_SERVER['DOCUMENT_ROOT'] . $filename . ' not found.');
    }

    public function getFavicon() {
        return $this->favicon;
    }

    public function render() {
        if ($this->favicon === NULL) {
            try {
                $this->setFavicon('/favicon.ico');
            } catch (FileNotFoundException $e) {
            }
        }

        if (is_string($this->favicon)) {
            echo Html::el('link')->rel('shortcut icon')
                    ->href($this->favicon) . "\n";
        } elseif ($this->favicon instanceof IIcon) {
            echo $this->favicon;
        }
    }
}
