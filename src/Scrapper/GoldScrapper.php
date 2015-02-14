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
            echo $result;die;
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
        		
        return \json_encode($resultsArray);
    }

    public function test() {
        $url = 'http://kuwait.gold-price-today.com/';
        // ÈÏÃ ÇáÌáÓÉ
        $ch = curl_init($url);
        // ÖÈØ ÇáÎÕÇÆÕ
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // ÅÓÊÏÚÇÁ ÇáÕÝÍÉ æÊÎÒíäåÇ Ýí ãÊÛíÑ
        $htmlPage = curl_exec($ch);
        // ÅÛáÇÞ ÇáÌáÓÉ
        curl_close($ch);

        // ÊÖãíä ãáÝ ÇáãßÊÈÉ
        //require_once ('phpQuery/phpQuery.php');
        // ÅäÔÇÁ ßÇÆä ãä ÇáÕÝÍÉ ÇáÊí Êã ÌáÈåÇ
        phpQuery::newDocumentHTML($htmlPage);

        // ÅÎÊíÇÑ Ãæá ÕÝ Ýí ÌÏæá ÇáÃÓÚÇÑ
        $clipper24Element = pq('table.prices-table tbody tr:first');
        // ÅÎÊíÇÑ Ãæá ÞíãÉ ÈåÇ ÓÚÑ ÇáÐåÈ ÚíÇÑ 24 ÈÇáÌäíÉ ÇáãÕÑí
        $clipper24['LE'] = preg_replace('/[^0-9.]/', '', $clipper24Element->find('td:first')->text());
        // ÇáÅäÊÞÇá  ááÞíãÉ ÇáËÇäíÉ æÈåÇ ÓÚÑ ÇáÐåÈ ÚíÇÑ 24 ÈãÍáÇÊ ÇáÐåÈ .
        $clipper24['GSHOP'] = preg_replace('/[^0-9.]/', '', $clipper24Element->find('td:first')->next()->text());
        // ÇáÅäÊÞÇá  ááÞíãÉ ÇáËÇáËÉ æÈåÇ ÓÚÑ ÇáÐåÈ ÚíÇÑ 24 ÈÚãáÉ ÇáæáÇíÇÊ ÇáãÊÍÏÉ .
        $clipper24['USD'] = preg_replace('/[^0-9.]/', '', $clipper24Element->find('td:first')->text());

        // ÈÇáãËá ÇáÈÞíÉ
        $clipper22Element = $clipper24Element->next();
        $clipper22['LE'] = preg_replace('/[^0-9.]/', '', $clipper22Element->find('td:first')->text());
        $clipper22['GSHOP'] = preg_replace('/[^0-9.]/', '', $clipper22Element->find('td:first')->next()->text());
        $clipper22['USD'] = preg_replace('/[^0-9.]/', '', $clipper22Element->find('td:last')->text());

        $clipper21Element = $clipper22Element->next();
        $clipper21['LE'] = preg_replace('/[^0-9.]/', '', $clipper21Element->find('td:first')->text());
        $clipper21['GSHOP'] = preg_replace('/[^0-9.]/', '', $clipper21Element->find('td:first')->next()->text());
        $clipper21['USD'] = preg_replace('/[^0-9.]/', '', $clipper21Element->find('td:last')->text());

        $clipper18Element = $clipper21Element->next();
        $clipper18['LE'] = preg_replace('/[^0-9.]/', '', $clipper18Element->find('td:first')->text());
        $clipper18['GSHOP'] = preg_replace('/[^0-9.]/', '', $clipper18Element->find('td:first')->next()->text());
        $clipper18['USD'] = preg_replace('/[^0-9.]/', '', $clipper18Element->find('td:last')->text());

        $clipper14Element = $clipper18Element->next();
        $clipper14['LE'] = preg_replace('/[^0-9.]/', '', $clipper14Element->find('td:first')->text());
        $clipper14['GSHOP'] = preg_replace('/[^0-9.]/', '', $clipper14Element->find('td:first')->next()->text());
        $clipper14['USD'] = preg_replace('/[^0-9.]/', '', $clipper14Element->find('td:last')->text());

        $clipper10Element = $clipper14Element->next();
        $clipper10['LE'] = preg_replace('/[^0-9.]/', '', $clipper10Element->find('td:first')->text());
        $clipper10['GSHOP'] = preg_replace('/[^0-9.]/', '', $clipper10Element->find('td:first')->next()->text());
        $clipper10['USD'] = preg_replace('/[^0-9.]/', '', $clipper10Element->find('td:last')->text());

        $ounceElement = $clipper14Element->next();
        $ounce['LE'] = preg_replace('/[^0-9.]/', '', $ounceElement->find('td:first')->text());
        $ounce['GSHOP'] = preg_replace('/[^0-9.]/', '', $ounceElement->find('td:first')->next()->text());
        $ounce['USD'] = preg_replace('/[^0-9.]/', '', $ounceElement->find('td:last')->text());

        $poundElement = $ounceElement->next();
        $pound['LE'] = preg_replace('/[^0-9.]/', '', $poundElement->find('td:first')->text());
        $pound['GSHOP'] = preg_replace('/[^0-9.]/', '', $poundElement->find('td:first')->next()->text());
        $pound['USD'] = preg_replace('/[^0-9.]/', '', $poundElement->find('td:last')->text());

        $kiloElement = $ounceElement->next();
        $kilo['LE'] = preg_replace('/[^0-9.]/', '', $kiloElement->find('td:first')->text());
        $kilo['GSHOP'] = preg_replace('/[^0-9.]/', '', $kiloElement->find('td:first')->next()->text());
        $kilo['USD'] = preg_replace('/[^0-9.]/', '', $kiloElement->find('td:last')->text());

        // ÅäÔÇÁ ÇáãÕÝæÝÉ ÇáäåÇÆíÉ
        $outData = array('clipper24' => $clipper24,
            'clipper22' => $clipper22,
            'clipper21' => $clipper21,
            'clipper18' => $clipper18,
            'clipper14' => $clipper14,
            'clipper10' => $clipper10,
            'ounce' => $ounce,
            'pound' => $pound,
            'kilo' => $kilo
        );
        // ÊÕÏíÑ ÇáÈíÇäÇÊ Úáì Ôßá ÊäÓíÞ ÌÓæä			
        echo json_encode($outData);
    }

}
