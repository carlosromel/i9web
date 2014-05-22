<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2010, 2012 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (@require_once("config/config.php")) {
    $control   = $_REQUEST["control"];
    $action    = $_REQUEST["action"] ? $_REQUEST["action"] : "index";
    $baseClass = $control . "Control";
    if ($control) {
        if (class_exists($baseClass)) {
            try {
                $component = new $baseClass($perfil, $params);

                if (method_exists($component, $action)) {
                    $content = $component->$action();

                    if ($content) {
                        $content->show();
                    }
                } else {
                    echo "O método '$baseClass::$baseClass' não pode ser acionado.";
                }
            } catch (Exception $e) {
                echo "A classe '$baseClass' não pode ser instanciada.";
            }
        } else {
            echo "A classe '$baseClass' não existe.";
        }
    }
} else {
    echo "Não foi possível ler o arquivo de configuração 'config/config.php'.";
}
?>