<?php
  $page_title = 'Manage Purchases';
  require_once('includes/load.php');
  page_require_level(2);

  // Fetch all purchases
  $all_purchases = find_all('purchases');
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>All Purchases</span>
       </strong>
        <div class="pull-right">
          <a href="add_purchase.php" class="btn btn-primary">Add Purchase</a>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Date</th>
              <th>Supplier</th>
              <th>Product</th>
              <th>Quantity</th>
              <th>Total Amount</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_purchases as $purchase): ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td><?php echo remove_junk(ucfirst($purchase['date'])); ?></td>
                <td><?php echo remove_junk(ucfirst(find_by_id('suppliers', $purchase['supplier_id'], 'supplier_id')['supplier_name'])); ?></td>
                <td><?php echo remove_junk(ucfirst(find_by_id('products', $purchase['product_id'], 'id')['name'])); ?></td>
                <td><?php echo remove_junk($purchase['quantity']); ?></td>
                <td><?php echo remove_junk($purchase['total_amount']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_purchase.php?id=<?php echo (int)$purchase['purchase_id'];?>" class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_purchase.php?id=<?php echo (int)$purchase['purchase_id'];?>" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
