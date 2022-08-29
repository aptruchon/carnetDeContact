<?php
class UtilisateurControleur extends Controleur
{

    function __construct($modele, $module, $action)
    {
        parent::__construct($modele, $module, $action);
        if(isset($_SESSION['utilisateur'])) {
            Utilitaire::nouvelleRoute('categorie/tout');
        }
    }

    /**
     * Méthode invoquée par défaut si aucune action n'est indiquée
     */
    public function index($params)
    {
        // Aucun code ici pour le moment...
    }

    
    /**
     * Méthode qui appelle la méthode ajout de UtilisateurModel en lui envoyant les données de formulaire en POST
     * et qui redirige vers utilisateur/index (Fenêtre de connexion)
     */
    public function ajout($params)
    {
        $this->modele->ajout($_POST);
        Utilitaire::nouvelleRoute("utilisateur/index");
    }


    /**
     * Méthode qui vérifie les informations de connexion récupéré en POST et qui traite les erreurs possibles
     */
    public function connexion()
    {
        $courriel = $_POST['uti_courriel'];
        $mdp = $_POST['uti_mdp'];

        $utilisateur = $this->modele->un($courriel);

        $erreur = false;
        if(!$utilisateur || !password_verify($mdp, $utilisateur->uti_mdp)) {
            $erreur = "**Combinaison courriel/Mot de passe erronée**";
        }
        else if($utilisateur->uti_confirmation != '') {
            $erreur = "**Compte non confirmé. Vérifiez vos courriels**";
        }

        if(!$erreur) {
            // Sauvegarder l'état de connexion
            $_SESSION['utilisateur'] = $utilisateur;
            var_dump($utilisateur);

            // Rediriger vers contact/tout
            Utilitaire::nouvelleRoute('contact/tout');
        }
        else {
            $this->gabarit->affecter('erreur', $erreur);
            $this->gabarit->affecterActionParDefaut('index');
            $this->index([]);
        }
    }


    /**
     * Méthode qui met fin à la session utilisateur
     */
    public function deconnexion()
    {
        unset($_SESSION['utilisateur']);
        Utilitaire::nouvelleRoute('utilisateur');
    }
}