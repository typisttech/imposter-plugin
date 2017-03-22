<?php

namespace TypistTech\Imposter\Plugin\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Lib\Interfaces\DependsOnModule;
use Codeception\Lib\Interfaces\RequiresPackage;
use Codeception\Module;
use Codeception\Module\Cli;
use Codeception\Module\Filesystem;
use Codeception\TestInterface;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class Functional extends Module implements DependsOnModule, RequiresPackage
{
    protected $config = [
        'composerInstallFlags' => '--no-interaction --quite',
        'symlink'              => 'true',
        'repositoryPaths'      => [],
    ];

    protected $dependencyMessage = <<<EOF
Example configuring ComposerProject.
--
modules:
    enabled:
        - \TypistTech\Imposter\Plugin\Helper\Functional:
            composerInstallFlags: '--no-interaction --quiet'
            projectRoot: 'tests/_data/fake-project'
            symlink: 'false'
            repositoryPaths:
                - 'tests/_data/dummy'
                - 'tests/_data/another-dummy'
            depends:
                - Cli
                - Filesystem
--
EOF;

    protected $requiredFields = ['projectRoot'];

    /**
     * @var Cli
     */
    private $cli;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $tmpProjectDir;

    /**
     * @param TestInterface $test
     *
     * @return void
     */
    public function _after(TestInterface $test)
    {
        $this->debugSection('ComposerProject', 'Deleting temporary directory...');

        $this->filesystem->deleteDir($this->tmpProjectDir);

        $this->debugSection('ComposerProject', 'Deleted temporary directory');
    }

    /**
     * @param TestInterface $test
     *
     * @return void
     */
    public function _before(TestInterface $test)
    {
        $this->createTmpProjectDir();
        $this->copyProjectRootToTmpProjectDir();

        $this->amInTmpProjectDir();

        $this->configComposerRepositoryPaths($this->_getConfig('repositoryPaths'));
        $this->runComposerInstall();
    }

    /**
     * @return void
     */
    private function createTmpProjectDir()
    {
        $this->debugSection('ComposerProject', 'Creating temporary directory...');

        $this->tmpProjectDir = (new TemporaryDirectory)->create()->path();

        $this->debugSection('ComposerProject', "Created temporary directory at $this->tmpProjectDir");
    }

    /**
     * @return void
     */
    private function copyProjectRootToTmpProjectDir()
    {
        $projectRoot = codecept_root_dir($this->_getConfig('projectRoot'));

        $this->debugSection('ComposerProject', "Project root is $projectRoot");
        $this->debugSection('ComposerProject', 'Copying project root to temporary directory');

        $this->filesystem->copyDir(
            $projectRoot,
            $this->tmpProjectDir
        );
    }

    /**
     * @retun void
     */
    public function amInTmpProjectDir()
    {
        $this->filesystem->amInPath($this->tmpProjectDir);
    }

    /**
     * @param array $paths
     *
     * @return void
     */
    private function configComposerRepositoryPaths(array $paths)
    {
        $paths = array_merge([''], $paths);

        array_map(function ($path, $index) {
            $command = sprintf(
                'config repositories.codeception%1$d \'{"type":"path","url":"%2$s","options":{"symlink":%3$s}}\'',
                $index,
                codecept_root_dir($path),
                $this->_getConfig('symlink')
            );

            $this->runComposerCommand($command);
        }, $paths, array_keys($paths));
    }

    /**
     * @param string $command
     * @param bool   $failNonZero
     *
     * @return void
     */
    public function runComposerCommand(string $command, bool $failNonZero = true)
    {
        $this->debug("> composer $command");
        $this->cli->runShellCommand("composer $command", $failNonZero);
    }

    /**
     * @void
     */
    public function runComposerInstall()
    {
        $this->runComposerCommand('install ' . $this->_getConfig('composerInstallFlags'));
    }

    public function _depends(): array
    {
        return [
            Cli::class        => $this->dependencyMessage,
            Filesystem::class => $this->dependencyMessage,
        ];
    }

    /**
     * @param Cli        $cli
     * @param Filesystem $filesystem
     *
     * @return void
     */
    public function _inject(Cli $cli, Filesystem $filesystem)
    {
        $this->cli        = $cli;
        $this->filesystem = $filesystem;
    }

    public function _requires(): array
    {
        return [
            TemporaryDirectory::class => '"spatie/temporary-directory": "^1.1"',
        ];
    }

    public function getTmpProjectDir(): string
    {
        return $this->tmpProjectDir;
    }
}
