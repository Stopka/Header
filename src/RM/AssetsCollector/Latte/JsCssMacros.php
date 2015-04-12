<?php
namespace RM\AssetsCollector\Latte;

use Latte\Macros\MacroSet;
use Latte\Compiler;

/**
 * Class defined macros for AssetsCollector.
 *
 * @author Roman Mátyus
 * @copyright (c) Roman Mátyus 2012
 * @license MIT
 */
class JsCssMacros extends MacroSet
{
	/**
	 * Method install macros.
	 * @param	compiler Nette\Latte\Compiler
	 */
	public static function install(Compiler $compiler)
	{
		$macroSet = new static($compiler);
		$macroSet->addMacro('css', '$presenter->getService(\'assetsCollector.collector\')->addCss(%node.array,dirname(($presenter->template->getFile()===$template->getFile())?$presenter->template->getFile():$template->getFile()));');
		$macroSet->addMacro('js', '$presenter->getService(\'assetsCollector.collector\')->addJs(%node.array,dirname(($presenter->template->getFile()===$template->getFile())?$presenter->template->getFile():$template->getFile()));');
		$macroSet->addMacro('pack', '$presenter->getService(\'assetsCollector.collector\')->addPackages(%node.array)');
		$macroSet->addMacro('cssContent', 'ob_start()','$content = ob_get_contents(); ob_end_clean(); $presenter->getService(\'assetsCollector.collector\')->addCssContent($content,dirname(($presenter->template->getFile()===$template->getFile())?$presenter->template->getFile():$template->getFile()));');
		$macroSet->addMacro('jsContent', 'ob_start()','$content = ob_get_contents(); ob_end_clean(); $presenter->getService(\'assetsCollector.collector\')->addJsContent($content,dirname(($presenter->template->getFile()===$template->getFile())?$presenter->template->getFile():$template->getFile()));');
	}
}