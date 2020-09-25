<?php

namespace App\Http\Controllers;

use App\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //リレーションを定義し、データベースからcartitemsを取得する方法に書き換える


        //「name」や「amount」など検索結果で取得したいカラムを指定
        $cartitems = CartItem::select('cart_items.*', 'items.name', 'items.amount')
                //ログイン中のユーザーのユーザーIDをキーにしてカート内の商品を検索している。
                ->where('user_id', Auth::id())
                //joinメソッドでcart_itemsテーブルとitemsテーブルを結合
                //cart_itemsテーブルは商品ID(cart_items.item_id)しか持っていないので、cart_items.item_idをキーにしてitemsテーブルから商品名と価格を取得できるようにしている
                //join()で内部結合する。第一引数で結合したいテーブル名。第2引数、第4引数で結合したいカラム。第3引数で比較演算子（基本的には「=」でOK）
                ->join('items', 'items.id', '=', 'cart_items.item_id')
                ->get();

        $subtotal = 0;
        foreach($cartitems as $cartitem){
            $subtotal += $cartitem->amount * $cartitem->quantity;
        }
        return view('cartitem/index', ['cartitems' => $cartitems, 'subtotal' => $subtotal]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        CartItem::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'item_id' => $request->post('item_id'),
            ],
            [
                'quantity' => \DB::raw('quantity +'. $request->post('quantity')),
            ]
            );
            return redirect('/')->with('flash_message', 'カートに追加しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    //更新する元となるカート情報と、更新する数量を受け取るためのリクエスト情報を受け取る
    public function update(Request $request, CartItem $cartItem)
    {
        //
        $cartItem->quantity = $request->post('quantity');
        $cartItem->save();
        return redirect('cartitem')->with('flash_message', 'カートを更新しました');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItem $cartItem)
    {
        //
        $cartItem->delete();
        return redirect('cartitem')->with('flash_message', 'カートから削除しました');
    }
}
