<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Faktur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Formulir Faktur</h1>
        <form action="proses_pesanan.php" method="post">
            <div class="mb-3">
                <label for="order_id" class="form-label">Order ID</label>
                <input type="text" class="form-control" id="order_id" name="order_id" required>
            </div>
         
            <div class="mb-3">
                <label for="invoice_date" class="form-label">Tanggal Faktur</label>
                <input type="date" class="form-control" id="invoice_date" name="invoice_date" required>
            </div>
            <div class="mb-3">
                <label for="due_date" class="form-label">Tanggal Jatuh Tempo</label>
                <input type="date" class="form-control" id="due_date" name="due_date" required>
            </div>
            <div class="mb-3">
                <label for="total_amount" class="form-label">Total Harga</label>
                <input type="number" class="form-control" id="total_amount" name="total_amount" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="pending">Pending</option>
                    <option value="oaid">Paid</option>
                    <option value="overdue">Overdue</option>
                </select>
            </div>
            <div class="d-flex justify-content-end">  <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>