<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] != 'secretaire'){
    header("location: ../login.php");
}
$connect = new PDO('mysql:host=localhost;dbname=medica', 'root', '');

$data = array();

$query = "SELECT * FROM fichepatient ORDER BY id";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
foreach($result as $row)
{
 $data[] = array(
  'id' => $row['id'],
  'nom'   => $row["nom"],
  'prenom'   => $row["prenom"],
  'CIN'   => $row["CIN"],
  'numtelephone' => $row["numtelephone"]
 );
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/template.css">
    <link rel="stylesheet" href="../css/listePatients.css">
    <title>medica | liste des patients</title>
    <style>
    .supp {
        display: inline-block;
    }
    </style>
</head>

<body>
    <?php include '../includes/sidebar.php'; ?>
    <div class="container">
        <div class="actions">
            <div class="search">
                <i class="fas fa-search"></i>
                <input type="text" id='filter' />
            </div>
            <div class="ajouter">
                <a href="ajouterPatients.php">
                    <i class="fas fa-user-plus"></i>
                    Ajouter un Patient
                </a>
            </div>
        </div>
        <div class="tableau">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"><i class="far fa-user"></i> Nom</th>
                        <th scope="col"><i class="far fa-user"></i> Prénom</th>
                        <th scope="col"><i class="fas fa-id-badge"></i> CIN</th>
                        <th scope="col"><i class="fas fa-phone-square-alt"></i> Numéro de téléphone</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $d): ?>

                    <tr class="info">
                        <td><?= $d["nom"] ?></td>
                        <td><?= $d["prenom"] ?></td>
                        <td><?= $d["CIN"] ?></td>
                        <td><?= $d["numtelephone"] ?></td>
                        <td>
                            <a href="modifierPatient.php?id=<?= $d["id"] ?>">
                                <button class="btn btn-primary">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </a>
                            <form class='supp' action="supprimerPatient.php">
                                <input type="hidden" name="id" value="<?= $d["id"] ?>">
                                <button class="btn btn-danger" type="submit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
    <script src="../js/filter.js"></script>
    <script>
    const supps = document.querySelectorAll('.supp')
    supps.forEach(supp => {
        supp.addEventListener('submit', e => {
            e.preventDefault();
            if (confirm('voulez vous vraiment supprimer ce patient ?')) {
                e.target.submit()
            }
        });
    })
    </script>
</body>

</html>