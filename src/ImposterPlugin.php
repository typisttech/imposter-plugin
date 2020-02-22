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
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => [
                ['transform', PHP_INT_MAX - 1000],
            ],
            ScriptEvents::POST_UPDATE_CMD => [
                ['transform', PHP_INT_MAX - 1000],
            ],
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
}
