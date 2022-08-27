<?php
class ContactModele extends AccesBd
{
    /**
     * Cherche tout les enregistrements de la table contact
     */
    public function tout()
    {
        $idUtilisateur = $_SESSION["utilisateur"]->uti_id;
        return $this->lireTout("SELECT contact.*, telephone.* FROM contact JOIN telephone ON tel_ctc_id_ce = ctc_id WHERE ctc_uti_id_ce = $idUtilisateur ORDER BY ctc_prenom");
    }

    public function ajouter($contact)
    {
        extract($contact);
        $this->creer(
            "INSERT INTO plat VALUES (0, :pla_nom, :pla_detail, :pla_portion, :pla_prix, :pla_cat_id_ce)",
                ["pla_nom" => $pla_nom,
                 "pla_detail" => $pla_detail,
                 "pla_portion" => $pla_portion,
                 "pla_prix" => $pla_prix,
                 "pla_cat_id_ce" => $pla_cat_id_ce
                ]);
    }
    
    public function modification($contact)
    {
        extract($contact);
        $this->modifier("UPDATE contact, telephone
                            SET 
                                ctc_prenom = :ctc_prenom,
                                ctc_nom = :ctc_nom,
                                tel_numero = :tel_numero,
                                tel_type = :tel_type,
                                tel_poste = :tel_poste
                            WHERE 
                                ctc_id = :ctc_id
                            AND 
                                tel_ctc_id_ce = :tel_ctc_id_ce",
                            ["ctc_id" => $ctc_id,
                            "ctc_prenom" => $ctc_prenom,
                            "ctc_nom" => $ctc_nom,
                            "tel_numero" => $tel_numero,
                            "tel_type" => $tel_type,
                            "tel_poste" => $tel_poste,
                            "tel_ctc_id_ce" => $tel_ctc_id_ce
                            ]);
    }


    public function suppression($contactId)
    {
        $this->supprimer("DELETE FROM contact WHERE ctc_id=:ctc_id"
        , ['ctc_id' => $contactId]);
    }
}