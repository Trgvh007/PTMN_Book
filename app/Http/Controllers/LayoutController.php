<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LayoutController extends Controller
{
    //
    function trang1()
    {
    return view("layouts.trang1");
    }


    function sachtl (){
        $data = DB::select("select * from the_loai");
        return view("layouts.sach_layout", compact("data"));
    }
    
    function sach()
    {
    $data = DB::select("select * from sach order by gia_ban asc limit 8");
    return view("vidusach.index", compact("data"));
    }

    function theloai($id)
    {
        $data = DB::select("select * from sach where id_the_loai = ?",[$id]);
        return view("vidusach.index", compact("data"));
        }
 
    function chitiet($id_sach) {

        $data = DB::select("select * from sach where id =?", [$id_sach]);
        return view("vidusach.detail", compact("data"));
    }

    public function booklist()
    {
    $data = DB::select("select * from sach ");
    return view("qlysach.book_list", compact("data"));
    }

    
    public function bookcreate()
    {
    $the_loai = DB::table("the_loai")->get();
    $action = "add";
    return view("qlysach.book_form", compact("the_loai", "action"));
    }


   

public function bookedit($id){
    $action = "edit";
    $the_loai = DB::table("the_loai")->get();
    $sach = DB::table("sach")->where("id",$id)->first();
    return view("qlysach.book_form",compact("the_loai","action","sach"));
    }


    public function booksave($action, Request $request)
{
$request->validate([
'tieu_de' => ['required', 'string', 'max:200'],
'nha_cung_cap' => ['required', 'string', 'max:50'],
'nha_xuat_ban' => ['required', 'string', 'max:50'],
'tac_gia' => ['required', 'string', 'max:50'],
'hinh_thuc_bia' => ['required', 'string', 'max:50'],
'gia_ban' => ['required', 'numeric'],
'id_the_loai' => ['required', 'max:3'],
'file_anh_bia' => ['nullable','image']
]);
$data = $request->except("_token");
if($action=="edit")
$data = $request->except("_token", "id");
if($request->hasFile("file_anh_bia"))
{
$fileName = $request->input("tieu_de") ."_".rand(1000000,9999999).'.' . $request->file('file_anh_bia')->extension();
$request->file('file_anh_bia')->storeAs('public/book_image', $fileName);
$data['file_anh_bia'] = $fileName;
}
//$data = $request->except("id","_token");
$message = "";
if($action=="add")
{
DB::table("sach")->insert($data);
$message = "Thêm thành công";
}
else if($action=="edit")
{
$id = $request->id;
DB::table("sach")->where("id",$id)->update($data);
$message = "Cập nhật thành công";
}
return redirect()->route('booklist')->with('status', $message);
}

public function bookdelete(Request $request)
{
$id = $request->id;
DB::table("sach")->where("id",$id)->delete();
return redirect()->route('booklist')->with('status', "Xóa thành công");
}
}
