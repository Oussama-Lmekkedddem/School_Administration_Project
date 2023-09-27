<?php
include('../php/Personne.php');
include('../php/Cour.php');
include('../php/Salle_Niveau.php');
include('../php/Database.php');
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Etudiant::ajouterEtudiant(
      $_POST['id'],
      $_POST['nom'],
      $_POST['prenom'],
      $_POST['tel'],
      $_POST['mail'],
      $_POST['dateInscription'],
      $_POST['niveauId']
  );

  header('Location: Listes_etudiants.php');
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
    <link rel="stylesheet" href="/style/Listes_etudiants.css">
    <title>Students</title>
</head>

<?php include 'Header.php'; ?>

    <aside class="aside2">
        <div class="div1"><p>Students</p>
        </div>
        <div>
        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="th-sm">ID
                </th>
                <th class="th-sm">Name
                </th>
                <th class="th-sm">Registration date
                </th>
                <th class="th-sm">Level
                </th>
                <th class="th-sm">Action
                </th>
              </tr>
            </thead>
            <tbody>
            <?php $etudiants = Etudiant::obtenirTousLesEtudiants(); ?>
              <?php foreach ($etudiants as $etudiant) : ?>
                <tr>
                  <td><?= $etudiant->getId(); ?></td>
                  <td><?= $etudiant->getNom() . ' ' . $etudiant->getPrenom(); ?></td>
                  <td><?= $etudiant->getDateInscription(); ?></td>
                  <td><?= $etudiant->getNiveauId(); ?></td>
                  <td class="drop-target">
                  <a href="Etudiant.php?id=<?= $etudiant->getId(); ?>">View details</a>
                  </td>
                </tr>
              <?php endforeach; ?> 
        </tbody>
      </table>
    </div>
    <div class="div3">
        <h1 class="title">Add student </h1>

        <form class="student-form" method="post">
            <div class="form-group">
                <label for="id">ID :</label>
                <input type="text" id="id" name="id" required>
            </div>

            <div class="form-group">
                <label for="nom">Name :</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="prenom">First name :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>

            <div class="form-group">
                <label for="tel">Phone number :</label>
                <input type="text" id="tel" name="tel">
            </div>

            <div class="form-group">
                <label for="mail">Email :</label>
                <input type="email" id="mail" name="mail">
            </div>

            <div class="form-group">
                <label for="dateInscription">Registration date :</label>
                <input type="date" id="dateInscription" name="dateInscription" required>
            </div>

            <div class="form-group">
                <label for="niveauId">Level :</label>
                <select id="niveauId" name="niveauId">
                    <option value="">Select a level</option>
                    <?php $niveaux = Niveau::obtenirTousLesNiveaux(); ?>
            <?php foreach ($niveaux as $niveau) : ?>
                <option value="<?php echo $niveau->getId(); ?>"><?php echo $niveau->getNom(); ?></option>
            <?php endforeach; ?>
                </select>
            </div>

            <input type="submit" value="Ajouter" class="submit-button">
        </form>
    </div>
    </aside>  

    <script src="/Js/Listes_etudiant.js"></script>
</body>
</html>