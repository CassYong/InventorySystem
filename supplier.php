<?php
  $page_title = 'Suppliers';
  require_once('includes/load.php');
  page_require_level(2);

  // Fetch all suppliers
  $all_suppliers = find_all('suppliers');
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
          <span>All Suppliers</span>
       </strong>
        <div class="pull-right">
          <a href="add_supplier.php" class="btn btn-primary">Add Supplier</a>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Supplier Name</th>
              <th>Phone Number</th>
              <th>Email</th>
              <th>Address</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_suppliers as $supplier): ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td><?php echo remove_junk(ucfirst($supplier['supplier_name'])); ?></td>
                <td><?php echo remove_junk($supplier['phone_number']); ?></td>
                <td><?php echo remove_junk($supplier['email']); ?></td>
                <td><?php echo remove_junk($supplier['address']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_supplier.php?id=<?php echo (int)$supplier['supplier_id'];?>" class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_supplier.php?id=<?php echo (int)$supplier['supplier_id'];?>" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
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
