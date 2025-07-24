<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController
{
    public function index()
    {
        $products = Product::with(["inventory", "products.inventory"])->where(["product_id" => null])->get();
        return view("index.index", compact("products"));
    }

    public function login()
    {
        return Auth::check() ? to_route('dashboard') : view('index.login');
    }

    public function doLogin(Request $request)
    {
        if(Auth::attempt(['email' => $request->post("email"), 'password' => $request->post("password")], true))
        {
            toast('Bem vindo de volta '.Auth::user()->name, 'success');
            return to_route('dashboard');
        }
        return back()->withErrors(['email' => 'Usuário ou senha inválidos.']);
    }
}
