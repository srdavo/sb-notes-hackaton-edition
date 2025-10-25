<?php
    class Token {
        public static function createToken($length = 32) {
            $token = bin2hex(random_bytes($length / 2)); // Genera la mitad en bytes
            return $token;
        }        
    }