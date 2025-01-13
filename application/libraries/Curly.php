<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Curl_library class
 *
 * Provides methods for making HTTP requests using cURL.
 */
class Curly {
    
    /**
     * CodeIgniter instance
     *
     * @var object
     */
    protected $ci;

    /**
     * Constructor
     */
    public function __construct() {
        $this->ci =& get_instance();
    }

    /**
     * Makes a GET request.
     *
     * @param string $url The URL to request.
     * @param array $headers Optional. An array of headers to send with the request.
     * @return array The response, decoded from JSON.
     * @throws Exception If the cURL request fails.
     */
    public function get($url, $headers = []) {
        return $this->request('GET', $url, null, $headers);
    }

    /**
     * Makes a POST request.
     *
     * @param string $url The URL to request.
     * @param array $data Optional. The data to send with the request.
     * @param array $headers Optional. An array of headers to send with the request.
     * @return array The response, decoded from JSON.
     * @throws Exception If the cURL request fails.
     */
    public function post($url, $data = [], $headers = []) {
        return $this->request('POST', $url, $data, $headers);
    }

    /**
     * Makes a PUT request.
     *
     * @param string $url The URL to request.
     * @param array $data Optional. The data to send with the request.
     * @param array $headers Optional. An array of headers to send with the request.
     * @return array The response, decoded from JSON.
     * @throws Exception If the cURL request fails.
     */
    public function put($url, $data = [], $headers = []) {
        return $this->request('PUT', $url, $data, $headers);
    }

    /**
     * Makes a DELETE request.
     *
     * @param string $url The URL to request.
     * @param array $data Optional. The data to send with the request.
     * @param array $headers Optional. An array of headers to send with the request.
     * @return array The response, decoded from JSON.
     * @throws Exception If the cURL request fails.
     */
    public function delete($url, $data = [], $headers = []) {
        return $this->request('DELETE', $url, $data, $headers);
    }

    /**
     * Makes an HTTP request using cURL.
     *
     * @param string $method The HTTP method to use (GET, POST, PUT, DELETE).
     * @param string $url The URL to request.
     * @param array|null $data Optional. The data to send with the request.
     * @param array $headers Optional. An array of headers to send with the request.
     * @return array The response, decoded from JSON.
     * @throws Exception If the cURL request fails.
     */
    private function request($method, $url, $data = null, $headers = []) {
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        // Set HTTP method
        switch (strtoupper($method)) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
        }

        // Set headers
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        // Execute cURL request
        $response = curl_exec($ch);
        $error = curl_error($ch);

        // Debugging Purposes
        if (strpos($url, 'cabang') !== false) {
            // dd($response);
        }

        // Close cURL session
        curl_close($ch);

        if ($response === false) {
            throw new Exception('cURL Error: ' . $error);
        }

        return json_decode($response, true);
    }
}
