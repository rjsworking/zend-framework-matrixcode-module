<?php
/**
 * Thanks to Paul Bourke http://local.wasp.uwa.edu.au/~pbourke/dataformats/postscript/
 *
 */


class Zend_Matrixcode_Renderer_Eps extends Zend_Matrixcode_Renderer_Abstract
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
    	
    	// convert a hexadecimal color code into decimal eps format (green = 0 1 0, blue = 0 0 1, ...)
  		list($r,$g,$b) = str_split($this->_symbolColor,2);
  		$epsSymbolColor = round((hexdec($r)/255),5).' '.round((hexdec($g)/255),5).' '.round((hexdec($b)/255),5);
    		
    	$output = 
    	'%!PS-Adobe EPSF-3.0'."\n".
    	'%%Creator: Zend_Matrixcode_Qrcode'."\n".
		'%%Title: QRcode'."\n".
		'%%CreationDate: '.date('Y-m-d')."\n".
		'%%DocumentData: Clean7Bit'."\n".
		'%%LanguageLevel: 2'."\n".
		'%%Pages: 1'."\n".
		'%%BoundingBox: 0 0 '.$output_size.' '.$output_size."\n";
		
		// set the scale
		$output .= $this->_scale.' '.$this->_scale.' scale'."\n";
		// position the center of the coordinate system
		$output .= $this->_padding.' '.$this->_padding.' translate'."\n";
		
		// redefine the 'rectfill' operator to shorten the syntax
		$output .= '/F { rectfill } def'."\n";
		// set the symbol color
		$output .= $epsSymbolColor.' setrgbcolor'."\n";
  		
  		
  		// Convert the matrix into pixels
		for($i=0; $i<$matrix_dimension; $i++) {
		    for($j=0; $j<$matrix_dimension; $j++) {
		    	if( (isset($this->_patternMatrix[$i][$j]) && $this->_patternMatrix[$i][$j]) || ($this->_dataMatrix[$i][$j] & $this->_maskPattern) ) {
		    		$x = $i;
		    		$y = $matrix_dimension - 1 - $j;
		    		$output .= $x.' '.$y.' 1 1 F'."\n";
		        }
		    }
		}
		
    	$output .=
    	'%%EOF';
		
		return $output;
	}
	
	
	public function setIcon ()
	{
		
	}
	
	
	public function addText ()
	{
		
	}
}