<?php

class SecureEncrypt {
    private const CIPHER_METHOD = 'aes-256-gcm';
    private string $encryptionKey;

    /**
     * La clave se procesa para obtener exactamente 32 bytes usando hash SHA-256.
     * Esto permite usar claves de cualquier longitud de forma segura.
     */
    public function __construct(string $encryptionKey) {
        // Usar hash SHA-256 para obtener exactamente 32 bytes
        $this->encryptionKey = hash('sha256', $encryptionKey, true);
    }

    public function encrypt(string $plaintext): ?string {
        if (empty($plaintext)) {
            return null;
        }

        // El IV para GCM debe ser de 12 bytes
        $iv = openssl_random_pseudo_bytes(12);
        
        // GCM genera una "etiqueta de autenticación" que es crucial para la seguridad.
        $tag = ''; // Se pasará por referencia a openssl_encrypt

        $ciphertext = openssl_encrypt(
            $plaintext,
            self::CIPHER_METHOD,
            $this->encryptionKey,
            OPENSSL_RAW_DATA,
            $iv,
            $tag, // La etiqueta de autenticación se llena aquí
            '',
            16 // La longitud de la etiqueta
        );

        if ($ciphertext === false) {
            return null; // Falló la encriptación
        }

        // Juntamos todo: IV + Etiqueta + Texto Cifrado, y lo codificamos en Base64
        return base64_encode($iv . $tag . $ciphertext);
    }

    public function decrypt(string $ciphertext_base64): ?string {
        if (empty($ciphertext_base64)) {
            return null;
        }

        $decoded = base64_decode($ciphertext_base64, true);
        if ($decoded === false) {
            return null; // No es un Base64 válido
        }

        // Extraemos las partes en el orden en que las guardamos
        $iv = mb_substr($decoded, 0, 12, '8bit');
        $tag = mb_substr($decoded, 12, 16, '8bit');
        $ciphertext = mb_substr($decoded, 28, null, '8bit');
        
        $plaintext = openssl_decrypt(
            $ciphertext,
            self::CIPHER_METHOD,
            $this->encryptionKey,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        return $plaintext !== false ? $plaintext : null; // Si la desencriptación falla, retorna null
    }
}

?>