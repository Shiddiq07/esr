<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'SiteController/actionIndex';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

# START API
	require_once __DIR__ . '/api.php';
# END API

$route['site'] = 'SiteController/actionIndex';
$route['site/login'] = 'SiteController/actionLogin';
$route['site/logout'] = 'SiteController/actionLogout';
$route['site/refresh-csrf'] = 'SiteController/actionRefreshCsrf';
$route['site/not-found'] = 'SiteController/actionNotFound';
$route['site/sso-callback'] = 'SiteController/actionSsoCallback';

$route['notifikasi'] = 'NotifikasiController/actionIndex';
$route['notifikasi/index'] = 'NotifikasiController/actionIndex';
$route['notifikasi/fetch-data'] = 'NotifikasiController/actionFetchData';
$route['notifikasi/read/(:num)']['post'] = 'NotifikasiController/actionRead/$1';
$route['notifikasi/delete/(:num)']['delete'] = 'NotifikasiController/actionDelete/$1';

# START MODULE RBAC ROUTES
	# RBAC MENU
	$route['rbac/menu'] = 'rbac/MenuController/actionIndex';
	$route['rbac/menu/index'] = 'rbac/MenuController/actionIndex';
	$route['rbac/menu/(:num)'] = 'rbac/MenuController/actionIndex/$1';
	$route['rbac/menu/hapus/(:num)'] = 'rbac/MenuController/actionHapus/$1';
	$route['rbac/menu/list-menu/(:num)'] = 'rbac/MenuController/actionListMenu/$1';
	$route['rbac/menu/search'] = 'rbac/MenuController/actionSearch';

	# User
	$route['rbac/user'] = 'rbac/UserController/actionIndex';
	$route['rbac/user/index'] = 'rbac/UserController/actionIndex';
	$route['rbac/user/get-data']['post'] = 'rbac/UserController/actionGetData';
	$route['rbac/user/create'] = 'rbac/UserController/actionCreate';
	$route['rbac/user/detail/(:num)'] = 'rbac/UserController/actionDetail/$1';
	$route['rbac/user/simpan-detail/(:num)']['post'] = 'rbac/UserController/actionSimpanDetail/$1';
	$route['rbac/user/edit/(:num)'] = 'rbac/UserController/actionEdit/$1';
	$route['rbac/user/hapus/(:num)/(:any)'] = 'rbac/UserController/actionHapus/$1/$2';
	$route['rbac/user/get-department/(:num)'] = 'rbac/UserController/actionGetDepartment/$1';
	$route['rbac/user/get-atasan']['post'] = 'rbac/UserController/actionGetAtasan';
	$route['rbac/user/get-grade'] = 'rbac/UserController/actionGetGrade';
	$route['rbac/user/get-designation'] = 'rbac/UserController/actionGetDesignation';
	$route['rbac/user/get-kelas-jabatan'] = 'rbac/UserController/actionGetKelasJabatan';
	$route['rbac/user/get-golongan/(:num)'] = 'rbac/UserController/actionGetGolongan/$1';

	# Group
	$route['rbac/group'] = 'rbac/GroupController/actionIndex';
	$route['rbac/group/index'] = 'rbac/GroupController/actionIndex';
	$route['rbac/group/detail/(:num)'] = 'rbac/GroupController/actionDetail/$1';
	$route['rbac/group/get-data']['post'] = 'rbac/GroupController/actionGetData';
	// $route['rbac/group/simpan']['post'] = 'rbac/GroupController/actionSimpan';
	// $route['rbac/group/simpan/(:num)']['post'] = 'rbac/GroupController/actionSimpan/$1';
	// $route['rbac/group/hapus/(:num)']['post'] = 'rbac/GroupController/actionHapus/$1';

	# Route
	$route['rbac/route'] = 'rbac/RouteController/actionIndex';
	$route['rbac/route/index'] = 'rbac/RouteController/actionIndex';
	$route['rbac/route/create']['post'] = 'rbac/RouteController/actionCreate';
	$route['rbac/route/assign']['post'] = 'rbac/RouteController/actionAssign';
	$route['rbac/route/remove']['post'] = 'rbac/RouteController/actionRemove';
	$route['rbac/route/refresh']['post'] = 'rbac/RouteController/actionRefresh';

	# Allowed
	$route['rbac/allowed'] = 'rbac/AllowedController/actionIndex';
	$route['rbac/allowed/index'] = 'rbac/AllowedController/actionIndex';
	$route['rbac/allowed/create']['post'] = 'rbac/AllowedController/actionCreate';
	$route['rbac/allowed/assign']['post'] = 'rbac/AllowedController/actionAssign';
	$route['rbac/allowed/remove']['post'] = 'rbac/AllowedController/actionRemove';
	$route['rbac/allowed/refresh']['post'] = 'rbac/AllowedController/actionRefresh';

	# Permission
	$route['rbac/permission'] = 'rbac/PermissionController/actionIndex';
	$route['rbac/permission/index'] = 'rbac/PermissionController/actionIndex';
	$route['rbac/permission/detail/(:num)'] = 'rbac/PermissionController/actionDetail/$1';
	$route['rbac/permission/get-data']['post'] = 'rbac/PermissionController/actionGetData';
	$route['rbac/permission/simpan']['post'] = 'rbac/PermissionController/actionSimpan';
	$route['rbac/permission/simpan/(:num)']['post'] = 'rbac/PermissionController/actionSimpan/$1';
	$route['rbac/permission/hapus/(:num)']['post'] = 'rbac/PermissionController/actionHapus/$1';
	$route['rbac/permission/view/(:num)'] = 'rbac/PermissionController/actionView/$1';
	$route['rbac/permission/assign/(:num)']['post'] = 'rbac/PermissionController/actionAssign/$1';
	$route['rbac/permission/remove/(:num)']['post'] = 'rbac/PermissionController/actionRemove/$1';
	$route['rbac/permission/refresh/(:num)']['post'] = 'rbac/PermissionController/actionRefresh/$1';

	# Permission
	$route['rbac/assignment'] = 'rbac/AssignmentController/actionIndex';
	$route['rbac/assignment/index'] = 'rbac/AssignmentController/actionIndex';
	$route['rbac/assignment/get-data']['post'] = 'rbac/AssignmentController/actionGetData';
	$route['rbac/assignment/view/(:num)'] = 'rbac/AssignmentController/actionView/$1';
	$route['rbac/assignment/assign/(:num)']['post'] = 'rbac/AssignmentController/actionAssign/$1';
	$route['rbac/assignment/remove/(:num)']['post'] = 'rbac/AssignmentController/actionRemove/$1';
	$route['rbac/assignment/refresh/(:num)']['post'] = 'rbac/AssignmentController/actionRefresh/$1';
# END MODULE RBAC ROUTES

# START MODULE EDUCATION ROUTES
	# SUMMARY
	$route['academics'] = 'academics/DashboardController/actionIndex';
	$route['academics/dashboard'] = 'academics/DashboardController/actionIndex';
	$route['academics/dashboard/index'] = 'academics/DashboardController/actionIndex';
	$route['academics/dashboard/(:any)'] = 'academics/DashboardController/actionIndex/$1';
	$route['academics/dashboard/detail'] = 'academics/DashboardController/actionDetail';
	$route['academics/dashboard/detail/(:any)'] = 'academics/DashboardController/actionDetail/$1';
	$route['academics/dashboard/get-summary'] = 'academics/DashboardController/actionGetSummary';
	$route['academics/dashboard/get-summary/(:any)'] = 'academics/DashboardController/actionGetSummary/$1';
	$route['academics/dashboard/get-status-mhs'] = 'academics/DashboardController/actionGetStatusMhs';
	$route['academics/dashboard/get-status-mhs/(:any)'] = 'academics/DashboardController/actionGetStatusMhs/$1';
	$route['academics/dashboard/get-status-prodi'] = 'academics/DashboardController/actionGetStatusProdi';
	$route['academics/dashboard/get-status-prodi/(:any)'] = 'academics/DashboardController/actionGetStatusProdi/$1';
	$route['academics/dashboard/get-status-cabang'] = 'academics/DashboardController/actionGetStatusCabang';
	$route['academics/dashboard/get-status-cabang/(:any)'] = 'academics/DashboardController/actionGetStatusCabang/$1';
	$route['academics/dashboard/get-data-detail'] = 'academics/DashboardController/actionGetDataDetail';
	$route['academics/dashboard/get-data-detail/(:any)'] = 'academics/DashboardController/actionGetDataDetail/$1';
	$route['academics/dashboard/get-sum-cabang'] = 'academics/DashboardController/actionGetSumCabang';
	$route['academics/dashboard/get-sum-cabang/(:any)'] = 'academics/DashboardController/actionGetSumCabang/$1';

	# RECAPITULATION
	$route['academics/recapitulation'] = 'academics/RecapitulationController/actionIndex';
	$route['academics/recapitulation/index'] = 'academics/RecapitulationController/actionIndex';
	$route['academics/recapitulation/(:any)'] = 'academics/RecapitulationController/actionIndex/$1';
	$route['academics/recapitulation/get-table-recap'] = 'academics/RecapitulationController/actionGetTableRecap';
	$route['academics/recapitulation/get-table-recap/(:any)'] = 'academics/RecapitulationController/actionGetTableRecap/$1';
	$route['academics/recapitulation/export-pdf'] = 'academics/RecapitulationController/actionExportPdf';
	$route['academics/recapitulation/export-pdf/(:any)'] = 'academics/RecapitulationController/actionExportPdf/$1';

	# REPORT RATA-RATA IPK
	$route['academics/report-rerata-ipk'] = 'academics/ReportRerataIpkController/actionIndex';
	$route['academics/report-rerata-ipk/index'] = 'academics/ReportRerataIpkController/actionIndex';
	$route['academics/report-rerata-ipk/(:any)'] = 'academics/ReportRerataIpkController/actionIndex/$1';
	$route['academics/report-rerata-ipk/get-data'] = 'academics/ReportRerataIpkController/actionGetData';
	$route['academics/report-rerata-ipk/get-data/(:any)'] = 'academics/ReportRerataIpkController/actionGetData/$1';

	# REPORT STATUS KELULUSAN
	$route['academics/report-status-kelulusan'] = 'academics/ReportStatusKelulusanController/actionIndex';
	$route['academics/report-status-kelulusan/index'] = 'academics/ReportStatusKelulusanController/actionIndex';
	$route['academics/report-status-kelulusan/(:any)'] = 'academics/ReportStatusKelulusanController/actionIndex/$1';
	$route['academics/report-status-kelulusan/get-data'] = 'academics/ReportStatusKelulusanController/actionGetData';
	$route['academics/report-status-kelulusan/get-data/(:any)'] = 'academics/ReportStatusKelulusanController/actionGetData/$1';

	# REPORT STATUS KELULUSAN
	$route['academics/report-status-pekerjaan'] = 'academics/ReportStatusPekerjaanController/actionIndex';
	$route['academics/report-status-pekerjaan/index'] = 'academics/ReportStatusPekerjaanController/actionIndex';
	$route['academics/report-status-pekerjaan/(:any)'] = 'academics/ReportStatusPekerjaanController/actionIndex/$1';
	$route['academics/report-status-pekerjaan/get-data'] = 'academics/ReportStatusPekerjaanController/actionGetData';
	$route['academics/report-status-pekerjaan/get-data/(:any)'] = 'academics/ReportStatusPekerjaanController/actionGetData/$1';

# END MODULE EDUCATION ROUTES

# START MODULE CNP ROUTES
	# DASHBOARD
	$route['cnp'] = 'cnp/DashboardController/actionIndex';
	$route['cnp/dashboard'] = 'cnp/DashboardController/actionIndex';
	$route['cnp/dashboard/index'] = 'cnp/DashboardController/actionIndex';
	$route['cnp/dashboard/(:any)'] = 'cnp/DashboardController/actionIndex/$1';
	$route['cnp/dashboard/get-summary'] = 'cnp/DashboardController/actionGetSummary';
	$route['cnp/dashboard/get-summary/(:any)'] = 'cnp/DashboardController/actionGetSummary/$1';
	$route['cnp/dashboard/get-placement'] = 'cnp/DashboardController/actionGetPlacement';
	$route['cnp/dashboard/get-placement/(:any)'] = 'cnp/DashboardController/actionGetPlacement/$1';
	$route['cnp/dashboard/get-graph-scale'] = 'cnp/DashboardController/actionGetGraphScale';
	$route['cnp/dashboard/get-graph-scale/(:any)'] = 'cnp/DashboardController/actionGetGraphScale/$1';
	$route['cnp/dashboard/get-graph-failure'] = 'cnp/DashboardController/actionGetGraphFailure';
	$route['cnp/dashboard/get-graph-failure/(:any)'] = 'cnp/DashboardController/actionGetGraphFailure/$1';
	$route['cnp/dashboard/get-graph-request'] = 'cnp/DashboardController/actionGetGraphRequest';
	$route['cnp/dashboard/get-graph-request/(:any)'] = 'cnp/DashboardController/actionGetGraphRequest/$1';

	# RECAPITULATION PERUSAHAAN CABANG
	$route['cnp/recapitulation-perusahaan-cabang'] = 'cnp/RecapitulationPerusahaanCabangController/actionIndex';
	$route['cnp/recapitulation-perusahaan-cabang/index'] = 'cnp/RecapitulationPerusahaanCabangController/actionIndex';
	$route['cnp/recapitulation-perusahaan-cabang/(:any)'] = 'cnp/RecapitulationPerusahaanCabangController/actionIndex/$1';
	$route['cnp/recapitulation-perusahaan-cabang/get-data'] = 'cnp/RecapitulationPerusahaanCabangController/actionGetData';
	$route['cnp/recapitulation-perusahaan-cabang/get-data/(:any)'] = 'cnp/RecapitulationPerusahaanCabangController/actionGetData/$1';
	$route['cnp/recapitulation-perusahaan-cabang/summary'] = 'cnp/RecapitulationPerusahaanCabangController/actionSummary';
	$route['cnp/recapitulation-perusahaan-cabang/summary/(:any)'] = 'cnp/RecapitulationPerusahaanCabangController/actionSummary/$1';

	# RECAPITULATION ALUMNI MAGANG/KERJA
	$route['cnp/recapitulation-alumni-karir'] = 'cnp/RecapitulationAlumniKarirController/actionIndex';
	$route['cnp/recapitulation-alumni-karir/index'] = 'cnp/RecapitulationAlumniKarirController/actionIndex';
	$route['cnp/recapitulation-alumni-karir/(:any)'] = 'cnp/RecapitulationAlumniKarirController/actionIndex/$1';
	$route['cnp/recapitulation-alumni-karir/get-data'] = 'cnp/RecapitulationAlumniKarirController/actionGetData';
	$route['cnp/recapitulation-alumni-karir/get-data/(:any)'] = 'cnp/RecapitulationAlumniKarirController/actionGetData/$1';
	$route['cnp/recapitulation-alumni-karir/get-tahun-angkatan'] = 'cnp/RecapitulationAlumniKarirController/actionGetTahunAngkatan';
	$route['cnp/recapitulation-alumni-karir/get-tahun-angkatan/(:any)'] = 'cnp/RecapitulationAlumniKarirController/actionGetTahunAngkatan/$1';

	# RECAPITULATION ALUMNI MAGANG/KERJA
	$route['cnp/recapitulation-proses-penempatan'] = 'cnp/RecapitulationProsesPenempatanController/actionIndex';
	$route['cnp/recapitulation-proses-penempatan/index'] = 'cnp/RecapitulationProsesPenempatanController/actionIndex';
	$route['cnp/recapitulation-proses-penempatan/(:any)'] = 'cnp/RecapitulationProsesPenempatanController/actionIndex/$1';
	$route['cnp/recapitulation-proses-penempatan/get-table'] = 'cnp/RecapitulationProsesPenempatanController/actionGetTable';
	$route['cnp/recapitulation-proses-penempatan/get-table/(:any)'] = 'cnp/RecapitulationProsesPenempatanController/actionGetTable/$1';
	$route['cnp/recapitulation-proses-penempatan/export-pdf'] = 'cnp/RecapitulationProsesPenempatanController/actionExportPdf';
	$route['cnp/recapitulation-proses-penempatan/export-pdf/(:any)'] = 'cnp/RecapitulationProsesPenempatanController/actionExportPdf/$1';
	$route['cnp/recapitulation-proses-penempatan/get-tahun-angkatan'] = 'cnp/RecapitulationProsesPenempatanController/actionGetTahunAngkatan';
	$route['cnp/recapitulation-proses-penempatan/get-tahun-angkatan/(:any)'] = 'cnp/RecapitulationProsesPenempatanController/actionGetTahunAngkatan/$1';

	# RECAPITULATION PROSES BULANAN
	$route['cnp/recapitulation-proses-bulanan'] = 'cnp/RecapitulationProsesBulananController/actionIndex';
	$route['cnp/recapitulation-proses-bulanan/index'] = 'cnp/RecapitulationProsesBulananController/actionIndex';
	$route['cnp/recapitulation-proses-bulanan/(:any)'] = 'cnp/RecapitulationProsesBulananController/actionIndex/$1';
	$route['cnp/recapitulation-proses-bulanan/get-table'] = 'cnp/RecapitulationProsesBulananController/actionGetTable';
	$route['cnp/recapitulation-proses-bulanan/get-table/(:any)'] = 'cnp/RecapitulationProsesBulananController/actionGetTable/$1';
	$route['cnp/recapitulation-proses-bulanan/export-pdf'] = 'cnp/RecapitulationProsesBulananController/actionExportPdf';
	$route['cnp/recapitulation-proses-bulanan/export-pdf/(:any)'] = 'cnp/RecapitulationProsesBulananController/actionExportPdf/$1';

	# RECAPITULATION KESESUAIAN JURUSAN
	$route['cnp/recapitulation-kesesuaian-jurusan'] = 'cnp/RecapitulationKesesuaianJurusanController/actionIndex';
	$route['cnp/recapitulation-kesesuaian-jurusan/index'] = 'cnp/RecapitulationKesesuaianJurusanController/actionIndex';
	$route['cnp/recapitulation-kesesuaian-jurusan/(:any)'] = 'cnp/RecapitulationKesesuaianJurusanController/actionIndex/$1';
	$route['cnp/recapitulation-kesesuaian-jurusan/get-table'] = 'cnp/RecapitulationKesesuaianJurusanController/actionGetTable';
	$route['cnp/recapitulation-kesesuaian-jurusan/get-table/(:any)'] = 'cnp/RecapitulationKesesuaianJurusanController/actionGetTable/$1';
	$route['cnp/recapitulation-kesesuaian-jurusan/export-pdf'] = 'cnp/RecapitulationKesesuaianJurusanController/actionExportPdf';
	$route['cnp/recapitulation-kesesuaian-jurusan/export-pdf/(:any)'] = 'cnp/RecapitulationKesesuaianJurusanController/actionExportPdf/$1';
	$route['cnp/recapitulation-kesesuaian-jurusan/get-cabang'] = 'cnp/RecapitulationKesesuaianJurusanController/actionGetCabang';
	$route['cnp/recapitulation-kesesuaian-jurusan/get-cabang/(:any)'] = 'cnp/RecapitulationKesesuaianJurusanController/actionGetCabang/$1';

	# RECAPITULATION PERMINTAAN
	$route['cnp/recapitulation-permintaan'] = 'cnp/RecapitulationPermintaanController/actionIndex';
	$route['cnp/recapitulation-permintaan/index'] = 'cnp/RecapitulationPermintaanController/actionIndex';
	$route['cnp/recapitulation-permintaan/(:any)'] = 'cnp/RecapitulationPermintaanController/actionIndex/$1';
	$route['cnp/recapitulation-permintaan/get-table'] = 'cnp/RecapitulationPermintaanController/actionGetTable';
	$route['cnp/recapitulation-permintaan/get-table/(:any)'] = 'cnp/RecapitulationPermintaanController/actionGetTable/$1';
	$route['cnp/recapitulation-permintaan/get-data'] = 'cnp/RecapitulationPermintaanController/actionGetData';
	$route['cnp/recapitulation-permintaan/get-data/(:any)'] = 'cnp/RecapitulationPermintaanController/actionGetData/$1';
	$route['cnp/recapitulation-permintaan/export-pdf'] = 'cnp/RecapitulationPermintaanController/actionExportPdf';
	$route['cnp/recapitulation-permintaan/export-pdf/(:any)'] = 'cnp/RecapitulationPermintaanController/actionExportPdf/$1';

	# RECAPITULATION RATA-RATA GAJI
	$route['cnp/recapitulation-rerata-gaji'] = 'cnp/RecapitulationRerataGajiController/actionIndex';
	$route['cnp/recapitulation-rerata-gaji/index'] = 'cnp/RecapitulationRerataGajiController/actionIndex';
	$route['cnp/recapitulation-rerata-gaji/(:any)'] = 'cnp/RecapitulationRerataGajiController/actionIndex/$1';
	$route['cnp/recapitulation-rerata-gaji/get-table'] = 'cnp/RecapitulationRerataGajiController/actionGetTable';
	$route['cnp/recapitulation-rerata-gaji/get-table/(:any)'] = 'cnp/RecapitulationRerataGajiController/actionGetTable/$1';
	$route['cnp/recapitulation-rerata-gaji/export-pdf'] = 'cnp/RecapitulationRerataGajiController/actionExportPdf';
	$route['cnp/recapitulation-rerata-gaji/export-pdf/(:any)'] = 'cnp/RecapitulationRerataGajiController/actionExportPdf/$1';
	$route['cnp/recapitulation-rerata-gaji/get-cabang'] = 'cnp/RecapitulationRerataGajiController/actionGetCabang';
	$route['cnp/recapitulation-rerata-gaji/get-cabang/(:any)'] = 'cnp/RecapitulationRerataGajiController/actionGetCabang/$1';
# END MODULE CNP ROUTES
# START PROCUREMENT ROUTE
# DASHBOARD
$route['procurement'] = 'procurement/DashboardController/actionIndex';
$route['procurement/dashboard'] = 'procurement/DashboardController/actionIndex';
$route['procurement/dashboard/index'] = 'procurement/DashboardController/actionIndex';
$route['procurement/dashboard/(:any)'] = 'procurement/DashboardController/actionIndex/$1';

# MASTER DATA
# SUPPLIER
$route['procurement/master-supplier'] = 'procurement/MasterSupplierController/actionIndex';
$route['procurement/master-supplier/index'] = 'procurement/MasterSupplierController/actionIndex';
// $route['procurement/master-supplier/(:any)'] = 'procurement/MasterSupplierController/actionIndex/$1';
$route['procurement/master-supplier/editData'] = 'procurement/MasterSupplierController/actionEditData';
$route['procurement/master-supplier/tambahData'] = 'procurement/MasterSupplierController/actionAddData';

# BARANG
$route['procurement/master-barang'] = 'procurement/MasterBarangController/actionIndex';
$route['procurement/master-barang/index'] = 'procurement/MasterBarangController/actionIndex';
// $route['procurement/master-barang/(:any)'] = 'procurement/MasterBarangController/actionIndex/$1';
$route['procurement/master-barang/editData'] = 'procurement/MasterBarangController/actionEditData';
$route['procurement/master-barang/tambahData'] = 'procurement/MasterBarangController/actionAddData';
# KATEGORI BARANG
$route['procurement/master-kategori-barang'] = 'procurement/MasterKategoriBarangController/actionIndex';
$route['procurement/master-kategori-barang/index'] = 'procurement/MasterKategoriBarangController/actionIndex';
// $route['procurement/master-kategori-barang/(:any)'] = 'procurement/MasterKategoriBarangController/actionIndex/$1';
$route['procurement/master-kategori-barang/editData'] = 'procurement/MasterKategoriBarangController/actionEditData';
$route['procurement/master-kategori-barang/tambahData'] = 'procurement/MasterKategoriBarangController/actionAddData';
# SATUAN
$route['procurement/master-satuan'] = 'procurement/MasterSatuanController/actionIndex';
$route['procurement/master-satuan/index'] = 'procurement/MasterSatuanController/actionIndex';
// $route['procurement/master-satuan/(:any)'] = 'procurement/MasterSatuanController/actionIndex/$1';
$route['procurement/master-satuan/editData'] = 'procurement/MasterSatuanController/actionEditData';
$route['procurement/master-satuan/tambahData'] = 'procurement/MasterSatuanController/actionAddData';


#PURCHASE ORDER
#BUAT PO
$route['procurement/purchase-create-order'] = 'procurement/PurchaseCreateOrderController/actionIndex';
$route['procurement/purchase-create-order/index'] = 'procurement/PurchaseCreateOrderController/actionIndex';
$route['procurement/purchase-create-order/(:any)'] = 'procurement/PurchaseCreateOrderController/actionIndex/$1';
#DAFTAR PO
$route['procurement/purchase-list-order'] = 'procurement/PurchaseListOrderController/actionIndex';
$route['procurement/purchase-list-order/index'] = 'procurement/PurchaseListOrderController/actionIndex';
// $route['procurement/purchase-list-order/(:any)'] = 'procurement/PurchaseListOrderController/actionIndex/$1';
#PENERIMAAN BARANG
$route['procurement/purchase-receipt'] = 'procurement/PurchaseReceiptController/actionIndex';
$route['procurement/purchase-receipt/index'] = 'procurement/PurchaseReceiptController/actionIndex';
// $route['procurement/purchase-receipt/(:any)'] = 'procurement/PurchaseReceiptController/actionIndex/$1';
#DETAIL LIST ORDER
$route['procurement/purchase-list-order/detail'] = 'procurement/PurchaseListOrderController/actionDetail';

#DETAIL PURCHASE
$route['procurement/purchase-receipt/detail'] = 'procurement/PurchaseReceiptController/actionDetail';

#VENDOR REPORT
$route['procurement/vendor-report'] = 'procurement/VendorReportController/actionIndex';
$route['procurement/vendor-report/index'] = 'procurement/VendorReportController/actionIndex';
// $route['procurement/vendor-report/(:any)'] = 'procurement/VendorReportController/actionIndex/$1';

#EXPENSE REPORT
$route['procurement/expense-report'] = 'procurement/ExpenseReportController/actionIndex';
$route['procurement/expense-report/index'] = 'procurement/ExpenseReportController/actionIndex';
$route['procurement/expense-report/(:any)'] = 'procurement/ExpenseReportController/actionIndex/$1';
#STOCK REPORT
$route['procurement/stock-report'] = 'procurement/StockReportController/actionIndex';
$route['procurement/stock-report/index'] = 'procurement/StockReportController/actionIndex';
$route['procurement/stock-report/(:any)'] = 'procurement/StockReportController/actionIndex/$1';
#PURCHASE REPORT
$route['procurement/purchase-report'] = 'procurement/PurchaseReportController/actionIndex';
$route['procurement/purchase-report/index'] = 'procurement/PurchaseReportController/actionIndex';
$route['procurement/purchase-report/(:any)'] = 'procurement/PurchaseReportController/actionIndex/$1';
# END PROCUREMENT ROUTE