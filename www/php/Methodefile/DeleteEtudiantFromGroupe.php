<?php
include('../Database.php');
include('../Groupe.php');
?>

<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $groupeId = $_POST['groupe_id'];
    $etudiantId = $_POST['etudiant_id'];

    Groupe::supprimerEtudiant($groupeId, $etudiantId);

    header("Location: ../../index/Groupe.php?id=$groupeId");
    exit;
}

?>