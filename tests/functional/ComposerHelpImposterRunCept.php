<?php use TypistTech\Imposter\Plugin\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantToTest('$ composer help imposter:run');

$I->runShellCommand('composer help imposter:run --no-ansi');

$I->seeInShellOutput('The imposter:run command goes through all required packages\' autoload-ed files, and');
$I->seeInShellOutput('prefixes all namespaces with yours, as defined as extra.imposter.namespace in composer.json');
