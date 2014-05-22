<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2011 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class LoginControl extends Control {
    
    function index($mensagem = "") {
        if ($mensagem) {
            $this->interface->setCurrentBlock("Mensagem");
            $this->interface->setVariable("mensagem", $mensagem);
            $this->interface->parseCurrentBlock();
        }
        
        $this->interface->setVariable("usuario", "");

        return $this->interface;
    }
}

?>
