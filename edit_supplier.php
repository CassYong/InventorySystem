<?php
  $page_title = 'Edit Supplier';
  require_once('includes/load.php');
  page_require_level(2);

  // Check if the supplier ID is provided
  if(!isset($_GET['id']) || empty($_GET['id'])){
    $session->msg("d", "Missing supplier ID.");
    redirect('supplier.php');
  }

  // Fetch the supplier details
  $supplier = find_by_id('suppliers', (int)$_GET['id'], 'supplier_id'); // Updated line
  if(!$supplier){
    $session->msg("d", "Supplier not found.");
    redirect('supplier.php');
  }

  if(isset($_POST['edit_supplier'])){
    $req_fields = array('supplier-name', 'phone-number', 'email', 'address');
    validate_fields($req_fields);
    if(empty($errors)){
      $s_name  = remove_junk($db->escape($_POST['supplier-name']));
      $s_phone = remove_junk($db->escape($_POST['phone-number']));
      $s_email = remove_junk($db->escape($_POST['email']));
      $s_address = remove_junk($db->escape($_POST['address']));
      $query = "UPDATE suppliers SET supplier_name='{$s_name}', phone_number='{$s_phone}', email='{$s_email}', address='{$s_address}' WHERE supplier_id='{$supplier['supplier_id']}'"; // Updated line
      if($db->query($query)){
        $session->msg('s',"Supplier updated ");
        redirect('supplier.php', false);
      } else {
        $session->msg('d',' Sorry failed to update supplier!');
        redirect('edit_supplier.php?id=' . (int)$supplier['supplier_id'], false);
      }
    } else {
      $session->msg("d", $errors);
      redirect('edit_supplier.php?id=' . (int)$supplier['supplier_id'], false);
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
          <span>Edit Supplier</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="edit_supplier.php?id=<?php echo (int)$supplier['supplier_id'];?>" class="clearfix">
           <div class="form-group">
             <div class="row">
               <div class="col-md-6">
                 <input type="text" class="form-control" name="supplier-name" value="<?php echo remove_junk($supplier['supplier_name']); ?>" placeholder="Supplier Name">
               </div>
               <div class="col-md-6">
                 <input type="text" class="form-control" name="phone-number" value="<?php echo remove_junk($supplier['phone_number']); ?>" placeholder="Phone Number">
               </div>
             </div>
           </div>
           <div class="form-group">
             <div class="row">
               <div class="col-md-6">
                 <input type="email" class="form-control" name="email" value="<?php echo remove_junk($supplier['email']); ?>" placeholder="Email">
               </div>
               <div class="col-md-6">
                 <input type="text" class="form-control" name="address" value="<?php echo remove_junk($supplier['address']); ?>" placeholder="Address">
               </div>
             </div>
           </div>
           <button type="submit" name="edit_supplier" class="btn btn-primary">Update Supplier</button>
       </form>
      </div>
     </div>
   </div>
</div>
<?php include_once('layouts/footer.php'); ?>
