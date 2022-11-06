<?php

// Initialize the session
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] != 'medecin'){
    header("location: ../../login.php");
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
$nom_prenom = $CIN = $antecedents_personnels = $antecedents_familiaux = $histoire_maladie = "";

$sql = "INSERT INTO dossier_medical (nom_prenom,CIN,antecedents_personnels,antecedents_familiaux,histoire_maladie) VALUES (?,?,?,?,?)";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $stmt = mysqli_prepare($link, $sql);
    if(!$stmt) {
        die('mysqli error: '.mysqli_error($link));
    }

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssss", $nom_prenom,$CIN,$antecedents_personnels,$antecedents_familiaux,$histoire_maladie);    

        // Set parameters
        $nom_prenom = trim($_POST["nom_prenom"]);
        $CIN = trim($_POST["CIN"]);
        $antecedents_personnels = trim($_POST["antecedents_personnels"]);
        $antecedents_familiaux = trim($_POST["antecedents_familiaux"]);
        $histoire_maladie = trim($_POST["histoire_maladie"]);
        if(mysqli_stmt_execute($stmt)){
            header("location:acceuil.php");
        } else {
            die("Error:". mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);


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
    <link rel="stylesheet" href="../css/form_dossier.css">
    <title>ajouter dossier médical</title>
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
                    <img src="../../img/doctor.png" alt="user" />
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
                                <h3 class="register-heading">Nouveau Dossier Médical</h3>
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
                                            <div class="form-group">
                                                <textarea class="form-control" style="resize: none;"
                                                    placeholder="Histoire de la maladie" name="histoire_maladie"
                                                    rows="4" cols="20"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <textarea class="form-control" style="resize: none;"
                                                    placeholder="Antécédents Personnels" name="antecedents_personnels"
                                                    rows="4" cols="20"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" style="resize: none;"
                                                    placeholder="Antécédents Familiaux" name="antecedents_familiaux"
                                                    rows="4" cols="20"></textarea>
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