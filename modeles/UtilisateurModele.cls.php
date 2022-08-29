<?php
class UtilisateurModele extends AccesBd
{
    /**
     * Méthode qui prépare une requête pour aller chercher toutes les informations de la table utilisateur pour un courriel donné
     * 
     * @param $courriel string
     */
    public function un($courriel)
    {
        return $this->lireUn("SELECT * FROM utilisateur 
                                WHERE uti_courriel=:email"
                        , ['email'=>$courriel]);
    }


    /**
     * Méthode qui prépare une requête sql avec les données reçus via $utilisateur (POST), pour l'ajout d'un utilisateur
     * + hashing du mdp
     * 
     * @param $utilisateur array
     */
    public function ajout($utilisateur)
    {
        extract($utilisateur);
        $cc = uniqid("nestor", true);
        $this->creer("INSERT INTO utilisateur VALUES (0, :nom, :courriel, :mdp, NOW(), '$cc')",
                    [
                        "nom" => $uti_nom,
                        "courriel" => $uti_courriel,
                        "mdp"      => password_hash($uti_mdp, PASSWORD_DEFAULT)
                    ]
                    );
    }
}