<?php

class Paiement {
    protected $etudiantId;
    protected $coursId;
    protected $montant;
    protected $datePaiement;

    public function __construct($etudiantId, $coursId, $montant, $datePaiement) {
        $this->etudiantId = $etudiantId;
        $this->coursId = $coursId;
        $this->montant = $montant;
        $this->datePaiement = $datePaiement;
    }

    public function getEtudiantId() {
        return $this->etudiantId;
    }

    public function getCoursId() {
        return $this->coursId;
    }

    public function getMontant() {
        return $this->montant;
    }

    public function getDatePaiement() {
        return $this->datePaiement;
    }

    public static function ajouterPaiement($etudiantId, $coursId, $montant, $datePaiement) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "INSERT INTO Paiements (etudiantId, coursId, montant, datePaiement)
                  VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$etudiantId, $coursId, $montant, $datePaiement]);
    }

    public static function supprimerPaiementCours($etudiantId, $coursId) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "DELETE FROM Paiements WHERE etudiantId = ? AND coursId = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$etudiantId, $coursId]);
    }
    
    public static function supprimerPaiement($etudiantId, $coursId, $montant, $datePaiement) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "DELETE FROM Paiements WHERE etudiantId = ? AND coursId = ? AND montant = ? AND datePaiement = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$etudiantId, $coursId, $montant, $datePaiement]);
    }

    public static function modifierPaiement($etudiantId, $coursId, $nouveauMontant, $nouvelleDatePaiement) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "UPDATE Paiements SET montant = ?, datePaiement = ?
                  WHERE etudiantId = ? AND coursId = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$nouveauMontant, $nouvelleDatePaiement, $etudiantId, $coursId]);
    }

    public static function afficherPaiementsEtudiantCours($etudiantId, $coursId) {
        $db = new Database();
        $conn = $db->getConnection();
    
        $query = "SELECT etudiantId, coursId, montant,datePaiement, MONTH(datePaiement) AS moisPaiement FROM Paiements WHERE etudiantId = ? AND coursId = ? ORDER BY datePaiement DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute([$etudiantId, $coursId]);
    
        $paiements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $paiements[] = new Paiement($row['etudiantId'], $row['coursId'], $row['montant'], $row['datePaiement'], $row['moisPaiement']);
        }
        return $paiements;
    }
    
    

    public static function afficherPaiementsEtudiant($etudiantId) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT * FROM Paiements WHERE etudiantId = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute($etudiantId);

        $paiements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $paiements[] = new Paiement($row['etudiantId'], $row['coursId'], $row['montant'], $row['datePaiement']);
        }
        return $paiements;
    }

    public static function notifierNonPaiement() {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $dateActuelle = date("Y-m-d");
            
            $dateLimite = date("Y-m-d", strtotime("-1 month", strtotime($dateActuelle)));
    
            $query = "SELECT P.nom AS nom_etudiant, P.prenom AS prenom_etudiant, C.nom AS nom_cours
                      FROM Etudiants E
                      INNER JOIN Personnes P ON P.id = E.id
                      INNER JOIN Paiements Pa ON E.id = Pa.etudiantId
                      INNER JOIN Cours C ON Pa.coursId = C.id
                      WHERE Pa.etudiantId IS NULL OR  Pa.datePaiement < :dateLimite";
    
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":dateLimite", $dateLimite, PDO::PARAM_STR);
            $stmt->execute();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row['nom_etudiant'] && $row['prenom_etudiant'] && $row['nom_cours']) {
                    echo "<div class=\"notification_case\"><p>L'étudiant " . $row['nom_etudiant'] . ' ' . $row['prenom_etudiant'] . " n'a pas effectué de paiement pour le cours " . $row['nom_cours'] . " depuis plus d'un mois.</p></div>";
                } else {
                    echo "<div class=\"notification_case\"><p>L'étudiant " . $row['nom_etudiant'] . ' ' . $row['prenom_etudiant'] . " n'a jamais effectué de paiement pour le cours  " . $row['nom_cours'] . " .<p></div>";
                }
            }
            
            $conn = null;
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }
}
