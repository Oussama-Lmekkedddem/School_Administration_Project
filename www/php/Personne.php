<?php
include('Groupe.php');


class Personne {
    protected $id;
    protected $nom;
    protected $prenom;
    protected $tel;
    protected $mail;
    protected $dateInscription;

    public function __construct($id, $nom, $prenom, $tel, $mail, $dateInscription) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->tel = $tel;
        $this->mail = $mail;
        $this->dateInscription = $dateInscription;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getTel() {
        return $this->tel;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getDateInscription() {
        return $this->dateInscription;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setTel($tel) {
        $this->tel = $tel;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function setDateInscription($dateInscription) {
        $this->dateInscription = $dateInscription;
    }
}

class Etudiant extends Personne {
    protected $niveauId;

    public function __construct($id, $nom, $prenom, $tel, $mail, $dateInscription, $niveauId) {
        parent::__construct($id, $nom, $prenom, $tel, $mail, $dateInscription);
        $this->niveauId = $niveauId;
    }

    public function getNiveauId() {
        return $this->niveauId;
    }

    public function setNiveauId($niveauId) {
        $this->niveauId = $niveauId;
    }

    public static function ajouterEtudiant($id, $nom, $prenom, $tel, $mail, $dateInscription, $niveauId) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "INSERT INTO Personnes (id, nom, prenom, tel, mail, dateInscription) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id, $nom, $prenom, $tel, $mail, $dateInscription]);

        $query = "INSERT INTO Etudiants (id, niveauId) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id, $niveauId]);
    }

    public static function supprimerEtudiant($id) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "DELETE FROM Paiements WHERE etudiantId = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);

        $query = "DELETE FROM GroupesEtudiants WHERE etudiantId = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);

        $query = "DELETE FROM Etudiants WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);

        $query = "DELETE FROM Personnes WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
    }

    public static function modifierEtudiant($id, $nouveauNom, $nouveauPrenom, $nouveauTel, $nouveauMail, $nouvelleDateInscription, $nouveauNiveauId) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "UPDATE Personnes SET nom = ?, prenom = ?, tel = ?, mail = ?, dateInscription = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$nouveauNom, $nouveauPrenom, $nouveauTel, $nouveauMail, $nouvelleDateInscription, $id]);

        $query = "UPDATE Etudiants SET niveauId = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$nouveauNiveauId, $id]);
    }

    public static function obtenirEtudiantParId($id) {
        $db = new Database();
        $conn = $db->getConnection();
    
        $query = "SELECT P.*, E.niveauId, N.nom AS niveau_nom FROM Personnes P
                  INNER JOIN Etudiants E ON P.id = E.id
                  INNER JOIN Niveaux N ON E.niveauId = N.id
                  WHERE P.id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return new Etudiant(
                $result['id'],
                $result['nom'],
                $result['prenom'],
                $result['tel'],
                $result['mail'],
                $result['dateInscription'],
                $result['niveau_nom']
            );
        } else {
            return null;
        }
    }
    
    public static function obtenirTousLesEtudiants() {
        $db = new Database();
        $conn = $db->getConnection();
    
        $query = "SELECT P.*, E.niveauId, N.nom AS niveau_nom FROM Personnes P
                  INNER JOIN Etudiants E ON P.id = E.id
                  INNER JOIN Niveaux N ON E.niveauId = N.id";
        $stmt = $conn->query($query);
    
        $etudiants = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $etudiants[] = new Etudiant(
                $row['id'],
                $row['nom'],
                $row['prenom'],
                $row['tel'],
                $row['mail'],
                $row['dateInscription'],
                $row['niveau_nom']
            );
        }
        return $etudiants;
    }
    
}


class Professeur extends Personne {
    protected $metier;

    public function __construct($id, $nom, $prenom, $tel, $mail, $dateInscription, $metier) {
        parent::__construct($id, $nom, $prenom, $tel, $mail, $dateInscription);
        $this->metier = $metier;
    }

    public function getMetier() {
        return $this->metier;
    }

    public function setMetier($metier) {
        $this->metier = $metier;
    }

        public static function afficherProfesseurs() {
            $db = new Database();
            $conn = $db->getConnection();
    
            $query = "SELECT * FROM Professeurs INNER JOIN Personnes ON Professeurs.id = Personnes.id";
            $result = $conn->query($query);
    
            $professeurs = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $professeur = new Professeur($row['id'], $row['nom'], $row['prenom'], $row['tel'], $row['mail'], $row['dateInscription'], $row['metier']);
                $professeurs[] = $professeur;
            }
    
            return $professeurs;
        }

        public static function obtenirProfesseurParId($id) {
            $db = new Database();
            $conn = $db->getConnection();
        
            $query = "SELECT P.*, Pr.metier FROM Personnes P
                      INNER JOIN Professeurs Pr ON P.id = Pr.id
                      WHERE P.id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$id]);
        
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return new Professeur(
                    $result['id'],
                    $result['nom'],
                    $result['prenom'],
                    $result['tel'],
                    $result['mail'],
                    $result['dateInscription'],
                    $result['metier']
                );
            } else {
                return null;
            }
        }
        
        public static function ajouterProfesseur($id, $nom, $prenom, $tel, $mail, $dateInscription, $metier) {
            $db = new Database();
            $conn = $db->getConnection();
    
            $query = "INSERT INTO Personnes (id, nom, prenom, tel, mail, dateInscription) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$id, $nom, $prenom, $tel, $mail, $dateInscription]);
    
            $query = "INSERT INTO Professeurs (id, metier) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$id, $metier]);
        }
    
        public static function supprimerProfesseur($id) {
            $db = new Database();
            $conn = $db->getConnection();

            $query = "SELECT id AS groupeId FROM Groupes WHERE professeurId = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$id]);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $groupeId = $row['groupeId'];
              Groupe::supprimerGroupe($groupeId);
            }
    
            $query = "DELETE FROM Professeurs WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$id]);
    
            $query = "DELETE FROM Personnes WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$id]);
        }

        public static function modifierProfesseur($id, $nouveauNom, $nouveauPrenom, $nouveauTel, $nouveauMail, $nouvelleDateInscription, $nouveauMetier) {
            $db = new Database();
            $conn = $db->getConnection();
        
            $query = "UPDATE Personnes SET nom = ?, prenom = ?, tel = ?, mail = ?, dateInscription = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$nouveauNom, $nouveauPrenom, $nouveauTel, $nouveauMail, $nouvelleDateInscription, $id]);
        
            $query = "UPDATE Professeurs SET metier = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$nouveauMetier, $id]);
        }
        
}
