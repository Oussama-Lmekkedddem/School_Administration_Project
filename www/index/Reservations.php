
<?php

include('../php/Database.php');
include('../php/EmploiDuTemps.php');

?>

<?php
$salleId = 1;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["salleId"])) {
        $salleId = $_POST["salleId"];
    }
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
    <link rel="stylesheet" href="/style/Reservations.css">
    <title>Reservation</title>
</head>

<?php include 'Header.php'; ?>


    <aside class="aside2">


    <div class="tableemploi">
        <div class="buttons-container">
          <form method="post">
            <button class="salle-button <?php if ($salleId == 1 || empty($_POST["salleId"])) echo 'active'; ?>" name="salleId" value="1">Small room 1</button>
            <button class="salle-button <?php if ($salleId == 2) echo 'active'; ?>" name="salleId" value="2">Small room 2</button>
            <button class="salle-button <?php if ($salleId == 3) echo 'active'; ?>" name="salleId" value="3">Large room</button>
            <button class="salle-button <?php if ($salleId == 4) echo 'active'; ?>" name="salleId" value="4">TP Room</button>
          </form>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <div class="schedule-table">
                <table class="table bg-white">
    <thead>
        <tr>
            <th>Timetable</th>
            <th>08-10 am</th>
            <th>10-12 am</th>
            <th>02-04 pm</th>
            <th>04-06 pm</th>
            <th class="last">06-08 pm</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $jours = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $reservations = EmploiDuTemps::afficherEmploiDuTempsSalle($salleId);
        $reservationsParJourHeure = [];

        foreach ($reservations as $reservation) {
            $jour = $reservation['jour'];
            $heure = $reservation['heure'];
            $reservationsParJourHeure[$jour][$heure] = $reservation;
        }

        foreach ($jours as $jour) { ?>
            <tr>
              <td class="day"><?= $jour ?></td>
              <?php for ($heure = 8; $heure <= 16; $heure += 2) { ?>
              <td class="active">
              <?php
                if (isset($reservationsParJourHeure[$jour][$heure])) {
                  $reservation = $reservationsParJourHeure[$jour][$heure];
               ?>
                      <a class="a-table" href="Reservations.php?id=<?= $reservation['id'] ?>&groupe_id=<?= $reservation['groupeId'] ?>">
                                <h4><?= $reservation['nomGroupe']; ?></h4>
                                <p><?= $reservation['nomProfesseur']; ?></p>
                                <div class="hover">
                                    <h4><?= $reservation['nomMatiereFormation']; ?></h4>
                                </div>
                      </a>
               <?php } ?>
              </td>
              <?php } ?>
            </tr>
        <?php } ?>
      </tbody>
    </table>

             
                </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="reservation">
    <?php
     if (isset($_GET['id'])) {
      $id_reservation = $_GET['id'];
    ?>
        <div class="reservation_time">
         <div class="affiche_reservation">
          <div class="div11">
            <?php
            $reservation = Reservation::afficherReservation($id_reservation);
            if($reservation){
               $nomGroupe = $reservation['nomGroupe'];
               $nomProfesseur = $reservation['nomProfesseur'];
               $nomMatiereFormation =$reservation['nomMatiereFormation'];
               $jour = $reservation['jour'];
               $heure = $reservation['heure'];

            ?>
            <h2>Group: <?php echo $nomGroupe; ?></h2>
            <p>Teachers: <?php echo $nomProfesseur; ?></p>
            <p>Room: <?php echo $nomMatiereFormation; ?></p>
            <p>Day: <?php echo $jour; ?></p>
            <p>Hour: <?php
        switch ($heure) {
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
        ?></p>
       <?php
        } else {
         echo "Réservation non trouvée.";
        }
      ?>
          </div>
          <div class="div12">
           <form action="../php/Methodefile/supprimerReservation.php" method="post" onsubmit="return confirmDelete()">
            <input type="hidden" name="reservation_id" value="<?= $id_reservation ?>">
            <button class="button">Delete</button>
            </form>
            <button class="button modify-button" id="modify-button">Edit</button>
           </div>
          </div>
          <div class="more_action" id="more-action">
            <h2>Edit Reservation</h2>
            <?php  $groupeId = $_GET['groupe_id']; ?>
            <form action="../php/Methodefile/modifierReservation.php" method="post">
               <input type="hidden" name="reservation_id" value="<?= $id_reservation ?>">
               <input type="hidden" name="groupe_id" value="<?= $groupeId ?>">
             <div class="form-row">
              <label for="salle_id">Romm :</label>
              <select id="salle_id" name="salle_id" require>
                <option value="1">Small romm 1</option>
                <option value="2">Small romm 2</option>
                <option value="3">Large room</option>
                <option value="4">Tp room</option>
              </select>
             </div>
             <div class="form-row">
              <label for="jour">Days :</label>
              <select id="jour" name="jour" require>
              <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
              </select>
             </div>
             <div class="form-row">
              <label for="heure">Hours :</label>
              <select id="heure" name="heure" require>
                <option value="8">8-10 am</option>
                <option value="10">10-12 am</option>
                <option value="12">02-04 pm</option>
                <option value="14">04-06 pm</option>
                <option value="16">06-08 pm</option>
              </select>
             </div>
             <div class="form-row">
              <input type="submit" value="Réserver">
             </div> 
            </form>
          </div>
        <?php } ?>
        </div>
        <div class="add_reservation">
          <div class="ajouter_reservation">
            <h2>Add Reservation</h2>
            <form action="../php/Methodefile/ajouterReservation.php" method="post">
             <div class="form-row">
              <label for="groupe_id">Groups :</label>
              <select id="groupe_id" name="groupe_id" require>
                 <option value="">Select a group</option>
                 <?php $groupes = Groupe::obtenirTousGroupes(); ?>
                 <?php foreach ($groupes as $groupe) : ?>
                    <option value="<?php echo $groupe['id']; ?>"><?php echo $groupe['nom']; ?></option>
                 <?php endforeach; ?>
              </select>
             </div>
             <div class="form-row">
              <label for="salle_id">Room :</label>
              <select id="salle_id" name="salle_id" require>
                <option value="1">Small room 1</option>
                <option value="2">Small room 2</option>
                <option value="3">Room TP</option>
                <option value="4">Big romm</option>
              </select>
             </div>
             <div class="form-row">
              <label for="jour">Days :</label>
              <select id="jour" name="jour" require>
              <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
              </select>
             </div>
             <div class="form-row">
              <label for="heure">Hours :</label>
              <select id="heure" name="heure" require>
                <option value="8">8-10 am</option>
                <option value="10">10-12 am</option>
                <option value="12">02-04 pm</option>
                <option value="14">04-06 pm</option>
                <option value="16">06-08 pm</option>
              </select>
             </div>
             <div class="form-row">
              <input type="submit" value="Réserver">
             </div> 
            </form>
          </div>
          <div class="reservation_taked">
          <?php
             if (isset($_GET['error'])) {
               $errorMessage = urldecode($_GET['error']);
               echo '<p><i class="fas fa-exclamation-circle"></i> ' . $errorMessage . '</p>';
             }
          ?>
          </div>
        </div>
    </div>

</aside>  
    <script src="/Js/Reservations.js"></script>
</body>
</html>
