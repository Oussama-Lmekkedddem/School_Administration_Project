<?php
include('Reservation.php');
include('Personne.php');
include('Cour.php');


class EmploiDuTemps {
    public static function afficherEmploiDuTempsSalle($salleId) {
        $reservations = Reservation::afficherReservationSalle($salleId);
    
        function comparerReservations($a, $b) {
            $jours = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            
            $jourA = array_search($a['jour'], $jours);
            $jourB = array_search($b['jour'], $jours);
            if ($jourA != $jourB) {
                return $jourA - $jourB;
            }
            
            $heureA = intval($a['heure']);
            $heureB = intval($b['heure']);
            return $heureA - $heureB;
        }
    
        usort($reservations, 'comparerReservations');
    
        $emploiDuTemps = [];
    
        foreach ($reservations as $reservation) {
            $id = $reservation['id'];
            $jour = $reservation['jour'];
            $heure = $reservation['heure'];
            $groupeId = $reservation['groupeId'];
    
            $groupe = Groupe::obtenirGroupe($groupeId);
            $nomGroupe = $groupe->getNom();
            $nomProfesseur = $groupe->getProfesseurId();
            $nomMatiereFormation = $groupe->getCoursId();

            $emploiDuTemps[] = [
                "groupeId" => $groupeId,
                "id" => $id,
                "jour" => $jour,
                "heure" => $heure,
                "nomGroupe" => $nomGroupe,
                "nomProfesseur" => $nomProfesseur,
                "nomMatiereFormation" => $nomMatiereFormation
            ];
        }
        return $emploiDuTemps;
    }
    
    
    public static function afficherTableauEmploiDuTempsSalle($salleId) {
        $emploiDuTemps = self::afficherEmploiDuTempsSalle($salleId);

        echo '<div class="tableemploi">';
        echo '<div class="container">';
        echo '<div class="row">';
        echo '<div class="col-md-12">';
        echo '<div class="schedule-table">';
        echo '<table class="table bg-white">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Emploi</th>';
        echo '<th>08-09 am</th>';
        echo '<th>09-10 am</th>';
        echo '<th>10-11 am</th>';
        echo '<th>11-12 am</th>';
        echo '<th>14-15 pm</th>';
        echo '<th>15-16 pm</th>';
        echo '<th>16-17 pm</th>';
        echo '<th class="last">17-18 pm</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $joursSemaine = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

        foreach ($joursSemaine as $jour) {
            echo '<tr>';
            echo '<td class="day">' . $jour . '</td>';
            foreach (array("08-09 am", "09-10 am", "10-11 am", "11-12 am", "02-03 pm", "03-04 pm", "04-05 pm", "05-06 pm") as $heure) {
                $cours = self::trouverCours($emploiDuTemps, $jour, $heure);
                echo '<td class="active">';
                if ($cours !== false) {
                    echo '<h4>' . $cours['nomMatiereFormation'] . '</h4>';
                    echo '<p>' . $cours['nomGroupe'] . '</p>';
                    echo '<div class="hover">';
                    echo '<h4>' . $cours['nomMatiereFormation'] . '</h4>';
                    echo '<p>' . $cours['nomGroupe'] . '</p>';
                    echo '<p>' . $cours['nomProfesseur'] . '</p>';
                    echo '</div>';
                }
                echo '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    private static function trouverCours($emploiDuTemps, $jour, $heure) {
        foreach ($emploiDuTemps as $cours) {
            if ($cours['jour'] === $jour && $cours['heure'] === $heure) {
                return $cours;
            }
        }
        return false;
    }
}

















/*
class EmploiDuTemps {
    protected $semaine;
    protected $cours; // Vous devrez stocker les cours ici, par exemple dans un tableau

    public function __construct($semaine) {
        $this->semaine = $semaine;
        $this->cours = [];
    }

    public function ajouterCours($cours) {
        $this->cours[] = $cours;
    }

    public function afficherEmploi() {
        echo "<h2>Emploi du temps - Semaine " . $this->semaine . "</h2>";
        echo "<table>";
        echo "<tr><th>Jour</th><th>Heure</th><th>Matière</th><th>Salle</th></tr>";
        
        foreach ($this->cours as $cours) {
            echo "<tr>";
            echo "<td>" . $cours->getJour() . "</td>";
            echo "<td>" . $cours->getHeure() . "</td>";
            echo "<td>" . $cours->getMatiere() . "</td>";
            echo "<td>" . $cours->getSalle() . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
}




$salle1 = new Salle(1, "Salle A");
$salle2 = new Salle(2, "Salle B");

$emploiDuTemps = new EmploiDuTemps(1);

// Création de quelques cours
$cours1 = new Cours("Lundi", "10:00", "Mathématiques", $salle1);
$cours2 = new Cours("Mardi", "14:00", "Histoire", $salle2);

$emploiDuTemps->ajouterCours($cours1);
$emploiDuTemps->ajouterCours($cours2);

// Affichage de l'emploi du temps
$emploiDuTemps->afficherEmploi();
*/