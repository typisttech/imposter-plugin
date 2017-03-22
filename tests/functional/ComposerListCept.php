<?php use TypistTech\Imposter\Plugin\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantTo('see all imposter commands in $composer list');

$I->runShellCommand('composer list --no-interaction --no-ansi');
$I->seeInShellOutput('imposter:run');
$I->seeInShellOutput('Transform all required packages\' namespaces into yours');
