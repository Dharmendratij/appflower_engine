<?php
/**
 * extJs Toolbar Menu Item
 */
class ImmExtjsToolbarMenuItem extends ImmExtjsToolbarComponent
{
	public $attributes=array();
	
	public $immExtjs=null;	
	public $containerObject=null;		
							
	public function __construct($containerObject,$attributes=array())
	{		
		$this->immExtjs=ImmExtjs::getInstance();
		
		if(isset($attributes['label']))
		{
			$this->attributes['text']=$attributes['label'];
			
			unset($attributes['label']);
		}
		
		if(isset($attributes['url']))
		{
			$this->attributes['handler']=$this->immExtjs->asMethod(array(
  									'parameters'=>'',
  									'source'=>'window.location.href="'.$attributes['url'].'";'
  								));
			
			unset($attributes['url']);
		}
		
		parent::__construct($containerObject,$attributes);
	}
	
	public function addMember($item)
	{
		$this->attributes['menu']=$this->immExtjs->asAnonymousClass($item);		
	}
}
?>