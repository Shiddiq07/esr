<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Tambah Barang</h1>
        <form action="proses_pesanan.php" method="post">
           <div class="row">
            <div class="col">
            <!-- <div class="mb-3">
                <label for="item_id" class="form-label">item ID</label>
                <input type="text" class="form-control" id="item_id" name="item_id" value="O001" required>
            </div> -->
            <div class="mb-3">
                <label for="item_name" class="form-label">item Name</label>
                <input type="text" class="form-control" id="item_name" name="item_name" required>
            </div>
            <div class="mb-3">
                <label for="categori_id" class="form-label">Id Kategori</label>
                <input type="text" class="form-control" id="categori_id" name="categori_id" required>
            </div>
            <div class="mb-3">
                <label for="sku" class="form-label">sku</label>
                <input type="text" class="form-control" id="sku" name="sku" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>
           
            </div>
            <div class="col">
            <div class="mb-3">
                <label for="unit_price" class="form-label">Harga Satuan</label>
                <input type="number" class="form-control" id="unit_price" name="unit_price" value="100000" required>
            </div>
            <div class="mb-3">
                <label for="unit_of_measure" class="form-label">Satuan Pengukuran</label>
                <input type="text" class="form-control" id="unit_of_measure" name="unit_of_measure" required>
            </div>
            <div class="mb-3">
                <label for="reorder_level" class="form-label">min. stok sebelum dipesan ulang</label>
                <input type="number" class="form-control" id="reorder_level" name="reorder_level" value="10" required>
            </div>
            <div class="mb-3">
                <label for="vendor_id" class="form-label">Id Vendor</label>
                <input type="text" class="form-control" id="vendor_id" name="vendor_id" required>
            </div>
            </div>
            </div>
            <div class="d-flex justify-content-end">  <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>