<?php
  $page_title = 'Add Supplier';
  require_once('includes/load.php');
  page_require_level(2);

  if(isset($_POST['add_supplier'])){
    $req_fields = array('supplier-name', 'phone-number', 'email', 'address');
    validate_fields($req_fields);
    if(empty($errors)){
      $s_name  = remove_junk($db->escape($_POST['supplier-name']));
      $s_phone = remove_junk($db->escape($_POST['phone-number']));
      $s_email = remove_junk($db->escape($_POST['email']));
      $s_address = remove_junk($db->escape($_POST['address']));
      
      // Check if supplier already exists by name
      $existing_supplier = find_by_sql("SELECT * FROM suppliers WHERE supplier_name='{$s_name}' LIMIT 1");
      
      if($existing_supplier) {
        $session->msg('d',' Supplier already exists!');
        redirect('add_supplier.php', false);
      } else {
        $query = "INSERT INTO suppliers (supplier_name, phone_number, email, address) VALUES ('{$s_name}', '{$s_phone}', '{$s_email}', '{$s_address}')";
        if($db->query($query)){
          $session->msg('s',"Supplier added successfully");
          redirect('supplier.php', false);
        } else {
          $session->msg('d',' Sorry, failed to add supplier!');
          redirect('add_supplier.php', false);
        }
      }
    } else {
      $session->msg("d", $errors);
      redirect('add_supplier.php', false);
    }
  }

  // Function to display session messages
  if (!function_exists('display_msg')) {
    function display_msg($msg =''){
      $output = array();
      if(!empty($msg)) {
        foreach ($msg as $key => $value) {
          $output  = "<div class=\"alert alert-{$key}\">";
          $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
          $output .= remove_junk(first_character($value));
          $output .= "</div>";
        }
        return $output;
      } else {
        return "" ;
      }
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
          <span>Add New Supplier</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_supplier.php" class="clearfix">
           <div class="form-group">
             <div class="row">
               <div class="col-md-6">
                 <input type="text" class="form-control" name="supplier-name" placeholder="Supplier Name">
               </div>
               <div class="col-md-6">
                 <input type="text" class="form-control" name="phone-number" placeholder="Phone Number">
               </div>
             </div>
           </div>
           <div class="form-group">
             <div class="row">
               <div class="col-md-6">
                 <input type="email" class="form-control" name="email" placeholder="Email">
               </div>
               <div class="col-md-6">
                 <input type="text" class="form-control" name="address" placeholder="Address">
               </div>
             </div>
           </div>
           <button type="submit" name="add_supplier" class="btn btn-primary">Add Supplier</button>
       </form>
      </div>
     </div>
   </div>
</div>
<?php include_once('layouts/footer.php'); ?>
