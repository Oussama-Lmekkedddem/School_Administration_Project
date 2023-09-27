<?php
include('../php/Cour.php');
include('../php/Salle_Niveau.php');
include('../php/Database.php');
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
    <link rel="stylesheet" href="/style/Formation.css">

    <title>Course</title>
</head>


<?php include 'Header.php'; ?>



    <aside class="aside2">
        <div class="firstdiv">
            <div class="buttons-container">
                <button class="button" id="button1">Training</button>
                <button class="button" id="button2">Topics</button>
            </div>
            
            <div class="content" id="div1">
               <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                 <thead>
                  <tr>
                    <th class="th-sm">Id
                    </th>
                    <th class="th-sm">Name
                    </th>
                    <th class="th-sm">Price
                    </th>
                    <th class="th-sm">Delete
                    </th>
                  </tr>
                 </thead>
                 <tbody>
                 <?php $formations = Formation::obtenirToutesLesFormations(); ?>
                   <?php foreach ($formations as $formation) : ?>
                   <tr>
                     <td><?= $formation->getId(); ?></td>
                     <td><?= $formation->getNom(); ?></td>
                     <td><?= $formation->getPrix(); ?></td>
                     <td>
                        <form action="../php/Methodefile/supprimerFormation.php" method="post" onsubmit="return confirmDelete()">
                         <input type="hidden" name="formation_id" value="<?= $formation->getId(); ?>">
                         <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                      </td>
                   </tr>
                   <?php endforeach; ?> 
                 </tbody>
                </table>
            </div>
            
            <div class="content" id="div2">
            <table id="dtBasicExample2" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                 <thead>
                  <tr>
                    <th class="th-sm">ID
                    </th>
                    <th class="th-sm">Name
                    </th>
                    <th class="th-sm">Level
                    </th>
                    <th class="th-sm">Price
                    </th>
                    <th class="th-sm">Delete
                    </th>
                  </tr>
                 </thead>
                 <tbody>
                 <?php $matieres = Matiere::obtenirToutesLesMatieres(); ?>
                   <?php foreach ($matieres as $matiere) : ?>
                   <tr>
                     <td><?= $matiere->getId(); ?></td>
                     <td><?= $matiere->getNom(); ?></td>
                     <td><?= $matiere->getNiveauId(); ?></td>
                     <td><?= $matiere->getPrix(); ?></td>
                     <td>
                      <form action="../php/Methodefile/supprimerMatiere.php" method="post" onsubmit="return confirmDelete()">
                       <input type="hidden" name="matiere_id" value="<?= $matiere->getId(); ?>">
                       <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                      </form>
                     </td>
                   </tr>
                   <?php endforeach; ?> 
                 </tbody>
            </table>
            </div>
            
        </div>
        <div class="secondediv">
            <div class="chaild1">

            <div class="content" id="div3">
                <h1 class="title">Add a training</h1>

                <form class="student-form" method="post" action="../php/Methodefile/ajouterFormation.php">
                  <div class="form-group">
                    <label for="id">ID :</label>
                    <input type="text" id="id" name="id_f" required>
                  </div>
                  <div class="form-group">
                    <label for="nom">Name :</label>
                    <input type="text" id="nom" name="nom_f" required>
                  </div>
                  <div class="form-group">
                    <label for="nom">Price :</label>
                    <input type="text" id="prix" name="prix_f" required>
                  </div>
                  <input type="submit" value="Ajouter" class="submit-button">
                </form>
              </div>

              <div class="content" id="div4">
                <h1 class="title">Add a subject</h1>

                <form class="student-form" method="post" action="../php/Methodefile/ajouterMatiere.php">
                  <div class="form-group">
                    <label for="id">ID :</label>
                    <input type="text" id="id" name="id_m" required>
                  </div>
                  <div class="form-group">
                    <label for="nom">Name :</label>
                    <input type="text" id="nom" name="nom_m" required>
                  </div>
                  <div>
                    <label for="nouveau_niveau_id">Level :</label>
                    <select id="nouveau_niveau_id" name="niveau_id_m">
                      <option value="">Sélectionnez un niveau</option>
                      <?php $niveaux = Niveau::obtenirTousLesNiveaux(); ?>
                      <?php foreach ($niveaux as $niveau) : ?>
                        <option value="<?php echo $niveau->getId(); ?>"><?php echo $niveau->getNom(); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="nom">Prix :</label>
                    <input type="text" id="prix" name="prix_m" required>
                  </div>
                  <input type="submit" value="Ajouter" class="submit-button">
                </form>
              </div>
              

            </div>
            <div class="chaild2">
              
<div class="content" id="div5">
       <h1 class="title">Edit a Training</h1>
       <form method="post" class="edit-form" action="../php/Methodefile/modifierFormation.php">
          <div class="form-group">
            <label for="matiere_id">Enter the ID of the training to modify:</label>
            <input type="text" class="form-control" name="formation_id" id="formation_id" required>
          </div>
          <div class="form-group">
            <label for="nouveau_nom">New name :</label>
            <input type="text" class="form-control" name="nouveau_nom_f">
          </div>
          <div class="form-group">
            <label for="nouveau_prenom">New price :</label>
            <input type="text" class="form-control" name="nouveau_prix_f">
          </div>
          <button type="submit" class="btn btn-primary btn-edit">Save</button>
       </form>
</div>

<div class="content" id="div6">
      <h1 class="title">Edit a Topic</h1>
        <form method="post" class="edit-form" action="../php/Methodefile/modifierMatiere.php">
          <div class="form-group">
            <label for="matiere_id">Enter the ID of the topic to modify :</label>
            <input type="text" class="form-control" name="matiere_id" id="matiere_id" required>
          </div>
          <div class="form-group">
            <label for="nouveau_nom">New name :</label>
            <input type="text" class="form-control" name="nouveau_nom_m">
          </div>
          <div class="form-group">
            <label for="nouveau_niveau_id">Level :</label>
            <select id="nouveau_niveau_id" class="form-control" name="nouveau_niveau_m">
                <option value="">Select a level</option>
                <?php $niveaux = Niveau::obtenirTousLesNiveaux(); ?>
                <?php foreach ($niveaux as $niveau) : ?>
                    <option value="<?php echo $niveau->getId(); ?>"><?php echo $niveau->getNom(); ?></option>
                <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="nouveau_prix">New price :</label>
            <input type="text" class="form-control" name="nouveau_prix_m">
          </div>
          <button type="submit" class="btn btn-primary btn-edit">Save</button>
        </form>
</div>



            </div>
        </div>
    </aside>  


    <script src="/Js/Formation.js"></script>
    <script src="/Js/Listes_etudiant.js"></script>
</body>
</html>
