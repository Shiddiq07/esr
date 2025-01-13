<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @link https://stackoverflow.com/a/30083294
 */
class MY_Exceptions extends CI_Exceptions
{
	private $statuses = [
		100	=> 'Continue',
		101	=> 'Switching Protocols',

		200	=> 'OK',
		201	=> 'Created',
		202	=> 'Accepted',
		203	=> 'Non-Authoritative Information',
		204	=> 'No Content',
		205	=> 'Reset Content',
		206	=> 'Partial Content',

		300	=> 'Multiple Choices',
		301	=> 'Moved Permanently',
		302	=> 'Found',
		303	=> 'See Other',
		304	=> 'Not Modified',
		305	=> 'Use Proxy',
		307	=> 'Temporary Redirect',

		400	=> 'Bad Request',
		401	=> 'Unauthorized',
		402	=> 'Payment Required',
		403	=> 'Forbidden',
		404	=> 'Not Found',
		405	=> 'Method Not Allowed',
		406	=> 'Not Acceptable',
		407	=> 'Proxy Authentication Required',
		408	=> 'Request Timeout',
		409	=> 'Conflict',
		410	=> 'Gone',
		411	=> 'Length Required',
		412	=> 'Precondition Failed',
		413	=> 'Request Entity Too Large',
		414	=> 'Request-URI Too Long',
		415	=> 'Unsupported Media Type',
		416	=> 'Requested Range Not Satisfiable',
		417	=> 'Expectation Failed',
		422	=> 'Unprocessable Entity',
		426	=> 'Upgrade Required',
		428	=> 'Precondition Required',
		429	=> 'Too Many Requests',
		431	=> 'Request Header Fields Too Large',

		500	=> 'Internal Server Error',
		501	=> 'Not Implemented',
		502	=> 'Bad Gateway',
		503	=> 'Service Unavailable',
		504	=> 'Gateway Timeout',
		505	=> 'HTTP Version Not Supported',
		511	=> 'Network Authentication Required',
	];

	protected $exceptional_exception = [
		'database'
	];

	public function __construct() {
        parent::__construct();
    }

	public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
	{
		$is_exceptional = false;

		$error_message = "🚨 <b>General Error</b>\n";
	    $error_message .= "Heading: <code>{$heading}</code>\n";
	    $error_message .= "Message: <code>{$message}</code>\n";
	    $error_message .= "Status Code: <code>{$status_code}</code>";
		$this->sendToTelegramChannel($error_message);

		if (is_array($message)) {
			$joinned_messages = implode('|', $message);

			foreach ($this->exceptional_exception as $key => $value) {
				if (strpos($joinned_messages, $value) !== false) {
					$is_exceptional = true;

					break;
				}
			}
		}

		if (!class_exists('CI_Controller') || $is_exceptional) {
			return parent::show_error($heading, $message, $template, $status_code);
		}

		if ($template == 'error_general') {
			$template = 'custom_error_general';
		}

		// $CI = new CI_Controller;
		// $CI =& $CI->get_instance();
		$CI =& get_instance();
		$templates_path = config_item('error_views_path');

		if (empty($templates_path)) {
			$templates_path = VIEWPATH.'errors'.DIRECTORY_SEPARATOR;
		}

		if (is_cli()) {
			$message = "\t".(is_array($message) ? implode("\n\t", $message) : $message);
			$template = 'cli'.DIRECTORY_SEPARATOR.$template;

			ob_start();
			include($templates_path.$template.'.php');
			$buffer = ob_get_contents();
			ob_end_clean();
			return $buffer;

		} else {
			set_status_header($status_code);
			$message = '<p>'.(is_array($message) ? implode('</p><p>', $message) : $message).'</p>';
			$template = 'html'.'/'.$template;

			$view = $CI->load->view('layouts/main', [
				'data' => [
					'heading' => def($this->statuses, $status_code, $heading),
					'message' => $message,
					'status_code' => $status_code,
				],
				'title' => $status_code .' '. def($this->statuses, $status_code),
				'view' => 'errors/'.$template,
				'breadcrumbs' => [
					'<a href="' . site_url('/') . '">Home</a>',
					'Error ' . $status_code,
				],
			], true);
		}

		if (ob_get_level() > $this->ob_level + 1) {
			ob_end_flush();
		}

		ob_start();
		echo $view;
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}

	public function show_exception($exception)
	{
		$type = get_class($exception);

		$error_message = "🚨 <b>{$exception}</b>\n";
	    $error_message .= "Message: <code>{$exception->getMessage()}</code>\n";
	    $error_message .= "File: <code>{$exception->getFile()}</code>\n";
	    $error_message .= "Line Code: <code>{$exception->getLine()}</code>";

	    if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE){
			$error_message .= '<p>Backtrace:</p>';

			foreach ($exception->getTrace() as $error){
				if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0) {
					$error_message .= '<p style="margin-left:10px">';
					$error_message .= 'File: '. $error['file'] .'<br />';
					$error_message .= 'Line: '. $error['line'] .'<br />';
					$error_message .= 'Function: '. $error['function'];
					$error_message .= '</p>';
				}
			}
	    }

		$this->sendToTelegramChannel($error_message);

		parent::show_exception($exception);
	}

	public function show_php_error($severity, $message, $filepath, $line)
	{
		$severity = isset($this->levels[$severity]) ? $this->levels[$severity] : $severity;

		$error_message = "🚨 <b>{$severity}</b>\n";
	    $error_message .= "Message: <code>{$message}</code>\n";
	    $error_message .= "File: <code>{$filepath}</code>\n";
	    $error_message .= "Line: <code>{$line}</code>";

		$this->sendToTelegramChannel($error_message);

		parent::show_php_error($severity, $message, $filepath, $line);
	}

	// Function helper buat kirim ke Telegram
	protected function sendToTelegramChannel($message) {
	    $bot_token = defined('TELEGRAM_TOKEN') ? TELEGRAM_TOKEN : '';
	    $chat_id = defined('TELEGRAM_CHANNEL_ID') ? TELEGRAM_CHANNEL_ID : '';
	    $url = defined('TELEGRAM_URL') ? TELEGRAM_URL : '';

	    if (!$bot_token || !$chat_id || !$url) {
	    	return;
	    }

	    $data = [
	        'chat_id' => $chat_id,
	        'text' => $message,
	        'parse_mode' => 'HTML',
	    ];

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    curl_close($ch);

	    return json_decode($response, true);
	}
	
}
