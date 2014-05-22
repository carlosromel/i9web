<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2010 Carlos Romel
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Index {
    
    private $interface;
    private $id_tipo;
    private $data_inicial;
    private $data_final;

    function  __construct() {
        $this->interface = new HTML_Template_IT();
        $this->interface->loadTemplateFile("view/index.html");

        /*
         * Em uma aplicação mais elaborada, os valores viriam através de um
         * parâmetro no construtor da classe.
         */
        $this->id_tipo      = $_REQUEST["id_tipo"];
        $this->data_inicial = $_REQUEST["data_inicial"];
        $this->data_final   = $_REQUEST["data_final"];
    }

    function index() {

        /*
         * Em um sistema em estágio de produção, ao invés do seletor abaixo,
         * teríamos um objeto que funcionaria como um concentrador (hub),
         * orquestrando a chamada dos métodos.
         */
        if ($_REQUEST["salvar"]) {
            self::enviarArquivo();
        } else {
            self::apresentarFormulario();
        }
    }

    function consultarSelosUtilizados() {

        $resultado = "";

        if ($this->data_inicial and $this->data_final) {
            $selos = new SelosUtilizadosModel();
            $selos->set("id_tipo",      $this->id_tipo);
            $selos->set("data_inicial", $this->data_inicial);
            $selos->set("data_final",   $this->data_final);

            $selosUtilizados = SelosUtilizadosDAO::consultar($selos);
            $resultado       = GerarSelosUtilizados::gerarXML($selosUtilizados);
        }

        return $resultado;
    }

    function enviarArquivo() {

        $xml = self::consultarSelosUtilizados();

        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header('Content-Disposition: attachment; filename="selos.xml"');
        header("Content-Transfer-Encoding: binary");
        header("Expires: 0");
        header("Cache-Control: must-revalidade, post-check=0, pre-check=0");
        header("Pragma: public");
        header("Content-Length: " . strlen($xml));

        echo $xml;
    }

    function apresentarFormulario () {

        $tipos = TipoDAO::consultar(new TipoModel());

        foreach ($tipos as $tipo) {

            $this->interface->setVariable("id_tipo",        $tipo->get("id_tipo"));
            $this->interface->setVariable("descricao_tipo", $tipo->get("descricao_tipo"));

            if ($tipo->get("id_tipo") == $this->id_tipo) {
                $this->interface->setVariable("selecionado", "selected='selected'");
            }

            $this->interface->parse("Tipo");
        }

        $this->interface->setVariable("data_inicial", $this->data_inicial);
        $this->interface->setVariable("data_final",   $this->data_final);
        $this->interface->setVariable("selos",        self::consultarSelosUtilizados());

        $this->interface->show();
    }
}
?>