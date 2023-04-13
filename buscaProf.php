<?php

header('Access-Control-Allow-Origin: *');

$connect = new PDO("mysql:host=localhost;dbname=id19923439_teste", "id19923439_gabriel", "DSMBancoGabriel1245/");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

if($received_data->query != '')
{
	$query = "
	SELECT * FROM fatec_prof 
	WHERE name LIKE '%".$received_data->query."%' 
	OR curso LIKE '%".$received_data->query."%' 
	ORDER BY salario DESC
	";
}
else
{
	$query = "
	SELECT * FROM fatec_prof 
	ORDER BY salario DESC
	";
}

$statement = $connect->prepare($query);

$statement->execute();

while($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$data[] = $row;
}

echo json_encode($data);

?>