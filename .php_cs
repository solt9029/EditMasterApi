<?php

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
    ])
    ->setFinder(PhpCsFixer\Finder::create()
        ->exclude('src/vendor')
        ->exclude('src/public/hot')
        ->exclude('src/public/storage')
        ->exclude('src/storage')
        ->exclude('src/bootstrap/cache')
        ->in(__DIR__)
        ->name('*.php')
        ->notName('*.blade.php')
    )
;
