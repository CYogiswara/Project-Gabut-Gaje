<?php
    // Koneksi Database
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "dblatihan";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

    //jika tombol simpan di klik
    if(isset($_POST['bsimpan']))
    {
        //pengujian apakah data akan diedit atau disimpan baru
        if($_GET['hal'] == "edit")
        {
            //data akan diedit
            //data akan disimpan baru
            $edit = mysqli_query($koneksi, " UPDATE tmhs set
                                                nim = '$_POST[tnim]',
                                                nama = '$_POST[tnama]',
                                                alamat = '$_POST[talamat]',
                                                prodi = '$_POST[tprodi]'
                                             WHERE id_mhs = '$_GET[id]'
                                           ");
            if($edit) //jika edit sukses
            {
            echo "<script>
            alert('Edit data sukses!');
            document.location= 'index.php';
            </script>";
            }
            else
            {
            echo "<script>
            alert('Edit data gagal!');
            document.location='index.php';
            </script>";
            }
        }else
        {
            //data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nim, nama, alamat, prodi)
            VALUES ('$_POST[tnim]',
                   '$_POST[tnama]',
                   '$_POST[talamat]',
                   '$_POST[tprodi]')
            ");
            if($simpan) //jika simpan sukses
            {
            echo "<script>
            alert('Simpan data sukses!');
            document.location= 'index.php';
            </script>";
            }
            else
            {
            echo "<script>
            alert('Simpan data gagal!');
            document.location='index.php';
            </script>";
            }
                    }

       
    }

    //pengujian jika tombol edit atau hapus diklik
    if(isset($GET['hal']))
    {
        //pengujian jika edit data
        if($GET['hal'] == "edit")
        {
            //Tampilkan data yang akan diedit
            $tampil == mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
            $data == mysqli_fetch_array($tampil);
            if($data)
            {
                //jika data ditemukan, maka data ditampung dulu kedalam variabel
                $vnim = $data['nim'];
                $vnama = $data['nama'];
                $valamat = $data['alamat'];
                $vprodi = $data['prodi'];
            }
        }
        else if ($_GET['hal'] == "hapus")
        {
            
            
                $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' ");
                if($hapus){
                    echo "<script>
                            alert('Hapus data sukses!');
                            document.location='index.php';
                        </script>";
                }
            
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD 2022 PHP & MYSQL + Bootstrap 5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>
<div class="container">

    
    <h1 class="text-center">CRUD PHP & MySQL + Bootstrap 5</h1>
    <h2 class="text-center">Christopher Yogiswara</h2>
    <!-- Card -->
    <div class="card mt-3">
  <div class="card-header bg-primary text-white">
    Form Input Data Mahasiswa
  </div>
  <div class="card-body">
    <form method="post" action="">
        <div class="form-group">
            <label>NIM</label>
            <input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="Input Nim Anda Disini!" required>
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama Anda Disini!" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea class="form-control" name="talamat" placeholder="Input Alamat Anda Disini!"><?=@$valamat?>"</textarea>
        </div>
        <div class="form-group">
            <label>Program Studi</label>
            <select class="form-control" name="tprodi" placeholder="Input Prodi Anda Disini!">
                <option value="<?=@$vprodi?>"><?=@$vprodi?></option>
                <option value="D3-MI">D3-MI</option>
                <option value="S1-SI">S1-SI</option>
                <option value="S1-TI">S1-TI</option>
                
            </select>
        </div>
        
        <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
        <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

    </form>
  </div>
</div>
    <!-- Card End -->

    <!-- Card-Tabel -->
    <div class="card mt-3">
  <div class="card-header bg-success text-white">
    Daftar Mahasiswa
  </div>
  <div class="card-body">
    
    <table class="table table-bordered table-striped">
        <tr>
            <th>No.</th>
            <th>Nim</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Program Studi</th>
            <th>Aksi</th>
        </tr>
        <?php
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
            while($data = mysqli_fetch_array($tampil)) :

        ?>
        <tr>
            <td><?=$no++;?></td>
            <td><?=$data['nim']?></td>
            <td><?=$data['nama']?></td>
            <td><?=$data['alamat']?></td>
            <td><?=$data['prodi']?></td>
            <td>
                <a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-warning">Edit</a>
                <a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" onclick="return confirm('apakah yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
            </td>
        </tr>
        <?php endwhile; //penutup perulangan while ?>
    </table>  

  </div>
</div>
    <!-- Card Tabel End -->
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>