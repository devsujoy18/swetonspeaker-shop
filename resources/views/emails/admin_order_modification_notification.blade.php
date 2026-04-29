<html lang="en">
    
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Order Modified - {{ $order->order_number }}</title>
    
    <style TYPE="text/css">
    
    td{font-family: helvetica; font-size: 10pt;}
    
    .top {
      border-top: solid;
      border-color: #E6E6E6;
    }
    .left {
      border-left: solid;
      border-color:#E6E6E6;
    }
    .bdc {
  border-left: solid;
  border-right: solid;
  border-top: solid;
  border-bottom: solid;
  border-color:#E6E6E6;
}
    
    </style>
    
    </head>
    
    <body>
    <br />
    
    <table width="700" cellspacing="0" cellpadding="0" class="bdc" bgcolor="#fff">
    <tr>
    <td valign="top" align="center">
    
    <table width="680" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" align="center">
      <tbody>
    
        <tr>
          <td align="left"><img src="{{ asset('image/logonew1.png') }}" alt="Sweton Logo" style="width:150px"></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left">Order modified.</td>
        </tr>
        <tr>
          <td> &nbsp; &nbsp;</td>
        </tr>
        <tr bgcolor="#E6E6E6">
          <td align="left" bgcolor="#E6E6E6"><strong>Order Details</strong></td>
        </tr>
        <tr>
          <td> &nbsp;</td>
        </tr>
        <tr>
          <td align="left"><table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody>
              <tr>
                <td width="50%" valign="top" align="left">Order ID: {{ $order->order_number }}</td>
                <td width="50%" valign="top" align="left">Email: {{ $order->billing_email }}</td>
              </tr>
              <tr>
                <td valign="top" align="left">Date Added: {{ $order->created_at->format('d M Y, h:i A') }}</td>
                <td valign="top" align="left">Telephone: {{ $order->billing_phone }}</td>
              </tr>
              <tr>
                <td valign="top" align="left">Payment Method: {{ strtoupper($order->payment_method) }}</td>
                <td valign="top" align="left">Alternate Telephone: {{ $order->billing_alternate_phone }}</td>
              </tr>
              <tr>
                <td valign="top" align="left">Payment Status: {{ ucfirst($order->payment_status) }}</td>
                <td valign="top" align="left">Order Status: {{ ucfirst($order->order_status) }}</td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td> &nbsp; &nbsp;</td>
        </tr>
        <tr>
          <td align="left"><table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody>
              <tr bgcolor="#E6E6E6">
                <td width="50%" valign="top" align="left"><strong>Billing Address</strong></td>
                <td width="50%" valign="top" align="left"><strong>Shipping Address</strong></td>
                </tr>
              <tr>
                <td valign="top" align="left"> </td>
                </tr>
              <tr>
                <td valign="top" align="left">
                  {{ $order->billing_name }}<br>
                      {{ $order->billing_locality }}, {{ $order->billing_street }}<br>
                      {{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_zip }}<br>
                      @if($order->billing_landmark) Landmark: {{ $order->billing_landmark }}<br> @endif
                      Phone : {{ $order->billing_phone }}<br>
                      @if($order->billing_alternate_phone) Alternate Phone: {{ $order->billing_alternate_phone }} @endif
                      @if($order->company_name) Company Name: {{ $order->company_name }} @endif
                       @if($order->gst_no) GST NO: {{ $order->gst_no }} @endif
                </td>
                <td valign="top" align="left">{{ $order->shipping_name }}<br>
                  {{ $order->shipping_locality }}, {{ $order->shipping_street }}<br>
                  {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zip }}<br>
                  @if($order->shipping_landmark) Landmark: {{ $order->shipping_landmark }}<br> @endif
                  Phone: {{ $order->shipping_phone }}<br>
                  @if($order->shipping_alternate_phone) Alternate Phone: {{ $order->shipping_alternate_phone }} @endif
                </td>
          
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td> &nbsp; &nbsp;</td>
        </tr>
        <tr>
          <td align="left"><table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody>
              <tr></tr>
              <tr>
                <td colspan="4" align="left"><table width="100%" cellspacing="0" cellpadding="0" border="0">
                  <tbody>
                    
                    <tr bgcolor="#E6E6E6">
                      <td width="50%" align="left" valign="top">Product</td>
                     
                      <td width="10%" align="left" valign="top">Qty</td>
                      <td width="20%" align="left" valign="top">Price</td>
                      <td width="20%" align="left" valign="top">Total</td>
                    </tr>
                  </tbody>
                  <tbody>@foreach ($order->orderitems as $item)
                        <tr>
                          <td>
                            {{ $item->product_name }} @if($item->shop_description) ( {{ $item->shop_description }} ) @endif
                              @if($item->product && $item->product->ohm_list)
                                  ({{ $item->product->ohm_list }})
                              @endif
                          </td>
                          
                          <td>{{ $item->quantity }}</td>
                          <td>₹{{ number_format($item->price, 2) }}</td>
                          <td>₹{{ number_format($item->total, 2) }}</td>
                        </tr>
                      @endforeach
                 </tbody>
                  <tbody>
                    
                    <tr>
                      <td valign="top" align="left"></td>
                     
                      <td valign="top" align="left"></td>
                      <td valign="top" align="left"><strong>Total Amount</strong></td>
                      <td valign="top" align="left">₹{{ number_format($order->total, 2) }}</td>
                    </tr>
                    <tr>
                      <td valign="top" align="left"></td>
                      
                      <td valign="top" align="left"></td>
                      <td valign="top" align="left">&nbsp;</td>
                      <td valign="top" align="left">&nbsp;</td>
                    </tr>
                  </tbody>
                </table></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td> </td>
        </tr>
        <tr>
          <td> This is computer generated receipt no signature required.<br />
          Abbreviation Pcs/Qty means Pieces per Quantity. Qty means Quantity.<br /><br />
          For further assistance, please contact Sweton Team at <a href="mailto:sales@swetonspeakers.com">sales@swetonspeakers.com</a>. Please quote the order number, registered contact number and name in all correspondence.<br />
            <br />
            Thank you for giving us the opportunity to serve you!</td>
        </tr>
        <tr>
          <td> </td>
        </tr>
      </tbody>
    </table>
    </td>
    </tr>
    </table>
    </body>
    </html>