<?php

namespace Stopka\Assetor\DI;

use Nette\Configurator;
use Nette\DI\Compiler;
use Nette\DI\CompilerExtension;
use Nette\DI\Config\Helpers;
use Nette\DI\ServiceDefinition;
use Stopka\Assetor\Collector\AssetCollectionGroupFactory;
use Stopka\Assetor\Collector\AssetsCollector;
use Stopka\Assetor\Control\Head\CssAssetControl;
use Stopka\Assetor\Control\Head\IIconControlFactory;
use Stopka\Assetor\Control\Head\IMetaControlFactory;
use Stopka\Assetor\Control\Head\ITitleControlFactory;
use Stopka\Assetor\Control\Head\JsAssetControl;
use Stopka\Assetor\Package\PackageFactory;
use Stopka\Assetor\Control\IHeadControlFactory;
use Stopka\Assetor\Control\IHtmlControlFactory;

/**
 * Class for register extension AssetsCollector.
 *
 * @author Roman Mátyus
 * @copyright (c) Roman Mátyus 2012
 * @license MIT
 */
class AssetorExtension extends CompilerExtension {
    const SERVICE_GROUP_FACTORY = 'groupFactory';
    const SERVICE_PACKAGE_FACTORY = 'packageFactory';
    const SERVICE_COLLECTOR = 'collector';
    const SERVICE_TITLE_CONTROL_FACTORY = 'titleControlFactory';
    const SERVICE_META_CONTROL_FACTORY = 'metaControlFactory';
    const SERVICE_ICON_CONTROL_FACTORY = 'iconControlFactory';
    const SERVICE_HTML_CONTROL_FACTORY = 'htmlControlFactory';
    const SERVICE_HEAD_CONTROL_FACTORY = 'headControlFactory';

    const CONF_GROUP = 'group';
    const CONF_TITLE = 'title';
    const CONF_ICON = 'icon';
    const CONF_META = 'meta';
    const CONF_PACKAGES = 'packages';

    const CONF_WEBTEMP = 'webTemp';
    const CONF_WWWDIR = 'wwwDir';

    /**
     * @return array
     */
    private function getDefaultConfig() {
        return [
            self::CONF_GROUP => [CssAssetControl::GROUP_ID,JsAssetControl::GROUP_ID],
            self::CONF_TITLE => null,
            self::CONF_ICON => null,
            self::CONF_META => [],
            self::CONF_PACKAGES => [],

            self::CONF_WEBTEMP => $_SERVER['DOCUMENT_ROOT'] . '/webtemp',
            self::CONF_WWWDIR => $_SERVER['DOCUMENT_ROOT'],
        ];
    }

    /**
     * @return array
     */
    protected function getMergedConfig() {
        return Helpers::merge($this->getConfig(), $this->getDefaultConfig());
    }

    /**
     * Method setings extension.
     */
    public function loadConfiguration() {
        $builder = $this->getContainerBuilder();

        $config = $this->getMergedConfig();

        /*$builder->addDefinition($this->prefix('cssSimpleMinificator'))
            ->setClass('RM\AssetsCollector\Compilers\CssSimpleMinificator');

        $builder->addDefinition($this->prefix('imageToDataStream'))
            ->setClass('RM\AssetsCollector\Compilers\ImageToDataStream')
            ->addSetup('$cssPath', array($config['cssPath']))
            ->addSetup('$wwwDir', array($config['wwwDir']))
            ->addSetup('$maxSize', array($config['maxSize']));

        $builder->addDefinition($this->prefix('imageReplacer'))
            ->setClass('RM\AssetsCollector\Compilers\ImageReplacer')
            ->addSetup('$cssPath', array($config['cssPath']))
            ->addSetup('$wwwDir', array($config['wwwDir']))
            ->addSetup('$webTemp', array($config['webTemp']));

        $config = array_merge($config, array(
            'addCssCompiler' => array(
                '@' . $this->prefix('cssSimpleMinificator'),
                '@' . $this->prefix('imageToDataStream'),
                '@' . $this->prefix('imageReplacer'),
            ),
        ));
*/
        $builder->addDefinition($this->prefix(self::SERVICE_GROUP_FACTORY))
            ->setClass(AssetCollectionGroupFactory::class, $config[self::CONF_GROUP]);

        $builder->addDefinition($this->prefix(self::SERVICE_PACKAGE_FACTORY))
            ->setClass(PackageFactory::class, '@'.$this->prefix(self::SERVICE_GROUP_FACTORY));

        $builder->addDefinition($this->prefix(self::SERVICE_COLLECTOR))
            ->setClass(AssetsCollector::class, '@'.$this->prefix(self::SERVICE_PACKAGE_FACTORY))
            ->addSetup('registerPackages', $config[self::CONF_PACKAGES]);

        $builder->addDefinition($this->prefix(self::SERVICE_TITLE_CONTROL_FACTORY))
            ->setImplement(ITitleControlFactory::class)
            ->setArguments($config[self::CONF_TITLE]);

        $builder->addDefinition($this->prefix(self::SERVICE_META_CONTROL_FACTORY))
            ->setImplement(IMetaControlFactory::class)
            ->setArguments($config[self::CONF_META]);

        $builder->addDefinition($this->prefix(self::SERVICE_ICON_CONTROL_FACTORY))
            ->setImplement(IIconControlFactory::class)
            ->setArguments($config[self::CONF_ICON]);

        $builder->addDefinition($this->prefix(self::SERVICE_HEAD_CONTROL_FACTORY))
            ->setImplement(IHeadControlFactory::class)
            ->addSetup('addComponentFactory','@'.$this->prefix(self::SERVICE_TITLE_CONTROL_FACTORY))
            ->addSetup('addComponentFactory','@'.$this->prefix(self::SERVICE_META_CONTROL_FACTORY))
            ->addSetup('addComponentFactory','@'.$this->prefix(self::SERVICE_ICON_CONTROL_FACTORY));

        $builder->addDefinition($this->prefix(self::SERVICE_HEAD_CONTROL_FACTORY))
            ->setImplement(IHtmlControlFactory::class);

        $self = $this;
        $registerToLatte = function (ServiceDefinition $def) use ($self) {
            $def
                ->addSetup('?->onCompile[] = function($engine) { RM\AssetsCollector\Latte\JsCssMacros::install($engine->getCompiler()); }', array('@self'));
        };

        if ($builder->hasDefinition('nette.latteFactory')) {
            $registerToLatte($builder->getDefinition('nette.latteFactory'));
        }

        if ($builder->hasDefinition('nette.latte')) {
            $registerToLatte($builder->getDefinition('nette.latte'));
        }
    }

    /**
     * Register AssetsCollector to application.
     * @param \Nette\Configurator $config
     */
    public static function register(Configurator $config) {
        $config->onCompile[] = function (Configurator $config, Compiler $compiler) {
            $compiler->addExtension('assetsCollector', new AssetorExtension());
        };
    }
}
