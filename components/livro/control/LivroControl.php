<?php
/**
 * @author Selvino Wilmar Rodrigues Junior <selvinojunior@gmail.com>
 */
class LivroControl extends Control {

    private $livro;

    public function __construct() {
        
        $this->livro = new LivroModel();
        parent::__construct($this->livro, "livro/view/livro.html");
    }

    public function index() {

        $this->interface->setVariable("idLivro", "");
        $this->interface->setVariable("numero",     "");
        $this->interface->setVariable("acao",     "Gravar");
        $this->interface->touchBlock("Consultar");

        return $this->interface;
    }

    public function editar() {

        if ((Integer) $this->livro->get("idLivro")) {
            $livro  = new LivroModel(array("idLivro" => (Integer) $this->livro->get("idLivro")));
            $livros = LivroDAO::consultar($livro);

            if ($livros) {
                $this->livro = $livros[0];
            }

            if ($this->livro->get("idLivro")) {
                $this->interface->setVariable("idLivro", $this->livro->get("idLivro"));
            }

            if ($this->livro->get("numero")) {
                $this->interface->setVariable("numero", $this->livro->get("numero"));
            }

            if ($this->livro->get("idLivro")) {
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

        if ($this->livro->get("idLivro")) {
            LivroDAO::alterar($this->livro);
        } else {
            LivroDAO::incluir($this->livro);
        }

        return $this->index();
    }

    function remover() {

        if ($this->livro->get("idLivro")) {
            LivroDAO::remover($this->livro);
        }

        return $this->index();
    }

    function consultar() {

        $livro  = new LivroModel(array("numero" => $this->livro->get("numero")));
        $livros = LivroDAO::consultar($livro);

        if ($livros) {
            $this->interface->setCurrentBlock("Livro");
            foreach ($livros as $livro) {
                $this->interface->setVariable("idLivro", $livro->get("idLivro"));
                $this->interface->setVariable("numero",     $livro->get("numero"));
                $this->interface->parseCurrentBlock();
            }
        }

        return $this->index();
    }
}
?>