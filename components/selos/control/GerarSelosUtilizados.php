<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2010 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class GerarSelosUtilizados {

    public static function gerarXML($selos) {
        $root = "<arquivo_selos>" .
                  "<serventia></serventia>" .
                  "<qtde_notas></qtde_notas>" .
                  "<notas></notas>" .
                "</arquivo_selos>";
        $xml  = new SimpleXMLElement($root);

        $total_notas   = 0;
        $numero_recibo = "";

        foreach ($selos as $selo) {

            if ($numero_recibo <> $selo->get("numero_recibo")) {
                $numero_recibo = $selo->get("numero_recibo");

                /*
                 * Num cenário ideal, este método apenas geraria o XML e o campo
                 * 'servico' já teria sido resolvido durante a consulta do
                 * banco, de modo a deixar o método blindado contra as regras do
                 * negócio.
                 */
                switch ($selo->get("id_tipo")) {
                    case 1:
                        $servico = "RTD/RCPJ";
                        break;
                    case 2:
                        $servico = "RCPN";
                        break;
                    default:
                        $servico = "NAO IMPLEMENTADO";
                }

                $nota = $xml->notas->addChild("nota");
                $nota->addAttribute("num_nota",    $numero_recibo);
                $nota->addAttribute("dt_emissao",  $selo->get("data"));
                $nota->addAttribute("cobrar_selo", $selo->get("cobrar_selo"));

                if ($selo->get("cobrar_selo") == "N") {
                    $nota->addAttribute("obs_nota", $selo->get("cobrar_selo"));
                }

                $nota->addAttribute("servico", $servico);
                
                ++$total_notas;
            }

            $numero_selo      = substr(str_replace(".", "", $selo->get("selo")), 4, 13);
            $valor_emolumento = str_replace(".", ",", $selo->get("valor_emolumento"));
            $valor_referencia = str_replace(".", ",", $selo->get("valor_de_referencia"));
            
            $ato = $nota->addChild("ato");
            $ato->addAttribute("codigo",     $selo->get("codigo_oficial"));
            $ato->addAttribute("selo",       $numero_selo);
            $ato->addAttribute("valor_emol", $valor_emolumento);

            if ($selo->get("valor_de_referencia") <> "0.00") {
                $ato->addAttribute("valor_ato", $valor_referencia);
            }
        }

        $xml->{'serventia'}  = "0515";
        $xml->{'qtde_notas'} = $total_notas;

        $config = array("indent"     => true,
                        "output-xml" => true,
                        "input-xml"  => true,
                        "wrap"       => 300);
        $tidy = new Tidy();
        $tidy->parseString($xml->asXML(), $config, "utf8");
        $tidy->cleanRepair();

        return $tidy;
    }
}
?>