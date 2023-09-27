<?php
include('../../php/Personne.php');
include('../../php/Database.php');
?>

<?php


if (isset($_POST['professeur_id'])) {
    $professeurId = $_POST['professeur_id'];
    Professeur::supprimerProfesseur($professeurId);

    header('Location: ../../index/Listes_professeurs.php');
    exit;
}


?>