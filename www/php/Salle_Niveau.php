<?php

class Salle {
    protected $id;
    protected $nom;

    public function __construct($id, $nom) {
        $this->id = $id;
        $this->nom = $nom;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public static function modifierNom($id, $nouveauNom) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "UPDATE Salles SET nom = :nouveauNom WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':nouveauNom', $nouveauNom, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function ajouterSalle($id, $nom) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "INSERT INTO Salles (id, nom) VALUES (:id, :nom)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
        $stmt->execute();
    }

    public static function supprimerSalle($id) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "DELETE FROM Salles WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function verifierDisponibilite($id, $jour, $heure) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT jour, heure, groupeId FROM reservations WHERE salleId = :id AND jour = :jour AND heure = :heure";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':jour', $jour, PDO::PARAM_STR);
        $stmt->bindValue(':heure', $heure, PDO::PARAM_STR);
        $stmt->execute();

        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $reservations;
    }

    /*

    $result = Salle::verifierDisponibilite($salleId, $jour, $heureDebut, $heureFin);

if (empty($result)) {
    // La salle est disponible à cette période
    echo "La salle est disponible à {$jour}, de {$heureDebut} à {$heureFin}.";
} else {
    // La salle est réservée, afficher les détails de la réservation
    foreach ($result as $reservation) {
        echo "La salle est réservée à {$reservation['jour']}, de {$reservation['heureDebut']} à {$reservation['heureFin']} pour le groupe {$reservation['groupeId']}.";
    }
}
*/

}

class Niveau {
    protected $id;
    protected $nom;

    public function __construct($id, $nom) {
        $this->id = $id;
        $this->nom = $nom;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    // Méthode pour ajouter un nouveau niveau
    public static function ajouterNiveau($id, $nom) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "INSERT INTO Niveaux (id, nom) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id, $nom]);
    }

    // Méthode pour supprimer un niveau par ID
    public static function supprimerNiveau($id) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "DELETE FROM Niveaux WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
    }

    // Méthode pour mettre à jour le nom d'un niveau par ID
    public static function modifierNiveau($id, $nouveauNom) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "UPDATE Niveaux SET nom = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$nouveauNom, $id]);
    }

    // Méthode pour obtenir un niveau par ID
    public static function obtenirNiveauParId($id) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT * FROM Niveaux WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return new Niveau($result['id'], $result['nom']);
        } else {
            return null;
        }
    }

    // Méthode pour obtenir tous les niveaux
    public static function obtenirTousLesNiveaux() {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT * FROM Niveaux";
        $stmt = $conn->query($query);

        $niveaux = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $niveaux[] = new Niveau($row['id'], $row['nom']);
        }
        return $niveaux;
    }
}