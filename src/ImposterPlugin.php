<?php

declare(strict_types=1);

namespace TypistTech\Imposter\Plugin;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Package\RootPackageInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use RuntimeException;
use TypistTech\Imposter\ImposterFactory;

class ImposterPlugin implements PluginInterface, EventSubscriberInterface
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
        if ($package instanceof RootPackageInterface) {
            $this->addAutoloadTo($package);
        }
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ScriptEvents::PRE_AUTOLOAD_DUMP => [
                ['transform', PHP_INT_MAX - 1000],
            ],
        ];
    }

    public function transform(Event $event): void
    {
        Transformer::run(
            $event->getIO()
        );
    }

    /**
     * @param $package
     *
     * @return void
     */
    private function addAutoloadTo(RootPackageInterface $package)
    {
        $autoload = $package->getAutoload();
        $autoload = array_merge_recursive($autoload, ['classmap' => $this->getImposterAutoloads()]);

        $package->setAutoload($autoload);
    }

    /**
     * @return string[]
     * @todo Think of a better way to handle file not found during installation
     */
    private function getImposterAutoloads(): array
    {
        try {
            $imposter = ImposterFactory::forProject(getcwd(), ['typisttech/imposter-plugin']);

            return array_map(function ($path): string {
                return str_replace(getcwd() . '/', '', $path);
            }, $imposter->getAutoloads());
        } catch (RuntimeException $exception) {
            return [];
        }
    }
}
