@if($order->status == 1)
    <p style="color: darkred; background-color: #ec7070; margin-top: 10px;
       text-align: center;font-size: 11px; font-weight: bold; border-radius: 5px; border: 1px solid #882c2c">
        Chờ xác nhận
    </p>
@elseif($order->status == 2)
    <p style="color: darkgreen; background-color: #3bfa3b; margin-top: 10px;
       text-align: center;font-size: 12px; font-weight: bold; border-radius: 5px; border: 1px solid green">
        Đã xác nhận
    </p>
@elseif($order->status == 3)
    <p style="color: darkorange; background-color: #faeed8; margin-top: 10px;
       text-align: center;font-size: 12px; font-weight: bold; border-radius: 5px; border: 1px solid #daa645">
        Đang xử lý
    </p>
@elseif($order->status == 4)
    <p style="color: #04aff6; background-color: #aed1df; margin-top: 10px; padding: 2px 0;
       text-align: center;font-size: 11px; font-weight: bold; border-radius: 3px; border: 1px solid #2393bf">
        Đã giao hàng
    </p>
@elseif($order->status == 5)
    <p style="color: purple; background-color: #ca8fca; margin-top: 10px;
       text-align: center;font-size: 12px; font-weight: bold; border-radius: 5px; border: 1px solid #852e85">
        Hoàn thành
    </p>
@elseif($order->status == 6)
    <p style="color: #757575; background-color: #c8c2c2; margin-top: 10px;
       text-align: center;font-size: 12px; font-weight: bold; border-radius: 5px; border: 1px solid #7c7a7a">
        Đã hủy
    </p>
@endif
