<?php
    require_once 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

    //1. Init Twig
    $twigLoaderFilesystem = new Twig_Loader_Filesystem('vendor/memio/memio/templates');
    $twigEnvironment = new Twig_Environment($twigLoaderFilesystem, []);

    //2. Init Memio
    $memioPrettyPrinter = new \Memio\Memio\PrettyPrinter($twigEnvironment);

    //3. Generate classes
    $generator = new \JacekB\MemioModelGenerator\ModelGenerator($memioPrettyPrinter);
    echo '<pre>' . $generator->getModelsCode() . '</pre>';
