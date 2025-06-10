<?php

function getTotalQuantity() {
    $totalQuantity = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $id => $quantity) {
            $totalQuantity += $quantity;
        }
    }
    return $totalQuantity;
}
