<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Edit Supplier/Vendor</h1>
        <form action="proses_pesanan.php" method="post">
           <div class="row">
            <div class="col">
            <!-- <div class="mb-3">
                <label for="item_id" class="form-label">item ID</label>
                <input type="text" class="form-control" id="item_id" name="item_id" value="O001" required>
            </div> -->
            <div class="mb-3">
                <label for="vendor_name" class="form-label">Nama Vendor</label>
                <input type="text" class="form-control" id="vendor_name" name="vendor_name" required>
            </div>
            <div class="mb-3">
                <label for="contact_name" class="form-label">Nama Kontak</label>
                <input type="text" class="form-control" id="contact_name" name="contact_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="tlp" class="form-label">No Telp</label>
                <input type="text" class="form-control" id="tlp" name="tlp" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
           
            </div>
            <div class="d-flex justify-content-end">  <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>