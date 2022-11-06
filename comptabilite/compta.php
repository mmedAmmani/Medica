<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] != 'secretaire'){
            header("location: ../login.php");
    }
    $prixConsultation = 300;
    $totale = null;
    if(isset($_POST["calculate"])){
        $salaires = (double)$_POST["salaires"];
        $divers = (double)$_POST["divers"];
        $eauElec = (double)$_POST["EauElec"];
        $month = $_POST["month"]!="" ? (int)explode('-',$_POST["month"])[1] : (int)date('m');
        $connect = new PDO('mysql:host=localhost;dbname=medica', 'root', '');
        $query = "SELECT COUNT(*) FROM rdv WHERE EXTRACT(month FROM date_debut) = :mnt ";
        $statement = $connect->prepare($query);
        $statement->bindParam(':mnt', $month);
        $statement->execute();
        
        $nombreConsultations = Array(); 
        $nombreConsultations = $statement->fetch();
        $totaleCons =  $nombreConsultations[0] * $prixConsultation;
        $totale = $totaleCons - $salaires - $divers - $eauElec;
    }    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/template.css" />
    <link rel="stylesheet" href="../css/calendar.css" />
    <link rel="stylesheet" href="../css/compta.css" />
    <title>medica | secretaire</title>
</head>

<body>
    <div class="main">
        <aside class="sidebar">
            <h1>
                Med<span><img src="../img/logo.svg" alt=" " /></span>ica
            </h1>
            <ul class="linksMet">
                <li>
                    <a href="../secretaire/acceuil.php"><i class="fas fa-home"></i> home</a>
                </li>
                <li>
                    <a href="../secretaire/ajouterPatients.php"><i class="fas fa-user-plus"></i> ajouter patient</a>
                </li>
                <li>
                    <a href="../secretaire/listepatients.php"><i class="fas fa-list"></i> liste des patients</a>
                </li>
                <li>
                    <a href="./compta.php"><i class="fas fa-calculator"></i> comptabilite</a>
                </li>
            </ul>
            <div class="user-info">
                <div class="user">
                    <img src="../img/receptionist.png" alt="user" />
                    <p>secretaire</p>
                </div>
                <ul class="links">
                    <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i>logout</a></li>
                    <li><a href="#"><i class="fas fa-key"></i>Reset</a></li>
                </ul>
            </div>
        </aside>
        <div class="container">
            <form class="compta" action="compta.php" method="post">
                <h1><i class="fas fa-calculator"></i> Compta</h1>
                <?php if($totale == null) { ?>
                <div class="inputs">
                    <div class="form-grp">
                        <input type="number" placeholder="salaires" name="salaires" required>
                        <input type="number" placeholder='divers' name="divers" required>
                    </div>
                    <div class="form-grp wide-grp">
                        <input type="number" class='wide' placeholder="Dépenses d'eau et d'électricité" name="EauElec"
                            required>
                    </div>
                    <div>
                        <input class='file' type="month" name="month">
                        <button class="btn btn-primary" name="calculate">Calculate</button>
                    </div>
                </div>
            </form>
            <?php } else if($totale>0) { ?>
            <h1 class="bg-success rounded afficher"><?php echo $totale; ?> DH</h1>
            <button class="btn btn-primary reset">Reset</button>
            <?php } else { ?>
            <div class="">
                <h1 class="bg-danger rounded afficher"><?php echo $totale; ?> DH</h1>
            </div>
            <button class="btn btn-primary reset">Reset</button>
            <?php } ?>
        </div>
        <script>
        document.querySelectorAll('.reset').forEach(element => {
            element.addEventListener('click', () => {
                location.reload();
            })
        })
        </script>
</body>

</html>