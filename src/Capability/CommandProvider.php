<?php

declare(strict_types=1);

namespace TypistTech\Imposter\Plugin\Capability;

use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use TypistTech\Imposter\Plugin\Command\RunCommand;

class CommandProvider implements CommandProviderCapability
{
    public function getCommands(): array
    {
        return [new RunCommand()];
    }
}
