<?php

function register()
{
    if (isset($_POST['register'])) {
        //validation

        //csrf
        if (!is_csrf_valid()) {
            global $message;
            $message['error'] = 'خطای امنیتی رخ داده است.';
        }
    }
}