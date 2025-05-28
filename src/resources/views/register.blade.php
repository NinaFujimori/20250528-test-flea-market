@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css')}}">
@endsection

@section('content')

<div class="register">
    <div class="register__main">
        <h2>商品登録</h2>
        <form action="/product/add" method="post" enctype="multipart/form-data">
        @csrf
            <div>
                <div class="register__text">
                    <p>商品名</p>
                    <div class="register__text--required-back">
                        <p>必須</p>
                    </div>
                </div>
                <input type="text" name ="name" placeholder="商品名を入力" value="{{ old('name') }}">
                <p class="register__error">
                    @error('name')
                        {{ $message }}
                    @enderror
                <p>
            </div>

            <div>
                <div class="register__text">
                    <p>値段</p>
                    <div class="register__text--required-back">
                        <p>必須</p>
                    </div>
                </div>
                <input type="number" name="price" placeholder="値段を入力" min="0" step="1" value="{{ old('price') }}">
                <p class="register__error">
                    @error('price')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div>
                <div class="register__text">
                    <p> 商品画像</p>
                    <div class="register__text--required-back">
                        <p>必須</p>
                    </div>
                </div>
                <input type="file" name="image" >
                <p class="register__error">
                    @error('image')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div>
                <div class="register__text">
                    <p>季節</p>
                    <div class="register__text--required-back">
                        <p>必須</p>
                    </div>
                    <p>複数選択可</p>
                </div>
                <div class="register__seasons">
                @foreach($seasons as $season)
                    <label>
                        <input type="checkbox" name="seasons[]" value="{{ $season->id }}"   {{ is_array(old('seasons')) && in_array($season->id, old('seasons')) ? 'checked' : '' }}>
                        {{$season -> season}}
                    </label><br>
                @endforeach
                </div>
                    <p class="register__error">
                        @error('seasons')
                            {{ $message }}
                        @enderror
                    </p>
            </div>

            <div>
                <div class="register__text">
                    <p>商品説明</p>
                    <div class="register__text--required-back">
                        <p>必須</p>
                    </div>
                </div>
                <textarea type="text" name="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
                <p class="register__error">
                    @error('description')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div>
                <div>
                    <a href="/product">戻る</a>
                </div>
                <div>
                    <input type="submit" value="登録">
                </div>
            </div>
        </form>
    </div>
</div>

@endsection