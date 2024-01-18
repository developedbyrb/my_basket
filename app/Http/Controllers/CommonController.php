<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function getAddressFields()
    {
        $returnHTML = view('layouts.common.address-fields')->render();
        $response = [
            'success' => true,
            'data' => [
                'html' => $returnHTML,
            ],
            'message' => 'Address fields fetched successfully.',
        ];

        return response($response);
    }
}
