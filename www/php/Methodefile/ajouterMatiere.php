<?php
include('../../php/Cour.php');
include('../../php/Salle_Niveau.php');
include('../../php/Database.php');
?>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Matiere::ajouterMatiere(
      $_POST['id_m'],
      $_POST['nom_m'],
      $_POST['niveau_id_m'],
      $_POST['prix_m'],
  );

  header('Location: ../../index/Formation.php');
  exit;
}
?>