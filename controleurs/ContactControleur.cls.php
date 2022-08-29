<?php
class ContactControleur extends Controleur
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


    /**
     * Méthode qui appel la méthode tout de ContactModele et qui affecte le retour à la variable contacts
     */
    public function tout($params)
    {
        $this->gabarit->affecter('contacts', $this->modele->tout());
    }


    /**
     * Méthode qui appel la méthode ajout de ContactModele en lui envoyant les données reçus en POST 
     * + redirection vers la page contact/tout
     */
    public function ajout($params)
    {
        $this->modele->ajout($_POST);
        Utilitaire::nouvelleRoute("contact/tout");
    }


    /**
     * Méthode qui appel la méthode modification de ContactModele en lui envoyant les données reçus en POST 
     * + redirection vers la page contact/tout
     */
    public function modification($params)
    {
        $this->modele->modification($_POST);
        Utilitaire::nouvelleRoute("contact/tout");
    }


    /**
     * Méthode qui appel la méthode suppression de ContactModele en lui envoyant un id reçus en GET
     * + redirection vers la page contact/tout
     */
    public function suppression($params)
    {
        $this->modele->suppression($_GET["idSuppression"]);
        Utilitaire::nouvelleRoute("contact/tout");
    }
}