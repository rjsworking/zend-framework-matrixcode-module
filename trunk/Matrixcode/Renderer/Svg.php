<?php



class Zend_Matrixcode_Renderer_Svg extends Zend_Matrixcode_Renderer_Abstract
{

	private $_maskPattern = 1;
	
	
	public function __construct($params)
	{
		parent::__construct($params);
		$this->_maskPattern = $params['mask_pattern'];
	}
	
	
	public function render()
	{
		$matrix_dimension = count($this->_dataMatrix);
    	$matrix_dim_with_padding = $matrix_dimension + 2*$this->_padding;
    	$output_size = $matrix_dim_with_padding * $this->_scale;
    		
    	$output = 
    	'<?xml version="1.0" encoding="utf-8"?>'."\n".
		'<svg version="1.1" baseProfile="full"  width="'.$output_size.'" height="'.$output_size.'" viewBox="0 0 '.$output_size.' '.$output_size.'"
		 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ev="http://www.w3.org/2001/xml-events">'."\n".
  		'<desc></desc>'."\n";
  		
  		if(!empty($this->_backgroundColor)) {
  			$output .= '<rect width="'.$output_size.'" height="'.$output_size.'" fill="#'.$this->_backgroundColor.'" cx="0" cy="0" />'."\n";
  		}
  		
  		$output .= 
  		'<defs>'."\n".
    	'<rect id="p" width="'.($this->_scale).'" height="'.($this->_scale).'" />'."\n".
  		'</defs>'."\n".
  		'<g fill="#'.$this->_symbolColor.'">'."\n";
  		
  		// Convert the matrix into pixels
		for($i=0; $i<$matrix_dimension; $i++) {
		    for($j=0; $j<$matrix_dimension; $j++) {
		    	if( (isset($this->_patternMatrix[$i][$j]) && $this->_patternMatrix[$i][$j]) || ($this->_dataMatrix[$i][$j] & $this->_maskPattern) ) {
		    		$x = ($i + $this->_padding) * $this->_scale;
		    		$y = ($j + $this->_padding) * $this->_scale;
		    		$output .= '<use x="'.$x.'" y="'.$y.'" xlink:href="#p" />'."\n";
		        }
		    }
		}
		
		$output .= 
		'</g>'."\n".
    	'</svg>';
		
		return $output;
	}
	
	
	public function setIcon ()
	{
		
	}
	
	
	public function addText ()
	{
		
	}
}