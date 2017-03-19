<?php

declare(strict_types = 1);

namespace TypistTech\Imposter\Plugin\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Composer\Command\BaseCommand;

class RunCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('imposter:run')
            ->setAliases(['imposter'])
            ->setDescription("Transform all required packages' namespaces into yours")
            ->setHelp(<<<EOT
The <info>imposter:run</info> command goes through all required packages' autoload-ed files, and
prefixes all namespaces with yours, as defined as <info>extra.imposter.namespace</info> in composer.json
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Executing imposter:run');
    }
}
