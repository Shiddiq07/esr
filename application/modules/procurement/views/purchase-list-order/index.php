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
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th width="5%">Aksi</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Data barang kantor (dummy)
                        $barang = [
                            ['id' => 1,'order_id'=>"001", 'nama' => 'Pensil', 'stok' => 10],
                            ['id' => 2,'order_id'=>"002", 'nama' => 'Buku', 'stok' => 5],
                            ['id' => 3,'order_id'=>"003", 'nama' => 'Pulpen', 'stok' => 15],
                        ];

                        $no = 1;
                        foreach ($barang as $b) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $b['order_id'] . "</td>";
                            echo "<td>" . $b['nama'] . "</td>";
                            echo "<td>" . $b['stok'] . "</td>";
                            echo "<td><a href='purchase-list-order/detail' class='btn btn-primary'>Detail</a></td>";
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