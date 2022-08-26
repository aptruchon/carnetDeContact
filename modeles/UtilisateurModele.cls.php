<?php
class UtilisateurModele extends AccesBd
{
    /**
     * 
     */
    public function un($courriel)
    {
        return $this->lireUn("SELECT * FROM utilisateur 
                                WHERE uti_courriel=:email"
                        , ['email'=>$courriel]);
    }

    /**
     * 
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