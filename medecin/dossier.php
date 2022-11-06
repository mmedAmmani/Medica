<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] != 'medecin'){
        header("location: ../login.php");
    }
    $connect = new PDO('mysql:host=localhost;dbname=medica', 'root', '');
    $CIN =  $_GET['CIN'];
    $query = "select * FROM dossier_medical where CIN = :CIN";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':CIN', $CIN);
    if($stmt->execute()){
        $resultat = $stmt->fetch();  
        if($resultat == null ){ header("location: acceuil.php");} 
        
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
    <link rel="stylesheet" href="../css/dossier.css">
    <title>dossier médical</title>
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
                    <a href="form_dossier.php"><i class="fas fa-user-plus"></i>Dossier medical</a>
                </li>
                <li>
                    <a href="./form_consultation.php"><i class="fal fa-comment-alt-medical"></i> Consultation</a>
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
            <div class="register">
                <div class="row">
                    <div class="col-md-9 mx-auto register-right">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <h3 class="register-heading">Dossier Médical</h3>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" value="<?php echo $CIN; ?>" name="CIN" readonly="readonly" />
                                    <div class="row register-form">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lname">Nom et Prénom</label><br>
                                                <input type="text" class="form-control" placeholder="Nom et Prénom *"
                                                    name="nom_prenom" required
                                                    value="<?php echo $resultat['nom_prenom']; ?>" />

                                            </div>
                                            <div class="form-group">
                                                <label for="lname">CIN</label><br>
                                                <input type="text" class="form-control" placeholder="CIN *" name="CIN"
                                                    required value="<?php echo $resultat['CIN']; ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="lname">Histoire de la Maladie</label><br>
                                                <textarea class="form-control" style="resize: none;" rows="4" cols="20"
                                                    name="histoire_maladie"><?php echo $resultat['histoire_maladie']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lname">Antécédents Personnels</label><br>
                                                <textarea class="form-control" style="resize: none;" rows="4" cols="20"
                                                    name="antecedents_personnels"><?php echo $resultat['antecedents_personnels']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="lname">Antécédents Familiaux</label><br>
                                                <textarea class="form-control" style="resize: none;" rows="5" cols="20"
                                                    name="antecedents_familiaux"><?php echo $resultat['antecedents_familiaux']; ?></textarea>
                                            </div>
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