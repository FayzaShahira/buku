<?php
//deletebykodebuku.php

include 'connection.php';
$conn=getConnection();

try{
    if(isset($_GET["kode_buku"])) {
        $kode_buku=$_GET["kode_buku"];
    
        $statement=$conn->prepare("SELECT * FROM buku WHERE kode_buku=:kode_buku;");
        $statement->bindParam(':kode_buku', $kode_buku);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = $statement->fetch();

        if ($result) {
            $statement = $conn->prepare("DELETE FROM buku WHERE kode_buku = :kode_buku");
            $statement->bindParam("kode_buku", $kode_buku);
            $statement->execute();

            $response['message'] = "Berhasil Menghapus Data Buku";
        } else {
            http_response_code(404);
            $response['message'] = "Informasi Buku Tidak Ditemukan";
        }

    } else {
        $response['message'] = "Gagal Menghapus Data Buku";
    }
} catch (PDOException $e) {
    echo $e;
}

$json = json_encode($response, JSON_PRETTY_PRINT);
echo $json;
