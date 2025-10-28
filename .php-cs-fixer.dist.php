<?php


$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        'php_unit_strict' => false,
        'php_unit_data_provider_static' => false,
        'phpdoc_to_comment' => false,
        'declare_strict_types' => true,
        'ordered_interfaces' => true,
        'static_lambda' => false,
    ])
    ->setFinder($finder);
