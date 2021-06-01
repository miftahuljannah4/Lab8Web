<?php
    error_reporting(E_ALL);
    include_once 'koneksi.php';

    if (isset($_POST['submit']))
    {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $kategori = $_POST['kategori'];
        $harga_jual = $_POST['harga_jual'];
        $harga_beli = $_POST['harga_beli'];
        $stok = $_POST['stok'];
        $file_gambar = $_FILES['file_gambar'];
        $gambar = null;

        if ($file_gambar['error'] == 0)
        {
            $filename = str_replace(' ', '_', $file_gambar['name']);
            $destination = dirname(__FILE__) . '/gambar/' . $file_name;
            if (move_uploaded_file($file_gambar['tmp_name'], $destination))
            {
                $gambar = 'gambar/' . $file_name;;
            }
        }
        $sql = 'UPDATE data_barang SET ';
        $sql .= "nama = '{$nama}', kategori = '{$kategori}', ";
        $sql .= "harga_jual = '{$harga_jual}', harga_beli = '{$harga_beli}', stok = '{$stok}' ";
        
        if (!empty($gambar))
        $sql .= ", gambar = '{$gambar}' ";
        $sql .= "WHERE id_barang = '{$id}'";
        $result = mysqli_query($conn, $sql);
    
        header('location: index.php');
    }

    $id = $_GET['id'];
    $sql = "SELECT * FROM data_barang WHERE id_barang = '{$id}'";
    $result = mysqli_query($conn, $sql);
    if (!$result) die('Error: Data tidak tersedia');
    $data = mysqli_fetch_array($result);

    function is_select($var, $val) {
        if ($var == $val) return 'selected="selected"';
        return false;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="tambahstyle.css" rel="stylesheet" type="text/css" />
    <title>Ubah Barang</title>
</head>
<body>
    <div class="container">
        <h1><center>Ubah Barang</h1></center>
    <div class="main">
        <form method="post" action="ubah.php" enctype="multipart/form-data">
            <table border="0" align="center">
                <tr>
                    <div class="input">
                        <td>Nama Barang</td>
                        <td>:</td>
                        <td><input type="text" name="nama" value="<?php echo $data['nama'];?>" /></td>
                    </div>
                </tr>
                <div class="input">
                    <td>Kategori</td>
                    <td>:</td>
                    <td>
                        <select name="kategori">
                            <option <?php echo is_select ('Komputer', $data['kategori']); ?> value="Komputer">Komputer</option>
                            <option <?php echo is_select ('Elektronik', $data['kategori']); ?> value="Elektronik">Elektronik</option>
                            <option <?php echo is_select ('Hand Phone', $data['kategori']); ?> value="Hand Phone">Hand Phone</option>
                        </select>
                    </td>
                </div>
                </tr>
                <div class="input">
                    <td>Harga Jual</td>
                    <td>:</td>
                    <td><input type="text" name="harga_jual" value="<?php echo $data['harga_jual'];?>" /></td>
                </div>
                </tr>
                <div class="input">
                    <td>Harga Beli</td>
                    <td>:</td>
                    <td><input type="text" name="harga_beli" value="<?php echo $data['harga_beli'];?>" /></td>
                </div>
                </tr>
                <div class="input">
                    <td>Stok</td>
                    <td>:</td>
                    <td><input type="text" name="stok" value="<?php echo $data['stok'];?>" /></td>
                </div>
                </tr>
                <div class="input">
                    <td>File Gambar</td>
                    <td>:</td>
                    <td><input type="file" name="file_gambar" /></td>
                </div>
                </tr>
                <div class="submit">
                    <td><input type="hidden" name="id" value="<?php echo $data['id_barang'];?>" /><td>
                    <td><input type="submit" name="submit" value="Simpan" /><td>
                </div>
                </tr>
        </form>
    </div>
    </div>
</body>
</html>