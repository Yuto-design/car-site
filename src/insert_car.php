<?php
    function mbTrim($pString) {
        return preg_replace('/\A[\p{Cc}\p{Cf}\p{Z}]++|[\p{Cc}\p{Cf}\p{Z}]++\z/u', '', $pString);
    }

    // Manufacture Name
    $is_valid_manufactureName = true;
    $input_manufactureName = '';
    if (isset($_POST['manufactureName'])) {
        $input_manufactureName = mbTrim(str_replace("\r\n", "\n", $_POST['manufactureName']));
        $_SESSION['input_pre_manufactureName'] = $_POST['manufactureName'];
    } else {
        $is_valid_manufactureName = false;
    }

    if ($is_valid_manufactureName && $input_manufactureName === '') {
        $is_valid_manufactureName = false;
        $_SESSION['input_error_manufactureName'] = 'メーカー名を入力してください。';
    }

    // Model
    $is_valid_model = true;
    $input_model = '';
    if (isset($_POST['model'])) {
        $input_model = mbTrim(str_replace("\r\n", "\n", $_POST['model']));
        $_SESSION['input_pre_model'] = $_POST['model'];
    } else {
        $is_valid_model = false;
    }

    if ($is_valid_model && $input_model === '') {
        $is_valid_model = false;
        $_SESSION['input_error_model'] = '車種名を入力してください。';
    }

    // Price
    $is_valid_price = true;
    $input_price = '';
    if (isset($_POST['price'])) {
        $input_price = mbTrim(str_replace("\r\n", "\n", $_POST['price']));
        $_SESSION['input_pre_price'] = $_POST['price'];
    } else {
        $is_valid_price = false;
    }

    if ($is_valid_price && $input_price === '') {
        $is_valid_price = false;
        $_SESSION['input_error_price'] = '価格を入力してください。';
    }

    // Size Length
    $is_valid_sizeLength = true;
    $input_sizeLength = '';
    if (isset($_POST['sizeLength'])) {
        $input_sizeLength = mbTrim(str_replace("\r\n", "\n", $_POST['sizeLength']));
        $_SESSION['input_pre_sizeLength'] = $_POST['sizeLength'];
    } else {
        $is_valid_sizeLength = false;
    }

    if ($is_valid_sizeLength && $input_sizeLength === '') {
        $is_valid_sizeLength = false;
        $_SESSION['input_error_sizeLength'] = '全長を入力してください。';
    }

    // Size Width
    $is_valid_sizeWidth = true;
    $input_sizeWidth = '';
    if (isset($_POST['sizeWidth'])) {
        $input_sizeWidth = mbTrim(str_replace("\r\n", "\n", $_POST['sizeWidth']));
        $_SESSION['input_pre_sizeWidth'] = $_POST['sizeWidth'];
    } else {
        $is_valid_sizeWidth = false;
    }

    if ($is_valid_sizeWidth && $input_sizeWidth === '') {
        $is_valid_sizeWidth = false;
        $_SESSION['input_error_sizeWidth'] = '全幅を入力してください。';
    }


    // Size Height
    $is_valid_sizeHeight = true;
    $input_sizeHeight = '';
    if (isset($_POST['sizeHeight'])) {
        $input_sizeHeight = mbTrim(str_replace("\r\n", "\n", $_POST['sizeHeight']));
        $_SESSION['input_pre_sizeHeight'] = $_POST['sizeHeight'];
    } else {
        $is_valid_sizeHeight = false;
    }

    if ($is_valid_sizeHeight && $input_sizeHeight === '') {
        $is_valid_sizeHeight = false;
        $_SESSION['input_error_sizeHeight'] = '全高を入力してください。';
    }


    // Engine_type
    $is_valid_engineType = true;
    $input_engineType = '';
    if (isset($_POST['engineType'])) {
        $input_engineType = mbTrim(str_replace("\r\n", "\n", $_POST['engineType']));
        $_SESSION['input_pre_engineType'] = $_POST['engineType'];
    } else {
        $is_valid_engineType = false;
    }

    if ($is_valid_engineType && mb_strlen($input_engineType) > 30) {
        $is_valid_engineType = false;
        $_SESSION['input_error_engineType'] = 'エンジンは30文字以内で入力してください。（現在 ' . mb_strlen($input_carName) . ' 文字）';
    }

    // Displacement
    $is_valid_displacement = true;
    $input_displacement = '';
    if (isset($_POST['displacement'])) {
        $input_displacement = mbTrim(str_replace("\r\n", "\n", $_POST['displacement']));
        $_SESSION['input_pre_displacement'] = $_POST['displacement'];
    } else {
        $is_valid_displacement = false;
    }

    if ($is_valid_displacement && mb_strlen($input_displacement) > 10) {
        $is_valid_displacement = false;
        $_SESSION['input_error_displacement'] = '排気量は10桁以内で入力してください。';
    }

    // Fuel_economy
    $is_valid_fuelEconomy = true;
    $input_fuelEconomy = '';
    if (isset($_POST['fuelEconomy'])) {
        $input_fuelEconomy = mbTrim(str_replace("\r\n", "\n", $_POST['fuelEconomy']));
        $_SESSION['input_pre_fuelEconomy'] = $_POST['fuelEconomy'];
    } else {
        $is_valid_fuelEconomy = false;
    }

    if ($is_valid_fuelEconomy && mb_strlen($input_fuelEconomy) > 10) {
        $is_valid_fuelEconomy = false;
        $_SESSION['input_error_fuelEconomy'] = '燃費は10桁以内で入力してください。';
    }

    // Description
    $is_valid_description = true;
    $input_description = '';
    if (isset($_POST['description'])) {
        $input_description = mbTrim(str_replace("\r\n", "\n", $_POST['description']));
        $_SESSION['input_pre_description'] = $_POST['description'];
    } else {
        $is_valid_description = false;
    }

    if ($is_valid_description && mb_strlen($input_description) > 255) {
        $is_valid_description = false;
        $_SESSION['input_error_description'] = '詳細255文字以内で入力してください。';
    }

    // HP
    $is_valid_hp = true;
    $input_hp = '';
    if (isset($_POST['hp'])) {
        $input_hp = mbTrim(str_replace("\r\n", "\n", $_POST['hp']));
        $_SESSION['input_pre_hp'] = $_POST['hp'];
    } else {
        $is_valid_hp = false;
    }

    if ($is_valid_hp && mb_strlen($input_hp) > 255) {
        $is_valid_hp = false;
        $_SESSION['input_error_hp'] = '詳細255文字以内で入力してください。';
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
        $file_name = uniqid('car_', true) . '.' . $file_ext;
        $target_path = $upload_dir . $file_name;

        move_uploaded_file($file_tmp, $target_path);
        $carImage = 'uploads/' . $file_name;
    }

    if ($is_valid_manufactureName && $is_valid_model && $is_valid_price &&
        $is_valid_sizeLength && $is_valid_sizeWidth && $is_valid_sizeHeight) {
            $query = 'INSERT INTO cars
                        (manufactureName, model, price, sizeLength, sizeWidth, sizeHeight, engineType, displacement, fuelEconomy, hp, description, carImage)
                        VALUES (:manufactureName, :model, :price, :sizeLength, :sizeWidth, :sizeHeight, :engineType, :displacement, :fuelEconomy, :hp, :description, :carImage)';

            $stmt = $dbh->prepare($query);

            $stmt->bindValue(':manufactureName', $input_manufactureName, PDO::PARAM_STR);
            $stmt->bindValue(':model', $input_model, PDO::PARAM_STR);
            $stmt->bindValue(':price', $input_price === '' ? null : (int)$input_price, PDO::PARAM_INT);
            $stmt->bindValue(':sizeLength', $input_sizeLength === '' ? null : (int)$input_sizeLength, PDO::PARAM_INT);
            $stmt->bindValue(':sizeWidth', $input_sizeWidth === '' ? null : (int)$input_sizeWidth, PDO::PARAM_INT);
            $stmt->bindValue(':sizeHeight', $input_sizeHeight === '' ? null : (int)$input_sizeHeight, PDO::PARAM_INT);
            $stmt->bindValue(':engineType', $input_engineType, PDO::PARAM_STR);
            $stmt->bindValue(':displacement', $input_displacement === '' ? null : (int)$input_displacement, PDO::PARAM_INT);
            $stmt->bindValue(':fuelEconomy', $input_fuelEconomy === '' ? null : (int)$input_fuelEconomy, PDO::PARAM_INT);
            $stmt->bindValue(':description', $input_description, PDO::PARAM_STR);
            $stmt->bindValue(':hp', $input_hp, PDO::PARAM_STR);
            $stmt->bindValue(':carImage', $carImage, PDO::PARAM_STR);

            $stmt->execute();

            $_SESSION['action_error_message'] = '';
            $_SESSION['input_error_manufactureName'] = '';
            $_SESSION['input_error_model'] = '';
            $_SESSION['input_error_price'] = '';
            $_SESSION['input_error_sizeLength'] = '';
            $_SESSION['input_error_sizeWidth'] = '';
            $_SESSION['input_error_sizeHeight'] = '';
            $_SESSION['input_error_engineType'] = '';
            $_SESSION['input_error_displacement'] = '';
            $_SESSION['input_error_fuelEconomy'] = '';
            $_SESSION['input_error_description'] = '';
            $_SESSION['input_error_hp'] = '';
            $_SESSION['input_pre_manufactureName'] = '';
            $_SESSION['input_pre_model'] = '';
            $_SESSION['input_pre_price'] = '';
            $_SESSION['input_pre_sizeLength'] = '';
            $_SESSION['input_pre_sizeWidth'] = '';
            $_SESSION['input_pre_sizeHeight'] = '';
            $_SESSION['input_pre_engineType'] = '';
            $_SESSION['input_pre_displacement'] = '';
            $_SESSION['input_pre_fuelEconomy'] = '';
            $_SESSION['input_pre_description'] = '';
            $_SESSION['input_pre_hp'] = '';
    }

    header('Location: /');
    exit();
?>