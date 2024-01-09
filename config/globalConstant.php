<?php

return [
    'APP_NAME' => 'MyBasket',
    'APP_ROLES' => [
        ['name' =>  'Admin'],
        ['name' => 'Shopper'],
        ['name' => 'Shopkeeper'],
        ['name' => 'Supplier']
    ],
    'APP_PERMISSIONS' => [
        ['name' =>  'get-roles'],
        ['name' => 'create-roles'],
        ['name' => 'edit-roles'],
        ['name' => 'delete-roles'],
        ['name' => 'get-permissions'],
        ['name' => 'create-permissions'],
        ['name' => 'edit-permissions'],
        ['name' => 'delete-permissions'],
        ['name' => 'get-categories'],
        ['name' => 'create-categories'],
        ['name' => 'edit-categories'],
        ['name' => 'delete-categories'],
        ['name' => 'get-users'],
        ['name' => 'create-users'],
        ['name' => 'edit-users'],
        ['name' => 'delete-users'],
        ['name' => 'get-products'],
        ['name' => 'create-products'],
        ['name' => 'edit-products'],
        ['name' => 'delete-products'],
        ['name' => 'get-shops'],
        ['name' => 'create-shops'],
        ['name' => 'edit-shops'],
        ['name' => 'delete-shops'],
        ['name' => 'get-access'],
        ['name' => 'save-access'],
        ['name' => 'get-attributes'],
        ['name' => 'create-attributes'],
        ['name' => 'edit-attributes'],
        ['name' => 'delete-attributes'],
        ['name' => 'get-warehouses'],
        ['name' => 'create-warehouses'],
        ['name' => 'edit-warehouses'],
        ['name' => 'delete-warehouses']
    ],
    'PAYMENT_METHODS' => [
        1 => 'COD',
        2 => 'Card',
        3 => 'UPI',
        4 => 'Net Banking'
    ],
    'ORDER_STATUSES' => [
        1 => 'Placed',
        2 => 'In Transits',
        3 => 'Delivered',
        4 => 'Cancelled'
    ],
    'RETURN_POLICY' => [
        1 => '7 Days',
        2 => '10 Days',
        3 => '15 Days',
    ],
    'PRODUCT_STATE' => [
        1 => 'New',
        2 => 'Refurbished'
    ],
    'GEO_GRAPHIC_STATES' => [
        'ap' => 'Andhra Pradesh',
    ]
];
