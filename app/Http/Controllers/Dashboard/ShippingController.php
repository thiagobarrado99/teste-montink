<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Coupon;
use App\Models\ShippingRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingController
{
/**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ShippingRule::all();
        return view('dashboard.shipping.index', compact("data"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $shipping_rule = new ShippingRule($request->input());        
        if($shipping_rule->save())
        {
            toast('Regra de envio criada com sucesso!', 'success');
            return to_route("shipping.index");
        }

        toast('Confira todos os campos e tente novamente!', 'error');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shipping_rule = ShippingRule::find($id);
        if($shipping_rule->delete())
        {
            toast('Regra de envio deletada com sucesso!', 'success');
        }else{
            toast('Houve um erro deletando a regra de envio!', 'error');
        }
        return back();
    }
}
