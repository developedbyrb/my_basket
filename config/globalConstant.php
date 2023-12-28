<?php

return [
    'APP_NAME' => 'MyBasket',
    'APP_ROLES' => [
        ['name' =>  'Admin'],
        ['name' => 'Shopper'],
        ['name' => 'Shopkeeper']
    ],
    'APP_PERMISSIONS' => [
        ['name' =>  'get-roles'],
        ['name' => 'save-roles'],
        ['name' => 'edit-roles'],
        ['name' => 'update-roles'],
        ['name' => 'delete-roles'],
        ['name' => 'get-permissions'],
        ['name' => 'save-permissions'],
        ['name' => 'edit-permissions'],
        ['name' => 'update-permissions'],
        ['name' => 'delete-permissions'],
        ['name' => 'get-categories'],
        ['name' => 'save-categories'],
        ['name' => 'edit-categories'],
        ['name' => 'update-categories'],
        ['name' => 'delete-categories'],
        ['name' => 'get-users'],
        ['name' => 'create-users'],
        ['name' => 'save-users'],
        ['name' => 'edit-users'],
        ['name' => 'update-users'],
        ['name' => 'delete-users'],
        ['name' => 'get-products'],
        ['name' => 'create-products'],
        ['name' => 'save-products'],
        ['name' => 'edit-products'],
        ['name' => 'update-products'],
        ['name' => 'delete-products'],
        ['name' => 'get-shops'],
        ['name' => 'create-shops'],
        ['name' => 'save-shops'],
        ['name' => 'edit-shops'],
        ['name' => 'update-shops'],
        ['name' => 'delete-shops'],
        ['name' => 'get-access'],
        ['name' => 'save-access']
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
        3 => 'Delivered'
    ]
];
