<?php
//updatebykodebuku.php

include 'connection.php';

$conn = getConnection();

try {
    if($_POST) {
        $kode_buku = $_POST["kode_buku"];
        $judul_buku = $_POST["judul_buku"];
        $pengarang = $_POST["pengarang"];
        $penerbit = $_POST["penerbit"];
        $tahun = $_POST["tahun"];
        $tanggal_input = $_POST["tanggal_input"];
        $harga = $_POST["harga"];
        $kode_kategori = $_POST["kode_kategori"];

        $statement = $conn->prepare("SELECT * FROM buku WHERE kode_buku = :kode_buku");
        $statement->bindParam(':kode_buku', $kode_buku);
        $statement->execute();
        $result = $statement->fetch();

        if($result){

            if(isset($_FILES['file_cover']['name'])){
                $image_name = $_FILES['file_cover']['name'];
                $extension_file = ["jpg", "png", "jpeg"];
                $extension = pathinfo($image_name, PATHINFO_EXTENSION);

                if (in_array($extension, $extension_file)){
                    $upload_path = 'upload/' . $image_name;

                    if(move_uploaded_file($_FILES['file_cover']['tmp_name'], $upload_path)){
                    
                        $file_cover = "http://localhost/buku/".$upload_path;
                      

                        $statement = $conn->prepare("UPDATE buku SET judul_buku = :judul_buku, pengarang = :pengarang, penerbit = :penerbit, tahun = :tahun, tanggal_input = :tanggal_input, harga = :harga, file_cover = :file_cover, kode_kategori = :kode_kategori WHERE kode_buku = :kode_buku");

                        $statement->bindParam(':kode_buku',$kode_buku);
                        $statement->bindParam(':judul_buku',$judul_buku);
                        $statement->bindParam(':pengarang',$pengarang);
                        $statement->bindParam(':penerbit',$penerbit);
                        $statement->bindParam(':tahun',$tahun);
                        $statement->bindParam(':tanggal_input',$tanggal_input);
                        $statement->bindParam(':harga',$harga);
                        $statement->bindParam(':file_cover',$file_cover);
                        $statement->bindParam(':kode_kategori',$kode_kategori);
    

                    } else {
                        $message = "Terjadi kesalahan saat mengupload gambar";
                    }
                } else {
                    $message = "Hanya diperbolehkan mengupload file gambar!";
                    $response["message"] = $message;
                    $json = json_encode($response, JSON_PRETTY_PRINT);

                    echo $json;
                    die();
                }
            } else {
                $statement = $conn->prepare("UPDATE buku SET judul_buku = :judul_buku, pengarang = :pengarang, penerbit = :penerbit, tahun = :tahun, tanggal_input = :tanggal_input, harga = :harga, file_cover = :file_cover, kode_kategori = :kode_kategori WHERE kode_buku = :kode_buku");

                $statement->bindParam(':kode_buku',$kode_buku);
                $statement->bindParam(':judul_buku',$judul_buku);
                $statement->bindParam(':pengarang',$pengarang);
                $statement->bindParam(':penerbit',$penerbit);
                $statement->bindParam(':tahun',$tahun);
                $statement->bindParam(':tanggal_input',$tanggal_input);
                $statement->bindParam(':harga',$harga);
                $statement->bindParam(':file_cover',$file_cover);
                $statement->bindParam(':kode_kategori',$kode_kategori);
            }
            $statement->execute();
            $response["message"] = "Data berhasil di ubah!";
        } else {
            $response["message"] = "Data tidak ditemukan!";
        }
    }
} catch(PDOException $e) {
    $response["message"] = "Error . $e";
}
$json = json_encode($response, JSON_PRETTY_PRINT);

//print json
echo $json;