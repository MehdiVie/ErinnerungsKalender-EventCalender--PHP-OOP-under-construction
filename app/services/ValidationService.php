<?php

class ValidationService {

    public function validateEmail(string $email) {
        return filter_var($email , FILTER_VALIDATE_EMAIL) !== false;
    }

    public function validatePassword(string $password) {
        return strlen($password) >= 6;
    }

    public function validateNotEmpty(string $value) {
        return trim($value) !== '';
    }
}