<?php
    $selectedPaymentMethod = $_POST['selectedPaymentMethod'];
    $selectedShippingMethod = $_POST['selectedShippingMethod'];
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <div class="container py-5">
        <!-- Page Header -->
        <div class="text-center mb-4">
            <h1 class="display-5">Confirm Your Order</h1>
            <p class="text-muted">Review your details before proceeding to payment</p>
        </div>

        <!-- Order Details Card -->
        <div class="card shadow-lg mb-4">
            <div class="card-body">
                <h5 class="card-title">Order Summary</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Product 1</span>
                        <span>$50.00</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Product 2</span>
                        <span>$30.00</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Shipping</span>
                        <span>$10.00</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>$90.00</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- User Details Form -->
        <div class="card shadow-lg mb-4">
            <div class="card-body">
                <h5 class="card-title">Shipping Details</h5>
                <form action="process-checkout.php" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Shipping Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="shipping-method" class="form-label">Shipping Method</label>
                        <select class="form-select" id="shipping-method" name="shipping_method" required>
                            <?php foreach ($shippingMethods as $shippingMethod): ?>
                                <option value="<?=$shippingMethod->id?>"><?=$shippingMethod->descricao?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="payment-method" class="form-label">Payment Method</label>
                        <select class="form-select" id="payment-method" name="payment_method" required>
                            <?php foreach ($paymentMethods as $paymentMethod): ?>
                                <option value="<?=$paymentMethod->id?>"><?=$paymentMethod->descricao?></option>
                            <?php endforeach; ?> 
                        </select>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-credit-card"></i> Confirm & Pay
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Back to Shopping -->
        <div class="text-center">
            <a href="<?= yii\helpers\Url::to(['user/checkout']) ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Checkout
            </a>
        </div>
    </div>
</body>

</html>
