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
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use TypistTech\Imposter\ImposterFactory;
use TypistTech\Imposter\Plugin\Capability\CommandProvider as ImposterCommandProvider;
use TypistTech\Imposter\Plugin\Command\RunCommand;

class ImposterPlugin implements PluginInterface, Capable, EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     * * The method name to call (priority defaults to 0)
     * * An array composed of the method name to call and the priority
     * * An array of arrays composed of the method names to call and respective
     *   priorities, or 0 if unset
     *
     * For instance:
     *
     * * array('eventName' => 'methodName')
     * * array('eventName' => array('methodName', $priority))
     * * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ScriptEvents::POST_INSTALL_CMD  => [
                ['runImposter', 10],
            ],
            ScriptEvents::POST_UPDATE_CMD   => [
                ['runImposter', 10],
            ],
            ScriptEvents::PRE_AUTOLOAD_DUMP => [
                ['runImposter', 10],
            ],
        ];
    }

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
        $package  = $composer->getPackage();
        $autoload = $package->getAutoload();

        $imposter = ImposterFactory::forProject(getcwd(), ['typisttech/imposter-plugin']);

        array_merge_recursive($autoload, ['classmap' => $imposter->getAutoloads()]);
        $package->setAutoload($autoload);
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
    public function getCapabilities(): array
    {
        return [
            CommandProvider::class => ImposterCommandProvider::class,
        ];
    }

    /**
     * @param Event $event
     *
     * @return void
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function runImposter(Event $event)
    {
        $io = $event->getIO();
        $io->write('Running Imposter...');

        $command = new RunCommand;
        $command->run(new ArrayInput([]), new NullOutput);

        $io->write('Done.');
    }
}
