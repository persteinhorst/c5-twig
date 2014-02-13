<?php

//Composer Autoloader
require_once __DIR__ . '/vendor/autoload.php';

class TwigTemplates
{

    private static $view;
    
    public function getViewClass( $view_class )
    {
        self::$view = $view_class;
    }

    public function renderTemplates( $pageContent )
    {

        $loader = new Twig_Loader_String();
        $twig = new Twig_Environment($loader);
        
        $c5_twig = new C5Twig( self::$view );
        $functions = $c5_twig->getFunctions();
        
        foreach( $functions as $name => $method )
        {
            $function = new Twig_SimpleFunction( $name, array( $c5_twig, $method ) );
            $twig->addFunction($function);
        } 
        
        return $twig->render( $pageContent, array('name' => 'Fabien'));
    }
}