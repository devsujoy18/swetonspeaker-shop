<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sweton Speakers - Order Review</title>

<style type="text/css">
TD { font-family: helvetica; font-size: 10pt; }
.bdc { border: 1px solid #E6E6E6; }
.rate-review {
    color: blue;
    text-transform: uppercase;
    font-weight: 500;
}
</style>
</head>

<body>
<br>

<table width="700" cellpadding="0" cellspacing="0" class="bdc" bgcolor="#fff">
<tr>
<td align="center">

<table width="680" cellpadding="0" cellspacing="0">
<tr>
<td align="left">
    <br>
    <img src="{{ asset('image/logonew1.png') }}" width="150">
</td>
</tr>

<tr><td>&nbsp;</td></tr>

<tr>
<td align="left">
    Hello, 
    @if($order->user) 
        {{ $order->user->name }} 
    @else 
        {{ $order->billing_name }} 
    @endif
    <br>
</td>
</tr>

<tr>
<td align="left">
Thank you for ordering at <a href="{{ url('/') }}">SWETON</a>.<br><br>

We’d love to hear from you! Please take a moment to rate the products you purchased.
Your feedback helps us improve and serve you better.<br><br>

Click below to write a review for your products.<br><br>

Thank you for choosing us!
</td>
</tr>

<tr><td>&nbsp;</td></tr>

<tr bgcolor="#E6E6E6">
<td><strong>Order Details</strong></td>
</tr>

<tr><td>&nbsp;</td></tr>

<tr>
<td>Order ID: {{ $order->order_number }}</td>
</tr>

<tr><td>&nbsp;</td></tr>

<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr bgcolor="#E6E6E6">
<th align="left">Product Image</th>
<th align="left">Product Name</th>
<th align="left">Review</th>
</tr>

@foreach ($order->orderitems as $item)
    @php
        $image = $item->product->primaryImage;
    @endphp
<tr>
<td>
    <img src="{{ $image ? env('IMG_HOST').'uploads/'.$image->path : asset('images/buy.jpg') }}" width="80">
</td>
<td>{{ $item->product->name }}</td>
<td>
    <a class="rate-review"
       href="{{ route('orders.index') }}">
       Rate & Review
    </a>
</td>
</tr>
@endforeach

</table>
</td>
</tr>

<tr><td>&nbsp;</td></tr>

<tr>
<td>
For assistance, contact us at
<a href="mailto:sales@swetonspeakers.com">sales@swetonspeakers.com</a><br><br>
Thank you for shopping with Sweton Speakers!
</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>
