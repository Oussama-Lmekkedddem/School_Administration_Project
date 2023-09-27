<?php
include('../../php/Personne.php');
include('../../php/Cour.php');
include('../../php/Database.php');
?>

<?php


if (isset($_POST['groupe_id'])) {
    $groupeId = $_POST['groupe_id'];
    Groupe::supprimerGroupe($groupeId);

    header('Location: ../../index/Groupes.php');
    exit;
}



?>