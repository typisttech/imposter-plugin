<?php use TypistTech\Imposter\Plugin\FunctionalTester;

$expectComposerV1 = (bool) getenv('EXPECT_COMPOSER_V1');
$expectedComposerMajorVersion = $expectComposerV1 ? 'Composer version 1.10.' : 'Composer 2.';

$I = new FunctionalTester($scenario);
$I->wantToTest("we are testing against ${expectedComposerMajorVersion}");

$I->runComposerCommand('--version --no-ansi');

$I->seeInShellOutput($expectedComposerMajorVersion);

