<?php

    if (isset($_POST['id']) && $_POST['id']) {
        $stmt = $dbh->prepare('DELETE FROM posts WHERE id = :id');
        $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION['action_success_message'] = '削除が完了しました';
        $_SESSION['action_error_message'] = '';
    } else {
        $_SESSION['action_success_message'] = '';
        $_SESSION['action_error_message'] = 'id がありません';
    }

    header('Location: /');
    exit();
?>