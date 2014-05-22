<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2010-2011 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Model {

    public function __construct($atributos = null) {

        $obj_vars = $this->get_object_vars();
        $keys     = array_keys($obj_vars);

        foreach ($keys as $key) {
            if (isset($atributos[$key])) {
                $this->$key = $atributos[$key];
            }
        }
    }

    public function setNull($attr) {
        unset($this->$attr);
    }

    public function hasSet($attr) {
        return isset($this->$attr);
    }

    public function get($atributo) {
        return $this->$atributo;
    }

    public function set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function get_object_vars() {

        return get_object_vars($this);
    }
}
?>