<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
class TwigPackage extends Package {

	protected $pkgHandle = 'twig';
	protected $appVersionRequired = '5.6.1';
	protected $pkgVersion = '0.0.1';
	
    	
    public function on_start()
    {
        Events::extend('on_before_render', 'TwigTemplates', 'getViewClass', __DIR__ .'/libraries/twig/twig_templates.php');
        Events::extend('on_page_output', 'TwigTemplates', 'renderTemplates',  __DIR__ .'/libraries/twig/twig_templates.php');
    }
    
	public function getPackageDescription()
    {
		return t("Installs the Twig Template Engine for Concrete5");
	}
	
	public function getPackageName()
    {
		return t("Twig Template Engine");
	}
	
	public function install()
    {
		$pkg = parent::install();	
	}
	
	public function upgrade()
    {
		$pkg = Package::getByHandle('twig');

		parent::upgrade($pkg);
	}

}