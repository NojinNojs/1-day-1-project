<?php
function format_number($number) {
    return number_format($number, 2, ',', '.');
}

function get_exchange_rates() {
    $cache_dir = __DIR__ . '/../cache';
    if (!file_exists($cache_dir)) {
        mkdir($cache_dir, 0777, true);
    }

    // Check if cache exists and is valid
    if (file_exists(CACHE_FILE) && (time() - filemtime(CACHE_FILE) < CACHE_EXPIRY)) {
        $cached_data = json_decode(file_get_contents(CACHE_FILE), true);
        if (isset($cached_data['rates']) && is_array($cached_data['rates'])) {
            return $cached_data['rates'];
        }
    }

    // Fetch new data from API
    $rates = fetch_exchange_rates();
    if ($rates) {
        $data_to_cache = [
            'rates' => $rates,
            'last_update' => date('Y-m-d H:i:s')
        ];
        file_put_contents(CACHE_FILE, json_encode($data_to_cache));
        return $rates;
    }

    // If everything fails, return default rates
    return [
        'USD' => 1,
        'EUR' => 0.85,
        'GBP' => 0.73,
        'JPY' => 110.0,
        'IDR' => 14500,
        'SGD' => 1.35,
        'MYR' => 4.2,
        'THB' => 33.0
    ];
}

function get_last_update_time() {
    if (file_exists(CACHE_FILE)) {
        $cached_data = json_decode(file_get_contents(CACHE_FILE), true);
        return isset($cached_data['last_update']) ? $cached_data['last_update'] : date('Y-m-d H:i:s');
    }
    return date('Y-m-d H:i:s');
}

function convert_currency($amount, $from, $to) {
    $rates = get_exchange_rates();
    if (!isset($rates[$from]) || !isset($rates[$to])) {
        return false;
    }

    $rate = $rates[$to] / $rates[$from];
    return $amount * $rate;
}