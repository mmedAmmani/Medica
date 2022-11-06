<?php

//update.php

$connect = new PDO('mysql:host=localhost;dbname=medica', 'root', '');

if(isset($_POST["id"]))
{
 $query = "
 UPDATE rdv 
 SET nom_patient=:nom_patient, date_debut=:date_debut, date_fin=:date_fin 
 WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':nom_patient'  => $_POST['title'],
   ':date_debut' => $_POST['start'],
   ':date_fin' => $_POST['end'],
   ':id'   => $_POST['id']
  )
 );
}

?>