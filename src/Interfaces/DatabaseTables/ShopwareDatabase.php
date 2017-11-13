<?php
namespace Portrino\Codeception\Interfaces\DatabaseTables;

/*
 * This file is part of the Codeception Helper Module project
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read
 * LICENSE file that was distributed with this source code.
 *
 */

/**
 * Interface ShopwareDatabase
 *
 * @package Portrino\Codeception\Interfaces\DatabaseTables
 */
interface ShopwareDatabase
{
    const S_ARTICLES = 's_articles';
    const S_ARTICLES_DETAILS = 's_articles_details';
    const S_ARTICLES_SUPPLIER = 's_articles_supplier';
    const S_ARTICLES_ATTRIBUTES = 's_articles_attributes';
    const S_ARTICLES_SUPPLIER_ATTRIBUTES = 's_articles_supplier_attributes';

    const S_ORDER = 's_order';
    const S_ORDER_ATTRIBUTES = 's_order_attributes';
    const S_ORDER_BASKET = 's_order_basket';
    const S_ORDER_BASKET_ATTRIBUTES = 's_order_basket_attributes';
    const S_ORDER_BASKET_SIGNATURES = 's_order_basket_signatures';
    const S_ORDER_BILLINGADDRESS = 's_order_billingaddress';
    const S_ORDER_BILLINGADDRESS_ATTRIBUTES = 's_order_billingaddress_attributes';
    const S_ORDER_COMPARISONS = 's_order_basket_signatures';
    const S_ORDER_DETAILS = 's_order_details';
    const S_ORDER_DETAILS_ATTRIBUTES = 's_order_details_attributes';
    const S_ORDER_SHIPPINGADDRESS = 's_order_shippingaddress';
    const S_ORDER_SHIPPINGADDRESS_ATTRIBUTES = 's_order_shippingaddress_attributes';

    const S_USER = 's_user';
    const S_USER_ATTRIBUTES = 's_user_attributes';
    const S_USER_ADDRESSES = 's_user_addresses';
    const S_USER_BILLINGADDRESS = 's_user_billingaddress';
    const S_USER_SHIPPINGADDRESS = 's_user_shippingaddress';

    const S_CORE_AUTH_ATTRIBUTES = 's_core_auth_attributes';
    const S_CORE_AUTH = 's_core_auth';
}
