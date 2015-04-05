<?php
/**
 * PHP library ImportExportUtils provides conversions between standard formats
 * and PHP hash map (assoc. array).
 * 
 * @author Josef Burger
 */
class ImportExportUtils {
    private static $INSTANCE = null;
    
    /**
     * Avoid instance
     */
    private function __construct() {}
    
    /**
     * Returns converter instance
     * @return ImportExportUtils
     */
    public static function getInstance() {
        if(self::$INSTANCE == null)
            self::$INSTANCE = new self();
        return self::$INSTANCE;
    }
    
    
    // === XML =================================================================
    
    
    /**
     * Converts PHP hashmap to XML with given root element
     * @param multitype array $map
     * @param String $rootElement
     * @return String
     */
    public function convertMapToXml($map, $rootElement = 'data') {
        return $this->doConvertMapToXml($map, new SimpleXMLElement('<' . $rootElement . '/>'));
    }
    
    protected function doConvertMapToXml($array, SimpleXMLElement $xml) {
        foreach ($array as $key => $value) {
            if(is_array($value)) {
                $this->doConvertMapToXml($value, $xml->addChild($key));
            } else {
               $xml->addChild($key, $value); 
            }
        }
        return $xml->asXML();
    }
    
    /**
     * Converts XML document into PHP hashmap
     * @param type $xmlDocument
     * @return multitype array
     */
    public function convertXmlToMap($xmlDocument) {
        return json_decode(json_encode((array)simplexml_load_string($xmlDocument)), true);
    }

    
    // === JSON ================================================================
    

    /**
     * Converts PHP hashmap to XML (converts force to objects)
     * @param multitype array $map
     * @return String
     */
    public function convertMapToJson($map) {
        return json_encode($map, JSON_FORCE_OBJECT);
    }
    
    /**
     * Converts string JSON to PHP hashmap
     * @param String $json
     * @return multitype array
     */
    public function convertJsonToMap($json) {
        return json_decode($json, true);
    }
    
    
    // === Arrays ==============================================================
    
    
    /**
     * Serialise PHP hashmap
     * @param multitype array $map
     * @return String
     */
    public function serialiseMap($map) {
        return serialize($map);
    }
    
    /**
     * Deserialise serialised PHP hashmap
     * @param String $serialisedMap
     * @return multitype array
     */
    public function deserialiseMap($serialisedMap) {
        return unserialize($serialisedMap);
    }
}
