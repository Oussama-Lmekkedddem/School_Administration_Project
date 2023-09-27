<?php

class Groupe {
    protected $id;
    protected $nom;
    protected $coursId;
    protected $professeurId;
    protected $listeEtudiants;

    public function __construct($id, $nom, $coursId, $professeurId, $listeEtudiants = []) {
        $this->id = $id;
        $this->nom = $nom;
        $this->coursId = $coursId;
        $this->professeurId = $professeurId;
        $this->listeEtudiants = $listeEtudiants;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getCoursId() {
        return $this->coursId;
    }

    public function getProfesseurId() {
        return $this->professeurId;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setCoursId($coursId) {
        $this->coursId = $coursId;
    }

    public function setProfesseurId($professeurId) {
        $this->professeurId = $professeurId;
    }


    public static function ajouterGroupe($nom, $coursId, $professeurId) {
        $db = new Database();
        $conn = $db->getConnection();
        $query = "INSERT INTO Groupes (nom, coursId, professeurId) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$nom, $coursId, $professeurId]);
    }
    
    public static function supprimerGroupe($id) {
       $db = new Database();
       $conn = $db->getConnection();
       
       $query = "DELETE FROM reservations WHERE groupeId = ?";
       $stmt = $conn->prepare($query);
       $stmt->execute([$id]);

       $query = "DELETE FROM GroupesEtudiants WHERE groupeId = ?";
       $stmt = $conn->prepare($query);
       $stmt->execute([$id]);
       
       $query = "DELETE FROM Groupes WHERE id = ?";
       $stmt = $conn->prepare($query);
       $stmt->execute([$id]);
    }
    
    
    public static function obtenirGroupe($id) {
        $db = new Database();
        $conn = $db->getConnection();
    
        $query = "SELECT G.id, G.nom, C.nom AS nom_cours, P.nom AS nom_professeur, P.prenom AS prenom_professeur
                  FROM Groupes G
                  INNER JOIN Cours C ON G.coursId = C.id
                  INNER JOIN Professeurs Pr ON G.professeurId = Pr.id
                  INNER JOIN Personnes P ON Pr.id = P.id
                  WHERE G.id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':id' => $id]);
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    
        if ($result) {
            $nomProfesseur = $result['nom_professeur'] . " " . $result['prenom_professeur'];
            return new Groupe($result['id'], $result['nom'], $result['nom_cours'], $nomProfesseur);
        } else {
            return null;
        }
    }
    
    public static function obtenirTousGroupes() {
        $db = new Database();
        $conn = $db->getConnection();
    
        $query = "SELECT G.id, G.nom, C.nom AS nom_cours, P.nom AS nom_professeur, P.prenom AS prenom_professeur
                  FROM Groupes G
                  INNER JOIN Cours C ON G.coursId = C.id
                  INNER JOIN Professeurs Pr ON G.professeurId = Pr.id
                  INNER JOIN Personnes P ON Pr.id = P.id";
                  
        $stmt = $conn->prepare($query);
        $stmt->execute();
    
        $groupes = [];
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $groupes[] = [
                'id' => $row['id'],
                'nom' => $row['nom'],
                'cours' => $row['nom_cours'],
                'professeur' => $row['nom_professeur'] . ' ' . $row['prenom_professeur']
            ];
        }
    
        $stmt->closeCursor();
    
        return $groupes;
    }


    public static function obtenirProfGroupes($id) {
        $db = new Database();
        $conn = $db->getConnection();
    
        $query = "SELECT G.id, G.nom, C.nom AS nom_cours, P.nom AS nom_professeur, P.prenom AS prenom_professeur
                  FROM Groupes G
                  INNER JOIN Cours C ON G.coursId = C.id
                  INNER JOIN Professeurs Pr ON G.professeurId = Pr.id
                  INNER JOIN Personnes P ON Pr.id = P.id
                  WHERE G.professeurId = ?";
    
                  $stmt = $conn->prepare($query);
                  $stmt->execute([$id]);
    
        $groupes = [];
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $groupes[] = [
                'id' => $row['id'],
                'nom' => $row['nom'],
                'cours' => $row['nom_cours'],
                'professeur' => $row['nom_professeur'] . ' ' . $row['prenom_professeur']
            ];
        }
    
        $stmt->closeCursor();
    
        return $groupes;
    }
    
    public static function modifierGroupe($id, $nom, $coursId, $professeurId) {
        $db = new Database();
        $conn = $db->getConnection();
    
        $query = "UPDATE Groupes SET nom = ?, coursId = ?, professeurId = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$nom, $coursId, $professeurId, $id]);
    }
    
    public static function ajouterEtudiant($groupeId, $etudiantId) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "INSERT INTO GroupesEtudiants (groupeId, etudiantId) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$groupeId, $etudiantId]);
    }

    public static function supprimerEtudiant($groupeId, $etudiantId) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "DELETE FROM GroupesEtudiants WHERE groupeId = ? AND etudiantId = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$groupeId, $etudiantId]);
    }

    public static function obtenirEtudiantsParGroupe($groupeId) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT P.id, P.nom, P.prenom, N.nom AS niveau
                  FROM GroupesEtudiants GE
                  JOIN Etudiants E ON GE.etudiantId = E.id
                  JOIN Personnes P ON E.id = P.id
                  JOIN Niveaux N ON E.niveauId = N.id
                  WHERE GE.groupeId = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$groupeId]);

        $etudiants = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $etudiants[] = [
                'id' => $row['id'],
                'nom' => $row['nom'],
                'prenom' => $row['prenom'],
                'niveau' => $row['niveau']
            ];
        }

        $stmt->closeCursor();

        return $etudiants;
    }

    public static function obtenirGroupesEtudiant($Id) {
        $db = new Database();
        $conn = $db->getConnection();
    
        $query = "SELECT P.id, P.nom, P.prenom, C.id AS cours_id, GE.groupeId AS groupe_id, G.nom AS nom_groupe, C.nom AS nom_cours
                  FROM GroupesEtudiants GE
                  INNER JOIN Etudiants E ON GE.etudiantId = E.id
                  INNER JOIN Personnes P ON E.id = P.id
                  INNER JOIN Groupes G ON GE.groupeId = G.id
                  INNER JOIN Cours C ON G.coursId = C.id
                  WHERE E.id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$Id]);
    
        $groupes = [];
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $groupes[] = [
                'id' => $row['id'],
                'nom' => $row['nom'],
                'prenom' => $row['prenom'],
                'groupe_id' => $row['groupe_id'],
                'nom_groupe' => $row['nom_groupe'],
                'cours_id' => $row['cours_id'],
                'nom_cours' => $row['nom_cours']
            ];
        }
    
        $stmt->closeCursor();
    
        return $groupes;
    }
    
    
    public static function obtenirGroupeEtudiant($Idgroupe, $idetudiant) {
        $db = new Database();
        $conn = $db->getConnection();
    
        $query = "SELECT P.id, P.nom, P.prenom, C.id AS cours_id, GE.groupeId AS groupe_id, G.nom AS nom_groupe, C.nom AS nom_cours
                  FROM GroupesEtudiants GE
                  INNER JOIN Etudiants E ON GE.etudiantId = E.id
                  INNER JOIN Personnes P ON E.id = P.id
                  INNER JOIN Groupes G ON GE.groupeId = G.id
                  INNER JOIN Cours C ON G.coursId = C.id
                  WHERE GE.groupeId = ? AND GE.etudiantId = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$Idgroupe, $idetudiant]);
    
        $groupe = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $stmt->closeCursor();
    
        return $groupe;
    }
    
    public static function etudiantExisteDansGroupe($groupeId, $etudiantId) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT COUNT(*) AS count FROM GroupesEtudiants
                  WHERE groupeId = ? AND etudiantId = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$groupeId, $etudiantId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];

        return $count > 0;
    }

}
