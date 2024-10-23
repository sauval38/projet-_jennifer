<?php

namespace Controllers;

use Models\CartShowModel;
use Views\CartShowView;

class CartShowController {
    protected $cartShowModel;
    protected $cartShowView;

    public function __construct() {
        $this->cartShowModel = new CartShowModel();
        $this->cartShowView = new CartShowView();
    }

    public function displayCart($userId) {
        $cartItems = $this->cartShowModel->getCartItems($userId);
        $this->cartShowView->render($cartItems);
    }

    public function updateQuantity($cartDetailId, $quantity) {
        $updated = $this->cartShowModel->updateItemQuantity($cartDetailId, $quantity);
        if ($updated) {
            echo json_encode(['success' => true, 'message' => 'Quantity updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update quantity']);
        }
    }

    public function removeItem($cartDetailId) {
        $deleted = $this->cartShowModel->removeItemFromCart($cartDetailId);
        if ($deleted) {
            echo json_encode(['success' => true, 'message' => 'Item removed from cart']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to remove item']);
        }
    }
}
