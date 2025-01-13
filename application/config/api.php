<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING API
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| The creation of this file was initiated by user needs of API
*/

$route['api/academic/summary'] = 'api/AcademicController/actionSummary';
$route['api/academic/summary/(:any)'] = 'api/AcademicController/actionSummary/$1';
$route['api/academic/graph-status'] = 'api/AcademicController/actionGraphStatus';
$route['api/academic/graph-status/(:any)'] = 'api/AcademicController/actionGraphStatus/$1';
$route['api/academic/graph-prodi'] = 'api/AcademicController/actionGraphProdi';
$route['api/academic/graph-prodi/(:any)'] = 'api/AcademicController/actionGraphProdi/$1';
$route['api/academic/graph-cabang'] = 'api/AcademicController/actionGraphCabang';
$route['api/academic/graph-cabang/(:any)'] = 'api/AcademicController/actionGraphCabang/$1';
$route['api/academic/graph-all-cabang'] = 'api/AcademicController/actionGraphAllCabang';
$route['api/academic/graph-all-cabang/(:any)'] = 'api/AcademicController/actionGraphAllCabang/$1';

# LIST DROPDOWN
$route['api/list-dropdown/tahun-biodata/(:any)'] = 'api/ListDropdownController/actionTahunBiodata/$1';
$route['api/list-dropdown/jurusan-cabang/(:any)'] = 'api/ListDropdownController/actionJurusanCabang/$1';
