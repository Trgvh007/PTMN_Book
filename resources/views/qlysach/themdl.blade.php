<form action="{{url('luudulieu')}}" method = "post">
 <table> 
    <tr> 
        <th> ID</th>
        <th> Tên thể loại</th>
    </tr>

    <tr>
        <td> <input type='text' name='id[]'></td>
        <td> <input type='text' name='ten_the_loai[]'></td>
    </tr>
    <tr>
        <td> <input type='text' name='id[]'></td>
        <td> <input type='text' name='ten_the_loai[]'></td>
    </tr>
 </table>

        <input type="submit" value="Lưu">
        {{ csrf_field() }}
 </form>


