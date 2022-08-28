<?php
class TelephoneControleur extends Controleur
{

    function __construct($modele, $module, $action)
    {
        parent::__construct($modele, $module, $action);
        if(!isset($_SESSION['utilisateur'])) {
            Utilitaire::nouvelleRoute('utilisateur/index');
        }
    }

    /**
     * Méthode invoquée par défaut si aucune action n'est indiquée
     */
    public function index($params)
    {
        // Aucun code ici pour le moment....

    }

    public function tout($params)
    {
        if(!isset($_SESSION["utilisateur"])){
            Utilitaire::nouvelleRoute("utilisateur/index");
        }
        $this->gabarit->affecter('numeros', $this->modele->tout());
    }

    public function ajout($params)
    {
        $this->modele->ajout($_POST);
        Utilitaire::nouvelleRoute("contact/tout");
    }

    public function modification($params)
    {
        $this->modele->modification($_POST);
        Utilitaire::nouvelleRoute("contact/tout");
    }

    public function suppression($params)
    {
        $this->modele->suppression($_GET["idSuppression"]);
        Utilitaire::nouvelleRoute("contact/tout");
    }


}