<?php
$page_title = 'Edit Customer';
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(3);

$customer = find_by_id('customers',(int)$_GET['id']);

if(!$customer){
  $session->msg("d","Missing Customer id.");
  redirect('customer.php');
}

if(isset($_POST['update'])){
  $req_fields = array('customer-name','customer-phone', 'loyalty-points');
  validate_fields($req_fields);

  if(empty($errors)){
    $name = remove_junk($db->escape($_POST['customer-name']));
    $email = isset($_POST['customer-email']) ? remove_junk($db->escape($_POST['customer-email'])) : ''; // Check if email is set
    $phone = remove_junk($db->escape($_POST['customer-phone']));
    $loyalty_points = remove_junk($db->escape($_POST['loyalty-points']));
    $points_adjustment = isset($_POST['points-adjustment']) ? (int)$_POST['points-adjustment'] : 0;

    // Calculate new loyalty points
    $new_loyalty_points = $loyalty_points + $points_adjustment;

    $query   = "UPDATE customers SET";
    $query  .= " customer_name ='{$name}', customer_phone ='{$phone}', loyalty_points ='{$new_loyalty_points}', last_update = NOW()";
    if($email !== '') { // Only include email in the query if it's not empty
      $query .= ", customer_email ='{$email}'";
    }
    $query  .= " WHERE id ='{$customer['id']}'";
    $result = $db->query($query);

    if($result && $db->affected_rows() === 1){
      $session->msg('s', "Customer updated successfully");
      redirect('customer.php', false);
    } else {
      $session->msg('d','Sorry failed to update customer!');
      redirect('edit_customer.php?id='.$customer['id'], false);
    }
  } else{
    $session->msg("d", $errors);
    redirect('edit_customer.php?id='.$customer['id'], false);
  }
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Edit Customer</span>
      </strong>
    </div>
    <div class="panel-body">
      <form method="post" action="edit_customer.php?id=<?php echo (int)$customer['id'] ?>">
        <div class="form-group">
          <label for="name">Customer Name</label>
          <input type="text" class="form-control" name="customer-name" value="<?php echo remove_junk(ucwords($customer['customer_name'])); ?>">
        </div>
        <div class="form-group">
          <label for="email">Customer Email</label>
          <input type="email" class="form-control" name="customer-email" value="<?php echo remove_junk($customer['customer_email']); ?>">
        </div>
        <div class="form-group">
          <label for="phone">Customer Phone</label>
          <input type="text" class="form-control" name="customer-phone" value="<?php echo remove_junk($customer['customer_phone']); ?>">
        </div>
        <div class="form-group">
          <label for="loyalty">Loyalty Points</label>
          <input type="text" class="form-control" name="loyalty-points" value="<?php echo remove_junk($customer['loyalty_points']); ?>">
        </div>
        <div class="form-group">
          <label for="adjustment">Points Adjustment</label>
          <input type="number" class="form-control" name="points-adjustment" value="0">
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
