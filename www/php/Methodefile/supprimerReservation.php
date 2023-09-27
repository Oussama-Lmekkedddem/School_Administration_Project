<?php
include('../Database.php');
include('../Reservation.php')
?>

<?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $Id = $_POST["reservation_id"];
              Reservation::supprimerReservation($Id);
                 header("Location: ../../index/Reservations.php");
            }
?>