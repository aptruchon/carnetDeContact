<?php
class ContactModele extends AccesBd
{
    /**
     * Cherche tout les enregistrements de la table contact
     */
    public function tout()
    {
        $idUtilisateur = $_SESSION["utilisateur"]->uti_id;
        return $this->lireTout("SELECT * FROM contact WHERE ctc_uti_id_ce = $idUtilisateur ORDER BY ctc_prenom");
    }

    public function ajouter($plat)
    {
        extract($plat);
        $this->creer(
            "INSERT INTO plat VALUES (0, :pla_nom, :pla_detail, :pla_portion, :pla_prix, :pla_cat_id_ce)",
                ["pla_nom" => $pla_nom,
                 "pla_detail" => $pla_detail,
                 "pla_portion" => $pla_portion,
                 "pla_prix" => $pla_prix,
                 "pla_cat_id_ce" => $pla_cat_id_ce
                ]);
    }

    public function retirer($plaId)
    {
        $this->supprimer("DELETE FROM plat WHERE pla_id=:pla_id"
            , ['pla_id' => $plaId]);
    }

    public function changer($plat)
    {
        extract($plat);
        $this->modifier("UPDATE plat 
                            SET 
                                pla_nom = :pla_nom,
                                pla_detail = :pla_detail,
                                pla_portion = :pla_portion,
                                pla_prix = :pla_prix,
                                pla_cat_id_ce = :pla_cat_id_ce
                            WHERE 
                                pla_id=:pla_id",
                            ["pla_id" => $pla_id,
                             "pla_nom" => $pla_nom,
                             "pla_detail" => $pla_detail,
                             "pla_portion" => $pla_portion,
                             "pla_prix" => $pla_prix,
                             "pla_cat_id_ce" => $pla_cat_id_ce
                            ]);
    }
}