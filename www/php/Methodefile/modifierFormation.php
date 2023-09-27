<?php
include('../../php/Cour.php');
include('../../php/Database.php');
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Formation::modifierFormation(
        $_POST['formation_id'],
        $_POST['nouveau_nom_f'],
        $_POST['nouveau_prix_f'],
    );

    header('Location: ../../index/Formation.php');
    exit;
}
?>