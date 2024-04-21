<?php
    // DEFINE our cipher
    define('AES_256_CBC', 'aes-256-cbc');

    class Encryption 
    {
        public $key;
        public $iv;

        public function __construct($key, $iv)
        {
            // $this->deault_key = $key;
            // Generates a string of pseudo-random bytes, with the number of bytes determined by the length parameter.

            // It also indicates if a cryptographically strong algorithm was used to produce the pseudo-random bytes, and does this via the optional crypto_strong parameter. It's rare for this to be FALSE, but some systems may be broken or old.

            // @param int $length
            // The length of the desired string of bytes. Must be a positive integer. PHP will try to cast this parameter to a non-null integer to use it.
            // @param bool &$strong_result
            // [optional]
            // If passed into the function, this will hold a boolean value that determines if the algorithm used was "cryptographically strong", e.g., safe for usage with GPG, passwords, etc. true if it did, otherwise false
            // @return string|false
            // the generated string of bytes on success, or false on failure.
            // @link https://php.net/manual/en/function.openssl-random-pseudo-bytes.php
            // Generate a pseudo-random string of bytes

            // openssl_random_pseudo_bytes( int $length [, bool $crypto_strong ]): string

            // Generate a 256-bit encryption key
            // This should be stored somewhere instead of recreating it each time
            $this->key = $key;
            $this->iv = $iv;

        }

        function encryptData($data)
        {
            
            $array = array();
            if(!is_array($data)){
                $array = $this->encrypt($data);
            }else{

                foreach($data as $key => $value){
                    
                    if (is_array($value) || is_object($value)) {
                        // recall the encryptData() to loop through the array again
                        $array[$key] = $this->encryptData($value);
                    } else {
                        $array[$key] = $this->encrypt($value);
                        // $array[$key] = $value;
                    }
                }
            }
            return $array;
        }

        function encryptPayload($data) 
        {
            return $this->encrypt($data);
        }
        
        function encryptAPIData($data)
        {
            unset($data['username']);
            unset($data['id']);
            unset($data['email']);
            unset($data['firstname']);
            unset($data['lastname']);
            unset($data['role_id']);
            unset($data['balance']);
            unset($data['usage_channel']);
            
            $array = array();
            if(!is_array($data)){
                $array = $this->encrypt($data);
            }else{

                foreach($data as $key => $value){
                    
                    if (is_array($value) || is_object($value)) {
                        // recall the encryptData() to loop through the array again
                        $array[$key] = $this->encryptAPIData($value);
                    } else {
                        // $array[$key] = $this->encrypt($value);
                        $array[$key] = $value;
                    }
                }
            }
            return $array;
        }
        
        function decryptData($data)
        {
            
            $array = array();
            if(!is_array($data)){
                $array = $this->decrypt($data);
            }else{
                foreach($data as $key => $value){
                    if (is_array($value) || is_object($value)) {
                        $array[$key] = $this->decryptData($value);
                    } else {
                        $array[$key] = $this->decrypt($value);
                    }
                }
            }
            return $array;
        }

        function decryptPayload($payload) {
            $data = $payload . ':' . base64_encode($this->iv);
            $parts = explode(':', $data);
        
            // Attempt decryption and handle errors with OPENSSL_RAW_DATA
            $decryptedData = openssl_decrypt(base64_decode($parts[0]), 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, base64_decode($parts[1]));
        
            if ($decryptedData === false) {
                // Decryption failed, handle the error
                $error = openssl_error_string();
                return "Decryption Error: " . $error;
            }
        
            return $decryptedData;
        }        
        

        function decryptAPIData($data)
        {

            unset($data['username']);
            unset($data['id']);
            unset($data['email']);
            unset($data['firstname']);
            unset($data['lastname']);
            unset($data['role_id']);
            unset($data['balance']);
            unset($data['usage_channel']);
            
            $array = array();
            if(!is_array($data)){
                $array = $this->decrypt($data);
            }else{
                foreach($data as $key => $value){
                    if (is_array($value) || is_object($value)) {
                        $array[$key] = $this->decryptAPIData($value);
                    } else {
                        // $array[$key] = $this->decrypt($value);
                        $array[$key] = $value;
                    }
                }
            }
            return $array;
        }

        function encrypt($data)
        {   

            // Encrypt $data using aes-256-cbc cipher with the given encryption key and
            // our initialization vector. The 0 gives us the default options, but can
            // be changed to OPENSSL_RAW_DATA or OPENSSL_ZERO_PADDING
            
            return openssl_encrypt($data, AES_256_CBC, $this->key, 0, $this->iv);
        }

        function decrypt($data)
        {   
            // If we lose the $iv variable, we can't decrypt this, so:
            // - $data is already base64-encoded from openssl_encrypt
            // - Append a separator that we know won't exist in base64, ":"
            // - And then append a base64-encoded $iv
            $data = $data . ':' . base64_encode($this->iv);

            // To decrypt, separate the encrypted data from the initialization vector ($iv).
            $parts = explode(':', $data);
            // $parts[0] = encrypted data
            // $parts[1] = base-64 encoded initialization vector

            // Don't forget to base64-decode the $iv before feeding it back to
            //openssl_decrypt
            return openssl_decrypt($parts[0], AES_256_CBC, $this->key, 0, base64_decode($parts[1]));

        }
    }

?>