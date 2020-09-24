@extends('layouts/app')
@section('title', '商品一覧')
@section('content')
@if (Session::has('flash_message'))
    <div class="alert alert-success">
        {{session('flash_message')}}
    </div>
@endif
    <div class="container">
        <div class="row justify-conten-left">
            @foreach ($items as $item)
                <div class="col-md-4 md-2">
                    <div class="card">
                        <div class="card-header"><a href="/item/{{$item->id}}">{{$item->name}}</a></div>
                        <div class="card-body">
                            {{$item->amount}}円
                        </div>
                        {{-- @auth〜@endauthを使うことにより、ユーザーがログインしている時だけ表示される --}}
                        @auth
                            <form action="cartitem" method="post" class="form-inline m-1">
                                {{csrf_field()}}
                                <select name="quantity" class="form-contorl col-md-3 mr-1">
                                    <option selected>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                                    <input type="hidden" name="item_id" value="{{$item->id}}">
                                    <button type="submit" class="btn btn-primary col-md-6">カートに入れる</button>
                            </form>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row justify-content-center">
            {{-- Request::get('keyword')でクエリパラメータのkeywordの内容をビューから参照できる。 --}}
            {{$items->appends(['keyword' => Request::get('keyword')])->links()}}
        </div>
    </div>
@endsection