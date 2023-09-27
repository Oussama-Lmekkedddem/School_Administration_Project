<?php
include('../../php/Cour.php');
include('../../php/Database.php');
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        Matiere::modifierMatiere(
            $_POST['matiere_id'],
            $_POST['nouveau_nom_m'],
            $_POST['nouveau_niveau_m'],
            $_POST['nouveau_prix_m'],
        );
    
        header('Location: ../../index/Formation.php');
        exit;

}

?>