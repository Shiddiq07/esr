<?php

/**
 * Library untuk nyimpen method atau 
 * helper yg bisa terhubung dengan model
 *
 * @author Ilham D. Sofyan
 */
class Helpers
{
	public $CI;

    public $months = [
        1 => "Januari", 
        "Februari", 
        "Maret", 
        "April", 
        "Mei", 
        "Juni", 
        "Juli", 
        "Agustus", 
        "September", 
        "Oktober", 
        "November", 
        "Desember"
    ];

	public function __construct()
	{
		$this->CI =& get_instance();

        get_instance()->load->model([
            'rbac/user',
            'rbac/group',
            'rbac/allowed',
            'rbac/authassignment',
            'rbac/permission',
        ]);
	}

	/**
	 * [isGuest description]
	 * @return boolean [description]
	 */
	public function isGuest()
	{
		return empty($this->CI->session->userdata('status_login'));
	}

	public function getRoute()
	{
		$routes = array_reverse($this->CI->router->routes); // All routes as specified in config/routes.php, reserved because Codeigniter matched route from last element in array to first.
		foreach ($routes as $key => $val) {
			$route = $key; // Current route being checked.

			// Convert wildcards to RegEx
			$key = str_replace(array(':any', ':num'), array('[^/]+', '[0-9]+'), $key);

			// Does the RegEx match?
			if (preg_match('#^'.$key.'$#', $this->CI->uri->uri_string(), $matches)) break;
		}

		if ( ! $route) $route = $routes['default_route']; // If the route is blank, it can only be mathcing the default route.

		return $route; // We found our route
	}

	public function getQueryParams()
	{
		return $_GET;
	}

	/**
     * Removes an item from an array and returns the value. If the key does not exist in the array, the default value
     * will be returned instead.
     *
     * Usage examples,
     *
     * ```php
     * // $array = ['type' => 'A', 'options' => [1, 2]];
     * // working with array
     * $type = \yii\helpers\ArrayHelper::remove($array, 'type');
     * // $array content
     * // $array = ['options' => [1, 2]];
     * ```
     *
     * @param array $array the array to extract value from
     * @param string $key key name of the array element
     * @param mixed $default the default value to be returned if the specified key does not exist
     * @return mixed|null the value of the element if found, default value otherwise
     */
    public function arrayRemove(&$array, $key, $default = null)
    {
        if (is_array($array) && (isset($array[$key]) || array_key_exists($key, $array))) {
            $value = $array[$key];
            unset($array[$key]);

            return $value;
        }

        return $default;
    }

    public static function filterRoutes($routes = [], $action = true)
    {
        $res = $routes;

        if ($action)
            $res = self::filterAction($res);
        else
            $res = self::filterActionAllowed($res);

        $res = self::filterAllow($res);
        return $res;
    }

    public static function filterAction($routes)
    {
        $res = [];
        if (!empty($routes)) {
            foreach ($routes as $key => $value) {
                if (!empty($value)) {
                    foreach ($value as $k => $v) {
                        if (substr(trim($v), -1) !== '*') {
                            $res[$key][] = $v;
                        }
                    }
                } else {
                    $res[$key] = [];
                }
            }
        }
        return $res;
    }

    public static function filterActionAllowed($routes)
    {
        $res = [];
        if (!empty($routes)) {
            foreach ($routes as $key => $value) {
                if (!empty($value) && $key == 'avaliable') {
                    foreach ($value as $k => $v) {
                        if (substr(trim($v), -1) !== '*') {
                            $res[$key][] = $v;
                        }
                    }
                } else {
                    $res[$key] = $value;
                }
            }
        }
        return $res;
    }

    public static function filterAllow($routes)
    {
        $res = $tmp = [];
        if (!empty($routes)) {
            $allowed = self::getAllowed();
            foreach ($routes as $key => $value) {
                if (!empty($value) && $key == 'avaliable') {
                    $res[$key] = [];
                    foreach ($value as $k => $v) {
                        if (!empty($allowed)) {
                            foreach ($allowed as $k1 => $v1) {
                                if (substr($v1, -1) === '*') {
                                    $route = rtrim($v1, "*");
                                    if (strlen($route) === 0 || strpos($v, $route) === 1) {
                                        $tmp[] = $v;
                                    }
                                } else {
                                    if (ltrim($v1, "/") === ltrim($v, "/")) {
                                        $tmp[] = $v;
                                    }
                                }
                            }
                        }
                    }
                    $res[$key] = array_diff($value, $tmp);
                } else {
                    $res[$key] = $value;
                }
            }
        }
        return $res;
    }

    public static function getAllowed()
    {
        $that = new self;
        $alloweds = $that->CI->allowed->findAll();
        $list_allowed = [];

        foreach ($alloweds as $key => $value) {
            $list_allowed[$value->id] = $value->allowed;
        }

        return $list_allowed;
    }

    // public function isSuperAdmin()
    // {
    //     $model = $this->CI->user->findOne($this->CI->session->userdata('identity')->id);

    //     return $model->isHasGroup(Group::ADMIN);
    // }

    // public function isAdminDirektorat()
    // {
    //     $model = $this->CI->user->findOne($this->CI->session->userdata('identity')->id);

    //     return $model->isHasGroup(Group::ADMIN_DIR);
    // }

    // public function isAdminCabang()
    // {
    //     $model = $this->CI->user->findOne($this->CI->session->userdata('identity')->id);

    //     return $model->isHasGroup(Group::ADMIN_CABANG);
    // }

    // public function isUser()
    // {
    //     $model = $this->CI->user->findOne($this->CI->session->userdata('identity')->id);

    //     return $model->isHasGroup(Group::USER);
    // }

    // public function isManajemenHo()
    // {
    //     $model = $this->CI->user->findOne($this->CI->session->userdata('identity')->id);

    //     return $model->isHasGroup(Group::MANAJEMEN_HO);
    // }

    // public function isManajemenDirektorat()
    // {
    //     $model = $this->CI->user->findOne($this->CI->session->userdata('identity')->id);

    //     return $model->isHasGroup(Group::MANAJEMEN_DIR);
    // }

    // public function isManajemenCabang()
    // {
    //     $model = $this->CI->user->findOne($this->CI->session->userdata('identity')->id);

    //     return $model->isHasGroup(Group::MANAJEMEN_CABANG);
    // }

    // public function isKeuangan()
    // {
    //     $model = $this->CI->user->findOne($this->CI->session->userdata('identity')->id);

    //     return $model->isHasGroup(Group::KEUANGAN);
    // }

    public function isCollege()
    {
        return $this->CI->group->isHasGroup($this->CI->session->userdata('group_id'), Group::COLLEGE);
    }

    public function isPoltek()
    {
        return $this->CI->group->isHasGroup($this->CI->session->userdata('group_id'), Group::POLTEK);
    }

    public function isLokal()
    {
        return $this->CI->group->isHasGroup($this->CI->session->userdata('group_id'), Group::LOKAL);
    }

    public function valueErrors($errors, $list = false)
    {
        $error_values = array_values($errors);

        if ($list) {
            return $this->CI->html->ul($error_values);
        } else {
            return implode('; ', array_values($error_values));
        }
    }

    public function getRoutesByGroup($groups)
    {
        $routes = [];
        $permissions_child = [];

        $permissions = $this->CI->authassignment->getPermissionsByGroup($groups);

        if ($permissions) {
            foreach ($permissions as $key => $permission) {
                $permissions_child[] = $permission->child;
            }
        }

        if ($permissions_child) {
            foreach ($permissions_child as $key => $childs) {
                foreach ($childs as $key => $child) {
                    $routes[] = $child->child;
                }
            }
        }

        return array_unique($routes);
    }

    public function getCurrentSite()
    {
        $controller = str_replace('Controller', '', $this->CI->router->fetch_class());
        $slug_controller = camelToSlug($controller, '-');
        $method = str_replace('action', '', $this->CI->router->fetch_method());
        $slug_method = camelToSlug($method, '-');

        return $this->CI->router->fetch_module() .'/'. $slug_controller .'/'. $slug_method;
    }
  
    /**
     * [diffHours description]
     * @param  string $start [00:00]
     * @param  string $end   [00:00]
     * @return int
     */
    public function diffHours($start, $end) {
        $starttimestamp = strtotime(date('H:i', strtotime($start)));
        $endtimestamp = strtotime(date('H:i', strtotime($end)));
        $difference = abs($endtimestamp - $starttimestamp) / 3600;

        return $difference;
    }

    public function getMonthNum($name)
    {
        $months = array_reverse($this->months);
        $name = strtolower($name);

        return $months[$name] ? $months[$name] : null;
    }

    public function getMonthName($num)
    {
        $months = $this->months;

        return $months[$num] ? $months[$num] : null;
    }

    /**
     * [formatDateIndonesia description]
     * @param  [type] $date [Y-m-d]
     * @return [type]       [description]
     */
    public function formatDateIndonesia($date)
    {
        $result = '';

        if ($date) {
            $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            $tahun = substr($date, 0, 4);
            $bulan = substr($date, 5, 2);
            $tgl   = substr($date, 8, 2);

            if (array_key_exists((int)$bulan-1, $BulanIndo)) {
                $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
            } else {
                $result = "-";
            }
        }

        return $result;
    }

    // public function configGoogle()
    // {
    //     // google API Configuration
    //     $redirectUrl = base_url('/site/google-auth');
        
    //     //Call google API
    //     $client = new Google_Client();
    //     $client->setApplicationName("LP3I-ERS");
    //     $client->setClientId(getEnv('GOOGLE_ID'));
    //     $client->setClientSecret(getEnv('GOOGLE_SECRET'));
    //     $client->setRedirectUri($redirectUrl);
    //     $client->addScope("https://www.googleapis.com/auth/userinfo.email");

    //     return $client;
    // }

    // public function getUrlGoogle()
    // {
    //     $client = $this->configGoogle();

    //     return $client->createAuthUrl();
    // }

    public function getTimezonedDate($time, $format = 'Y-m-d H:i:s', $timezone = 'Asia/Jakarta') {
        $dt = new DateTime();
        $dt->setTimezone(new DateTimeZone($timezone));
        $dt->setTimestamp($time);
        
        return $dt->format($format);
    }


    public function formatGetRomawi($bulan){

        $result = '';

        if($bulan){
            $Romawi = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
             if (array_key_exists((int)$bulan-1, $Romawi)) {
                $result = $Romawi[(int)$bulan-1];
            } else {
                $result = "-";
            }
        }

          return $result;
    }

    /** 
     * Get header Authorization
     * */
    public function getAuthorizationHeader(){
            $headers = null;
            if (isset($_SERVER['Authorization'])) {
                $headers = trim($_SERVER["Authorization"]);
            }
            else if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
                $headers = trim($_SERVER["REDIRECT_HTTP_AUTHORIZATION"]);
            } elseif (function_exists('apache_request_headers')) {
                $requestHeaders = apache_request_headers();
                // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
                $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                //print_r($requestHeaders);
                if (isset($requestHeaders['Authorization'])) {
                    $headers = trim($requestHeaders['Authorization']);
                }
            }
            return $headers;
        }
    /**
     * get access token from header
     * */
    public function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    public function makeLinkIfExist($path, $preview = false, $title = 'Pratinjau')
    {
        $link = '';

        if (file_exists($path)) {
            $path = site_url(str_replace('./', '/', $path));

            if ($preview === true) {
                $link = "<a href='{$path}' class='dokumen-modal-button'>{$title}</a>";
            } else {
                $link = "<a href='{$path}'>{$title}</a>";
            }
        }

        return $link;
    }

    public function getHeadersViaCurl($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($ch);
        curl_close($ch);

        $headers = [];
        $data = explode("\n", $data);
        foreach($data as $part) {
            $middle = explode(":", $part);
            if (isset($middle[1])) {
                $headers[trim($middle[0])] = trim($middle[1]);
            }
        }
        return $headers;
    }

    public function urlExists($url)
    {
        $headers = $this->getHeadersViaCurl($url);

        // Check if headers were returned
        if ($headers) {
            return true;
        } else {
            return false;
        }
    }

    public function getImage($profile_pic = null, $with_domain = false)
    {
        $default = '/web/assets/img/default-user-icon.jpg';
        $img = $default;

        $profile_pic = $profile_pic ? $profile_pic : $this->CI->session->userdata('detail_identity')['profile_pic'];

        if ($profile_pic) {
            $img = strpos($profile_pic, 'http') !== false ? $profile_pic : HRIS_URL . str_replace('./', '/', $profile_pic);
        }

        if (!$this->urlExists($img)) {
            $img = base_url($default);
        }

        return $img;
    }

    public function getNotifications($to, $unread_only = false)
    {
        $this->CI->load->model('notifikasi');
        $notifikasis = $this->CI->notifikasi->getNotifications($to, $unread_only, 5);

        return $notifikasis;
    }

    public function isValidDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    /**
     * Converts a number to its roman presentation.
     **/ 
    public function numberToRoman($num)  
    { 
        // Be sure to convert the given parameter into an integer
        $n = intval($num);
        $result = ''; 
     
        // Declare a lookup array that we will use to traverse the number: 
        $lookup = array(
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
        ); 
     
        foreach ($lookup as $roman => $value)  
        {
            // Look for number of matches
            $matches = intval($n / $value); 
     
            // Concatenate characters
            $result .= str_repeat($roman, $matches); 
     
            // Substract that from the number 
            $n = $n % $value; 
        } 

        return $result; 
    } 

}
