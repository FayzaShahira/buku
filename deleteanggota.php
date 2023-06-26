<?php
//deletebynomoranggota.php

include 'connection.php';

$conn=getConnection();

try{
    if  (isset($_GET["nomor"])) {
        $nomor=$_GET["nomor"];
    
        $statement = $conn->prepare("SELECT * FROM anggota WHERE nomor=:nomor;");
        $statement->bindParam(':nomor', $nomor);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = $statement->fetch();

        if ($result) {
        $statement = $conn->prepare("DELETE FROM anggota WHERE nomor=:nomor");
        $statement->bindParam(':nomor', $nomor);
        $statement->execute();

            $response['message'] = "Berhasil Menghapus Data Anggota";
        } else {
            http_response_code(404);
            $response['message'] = "Informasi Anggota Tidak Ditemukan";
        }

    } else {
        $response['message'] = "Gagal Menghapus Data Anggota";
    }
} catch (PDOException $e) {
    echo $e;
}

$json = json_encode($response, JSON_PRETTY_PRINT);
echo $json;
