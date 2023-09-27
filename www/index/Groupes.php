<?php
include('../php/Personne.php');
include('../php/Cour.php');
include('../php/Database.php');
?>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Groupe::ajouterGroupe(
      $_POST['nom'],
      $_POST['coursId'],
      $_POST['professeurId']
  );

  header('Location: Groupes.php');
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
    <link rel="stylesheet" href="/style/Groupes.css">
    <title>Group</title>
</head>

<?php include 'Header.php'; ?>


    <aside class="aside2">

    <div class="div1"><p>Groupes</p>
        </div>
        <div>
        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
          <thead>
           <tr>
            <th class="th-sm">ID</th>
            <th class="th-sm">Name</th>
            <th class="th-sm">Course</th>
            <th class="th-sm">Teacher</th>
            <th class="th-sm">Action</th>
           </tr>
          </thead>
          <tbody>
           <?php $groupes = Groupe::obtenirTousGroupes(); ?>
           <?php foreach ($groupes as $groupe) : ?>
            <tr>
                <td><?php echo $groupe['id']; ?></td>
                <td><?php echo $groupe['nom']; ?></td>
                <td><?php echo $groupe['cours']; ?></td>
                <td><?php echo $groupe['professeur']; ?></td>
                <td class="drop-target">
                    <a href="Groupe.php?id=<?php echo $groupe['id']; ?>">View details</a>
                </td>
            </tr>
          <?php endforeach; ?>
         </tbody>
        </table>
    </div>

    <div class="div3">
        <h1 class="title">Add Group</h1>


     <form class="groupe-form" method="post">     
        <div class="form-group">
        <label for="nom">Name :</label>
        <input type="text" id="nom" name="nom" required>
    </div>

    <div class="form-group">
        <label for="coursId">Course :</label>
        <select id="coursId" name="coursId">
            <option value="">Select a course</option>
            <?php $cours = Cours::obtenirToutesLesCours()?>
            <?php foreach ($cours as $coursItem) : ?>
                <option value="<?php echo $coursItem->getId(); ?>"><?php echo $coursItem->getNom(); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="professeurId">Teacher :</label>
        <select id="professeurId" name="professeurId">
            <option value="">Select a teacher</option>
            <?php $professeurs = Professeur::afficherProfesseurs() ?>
            <?php foreach ($professeurs as $professeur) : ?>
                <option value="<?php echo $professeur->getId(); ?>"><?php echo $professeur->getNom() . ' ' . $professeur->getPrenom() . ' ' . $professeur->getmetier(); ?></option>
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