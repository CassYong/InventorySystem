<?php
  $page_title = 'Edit Purchase';
  require_once('includes/load.php');
  page_require_level(2);

  // Check if the purchase ID is provided
  if (!isset($_GET['id']) || empty($_GET['id'])) {
    $session->msg("d", "Missing purchase ID.");
    redirect('purchase.php');
  }

  // Fetch the purchase details
  $purchase = find_by_id('purchases', (int)$_GET['id'], 'purchase_id'); // Updated line
  if (!$purchase) {
    $session->msg("d", "Purchase not found.");
    redirect('purchase.php');
  }

  if (isset($_POST['edit_purchase'])) {
    $req_fields = array('purchase-date', 'supplier-id', 'product-id', 'quantity', 'total-amount');
    validate_fields($req_fields);
    if (empty($errors)) {
      $p_date  = remove_junk($db->escape($_POST['purchase-date']));
      $s_id    = (int)$db->escape($_POST['supplier-id']);
      $p_id    = (int)$db->escape($_POST['product-id']);
      $p_qty   = (int)$db->escape($_POST['quantity']);
      $p_total = remove_junk($db->escape($_POST['total-amount']));
      $query = "UPDATE purchases SET date='{$p_date}', supplier_id='{$s_id}', product_id='{$p_id}', quantity='{$p_qty}', total_amount='{$p_total}' WHERE purchase_id='{$purchase['purchase_id']}'"; // Updated line
      if ($db->query($query)) {
        $session->msg('s', "Purchase updated");
        redirect('purchase.php', false);
      } else {
        $session->msg('d', ' Sorry, failed to update purchase!');
        redirect('edit_purchase.php?id=' . (int)$purchase['purchase_id'], false);
      }
    } else {
      $session->msg("d", $errors);
      redirect('edit_purchase.php?id=' . (int)$purchase['purchase_id'], false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-9">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Edit Purchase</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="edit_purchase.php?id=<?php echo (int)$purchase['purchase_id'];?>" class="clearfix">
           <div class="form-group">
             <div class="row">
               <div class="col-md-6">
                 <input type="date" class="form-control" name="purchase-date" value="<?php echo remove_junk($purchase['date']); ?>" placeholder="Purchase Date">
               </div>
               <div class="col-md-6">
                 <select class="form-control" name="supplier-id">
                   <option value="">Select Supplier</option>
                   <?php  foreach (find_all('suppliers') as $supplier): ?>
                     <option value="<?php echo (int)$supplier['supplier_id']; ?>" <?php if($supplier['supplier_id'] === $purchase['supplier_id']) echo "selected"; ?>>
                       <?php echo $supplier['supplier_name']; ?>
                     </option>
                   <?php endforeach; ?>
                 </select>
               </div>
             </div>
           </div>
           <div class="form-group">
             <div class="row">
               <div class="col-md-6">
                 <select class="form-control" name="product-id">
                   <option value="">Select Product</option>
                   <?php  foreach (find_all('products') as $product): ?>
                     <option value="<?php echo (int)$product['id']; ?>" <?php if($product['id'] === $purchase['product_id']) echo "selected"; ?>>
                       <?php echo $product['name']; ?>
                     </option>
                   <?php endforeach; ?>
                 </select>
               </div>
               <div class="col-md-6">
                 <input type="number" class="form-control" name="quantity" value="<?php echo remove_junk($purchase['quantity']); ?>" placeholder="Quantity">
               </div>
             </div>
           </div>
           <div class="form-group">
             <div class="row">
               <div class="col-md-12">
                 <input type="text" class="form-control" name="total-amount" value="<?php echo remove_junk($purchase['total_amount']); ?>" placeholder="Total Amount">
               </div>
             </div>
           </div>
           <button type="submit" name="edit_purchase" class="btn btn-primary">Update Purchase</button>
       </form>
      </div>
     </div>
   </div>
</div>
<?php include_once('layouts/footer.php'); ?>
