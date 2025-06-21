<?php
    function mbTrim($pString) {
        return preg_replace('/\A[\p{Cc}\p{Cf}\p{Z}]++|[\p{Cc}\p{Cf}\p{Z}]++\z/u', '', $pString);
    }

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // POST以外からのアクセスは不正とみなし、リダイレクト
    header('Location: /');
    exit();
}

$errors = [];

// Manufacture Name
$make = '';
if (isset($_POST['make'])) {
    $make = mbTrim(str_replace("\r\n", "\n", $_POST['make']));
    if (empty($make) || mb_strlen($make) > 100) {
        $errors[] = 'メーカー名は1～100文字で入力してください。';
    }
} else {
    $errors[] = 'メーカー名が入力されていません。';
}

// model
$model = '';
if (isset($_POST['model'])) {
    $model = mbTrim(str_replace("\r\n", "\n", $_POST['model']));
    if (empty($model) || mb_strlen($model) > 100) {
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
$engine_type = null;
if (isset($_POST['engine_type']) && $_POST['engine_type'] !== '') {
    $engine_type = mbTrim($_POST['engine_type']);
    if (mb_strlen($engine_type) > 50) {
        $errors[] = 'エンジンタイプは50文字以内で入力してください。';
        $engine_type = null;
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
$fuel_economy = null;
if (isset($_POST['fuel_economy']) && $_POST['fuel_economy'] !== '') {
    $fuel_economy = filter_var($_POST['fuel_economy'], FILTER_VALIDATE_FLOAT);
    if ($fuel_economy === false || $fuel_economy <= 0 || $fuel_economy > 999.99) {
        $errors[] = '燃費は0より大きい数値で入力してください。';
        $fuel_economy = null;
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

// image_path (画像パス)
$image_path = 'images/default_car.jpg';

if (empty($errors)) {
    $query = 'INSERT INTO cars
            (make, model, year, price, engine_type, displacement, fuel_economy, description, image_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

    $stmt = $conn->prepare($query);

    $stmt->bind_param(
        "ssidsddss",
        $make,
        $model,
        $year,
        $price,
        $engine_type,
        $displacement,
        $fuel_economy,
        $description,
        $image_path
    );

    if ($stmt->execute()) {
        header('Location: brand_cars.php?brand=' . urlencode($make));
        exit();
    } else {
        $errors[] = 'データベースへの保存に失敗しました: ' . $stmt->error;
        $_SESSION['form_errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header('Location: add_car.php');
        exit();
    }
    $stmt->close();
} else {
    session_start();
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: add_car.php');
    exit();
}

$conn->close();

?>