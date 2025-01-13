<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang Kantor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="row">
        <div class="col-md-12">
            <div class="input-group">
                
                </div>
                <div class="card">
                <div class="container-fluid d-flex mt-5 ">
                <div class="">
                    
                                <form >
                                <div class="d-flex">
                                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-outline-success" type="submit">Search</button>
</div>
                                </form>
                                </div>
                                <div class="ms-auto "><a href='master-kategori-barang/tambahData' class='btn btn-primary'>+ Tambah data</a></div>
                            </div>
            
            <div class="card-body pt-3">
            	<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="table-group">
                    <thead>
                        <tr>
                        <th width="5%">No</th>
                            <th>Category Id</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th width="15%">Aksi</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Data barang kantor (dummy)
                        $barang = [
                            ['id' => 1,'category_id'=>"001", 'nama' => 'Perlengkapan', 'description' => "Digunakan untuk melengkapi pekerjaan sehari-hari atau mendukung penggunaan peralatan."],
                            ['id' => 2,'category_id'=>"002", 'nama' => 'peralatan', 'description' => "Digunakan untuk melakukan tugas yang lebih kompleks atau produksi."],
                        ];

                        $no = 1;
                        foreach ($barang as $b) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $b['category_id'] . "</td>";
                            echo "<td>" . $b['nama'] . "</td>";
                            echo "<td>" . $b['description'] . "</td>";
                            echo "<td><a href='master-kategori-barang/editData' class='btn btn-primary'>edit</a><a href='' class='btn btn-danger'>hapus</a></td>";
                            // echo "<td><a href='detail.php?id=" . $b['id'] . "' class='btn btn-primary'>Detail</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>