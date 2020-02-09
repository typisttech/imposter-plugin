<?php

declare(strict_types=1);

namespace TypistTech\Imposter\Plugin\Command;

use Composer\Command\BaseCommand;
use Composer\IO\NullIO;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TypistTech\Imposter\ImposterFactory;

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
        $io = $this->getIO();
        $imposter = ImposterFactory::forProject(getcwd(), ['typisttech/imposter-plugin']);

        // Print an empty line to separate imposter outputs.
        $io->write('', true);
        $io->write('<info>Running Imposter...</info>', true);
        $io->write('<info>======================</info>', true);
        $io->write('Loading package information from <info>' . getcwd() . '/composer.json</info>', true);

        $autoloads = $imposter->getAutoloads();
        $count = count($autoloads);

        $io->write('', true);
        $io->write("Imposter operations: <info>$count</info> transformations", true);

        foreach ($autoloads as $autoload) {
            $io->write(" - Transforming: <comment>$autoload</comment>", true);
            $imposter->transform($autoload);
        }

        // Print empty lines to separate imposter outputs.
        $io->write('', true);
        $io->write('<info>Success: Imposter transformed vendor files.</info>', true);
        $io->write('', true);
    }
}
