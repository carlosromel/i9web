<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2011-2012 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
/*
 * TODO: Incluir automaticamente os eventuais roteiros JavaScript na interface.
 * TODO: Incluir automaticamente as eventuais folhas de estilona interface.
 */
class Content_IndexControl extends Control {

    protected $anonymousMethods = array("index");

    public function index() {
        /*
         * Buscamos na interface, referências a componentes que deverão ser
         * renderizados (composição).
         * Usamos 
         */
        if ($this->interface->blockvariables["__global__"]) {
            foreach ($this->interface->blockvariables["__global__"] as $variavel => $valor) {
                if (preg_match("/componente_(.*)/", $variavel, $ocorrencias)) {
                    $classe = $ocorrencias[1] . "Control";
                    if (class_exists($classe)) {
                        $componente = new $classe();
                        $resultado = $componente->index();
                        $this->interface->setVariable("$variavel", $resultado->get());
                    }
                }
            }
        } else {
            $this->interface->touchBlock("__global__");
        }

        return $this->interface;
    }
}
?>