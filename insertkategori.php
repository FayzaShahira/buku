<?php
include 'connection.php';
$conn=getConnection();

try{
    if($_POST){
        $kode_kategori=$_POST["kode_kategori"];
        $jenis_kategori=$_POST["jenis_kategori"];

        $statement=$conn->prepare("INSERT INTO `kategori`(`kode_kategori`, `jenis_kategori`) VALUES (:kode_kategori, :jenis_kategori)");

        $statement->bindParam(':kode_kategori', $kode_kategori);
        $statement->bindParam(':jenis_kategori', $jenis_kategori);

        $statement->execute();
        $response["message"]="Data Berhasil Direcord";
    }
} catch (PDOException $e){
    $response["message"]="error $e";
}
echo json_encode($response, JSON_PRETTY_PRINT);