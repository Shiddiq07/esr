<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penerimaan Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Detail Penerimaan Barang</h1>
        <form action="proses_pesanan.php" method="post">
           <div class="row">
            <div class="col">
            <div class="mb-3">
                <label for="order_id" class="form-label">Order ID</label>
                <input type="text" class="form-control" id="order_id" name="order_id" value="O001" required>
            </div>
            <div class="mb-3">
                <label for="receipt_date" class="form-label">Tanggal Terima</label>
                <input type="date" class="form-control" id="receipt_date" name="receipt_date" required>
            </div>
            <div class="mb-3">
                <label for="received_by" class="form-label">Vendor</label>
                <input type="text" class="form-control" id="received_by" name="received_by" required>
            </div>
            <div class="mb-3">
                <label for="received_by" class="form-label">Nama Penerima</label>
                <input type="text" class="form-control" id="received_by" name="received_by" required>
            </div>
            <div class="mb-3">
                <label for="item_name" class="form-label">Item Name</label>
                <input type="text" class="form-control" id="item_name" name="item_name" value="Pensil" required>
            </div>
            </div>
            <div class="col">
            <div class="mb-3">
                <label for="delivery_date" class="form-label">Tanggal Pengiriman</label>
                <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
            </div>
            <div class="mb-3">
                <label for="unit_price" class="form-label">Harga Satuan</label>
                <input type="number" class="form-control" id="unit_price" name="unit_price" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="mb-3">
                <label for="total_amount" class="form-label">Total Harga</label>
                <input type="number" class="form-control" id="total_amount" name="total_amount" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="pending">Pending</option>
                    <option value="delivered">Delivered</option>
                    <option value="canceled">Canceled</option>
                </select>
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