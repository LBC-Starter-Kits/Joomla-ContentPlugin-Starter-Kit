<?php
defined("_JEXEC") or die("Acceso restringido");

$temp = __DIR__ . DIRECTORY_SEPARATOR ."vendor" . DIRECTORY_SEPARATOR . "autoload.php";

require_once $temp;

use Dickinsonjl\Lorum\Lorum;

class plgContentPluginBase extends JPlugin{

    protected $autoloadLanguge=true;

    function onContentPrepare($context,&$articulo,$params,$limitstart){

        // Detecta el patron {plugin_base}{"index":"indice"}{/plugin_base} y lo sustituye por $this->getTextoDeReemplazo("indice")

        $patron = '/(\{plugin_base\})(.*)(\{\/plugin_base\})/';

        $match = $this->getContenido($articulo->text, $patron);
        if($match && $this->isJSON($match)){
            $reemplazo = $this->getTextoDeReemplazo(json_decode($match)->index);
            $articulo->text = $this->reemplazaContenido($articulo->text, $patron, $reemplazo);
        }
        else{
            $articulo->text = $this->reemplazaContenido($articulo->text, $patron, "");
        }

        $match = $this->getContenido($articulo->introtext, $patron);
        if($match && $this->isJSON($match)){
            $reemplazo = $this->getTextoDeReemplazo(json_decode($match)->index);
            $articulo->introtext = $this->reemplazaContenido($articulo->introtext, $patron, $reemplazo);
        }
        else{
            $articulo->introtext = $this->reemplazaContenido($articulo->introtext, $patron, "");
        }

        // $articulo->text=str_replace("{plugin_ejemplo}{/plugin_ejemplo}",$this->reemplazaContenido($articulo),$articulo->text);
        // $articulo->introtext=str_replace("{plugin_ejemplo}{/plugin_ejemplo}",$this->reemplazaContenido($articulo),$articulo->introtext);
        
        return true;
    }

    private function getContenido($text,$patron){
        $matches = [];
        preg_match($patron, $text, $matches);

        if(count($matches) == 4){
            return $matches[2];
        }
        else{
            return false;
        }
    }

    private function isJSON($string){
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    private function reemplazaContenido($text,$patron,$reemplazo){
        $out = preg_replace($patron, $reemplazo, $text);

        return $out;
    }

    private function getTextoDeReemplazo($index){
        switch($index){
            case "test":
                return "<span>FUNCIONAAA!!!!</span>";
            case "test-2":
                $lorum = new Lorum();
                return "<span>" . $lorum->giveMeSentence(2) . "</span>";
                return "<span>FUNCIONAAA2!!!!</span>";
            default:
                return "";
        }
    }
}

?>