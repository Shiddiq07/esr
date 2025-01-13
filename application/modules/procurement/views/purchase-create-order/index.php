<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pesanan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Formulir Pesanan</h1>
        <form action="proses_pesanan.php" method="post">
            <div class="mb-3">
                <label for="request_id" class="form-label">Request ID</label>
                <input type="text" class="form-control" id="request_id" name="request_id" required>
            </div>
            <div class="mb-3">
                <label for="vendor_id" class="form-label">Vendor ID</label>
                <input type="text" class="form-control" id="vendor_id" name="vendor_id" required>
            </div>
            <div class="mb-3">
                <label for="order_date" class="form-label">Tanggal Pesan</label>
                <input type="date" class="form-control" id="order_date" name="order_date" required>
            </div>
            <div class="mb-3">
                <label for="delivery_date" class="form-label">Tanggal Pengiriman</label>
                <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
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
            <div class="d-flex justify-content-end">  <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>