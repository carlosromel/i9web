<?php

class UsuarioModel extends Model {
    protected $id_usuario;
    protected $credencial;
    protected $nome;
    /*
     * Esse atributo não deve ser propagado.
     */
    protected $senha;
}

?>