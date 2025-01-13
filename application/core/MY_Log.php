<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @link https://stackoverflow.com/a/30083294
 */
class MY_Log extends CI_Log
{
	public function write_log($level, $msg)
	{
		$date = date($this->_date_fmt);
		$message = $this->_format_line($level, $date, $msg);

		if ($level == 'error') {
			$this->sendToTelegramChannel($message);
		}

		parent::write_log($level, $msg);
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
