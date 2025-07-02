<?php
    $_SESSION['action_success_message'] = '';
    $_SESSION['action_error_message '] = '';
    $_SESSION['input_error_manufactureName'] = '';
    $_SESSION['input_error_carName'] = '';
    $_SESSION['input_error_price'] = '';
    $_SESSION['input_error_sizeLength'] = '';
    $_SESSION['input_error_sizeWidth'] = '';
    $_SESSION['input_error_sizeHeight'] = '';
    $_SESSION['input_error_engineType'] = '';
    $_SESSION['input_error_displacement'] = '';
    $_SESSION['input_error_fuelEconomy'] = '';
    $_SESSION['input_error_Description'] = '';
    $_SESSION['input_pre_manufactureName'] = '';
    $_SESSION['input_pre_carName'] = '';
    $_SESSION['input_pre_price'] = '';
    $_SESSION['input_pre_sizeLength'] = '';
    $_SESSION['input_pre_sizeWidth'] = '';
    $_SESSION['input_pre_sizeHeight'] = '';
    $_SESSION['input_pre_engineType'] = '';
    $_SESSION['input_pre_displacement'] = '';
    $_SESSION['input_pre_fuelEconomy'] = '';
    $_SESSION['input_pre_Description'] = '';

    if (isset($_SESSION['form_errors'])) {
        $form_errors = $_SESSION['form_errors'];
        unset($_SESSION['form_errors']);
    }

    if (isset($_SESSION['form_data'])) {
        $form_old_data = $_SESSION['form_data'];
        unset($_SESSION['form_data']);
    }

    if (isset($_SESSION['add_car_success'])) {
        $form_success_message = $_SESSION['add_car_success'];
        unset($_SESSION['add_car_success']);
    }
?>