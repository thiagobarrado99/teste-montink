<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::with("products.inventory")->where(["product_id" => null])->get();
        return view("dashboard.products.index", compact("data"));
    }

    /**
     * Display a single resource.
     */
    public function show(string $id)
    {
        $data = Product::with("products.inventory")->where(["id" => $id])->first();
        if($data)
        {
            return response()->json($data);
        }
        return response()->json([], 404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.products.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $product = new Product($request->only(["name", "price"]));
            if($product->save())
            {
                $variation_array = $request->input("variations");
                if($variation_array && is_array($variation_array))
                {
                    //Product with variations, skip inventory entry
                    foreach($variation_array as $variation)
                    {
                        $productVariation = $product->products()->create([
                            "name" => $variation["name"],
                            "price" => $product->price,
                        ]);

                        $productVariation->inventory()->create([
                            "quantity" => $variation["quantity"]
                        ]);
                    }
                }else{
                    //Simple product, create inventory entry
                    $product->inventory()->create([
                        "quantity" => $request->input("quantity")
                    ]);
                }

                DB::commit();
                toast('Produto criado com sucesso!', 'success');
                return to_route("products.index");
            }
        }catch(\Throwable $e){ 
            toast('Tente novamente: ' . $e->getMessage(), 'error');
        }

        DB::rollBack();
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if($product->delete())
        {
            toast('Produto deletado com sucesso!', 'success');
        }else{
            toast('Houve um erro deletando o produto!', 'error');
        }
        return back();
    }
}
