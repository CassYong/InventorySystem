<?php
$page_title = 'Add Sale';
require_once('includes/load.php');
// Check what level user has permission to view this page
page_require_level(3);

// Fetch all customers
$all_customers = find_all_customers();
error_log('Customers: ' . print_r($all_customers, true)); // Debugging line

// Fetch all products
$all_products = find_all_products();

if (isset($_POST['add_sale'])) {
    $customer_id = $db->escape((int)$_POST['customer_id']);
    $total_amount = 0;
    $items = $_POST['items']; // Array of items with product_id and quantity

    // Validate inputs
    if (empty($customer_id) || !is_array($items) || count($items) == 0) {
        $session->msg('d', 'Please fill out all fields.');
        redirect('add_sale.php', false);
    }

    foreach ($items as $item) {
        $product_id = $db->escape((int)$item['product_id']);
        $quantity = $db->escape((int)$item['quantity']);
        $product = find_by_id('products', $product_id);
        if (!$product || $quantity <= 0) {
            $session->msg('d', 'Invalid product or quantity.');
            redirect('add_sale.php', false);
        }
        $price = $product['sale_price'];
        $total_amount += $price * $quantity;
    }

    // Insert into sales_transactions
    $query  = "INSERT INTO sales_transactions (customer_id, total_amount) ";
    $query .= "VALUES ('{$customer_id}', '{$total_amount}')";
    if ($db->query($query)) {
        $transaction_id = $db->insert_id();

        // Insert into sales_items
        foreach ($items as $item) {
            $product_id = $db->escape((int)$item['product_id']);
            $quantity = $db->escape((int)$item['quantity']);
            $price = $product['sale_price'];
            $query  = "INSERT INTO sales_items (transaction_id, product_id, quantity, price) ";
            $query .= "VALUES ('{$transaction_id}', '{$product_id}', '{$quantity}', '{$price}')";
            $db->query($query);
        }

        // Calculate and update loyalty points
        $points_earned = $total_amount; // 1 point per dollar
        $update_points_query = "UPDATE customers SET loyalty_points = loyalty_points + {$points_earned} WHERE id = {$customer_id}";
        $db->query($update_points_query);

        $session->msg('s', 'Sale added successfully and loyalty points updated.');
        redirect('sales.php', false);
    } else {
        error_log('Failed to add sale: ' . $db->error);
        $session->msg('d', 'Failed to add sale.');
        redirect('add_sale.php', false);
    }
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="add_sale.php">
      <div class="form-group">
        <label for="customer_id">Customer</label>
        <select class="form-control" name="customer_id" required>
          <?php foreach ($all_customers as $customer): ?>
            <option value="<?php echo (int)$customer['id']; ?>">
              <?php echo $customer['name']; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div id="items">
        <div class="form-group">
          <label for="product_id">Product</label>
          <select class="form-control" name="items[0][product_id]" required>
            <?php foreach ($all_products as $product): ?>
              <option value="<?php echo (int)$product['id']; ?>">
                <?php echo $product['name']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="quantity">Quantity</label>
          <input type="number" class="form-control" name="items[0][quantity]" min="1" required>
        </div>
      </div>
      <button type="button" class="btn btn-secondary" onclick="addItem()">Add Another Item</button>
      <button type="submit" name="add_sale" class="btn btn-primary">Add Sale</button>
    </form>
  </div>
</div>

<script>
function addItem() {
  var itemsDiv = document.getElementById('items');
  var newItem = document.createElement('div');
  newItem.className = 'form-group';
  newItem.innerHTML = `
    <label for="product_id">Product</label>
    <select class="form-control" name="items[${itemsDiv.children.length}][product_id]" required>
      <?php foreach ($all_products as $product): ?>
        <option value="<?php echo (int)$product['id']; ?>">
          <?php echo $product['name']; ?>
        </option>
      <?php endforeach; ?>
    </select>
    <div class="form-group">
      <label for="quantity">Quantity</label>
      <input type="number" class="form-control" name="items[${itemsDiv.children.length}][quantity]" min="1" required>
    </div>
  `;
  itemsDiv.appendChild(newItem);
}
</script>

<?php include_once('layouts/footer.php'); ?>
