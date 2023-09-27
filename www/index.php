<?php
include('php/Database.php');
include('php/EmploiDuTemps.php');

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
    <script src="framework/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="framework/jquery.dataTables.min.css">
    <script src="framework/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="framework/bootstrap.min.css">
    <link rel="stylesheet" href="framework/all.min.css">
    <link rel="stylesheet" href="style/Global.css">
    <link rel="stylesheet" href="style/Accueil.css">
    <title>Welcome</title>
</head>



<?php include 'index/Header.php'; ?>


    <aside class="aside2">
    <div class="tableemploi">
        <div class="buttons-container">
          <form method="post">
            <button class="salle-button <?php if ($salleId == 1 || empty($_POST["salleId"])) echo 'active'; ?>" name="salleId" value="1">Small romm 1</button>
            <button class="salle-button <?php if ($salleId == 2) echo 'active'; ?>" name="salleId" value="2">Small romm 2</button>
            <button class="salle-button <?php if ($salleId == 3) echo 'active'; ?>" name="salleId" value="3">Romm TP</button>
            <button class="salle-button <?php if ($salleId == 4) echo 'active'; ?>" name="salleId" value="4">Big romm</button>
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
                    <h4><?= $reservation['nomGroupe']; ?></h4>
                    <p><?= $reservation['nomProfesseur']; ?></p>
                    <div class="hover">
                         <h4><?= $reservation['nomMatiereFormation']; ?></h4>
                    </div>
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
    </aside>  
</body>
</html>