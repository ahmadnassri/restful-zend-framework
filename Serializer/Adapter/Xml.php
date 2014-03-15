<?php
class REST_Serializer_Adapter_Xml extends Zend_Serializer_Adapter_AdapterAbstract
{
    /**
     * @var array Default options
     */
    protected $_options = array(
        'rootNode' => 'response',
    );

    /**
     * Serialize PHP value to XML
     *
     * @param  mixed $value
     * @param  array $opts
     * @return string
     * @throws Zend_Serializer_Exception on XML encoding exception
     */
    public function serialize($value, array $opts = array())
    {
        $opts = $opts + $this->_options;

        try {
            $dom = new DOMDocument('1.0', 'utf-8');
            $root = $dom->appendChild($dom->createElement($opts['rootNode']));
            $this->createNodes($dom, $value, $root, false);
            return $dom->saveXml();
        } catch (Exception $e) {
            require_once 'Zend/Serializer/Exception.php';
            throw new Zend_Serializer_Exception('Serialization failed', 0, $e);
        }
    }

    /**
     * Deserialize XML to PHP value
     *
     * @param  string $json
     * @param  array $opts
     * @return mixed
     */
    public function unserialize($xml, array $opts = array())
    {
        try {
            Zend_Json::fromXml($xml);
            return (array) Zend_Json::decode($json, Zend_Json::TYPE_OBJECT);
        } catch (Exception $e) {
            require_once 'Zend/Serializer/Exception.php';
            throw new Zend_Serializer_Exception('Unserialization failed by previous error', 0, $e);
        }
    }

    private function createNodes($dom, $data, &$parent)
    {
        switch (gettype($data)) {
            case 'string':
            case 'integer':
            case 'double':
                $parent->appendChild($dom->createTextNode($data));
                break;

            case 'boolean':
                switch ($data) {
                    case true:
                        $value = 'true';
                        break;

                    case false:
                        $value = 'false';
                        break;
                }

                $parent->appendChild($dom->createTextNode($value));
                break;

            case 'object':
            case 'array':
                foreach ($data as $key => $value) {
                
                    if (is_object($value) and $value instanceOf DOMDocument and !empty($value->firstChild)) {
                        $node = $dom->importNode($value->firstChild, true);
                        $parent->appendChild($node);
                    } else {
                        $attributes = null;
                        
                        // SimpleXMLElements can contain key with @attribute as the key name
                        // which indicates an associated array that should be applied to the xml element

                        if (is_object($value) and $value instanceOf SimpleXMLElement) {
                            $attributes = $value->attributes(); 
                            $value = (array) $value;
                        }

                        // don't emit @attribute as an element of it's own
                        if ($key[0] !== '@')
                        {
                            if (gettype($value) == 'array' and !is_numeric($key)) {
                                $child = $parent->appendChild($dom->createElement($key));

                                if ($attributes)
                                {
                                    foreach ($attributes as $attrKey => $attrValue)
                                    {
                                        $child->setAttribute($attrKey, $attrValue);
                                    }
                                }

                                $this->createNodes($dom, $value, $child);
                            } else {
                            
                                if (is_numeric($key)) {
                                    $key = sprintf('%s', $this->depluralize($parent->tagName));
                                }

                                $child = $parent->appendChild($dom->createElement($key));
                                
                                if ($attributes)
                                {
                                    foreach ($attributes as $attrKey => $attrValue)
                                    {
                                        $child->setAttribute($attrKey, $attrValue);
                                    }
                                }

                                $this->createNodes($dom, $value, $child);
                            }
                        }
                    }
                }

                break;
        }
    }

    private function depluralize($word) {
        $rules = array(
            'ss' => false,
            'os' => 'o',
            'ies' => 'y',
            'xes' => 'x',
            'oes' => 'o',
            'ies' => 'y',
            'ves' => 'f',
            's' => null
        );

        // Loop through all the rules
        foreach(array_keys($rules) as $key) {
            // If the end of the word doesn't match the key, it's not a candidate for replacement.
            if (substr($word, (strlen($key) * -1)) != $key) {
                continue;
            }

            // If the value of the key is false, stop looping  and return the original version of the word.
            if ($key === false) {
                return $word;
            }

            // apply the rule
            return substr($word, 0, strlen($word) - strlen($key)) . $rules[$key];
        }

        return $word;
    }
}
