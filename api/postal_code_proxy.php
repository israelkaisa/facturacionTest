<?php
header("Content-Type: application/json");

// Check if the postal code is provided
if (!isset($_GET['cp']) || empty($_GET['cp'])) {
    http_response_code(400); // This is a client error, so 400 is appropriate.
    echo json_encode(['status' => 'error', 'message' => 'Postal code (cp) is required.']);
    exit();
}

$postal_code = trim($_GET['cp']);

// Basic validation for a 5-digit postal code
if (!preg_match('/^[0-9]{5}$/', $postal_code)) {
    http_response_code(400); // This is a client error, so 400 is appropriate.
    echo json_encode(['status' => 'error', 'message' => 'Invalid postal code format.']);
    exit();
}

$api_url = "https://codigos-postales-mx.herokuapp.com/api/codigos-postales/" . urlencode($postal_code);

// Use file_get_contents with error handling
$context = stream_context_create(['http' => ['ignore_errors' => true]]);
$response = file_get_contents($api_url, false, $context);

// Check the raw HTTP response headers to see if the external API returned a 404
$is_external_404 = false;
if (isset($http_response_header)) {
    foreach ($http_response_header as $header) {
        if (strpos($header, 'HTTP/1.1 404') !== false) {
            $is_external_404 = true;
            break;
        }
    }
}

if ($response === false || $is_external_404) {
    // The external lookup failed, but our proxy script worked. Return 200 OK with an error status.
    echo json_encode(['status' => 'error', 'message' => 'No se encontraron datos para este código postal.']);
    exit();
}

// The external API seems to wrap its actual response in an outer array.
// We will just pass it through, but inside our own structured response.
$data = json_decode($response);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500); // This is a server-side parsing error.
    echo json_encode(['status' => 'error', 'message' => 'Failed to parse JSON response from the external API.']);
    exit();
}

// Forward the successful response, wrapped in our own status object
echo json_encode(['status' => 'success', 'data' => $data]);
?>
