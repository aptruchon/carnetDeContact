<?php
class ContactModele extends AccesBd
{
    /**
     * Cherche tout les enregistrements de la table contact
     */
    public function tout()
    {
        $idUtilisateur = $_SESSION["utilisateur"]->uti_id;
        $contacts = $this->lireTout("SELECT * FROM contact WHERE ctc_uti_id_ce = $idUtilisateur");
        /* var_dump($contacts); */
        foreach($contacts as $contact){
            $ctc_id = $contact->ctc_id;
            $nomComplet = $contact->ctc_prenom. " " .$contact->ctc_nom;
            $telephones = [];
            $telephone[$nomComplet] = $this->lireTout("SELECT telephone.*, ctc_id, ctc_prenom, ctc_nom from telephone JOIN contact ON ctc_id = tel_ctc_id_ce WHERE tel_ctc_id_ce = $ctc_id");
            array_push($telephones, $telephone);
        }
        $tabTelParContact = $telephones[0];

        var_dump($tabTelParContact);
        return $tabTelParContact;
        // return $this->lireTout("SELECT contact.*, telephone.* FROM contact JOIN telephone ON tel_ctc_id_ce = ctc_id WHERE ctc_uti_id_ce = $idUtilisateur ORDER BY tel_ctc_id_ce");
    }

    public function ajout($contact)
    {
        extract($contact);
        $idUtilisateur = $_SESSION["utilisateur"]->uti_id;
        $lastInsertId = $this->creer("INSERT INTO contact (ctc_prenom, ctc_nom, ctc_uti_id_ce) VALUES (:ctc_prenom, :ctc_nom, :ctc_uti_id_ce)",
                        [   "ctc_prenom" => $ctc_prenom,
                            "ctc_nom" => $ctc_nom,
                            "ctc_uti_id_ce" => $idUtilisateur
                        ]);
        $this->creer("INSERT INTO telephone (tel_numero, tel_type, tel_poste, tel_ctc_id_ce) VALUES (:tel_numero, :tel_type, :tel_poste, :tel_ctc_id_ce);",
        [
            "tel_numero" => $tel_numero,
            "tel_type" => $tel_type,
            "tel_poste" => $tel_poste,
            "tel_ctc_id_ce" => $lastInsertId
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
                            [   "ctc_id" => $ctc_id,
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
        $this->supprimer("  BEGIN;
                                DELETE FROM telephone WHERE tel_ctc_id_ce = :tel_ctc_id_ce;
                                DELETE FROM contact WHERE ctc_id=:ctc_id;
                            COMMIT",
                            [   'tel_ctc_id_ce' => $contactId,
                                'ctc_id' => $contactId
                            ]);
    }
}