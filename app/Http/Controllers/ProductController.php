<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use stdClass;

class ProductController extends Controller
{
    // Список товаров
    public function index()
    {
        $product = Product::orderBy('id', 'desc')->paginate(10);
        return view('shop', ['product' => $product]);
    }

    // Добавить в корзину
    public function add_to_cart(Request $request)
    {
	    if (Auth::check()) {

		    Cart::restore(Auth::user()->id);
	    }
        $product = Product::find($request->id);
        if(!$product) abort(404);

        Cart::add($product->id, $product->title, 1, $product->price);

	    if (Auth::check()) {

		    Cart::store(Auth::user()->id);
	    }
        return Cart::content();
    }

    // Добавить в корзину
    public function remove_from_cart(Request $request)
    {
	    if (Auth::check()) {

		    Cart::restore(Auth::user()->id);
	    }
        Cart::remove($request->id);
	    if (Auth::check()) {

		    Cart::store(Auth::user()->id);
	    }

        return "OK";
    }

    // Изменить количество
    public function change_qty_in_cart(Request $request)
    {
	    if (Auth::check()) {

		    Cart::restore(Auth::user()->id);
	    }

        Cart::update($request->id, $request->qty);

	    if (Auth::check()) {

		    Cart::store(Auth::user()->id);
	    }
        return "OK";
    }

    // Отправить заказ
    public function send_order(Request $request)
    {
        if(Auth::check()) {

            // Сохраняем в профиль пользователя

            $user = new stdClass();
            $user->shipping_title = $request->shipping['title'] ?? "";
            $user->shipping_name = $request->shipping['name'] ?? "";
            $user->shipping_address1 = $request->shipping['address1'] ?? "";
            $user->shipping_address2 = $request->shipping['address2'] ?? "";
            $user->shipping_city = $request->shipping['city'] ?? "";
            $user->shipping_region = $request->shipping['region'] ?? "";
            $user->shipping_zip = $request->shipping['zip'] ?? "";
            $user->shipping_country = $request->shipping['country'] ?? "";
            $user->shipping_email = $request->shipping['email'] ?? "";
            if(Auth::user()){
                Auth::user()->payment_data = json_encode($user);
                Auth::user()->save();
            }

            // Сохраняем заказ
            $order = new Order;
            $order->user_id = Auth::user()->id;

            // Сохраняем корзину
            $cart = new stdClass();
            $cart_items = array();
            $total = 0;
            if(is_array($request->cart)){
                foreach($request->cart as $key => $item){
                    $product = Product::find($item["product_id"]);
                    $cart_items[$key] = [
                        "id" => $product->id,
                        "name" => $product->title,
                        "qty" => $item["qty"],
                        "price" => $product->price,
                    ];
                    $total = $total + ($product->price * $item["qty"]);
                }
            }else{
                $cart_items[] = [
                    "id" => "0",
                    "name" => "Refill",
                    "qty" => 1,
                    "price" => $request->cart,
                ];
                $total = $request->cart;
                $order->refill = 1;
            }
            $cart->cart_items = json_encode($cart_items);
            $cart->total = "$total";
            $order->pay = 0;
            $order->cart = json_encode($cart);

            // Сохраняем платежные реквизиты
            $order->payment_data = json_encode($user);
            $order->save();

            $result = app('App\Http\Controllers\PaymentController')->paypal($request->shipping, $cart, $order->id);
            $return = $result->getApprovalLink();


            return $return;

        }
        else {

            return "login";
        }

    }

    // Список товаров
    public function cart()
    {
	    if (Auth::check()) {
		    Cart::restore(Auth::user()->id);
            $user_id = User::select('payment_data')->where('id', Auth::user()->id)->get();
            $payment_data = json_decode($user_id[0]->payment_data);
	    } else {
            $payment_data = null;
        }



        if(Cart::content()){
            // Выводим результат

            $cart = array();
            $index = 0;
            foreach(Cart::content() as $key => $item){
                $index++;
                $cart['items'][] = array(
                    'id'         => $item->rowId,
                    'product_id' => $item->id,
                    'name'       => $item->name,
                    'qty'        => $item->qty,
                    'price'      => $item->price,
                );
            }
        }

        return view('cart', [
            'cart' => isset($cart) ? json_encode($cart) : json_encode(array()),
            'countrylist' => app('App\Http\Controllers\PaymentController')->countrylist(),
            'payment_data' => $payment_data,
        ]);
    }

    // Спасибо за покупку
    public function thank()
    {
        app('App\Http\Controllers\PaymentController')->check();

        Cart::restore(Auth::user()->id);
        // Очищаем корзину
        foreach(Cart::content() as $key => $item){
            Cart::remove($item->rowId);
        }

        Cart::store(Auth::user()->id);

        return view('thank');
    }

    // Платеж отменен
    public function cancel()
    {
        return view('cancel');
    }



}
