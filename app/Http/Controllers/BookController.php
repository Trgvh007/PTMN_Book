<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
 use App\Models\Category;
 use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    //
    function laythongtintheloai()
    {
    $the_loai_sach = Category::all();
    return view("qlysach.the_loai",compact("the_loai_sach"));
    }

    function laythongtinsach()
    {
    $sach = Book::where("nha_xuat_ban","Văn Học")
    ->where("gia_ban", ">", 70000)->get();
   return view("qlysach.thong_tin_sach",compact("sach"));        
   }

   function themtheloai(){
    return view("qlysach.themdl");
   }

   function luudulieu (Request $request) {
    $id = $request->input("id");
    $tentl = $request->input("ten_the_loai");
    foreach ($id as $index => $id) {
        $data = [
            "id" => $id,
            "ten_the_loai" => $tentl[$index]
        ];
        DB::table("the_loai")->insert($data);
    }
    return "Thêm dữ liệu thành công";
   }

   public function cartadd(Request $request)
   {
   $request->validate([
   "id"=>["required","numeric"],
   "num"=>["required","numeric"]
   ]);
 
   $id = $request->id;
   $num = $request->num;
   $total = 0;
   $cart = [];
   if(session()->has('cart'))
   {
   $cart = session()->get("cart");
   if(isset($cart[$id]))
   $cart[$id] += $num;
   else
   $cart[$id] = $num ;
   }
   else
   {
   $cart[$id] = $num ;
   }
   session()->put("cart",$cart);
   return count($cart);
}

}
