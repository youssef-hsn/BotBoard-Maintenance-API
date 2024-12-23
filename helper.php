<?php
function jsonErrorResponse(int $code, string $message, array $details = []) {
    http_response_code($code);
    echo json_encode([
        "error" => [
            "code" => $code,
            "message" => $message,
            "details" => $details
        ]
    ]);
    exit;
}
?>