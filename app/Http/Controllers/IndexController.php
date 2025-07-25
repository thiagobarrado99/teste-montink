<?php

namespace App\Http\Controllers;

use App\Mail\OrderFinishedMail;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingRule;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    public function cart()
    {
        $cart = session('cart', []);
        $ids = array_keys($cart);
        $products = Product::with("product")->whereIn('id', $ids)->orderBy("id", "ASC")->get();
        return view("index.cart", compact("cart", "products"));
    }

    public function shipping()
    {
        return view("index.shipping");
    }

    public function finishOrder(Request $request)
    {
        $cart = session('cart', []);
        if(count($cart) <= 0)
        {
            toast('Seu carrinho está vazio!', 'error');
            return to_route('index');
        }

        //Create order
        DB::beginTransaction();
        try{
            $client = Client::where(["email" => $request->input("email")])->first();
            if(!$client)
            {
                $client = new Client($request->only(["name", "tax_id", "email", "phone", "zipcode", "state", "city", "neighborhood", "address", "number"]));
                if(!$client->save())
                {
                    throw new \Exception("Failed to create client.");
                }
            }
            
            $order = new Order([
                "client_id" => $client->id,
                "status" => Order::STATUS_PENDING,
                "total" => 0
            ]);
            if(!$order->save())
            {
                throw new \Exception("Failed to create order.");
            }

            $total = 0;
            foreach($cart as $id => $data)
            {
                $product = Product::with("product")->where(["id" => $id])->first();
                $quantity = $data["quantity"];

                $order->orderTotals()->create([
                    "product_id" => $id,
                    "description" => $quantity."x ".($product->product ? $product->product->name.">".$product->name : $product->name),
                    "total" => round($product->price * $quantity, 2)
                ]);
                $product->inventory->decrease($quantity);
                $total += round($product->price * $quantity, 2);
            }

            $shipping_rules = ShippingRule::all();
            $shipping_cost = $shipping_rules[0]->price;

            foreach($shipping_rules as $rule)
            {
                switch($rule->type)
                {
                    case "0": default:
                        if($total <= $rule->range_start)
                        {
                            $shipping_cost = $rule->price;
                            continue 2;
                        }
                        break;
                    case "1":
                        if($total >= $rule->range_start)
                        {
                            $shipping_cost = $rule->price;
                            continue 2;
                        }
                        break;
                    case "2":
                        if($total >= $rule->range_start && $total <= $rule->end)
                        {
                            $shipping_cost = $rule->price;
                            continue 2;
                        }
                        break;
                }
            }
            $total += $shipping_cost;
            
            $order->orderTotals()->create([
                "description" => "Frete",
                "total" => round($shipping_cost, 2)
            ]);

            $order->total = $total;
            $order->save();

            DB::commit();

            //Envia o email para o log 
            Mail::to($client->email)->send(new OrderFinishedMail($client));

            session(["cart" => array()]);
            alert('Pedido finalizado!', 'Seu pedido foi criado com sucesso! Atualizações de rastreamento serão enviadas para o email cadastrado.', 'success');
            return to_route("index");
        }catch(\Throwable $e){ 
            dd($e);
        }

        DB::rollBack();
        toast('Confira todos os campos e tente novamente.', 'error');
        return back();
    }

    public function cep($cep)
    {
        return response()->json(json_decode(file_get_contents("https://viacep.com.br/ws/".$cep."/json/")));
    }

    public function productInfo(string $id)
    {
        $product = Product::with(["inventory", "products.inventory"])->where(["id" => $id])->first();
        if($product)
        {
            return response()->json($product);
        }
        return response()->json([], 400);
    }

    public function productAdd(string $id)
    {
        //Add product and return new cart
        $cart = session('cart', []);
        $product = Product::with(["inventory", "product"])->where(["id" => $id])->first();
        if($product && $product->inventory->quantity > 0)
        {
            if(isset($cart[$id]))
            {
                $cart[$id]["quantity"] = $cart[$id]["quantity"]+1;
                if($cart[$id]["quantity"] > $product->inventory->quantity)
                {
                    return response()->json(["message" => "Product stock limited."], 400);
                }
            }else{
                $cart[$id] = array();
                $cart[$id]["name"] = ($product->product ? $product->product->name . ">".$product->name : $product->name);
                $cart[$id]["quantity"] = 1;
            }
            ksort($cart);
            session(['cart' => $cart]);
            return response()->json(array_values($cart));
        }
        return response()->json(["message" => "Product not found or out of stock."], 400);
    }

    public function productRemove(string $id)
    {
        //Add product and return new cart
        $cart = session('cart', []);
        if(isset($cart[$id]))
        {
            unset($cart[$id]);
        }
        session(['cart' => $cart]);
        toast('Produto removido com sucesso!', 'success');
        return back();
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
