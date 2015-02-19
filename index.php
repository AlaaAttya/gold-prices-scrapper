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
            $result_array = array();
            if(isset($_REQUEST['countries']) && !empty($_REQUEST['countries']) && count($_REQUEST['countries']) > 0) {
                $countries = explode(',', $_REQUEST['countries']);
                foreach ($countries as $country) {
                    $result_array[$country] = $goldScrapper->get_price_by_country($country);
                }
                echo \json_encode($result_array);    
            }
            
            die;
            break;
        case 'yallkora':
            $yallakooraScrapper = new Scrapper\GoldScrapper('http://www.yallakora.com/ar/Matches/0/%D9%8A%D8%A7%D9%84%D9%84%D8%A7%D9%83%D9%88%D8%B1%D8%A9-%D9%85%D8%B1%D9%83%D8%B2-%D8%A7%D9%84%D9%85%D8%A8%D8%A7%D8%B1%D9%8A%D8%A7%D8%AA?gmtvalue=1&selecteddate=13-02-2015');
            $yallakooraScrapper->test_t();
        default:

            break;
    }
}
