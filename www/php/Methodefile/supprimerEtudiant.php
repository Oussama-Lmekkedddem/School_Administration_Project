<?php
include('../../php/Personne.php');
include('../../php/Database.php');
?>

<?php


if (isset($_POST['etudiant_id'])) {
    $etudiantId = $_POST['etudiant_id'];
    Etudiant::supprimerEtudiant($etudiantId);

    header('Location: ../../index/Listes_etudiants.php');
    exit;
}



?>