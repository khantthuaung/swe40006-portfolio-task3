<?php
$temperature = '';
$direction = 'c_to_f';
$result = null;
$error = '';

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $temperature = is_string($_POST['temperature'] ?? null)
        ? trim($_POST['temperature']) : '';

    $direction = is_string($_POST['direction'] ?? null)
        ? $_POST['direction'] : '';

    if ($temperature === '' || !is_numeric($temperature)) {
        $error = 'Enter a valid numeric temperature.';
    } elseif (!in_array($direction, ['c_to_f', 'f_to_c'], true)) {
        $error = 'Select a valid conversion direction.';
    } else {
        $value = (float) $temperature;
        $converted = $direction === 'c_to_f'
            ? ($value * 9 / 5) + 32
            : ($value - 32) * 5 / 9;

        if (!is_finite($value) || !is_finite($converted)) {
            $error = 'That number is too large. Enter a smaller value.';
        } else {
            $from = $direction === 'c_to_f' ? '°C' : '°F';
            $to = $direction === 'c_to_f' ? '°F' : '°C';
            $result = number_format($value, 2) . " $from = "
                . number_format($converted, 2) . " $to";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Temperature Converter</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: #f3f6fa;
            color: #172033;
            font-family: Arial, sans-serif;
        }
        main {
            max-width: 580px;
            margin: 70px auto;
            padding: 28px;
        }
        form {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 18px #17203312;
        }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #aab4c4;
            border-radius: 6px;
            font: inherit;
        }
        button, .reset {
            display: inline-block;
            padding: 12px 18px;
            border-radius: 6px;
            font: inherit;
        }
        button {
            border: 0;
            background: #185adb;
            color: white;
            cursor: pointer;
        }
        .reset { color: #185adb; }
        .result, .error { padding: 18px; border-radius: 8px; }
        .result { background: #d9f3e5; color: #14532d; }
        .error { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
<main>
    <h1>Temperature Converter</h1>
    <p>Convert between Celsius and Fahrenheit using PHP.</p>

    <form method="post">
        <label for="temperature">Temperature</label>
        <input id="temperature" name="temperature"
               type="number" step="any" required
               value="<?= escape($temperature) ?>"
               placeholder="For example, 25">

        <label for="direction">Conversion direction</label>
        <select id="direction" name="direction">
            <option value="c_to_f"
                <?= $direction === 'c_to_f' ? 'selected' : '' ?>>
                Celsius to Fahrenheit
            </option>
            <option value="f_to_c"
                <?= $direction === 'f_to_c' ? 'selected' : '' ?>>
                Fahrenheit to Celsius
            </option>
        </select>

        <button type="submit">Convert</button>
        <a class="reset" href="./">Reset</a>
    </form>

    <?php if ($error !== ''): ?>
        <p class="error" role="alert"><?= escape($error) ?></p>
    <?php endif; ?>

    <?php if ($result !== null): ?>
        <p class="result" role="status">
            <strong><?= escape($result) ?></strong>
        </p>
    <?php endif; ?>
</main>
</body>
</html>