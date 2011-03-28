<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to version 1.0 of the Zend Framework
 * license, that is bundled with this package in the file LICENSE.txt, and
 * is available through the world-wide-web at the following URL:
 * http://framework.zend.com/license/new-bsd. If you did not receive
 * a copy of the Zend Framework license and are unable to obtain it
 * through the world-wide-web, please send a note to license@zend.com
 * so we can mail you a copy immediately.
 *
 * @package    Zend_Matrixcode
 * @copyright  Copyright (c) 2009-2011 Peter Minne <peter@inthepocket.mobi>
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */



/**
 * Zend_Matrixcode_Renderer_Abstract
 *
 * @package    Zend_Matrixcode
 * @copyright  Copyright (c) 2009-2011 Peter Minne <peter@inthepocket.mobi>
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Zend_Matrixcode_Renderer_Abstract 
{
	
	/**
     * Namespace of the renderer for autoloading
     * @var string
     */
    protected $_rendererNamespace = 'Zend_Matrixcode_Renderer';
    
    /**
     * Renderer type
     * @var string
     */
    protected $_type;
    
    /**
     * Matrixcode object
     * @var Zend_Matrixcode_Abstract
     */
	protected $_matrixcode;
	
	/**
	 * Whether to return the result or send it to the client
	 * @var boolean
	 */
	protected $_return_resource = false;
	
	
	
	/**
     * Constructor
     * @param array | Zend_Config $options 
     * @return void
     */
    public function __construct ($options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        } elseif ($options instanceof Zend_Config) {
            $this->setConfig($options);
        }
        $this->_type = strtolower(substr(get_class($this), strlen($this->_rendererNamespace) + 1));
    }

    
    /**
     * Set matrixcode state from options array
     * @param Zend_Config $config
     * @return Zend_Matrixcode_Abstract
     */
    public function setOptions($options)
    {
    	foreach ($options as $key => $value) {
    		$normalized = ucfirst($key);
            $method = 'set' . $key;
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
   
	/**
     * Set matrixcode state from config object
     * @param Zend_Config $config
     * @return Zend_Matrixcode_Abstract
     */
    public function setConfig(Zend_Config $config)
    {
        return $this->setOptions($config->toArray());
    }
	
    
    /**
     * Retrieve renderer type
     * @return string
     */
    public function getType()
    {
    	return $this->_type;
    }
    
    
    /**
     * Set the 'return resource' flag
     * @param bool $bool
     */
    public function setReturnResource($bool)
    {
    	$this->_return_resource = (bool) $bool;
    	return $this;
    }
    
    /**
     * Retrieve the 'return resource' flag
     * @return bool
     */
    public function getReturnResource()
    {
    	return $this->_return_resource;
    }
	
	
    /**
     * Set the matrix code
     * @param Zend_Matrixcode_Abstract $matrixcode
     */
	public function setMatrixcode(Zend_Matrixcode_Abstract $matrixcode)
	{
		$this->_matrixcode = $matrixcode;
		return $this;
	}
	
	
	/**
	 * Render method
	 */
	public function render()
	{
		$this->_checkParams();
		$this->_renderMatrixcode();
	}
	
	
	/**
     * Checking of parameters after all settings
     *
     * @return void
     */
    abstract protected function _checkParams();
    
    
    /**
     * Method that prepares the matrix
     * @return array
     */
    abstract protected function _renderMatrixcode();
	
}