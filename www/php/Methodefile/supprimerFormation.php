<?php
include('../../php/Cour.php');
include('../../php/Database.php');
?>

<?php


if (isset($_POST['formation_id'])) {
    $formationId = $_POST['formation_id'];
    Formation::supprimerFormation($formationId);

    header('Location: ../../index/Formation.php');
    exit;
}



?>