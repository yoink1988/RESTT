<?php

/**
 * Description of View
 *
 * @author yoink
 */
class View
{

    public function __construct($format)
    {
        $this->format = $format;
    }

    public function doResponse($data)
    {
        $encoded = '';
        switch ($this->format)
        {
        case 'json' :
            $encoded = $this->parseToJson($data);
            break;
        case 'txt' :
            $encoded = $this->parseToTxt($data);
            break;
        case 'xml' :
            $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
            $encoded = $this->parseToXml($data, $xml );
            break;
        case 'html' :
            $encoded = $this->parseToHtml($data);
            break;
        default: 
            // todo sdelat oshibku formata
            $encoded = $this->parseToJson($data);
        }
        echo $encoded;
    }
    public function parseToXml($data, &$xml)
    {

   //     function array_to_xml( $data, &$xml_data ) {
            foreach( $data as $key => $value ) {
                if( is_numeric($key) ){
                    $key = 'item'.$key;
                }
                if( is_array($value) ) {
                    $subnode = $xml->addChild($key);

                    $this->parseToXml($value, $subnode);
                } else {
                    $xml->addChild("$key",htmlspecialchars("$value"));
                }
            }
            return $xml->asXML();
     //   }
        /*
        header("Content-type: text/xml");
        $xml = new SimpleXMLElement('<response/>');
        if (count($data,1) != count($data))
        {
            foreach ($data as $car)
            {
                $data =  array_flip($car);
                array_walk_recursive($data, array ($xml, 'addChild'));
            }
        }
        else
        {
            $data = array_flip($data);
            array_walk_recursive($data, array($xml, 'addChild'));
        }
        return $xml->asXML();
         */
    }
    public function parseToJson($data)
    {
        //		header('Content-Type: application/json');
        return json_encode($data);
    }
    public function parseToTxt($data)
    {
        header("Content-type: text/javascript");
        print_r($data);
    }
    public function parseToHtml($data)
    {
        header('Content-Type: text/html; charset=utf-8');
        $str = '<div>';
        if (count($data,1) != count($data))
        {
            foreach ($data as $values)
            {
                foreach($values as $key => $val)
                {
                    $str .= '<p>'.$key.' - '.$val.'</p>';
                }
                $str .= '</body>';
            }
        }
        else
        {
            foreach($data as $key => $val)
            {
                $str .= '<p>'.$key.' => '.$val.'</p>';
            }
            $str .= '</div>';
        }
        return $str;
    }
}
