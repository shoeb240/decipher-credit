<?php
class HandlerResponse 
{
    const ERROR_CODE = 'ERROR';
    const INVALID_INPUT_MSG = 'Invalid User Input';
    const SUCCESS_CODE = 'OK';
    const SUCCESS_MSG = 'User input handled successfully';
    
    private $_responseCode;
    private $_responseText;
    
    public function __construct($code = '', $text = '') {
        $this->_responseCode = $code;
         $this->_responseText = $text;
    }
    
    public function SetResponseCode($code)
    {
        $this->_responseCode = $code;
    }
    
    public function getResponseCode()
    {
        return $this->_responseCode;
    }
    
    public function SetResponseText($text)
    {
        $this->_responseText = $text;
    }
    
    public function getResponseText()
    {
        return $this->_responseText;
    }
}