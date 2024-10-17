<?php
namespace Controllers;

use Models\AddressCartModel;
use Views\AddressView; 

class AddressCartController {
    protected $addressModel;
    protected $addressView;

    public function __construct() {
        $this->addressModel = new AddressCartModel();
        $this->addressView = new AddressView();
    }

    public function AddressForm() {
        $address = $this->addressModel->fetchAddress();
        $this->addressView->initForm($address);
    }

    public function AddressSave() {
        if ($this->addressModel->saveAddress()) {
            return true;
        }
        return false; // Erreur dans la sauvegarde
    }
}
?>
