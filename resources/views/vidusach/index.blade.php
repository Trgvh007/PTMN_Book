<x-book-layout>
  <x-slot name='title'>
Sach 
</x-slot>
 <div class='list-book'>
  @foreach($data as $row)
    <div class='book'>
      <a href="{{url('detail_sach/'.$row->id)}}"> 
      <img src="{{asset('book_image/'.$row->file_anh_bia)}}" width='200px' 
height='200px'><br>
        <b>{{$row->tieu_de}}</b><br/>
        <i>{{number_format($row->gia_ban,0,",",".")}}đ</i>
</a>
<div class='btn-add-product'>
 <button class='btn btn-success btn-sm mb-1 add-product' book_id="{{$row->id}}">
 Thêm vào giỏ hàng
 </button> 
</div>
    </div>
  @endforeach
 </div>

</x-book-layout>
<script>
    $(document).ready(function(){
      $(".add-product").click(function(){
      id = $(this).attr("book_id");
      num = 1;
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
