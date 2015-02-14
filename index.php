<?php

/**
 * A scrapper that pull daily gold prices
 * from http://egypt.gold-price-today.com/
 *
 * @author Alaa Attya <alaa.attya91@gmail.com>
 * @version 1.0.0
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

use phpQuery;
use Scrapper;

if (isset($_REQUEST['route'])) {
    
    switch ($_REQUEST['route']) {
        case 'gold-prices':
            $goldScrapper = new Scrapper\GoldScrapper('gold-price-today.com/');
            $goldScrapper->get_price_by_country('kuwait');die;
            break;

        default:

            break;
    }
}
