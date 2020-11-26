<?php

declare(strict_types=1);

namespace TypistTech\Imposter\Plugin;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Package\CompletePackage;
use Composer\Package\RootPackageInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;

class ImposterPlugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $package = $composer->getPackage();
        if ($package instanceof RootPackageInterface) {
            AutoloadMerger::run($package);
        }

        if ($package instanceof CompletePackage) {
            $scripts = array_merge_recursive([
                ScriptEvents::POST_INSTALL_CMD => [
                    '@composer dump-autoload --optimize',
                ],
                ScriptEvents::POST_UPDATE_CMD => [
                    '@composer dump-autoload --optimize',
                ],
            ], $package->getScripts());

            $package->setScripts($scripts);
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

    public function deactivate(Composer $composer, IOInterface $io)
    {
        // Do nothing.
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        // Do nothing.
    }
}
