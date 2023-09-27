<?php
include('../../php/Cour.php');
include('../../php/Database.php');
?>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Formation::ajouterFormation(
      $_POST['id_f'],
      $_POST['nom_f'],
      $_POST['prix_f'],
  );

  header('Location: ../../index/Formation.php');
  exit;
}