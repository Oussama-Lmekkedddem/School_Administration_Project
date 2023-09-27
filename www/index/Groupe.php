<?php
include('../php/Personne.php');
include('../php/Cour.php');
include('../php/Database.php');


$groupeId = $_GET['id'];
?>



<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    Groupe::modifierGroupe(
        $_POST['groupe_id'],
        $_POST['nouveau_nom'],
        $_POST['nouveau_cours_id'],
        $_POST['nouveau_professeur_id'],
    );
    $groupeId = $_POST['groupe_id'];

    header("Location: Groupe.php?id=$groupeId");
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
    <link rel="stylesheet" href="/style/Groupe.css">
    <title>Group</title>
</head>

<?php include 'Header.php'; ?>


    <aside class="aside2">

    <?php $groupe = Groupe::obtenirGroupe($groupeId);

    if ($groupe) {
            ?>

    <section class="section1">
        <div class="div1">
            <div class="div11">
               <h2><?php echo $groupe->getNom() ?></h2>
               <p>Course : <?php echo $groupe->getCoursId() ?></p>
               <p>Teacher: <?php echo $groupe->getProfesseurId() ?></p>
            </div>
            <div class="div12">
                <form action="../php/Methodefile/supprimerGroupe.php" method="post" onsubmit="return confirmDelete()">
                   <input type="hidden" name="groupe_id" value="<?= $groupe->getId(); ?>">
                   <button class="button">Delete</button>
                </form>
                <button class="button modify-button">Edit</button>
            </div>
        </div>
        <div class="div2">
            <h2>Edit Group</h2>
            <form method="post" class="edit-form">
            <input type="hidden" name="groupe_id" value="<?= $groupe->getId(); ?>">
              <div class="form-group">
                <label for="nom">New name:</label>
                <input type="text" id="nom" name="nouveau_nom" value="<?php echo $groupe->getNom() ?>" required>
              </div>
              <div class="form-group">
               <label for="coursId">New course :</label>
               <select id="coursId" name="nouveau_cours_id">
                  <option value="">Select a course</option>
                  <?php $cours = Cours::obtenirToutesLesCours()?>
                  <?php foreach ($cours as $coursItem) : ?>
                  <option value="<?php echo $coursItem->getId(); ?>"><?php echo $coursItem->getNom(); ?></option>
                  <?php endforeach; ?>
               </select>
              </div>

              <div class="form-group">
               <label for="professeurId">New teacher :</label>
               <select id="professeurId" name="nouveau_professeur_id">
                <option value="">Select a teacher</option>
                <?php $professeurs = Professeur::afficherProfesseurs() ?>
                <?php foreach ($professeurs as $professeur) : ?>
                <option value="<?php echo $professeur->getId(); ?>"><?php echo $professeur->getNom() . ' ' . $professeur->getPrenom() . ' ' . $professeur->getmetier(); ?></option>
                <?php endforeach; ?>
               </select>
              </div>

              <button type="submit" class="btn btn-edit">Save</button>
            </form>
        </div>
    </section>

    <section class="section2">
        <div class="div3">
        <h2>Group Studients</h2>
        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                 <thead>
                  <tr>
                    <th class="th-sm">ID
                    </th>
                    <th class="th-sm">Name
                    </th>
                    <th class="th-sm">Level
                    </th>
                    <th class="th-sm">Delete
                    </th>
                  </tr>
                 </thead>
                 <tbody>
                 <?php $etudiants = Groupe::obtenirEtudiantsParGroupe($groupeId); ?>
                   <?php foreach ($etudiants as $etudiant) : ?>
                   <tr>
                     <td><?= $etudiant['id']; ?></td>
                     <td><?= $etudiant['nom'] . ' ' . $etudiant['prenom']; ?></td>
                     <td><?= $etudiant['niveau']; ?></td>
                     <td>
                      <form action="../php/Methodefile/DeleteEtudiantFromGroupe.php" method="post" onsubmit="return confirmDelete2()">
                      <input type="hidden" name="groupe_id" value="<?= $groupeId; ?>">
                       <input type="hidden" name="etudiant_id" value="<?= $etudiant['id']; ?>">
                       <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                      </form>
                     </td>
                   </tr>
                   <?php endforeach; ?> 
                 </tbody>
            </table>
        </div>
        <div class="div4">
        <h2>Add Studients</h2>
        <table id="dtBasicExample2" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                 <thead>
                  <tr>
                    <th class="th-sm">ID
                    </th>
                    <th class="th-sm">Name
                    </th>
                    <th class="th-sm">Level
                    </th>
                    <th class="th-sm">Add
                    </th>
                  </tr>
                 </thead>
                 <tbody>
                 <?php $etudiants = Etudiant::obtenirTousLesEtudiants(); ?>
                 <div id="groupeIdContainer" data-groupeid="<?= $groupeId ?>"></div>
                   <?php foreach ($etudiants as $etudiant) : ?>
                   <tr>
                     <td><?= $etudiant->getId(); ?></td>
                     <td><?= $etudiant->getNom() . ' ' . $etudiant->getPrenom(); ?></td>
                     <td><?= $etudiant->getNiveauId(); ?></td>
                     <?php  
                       if (Groupe::etudiantExisteDansGroupe($groupeId, $etudiant->getId())) { ?>
                        <td></td>
                     <?php 
                       } else { ?> 
                        <td><input type='checkbox' class='personne-checkbox' value= "<?= $etudiant->getId(); ?>" ></td>
                     <?php } ?>
                   </tr>
                   <?php endforeach; ?> 
                 </tbody>
            </table>
            <button class="button add-button" onclick="insererPersonnes()">Add Students</button>
        </div>
    </section>

    <?php  
    }else {
         echo '<p>Groupe non trouvé.</p>';
    }
     ?>
    </aside>  


    <script src="/Js/Groupe.js"></script>
    <script src="/Js/Listes_etudiant.js"></script>
</body>
</html>