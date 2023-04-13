<?php
header('Access-Control-Allow-Origin: *');

$connect = new PDO("mysql:host=localhost;dbname=id19923439_teste", "id19923439_gabriel", "DSMBancoGabriel1245/");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();
if ($received_data->action == 'fetchall') {
    $query = "
 SELECT * FROM fatec_prof 
 ORDER BY id DESC
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data);
}
if ($received_data->action == 'insert') {
    $data = array(
        ':name' => $received_data->name,
        ':endereco' => $received_data->endereco,
        ':curso' => $received_data->curso,
        ':salario' => $received_data->salario
    );

    $query = "
 INSERT INTO fatec_prof
 (name, endereco, curso, salario) 
 VALUES (:name, :endereco, :curso, :salario)
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Professor Adicionado'
    );

    echo json_encode($output);
}
if ($received_data->action == 'fetchSingle') {
    $query = "
 SELECT * FROM fatec_prof 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['name'] = $row['name'];
        $data['endereco'] = $row['endereco'];
        $data['curso'] = $row['curso'];
        $data['salario'] = $row['salario'];
    }

    echo json_encode($data);
}
if ($received_data->action == 'update') {
    $data = array(
        ':name' => $received_data->name,
        ':endereco' => $received_data->endereco,
        ':curso' => $received_data->curso,
        ':salario' => $received_data->salario,
        ':id' => $received_data->hiddenId
    );

    $query = "
 UPDATE fatec_prof 
 SET name = :name, 
 endereco = :endereco,
 curso = :curso,
 salario = :salario
 WHERE id = :id
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Professor Atualizado'
    );

    echo json_encode($output);
}

if ($received_data->action == 'delete') {
    $query = "
 DELETE FROM fatec_prof 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $output = array(
        'message' => 'Professor Deletado'
    );

    echo json_encode($output);
}

?>