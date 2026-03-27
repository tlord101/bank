<?php
require 'db.php'; // Database connection
require 'vendor/autoload.php'; // Include Pusher PHP SDK

$pusher = new Pusher\Pusher(
    getenv('PUSHER_APP_KEY'),
    getenv('PUSHER_APP_SECRET'),
    getenv('PUSHER_APP_ID'),
    ['cluster' => getenv('PUSHER_APP_CLUSTER')]
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Update courier's location in the database
    $stmt = $pdo->prepare("UPDATE couriers SET latitude = ?, longitude = ? WHERE id = ?");
    $stmt->execute([$latitude, $longitude, 1]); // Assuming 1 is the courier ID

    // Trigger Pusher event
    $pusher->trigger('courier-tracking', 'location-update', [
        'latitude' => $latitude,
        'longitude' => $longitude
    ]);

    echo json_encode(['status' => 'Location updated']);
}
