<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/api.php';

$rates = get_exchange_rates();
$currencies = is_array($rates) ? array_keys($rates) : ['USD', 'EUR', 'GBP', 'JPY', 'IDR'];
$last_update = get_last_update_time();

// Inisialisasi variabel
$amount = null;
$from = 'USD';
$to = 'IDR';
$result = null;
$error_message = null;

// Hanya proses jika ada POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $amount = isset($_POST['amount']) ? str_replace(['.', ','], ['', '.'], $_POST['amount']) : null;
        $from = isset($_POST['from']) ? $_POST['from'] : 'USD';
        $to = isset($_POST['to']) ? $_POST['to'] : 'IDR';

        if ($amount !== null) {
            $result = convert_currency((float) $amount, $from, $to);
            if ($result === false) {
                $error_message = "Unable to convert between selected currencies";
            }
        }
    } catch (Exception $e) {
        $error_message = "An error occurred during conversion";
        error_log($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Currency Converter</h1>
        <p class="text-center text-muted mb-4">Last updated: <?= $last_update ?></p>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post" id="converter-form">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount"
                            value="<?= $amount ? format_number($amount) : '' ?>" placeholder="Enter amount" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="from" class="form-label">From</label>
                            <select class="form-select" id="from" name="from">
                                <?php foreach ($currencies as $currency): ?>
                                    <option value="<?= $currency ?>" <?= $currency === $from ? 'selected' : '' ?>>
                                        <?= $currency ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="to" class="form-label">To</label>
                            <select class="form-select" id="to" name="to">
                                <?php foreach ($currencies as $currency): ?>
                                    <option value="<?= $currency ?>" <?= $currency === $to ? 'selected' : '' ?>>
                                        <?= $currency ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Convert</button>
                </form>

                <?php if ($result !== null): ?>
                    <div class="mt-4 alert alert-success">
                        <?= format_number($amount) ?>     <?= $from ?> = <?= format_number($result) ?>     <?= $to ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Conversions -->
        <div class="row mt-5">
            <h2 class="text-center mb-4">Common Conversions</h2>
            <?php
            $base_currencies = ['USD', 'EUR', 'GBP'];
            $target_currencies = ['IDR'];

            foreach ($base_currencies as $base):
                foreach ($target_currencies as $target):
                    $quick_result = convert_currency(1, $base, $target);
                    ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= $base ?> to <?= $target ?></h5>
                                <p class="card-text">1 <?= $base ?> = <?= format_number($quick_result) ?>         <?= $target ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
            endforeach;
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('amount').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\./g, '').replace(/,/g, '.');
            if (!isNaN(value)) {
                let parts = value.split('.');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                e.target.value = parts.join(',');
            }
        });
    </script>
</body>

</html>