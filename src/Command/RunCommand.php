<?php

declare(strict_types=1);

namespace TypistTech\Imposter\Plugin\Command;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TypistTech\Imposter\Plugin\Transformer;

class RunCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('imposter:run')
             ->setDescription("Transform all required packages' namespaces into yours")
             ->setHelp(<<<EOT
The <info>imposter:run</info> command goes through all required packages' autoload-ed files, and
prefixes all namespaces with yours, as defined as <info>extra.imposter.namespace</info> in composer.json
EOT
             );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        Transformer::run(
            $this->getIO()
        );
    }
}
