<?php
class CheckoutAction extends checkout
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    function ActionAddOrder()
    {
        echo '<pre>';
        print_r($this->data);exit;
    }
}