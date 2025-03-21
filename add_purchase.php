<?php
  $page_title = 'Add Purchase';
  require_once('includes/load.php');
  page_require_level(2);
  $all_suppliers = find_all('suppliers');
  $all_products = find_all('products');

  if(isset($_POST['add_purchase'])){
    $req_fields = array('purchase-date', 'supplier-id', 'product-id', 'quantity');
    validate_fields($req_fields);
    if(empty($errors)){
      $p_date  = remove_junk($db->escape($_POST['purchase-date']));
      $s_id    = (int)$db->escape($_POST['supplier-id']);
      $p_id    = (int)$db->escape($_POST['product-id']);
      $p_qty   = (int)$db->escape($_POST['quantity']);
      
      // Get product price
      $product = find_by_id('products', $p_id, 'id');
      $p_price = $product['buy_price'];
      
      // Calculate total amount
      $p_total = $p_qty * $p_price;

      $query = "INSERT INTO purchases (date, supplier_id, product_id, quantity, total_amount) VALUES ('{$p_date}', '{$s_id}', '{$p_id}', '{$p_qty}', '{$p_total}')";
      if($db->query($query)){
        $session->msg('s',"Purchase added successfully");
        redirect('purchase.php', false);
      } else {
        $session->msg('d',' Sorry failed to add purchase!');
        redirect('add_purchase.php', false);
      }
    } else {
      $session->msg("d", $errors);
      redirect('add_purchase.php', false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-9">
    <?php echo display_msg($msg); ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New Purchase</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_purchase.php" class="clearfix">
           <div class="form-group">
             <div class="row">
               <div class="col-md-6">
                 <select class="form-control" name="supplier-id">
                   <option value="">Select Supplier</option>
                 <?php  foreach ($all_suppliers as $supplier): ?>
                   <option value="<?php echo (int)$supplier['supplier_id'] ?>">
                     <?php echo $supplier['supplier_name'] ?></option>
                 <?php endforeach; ?>
                 </select>
               </div>
               <div class="col-md-6">
                 <input type="date" class="form-control" name="purchase-date" placeholder="Purchase Date">
               </div>
             </div>
           </div>
           <div class="form-group">
             <div class="row">
               <div class="col-md-6">
                 <select class="form-control" name="product-id">
                   <option value="">Select Product</option>
                 <?php  foreach ($all_products as $product): ?>
                   <option value="<?php echo (int)$product['id'] ?>">
                     <?php echo $product['name'] ?></option>
                 <?php endforeach; ?>
                 </select>
               </div>
               <div class="col-md-6">
                 <input type="number" class="form-control" name="quantity" placeholder="Quantity" min="1" step="1">
               </div>
             </div>
           </div>
           <button type="submit" name="add_purchase" class="btn btn-primary">Add Purchase</button>
       </form>
      </div>
     </div>
   </div>
</div>
<?php include_once('layouts/footer.php'); ?>
