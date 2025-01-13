<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembelian</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Laporan Pengeluaran</h1>

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
                    <th>Order ID</th>
                    <th>Item Name</th>
                    <th>Tanggal Pesan</th>
                    <th>Tanggal Pengiriman</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="data-table">
                </tbody>
        </table>
    </div>

    <script>
       const data = [
    { tanggal: "2023-11-01", orderId: "ORD001", itemName: "Pensil", tanggalPesan: "2023-10-25", tanggalPengiriman: "2023-11-05", hargaSatuan: 10000, jumlah: 2, totalHarga: 20000, status: "paid" },
    { tanggal: "2023-11-15", orderId: "ORD002", itemName: "Buku Tulis", tanggalPesan: "2023-11-10", tanggalPengiriman: "2023-11-18", hargaSatuan: 5000, jumlah: 5, totalHarga: 25000, status: "shipped" },
    { tanggal: "2023-12-05", orderId: "ORD003", itemName: "Bolpoin", tanggalPesan: "2023-11-28", tanggalPengiriman: "2023-12-10", hargaSatuan: 3000, jumlah: 10, totalHarga: 30000, status: "paid" },
    { tanggal: "2024-01-10", orderId: "ORD004", itemName: "Penghapus", tanggalPesan: "2024-01-02", tanggalPengiriman: "2024-01-15", hargaSatuan: 1500, jumlah: 5, totalHarga: 7500, status: "returned" },
    { tanggal: "2023-12-20", orderId: "ORD005", itemName: "Kertas HVS", tanggalPesan: "2023-12-15", tanggalPengiriman: "2023-12-25", hargaSatuan: 20000, jumlah: 5, totalHarga: 100000, status: "pending" },
    { tanggal: "2024-01-25", orderId: "ORD006", itemName: "Spidol Warna", tanggalPesan: "2024-01-20", tanggalPengiriman: "2024-01-30", hargaSatuan: 5000, jumlah: 12, totalHarga: 60000, status: "paid" },
    { tanggal: "2023-12-12", orderId: "ORD007", itemName: "Buku Gambar", tanggalPesan: "2023-11-30", tanggalPengiriman: "2023-12-15", hargaSatuan: 15000, jumlah: 3, totalHarga: 45000, status: "shipped" },
    { tanggal: "2024-02-05", orderId: "ORD008", itemName: "Pensil Warna", tanggalPesan: "2024-01-28", tanggalPengiriman: "2024-02-10", hargaSatuan: 8000, jumlah: 8, totalHarga: 64000, status: "paid" }
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
                        <td>${item.orderId}</td>
                        <td>${item.itemName}</td>
                        <td>${item.tanggalPesan}</td>
                        <td>${item.tanggalPengiriman}</td>
                        <td>${item.hargaSatuan}</td>
                        <td>${item.jumlah}</td>
                        <td>${item.totalHarga}</td>
                        <td>${item.status}</td>
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