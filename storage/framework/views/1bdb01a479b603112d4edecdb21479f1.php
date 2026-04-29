<html lang="en">
    
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>New Order Received - <?php echo e($order->order_number); ?></title>
    
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
          <td align="left"><img src="<?php echo e(asset('image/logonew1.png')); ?>" alt="Sweton Logo" style="width:150px"></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left">You have received an order.</td>
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
                <td width="50%" valign="top" align="left">Order ID: <?php echo e($order->order_number); ?></td>
                <td width="50%" valign="top" align="left">Email: <?php echo e($order->billing_email); ?></td>
              </tr>
              <tr>
                <td valign="top" align="left">Date Added: <?php echo e($order->created_at->format('d M Y, h:i A')); ?></td>
                <td valign="top" align="left">Telephone: <?php echo e($order->billing_phone); ?></td>
              </tr>
              <tr>
                <td valign="top" align="left">Payment Method: <?php echo e(strtoupper($order->payment_method)); ?></td>
                <td valign="top" align="left">Alternate Telephone: <?php echo e($order->billing_alternate_phone); ?></td>
              </tr>
              <tr>
                <td valign="top" align="left">Payment Status: <?php echo e(ucfirst($order->payment_status)); ?></td>
                <td valign="top" align="left">Order Status: <?php echo e(ucfirst($order->order_status)); ?></td>
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
                  <?php echo e($order->billing_name); ?><br>
                      <?php echo e($order->billing_locality); ?>, <?php echo e($order->billing_street); ?><br>
                      <?php echo e($order->billing_city); ?>, <?php echo e($order->billing_state); ?> - <?php echo e($order->billing_zip); ?><br>
                      <?php if($order->billing_landmark): ?> Landmark: <?php echo e($order->billing_landmark); ?><br> <?php endif; ?>
                      Phone : <?php echo e($order->billing_phone); ?><br>
                      <?php if($order->billing_alternate_phone): ?> Alternate Phone: <?php echo e($order->billing_alternate_phone); ?> <?php endif; ?>
                      <?php if($order->company_name): ?> Company Name: <?php echo e($order->company_name); ?> <?php endif; ?>
                       <?php if($order->gst_no): ?> GST NO: <?php echo e($order->gst_no); ?> <?php endif; ?>
                </td>
                <td valign="top" align="left"><?php echo e($order->shipping_name); ?><br>
                  <?php echo e($order->shipping_locality); ?>, <?php echo e($order->shipping_street); ?><br>
                  <?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> - <?php echo e($order->shipping_zip); ?><br>
                  <?php if($order->shipping_landmark): ?> Landmark: <?php echo e($order->shipping_landmark); ?><br> <?php endif; ?>
                  Phone: <?php echo e($order->shipping_phone); ?><br>
                  <?php if($order->shipping_alternate_phone): ?> Alternate Phone: <?php echo e($order->shipping_alternate_phone); ?> <?php endif; ?>
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
                  <tbody><?php $__currentLoopData = $order->orderitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td>
                            <?php echo e($item->product_name); ?> <?php if($item->shop_description): ?> ( <?php echo e($item->shop_description); ?> ) <?php endif; ?>
                              <?php if($item->product && $item->product->ohm_list): ?>
                                  (<?php echo e($item->product->ohm_list); ?>)
                              <?php endif; ?>
                          </td>
                          
                          <td><?php echo e($item->quantity); ?></td>
                          <td>₹<?php echo e(number_format($item->price, 2)); ?></td>
                          <td>₹<?php echo e(number_format($item->total, 2)); ?></td>
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </tbody>
                  <tbody>
                    
                    <tr>
                      <td valign="top" align="left"></td>
                     
                      <td valign="top" align="left"></td>
                      <td valign="top" align="left"><strong>Total Amount</strong></td>
                      <td valign="top" align="left">₹<?php echo e(number_format($order->total, 2)); ?></td>
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
    </html><?php /**PATH /home/ace85084/public_html/shop.swetonspeakers.com/resources/views/emails/admin_order_notification.blade.php ENDPATH**/ ?>