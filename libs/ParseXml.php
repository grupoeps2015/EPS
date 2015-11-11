<?php
/**
 *	@File name:	ParseXml.class.php
 *	@todo: 	parsing XML(string or file or url)
 *	@author:	zhys9 @ 2008-03-24 <email>zhys99@gmail.com</email>
 *	example:
 *	<code>
 *			$xml = new ParseXml();
 *			$xml->LoadFile("test.xml");
 *			//$xml->LoadString($xmlString);
 *			//$xml->LoadRemote("http"//www.yourdomain.com/dir/filename.xml", 3);
 *			$dataArray = $xml->ToArray();
 *			print_r($dataArray);
 *	</code>
 */

 class ParseXml {
    var $xmlStr;
    var $xmlFile;
    var $obj;
    var $aArray;
    var $timeOut;
    var $charsetOutput = CHAR_SET;

    function ParseXml() {

    }
	
    /**
     * @param String xmlString xml string to parsing
     */
    function LoadString($xmlString) {
            $this->xmlStr = $xmlString;
    }
	
    /**
     * @param String Path and file name which you want to parsing, 
     *	Also, if �fopen wrappers�  is activated, you can fetch a remote document, but timeout not be supported.
     */
    function LoadFile ($file) {
            $this->xmlFile = $file;
            $this->xmlStr = @file_get_contents($file);
    }
	
    /**
     * @todo Load remote xml document
     * @param string $url URL of xml document.
     * @param int $timeout timeout  default:5s
     */
    function LoadRemote ($url, $timeout=5) {
        $this->xmlFile = $url;
        $p=parse_url($url);
        if($p['scheme']=='http'){
            $host = $p['host'];
            $pos = $p['path'];
            $pos .= isset($p['query']) ? sprintf("?%s",$p['query']) : '';
            $port = isset($p['port'])?$p['port']:80;
            $this->xmlStr = $this->Async_file_get_contents($host, $pos, $port, $timeout);
            //if(!$this->xmlStr) return false;
        }else{
                return false;
        }

    }
	
    /**
     * @todo Set attributes.
     * @param array $set array('attribute_name'=>'value')
     */
    function Set (array $set) {
        foreach($set as $attribute=>$value) {
            if($attribute=='charsetOutput'){
                $value = strtoupper($value);
            }
            $this->$attribute = $value;
        }
    }
	
    /**
     * @todo Convert charset&#65292;if you want to output data with a charset not "UTF-8",
     *	this member function must be useful.
     * @param string $string &#38656;&#36716;&#25442;&#30340;&#23383;&#31526;&#20018;
     */
    function ConvertCharset ($string) {
        if('UTF-8'!=$this->charsetOutput) {
            if(function_exists("iconv")){
                $string = iconv('UTF-8', $this->charsetOutput, $string);
            }elseif(function_exists("mb_convert_encoding")){
                $string = mb_convert_encoding($string, $this->charsetOutput, 'UTF-8');
            }else{
                die('Function "iconv" or "mb_convert_encoding" needed!');
            }
        }
        return $string;
    }
	
    /**
     * &#35299;&#26512;xml
     */
    function Parse () {
        $this->obj = simplexml_load_string($this->xmlStr);
    }
	
    /**
     * @return Array Result of parsing.
     */
    function ToArray(){
        if(empty($this->obj)){
            $this->Parse();
        }
        $this->aArray = $this->Object2array($this->obj);
        return $this->aArray;
    }
	
    /**
     * @param Object object Objects you want convert to array.
     * @return Array
     */
    function Object2array($object) {
        $return = array();
        if(is_array($object)){
            foreach($object as $key => $value){
                    $return[$key] = $this->Object2array($value);
            }
        }else{
            if (is_object($object) && ($var = get_object_vars($object)) !== false) {
                foreach($var as $key => $value){
                    $return[$key] = ($key && ($value==null)) ? null : $this->Object2array($value);
                }
            }else{
                return $this->ConvertCharset((string)$object);
            }
        }
        return $return;
    }
	
    /**
     * @todo Fetch a remote document with HTTP protect.
     * @param string $site Server's IP/Domain
     * @param string $pos URI to be requested
     * @param int $port Port default:80
     * @param int $timeout Timeout  default:5s
     * @return string/false Data or FALSE when timeout.
     */
    function Async_file_get_contents($site,$pos,$port=80,$timeout=5) {
        $fp = fsockopen($site, $port, $errno, $errstr, 5);

        if (!$fp) {
            return false;		
        }else{
            fwrite($fp, "GET $pos HTTP/1.0\r\n");
            fwrite($fp, "Host: $site\r\n\r\n");
            stream_set_timeout($fp, $timeout);
            $res = stream_get_contents($fp);
            $info = stream_get_meta_data($fp);
            fclose($fp);

            if ($info['timed_out']) {
                return false;    	
            }else{
                return substr(strstr($res, "\r\n\r\n"),4);
            }
        }
    }
	
    /**
     * @todo Get xmlStr of current object.
     * @return string xmlStr
     */
    function GetXmlStr () {
        return $this->xmlStr;
    }
    
    function xml2array($contents, $get_attributes=1) {
        if(!$contents) return array();

        if(!function_exists('xml_parser_create')) {
            return array();
        }

        //Get the XML parser of PHP - PHP must have this module for the parser to work
        $parser = xml_parser_create();
        xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 );
        xml_parser_set_option( $parser, XML_OPTION_SKIP_WHITE, 1 );
        xml_parse_into_struct( $parser, $contents, $xml_values );
        xml_parser_free( $parser );

        if(!$xml_values) return;

        //Initializations
        $xml_array = array();
        $parents = array();
        $opened_tags = array();
        $arr = array();

        $current = &$xml_array;

        //Go through the tags.
        foreach($xml_values as $data) {
            unset($attributes,$value);//Remove existing values, or there will be trouble
            extract($data);//We could use the array by itself, but this cooler.

            $result = '';
            if($get_attributes) {//The second argument of the function decides this.
                $result = array();
                if(isset($value)) $result['value'] = $value;

                //Set the attributes too.
                if(isset($attributes)) {
                    foreach($attributes as $attr => $val) {
                        if($get_attributes == 1) $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
                        /**  :TODO: should we change the key name to '_attr'? Someone may use the tagname 'attr'. Same goes for 'value' too */
                    }
                }
            } elseif(isset($value)) {
                $result = $value;
            }

            //See tag status and do the needed.
            if($type == "open") {//The starting of the tag '<tag>'
                $parent[$level-1] = &$current;

                if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                    $current[$tag] = $result;
                    $current = &$current[$tag];

                } else { //There was another element with the same tag name
                    if(isset($current[$tag][0])) {
                        array_push($current[$tag], $result);
                    } else {
                        $current[$tag] = array($current[$tag],$result);
                    }
                    $last = count($current[$tag]) - 1;
                    $current = &$current[$tag][$last];
                }

            } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
                //See if the key is already taken.
                if(!isset($current[$tag])) { //New Key
                    $current[$tag] = $result;

                } else { //If taken, put all things inside a list(array)
                    if((is_array($current[$tag]) and $get_attributes == 0)//If it is already an array...
                            or (isset($current[$tag][0]) and is_array($current[$tag][0]) and $get_attributes == 1)) {
                        array_push($current[$tag],$result); // ...push the new element into that array.
                    } else { //If it is not an array...
                        $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                    }
                }
            } elseif($type == 'close') { //End of tag '</tag>'
                $current = &$parent[$level-1];
            }
        }
        return($xml_array);
    }
    
}
?>