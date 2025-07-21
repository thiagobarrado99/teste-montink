<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Client;

class ClientController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Client::all();
        return view("dashboard.clients.index", compact("data"));
    }
}
