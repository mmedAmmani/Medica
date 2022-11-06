<?php

//insert.php

$connect = new PDO('mysql:host=localhost;dbname=medica', 'root', '');

if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO rdv 
 (nom_patient, date_debut, date_fin) 
 VALUES (:nom_patient, :date_debut, :date_fin)
 "; 
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':nom_patient'  => $_POST['title'],
   ':date_debut' => $_POST['start'],
   ':date_fin' => $_POST['end']
  )
 );
}


?>