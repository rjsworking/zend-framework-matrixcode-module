# Demo code #
### application/controllers/TestController.php ###
```
<?php
class TestController extends Zend_Controller_Action
{
    public $code_params = array('text'            => 'http://www.google.com', 
                                'backgroundColor' => '#FFFFFF', 
                                'foreColor' => '#000000', 
                                'padding' => 4,  //array(10,5,10,5),
                                'moduleSize' => 8);
    
    
    public function demoAction ()
    {
        $this->_helper->layout()->disableLayout();
    }
    
    public function embeddedImageAction ()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $renderer_params = array('imageType' => 'png');
        Zend_Matrixcode::render('qrcode', $this->code_params, 'image', $renderer_params);
    }
    
    public function embeddedSvgAction ()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        Zend_Matrixcode::render('qrcode', $this->code_params, 'svg');
    }
    
    public function downloadAction ()
    {
        $type = $extension = $this->getRequest()->getParam('type', 'image');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        if ($type == 'image') {
            $renderer_params['imageType'] = 'png';
            $extension = 'png';
        } else if ($type == 'pdf') {
            $renderer_params['footnote'] = 'QR code demo';
        }
        $renderer_params['sendResult'] = array('Content-Disposition: attachment;filename="qrcode-demo.' . $extension . '"');
        Zend_Matrixcode::render('qrcode', $this->code_params, $type, $renderer_params);
    }
    
    public function saveImageAction ()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $renderer_params = array('imageType' => 'png', 'sendResult' => false);
        
        $res = Zend_Matrixcode::render('qrcode', $this->code_params, 'image', $renderer_params);
        imagepng($res, realpath(APPLICATION_PATH . '/../public/tmp') . DIRECTORY_SEPARATOR . 'qrcode_test.png');
    }
}
```

### application/views/scripts/test/demo.phtml ###
```
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>QR Demo</title>
<style type="text/css">
* { font-family: Arial; }
</style>

</head>


<body>

<h2>PNG format</h2>
<img src="/test/embedded-image" /><br />
<a href="/test/download/type/image">Download</a>

<h2>SVG format</h2>
<img src="/test/embedded-svg" /><br />
<a href="/test/download/type/svg">Download</a>

<h2>EPS format</h2>
<a href="/test/download/type/eps">Download</a>

<h2>PDF format</h2>
<a href="/test/download/type/pdf">Download</a>

</body>
</html>
```