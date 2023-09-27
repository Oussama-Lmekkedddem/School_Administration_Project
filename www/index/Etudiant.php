<?php
include('../php/Personne.php');
include('../php/Database.php');
include('../php/Reservation.php');
include('../php/Paiement.php');

$etudiantId = $_GET['id'];
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Etudiant::modifierEtudiant(
        $etudiantId,
        $_POST['nouveau_nom'],
        $_POST['nouveau_prenom'],
        $_POST['nouveau_tel'],
        $_POST['nouveau_mail'],
        $_POST['nouvelle_date_inscription'],
        $_POST['nouveau_niveau_id']
    );

    header("Location: Etudiant.php?id=$etudiantId");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     
    <script src="/framework/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/framework/jquery.dataTables.min.css">
    <script src="/framework/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="/framework/bootstrap.min.css">
    <link rel="stylesheet" href="/framework/all.min.css">

    <link rel="stylesheet" href="/style/Global.css">
    <link rel="stylesheet" href="/style/Etudiant.css">
    <title>Student</title>
</head>

<?php include 'Header.php'; ?>


    <aside class="aside2">
            <?php $etudiant = Etudiant::obtenirEtudiantParId($etudiantId);

    if ($etudiant) {
            ?>
    <div class="etudiant-card">
        <div class="etudiant-info">
            <h2><?= $etudiant->getNom() . ' ' . $etudiant->getPrenom() ?></h2>
            <p>ID : <?php echo $etudiant->getId(); ?><p>
            <p>Phone number: <?= $etudiant->getTel() ?></p>
            <p>Email: <?= $etudiant->getMail() ?></p>
            <p>Registration date: <?= $etudiant->getDateInscription() ?></p>
            <p>Level: <?= $etudiant->getNiveauId() ?></p>
        </div>
    
        <div class="actions">
            <button class="btn btn-edit">Edit</button>
            <form action="../php/Methodefile/supprimerEtudiant.php" method="post" onsubmit="return confirmDelete()">
                <input type="hidden" name="etudiant_id" value="<?= $etudiant->getId(); ?>">
                <button type="submit" class="btn btn-delete">Delete</button>
            </form>
        </div>
    
    </div>
    <div class="edit-div" style="display: none;">
    <form method="post" class="edit-form">
    <div>
        <label for="nouveau_nom">New name :</label>
        <input type="text" name="nouveau_nom" value="<?= $etudiant->getNom() ?>">
    </div>
    <div>
        <label for="nouveau_prenom">New first name :</label>
        <input type="text" name="nouveau_prenom" value="<?= $etudiant->getPrenom() ?>">
    </div>
    <div>
        <label for="nouveau_tel">New phone number :</label>
        <input type="text" name="nouveau_tel" value="<?= $etudiant->getTel() ?>">
    </div>
    <div>
        <label for="nouveau_mail">Nouveau email :</label>
        <input type="text" name="nouveau_mail" value="<?= $etudiant->getMail() ?>">
    </div>
    <div>
        <label for="nouvelle_date_inscription">New registration date :</label>
        <input type="Date" name="nouvelle_date_inscription" value="<?= $etudiant->getDateInscription() ?>">
    </div>
    <div>
        <label for="nouveau_niveau_id">Level :</label>
        <select id="nouveau_niveau_id" name="nouveau_niveau_id">
            <option value="">Select a level</option>
            <?php $niveaux = Niveau::obtenirTousLesNiveaux(); ?>
            <?php foreach ($niveaux as $niveau) : ?>
                <option value="<?php echo $niveau->getId(); ?>"><?php echo $niveau->getNom(); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-edit"> Save</button>
</form>
</div>
    
    <?php
} else {
    echo '<p>Étudiant non trouvé.</p>';
}
?>
<div class="globaldivition">
    <div id="division1">
        <button id="btnPaiement"> Payment</button>
        <button id="btnCours">Course</button>
        <div id="tableau">
            <div id="tableauPaiement" style="display: none;">
                <?php $resultes = Groupe::obtenirGroupesEtudiant($etudiantId) ?>
                <?php foreach ($resultes as $resulte) : ?>
                <div class="ligne">
                  <a href="Etudiant.php?id=<?= $etudiantId ?>&cours_id=<?= $resulte['cours_id']?>"><?php echo $resulte['nom_cours']; ?></a>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="tableauCours" style="display: none;">
                <?php $resultes = Groupe::obtenirGroupesEtudiant($etudiantId) ?>
                <?php foreach ($resultes as $resulte) : ?>
                <div class="ligne">
                  <a href="Etudiant.php?id=<?= $etudiantId ?>&groupe_id=<?= $resulte['groupe_id']?>"><?php echo $resulte['nom_cours'] . ' - ' . $resulte['nom_groupe'] ;?></a>
                </div>
                <?php endforeach; ?>
            </div>
        </div> 
    </div>
    <div id="division2">
       <?php if(isset($_GET['groupe_id'])){?> 
        <div id="infosSelectionCours">
           <?php $grpstudent = Groupe::obtenirGroupeEtudiant($_GET['groupe_id'], $etudiantId) ?>
           <div>
            <p>Course name : <?php echo $grpstudent['nom_cours']; ?></p>
            <p>Group name: <?php echo $grpstudent['nom_groupe']; ?></p>
          </div>       
           <?php $reservations = Reservation::afficherReservationGroupe($_GET['groupe_id']);
            if (!empty($reservations)) { ?>
          <ul>
           <?php
            foreach ($reservations as $reservation) { ?>
              <div>
                <p>Day  : <?= $reservation['jour'] ?><p>
                <p>Hour : <?php
        switch ($reservation['heure']) {
            case 8:
                echo "08-10 am";
                break;
            case 10:
                echo "10-12 am";
                break;
            case 12:
                echo "02-04 pm";
                break;
            case 14:
                echo "04-06 pm";
                break;
            case 16:
                echo "06-08 pm";
                break;
            default:
                echo "Heure non valide";
                break;
        }
        ?><p>
                <p>Room : <?= $reservation['nom'] ?><p>
              </div>
            <?php }?>
            </ul>
          <?php } else {
              echo '<p>Aucune réservation trouvée pour ce groupe.</p>'; 
            }
            ?>
        </div>
       <?php } ?> 
       <?php if(isset($_GET['cours_id'])){?> 
        <div id="infosSelectionPaiement">
            <?php $paiements = Paiement::afficherPaiementsEtudiantCours($etudiantId, $_GET['cours_id']);
            if (!empty($paiements)) { ?>
               <?php
               foreach ($paiements as $paiement) { ?>
               <div class="column">
                 <div class="column_infos">
                    <p>Course : <?= $paiement->getCoursId(); ?><p>    
                    <p>Amount : <?= $paiement->getMontant(); ?><p>
                    <p>Payment date : <?= $paiement->getDatePaiement(); ?><p> 
                 </div>
                 <div class="column_actions">
                   <form action="../php/Methodefile/supprimerPaiement.php" method="post" onsubmit="return confirmDelete2()">
                      <input type="hidden" name="id_etudiant" value="<?= $etudiantId; ?>">
                      <input type="hidden" name="id_cours" value="<?= $_GET['cours_id'] ?>">
                      <input type="hidden" name="montant" value="<?= $paiement->getMontant(); ?>">
                      <input type="hidden" name="datePaiement" value="<?= $paiement->getDatePaiement(); ?>">
                      <button class="button">Delete</button>
                   </form>
                   <button class="button modify-button">Edit</button>
                 </div> 
               </div>
               <div id="moreinfo_paiement" style="display: none;">
                 <h2>Edit payment</h2>
                 <form action="../php/Methodefile/modifierPaiement.php" method="post">
                      <input type="hidden" name="id_etudiant" value="<?= $etudiantId; ?>">
                      <input type="hidden" name="id_cours" value="<?= $_GET['cours_id'] ?>">
                      <div class="form-group">
                        <label for="montant">New amount:</label>
                        <input type="number" class="form-control" id="montant" name="montant" required>
                      </div>
                      <div class="form-group">
                        <label for="datePaiement">New payment date :</label>
                        <input type="date" class="form-control" id="datePaiement" name="datePaiement" required>
                      </div>
                      <button type="submit" class="btn btn-primary">Save</button>
                 </form>
               </div>
                <?php } ?> 
            <?php } else { ?>
              <p>No payment found for this course</p>
              <div class="form-container">
              <h2> Add a payment</h2>
              <form action="../php/Methodefile/ajouterPaiement.php" method="POST">
              <input type="hidden" id="id_etudiant" name="id_etudiant" value="<?= $etudiantId ?>">
              <input type="hidden" id="id_cours" name="id_cours" value="<?= $_GET['cours_id'] ?>">
              <div class="form-group">
               <label for="montant">Amount :</label>
               <input type="number" class="form-control" id="montant" name="montant" required>
              </div>
              <div class="form-group">
               <label for="datePaiement">Payment date :</label>
               <input type="date" class="form-control" id="datePaiement" name="datePaiement" required>
              </div>
              <button type="submit" class="btn btn-primary">Add payment</button>
              </form>
            </div>
            <?php } ?>

        </div>
       <?php } ?>
    </div>
</div>
</aside>  
    <script src="/Js/Etudiant.js"></script>
    <script src="/Js/Listes_etudiant.js"></script>
    
</body>
</html>