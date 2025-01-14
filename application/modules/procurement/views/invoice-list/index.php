<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Faktur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="row">
        <div class="col-md-12">
            <div class="input-group">
                
                </div>
                <div class="card">
            <div class="container-fluid mt-5 w">
                                <form class="d-flex">
                                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </form>
                            </div>
            
            <div class="card-body pt-3">
            	<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="table-group">
                    <thead>
                        <tr>
                        <th width="5%">No</th>
                            <th>Order Id</th>
                            <th>Nama Vendor</th>
                            <th>Tanggal Faktur</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Data barang kantor (dummy)
                        $barang = [
                            ['id' => 1,'order_id'=>"001", 'nama' => 'sinarmas', 'tglFaktur' => "2023-11-01",'harga' => '1200000',"due_date"=>"2023-11-01","status"=>"paid"],
                            ['id' => 2,'order_id'=>"002", 'nama' => 'sinarmas', 'tglFaktur' => "2023-11-01",'harga' => '1200000',"due_date"=>"2023-11-01","status"=>"paid"],
                            ['id' => 3,'order_id'=>"003", 'nama' => 'sinarmas', 'tglFaktur' => "2023-11-01",'harga' => '1200000',"due_date"=>"2023-11-01","status"=>"paid"],
                            ['id' => 1,'order_id'=>"004", 'nama' => 'sinarmas', 'tglFaktur' => "2023-11-01",'harga' => '1200000',"due_date"=>"2023-11-01","status"=>"paid"],
                            ['id' => 2,'order_id'=>"005", 'nama' => 'sinarmas', 'tglFaktur' => "2023-11-01",'harga' => '1200000',"due_date"=>"2023-11-01","status"=>"paid"],
                            ['id' => 3,'order_id'=>"006", 'nama' => 'sinarmas', 'tglFaktur' => "2023-11-01",'harga' => '1200000',"due_date"=>"2023-11-01","status"=>"paid"],
                        ];

                        $no = 1;
                        foreach ($barang as $b) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $b['order_id'] . "</td>";
                            echo "<td>" . $b['nama'] . "</td>";
                            echo "<td>" . $b['tglFaktur'] . "</td>";
                            echo "<td>" . $b['due_date'] . "</td>";
                            echo "<td>" . $b['harga'] . "</td>";
                            echo "<td>" . $b['status'] . "</td>";
                            echo "<td><a href='invoice-list/detail' class='btn btn-primary'>Detail</a><a href='' class='btn btn-danger'>Hapus</a></td>";
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