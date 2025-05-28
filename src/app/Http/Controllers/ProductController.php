<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Season;
use App\Models\ProductSeeder;

class ProductController extends Controller
{
    //商品一覧画面　表示
    public function index()
    {
        $products = Product::Paginate(6);
        return view('product',compact('products'));
    }
    
    //商品一覧画面　検索機能
    public function search(Request $request)
    {
        $query = Product::query();
        if(!empty($request->keyword)) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }
        if ($request->sort === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy('price', 'desc');
        }
        $products = $query->paginate(6)->appends($request->all());
        return view('product', compact('products'));
    }
    //商品一覧画面　並び替え機能
    public function sort(Request $request)
    {
        $query = Product::query();

        if (!empty($request->keyword)) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->sort === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy('price', 'desc');
        }

        $products = $query->paginate(6)->appends($request->all());

        return view('product', compact('products'));
    }
    

    //商品詳細画面　表示
    public function edit( $id){
        $product = Product::find($id);
        $seasons = Season::all();

        return view('update',[
            'product' => $product,
            'seasons' => $seasons
        ]);
    }

    //商品詳細画面　更新機能
    public function update(UpdateProductRequest $request, $id){
        $product = Product::findOrFail($id);

    // 画像アップロード処理（省略可）
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        $product->image = $imagePath;
    }

    // 商品情報の更新
    $product->name = $request->input('name');
    $product->price = $request->input('price');
    $product->description = $request->input('description');
    $product->save();

    // 中間テーブルの季節情報を更新
    $product->seasons()->sync($request->input('seasons'));

    return redirect('/product');
    }

    //商品詳細画面　削除機能　
    public function delete(Request $request,$id){
        Product::find($id)->delete();
        return redirect('/product');
    }


    // 商品登録画面　表示
    public function register(){
        $seasons = Season::all();
        return view('register',compact('seasons'));
    }

    // 商品登録画面　登録機能   
    public function store(StoreProductRequest $request){

        // 画像ファイルを保存
        $imagePath = $request->file('image')->store('images', 'public');

        // 商品登録
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        // 季節の紐付け
        $seasonIds = $request->input('seasons', []);
        $product->seasons()->sync($seasonIds);

        return redirect('/product');
    }

}
