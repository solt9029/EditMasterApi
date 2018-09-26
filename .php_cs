<?php

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
    ])
    ->setFinder(PhpCsFixer\Finder::create()
        ->exclude('vendor')
        ->exclude('public/hot')
        ->exclude('public/storage')
        ->exclude('storage/*.key')
        ->in(__DIR__)
        ->name('*.php')
        ->notName('*.blade.php')
    )
;
