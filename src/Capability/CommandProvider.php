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

namespace TypistTech\Imposter\Plugin\Capability;

use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use TypistTech\Imposter\Plugin\Command\RunCommand;

class CommandProvider implements CommandProviderCapability
{
    public function getCommands()
    {
        return [new RunCommand];
    }
}
