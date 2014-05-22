<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2010 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class PessoaControl extends Control {

    private $pessoa;

    public function __construct() {
        
        $this->pessoa = new PessoaModel();
        parent::__construct($this->pessoa, "pessoa/view/pessoa.html");
    }

    public function index() {

        $this->interface->setVariable("idPessoa", "");
        $this->interface->setVariable("nome",     "");
        $this->interface->setVariable("acao",     "Gravar");
        $this->interface->touchBlock("Consultar");

        return $this->interface;
    }

    public function editar() {

        if ((Integer) $this->pessoa->get("idPessoa")) {
            $pessoa  = new PessoaModel(array("idPessoa" => (Integer) $this->pessoa->get("idPessoa")));
            $pessoas = PessoaDAO::consultar($pessoa);

            if ($pessoas) {
                $this->pessoa = $pessoas[0];
            }

            if ($this->pessoa->get("idPessoa")) {
                $this->interface->setVariable("idPessoa", $this->pessoa->get("idPessoa"));
            }

            if ($this->pessoa->get("nome")) {
                $this->interface->setVariable("nome", $this->pessoa->get("nome"));
            }

            if ($this->pessoa->get("idPessoa")) {
                $this->interface->setVariable("acao", "Atualizar");
                $this->interface->touchBlock("Remover");
            } else {
                $this->interface->setVariable("acao", "Gravar");
                $this->interface->touchBlock("Consultar");
            }
        } else {
            $this->index();
        }

        return $this->interface;
    }

    public function gravar() {

        if ($this->pessoa->get("idPessoa")) {
            PessoaDAO::alterar($this->pessoa);
        } else {
            PessoaDAO::incluir($this->pessoa);
        }

        return $this->index();
    }

    function remover() {

        if ($this->pessoa->get("idPessoa")) {
            PessoaDAO::remover($this->pessoa);
        }

        return $this->index();
    }

    function consultar() {

        $pessoa  = new PessoaModel(array("nome" => $this->pessoa->get("nome")));
        $pessoas = PessoaDAO::consultar($pessoa);

        if ($pessoas) {
            $this->interface->setCurrentBlock("Pessoa");
            foreach ($pessoas as $pessoa) {
                $this->interface->setVariable("idPessoa", $pessoa->get("idPessoa"));
                $this->interface->setVariable("nome",     $pessoa->get("nome"));
                $this->interface->parseCurrentBlock();
            }
        }

        return $this->index();
    }
}
?>