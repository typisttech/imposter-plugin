<?php
/**
 * Imposter Plugin
 *
 * Composer plugin that wraps all composer vendor packages inside your own namespace.
 * Intended for WordPress plugins.
 *
 * @package   TypistTech\Imposter\Plugin
 * @author    Typist Tech <imposter-plugin@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   MIT
 * @see       https://www.typist.tech/projects/imposter-plugin
 */

declare(strict_types=1);

namespace TypistTech\Imposter\Plugin;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\CompletePackage;
use Composer\Package\RootPackageInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;
use RuntimeException;
use TypistTech\Imposter\ImposterFactory;
use TypistTech\Imposter\Plugin\Capability\CommandProvider as ImposterCommandProvider;

class ImposterPlugin implements PluginInterface, Capable
{
    /**
     * Apply plugin modifications to Composer
     *
     * @param Composer    $composer
     * @param IOInterface $io
     *
     * @return void
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $package = $composer->getPackage();

        if ($package instanceof CompletePackage) {
            $this->addScriptsTo($package);
        }

        if ($package instanceof RootPackageInterface) {
            $this->addAutoloadTo($package);
        }
    }

    /**
     * @param $package
     *
     * @return void
     */
    private function addScriptsTo(CompletePackage $package)
    {
        $scripts = $package->getScripts();
        $scripts = array_merge_recursive($scripts, $this->getScripts());

        $package->setScripts($scripts);
    }

    private function getScripts() : array
    {
        return [
            ScriptEvents::POST_INSTALL_CMD  => [
                '@composer dump-autoload -o',
            ],
            ScriptEvents::POST_UPDATE_CMD   => [
                '@composer dump-autoload -o',
            ],
            ScriptEvents::PRE_AUTOLOAD_DUMP => [
                '@composer imposter:run',
            ],
        ];
    }

    /**
     * @param $package
     *
     * @return void
     */
    private function addAutoloadTo(RootPackageInterface $package)
    {
        $autoload = $package->getAutoload();
        $autoload = array_merge_recursive($autoload, [ 'classmap' => $this->getImposterAutoloads() ]);

        $package->setAutoload($autoload);
    }

    /**
     * @todo Think of a better way to handle file not found during installation
     * @return array
     */
    private function getImposterAutoloads() : array
    {
        try {
            $imposter = ImposterFactory::forProject(getcwd(), [ 'typisttech/imposter-plugin' ]);

            return array_map(function ($path) {
                return str_replace(getcwd() . '/', '', $path);
            }, $imposter->getAutoloads());
        } catch (RuntimeException $exception) {
            return [];
        }
    }

    /**
     * Method by which a Plugin announces its API implementations, through an array
     * with a special structure.
     *
     * The key must be a string, representing a fully qualified class/interface name
     * which Composer Plugin API exposes.
     * The value must be a string as well, representing the fully qualified class name
     * of the implementing class.
     *
     * @tutorial
     *
     * return array(
     *     'Composer\Plugin\Capability\CommandProvider' => 'My\CommandProvider',
     *     'Composer\Plugin\Capability\Validator'       => 'My\Validator',
     * );
     *
     * @return string[]
     */
    public function getCapabilities() : array
    {
        return [
            CommandProvider::class => ImposterCommandProvider::class,
        ];
    }
}
