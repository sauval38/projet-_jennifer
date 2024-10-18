<?php
namespace Controllers;

use Models\DeliveryCartModel;
use Views\DeliveryView;

class DeliveryCartController {
    protected $deliveryModel;
    protected $deliveryView;

    public function __construct() {
        $this->deliveryModel = new DeliveryCartModel();
        $this->deliveryView = new DeliveryView();
    }

    public function DeliveryChoice() {
        $deliveryOptions = $this->deliveryModel->getDeliveryOptions();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selectedOptionId = $_POST['delivery_option_id'] ?? null;
            if ($selectedOptionId) {
                $this->deliveryModel->saveDeliveryChoiceToSession($selectedOptionId);
                header('Location: ./recap');
                exit();
            } else {
                $this->deliveryView->render($deliveryOptions, 'Veuillez sélectionner une option de livraison.');
            }
        } else {
            $this->deliveryView->render($deliveryOptions);
        }
    }
}
?>
