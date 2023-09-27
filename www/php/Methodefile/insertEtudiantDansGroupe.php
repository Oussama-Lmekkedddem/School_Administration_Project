<?php
include('../Groupe.php');
include('../Database.php');

?>


<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $groupeId = $_POST["groupeId"];
    $etudiantIds = $_POST["etudiantIds"];

    foreach ($etudiantIds as $etudiantId) {
        Groupe::ajouterEtudiant($groupeId, $etudiantId);
    }

    header("Location: ../../index/Groupe.php?id=$groupeId");
} else {
    echo "Invalid request";
}
    
