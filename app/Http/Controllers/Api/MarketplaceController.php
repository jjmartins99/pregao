<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function products()
    {
        return response()->json(['message' => 'Products endpoint']);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Product details', 'id' => $id]);
    }

    public function categories()
    {
        return response()->json(['message' => 'Categories endpoint']);
    }

    public function stores()
    {
        return response()->json(['message' => 'Stores endpoint']);
    }
}