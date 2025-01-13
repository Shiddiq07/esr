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
                                <div class="ms-auto "><a href='master-barang/tambahData' class='btn btn-primary'>+ Tambah data</a></div>
                            </div>
            <div class="card-body pt-3">
            	<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="table-group">
                    <thead>
                        <tr>
                        <th width="5%">No</th>
                            <th>Item Id</th>
                            <th>Nama Item</th>
                            <th>Kategori</th>
                            <th>sku</th>
                            <th>Deskripsi</th>
                            <th>Harga Satuan</th>
                            <th>Satuan Ukuran</th>
                            <th width="15%">Aksi</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Data barang kantor (dummy)
                        $barang = [
                            ['id' => 1,'item_id'=>"001", 'nama' => 'Pensil', 'category' => "peralatan",'sku'=>'001','description'=>'alat tulis','harga'=>'1000000','satuan'=>'pcs'],
                            ['id' => 2,'item_id'=>"002", 'nama' => 'Buku', 'category' => "peralatan",'sku'=>'002','description'=>'alat tulis','harga'=>'1000000','satuan'=>'pcs'],
                            ['id' => 3,'item_id'=>"003", 'nama' => 'Pulpen', 'category' => "peralatan",'sku'=>'003','description'=>'alat tulis','harga'=>'1000000','satuan'=>'pcs'],
                        ];

                        $no = 1;
                        foreach ($barang as $b) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $b['item_id'] . "</td>";
                            echo "<td>" . $b['nama'] . "</td>";
                            echo "<td>" . $b['category'] . "</td>";
                            echo "<td>" . $b['sku'] . "</td>";
                            echo "<td>" . $b['description'] . "</td>";
                            echo "<td>" . $b['harga'] . "</td>";
                            echo "<td>" . $b['satuan'] . "</td>";
                            echo "<td><a href='master-barang/editData' class='btn btn-primary'>edit</a><a href='' class='btn btn-danger'>hapus</a></td>";
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