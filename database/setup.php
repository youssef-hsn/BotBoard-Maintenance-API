<?php
$envFile = __DIR__ . '/.env';
$lockFile = __DIR__ . '/setup.lock';

if (file_exists($lockFile)) {
    foreach (file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        putenv(trim($line));
    }
    echo "test: " . getenv('DB_HOST');
    die("Setup has already been completed. To reconfigure, delete 'setup.lock' and rerun the script.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = $_POST['DB_HOST'] ?? '';
    $dbName = $_POST['DB_NAME'] ?? '';
    $dbUser = $_POST['DB_USER'] ?? '';
    $dbPass = $_POST['DB_PASS'] ?? '';

    if (empty($dbHost) || empty($dbName) || empty($dbUser)) {
        echo "All fields except DB_PASS are required!";
    } else {
        $envContent = "DB_HOST=$dbHost\nDB_NAME=$dbName\nDB_USER=$dbUser\nDB_PASS=$dbPass";

        if (file_put_contents($envFile, $envContent)) {
            file_put_contents($lockFile, "Setup completed on " . date('Y-m-d H:i:s'));

            foreach (file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                putenv(trim($line));
            }

            echo "Setup completed successfully! The environment variables have been saved.";
        } else {
            echo "Error writing to .env file. Check file permissions.";
        }
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Environment Variables</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        form {
            max-width: 400px;
            margin: auto;
        }
        label {
            font-weight: bold;
        }
        input {
            display: block;
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Setup Environment Variables</h1>
    <form method="POST">
        <label for="DB_HOST">Database Host (DB_HOST):</label>
        <input type="text" id="DB_HOST" name="DB_HOST" required>

        <label for="DB_NAME">Database Name (DB_NAME):</label>
        <input type="text" id="DB_NAME" name="DB_NAME" required>

        <label for="DB_USER">Database User (DB_USER):</label>
        <input type="text" id="DB_USER" name="DB_USER" required>

        <label for="DB_PASS">Database Password (DB_PASS):</label>
        <input type="password" id="DB_PASS" name="DB_PASS">

        <button type="submit">Save Environment Variables</button>
    </form>
</body>
</html>