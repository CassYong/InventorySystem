<?php
$page_title = 'Edit Sale';
require_once('includes/load.php');
// Check what level user has permission to view this page
page_require_level(3);

// Define the update_loyalty_points function
function update_loyalty_points($customer_id, $total_amount) {
    global $db;
    $points = calculate_loyalty_points($total_amount); // Define your points calculation logic
    $query = "UPDATE customers SET loyalty_points = loyalty_points + {$points} WHERE id = {$customer_id}";
    return $db->query($query);
}

// Define the calculate_loyalty_points function
function calculate_loyalty_points($total_amount) {
    return floor($total_amount / 10); // Example: 1 point for every 10 units of currency
}

$sale_id = (int)$_GET['id'];
$sale = find_by_id('sales_items', $sale_id);
if (!$sale) {
    $session->msg("d", "Missing sale ID.");
    redirect('sales.php');
}

$transaction = find_by_id('sales_transactions', $sale['transaction_id']);
$items = find_sales_items_by_transaction($sale['transaction_id']) ?? [];
$all_customers = find_all_customers();
$all_products = find_all_products();

if (isset($_POST['update_sale'])) {
    $customer_id = (int)$_POST['customer_id'];
    $total_amount = 0;
    $items = $_POST['items']; // Array of items with product_id and quantity

    // Validate inputs
    if (empty($customer_id) || !is_array($items) || count($items) == 0) {
        $session->msg('d', 'Please fill out all fields.');
        redirect('edit_sale.php?id=' . $sale_id, false);
    }

    foreach ($items as $item) {
        $product_id = (int)$item['product_id'];
        $quantity = (int)$item['quantity'];
        $product = find_by_id('products', $product_id);
        if (!$product || $quantity <= 0) {
            $session->msg('d', 'Invalid product or quantity.');
            redirect('edit_sale.php?id=' . $sale_id, false);
        }
        $price = $product['sale_price'];
        $total_amount += $price * $quantity;
    }

    // Sanitize inputs
    $customer_id = $db->escape((int)$customer_id);
    $total_amount = $db->escape($total_amount);
    $transaction_id = $db->escape((int)$sale['transaction_id']);

    // Update sales_transaction
    $query = "UPDATE sales_transactions SET customer_id = '{$customer_id}', total_amount = '{$total_amount}' WHERE id = '{$transaction_id}'";
    if ($db->query($query)) {

        // Delete existing items
        $db->query("DELETE FROM sales_items WHERE transaction_id = '{$transaction_id}'");

        // Insert updated items
        foreach ($items as $item) {
            $product_id = $db->escape((int)$item['product_id']);
            $quantity = $db->escape((int)$item['quantity']);
            $price = $db->escape(find_by_id('products', $product_id)['sale_price']);
            $query  = "INSERT INTO sales_items (transaction_id, product_id, quantity, price) ";
            $query .= "VALUES ('{$transaction_id}', '{$product_id}', '{$quantity}', '{$price}')";
            $db->query($query);
        }

        update_loyalty_points($customer_id, $total_amount);
        $session->msg('s', 'Sale updated successfully.');
        redirect('sales.php', false);
    } else {
        $session->msg('d', 'Failed to update sale.');
        redirect('edit_sale.php?id=' . $sale_id, false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="edit_sale.php?id=<?php echo (int)$sale['id']; ?>">
        <div class="form-group">
          <label for="customer_id">Customer</label>
          <select class="form-control" name="customer_id" required>
              <?php foreach ($all_customers as $customer): ?>
                <option value="<?php echo (int)$customer['id']; ?>" <?php if($transaction['customer_id'] == $customer['id']) echo 'selected'; ?>>
                    <?php echo $customer['name']; ?>
                </option>
              <?php endforeach; ?>
          </select>
        </div>
        <div id="items">
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $index => $item): ?>
                <div class="form-group">
                    <label for="product_id">Product</label>
                    <select class="form-control" name="items[<?php echo $index; ?>][product_id]" required>
                        <?php foreach ($all_products as $product): ?>
                            <option value="<?php echo (int)$product['id']; ?>" <?php if($item['product_id'] == $product['id']) echo 'selected'; ?>>
                                <?php echo $product['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" name="items[<?php echo $index; ?>][quantity]" value="<?php echo $item['quantity']; ?>" min="1" required>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
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
            <?php endif; ?>
        </div>
        <button type="button" class="btn btn-secondary" onclick="addItem()">Add Another Item</button>
        <button type="submit" name="update_sale" class="btn btn-primary">Update Sale</button>
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
