<?php

class C5Twig
{
    private $functions;
    private $tests;
    
    private $c;
    private $view;
    
    function __construct( $viewClass )
    {
        $this->view = $viewClass;
        $this->c = $this->view->c;
        
        $this->functions = array(
            'Area'              => 'makeArea',
            'GlobalArea'        => 'makeGlobalArea',
            'GetStyleSheet'     => 'getStyleSheet',
            'GetScript'         => 'getScript',
            'Element'           => 'element'
        );
        
        $this->tests = array(
            'IsEditMode' => 'isEditMode'                     
        );
    }
    
    
    #===========================================================================
    #   GET METHODS
    #===========================================================================
    
    /**
     *  gets the Functions Array
     */
    public function getFunctions()
    {
        return $this->functions;
    }
    
    public function getTests()
    {
        return $this->tests;
    }
    
    #===========================================================================
    #   TWIG C5 FUNCTIONS
    #===========================================================================
    
    /**
     *  Concrete5 GlobalArea
     */
    public function makeGlobalArea( $name, $bloglimit = null )
    {
        $a = new GlobalArea( $name );
        
        if( isset($bloglimit) )
        {
            $a->setBlockLimit( $blocklimit );
        }
        
        $a->display( $this->c );
    }
    
    /**
     *  Concrete5 Area
     */
    public function makeArea( $name, $bloglimit = null )
    {
        $a = new Area( $name );
        
        if( isset($bloglimit) )
        {
            $a->setBlockLimit( $blocklimit );
        }
        
        $a->display( $this->c );
    }
    
    
    /**
     * get Stylesheet Paths
     * if $is_editable is set, concrete5 Edit Themes feature can
     * be used.
     */
    public function getStyleSheet( $relative_path, $is_editable = false )
    {
        ob_start();
        if( $is_editable )
        {
            echo $this->view->getStyleSheet( $relative_path );
        }
        else
        {
            echo $this->view->getThemePath() . '/' . $relative_path;
            
        }
        
        $path = ob_get_contents();
        ob_end_clean();
        
        echo sprintf('<link href="%s" rel="stylesheet">', $path );
    }
    
    
    /**
     *  Get Scripts Paths
     */
    public function getScript( $relative_path )
    {
        ob_start();
        echo $this->view->getThemePath() . '/' . $relative_path;
        
        $path = ob_get_contents();
        ob_end_clean();
        
        echo sprintf('<script src="%s"></script>', $path);
    }
    
    
    /**
     *  Use the concrete5 Loader::element Function in a Template Tag
     */
    public function element( $load )
    {
        // Closures Requires PHP >= 5.4.0
        $closure = function( $closure_load ){ echo Loader::element( $closure_load ); };
        
        // Changing $this context,
        // binding Loader::element to the View class
        $boundclosure = $closure->bindTo( $this->view );
        $boundclosure( $load );
    }
    
    #===========================================================================
    #   TWIG C5 TESTS
    #===========================================================================
    
    public function isEditmode()
    {
        return $this->c->isEditMode();
    }
    
}
