<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2010-2012 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (file_exists("config/config.php")) {
    if (require_once "config/config.php") {
        $module      = (isset($_REQUEST["module"])  ? $_REQUEST["module"]  : "Content");
        $control     = (isset($_REQUEST["control"]) ? $_REQUEST["control"] : "Index");
        $class       = "{$module}_{$control}Control";
        $application = new $class();

        if ($application->anonymousMethod() || ConnectionControl::authenticate()) {
            $content = $application->index();
        
            if (SessionControl::$componente) {
                $component        = new SessionControl::$componente();
                $method           = SessionControl::$metodo;
                $componentContent = $component->$method();
                /*
                 * Alguns métodos simplesmente não retornam uma interface.
                 */
                if ($componentContent instanceof HTML_Template_IT) {
                    $content->setVariable("content", $componentContent->get());
                }
            }

            $content->setVariable("base_href", SITE);
            /*
             * TODO: Criar a opção de compactação do conteúdo.
             */
            $output = $content->get();
            //$saida = preg_replace("/>.*</", "><", preg_replace("/\n/", "", preg_replace("/\r/", "", $saida)));

            echo $output;
        }
    } else {
        echo "Não foi possível ler o arquivo de configuração 'config/config.php'.";
    }
} else {
    echo "O arquivo 'config/config.php' não foi encontrado.";
}
?>