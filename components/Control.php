<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2010-2012 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Control {

    protected $interface;
    /*
     * Útil quando todos os métodos da classe podem ser executados sem a
     * necessidade de identificação do usuário.
     * 
     * Nota: Use essa forma de permissão com cautela e apenas quando a classe
     *       for iminentemente pública ou possuir poucos métodos. Previna-se e
     *       evite surpresas.
     */
    protected $anonymousComponent = false;
    /*
     * útil quando apenas alguns métodos da classe podem ser executados sem a
     * necessidade de identificação do usuário.
     * 
     * Nota: Use preferencialmente essa forma de permissão dos componentes.
     */
    protected $anonymousMethods   = array();

    public function __construct($object = null, $interface = null) {

        /*
         * Povoamos o objeto indicado com uma instância determinada.
         * Útil quando precisamos coletar os parâmetros passados em $_REQUEST.
         */
        if (is_object($object)) {
            $attributes = array_keys($object->get_object_vars());

            foreach ($attributes as $attribute) {
                /*
                 * Somente os parâmetros que coincidem com os atributos do
                 * objeto são utilizados.
                 */
                if ($_REQUEST[$attribute]) {
                    $object->set($attribute, $_REQUEST[$attribute]);
                }
            }
        }

        $this->interface = $this->loadInterface($interface);
    }
    
    /*
     * Determina quando um metodo pode ser executado sem a identificação do
     * usuário.
     * 
     * Veja: $this->componenteAnonimo e $this->metodosAnonimos.
     */
    public function anonymousMethod($method = "index") {

        return $this->anonymousComponent || in_array($method, $this->anonymousMethods);
    }

    public function get() {

        return $this->interface;
    }
    
    public function show() {
        
        $this->index()->show();
    }

    protected function loadInterface($interface) {
        $view      = new HTML_Template_IT("components");
        $baseClass = get_class($this);
        /*
         * O caso mais comum ocorre quando intuimos o nome da interface pelo
         * nome da classe.
         * Ex.: LoginControl possui a interface components/login/view/loginView.html
         */
        if (! $interface) {
            $base = lcfirst(substr($baseClass, 0, strpos($baseClass, "Control")));
            if (strpos($baseClass, "_")) {
                $module = lcfirst(substr($baseClass, 0, strpos($baseClass, "_")));
            } else {
                $module = $base;
            }
            
            $interface = $base . "View.html";
        } else {
            /*
             * O caso mais comum ocorre quando a interface advém de uma classe
             * pertencente a um componente.
             * Ex.: Microblog_EditarControl possui a interface microblog/view/editarView.html
             * 
             */
            if (strpos($baseClass, "_")) {
                $module = substr($baseClass, 0, strpos($baseClass, "_"));
            } else {
                /*
                 * O caso mais obscuro ocorre quando a interface não deriva do
                 * nome da classe (ou a interface foi explicitamente indicada.
                 * Ex.: LogControl possui a interface components/log/view/logView.html
                 */
                $module = substr($baseClass, 0, strpos($baseClass, "View"));
            }

            /*
             * Os nomes dos diretórios são todos em minúsculas, facilitando a
             * vida de quem desenvolve em Windows e tem o servidor de aplicação
             * em uma instalação POSIX (*BSD, GNU/Linux).
             */
            $module = lcfirst($module);
        }

        $view->loadTemplatefile("$module/view/html/$interface");

        return $view;
    }
    
    public function defaultValue($value, $default) {
        return isset($value) ? $value : $default;
    }
}
?>