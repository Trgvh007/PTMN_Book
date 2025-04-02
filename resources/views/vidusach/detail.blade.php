<x-book-layout>
<x-slot name='title'>
  Chi tiet sach
</x-slot>
  @foreach($data as $row)
  <h4>{{$row->tieu_de}} </h4><br>
    <div class='detail-book'>
      <div style="float:left;margin-right:15px;"> 
      <img src="{{asset('book_image/'.$row->file_anh_bia)}}" width='200px' 
height='200px'>
</div>
<div style ="float: left"> 
        Nhà cung cấp: <b>{{$row->nha_cung_cap}} </b> <br>
        Nhà xuất bản: <b>{{$row->nha_xuat_ban}} </b> <br>
        Tác giả: <b> {{$row->tac_gia}}</b> <br>
        Hình thức bìa: <b>{{$row->hinh_thuc_bia}}</b>   
        <div class='mt-1'>
        Số lượng mua:
        <input type='number' id='product-number' size='5' min="1" value="1">
        <button class='btn btn-success btn-sm mb-1' id='add-to-cart' data-id="{{$row->id}}">Thêm vào giỏ hàng</button>
        </div>
        </div> 
<br style="clear:both;">
    <div style='text-align:justify'>
              <b>Mô tả</b>:<br>
              {{$row->mo_ta}}
            </div>
    </div>
  @endforeach
  <script>
 $(document).ready(function(){
 $("#add-to-cart").click(function(){

  id = $(this).data("id");
  num = $("#product-number").val()
  $.ajax({
      type:"POST",
      dataType:"json",
      url: "{{route('cartadd')}}",
      data:{"_token": "{{ csrf_token() }}","id":id,"num":num},
      beforeSend:function(){
      },

 success:function(data){

 $("#cart-number-product").html(data);
 },
 error: function (xhr,status,error){
 },
 complete: function(xhr,status){
 }
 });
});
 });
 
 </script>
</x-book-layout>



