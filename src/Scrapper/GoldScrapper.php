<?php

namespace Scrapper;

use phpQuery;

class GoldScrapper extends \Scrapper {

    /**
     * @var array Countries names, which will be used
     * as the subdomain name to get the data from
     * @example {countryname}.gold-price-today.com
     */
    private $_countries = array(
        'egypt',
        'kuwait',
        'saudi-arabia',
        'yemen',
        'jordan',
        'iraq',
        'lebanon',
        'oman',
        'bahrain',
        'algeria',
        'morocco',
        'palestine'
    );

    /**
     * @var string base url to be used for scrapping the data
     */
    private $_base_url;

    /**
     * @param string $base_url
     */
    public function __construct($base_url) {
        $this->_base_url = $base_url;
    }

    public function get_price_by_country($country_name) {

        if (\in_array($country_name, $this->_countries)) {
            $this->set_src_url("http://$country_name." . $this->_base_url);
            $page_content = $this->get_page_content();
            $result = $this->parse_page_content($page_content);
            return $result;
        } else {
            // Country title mistach
            throw new Exception\CountryTitleMismatch("Error in country name $country_name");
        }
    }

    /**
     * Prase html page content to get 
     * 
     * @param string $page_content
     * @return json
     */
    public function parse_page_content($page_content) {

        phpQuery::newDocumentHTML($page_content);

        $resultsArray = array();

        $clipper24Element = pq('table.prices-table tbody tr:first');
        $resultsArray['carat-24'] = array(
            'country-currency' => preg_replace('/[^0-9.]/', '', $clipper24Element->find('td:first')->text()),
            'usd' => preg_replace('/[^0-9.]/', '', $clipper24Element->find('td:first')->next()->text())
        );

        $clipper22Element = $clipper24Element->next();
        $resultsArray['carat-22'] = array(
            'country-currency' => preg_replace('/[^0-9.]/', '', $clipper22Element->find('td:first')->text()),
            'usd' => preg_replace('/[^0-9.]/', '', $clipper22Element->find('td:first')->next()->text())
        );

        $clipper21Element = $clipper22Element->next();
        $resultsArray['carat-21'] = array(
            'country-currency' => preg_replace('/[^0-9.]/', '', $clipper21Element->find('td:first')->text()),
            'usd' => preg_replace('/[^0-9.]/', '', $clipper21Element->find('td:first')->next()->text())
        );

        $clipper18Element = $clipper21Element->next();
        $resultsArray['carat-18'] = array(
            'country-currency' => preg_replace('/[^0-9.]/', '', $clipper18Element->find('td:first')->text()),
            'usd' => preg_replace('/[^0-9.]/', '', $clipper18Element->find('td:first')->next()->text())
        );

        $clipper14Element = $clipper18Element->next();
        $resultsArray['carat-14'] = array(
            'country-currency' => preg_replace('/[^0-9.]/', '', $clipper14Element->find('td:first')->text()),
            'usd' => preg_replace('/[^0-9.]/', '', $clipper14Element->find('td:first')->next()->text())
        );

        $clipper10Element = $clipper14Element->next();
        $resultsArray['carat-10'] = array(
            'country-currency' => preg_replace('/[^0-9.]/', '', $clipper10Element->find('td:first')->text()),
            'usd' => preg_replace('/[^0-9.]/', '', $clipper10Element->find('td:first')->next()->text())
        );

        $ounceElement = $clipper10Element->next();
        $resultsArray['ounce'] = array(
            'country-currency' => preg_replace('/[^0-9.]/', '', $ounceElement->find('td:first')->text()),
            'usd' => preg_replace('/[^0-9.]/', '', $ounceElement->find('td:first')->next()->text())
        );

        $poundElement = $ounceElement->next();
        $resultsArray['pound'] = array(
            'country-currency' => preg_replace('/[^0-9.]/', '', $poundElement->find('td:first')->text()),
            'usd' => preg_replace('/[^0-9.]/', '', $poundElement->find('td:first')->next()->text())
        );

        $kiloElement = $poundElement->next();
        $resultsArray['kilo'] = array(
            'country-currency' => preg_replace('/[^0-9.]/', '', $kiloElement->find('td:first')->text()),
            'usd' => preg_replace('/[^0-9.]/', '', $kiloElement->find('td:first')->next()->text())
        );

        return $resultsArray;
    }
}
