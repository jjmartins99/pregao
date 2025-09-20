<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class DataValidationService
{
    public static function validateCreditCard($data)
    {
        return Validator::make($data, [
            'number' => 'required|credit_card',
            'expiry' => 'required|date_format:m/y|after:today',
            'cvv' => 'required|digits_between:3,4',
            'name' => 'required|string|max:255',
        ]);
    }
    
    public static function validatePersonalData($data)
    {
        return Validator::make($data, [
            'nif' => 'required|size:9|regex:/^[0-9]{9}$/',
            'phone' => 'required|regex:/^[9][0-9]{8}$/',
            'email' => 'required|email|max:255',
        ]);
    }
    
    public static function sanitizeInput($input)
    {
        if (is_array($input)) {
            return array_map([self::class, 'sanitizeInput'], $input);
        }
        
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }
}