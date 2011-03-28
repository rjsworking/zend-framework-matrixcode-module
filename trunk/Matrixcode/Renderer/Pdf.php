<?php



class Zend_Matrixcode_Renderer_Pdf extends Zend_Matrixcode_Renderer_Abstract
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
    		
    	$pdf = new Zend_Pdf();
    	$pdf->pages[] = ($page = $pdf->newPage('A4'));
    	
    	// Add credits
    	$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 10)
      		 ->setFillColor(Zend_Pdf_Color_Html::color('#000000'))
      		 ->drawText('created by http://qr.InThePocket.mobi', 20, 20);
      	
      		 	 
    	$page_width  = $page->getWidth();
		$page_height = $page->getHeight();
		// Move center of coordination system (by default the lower left corner)
		$page->translate(floor($page_width - $output_size) / 2, ($page_height - $output_size) / 2);
		
		$symbolcolor = new Zend_Pdf_Color_HTML('#'.$this->_symbolColor);
		if(!empty($this->_backgroundColor)) {
			$backgroundcolor = new Zend_Pdf_Color_HTML('#'.$this->_backgroundColor);
			$page->setFillColor($backgroundcolor);
			$page->drawRectangle(0,0,$output_size,$output_size,Zend_Pdf_Page::SHAPE_DRAW_FILL);
		}
		
		$page->setFillColor($symbolcolor);
		
		// Convert the matrix into pixels
		for($i=0; $i<$matrix_dimension; $i++) {
		    for($j=0; $j<$matrix_dimension; $j++) {
		    	if( (isset($this->_patternMatrix[$i][$j]) && $this->_patternMatrix[$i][$j]) || ($this->_dataMatrix[$i][$j] & $this->_maskPattern) ) {
		    		$x = ($i + $this->_padding) * $this->_scale;
		    		$y = ($matrix_dimension - 1 - $j + $this->_padding) * $this->_scale;
		    		$page->drawRectangle($x, $y, $x + $this->_scale, $y + $this->_scale, Zend_Pdf_Page::SHAPE_DRAW_FILL);
		        }
		    }
		}
		
		return $pdf->render();
	}
	
	
	public function setIcon ()
	{
		
	}
	
	
	public function addText ()
	{
		
	}
}