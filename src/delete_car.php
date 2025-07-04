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

            $_SESSION['action_success_message'] = '削除が完了しました';
            $_SESSION['action_error_message'] = '';
        } else {
            $_SESSION['action_success_message'] = '';
            $_SESSION['action_error_message'] = '対象の投稿が見つかりませんでした';
        }
    } else {
        $_SESSION['action_success_message'] = '';
        $_SESSION['action_error_message'] = 'id がありません';
    }

    header('Location: /');
    exit();
?>