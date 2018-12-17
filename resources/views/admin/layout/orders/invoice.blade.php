  <head>
    <meta charset="utf-8">
    <title>Invoice template</title>
    <base href="{{asset('')}}">
    <link rel="stylesheet" href="admin_source/invoice/style.css"/>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="admin_source/invoice/logo.png">
      </div>
      <div id="company">
        <h2 class="name">OneTech Mobile Store</h2>
        <div>KP6, P.Linh Trung, Q.Thủ Đức, TP.HCM</div>
        <div>+84 167 518 3919</div>
        <div><a href="">Email : Onetechmobile@gmail.com</a></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">THÔNG TIN KHÁCH HÀNG:</div>
          <h2 class="name">{{$data->customer_name}}</h2>
          <div class="address">Đ/C : {{$data->delivery_address}}</div>
          <div class="email">Email : <a href="">{{$data->customer_email}}</a></div>
          <div class="phone">SĐT : {{$data->customer_phone}}</div>
        </div>
        <div id="invoice">
          <h1>HÓA ĐƠN BÁN HÀNG</h1>
          <div class="date">Mã số đơn hàng : {{$data->id}}</div>
          <div class="date">Ngày đặt hàng : {{$data->created_at}}</div>
          <div class="date">Ngày lập hóa đơn: {{date('Y-m-d H:i:s')}}</div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">STT</th>
            <th class="desc">TÊN SẢN PHẨM</th>
            <th class="unit">ĐƠN GIÁ</th>
            <th class="qty">SỐ LƯỢNG</th>
            <th class="total">THÀNH TIỀN</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1 ?>
          @foreach($orders as $item)
          <tr>
            <td class="no">{{$i}}</td>
            <td class="desc"><h3>{{$item->product_name}}</h3></td>
            <td class="unit">{{number_format($item->product_price,0,',','.')}} đ</td>
            <td class="qty">{{$item->quantity}}</td>
            <td class="total">{{number_format($item->amount,0,',','.')}} đ</td>
          </tr>
          <?php $i++ ?>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">TỔNG TIỀN</td>
            <td>{{number_format($data->total_amount - $data->transport_fee,0,',','.')}} đ</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">PHÍ VẬN CHUYỂN</td>
            <td>{{number_format($data->transport_fee,0,',','.')}} đ</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">TỔNG TIỀN HÓA ĐƠN</td>
            <td>{{number_format($data->total_amount,0,',','.')}} đ</td>
          </tr>
        </tfoot>
      </table>
      <div id="thanks">Cảm ơn bạn đã mua hàng tại OneTech!</div>
      <div id="notices">
        <div>GHI CHÚ:</div>
        <div class="notice">Bạn vui lòng giữ lại hóa đơn này để xuất trình khi có yêu cầu hoặc cần bảo hành sản phẩm.</div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>