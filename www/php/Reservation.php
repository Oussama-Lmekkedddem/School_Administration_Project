<?php
include('Salle_Niveau.php');


class Reservation {
    protected $id;
    protected $salleId;
    protected $jour;
    protected $heure;
    protected $groupeId;

    public function __construct($id, $salleId, $jour, $heure, $groupeId) {
        $this->id = $id;
        $this->salleId = $salleId;
        $this->jour = $jour;
        $this->heure = $heure;
        $this->groupeId = $groupeId;
    }

    public static function ajouterReservation($salleId, $groupeId, $jour, $heure) {
        $db = new Database();
        $conn = $db->getConnection();

        $disponibilite = Salle::verifierDisponibilite($salleId, $jour, $heure);

        if (empty($disponibilite)) {
            $query = "INSERT INTO reservations (salleId, groupeId, jour, heure) VALUES (:salleId, :groupeId, :jour, :heure)";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':salleId', $salleId, PDO::PARAM_INT);
            $stmt->bindValue(':groupeId', $groupeId, PDO::PARAM_INT);
            $stmt->bindValue(':jour', $jour, PDO::PARAM_STR);
            $stmt->bindValue(':heure', $heure, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } else {
          return false;
        }
    }

    public static function modifierReservation($reservationId, $nouveauSalleId, $nouveauGroupeId, $nouveauJour, $nouveauHeure) {
        $db = new Database();
        $conn = $db->getConnection();
    
        $query = "UPDATE reservations SET salleId = :nouveauSalleId, groupeId = :nouveauGroupeId, jour = :nouveauJour, heure = :nouveauHeure WHERE id = :reservationId";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':nouveauSalleId', $nouveauSalleId, PDO::PARAM_INT);
        $stmt->bindValue(':nouveauGroupeId', $nouveauGroupeId, PDO::PARAM_INT);
        $stmt->bindValue(':nouveauJour', $nouveauJour, PDO::PARAM_STR);
        $stmt->bindValue(':nouveauHeure', $nouveauHeure, PDO::PARAM_STR);
        $stmt->bindValue(':reservationId', $reservationId, PDO::PARAM_INT);
        $stmt->execute();
    }



    public static function supprimerReservation($id) {
        $db = new Database();
        $conn = $db->getConnection();
     
         $query = "DELETE FROM reservations WHERE id = ?";
         $stmt = $conn->prepare($query);
         $stmt->execute([$id]);
     }


     public static function obtenirReservation($id) {
        $db = new Database();
        $conn = $db->getConnection();
     
        $query = "SELECT * FROM reservations WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    
        return $reservation;
     }

     public static function afficherReservation($id) {
        $reservation = Reservation::obtenirReservation($id);
        if ($reservation) {
            $jour = $reservation['jour'];
            $heure = $reservation['heure'];
            $groupeId = $reservation['groupeId'];
            $groupe = Groupe::obtenirGroupe($groupeId);
    
            $nomGroupe = $groupe->getNom();
            $nomProfesseur = $groupe->getProfesseurId();
            $nomMatiereFormation = $groupe->getCoursId();
    
            $nouvelleReservation = [
                'jour' => $jour,
                'heure' => $heure,
                'groupeId' => $groupeId,
                'nomGroupe' => $nomGroupe,
                'nomProfesseur' => $nomProfesseur,
                'nomMatiereFormation' => $nomMatiereFormation,
            ];
    
            return $nouvelleReservation;
        } else {
            return null;
        }
    }
    
    public static function afficherReservationSalle($salleId) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT id, jour, heure, groupeId FROM reservations WHERE salleId = :salleId";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':salleId', $salleId, PDO::PARAM_INT);
        $stmt->execute();

        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $reservations;
    }

    public static function afficherReservationGroupe($id) {
        $db = new Database();
        $conn = $db->getConnection();
        $query = "SELECT R.id, R.jour, R.heure, R.groupeId, S.nom 
                  FROM reservations AS R
                  INNER JOIN Salles AS S ON R.salleId = S.id
                  WHERE groupeId = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $reservations;
    }
}

