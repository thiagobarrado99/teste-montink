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
        $data = Product::with(["inventory", "products.inventory"])->where(["id" => $id])->first();
        if($data)
        {
            return response()->json($data);
        }
        return response()->json([], 404);
    }

    public function history(string $id)
    {
        $data = Product::with(["inventory", "products.inventory"])->where(["id" => $id])->first();
        return view('dashboard.products.history', compact("data"));
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->fill($request->only(["name", "price"]));
        if($product->save())
        {
            $product->products()->update(['price' => $product->price]);
            toast('Produto editado com sucesso!', 'success');
        }else{
            toast('Houve um erro editando o produto!', 'error');
        }
        return back();
    }

    public function massUpdate(Request $request)
    {
        DB::beginTransaction();
        try{
            $data = $request->input("products");
            if($data && is_array($data))
            {
                foreach($data as $key => $value)
                {
                    $product = Product::with("inventory")->where(["id" => $key])->first();
                    $product->update(["name" => $value["name"]]);
                    
                    $diff = $value["quantity"] - $product->inventory->quantity;
                    if($diff != 0)
                    {
                        $product->inventory->inventoryHistory()->create([
                            "quantity" => $diff,
                            "description" => "Alteração de estoque manual"
                        ]);
                    }

                    $product->inventory->update(["quantity" => $value["quantity"]]);
                }
                DB::commit();
                toast('Estoque alterado com sucesso!', 'success');
                return to_route("products.index");
            }else{
                throw new \Exception("Dados invalidos.");
            }
        }catch(\Throwable $e){ 
            toast('Tente novamente: ' . $e->getMessage(), 'error');
        }

        DB::rollBack();
        return back();
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
