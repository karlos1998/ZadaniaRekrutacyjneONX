<?php


class Thesaurus {

    private $data = array("market" => array("trade"), "small" => array("little", "compact"));

    public function __construct()
    {
        
    }
    public function getSynonyms (string $word)
    {
        $found = [];
        
        if(isset($this->data[$word]))
            $found = $this->data[$word];
        else
        {
            /** Jesli synonimow nie ma w naszym slowniku szuka tez w API :) */
            $found = $this->getFromUrl($word);
        }

        $result = [
            'word' => $word,
            'synonyms' => $found
        ];

        return json_encode($result);
    }

    private function getFromUrl($word)
    {
        /**
         * Bonusowo sprwadza tez synonimy z publicznego API (tylko przymiotniki)
         */
        try {
            $response = @file_get_contents("https://words.bighugelabs.com/api/2/bb73a913cde61cf4e5d420ebf163be12/$word/json");
            $json = json_decode($response, 1);
            if(json_last_error()) {
                throw new Exception('Json Error.');
            }
            $result = $json['adjective']['syn'];
            return $result;
        } catch (Exception $e) {
            return [];
        }
    }
}

$thesaurus = new Thesaurus();

$data = $thesaurus->getSynonyms("small");
echo $data;

echo PHP_EOL . PHP_EOL;

$data = $thesaurus->getSynonyms("asleast");
echo $data;


echo PHP_EOL . PHP_EOL;

$data = $thesaurus->getSynonyms("bright");
echo $data;
