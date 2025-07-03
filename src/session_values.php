<?php
    $message['action_success_message'] = '';
    $message['action_error_message '] = '';
    $message['input_error_manufactureName'] = '';
    $message['input_error_carName'] = '';
    $message['input_error_price'] = '';
    $message['input_error_sizeLength'] = '';
    $message['input_error_sizeWidth'] = '';
    $message['input_error_sizeHeight'] = '';
    $message['input_error_engineType'] = '';
    $message['input_error_displacement'] = '';
    $message['input_error_fuelEconomy'] = '';
    $message['input_error_description'] = '';
    $message['input_pre_manufactureName'] = '';
    $message['input_pre_carName'] = '';
    $message['input_pre_price'] = '';
    $message['input_pre_sizeLength'] = '';
    $message['input_pre_sizeWidth'] = '';
    $message['input_pre_sizeHeight'] = '';
    $message['input_pre_engineType'] = '';
    $message['input_pre_displacement'] = '';
    $message['input_pre_fuelEconomy'] = '';
    $message['input_pre_Description'] = '';

    if (isset($_SESSION['action_success_message'])) {
        $message['action_success_message'] = $_SESSION['action_success_message'];
        unset($_SESSION['action_success_message']);
    }

    if (isset($_SESSION['action_error_message'])) {
        $message['action_error_message'] = $_SESSION['action_error_message'];
        unset($_SESSION['action_error_message']);
    }

    if (isset($_SESSION['input_error_manufactureName'])) {
        $message['input_error_manufactureName'] = $_SESSION['input_error_manufactureName'];
        unset($_SESSION['input_error_manufactureName']);
    }

    if (isset($_SESSION['input_error_carName'])) {
        $message['input_error_carName'] = $_SESSION['input_error_carName'];
        unset($_SESSION['input_error_carName']);
    }

    if (isset($_SESSION['input_error_price'])) {
        $message['input_error_price'] = $_SESSION['input_error_price'];
        unset($_SESSION['input_error_price']);
    }

    if (isset($_SESSION['input_error_sizeLength'])) {
        $message['input_error_sizeLength'] = $_SESSION['input_error_sizeLength'];
        unset($_SESSION['input_error_sizeLength']);
    }

    if (isset($_SESSION['input_error_sizeWidth'])) {
        $message['input_error_sizeWidth'] = $_SESSION['input_error_sizeWidth'];
        unset($_SESSION['input_error_sizeWidth']);
    }

    if (isset($_SESSION['input_error_sizeHeight'])) {
        $message['input_error_sizeHeight'] = $_SESSION['input_error_sizeHeight'];
        unset($_SESSION['input_error_sizeHeight']);
    }

    if (isset($_SESSION['input_error_engineType'])) {
        $message['input_error_engineType'] = $_SESSION['input_error_engineType'];
        unset($_SESSION['input_error_engineType']);
    }

    if (isset($_SESSION['input_error_displacement'])) {
        $message['input_error_displacement'] = $_SESSION['input_error_displacement'];
        unset($_SESSION['input_error_displacement']);
    }

    if (isset($_SESSION['input_error_fuelEconomy'])) {
        $message['input_error_fuelEconomy'] = $_SESSION['input_error_fuelEconomy'];
        unset($_SESSION['input_error_fuelEconomy']);
    }

    if (isset($_SESSION['input_error_description'])) {
        $message['input_error_description'] = $_SESSION['input_error_description'];
        unset($_SESSION['input_error_description']);
    }

    if (isset($_SESSION['input_pre_manufactureName'])) {
        $message['input_pre_manufactureName'] = $_SESSION['input_pre_manufactureName'];
        unset($_SESSION['input_pre_manufactureName']);
    }

    if (isset($_SESSION['input_pre_carName'])) {
        $message['input_pre_carName'] = $_SESSION['input_pre_carName'];
        unset($_SESSION['input_pre_carName']);
    }

    if (isset($_SESSION['input_pre_price'])) {
        $message['input_pre_price'] = $_SESSION['input_pre_price'];
        unset($_SESSION['input_pre_price']);
    }

    if (isset($_SESSION['input_pre_sizeLength'])) {
        $message['input_pre_sizeLength'] = $_SESSION['input_pre_sizeLength'];
        unset($_SESSION['input_pre_sizeLength']);
    }

    if (isset($_SESSION['input_pre_sizeWidth'])) {
        $message['input_pre_sizeWidth'] = $_SESSION['input_pre_sizeWidth'];
        unset($_SESSION['input_pre_sizeWidth']);
    }

    if (isset($_SESSION['input_pre_sizeHeight'])) {
        $message['input_pre_sizeHeight'] = $_SESSION['input_pre_sizeHeight'];
        unset($_SESSION['input_pre_sizeHeight']);
    }

    if (isset($_SESSION['input_pre_engineType'])) {
        $message['input_pre_engineType'] = $_SESSION['input_pre_engineType'];
        unset($_SESSION['input_pre_engineType']);
    }

    if (isset($_SESSION['input_pre_displacement'])) {
        $message['input_pre_displacement'] = $_SESSION['input_pre_displacement'];
        unset($_SESSION['input_pre_displacement']);
    }

    if (isset($_SESSION['input_pre_fuelEconomy'])) {
        $message['input_pre_fuelEconomy'] = $_SESSION['input_pre_fuelEconomy'];
        unset($_SESSION['input_pre_fuelEconomy']);
    }

    if (isset($_SESSION['input_pre_description'])) {
        $message['input_pre_description'] = $_SESSION['input_pre_description'];
        unset($_SESSION['input_pre_description']);
    }
?>