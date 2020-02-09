<?php

declare(strict_types=1);

namespace TypistTech\Imposter\Plugin\Command;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TypistTech\Imposter\Imposter;
use TypistTech\Imposter\ImposterFactory;

class RunCommand extends BaseCommand
{
    /**
     * @var Imposter
     */
    private $imposter;

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
        // Print an empty line to separate imposter outputs.
        $output->writeln('');
        $output->writeln('');
        $output->writeln('<info>Running Imposter...</info>');
        $output->writeln('<info>======================</info>');
        $output->writeln('Loading package information from <info>' . getcwd() . '/composer.json</info>');

        $count = count($this->getAutoloads());
        $output->writeln("Imposter operations: <info>$count</info> transformations");

        $progressBar = new ProgressBar($output, $count);
        $progressBar->start();

        $autoloads = $this->getAutoloads();
        array_walk($autoloads, function ($autoload) use ($output, $progressBar) {
            $progressBar->clear();
            $output->writeln(" - Transforming: <comment>$autoload</comment>");
            $progressBar->display();

            $this->transform($autoload);

            $progressBar->advance();
        });

        $progressBar->finish();

        // Print empty lines to separate imposter outputs.
        $output->writeln('');
        $output->writeln('<info>Success: Imposter transformed vendor files.</info>');
        $output->writeln('');
        $output->writeln('');
    }

    /**
     * @return string[]
     */
    private function getAutoloads(): array
    {
        return $this->getImposter()->getAutoloads();
    }

    private function getImposter(): Imposter
    {
        if (null === $this->imposter) {
            $this->imposter = ImposterFactory::forProject(getcwd(), ['typisttech/imposter-plugin']);
        }

        return $this->imposter;
    }

    /**
     * @param string $autoload
     *
     * @return void
     */
    private function transform(string $autoload)
    {
        $this->getImposter()->transform($autoload);
    }
}
