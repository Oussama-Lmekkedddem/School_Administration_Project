
<?php
include 'Salle_Niveau.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'])) {
    $nomNiveau = $_POST['nom'];
    $niveaux = Niveau::obtenirTousLesNiveaux();

    foreach ($niveaux as $niveau) {
        if (stripos($niveau->getNom(), $nomNiveau) !== false) {
            echo '<div onclick="selectNiveau(' . $niveau->getId() . ', \'' . $niveau->getNom() . '\')">' . $niveau->getNom() . '</div>';
        }
    }
}

