<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
    protected function validateFileUpload($file, $rules = [])
{
    $defaultRules = [
        'file' => 'required|file|max:10240', // 10MB max
        'mimes' => 'jpg,jpeg,png,pdf,doc,docx',
        'mimetypes' => 'image/jpeg,image/png,application/pdf,application/msword',
    ];
    
    $rules = array_merge($defaultRules, $rules);
    
    return validator(['file' => $file], $rules)->validate();
}
}
