<?php
//insertbuku.php
include 'connection.php';

// id_buku, kode_buku, judul_buku, pengarang, penerbit, tahun, tanggal_input, harga, file_cover, kode_kategori

$conn=getConnection();

try{
    if($_POST){
        $kode_buku=$_POST["kode_buku"];
        $judul_buku=$_POST["judul_buku"];
        $pengarang=$_POST["pengarang"];
        $penerbit=$_POST["penerbit"];
        $tahun=$_POST["tahun"];
        $tanggal_input=$_POST["tanggal_input"];
        $harga=$_POST["harga"];
        $kode_kategori=$_POST["kode_kategori"];
    
        if(isset($_FILES["file_cover"]["name"])){
            $image_name = $_FILES["file_cover"]["name"];
            $extensions = ["jpg", "png", "jpeg"];
            $extension = pathinfo($image_name, PATHINFO_EXTENSION);
            
            if (in_array($extension, $extensions)){
                $upload_path = 'upload/' . $image_name;

                if(move_uploaded_file($_FILES["file_cover"]["tmp_name"], $upload_path)){

                    $file_cover = "http://localhost/buku/" . $upload_path; 

                    $statement = $conn->prepare("INSERT INTO `buku`(`kode_buku`, `judul_buku`, `pengarang`, `penerbit`, `tahun`, `tanggal_input`, `harga`, `file_cover`, `kode_kategori`) VALUES (:kode_buku, :judul_buku, :pengarang, :penerbit, :tahun, :tanggal_input, :harga, :file_cover, :kode_kategori);");

                    $statement->bindParam(':kode_buku',$kode_buku);
                    $statement->bindParam(':judul_buku',$judul_buku);
                    $statement->bindParam(':pengarang',$pengarang);
                    $statement->bindParam(':penerbit',$penerbit);
                    $statement->bindParam(':tahun',$tahun);
                    $statement->bindParam(':tanggal_input',$tanggal_input);
                    $statement->bindParam(':harga',$harga);
                    $statement->bindParam(':file_cover',$file_cover);
                    $statement->bindParam(':kode_kategori',$kode_kategori);

                    $statement->execute();

                    $response["message"]="Data Berhasil Direcord!";

                } else {
                    echo "Gagal Memindahkan File";
                }
                } else {
                    $response["message"]="Hanya Diperbolehkan Menginput file_cover Gambar!";
                }
            }
        }
        } catch (PDOException $e){
            $response ["message"]="error $e";
        }
        echo json_encode ($response, JSON_PRETTY_PRINT);
    