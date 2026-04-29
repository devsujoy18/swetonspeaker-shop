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
    <img src="<?php echo e(asset('image/logonew1.png')); ?>" width="150">
</td>
</tr>

<tr><td>&nbsp;</td></tr>

<tr>
<td align="left">
    Hello, 
    <?php if($order->user): ?> 
        <?php echo e($order->user->name); ?> 
    <?php else: ?> 
        <?php echo e($order->billing_name); ?> 
    <?php endif; ?>
    <br>
</td>
</tr>

<tr>
<td align="left">
Thank you for ordering at <a href="<?php echo e(url('/')); ?>">SWETON</a>.<br><br>

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
<td>Order ID: <?php echo e($order->order_number); ?></td>
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

<?php $__currentLoopData = $order->orderitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $image = $item->product->primaryImage;
    ?>
<tr>
<td>
    <img src="<?php echo e($image ? env('IMG_HOST').'uploads/'.$image->path : asset('images/buy.jpg')); ?>" width="80">
</td>
<td><?php echo e($item->product->name); ?></td>
<td>
    <a class="rate-review"
       href="<?php echo e(route('orders.index')); ?>">
       Rate & Review
    </a>
</td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
<?php /**PATH /home/ace85084/public_html/shop.swetonspeakers.com/resources/views/emails/order_review.blade.php ENDPATH**/ ?>