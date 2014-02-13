<?php

class C5Twig
{
    private $functions;
    private $c;
    private $view;
    
    function __construct( $viewClass )
    {
        $this->view = $viewClass;
        $this->c = $this->view->c;
        
        $this->functions = array(
            'Area'              => 'makeArea',
            'GlobalArea'       => 'makeGlobalArea',
            'getStyleSheet'   => 'getStyleSheet',
            'getScript'        => 'getScript'
        );
    }
    
    public function getFunctions()
    {
        return $this->functions;
    }
    
    public function makeGlobalArea( $name, $bloglimit = null )
    {
        $a = new GlobalArea( $name );
        
        if( isset($bloglimit) )
        {
            $a->setBlockLimit( $blocklimit );
        }
        
        $a->display( $this->c );
    }
    
    public function makeArea( $name, $bloglimit = null )
    {
        $a = new Area( $name );
        
        if( isset($bloglimit) )
        {
            $a->setBlockLimit( $blocklimit );
        }
        
        $a->display( $this->c );
    }
    
    public function getStyleSheet( $relative_path, $is_editable = false )
    {
        if( $is_editable )
        {
            return $this->view->getStyleSheet( $relative_path );
        }
        else
        {
            return $this->view->getThemePath() . '/' . $relative_path;
        }
    }
    
    public function getScript( $relative_path )
    {
        return $this->view->getThemePath() . '/' . $relative_path;
    }
    
}
