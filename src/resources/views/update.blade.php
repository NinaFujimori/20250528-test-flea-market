@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product.css')}}">
@endsection

@section('content')

<div class="update">
    <form action="/product/{{ $product->id }}/update" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="update__image">
            <input type="file" name="image" value="{{ $product->image }}">
            <p>
                @error('image')
                    {{ $message }}
                @enderror
            </p>
        </div>

        <div class="update__upper-text">
            <div>
                <h2>商品名</h2>
                <input type="text" name="name" placeholder="商品名を入力" value="{{$product->name}}">
                <p>
                    @error('name')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div>
                <h2>値段</h2>
                <input type="number" name="price" placeholder="値段を入力" value="  {{$product->price}}">
                <p>
                    @error('price')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div>
                <h2>季節</h2>
                @foreach($seasons as $season)
                <label>
                    <input type="checkbox" name="seasons[]" value="{{ $season->id }}"{{ $product->seasons->contains($season->id) ? 'checked' : '' }}>
                    {{$season -> season}}
                </label><br>
                @endforeach
                <p>
                    @error('seasons')
                        {{ $message }}
                    @enderror
                </p>
            </div>

        </div>
        <div class="update__lower-text">
            <div>
                <h2>商品説明</h2>
                <textarea name="description" placeholder="商品の説明を入力" >{{$product->description}}</textarea>
                @error('description')
                    {{ $message }}
                @enderror
            </div>

            <div>
                <div>
                    <a href="/product">戻る</a>
                    <input type="submit" value="変更を保存">
                </div>
            
            </div>
        </form>
        <form action="/product/{{ $product->id }}/delete" value="POST">
            @method('DELETE')
            @csrf
            <input type="submit" value="削除">
        </div>
        
    </form>

</div>

@endsection