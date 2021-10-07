<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'yoda_style' => false,
        'concat_space' => ['spacing' => 'one'],
        'array_syntax' => ['syntax' => 'short'],
        'phpdoc_order' => true,
        'no_superfluous_phpdoc_tags' => true,
        'phpdoc_align' => false,
        'class_attributes_separation' => true,
    ])
    ->setFinder($finder);
