<?php
namespace Controllers;

use Models\RecapOrderModel;
use Views\RecapOrderView;

class RecapOrderController {
    protected $recapOrderModel;
    protected $recapOrderView;

    public function __construct() {
        $this->recapOrderModel = new RecapOrderModel();
        $this->recapOrderView = new RecapOrderView();
    }

    public function RecapPlz($cartId) {
        $cartDetails = $this->recapOrderModel->fetchCartDetails($cartId);
        $deliveryOption = $this->recapOrderModel->getSelectedDeliveryOption();
        $totalAmount = $this->recapOrderModel->calculateTotalAmount($cartDetails, $deliveryOption);

        $this->recapOrderView->render($cartDetails, $deliveryOption, $totalAmount);
    }
}
?>
