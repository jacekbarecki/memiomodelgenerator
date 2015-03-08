<?php
    require_once 'bootstrap.php';

    //1. Init Twig
    $twigLoaderFilesystem = new Twig_Loader_Filesystem('vendor/gnugat/medio/templates');
    $twigEnvironment = new Twig_Environment($twigLoaderFilesystem, []);

    //2. Init Medio
    $medioPrettyPrinter = new \Gnugat\Medio\PrettyPrinter($twigEnvironment);

    //3. Generate classes
    $generator = new ModelGenerator($medioPrettyPrinter);
    echo '<pre>' . $generator->getModelsCode() . '</pre>';
