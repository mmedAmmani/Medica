<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] != 'medecin'){
        header("location: ../login.php");
    }
    $connect = new PDO('mysql:host=localhost;dbname=medica', 'root', '');
    $CIN =  $_GET['CIN'];
    $query = "select * FROM consultation where CIN = :CIN";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':CIN', $CIN);
    if($stmt->execute()){
        $resultat = $stmt->fetchAll();  
        if($resultat == null ){ header("location: acceuil.php?err=err");} 
        foreach($resultat as $row)
        {
            $data[] = array(
                'nom_prenom' => $row['nom_prenom'],
                'CIN'   => $row["CIN"],
                'date_consultation'   => $row["date_consultation"],
                'motif_consultation'   => $row["motif_consultation"],
                'examen_clinique' => $row["examen_clinique"],
                'examen_paraclinique' => $row["examen_paraclinique"],
                'diagnostic' => $row["diagnostic"],
                'conclusion' => $row["conclusion"],
                'evolution' => $row["evolution"]
            );
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
    <link rel="stylesheet" href="../css/template2.css">
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
                    <a href="./documents/form_dossier.php"><i class="fas fa-user-plus"></i>Dossier medical</a>
                </li>
                <li>
                    <a href="./documents/form_consultation.php"><i class="fal fa-comment-alt-medical"></i>
                        Consultation</a>
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
        <div class="test"></div>
        <div class="container">
            <?php foreach ($data as $d): ?>
            <div class="register">
                <div class="row">
                    <div class="col-md-9 mx-auto register-right">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <h3 class="register-heading">Consultations </h3>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" value="<?php echo $d["CIN"]; ?>" name="CIN" />
                                    <div class="row register-form">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lname">Nom et Prénom</label><br>
                                                <input type="text" class="form-control" placeholder="Nom et Prénom *"
                                                    name="nom_prenom" required
                                                    value="<?php echo $d['nom_prenom']; ?>" />

                                            </div>
                                            <div class="form-group">
                                                <label for="lname">CIN</label><br>
                                                <input type="text" class="form-control" placeholder="CIN *" name="CIN"
                                                    required value="<?php echo $d['CIN']; ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="lname">Date de consultation</label><br>
                                                <input type="text" class="form-control"
                                                    placeholder="Date de consultation" name="date_consultation"
                                                    value="<?php echo $d['date_consultation']; ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="lname">Motif de consultation</label><br>
                                                <textarea type="text" class="form-control" style="resize: none;"
                                                    rows="4" cols="20" placeholder="Motif de consultation"
                                                    name="motif_consultation"><?php echo $d['motif_consultation']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="lname">Examen clinique</label><br>
                                                <textarea type="text" class="form-control" style="resize: none;"
                                                    rows="4" cols="20"
                                                    name="examen_clinique"><?php echo $d['examen_clinique']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lname">Examen paraclinique</label><br>
                                                <textarea type="text" class="form-control" style="resize: none;"
                                                    rows="4" cols="20" placeholder="Examen paraclinique"
                                                    name="examen_paraclinique"><?php echo $d['examen_paraclinique']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="lname">Diagnostic </label><br>
                                                <textarea type="text" class="form-control" style="resize: none;"
                                                    rows="4" cols="20" placeholder="Diagnostic"
                                                    name="diagnostic"><?php echo $d['diagnostic']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="lname">Conclusion</label><br>
                                                <textarea type="text" class="form-control" style="resize: none;"
                                                    rows="4" cols="20" placeholder="Conclusion"
                                                    name="conclusion"><?php echo $d['conclusion']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="lname">Evolution</label><br>
                                                <input type="text" class="form-control" placeholder="Evolution"
                                                    name="evolution" value="<?php echo $d['evolution']; ?>" />
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>
</body>

</html>