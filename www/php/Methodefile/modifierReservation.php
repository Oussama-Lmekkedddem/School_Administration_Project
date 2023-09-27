<?php
include('../Database.php');
include('../Reservation.php')
?>

<?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $Id = $_POST["reservation_id"];
              $salleId = $_POST["salle_id"];
              $groupeId = $_POST["groupe_id"];
              $jour = $_POST["jour"];
              $heure = $_POST["heure"];
              if (Reservation::modifierReservation($Id, $salleId, $groupeId, $jour, $heure)) {
                 header("Location: ../../index/Reservations.php");
              }else {
                 header("Location: ../../index/Reservations.php?error=La+salle+est+déjà+réservée+pour+ce+créneau");
              }
            }
?>