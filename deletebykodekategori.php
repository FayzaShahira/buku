<?php
//deletebykodekategori.php

include 'connection.php';

$conn=getConnection();

try{
    if  (isset($_GET["kode_kategori"])) {
        $kode_kategori=$_GET["kode_kategori"];
    
        $statement = $conn->prepare("SELECT * FROM kategori WHERE kode_kategori = :kode_kategori;");
        $statement->bindParam(':kode_kategori', $kode_kategori);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = $statement->fetch();

        if ($result) {
        $statement = $conn->prepare("DELETE FROM kategori WHERE kode_kategori = :kode_kategori");
        $statement->bindParam(':kode_kategori', $kode_kategori);
        $statement->execute();

            $response['message'] = "Berhasil Menghapus Data kategori";
        } else {
            http_response_code(404);
            $response['message'] = "Informasi kategori Tidak Ditemukan";
        }

    } else {
        $response['message'] = "Gagal Menghapus Data kategori";
    }
} catch (PDOException $e) {
    echo $e;
}

$json = json_encode($response, JSON_PRETTY_PRINT);
echo $json;
