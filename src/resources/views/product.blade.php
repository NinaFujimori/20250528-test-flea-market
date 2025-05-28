<style>
    svg.w-5.h-5 {
    /*paginateメソッドの矢印の大きさ調整のために追加*/
    width: 30px;
    height: 30px;
  }
</style>

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product.css')}}">
@endsection

@section('content')

<div class="product__main">
    <div class="product__upper">
        <div class="product__upper-text">
            <h2 class="product__upper-text--title">商品一覧</h2>
            <div class="product__upper-text--register">
                <a href="/product/register">+商品を追加</a>
            </div>
        </div>
    </div>

    <!--サイドバーの内容-->
    <div class="product__side">

        <!--検索-->
        <div>
            <form action="/search" method="GET">
                @csrf
                <input type="text" placeholder="商品名で検索" name="keyword" value="{{request('keyword')}}">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <div>
                    <input type="submit" value="検索">
                </div>
            </form>
        </div>

        <!--並び替え-->
        <div>
            <h3>価格順で表示</h3>
            <form action="/sort" method="GET">
                @csrf
                @if(request('keyword'))
                    <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                @endif
                <select name="sort" onchange="this.form.submit()">
                    <option value="" disabled {{ request('sort') == null ? 'selected' : '' }}>価格で並び替え</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>高い順に表示</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>低い順に表示</option>
                </select>
            </form>
            @if(request('sort') === 'asc' || request('sort') === 'desc')
                <form action="/product" method="GET" style="margin-top: 10px;">
                    @if(request('keyword'))
                        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                    @endif
                    <button type="submit">
                        × {{ request('sort') === 'asc' ? '低い順' : '高い順' }} を解除
                    </button>
                </form>
            @endif 
        </div>

    </div>

    <!--商品一覧-->
    <div class="product__fruit">   
        <div class="product__fruit-group">
        @foreach($products as $product)
            <div class="product__fruit--card">
                <label for="product">
                <a href="{{ route('product.edit', ['id' => $product->id]) }}">
                    <img src="{{ asset( $product->image ) }}" alt="fruit">
                    <div class="product__fruit--text">
                        <p>{{$product -> name}}</p>
                        <p>{{$product -> price}}</p>
                    </div>
                </a>
                </label>
            </div>
        @endforeach
        </div>  
        {{ $products -> links() }}
    </div>

</div>

@endsection