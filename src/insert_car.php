<?php
    require_once(__DIR__ . '/../src/db_connect.php');

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

    // Model
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
    $price = '';
    if (isset($_POST['price']) && $_POST['price'] !== '') {
        if (is_numeric($_POST['price'])) {
            $price = (float)$_POST['price'];
            if ($price <= 0 || $price > 99999999.99) {
                $errors[] = '価格は0より大きく、99999999.99以下の数値で入力してください。';
            }
        } else {
            $errors[] = '価格は有効な数値で入力してください。';
        }
    } else {
        $errors[] = '価格が入力されていません。';
    }

    // Size Length
    $sizeLength = '';
    if (isset($_POST['sizeLength']) && $_POST['sizeLength'] !== '') {
        if (is_numeric($_POST['sizeLength'])) {
            $sizeLength = (float)$_POST['sizeLength'];
            if ($sizeLength <= 0 || $sizeLength > 99999999.99) {
                $errors[] = '全長は0より大きく、99999999.99以下の数値で入力してください。';
            }
        } else {
            $errors[] = '全長は有効な数値で入力してください。';
        }
    } else {
        $errors[] = '全長が入力されていません。';
    }

    // Size Width
    $sizeWidth = '';
    if (isset($_POST['sizeWidth']) && $_POST['sizeWidth'] !== '') {
        if (is_numeric($_POST['sizeWidth'])) {
            $sizeWidth = (float)$_POST['sizeWidth'];
            if ($sizeWidth <= 0 || $sizeWidth > 99999999.99) {
                $errors[] = '全幅は0より大きく、99999999.99以下の数値で入力してください。';
            }
        } else {
            $errors[] = '全幅は有効な数値で入力してください。';
        }
    } else {
        $errors[] = '全幅が入力されていません。';
    }

    // Size Height
    $sizeHeight = '';
    if (isset($_POST['sizeHeight']) && $_POST['sizeHeight'] !== '') {
        if (is_numeric($_POST['sizeHeight'])) {
            $sizeHeight = (float)$_POST['sizeHeight'];
            if ($sizeHeight <= 0 || $sizeHeight > 99999999.99) {
                $errors[] = '全高は0より大きく、99999999.99以下の数値で入力してください。';
            }
        } else {
            $errors[] = '全高は有効な数値で入力してください。';
        }
    } else {
        $errors[] = '全高が入力されていません。';
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
        if (is_numeric($_POST['displacement'])) {
            $displacement = (float)$_POST['displacement'];
            if ($displacement <= 0 || $displacement > 9999.99) {
                $errors[] = '排気量は0より大きく、9999.99以下の数値で入力してください。';
                $displacement = null;
            }
        } else {
            $errors[] = '排気量は有効な数値で入力してください。';
        }
    }

    // fuel_economy
    $fuelEconomy = null;
    if (isset($_POST['fuelEconomy']) && $_POST['fuelEconomy'] !== '') {
        if (is_numeric($_POST['fuelEconomy'])) {
            $fuelEconomy = (float)$_POST['fuelEconomy'];
            if ($fuelEconomy <= 0 || $fuelEconomy > 999.99) {
                $errors[] = '燃費は0より大きく、999.99以下の数値で入力してください。';
                $fuelEconomy = null;
            }
        } else {
            $errors[] = '燃費は有効な数値で入力してください。';
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

    // HP
    $hp = null;
    if (isset($_POST['hp']) && $_POST['hp'] !== '') {
        $hp = mbTrim($_POST['hp']);
        if (!filter_var($hp, FILTER_VALIDATE_URL) || mb_strlen($hp) > 255) {
            $errors[] = 'HPのURLは有効な形式で255文字以内で入力してください。';
            $hp = null;
        }
    }

    // Car Image
    $carImage = null;
    if (isset($_FILES['carImage']) && $_FILES['carImage']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../public/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_tmp = $_FILES['carImage']['tmp_name'];
        $file_ext = strtolower(pathinfo($_FILES['carImage']['name'], PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($file_ext, $allowed_exts)) {
            $file_name = uniqid('car_', true) . '.' . $file_ext;
            $target_path = $upload_dir . $file_name;

            if (move_uploaded_file($file_tmp, $target_path)) {
                $carImage = 'uploads/' . $file_name;
            } else {
                $errors[] = '画像のアップロードに失敗しました。';
            }
        } else {
            $errors[] = '許可されていないファイル形式です。jpg, png, gif, webpのみアップロード可能です。';
        }
    }

    if (empty($errors)) {
        try {
            $query = 'INSERT INTO cars
                        (manufactureName, carName, price, sizeLength, sizeWidth, sizeHeight, engineType, displacement, fuelEconomy, hp, description, carImage)
                        VALUES (:manufactureName, :carName, :price, :sizeLength, :sizeWidth, :sizeHeight, :engineType, :displacement, :fuelEconomy, :hp, :description, :carImage)';

            $stmt = $dbh->prepare($query);

            $stmt->bindValue(':manufactureName', $manufactureName, PDO::PARAM_STR);
            $stmt->bindValue(':carName', $carName, PDO::PARAM_STR);
            $stmt->bindValue(':price', $price, PDO::PARAM_STR);
            $stmt->bindValue(':sizeLength', $sizeLength, PDO::PARAM_STR);
            $stmt->bindValue(':sizeWidth', $sizeWidth, PDO::PARAM_STR);
            $stmt->bindValue(':sizeHeight', $sizeHeight, PDO::PARAM_STR);
            $stmt->bindValue(':engineType', $engineType, PDO::PARAM_STR);
            $stmt->bindValue(':displacement', $displacement, PDO::PARAM_STR);
            $stmt->bindValue(':fuelEconomy', $fuelEconomy, PDO::PARAM_STR);
            $stmt->bindValue(':description', $description, PDO::PARAM_STR);
            $stmt->bindValue(':hp', $hp, PDO::PARAM_STR);
            $stmt->bindValue(':carImage', $carImage, PDO::PARAM_STR);

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