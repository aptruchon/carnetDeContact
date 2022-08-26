<?php
class UtilisateurControleur extends Controleur
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

    public function nouveau($params)
    {
        
    }
    
    public function ajout($params)
    {
        $this->modele->ajout($_POST);
        Utilitaire::nouvelleRoute("utilisateur/index");
    }

    public function connexion()
    {
        $courriel = $_POST['uti_courriel'];
        $mdp = $_POST['uti_mdp'];

        $utilisateur = $this->modele->un($courriel);

        $erreur = false;
        if(!$utilisateur || !password_verify($mdp, $utilisateur->uti_mdp)) {
            $erreur = "Combinaison courriel/mot de passe erronée";
        }
        else if($utilisateur->uti_confirmation != '') {
            $erreur = "Compte non confirmé : vérifiez vos courriels";
        }
        else if(!$utilisateur->uti_actif) {
            $erreur = "Compte pas activé : communiquez avec votre administrateur";
        }

        if(!$erreur) {
            // Sauvegarder l'état de connexion
            $_SESSION['utilisateur'] = $utilisateur;
            // Rediriger vers categorie/tout
            Utilitaire::nouvelleRoute('categorie/tout');
        }
        else {
            $this->gabarit->affecter('erreur', $erreur);
            $this->gabarit->affecterActionParDefaut('index');
            $this->index([]);
        }
    }

    public function deconnexion()
    {
        unset($_SESSION['utilisateur']);
        Utilitaire::nouvelleRoute('utilisateur');
    }
}
