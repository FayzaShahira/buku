<?php
include 'connection.php';

$conn=getConnection();


try{
    if(isset($_GET["kode_kategori"])) {
    $kode_kategori=$_GET["kode_kategori"];
    }
    $statement=$conn->prepare("SELECT*FROM kategori WHERE kode_kategori = :kode_kategori;");
    $statement->bindParam(':kode_kategori', $kode_kategori);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $result=$statement->fetch();

    if($result){
        echo json_encode($result, JSON_PRETTY_PRINT);
    } else {
        http_response_code(404);
        $response["message"]="Informasi kategori Tidak Ditemukan";
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
} catch (PDOException $e) {
    echo $e;
}
