<?php
    function mbTrim($pString) {
        return preg_replace('/\A[\p{Cc}\p{Cf}\p{Z}]++|[\p{Cc}\p{Cf}\p{Z}]++\z/u', '', $pString);
    }

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: /');
    exit();
}

$errors = [];

// Manufacture Name
$manufactureName = '';
if (isset($_POST['manufactureName'])) {
    $manufactureName = mbTrim(str_replace("\r\n", "\n", $_POST['manufactureName']));
    if (empty($manufactureName) || mb_strlen($manufactureName) > 100) {
        $errors[] = 'メーカー名は1～100文字で入力してください。';
    }
} else {
    $errors[] = 'メーカー名が入力されていません。';
}

// Car Name
$carName = '';
if (isset($_POST['carName'])) {
    $carName = mbTrim(str_replace("\r\n", "\n", $_POST['carName']));
    if (empty($carName) || mb_strlen($carName) > 100) {
        $errors[] = '車種名は1～100文字で入力してください。';
    }
} else {
    $errors[] = '車種名が入力されていません。';
}

// price
$price = null;
if (isset($_POST['price'])) {
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    if ($price === false || $price <= 0 || $price > 99999999.99) {
        $errors[] = '価格は0より大きい数値で入力してください。';
        $price = null;
    }
} else {
    $errors[] = '価格が入力されていません。';
}


// engine_type
$engineType = null;
if (isset($_POST['engineType']) && $_POST['engineType'] !== '') {
    $engineType = mbTrim($_POST['engineType']);
    if (mb_strlen($engineType) > 50) {
        $errors[] = 'エンジンタイプは50文字以内で入力してください。';
        $engineType = null;
    }
}

// displacement
$displacement = null;
if (isset($_POST['displacement']) && $_POST['displacement'] !== '') {
    $displacement = filter_var($_POST['displacement'], FILTER_VALIDATE_FLOAT);
    if ($displacement === false || $displacement <= 0 || $displacement > 999.99) {
        $errors[] = '排気量は0より大きい数値で入力してください。';
        $displacement = null;
    }
}

// fuel_economy (燃費)
$fuelEconomy = null;
if (isset($_POST['fuelEconomy']) && $_POST['fuelEconomy'] !== '') {
    $fuelEconomy = filter_var($_POST['fuelEconomy'], FILTER_VALIDATE_FLOAT);
    if ($fuelEconomy === false || $fuelEconomy <= 0 || $fuelEconomy > 999.99) {
        $errors[] = '燃費は0より大きい数値で入力してください。';
        $fuelEconomy = null;
    }
}

// description
$description = null;
if (isset($_POST['description']) && $_POST['description'] !== '') {
    $description = mbTrim($_POST['description']);
    if (mb_strlen($description) > 65535) {
        $errors[] = '詳細説明が長すぎます。';
        $description = null;
    }
}

if (empty($errors)) {
    try {
        $query = 'INSERT INTO cars
                (manufactureName, carName, price, engineType, displacement, fuelEconomy, description)
                VALUES (:manufactureName, :carName, :price, :engineType, :displacement, :fuelEconomy, :description)';

        $stmt = $dbh->prepare($query);

        $stmt->bindValue(':manufactureName', $manufactureName, PDO::PARAM_STR);
        $stmt->bindValue(':carName', $carName, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR);
        $stmt->bindValue(':engineType', $engineType, PDO::PARAM_STR);
        $stmt->bindValue(':displacement', $displacement, PDO::PARAM_STR);
        $stmt->bindValue(':fuelEconomy', $fuelEconomy, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);

        $stmt->execute();

        $_SESSION['success_message'] = '車両情報が正常に登録されました。';
        header('Location: /');
        exit();

    } catch (PDOException $e) {
        error_log('データベース保存エラー: ' . $e->getMessage());
        $errors[] = '車両情報の保存中にエラーが発生しました。時間をおいて再度お試しください。';

        $_SESSION['form_errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header('Location: /');
        exit();
    }
} else {
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: /');
    exit();
}
?>