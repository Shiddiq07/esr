<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Tambah Kategori</h1>
        <form action="" method="post">
           <div class="row">
            <div class="col">
            <!-- <div class="mb-3">
                <label for="item_id" class="form-label">item ID</label>
                <input type="text" class="form-control" id="item_id" name="item_id" value="O001" required>
            </div> -->
            <div class="mb-3">
                <label for="category_name" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="category_name" name="category_name" required>
            </div>
            <div class="mb-3">
                <label for="dedcription" class="form-label">Deskripsi</label>
                <input type="text" class="form-control" id="dedcription" name="dedcription" required>
            </div>
           
            </div>
            <div class="d-flex justify-content-end">  <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>