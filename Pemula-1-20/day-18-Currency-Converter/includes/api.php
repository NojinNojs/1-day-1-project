<?php
function fetch_exchange_rates() {
    try {
        $client = new GuzzleHttp\Client();
        $response = $client->request('GET', "http://api.exchangeratesapi.io/v1/latest?access_key=" . API_KEY);
        $data = json_decode($response->getBody(), true);
        
        if (isset($data['success']) && $data['success'] === true && isset($data['rates'])) {
            return $data['rates'];
        } else {
            error_log("API Error: " . json_encode($data));
            return null;
        }
    } catch (Exception $e) {
        error_log("API Request Error: " . $e->getMessage());
        return null;
    }
}