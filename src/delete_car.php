<?php

    if (isset($_POST['car_id']) && $_POST['car_id']) {
        $id = (int)$_POST['car_id'];

        $stmt = $dbh->prepare('SELECT carImage FROM cars WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $stmt = $dbh->prepare('DELETE FROM cars WHERE id = :id');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if (!empty($row['carImage'])) {
                $imagePath = __DIR__ . '/../public/' . $row['carImage'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }
    }

    header('Location: /');
    exit();
?>