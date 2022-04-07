<?php
defined("_JEXEC") or die("Acceso restringido");

require_once __DIR__ . "/vendor/autoload.php";

use Dickinsonjl\Lorum\Lorum;

class plgContentPluginBase extends JPlugin{

    protected $autoloadLanguge=true;

    function onContentPrepare($context,&$articulo,$params,$limitstart){

        // Detecta el patron {plugin_base}{"index":"indice"}{/plugin_base} y lo sustituye por $this->getTextoDeReemplazo("indice")

        $patron = '/(\{plugin_base\})(.*)(\{\/plugin_base\})/';

        $this->procesarTexto($articulo->text, $patron);

        $this->procesarTexto($articulo->introtext, $patron);
    
        return true;
    }

    private function procesarTexto(&$text,$patron){
        $tags = $this->getContenido($text, $patron);

        foreach ($tags as $tag) {
            if($this->isJSON($tag["content"])){
                $reemplazo = $this->getTextoDeReemplazo(json_decode($tag["content"])->index);
                
                $text = $this->reemplazaContenido($text, $tag["tag"], $reemplazo);
            }
            else{
                $text = $this->reemplazaContenido($text, $patron, "");
            }
        }
    }


    private function getContenido($text,$patron){
        $out = [];
        $matches = [];
        preg_match_all($patron, $text, $matches);
        
        if(count($matches) == 4){
            
            //Existen matches
            for($i = 0; $i < count($matches[0]); $i++){
                $tag["tag"] = $matches[0][$i];
                $tag["content"] = $matches[2][$i];
                
                array_push($out,$tag);
            }   
            return $out;
        }
        else{
            return false;
        }
    }

    private function isJSON($string){
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    private function reemplazaContenido($text,$patron,$reemplazo){
        $out = str_replace($patron, $reemplazo, $text);

        return $out;
    }

    private function getTextoDeReemplazo($index){
        // die(var_dump($index));
        switch($index){
            case "test":
                $out = "<span>FUNCIONAAAA!!!!</span>";
                break;
            case "test-2":
                $lorum = new Lorum();
                return "<span>" . $lorum->giveMeSentence(2) . "</span>";
                // $out = "<span>FUNCIONAAA2!!!!</span>";
                break;
            default:
                $out = "";
        }

        return $out;
    }
}

?>