<?php

// Initialize the session
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] != 'secretaire'){
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
$nom = $prenom = $date_naissane = $CIN = $numtelephone = $assurance = $sexe = $email = $adresse = "";
/*$nom_err = $prenom_err = $date_de_naissane_err = $cin_err = $numero_de_telephone_err = $assurance_err = $sexe_err = $email_err = $adresse_err = "";*/

$sql = "INSERT INTO fichepatient (nom,prenom,date_naissance,CIN,numtelephone,assurance,sexe,email,adresse) VALUES (?,?,?,?,?,?,?,?,?)";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $stmt = mysqli_prepare($link, $sql);
    if(!$stmt) {
        die('mysqli error: '.mysqli_error($link));
    }

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssssssss", $nom,$prenom,$date_naissance,$CIN,$numtelephone,$assurance,$sexe,$email,$adress);    

        // Set parameters
        $nom = trim($_POST["nom"]);
        $prenom = trim($_POST["prenom"]);
        $date_naissance = trim($_POST["date_naissance"]);
        $CIN = trim($_POST["CIN"]);
        $numtelephone = trim($_POST["numtelephone"]);
        $assurance = trim($_POST["assurance"]);
        $sexe = trim($_POST["gender"]);
        $email = trim($_POST["email"]);
        $adress = trim($_POST["adresse"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location:listepatients.php");


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
    <link rel="stylesheet" href="../css/ajouterPatients.css">
    <title>ajouter patient</title>
</head>

<body>
    <?php include '../includes/sidebar.php'; ?>
    <div class="container">
        <div class="register">
            <div class="row">
                <div class="col-md-9 mx-auto register-right">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <h3 class="register-heading">Nouveau Patient</h3>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="row register-form">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Nom *" name="nom"
                                                required />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="CIN *" name="CIN"
                                                required />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Numéro de téléphone *"
                                                name="numtelephone" required />
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Email *" name="email"
                                                required />
                                        </div>
                                        <div class="form-group">
                                            <div class="sexe">
                                                <label class="radio inline">
                                                    <input type="radio" name="gender" value="male" checked>
                                                    <span> Homme </span>
                                                </label>
                                                <label class="radio inline">
                                                    <input type="radio" name="gender" value="female">
                                                    <span> Femme </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Prénom *" name="prenom"
                                                required />
                                        </div>
                                        <div class="md-form md-outline input-with-post-icon datepicker form-group">
                                            <input placeholder="Select date" type="date" id="example"
                                                name='date_naissance' class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Assurance *"
                                                name="assurance" required />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Adresse *"
                                                name="adresse" required />
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