<?php
//updatebykode.php

include 'connection.php';
$conn = getConnection();
try {
    if($_POST){
        $kode_kategori  = $_POST["kode_kategori"];
        $jenis_kategori = $_POST["jenis_kategori"];

        $statement = $conn->prepare("SELECT * FROM kategori WHERE kode_kategori=:kode_kategori");
        $statement->bindParam(':kode_kategori', $kode_kategori);
        $statement->execute();
        $result = $statement->fetch();

        // if ($result){
            $statement = $conn->prepare("UPDATE `kategori` SET kode_kategori=:kode_kategori, jenis_kategori=:jenis_kategori WHERE kode_kategori = :kode_kategori");

            $statement->bindParam(':kode_kategori', $kode_kategori );
            $statement->bindParam(':jenis_kategori', $jenis_kategori);

            $statement->execute();
            $response["message"] = "Data berhasil direcord";
        
    }
}
catch (PDOException $e){
    $response["message"] = "error $e";
}
echo json_encode($response, JSON_PRETTY_PRINT);
?>