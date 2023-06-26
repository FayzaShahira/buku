<?php
include 'connection.php';

$conn=getConnection();


try{
    if(isset($_GET["nomor"])) {
    $nomor=$_GET["nomor"];
    }
    $statement=$conn->prepare("SELECT*FROM anggota WHERE nomor=:nomor;");
    $statement->bindParam(':nomor', $nomor);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $result=$statement->fetch();

    if($result){
        echo json_encode($result, JSON_PRETTY_PRINT);
    } else {
        http_response_code(404);
        $response["message"]="Informasi Anggota Tidak Ditemukan";
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
} catch (PDOException $e) {
    echo $e;
}
