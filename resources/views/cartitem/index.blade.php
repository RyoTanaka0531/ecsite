@extends('layouts.app')

@section('title', 'カート内')

@section('content')
@if (Session::has('flash_message'))
    <div class="alert alert-success">
        {{session('flash_message')}}
    </div>
@endif

{{-- @isset($cartitems) --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @foreach ($cartitems as $cartitem)
                        <div class="card-header">
                            <a href="/item/{{$cartitem->item_id}}">{{$cartitem->name}}</a>
                        </div>
                        <div class="card-body">
                            <div>
                                {{$cartitem->amount}}円
                            </div>
                            <div class="form-inline">
                                <form action="/cartitem/{{$cartitem->id}}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <input type="text" name="quantity" value="{{$cartitem->quantity}}" class="form-control">個
                                    <button type="submit" class="btn btn-primary">更新</button>
                                </form>
                                <form method="POST" action="/cartitem/{{ $cartitem->id }}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-primary ml-1">カートから削除する</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        小計
                    </div>
                    <div class="card-body">
                        {{$subtotal}}円
                    </div>
                    <div>
                        @if (isset($cartitem))
                            <a  class="btn btn-primary" href="/buy" role="button" style="margin-left: 10px;">
                                レジに進む
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- @else
    <h4 style="text-align: center">カート内に商品がありません</h4>
@endif --}}
@endsection