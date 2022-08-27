<?php
class ContactControleur extends Controleur
{

    function __construct($modele, $module, $action)
    {
        parent::__construct($modele, $module, $action);
       /*  if(isset($_SESSION['utilisateur'])) {
            Utilitaire::nouvelleRoute('categorie/tout');
        } */
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
        $this->gabarit->affecter('contacts', $this->modele->tout());
       /*  // Nous avons aussi besoin des catégories...
        $this->gabarit->affecter("types", $this->modele->toutesCategories()); */
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
        $this->modele->suppression($_POST);
        Utilitaire::nouvelleRoute("contact/tout");
    }


}