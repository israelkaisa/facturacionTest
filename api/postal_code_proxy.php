<?php
header("Content-Type: application/json");

// Check if the postal code is provided
if (!isset($_GET['cp']) || empty($_GET['cp'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Postal code (cp) is required.']);
    exit();
}

$postal_code = trim($_GET['cp']);

// Basic validation for a 5-digit postal code
if (!preg_match('/^[0-9]{5}$/', $postal_code)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid postal code format.']);
    exit();
}

$api_url = "https://codigos-postales-mx.herokuapp.com/api/codigos-postales/" . urlencode($postal_code);

// Use file_get_contents with error handling
// The '@' suppresses warnings from file_get_contents on failure, allowing us to handle the error manually
$response = @file_get_contents($api_url);

if ($response === false) {
    // This could be a 404 from the external API or a network issue
    http_response_code(404);
    echo json_encode(['error' => 'Could not retrieve data for the given postal code from the external API.']);
    exit();
}

// The external API seems to wrap its actual response in an outer array.
// We will just pass it through.
// If the response is not valid JSON, json_decode will return null.
$data = json_decode($response);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to parse JSON response from the external API.']);
    exit();
}

// Forward the response to the client
echo $response;
?>
