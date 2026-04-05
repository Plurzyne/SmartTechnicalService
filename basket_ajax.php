<?php
session_start();

// Session səbət yoxdursa boş array
if (!isset($_SESSION['basket'])) $_SESSION['basket'] = [];

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {

    // Məhsulu əlavə et
    case 'add':
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];

        if (isset($_SESSION['basket'][$id])) {
            $_SESSION['basket'][$id]['qty']++;
        } else {
            $_SESSION['basket'][$id] = ['id' => $id, 'name' => $name, 'price' => $price, 'qty' => 1];
        }
        break;

    // Məhsulu sil
    case 'remove':
        $id = $_POST['id'];
        unset($_SESSION['basket'][$id]);
        break;

    // Say artır/azalt
    case 'update':
        $id = $_POST['id'];
        $qtyChange = intval($_POST['qtyChange']);
        if (isset($_SESSION['basket'][$id])) {
            $_SESSION['basket'][$id]['qty'] += $qtyChange;
            if ($_SESSION['basket'][$id]['qty'] < 1) {
                unset($_SESSION['basket'][$id]);
            }
        }
        break;

    // Səbəti JSON şəklində qaytar
    case 'view':
        header('Content-Type: application/json');
        echo json_encode(array_values($_SESSION['basket']));
        exit;
}
