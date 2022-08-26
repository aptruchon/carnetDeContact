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
        $this->creer("INSERT INTO utilisateur VALUES (0, :courriel, :mdp, NOW(), '$cc', 0)",
                    [
                        "courriel" => $uti_courriel,
                        "mdp"      => password_hash($uti_mdp, PASSWORD_DEFAULT)
                    ]
                    );
    }
}