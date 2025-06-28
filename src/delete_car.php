<?php
    require_once(__DIR__ . '/db_connect.php');

    if (!isset($_POST['car_id']) || !is_numeric($_POST['car_id'])) {
        $_SESSION['form_errors'][] = '無効なIDです。';
        return;
    }

    $carId = (int) $_POST['car_id'];

    try {
        $stmt = $dbh->prepare('SELECT carImage FROM cars WHERE id = ?');
        $stmt->execute([$carId]);
        $car = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($car && !empty($car['carImage']) && file_exists(__DIR__ . '/../' . $car['carImage'])) {
            unlink(__DIR__ . '/../' . $car['carImage']);
        }

        $stmt = $dbh->prepare('DELETE FROM cars WHERE id = ?');
        $stmt->execute([$carId]);

        $_SESSION['success_message'] = '車両情報を削除しました。';
    } catch (Exception $e) {
        $_SESSION['form_errors'][] = '削除に失敗しました：' . $e->getMessage();
}
