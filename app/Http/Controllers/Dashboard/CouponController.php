<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController
{
/**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Coupon::all();
        return view("dashboard.coupons.index", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.coupons.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $coupon = new Coupon($request->input());        
        if($coupon->save())
        {
            toast('Cupom criado com sucesso!', 'success');
            return to_route("coupons.index");
        }

        toast('Confira todos os campos e tente novamente!', 'error');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::find($id);
        return view("dashboard.coupons.edit", compact("coupon"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $coupon = Coupon::find($id);
        $coupon->fill($request->except(["user_id", "created_at", "updated_at"]));
        
        if($coupon->save())
        {
            toast('Cupom editado com sucesso!', 'success');
            return to_route("coupons.index");
        }

        toast('Confira todos os campos e tente novamente!', 'error');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::find($id);
        if($coupon->delete())
        {
            toast('Cupom deletado com sucesso!', 'success');
        }else{
            toast('Houve um erro deletando o cupom!', 'error');
        }
        return back();
    }
}
