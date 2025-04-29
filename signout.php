<?php
session_start();

if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
}
?>