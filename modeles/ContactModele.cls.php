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

        foreach($contacts as $contact){
            $ctc_id = $contact->ctc_id;
            $nomComplet = $contact->ctc_prenom. " " .$contact->ctc_nom;
            $telephones = [];
            $telephone[$nomComplet] = $this->lireTout("SELECT telephone.*, ctc_id, ctc_prenom, ctc_nom from telephone JOIN contact ON ctc_id = tel_ctc_id_ce WHERE tel_ctc_id_ce = $ctc_id");
            array_push($telephones, $telephone);
        }
        $tabTelParContact = $telephones[0];

        return $tabTelParContact;
    }


    /**
     * Méthode qui prépare une requête sql de type INSERT pour ajouter un contact et un/des numéro(s) de téléphone(s)
     * Envoyé à la méthode creer de AccesBd qui traite la requête
     * 
     * @param  $contact array
     */
    public function ajout($contact)
    {
        extract($contact);
        $idUtilisateur = $_SESSION["utilisateur"]->uti_id;

        $lastInsertId = $this->creer("INSERT INTO contact (ctc_prenom, ctc_nom, ctc_uti_id_ce) VALUES (:ctc_prenom, :ctc_nom, :ctc_uti_id_ce)",
                        [   "ctc_prenom" => $ctc_prenom,
                            "ctc_nom" => $ctc_nom,
                            "ctc_uti_id_ce" => $idUtilisateur
                        ]);

        for ($i=0; $i < $nbEntre; $i++) {
            // Concaténation du nom et affectation des variables reçus vers les même variables utilisés dans la requête préparé
            // Celles qu'on reçoit en GET s'appellent telNumero1, telNumero2, ect...
            $tel_numero = ${"telNumero" . $i + 1};
            $tel_type = ${"telType" . $i + 1};
            $tel_poste = ${"telPoste" . $i + 1};

            $this->creer("INSERT INTO telephone (tel_numero, tel_type, tel_poste, tel_ctc_id_ce) VALUES (:tel_numero, :tel_type, :tel_poste, :tel_ctc_id_ce);",
            [
                "tel_numero" => $tel_numero,
                "tel_type" => $tel_type,
                "tel_poste" => $tel_poste,
                "tel_ctc_id_ce" => $lastInsertId
            ]);
        }
    }
    

    /**
     * Méthode qui prépare une requête sql de type UPDATE pour modifier les informations d'un contact et son/ses numéro(s) de téléphon(s)
     * Envoyé à la méthode modification de AccesBd qui traite la requête
     * 
     * @param  $contact array
     */
    public function modification($contact)
    {
        extract($contact);

        for ($i=0; $i < $nbEntre; $i++) { 
            // Concaténation du nom et affectation des variables reçus vers les même variables utilisés dans la requête préparé
            // Celles qu'on reçoit en GET s'appellent telNumero1, telNumero2, ect...
            $tel_numero = ${"telNumero" . $i + 1};
            $tel_type = ${"telType" . $i + 1};
            $tel_poste = ${"telPoste" . $i + 1};
            $tel_id = ${"telId" . $i + 1};

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
                                tel_ctc_id_ce = :tel_ctc_id_ce
                            AND
                                tel_id = :tel_id",
                            [   "ctc_id" => $ctc_id,
                                "ctc_prenom" => $ctc_prenom,
                                "ctc_nom" => $ctc_nom,
                                "tel_numero" => $tel_numero,
                                "tel_type" => $tel_type,
                                "tel_poste" => $tel_poste,
                                "tel_ctc_id_ce" => $tel_ctc_id_ce,
                                "tel_id" => $tel_id
                            ]);
        }
    }


    /**
     * Méthode qui prépare une transaction sql de type DELETE pour supprimer un contact ainsi que son/ses numéro(s) de téléphone(s)
     * Envoyé à la méthode suppression de AccesBd qui traite la requête
     * 
     * @param $contactId int
     */
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