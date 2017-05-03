<?php

namespace Stopka\Assetor\Control;

use Imagick;
use ImagickPixel;
use Nette\Caching\Cache;
use Nette\Utils\Image;


/*
 * @copyright (c) Roman Mátyus
 * @license MIT
 * @package HeaderControl
 */
class Icon implements IIcon
{

	const PNG = 'png';

	/** @var string  */
	protected $webTemp;

	/** @var string */
	protected $wwwDir;

	/** @var string */
	protected $source;

	/** @var Cache */
	protected $cache;

	/** @var [] */
	protected $config;


	public function __construct(string $webTemp, string $wwwDir, string $source, Cache $cache, array $config = NULL)
	{
		$this->webTemp = $webTemp;
		$this->wwwDir = $wwwDir;
		$this->source = $source;
		$this->cache = $cache;
		$this->config = $config;
	}

	public function setTitle(string $title) : Icon
	{

		return $this;
	}

	public function __toString()
	{
		return $this->getString();
	}

	public function getString() : string
	{
		//$cacheKey = md5(serialize($this->config) . $this->source);
		$s = '<link rel="apple-touch-icon" sizes="180x180" href="' . $this->getImage(180) . '">' . "\n"
			. '<link rel="icon" type="image/png" href="' . $this->getImage(32) . '" sizes="32x32">' . "\n"
			. '<link rel="icon" type="image/png" href="' . $this->getImage(16) . '" sizes="16x16">' . "\n";
		foreach ($this->config['meta'] as $name => $content) {
			$s .= '<meta name="' . $name . '" content="' . $content . '">' . "\n";
		}
		return $s;
	}

	public function getImage(int $size, string $format = self::PNG) : string
	{
		$info = pathinfo($this->source);
		$outputName = $this->webTemp . DIRECTORY_SEPARATOR . $info['filename'] . '-' . $size . 'x' . $size . '.' . $format;

		switch ($info['extension']) {
			case 'svg':
				$source = new Imagick;
				$source->setBackgroundColor(new ImagickPixel('transparent'));
				$source->readImageBlob(file_get_contents($this->source));
				$source->resizeImage($size, $size, Imagick::FILTER_LANCZOS, 1);
				if ($format === self::PNG) {
					$source->setImageFormat("png32");
				}
				$source->writeImage($outputName);
				$source->clear();
				$source->destroy(); 
				break;
			case 'ico':
				$source = new Imagick($this->source);
				$source->resizeImage($size, $size, Imagick::FILTER_LANCZOS, 1);
				$source->writeImage($outputName);
				$source->clear();
				$source->destroy(); 
				break;
			default:
				$image = Image::fromFile($this->source);
				$image->resize($size, $size);
				$image->save($outputName);
				break;
		}

		return str_replace($this->wwwDir, '', $outputName);
	}
}
