<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Laporan Stok</h1>
        <div class="d-flex">
<div class="">
                    
                    <form >
                    <div class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
</div>
                    </form>
                    </div>
        <div class="form-group ms-auto m-3" style="width:200px">
            <label for="bulan">Filter Berdasarkan Bulan:</label>
            <select class="form-select" id="bulan" onchange="filterData()">
                <option value="all">Semua</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                </select>
        </div>
        <div class="form-group m-3" style="width:200px">
            <label for="tahun">Filter Berdasarkan Tahun:</label>
            <select class="form-select" id="tahun" onchange="filterData()">
                <option value="all">Semua</option>
                <option value="01">2023</option>
                <option value="02">2024</option>
                <option value="03">2025</option>
                </select>
        </div>
        </div>
        <table class="table table-striped table-bordered table-hover dt-responsive">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    
                </tr>
            </thead>
            <tbody id="data-table">
                </tbody>
        </table>
    </div>

    <script>
       const data = [
    { tanggal: "2023-11-01", itemId: "ITM001", itemName: "Pensil",  category: "Perlengkapan", jumlah: 20 },
    { tanggal: "2023-11-05", itemId: "ITM002", itemName: "Buku Tulis", category: "Perlengkapan", jumlah: 50 },
    { tanggal: "2023-11-10", itemId: "ITM003", itemName: "Spidol",     category: "Perlengkapan", jumlah: 30 },
    { tanggal: "2023-11-15", itemId: "ITM004", itemName: "Kertas A4",   category: "Perlengkapan", jumlah: 200 },
    { tanggal: "2023-11-20", itemId: "ITM005", itemName: "Laptop",     category: "Elektronik",   jumlah: 5 },
    { tanggal: "2023-11-25", itemId: "ITM006", itemName: "Printer",    category: "Elektronik",   jumlah: 2 },
    { tanggal: "2023-12-01", itemId: "ITM007", itemName: "Kopi",       category: "Makanan",    jumlah: 100 },
    { tanggal: "2023-12-05", itemId: "ITM008", itemName: "Teh",        category: "Makanan",    jumlah: 50 },
    { tanggal: "2023-12-10", itemId: "ITM009", itemName: "Gula",       category: "Makanan",    jumlah: 25 },
    { tanggal: "2023-12-15", itemId: "ITM010", itemName: "Mie Instan",  category: "Makanan",    jumlah: 50 }
];

        function filterData() {
            const bulan = document.getElementById("bulan").value;
            const tableBody = document.getElementById("data-table");
            tableBody.innerHTML = "";

            data.forEach(item => {
                const tanggal = new Date(item.tanggal);
                const bulanData = tanggal.getMonth() + 1; // Bulan dimulai dari 0

                if (bulan === "all" || bulan === bulanData.toString().padStart(2, '0')) {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${item.tanggal}</td>
                        <td>${item.itemId}</td>
                        <td>${item.itemName}</td>
                        <td>${item.category}</td>
                        <td>${item.jumlah}</td>
                    `;
                    tableBody.appendChild(row);
                }
            });
        }

        // Panggil fungsi filterData() saat halaman pertama kali dimuat
        filterData();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></select>
</body>
</html>