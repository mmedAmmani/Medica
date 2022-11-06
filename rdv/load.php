<?php

//load.php

$connect = new PDO('mysql:host=localhost;dbname=medica', 'root', '');

$data = array();

$query = "SELECT * FROM rdv ORDER BY id";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'title'   => $row["nom_patient"],
  'start'   => $row["date_debut"],
  'end'   => $row["date_fin"]
 );
}

echo json_encode($data);

?>