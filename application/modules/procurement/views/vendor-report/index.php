<!DOCTYPE html>
<html>
<head>
    <title>Laporan Vendor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Laporan Vendor</h1>
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
                    <th>Vendor ID</th>
                    <th>Vendor Name</th>
                    <th>Item</th>
                    <th>Harga Satuan</th>
                    <th>Total Pesanan Berhasil</th>
                    <th>Total Pengiriman Dibatalkan/Ditolak</th>
                </tr>
            </thead>
            <tbody id="data-table">
                </tbody>
        </table>
    </div>

    <script>
       const data = [
    { tanggal: "2023-11-01", vendorId: "VDR001", namaVendor:"sinarmas", itemName: "Buku", harga: "100000", approve: "5", denied: 0 },
    { tanggal: "2023-11-15", vendorId: "VDR002", namaVendor:"buana", itemName: "Pulpen", harga: "20000", approve: "3", denied: 2 },
    { tanggal: "2023-12-01", vendorId: "VDR001", namaVendor:"sinarmas", itemName: "Pensil", harga: "15000", approve: "2", denied: 3 },
    { tanggal: "2023-12-10", vendorId: "VDR003", namaVendor:"jaya", itemName: "Penghapus", harga: "5000", approve: "5", denied: 0 },
    { tanggal: "2024-01-05", vendorId: "VDR002", namaVendor:"buana", itemName: "Kertas", harga: "30000", approve: "4", denied: 1 },
    { tanggal: "2024-01-20", vendorId: "VDR001", namaVendor:"sinarmas", itemName: "Spidol", harga: "25000", approve: "5", denied: 0 },
    { tanggal: "2023-11-25", vendorId: "VDR004", namaVendor:"abadi", itemName: "Buku Tulis", harga: "18000", approve: "3", denied: 2 },
    { tanggal: "2023-12-15", vendorId: "VDR003", namaVendor:"jaya", itemName: "Binder", harga: "10000", approve: "4", denied: 1 },
    { tanggal: "2024-01-10", vendorId: "VDR002", namaVendor:"buana", itemName: "Bolpoin", harga: "3000", approve: "5", denied: 0 },
    { tanggal: "2024-01-25", vendorId: "VDR001", namaVendor:"sinarmas", itemName: "Pita Koreksi", harga: "8000", approve: "2", denied: 3 }
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
                        <td>${item.vendorId}</td>
                        <td>${item.namaVendor}</td>
                        <td>${item.itemName}</td>
                        <td>${item.harga}</td>
                        <td>${item.approve}</td>
                        <td>${item.denied}</td>
                       
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