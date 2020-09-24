@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center" style="margin-bottom:10px;">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        お届け先入力
                    </div>
                    <div class="card-body">
                        <form action="/buy" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">氏名</label>
                                    @if (Request::has('confirm'))
                                        <p class="form-control-static">{{old('name')}}</p>
                                        <input type="hidden" name="name" id="name" value="{{old('name')}}">
                                    @else
                                        <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control">
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="postalcode">郵便番号</label>
                                    @if (Request::has('confirm'))
                                        <p class="form-control-static">{{old('postalcode')}}</p>
                                        <input type="hidden" name="postalcode" id="postalcode" value="{{old('postalcode')}}">
                                    @else
                                        <input type="text" name="postalcode" id="postalcode" value="{{old('postalcode')}}" class="form-control">
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="region">都道府県</label>
                                    @if (Request::has('confirm'))
                                        <p class="form-control-static">{{old('region')}}</p>
                                        <input type="hidden" name="region" id="region" value="{{old('region')}}">
                                    @else
                                        <select name="region" id="region" class="form-control">
                                            {{--Config::get('region')でconfig/region.phpの内容を読み込んでいる --}}
                                            @foreach (Config::get('region') as $value)
                                            {{-- @if(old('region') == $value) selected @endif でセッションに残っている都道府県をselectedにして選択状態にしています。 --}}
                                                <option @if(old('region') == $value) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="form-group col-md-6">
                                    <label for="addressline1">住所1</label>
                                    @if (Request::has('confirm'))
                                        <p class="form-control-static">{{old('addressline1')}}</p>
                                        <input type="hidden" name="addressline1" id="addressline1" value="{{old('addressline1')}}">
                                    @else
                                        <input type="text" name="addressline1" id="addressline1" value="{{old('addressline1')}}" class="form-control">
                                    @endif
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="form-group col-md-6">
                                    <label for="addressline2">住所2</label>
                                    @if (Request::has('confirm'))
                                        <p class="form-control-static">{{old('addressline2')}}</p>
                                        <input type="hidden" name="addressline2" id="addressline2" value="{{old('addressline2')}}">
                                    @else
                                        <input type="text" name="addressline2" id="addressline2" value="{{old('addressline2')}}" class="form-control">
                                    @endif
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="form-group col-md-6">
                                    <label for="phonenumber">電話番号</label>
                                    @if (Request::has('confirm'))
                                        <p class="form-control-static">{{old('phonenumber')}}</p>
                                        <input type="hidden" name="phonenumber" id="phonenumber" value="{{old('phonenumber')}}">
                                    @else
                                        <input type="text" name="phonenumber" id="phonenumber" value="{{old('phonenumber')}}" class="form-control">
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    @if (Request::has('confirm'))
                                        <button type="submit" class="btn btn-primary" name="post">注文を確定する</button>
                                        <button type="submit" class="btn btn-default" name="back">修正する</button>
                                    @else
                                        <button type="submit" class="btn btn-primary" name="confirm">入力内容を確認する</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @foreach ($cartitems as $cartitem)
                        <div class="card-header">
                            {{$cartitem->name}}
                        </div>
                        <div class="card-body">
                            <div>
                                {{$cartitem->amount}}円
                            </div>
                            <div>
                                {{$cartitem->quantity}}個
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection