<?php use TypistTech\Imposter\Plugin\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantTo('see all imposter commands in $composer list');

$I->runShellCommand('composer list');
$I->canSeeInShellOutput('imposter:run');
