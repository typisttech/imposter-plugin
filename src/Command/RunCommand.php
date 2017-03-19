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
        $this->setName('imposter:run');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Executing imposter:run');
    }
}
