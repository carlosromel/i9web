<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2010 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class SelosUtilizadosModel extends Model {
    
    protected $numero_recibo;
    protected $tipo;
    protected $cobrar_selo;
    protected $codigo_oficial;
    protected $valor_emolumento;
    protected $valor_de_referencia;
    protected $selo;
    protected $data_inicial; // Este atributo não é materializado.
    protected $data_final;   // Este atributo não é materializado.
    protected $data;
}
?>