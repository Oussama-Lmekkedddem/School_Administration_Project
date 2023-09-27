<?php
include('../../php/Cour.php');
include('../../php/Database.php');
?>

<?php


if (isset($_POST['matiere_id'])) {
    $matiereId = $_POST['matiere_id'];
    Matiere::supprimerMatiere($matiereId);

    header('Location: ../../index/Formation.php');
    exit;
}



?>

