<?php
class Cours {
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

    public static function obtenirCoursParId($id) {
        $db = new Database();
        $conn = $db->getConnection();
    
        $query = "SELECT * FROM Cours
                  WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);          

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return new Cours($result['id'], $result['nom'], $result['prix']);
        } else {
            return null;
        }
    }

    public static function obtenirToutesLesCours() {
        $db = new Database();
        $conn = $db->getConnection();
    
        $query = "SELECT * FROM Cours";
        $stmt = $conn->query($query);
    
        $cours = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cours[] = new Cours($row['id'], $row['nom'], $row['prix']);
        }
        return $cours;
    }
    
}

class Formation extends Cours  {
    protected $prix;

    public function __construct($id, $nom, $prix) {
        parent::__construct($id, $nom);
        $this->prix = $prix;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }

    public static function ajouterFormation($id, $nom, $prix) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "INSERT INTO Cours (id, nom) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id, $nom]);

        $query = "INSERT INTO Formations (id, prix) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id, $prix]);
    }

    
    public static function supprimerFormation($id) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "DELETE FROM Formations WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);

        $query = "DELETE FROM Cours WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
    }

    public static function modifierFormation($id, $nouveauNom, $nouveauPrix) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "UPDATE Cours SET nom = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$nouveauNom, $id]);

        $query = "UPDATE Formations SET prix = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$nouveauPrix, $id]);
    }

    public static function obtenirFormationParId($id) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT C.id, C.nom, F.prix FROM Cours C
                  INNER JOIN Formations F ON C.id = F.id
                  WHERE C.id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return new Formation($result['id'], $result['nom'], $result['prix']);
        } else {
            return null;
        }
    }

    public static function obtenirToutesLesFormations() {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT C.*, F.* FROM Cours C
                  INNER JOIN Formations F ON C.id = F.id";
        $stmt = $conn->query($query);

        $formations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $formations[] = new Formation($row['id'], $row['nom'], $row['prix']);
        }
        return $formations;
    }
}

class Matiere extends Cours {
    protected $niveauId;
    protected $prix;

    public function __construct($id, $nom, $niveauId, $prix) {
        parent::__construct($id, $nom);
        $this->niveauId = $niveauId;
        $this->prix = $prix;
    }

    public function getNiveauId() {
        return $this->niveauId;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function setNiveauId($niveauId) {
        $this->niveauId = $niveauId;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }

    public static function ajouterMatiere($id, $nom, $niveauId, $prix) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "INSERT INTO Cours (id, nom) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id, $nom]);

        $query = "INSERT INTO Matieres (id, niveauId, prix) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id, $niveauId, $prix]);
    }

    public static function supprimerMatiere($id) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "DELETE FROM Matieres WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);

        $query = "DELETE FROM Cours WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
    }

    public static function modifierMatiere($id, $nouveauNom, $nouveauNiveauId, $nouveauPrix) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "UPDATE Cours SET nom = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$nouveauNom, $id]);

        $query = "UPDATE Matieres SET niveauId = ?, prix = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$nouveauNiveauId, $nouveauPrix, $id]);
    }

    public static function obtenirMatiereParId($id) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT C.id, C.nom, M.niveauId, M.prix FROM Cours C
                  INNER JOIN Matieres M ON C.id = M.id
                  WHERE C.id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return new Matiere($result['id'], $result['nom'], $result['niveauId'], $result['prix']);
        } else {
            return null;
        }
    }

    public static function obtenirToutesLesMatieres() {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT C.id, C.nom, M.niveauId, M.prix FROM Cours C
                  INNER JOIN Matieres M ON C.id = M.id";

        $query = "SELECT C.*, M.*, N.nom AS niveau_nom FROM Cours C
                  INNER JOIN Matieres M ON C.id = M.id
                  INNER JOIN Niveaux N ON M.niveauId = N.id"; 
        $stmt = $conn->query($query);

        $matieres = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $matieres[] = new Matiere($row['id'], $row['nom'], $row['niveau_nom'], $row['prix']);
        }
        return $matieres;
    }
}



