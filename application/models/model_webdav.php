<?php

/*
 * Модель WebDAV сервера.
 * */
class model_webdav {

    function exec() {
        $this->invoke(strtolower($_SERVER['REQUEST_METHOD']));
    }

    protected function invoke($method) {

        if (in_array($method,$this->getAllowedMethods())) {
            $this->$method();
        }
    }

    protected function getAllowedMethods() {
        return array('options','get','head','post','delete','trace','propfind','proppatch','copy','mkcol','put');
    }


    protected function sendHTTPStatus($code) {

        header($this->getHTTPStatus($code));

    }

    protected function getHTTPStatus($code) {

        $msg = array(
            200 => 'Ok',
            201 => 'Created',
            204 => 'No Content',
            207 => 'Multi-Status',
            403 => 'Forbidden',
            404 => 'Not Found',
            409 => 'Conflict',
            415 => 'Unsupported Media Type',
            500 => 'Internal Server Error',
            501 => 'Method not implemented',
        );

        return 'HTTP/1.1 ' . $code . ' ' . $msg[$code];
    }

    protected function options() {
        $this->addHeader('Allows',strtoupper(implode(' ',$this->getAllowedMethods())));
        $this->addHeader('DAV','1');
    }

    function addHeader($name,$value) {
        header($name . ': ' . str_replace(array("\n","\r"),array('\n','\r'),$value));
    }

    function getRequestedProperties($data) {
        $data = preg_replace("/xmlns(:[A-Za-z0-9_])?=\"DAV:\"/","xmlns\\1=\"urn:DAV\"",$data);

        $xml = simplexml_load_string($data);
        $xml = $xml->children('urn:DAV');

        $props = array();

        $propertyTypes = array(
            'getlastmodified',
            'getcontentlength',
            'resourcetype',
        );

        foreach($propertyTypes as $propType) if (isset($xml->prop->$propType)) $props[] = $propType;

        return $props;
    }

}