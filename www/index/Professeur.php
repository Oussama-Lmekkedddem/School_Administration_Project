<?php
include('../php/Personne.php');
include('../php/Database.php');
include('../php/Reservation.php');

$professeurId = $_GET['id'];
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Professeur::modifierProfesseur(
        $professeurId,
        $_POST['nouveau_nom'],
        $_POST['nouveau_prenom'],
        $_POST['nouveau_tel'],
        $_POST['nouveau_mail'],
        $_POST['nouvelle_date_inscription'],
        $_POST['nouveau_metier']
    );

    header("Location: Professeur.php?id=$professeurId");
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
    <script src="/framework/jquery-3.6.0.min.js"></script>
    <script src="/framework/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="/framework/bootstrap.min.css">
    <link rel="stylesheet" href="/framework/all.min.css">
    <link rel="stylesheet" href="/style/Global.css">
    <link rel="stylesheet" href="/style/Professeur.css">
    <title>Welcome</title>
</head>

<?php include 'Header.php'; ?>


<aside class="aside2">
            <?php $professeur = Professeur::obtenirProfesseurParId($professeurId);

    if ($professeur) {
            ?>
    <div class="etudiant-card">
        <div class="etudiant-info">
            <h2><?= $professeur->getNom() . ' ' . $professeur->getPrenom() ?></h2>
            <p>ID : <?php echo $professeur->getId(); ?><p>
            <p>Phone number: <?= $professeur->getTel() ?></p>
            <p>Email: <?= $professeur->getMail() ?></p>
            <p>Registration date: <?= $professeur->getDateInscription() ?></p>
            <p>Occupation: <?= $professeur->getMetier() ?></p>
        </div>
    
        <div class="actions">
            <button class="btn btn-edit">Edit</button>

            <form action="../php/Methodefile/supprimerProfesseur.php" method="post" onsubmit="return confirmDelete()">
                <input type="hidden" name="professeur_id" value="<?= $professeur->getId(); ?>">
                <button type="submit" class="btn btn-delete">Delete</button>
            </form>



        </div>
    
    </div>
    <div class="edit-div" style="display: none;">
    <form method="post" class="edit-form">
    <div>
        <label for="nouveau_nom">New name :</label>
        <input type="text" name="nouveau_nom" value="<?= $professeur->getNom() ?>">
    </div>
    <div>
        <label for="nouveau_prenom">New first name :</label>
        <input type="text" name="nouveau_prenom" value="<?= $professeur->getPrenom() ?>">
    </div>
    <div>
        <label for="nouveau_tel">New phone number :</label>
        <input type="text" name="nouveau_tel" value="<?= $professeur->getTel() ?>">
    </div>
    <div>
        <label for="nouveau_mail">New email :</label>
        <input type="text" name="nouveau_mail" value="<?= $professeur->getMail() ?>">
    </div>
    <div>
        <label for="nouvelle_date_inscription">New Registration date :</label>
        <input type="Date" name="nouvelle_date_inscription" value="<?= $professeur->getDateInscription() ?>">
    </div>
    <div>
        <label for="nouvelle_metier">Occupation :</label>
        <input type="text" name="nouveau_metier" value="<?= $professeur->getMetier() ?>">
    </div>
    
    <button type="submit" class="btn btn-edit">Save</button>
</form>
</div>
    
    <?php
} else {
    echo '<p>Professeur non trouvé.</p>';
}
?>
<div class="globaldivition">
    <div id="division1">
        <div id="tableau">
            <?php $resultes = Groupe::obtenirProfGroupes($professeurId); ?>
            <?php foreach ($resultes as $resulte) : ?>
                <div class="button">
                  <a href="Professeur.php?id=<?= $professeurId ?>&groupe_id=<?= $resulte['id']?>"><?php echo $resulte['nom'] . ' ' . $resulte['cours'] ;?></a>
                </div>
            <?php endforeach; ?>
        </div> 
    </div>
    <div id="division2">
        <?php if(isset($_GET['groupe_id'])){?>
        <div id="infosSelection">
        <?php $groupe = Groupe::obtenirGroupe($_GET['groupe_id']); ?>
          <div>
            <p>Group ID : <?php echo $groupe->getId(); ?></p>
            <p>Group name: <?php echo $groupe->getNom(); ?></p>
            <p>course name : <?php echo $groupe->getCoursId(); ?> </p>
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
        <?php } ?>
    </div>
</div>

</aside>  

    <script src="/Js/Professeur.js"></script>
    <script src="/Js/Listes_etudiant.js"></script>
    
</body>
</html>