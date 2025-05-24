<div class="flex-grow-1">
    <div class="container my-4 appCard <?php if (!isset($_GET['workingPage'])) echo "bg-transparent"; ?>">
        <?php
        if ($workingPage == 'category') {
            include("./pages/Category/CategoryIndex.php");
            include("./pages/Category/AddCategoryPopup.php");
        } else if ($workingPage == 'productSize') {
            include("./pages/ProductSize/ProductSizeIndex.php");
            include("./pages/ProductSize/AddProductSizePopup.php");
        } else if ($workingPage == 'productImage') {
            include("./pages/ProductImage/ProductImageIndex.php");
            include("./pages/ProductImage/AddProductImagePopup.php");
        } else if ($workingPage == 'product') {
            include("./pages/Product/ProductIndex.php");
            include("./pages/Product/AddProductPopup.php");
        } else if ($workingPage == 'event') {
            include("./pages/Event/EventIndex.php");
            include("./pages/Event/AddEventPopup.php");
        } else if ($workingPage == 'user') {
            include("./pages/User/UserIndex.php");
            include("./pages/User/UserOrderTable.php");
        } else if ($workingPage == 'order') {
            include("./pages/Order/OrderIndex.php");
            include("./pages/Order/AddOrderPopup.php");
        } else if ($workingPage == 'status') {
            include("./pages/Status/StatusIndex.php");
            include("./pages/Status/AddStatusPopup.php");
        } else if ($workingPage == 'size') {
            include("./pages/Size/SizeIndex.php");
            include("./pages/Size/AddSizePopup.php");
        } else if ($workingPage == 'payment_type') {
            include("./pages/PaymentType/PaymentTypeIndex.php");
            include("./pages/PaymentType/AddPaymentTypePopup.php");
        } else if ($workingPage == 'orderDetail') {
            include("./pages/OrderDetail/OrderDetailIndex.php");
            include("./pages/OrderDetail/AddOrderDetailPopup.php");
        } else if($workingPage == "user_order") {
            include("./pages/UserOrderDetail/UserOrderIndex.php");
            include("./pages/UserOrderDetail/AddUserOrderPopup.php");
        }
        else if($workingPage == "expenses") {
            include("./pages/Expenses/Expenses.php");
            include("./pages/Expenses/AddExpensePopup.php");
        }
        else if($workingPage == "marketing") {
            include("./pages/Marketing/MarketingCampaigns.php");
            include("./pages/Marketing/AddCampaignPopup.php");
        }
        else if($workingPage == "sales") {
            include("./pages/Sales/SalesDeals.php");
            include("./pages/Sales/AddDealPopup.php");
        }
        else if($workingPage == "inventory") {
            include("./pages/Inventory/InventoryTransactions.php");
            include("./pages/Inventory/AddTransactionPopup.php");
        }
        else {
            include("./pages/Dashboard/DashboardIndex.php");
        }
        ?>
    </div>
</div>