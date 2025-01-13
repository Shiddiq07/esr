<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/

$hook['post_controller_constructor'][] = array(
    'class'    => 'AuthHelper',
    'function' => 'checkLogin',
    'filename' => 'AuthHelper.php',
    'filepath' => 'hooks',
    'params'   => array()
);

$hook['post_controller_constructor'][] = array(
    'class'    => 'AuthHelper',
    'function' => 'checkPermission',
    'filename' => 'AuthHelper.php',
    'filepath' => 'hooks',
    'params'   => array()
);

$hook['pre_system'][] = array(
    'class'    => 'MaintenanceHook',
    'function' => 'goMaintenance',
    'filename' => 'MaintenanceHook.php',
    'filepath' => 'hooks',
    'params'   => array()
);
