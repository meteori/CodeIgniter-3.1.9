<?php

namespace yidas\linePay;

/**
 * LINE Pay Response
 * 
 * @author  Nick Tsai <myintaer@gmail.com>
 * @since   3.0.0
 */
class Response implements \ArrayAccess
{
    /**
     * @var object \GuzzleHttp\Psr7\Response $response
     */
    public $response;

    /**
     * @var array Cache data for body with array data type
     */
    protected $bodyArrayCache = null;

    /**
     * @var object Cache data for body with array object type
     */
    protected $bodyObjectCache = null;
    
    /**
     * Constructor
     *
     * @param object \GuzzleHttp\Psr7\Response $response
     */
    function __construct(\GuzzleHttp\Psr7\Response $response) 
    {
        $this->response = $response;
    }

    /**
     * Get LINE Pay response body as array
     *
     * @return array
     */
    public function toArray()
    {
        // Cache
        if (!$this->bodyArrayCache) {
            // ********************************************************
            // KNOWN BUG OF JSON_BIGINT_AS_STRING IN PHP 5.5
            // FIX START
            // ********************************************************
                $options = ( version_compare(PHP_VERSION, '5.4.0', '>=') and ! (defined('JSON_C_VERSION') and PHP_INT_SIZE > 4) ) ? JSON_BIGINT_AS_STRING : 0;
            // ********************************************************
            // FIX END
            // ********************************************************
            $this->bodyArrayCache = json_decode($this->response->getBody(), true, 512, $options );
        }

        return $this->bodyArrayCache;
    }

    /**
     * Get LINE Pay response body as object
     *
     * @return object
     */
    public function toObject()
    {
        // Cache
        if (!$this->bodyObjectCache) {
            // ********************************************************
            // KNOWN BUG OF JSON_BIGINT_AS_STRING IN PHP 5.5
            // FIX START
            // ********************************************************
                $options = ( version_compare(PHP_VERSION, '5.4.0', '>=') and ! (defined('JSON_C_VERSION') and PHP_INT_SIZE > 4) ) ? JSON_BIGINT_AS_STRING : 0;
            // ********************************************************
            // FIX END
            // ********************************************************
            $this->bodyObjectCache = json_decode($this->response->getBody(), false, 512, $options );
        }

        return $this->bodyObjectCache;
    }

    /**
     * Get LINE Pay API response body's returnCode
     *
     * @return string
     */
    public function getReturnCode()
    {
        return $this->offsetGet('returnCode');
    }

    /**
     * Get LINE Pay API response body's returnMessage
     *
     * @return string
     */
    public function getReturnMessage()
    {
        return $this->offsetGet('returnMessage');
    }

    /**
     * Get LINE Pay API response body's info as array
     *
     * @return array
     */
    public function getInfo()
    {
        return $this->offsetGet('info');
    }

    /**
     * Get LINE Pay API response body's info.paymentUrl (Default type is "web")
     *
     * @return string URL
     */
    public function getPaymentUrl($type='web')
    {
        $info = $this->offsetGet('info');
        
        return isset($info['paymentUrl'][$type]) ? $info['paymentUrl'][$type] : null;
    }

    /**
     * Get LINE Pay API response body's info.payInfo[] or info.[$param1].payInfo[] as array
     *
     * @param integer $itemKey 
     * @return array
     */
    public function getPayInfo($itemKey=0)
    {
        $info = $this->offsetGet('info');
        // Check for confirm or details response format
        if (isset($info['payInfo'])) {
            return $info['payInfo'];
        }
        elseif (isset($info[$itemKey]['payInfo'])) {
            return $info[$itemKey]['payInfo'];
        }
        return null;
    }

    /**
     * LINE Pay API result successful status
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        if ($this->getReturnCode() == "0000") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Magic method __call() for access \GuzzleHttp\Psr7\Response
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->response, $name], $arguments);
    }

    /**
     * Magic method __get()
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $data = $this->toObject();
        
        return isset($data->$name) ? $data->$name : null;
    }

    /**
     * Magic method __set()
     *
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function __set($name, $value)
    {
        trigger_error("Cannot set response data", E_USER_NOTICE); 
    }
    
    /**
     * ArrayAccess method offsetSet
     *
     * @param string $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value) 
    {
        trigger_error("Cannot set response data", E_USER_NOTICE); 
    }

    /**
     * ArrayAccess method offsetExists
     *
     * @param string $offset
     * @return boolean
     */
    public function offsetExists($offset) 
    {
        return isset($this->toArray()[$offset]);
    }

    /**
     * ArrayAccess method offsetUnset
     *
     * @param string $offset
     * @return void
     */
    public function offsetUnset($offset) 
    {
        trigger_error("Cannot unset response data", E_USER_NOTICE); 
    }

    /**
     * ArrayAccess method offsetGet
     *
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset) 
    {
        $data = $this->toArray();
        
        return isset($data[$offset]) ? $data[$offset] : null;
    }
}
