<?php

namespace App\Http\Controllers;

use App\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\Buy;
use Illuminate\Support\Facades\Mail;

class BuyController extends Controller
{
    //
    public function index()
    {
        $cartitems = CartItem::select('cart_items.*', 'items.name', 'items.amount')
                ->where('user_id', Auth::id())
                ->join('items', 'items.id', '=', 'cart_items.item_id')
                ->get();
        
        $subtotal = 0;
        foreach($cartitems as $cartitem){
            $subtotal += $cartitem->amount * $cartitem->quantity;
        }
        return view('buy/index', ['cartitems' => $cartitems]);

    }

    public function store(Request $request)
    {
        //リクエストパラメータにpostという値が含まれていれば注文を確定する処理
        //postが含まれていなければもう一度購入画面を表示して、ビュー側で入力確認の表示を切り替える
        if($request->has('post')){
            //MailクラスとBuyクラスを使ってメールを送信する
            //Auth::user()->emailでログイン中のユーザーのメールアドレスを取得
            Mail::to(Auth::user()->email)->send(new Buy());
            //ユーザーが持っているカート情報を削除し、同じ注文を何度も行わないようにする
            CartItem::where('user_id', Auth::id())->delete();
            return view('buy/complete');
        }
        //「修正する」が押された場合の処理
        //入力した内容を編集できるようにするためフォームのリクエスト情報をセッションに記録
        //これにより、確認画面でセッション情報を取り出して入力内容を表示できる
        $request->flash();
        return $this->index();
    }
}
