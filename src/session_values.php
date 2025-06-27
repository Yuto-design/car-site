<?php
    $form_errors = [];
    $form_old_data = [];
    $form_success_message = '';

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