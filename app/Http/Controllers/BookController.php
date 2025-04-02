<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
 use App\Models\Category;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Support\Facades\Auth;

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

   //////////////
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
////////////
public function order()
{
$cart=[];
$data =[];
$quantity = [];
$list_book = "";
if(session()->has('cart'))
{
$cart = session("cart");

foreach($cart as $id=>$value)
{
$quantity[$id] = $value;
$list_book .=$id.", ";
}
}
if (!empty($list_book)) {
$list_book = substr($list_book, 0,strlen($list_book)-2);
$data = DB::table("sach")->whereRaw("id in (".$list_book.")")->get();
} else {
    $data = []; // Giỏ hàng rỗng, tránh lỗi SQL
}

return view("vidusach.order",compact("quantity","data"));
}

/////////////
public function cartdelete(Request $request)
{
$request->validate([
"id"=>["required","numeric"]
]);
$id = $request->id;
$total = 0;
$cart = [];
if(session()->has('cart'))
{
$cart = session()->get("cart");
unset($cart[$id]);
}
session()->put("cart",$cart);
return redirect()->route('order');
}

//Ham ordercreate
public function ordercreate(Request $request)
{
$request->validate([
"hinh_thuc_thanh_toan"=>["required","numeric"]
]);
$data = [];
$quantity = [];
if(session()->has('cart'))
{
$order = ["ngay_dat_hang"=>DB::raw("now()"),"tinh_trang"=>1,
"hinh_thuc_thanh_toan"=>$request->hinh_thuc_thanh_toan,
"user_id"=>Auth::user()->id];
DB::transaction(function () use ($order) {
$id_don_hang = DB::table("don_hang")->insertGetId($order);
$cart = session("cart");
$list_book = "";
$quantity = [];
foreach($cart as $id=>$value)
{
$quantity[$id] = $value;
$list_book .=$id.", ";
}
$list_book = substr($list_book, 0,strlen($list_book)-2);
$data = DB::table("sach")->whereRaw("id in (".$list_book.")")->get();
$detail = [];
foreach($data as $row)
{
$detail[] = ["ma_don_hang"=>$id_don_hang,"sach_id"=>$row->id,
"so_luong"=>$quantity[$row->id],"don_gia"=>$row->gia_ban]; 
}
DB::table("chi_tiet_don_hang")->insert($detail);
session()->forget('cart');
});
}
return view("vidusach.order", compact('data','quantity'));

}

////////////
public function bookview(Request $request)
{
$the_loai = $request->input("id_the_loai");
$data = [];
if($the_loai!="")
$data = DB::select("select * from sach where id_the_loai = ?",[$the_loai]);
else
$data = DB::select("select * from sach order by gia_ban asc limit 0,10");
return view("vidusach.bookview", compact("data"));

}

}

