<?php
include('../../php/Paiement.php');
include('../../php/Database.php');
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Paiement::modifierPaiement(
      $_POST['id_etudiant'],
      $_POST['id_cours'],
      $_POST['montant'],
      $_POST['datePaiement']
  );

  $redirectUrl = "../../index/Etudiant.php?id=" . $_POST['id_etudiant'];
  header("Location: $redirectUrl");
  exit;
}
?>