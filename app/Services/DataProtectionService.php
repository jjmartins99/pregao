<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class DataProtectionService
{
    public static function encryptPersonalData($data)
    {
        return Crypt::encrypt($data);
    }
    
    public static function decryptPersonalData($encryptedData)
    {
        return Crypt::decrypt($encryptedData);
    }
    
    public static function anonymizeData($data)
    {
        // Para dados que não precisam ser recuperados
        return hash('sha256', $data . config('app.key'));
    }
    
    public static function maskEmail($email)
    {
        $parts = explode('@', $email);
        $username = $parts[0];
        $domain = $parts[1];
        
        $maskedUsername = substr($username, 0, 2) . str_repeat('*', strlen($username) - 2);
        
        return $maskedUsername . '@' . $domain;
    }
}