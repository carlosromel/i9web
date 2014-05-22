<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControleUsuarioCadastro
 *
 * @author cromel
 */
class Usuario_CadastroControl extends Control {
    protected $usuario;

    public function __construct() {
        parent::__construct($this->usuario, "Usuario_CadastroInterface.html");
    }

    public function index() {
        $this->interface->setVariable("nome", "");
        $this->interface->setVariable("email", "");

        return $this->interface;
    }
}
?>