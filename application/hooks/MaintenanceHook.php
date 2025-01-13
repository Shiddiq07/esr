<?php

require_once APPPATH . '/helpers/esr_helper.php';

class MaintenanceHook
{
	public function goMaintenance()
	{
		if (MAINTENANCE) {
			$list_allowed_ip = explode(';', MAINTENANCE_ALLOWED_IP);
			$client_ip = getClientIp();

			if (!in_array($client_ip, $list_allowed_ip)) {
				header("HTTP/1.1 503 Service Unavailable");


				include_once APPPATH . '/views/layouts/maintenance.php';
				exit();
			}
		}

		return true;
	}
}
