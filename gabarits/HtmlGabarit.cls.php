<?php
use \Twig\Environment;
use \Twig\Loader\FilesystemLoader;

class HtmlGabarit 
{
    protected $variables = array();
    protected $module;
    protected $action;
    private $twig;

    function __construct($module, $action)
    {
        $this->module = $module;
        $this->action = $action;

        $this->twig = new Environment(new FilesystemLoader(['vues/']), []);
        // Pour avoir accès à SESSION, POST et GET avec twig
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addGlobal('_post', $_POST);
        $this->twig->addGlobal('_get', $_GET);
    }

    public function affecter($nom, $valeur)
    {
        $this->variables[$nom] = $valeur;
    }

    public function affecterActionParDefaut($nomAction) {
        $this->action = $nomAction;
    }
 
    public function genererVue() 
    {
        $this->twig->display("$this->module.$this->action.twig.html", $this->variables);
    }
}