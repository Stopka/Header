<?php

namespace Stopka\Assetor\Control\Head;

use Nette\Application\UI\Control;
use Nette\Utils\Html;
use Stopka\Assetor\Control\IIcon;

/**
 *
 * @author Štěpán Škorpil
 * @copyright (c) Štěpán Škorpil 2017
 * @license MIT
 * @package HeaderControl
 */
class IconControl extends Control implements IHeadComponent {

    /** @var IIcon */
    private $icon;

    public function __construct($defaultIcon) {
        parent::__construct();
        $this->setIcon($defaultIcon);
    }

    /**
     * @param string $filename
     * @return string[]
     */
    protected function getIconPathCandidates(string $filename): array {
        return [
            $filename,
            __DIR__ . DIRECTORY_SEPARATOR . $filename,
            $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $filename,
        ];
    }

    /**
     * @param string $filename
     */
    public function setIcon(string $filename) {
        $this->icon = $filename;
        /*foreach ($this->getIconPathCandidates($filename) as $pathCandidate) {
            if (file_exists($pathCandidate)) {
                $this->icon = ($this->iconFactory instanceof IIconFactory)
                    ? $this->iconFactory->create(realpath($pathCandidate))->setTitle((string)$this->getTitle())
                    : realpath($pathCandidate);
                return $this;
            }
        }
        throw new FileNotFoundException('Icon ' . $filename . ' not found.');*/
    }

    public function getIcon() {
        return $this->icon;
    }

    public function render() {
        $icon = $this->getIcon();
        echo Html::el('link', [
                'rel' => 'icon',
                'href' => $icon
            ]) . "\n";
        echo Html::el('link', [
                'rel' => 'icon',
                'sizes' => '192x192',
                'href' => $icon
            ]) . "\n";
        echo Html::el('link', [
                'rel' => 'apple-touch-startup-image',
                'href' => $icon
            ]) . "\n";
        echo Html::el('link', [
                'rel' => 'apple-touch-icon',
                'href' => $icon
            ]) . "\n";
    }
}
