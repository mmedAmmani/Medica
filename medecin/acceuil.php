<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] != 'medecin'){
            header("location: ../login.php");
    }

$connect = new PDO('mysql:host=localhost;dbname=medica', 'root', '');
$err = isset($_GET["err"]) ? $_GET["err"] : null; 
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
    <style>
    .main #calendar {
        height: 90%;
        width: 100%;
        margin-top: 25px;
        background: #e0f5ff;
        box-shadow: -3px 2px 46px -16px rgba(0, 0, 0, 0.75);
        -webkit-box-shadow: -3px 2px 46px -16px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: -3px 2px 46px -16px rgba(0, 0, 0, 0.75);
        background-image: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);
        border-radius: 10px;
    }

    .ajouter {
        background-image: none;
        right: 20px;
    }

    .ajouter a {
        border-radius: 3px;
        background-image: linear-gradient(120deg, #89f7fe 0%, #66a6ff 100%);
        color: #03045E;
        border: 1px solid #03045E;
        margin-left: 3px;
        padding: 8px;
        font-weight: normal;
        border-radius: 3px;
        font-family: "Helvetica Neue", Helvetica, Arial;

    }
    </style>
</head>

<body>
    <div class="main">
        <aside class="sidebar">
            <h1>
                Med<span><img src="../img/logo.svg" alt=" " /></span>ica
            </h1>
            <ul class='linksMet'>
                <li>
                    <a href="acceuil.php"><i class="fas fa-home"></i> Home</a>
                </li>
                <li>
                    <a href="ajouterDossier.php"><i class="fas fa-user-plus"></i>Dossier medical</a>
                </li>
                <li>
                    <a href="ajouterConsultation.php"><i class="fal fa-comment-alt-medical"></i> Consultation</a>
                </li>
                <li>
                    <a href="calendrier.php"><i class="far fa-calendar"></i> Calendrier</a>
                </li>

            </ul>
            <div class="user-info">
                <div class="user">
                    <img src="../img/doctor.png" alt="user" />
                    <p>Medecin</p>
                </div>
                <ul class="links">
                    <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
                    <li><a href="#"><i class="fas fa-key"></i>Reset</a></li>
                </ul>
            </div>
        </aside>
        <div class="container">
            <div class="actions">
                <div class="search">
                    <i class="fas fa-search"></i>
                    <input type="text" id='filter' />
                </div>
                <div class="ajouter doc">
                    <a href="./documents/lettre.html">
                        lettre de confrere
                    </a>
                    <a href="./documents/ordonnance.html">
                        ordonnance
                    </a>
                    <a href="#">
                        certificat medicale
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
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $d): ?>

                        <tr class="info">
                            <td><?= $d["nom"] ?></td>
                            <td><?= $d["prenom"] ?></td>
                            <td><?= $d["CIN"] ?></td>
                            <td>
                                <a href="dossier.php?CIN=<?= $d["CIN"] ?>">
                                    <button class="btn btn-primary">
                                        Dossier medical
                                    </button>
                                </a>

                                <a href="consultation.php?CIN=<?= $d["CIN"] ?>">
                                    <button class="btn btn-danger">
                                        <i class="fal fa-comment-alt-medical">Consultations</i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <?php if($err!=null) { ?>
    <script>
    window.addEventListener('DOMContentLoaded', () => {
        alert("ce patient ne possede pas des consultations")
        window.location = window.location.pathname;
    })
    </script>
    <?php } ?>
    <script src="../js/filter.js"></script>
</body>

</html>