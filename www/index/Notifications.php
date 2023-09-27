<?php

include('../php/Database.php');
include('../php/Paiement.php');

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
    <link rel="stylesheet" href="/style/Notifications.css">
    <title>Notifications</title>
</head>



<?php include 'Header.php'; ?>


    <aside class="aside2">
        <div class="container">
        <div class="notification_title">
            <h2>Notifications</h2>
        </div>
          <?php Paiement::notifierNonPaiement();?>
    </aside>  
</body>
</html>