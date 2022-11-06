<?php

// Initialize the session
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] != 'medecin'){
    header("location: ../login.php");
}

/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'medica');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if (!$link) {
    die('Connect Error: ' . mysqli_connect_error());
}else{
 
// Define variables and initialize with empty values
$nom_prenom = $CIN = $date_consultation = $motif_consultation = $examen_clinique = $examen_paraclinique = $diagnostic = $conclusion = $evolution = "";

$sql = "INSERT INTO consultation (nom_prenom,CIN,date_consultation,motif_consultation,examen_clinique,examen_paraclinique,diagnostic,conclusion,evolution) VALUES (?,?,?,?,?,?,?,?,?)";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $stmt = mysqli_prepare($link, $sql);
    if(!$stmt) {
        die('mysqli error: '.mysqli_error($link));
    }

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssssssss", $nom_prenom,$CIN,$date_consultation,$motif_consultation,$examen_clinique,$examen_paraclinique,$diagnostic,$conclusion,$evolution);    

        // Set parameters
        $nom_prenom = trim($_POST["nom_prenom"]);
        $CIN = trim($_POST["CIN"]);
        $date_consultation = trim($_POST["date_consultation"]);
        $motif_consultation = trim($_POST["motif_consultation"]);
        $examen_clinique = trim($_POST["examen_clinique"]);
        $examen_paraclinique = trim($_POST["examen_paraclinique"]);
        $diagnostic = trim($_POST["diagnostic"]);
        $conclusion = trim($_POST["conclusion"]);
        $evolution = trim($_POST["evolution"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location:acceuil.php");

}
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
    <link rel="stylesheet" href="../css/form_consultation.css">
    <title>ajouter consultation</title>
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
                    <a href="calendrier.php"><i class="fas fa-list"></i> Calendrier</a>
                </li>

            </ul>
            <div class="user-info">
                <div class="user">
                    <img src="../img/doctor.png" alt="user" />
                    <p>Medecin</p>
                </div>
                <ul class="links">
                    <li><a href="../../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
                    <li><a href="#"><i class="fas fa-key"></i>Reset</a></li>
                </ul>
            </div>
        </aside>
        <div class="container">
            <div class="register">
                <div class="row">
                    <div class="col-md-9 mx-auto register-right">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <h3 class="register-heading">Nouvelle Consultation</h3>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="row register-form">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Nom et Prénom *"
                                                    name="nom_prenom" required />
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="CIN *" name="CIN"
                                                    required />
                                            </div>
                                            <div class="md-form md-outline input-with-post-icon datepicker form-group">
                                                <input placeholder="Select date" type="date" id="example"
                                                    name='date_consultation' class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" style="resize: none;"
                                                    placeholder="Motif de consultation *" name="motif_consultation"
                                                    rows="4" cols="20" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" style="resize: none;"
                                                    placeholder="Examen Clinique" name="examen_clinique" rows="4"
                                                    cols="20"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <textarea class="form-control" style="resize: none;"
                                                    placeholder="Examen Paraclinique" name="examen_paraclinique"
                                                    rows="4" cols="20"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" style="resize: none;"
                                                    placeholder="Diagnostic *" name="diagnostic" rows="4" cols="20"
                                                    required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" style="resize: none;"
                                                    placeholder="Conclusion *" name='conclusion' rows="4" cols="20"
                                                    required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Evolution *"
                                                    name="evolution" required />
                                            </div>
                                            <input type="submit" class="btnRegister" value="Ajouter" />
                                        </div>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
</body>

</html>