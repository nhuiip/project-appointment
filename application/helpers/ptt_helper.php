<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_ptt'))
{
	function get_ptt(){
		$dataOil = array();
		$client = new SoapClient("http://www.pttplc.com/webservice/pttinfo.asmx?WSDL");
    $params = array(
                   'Language' => "en"
               );
    $data = $client->CurrentOilPrice($params);
    $ob = $data->CurrentOilPriceResult;
    $xml = new SimpleXMLElement($ob);
    foreach ($xml  as  $key =>$val) {
    	if($val->PRICE != ''){
				if($val->PRODUCT == "Blue Diesel"){
					$dataOil['Diesel'] = $val->PRICE;
				}else if($val->PRODUCT == "Blue Gasohol E85"){
					$dataOil['E85'] = $val->PRICE;
				}else if($val->PRODUCT == "Blue Gasohol E20"){
					$dataOil['E20'] = $val->PRICE;
				}else if($val->PRODUCT == "Blue Gasohol 91"){
					$dataOil['91'] = $val->PRICE;
				}else if($val->PRODUCT == "Blue Gasohol 95"){
					$dataOil['95'] = $val->PRICE;
				}
      }
    }
		return $dataOil;
	}

}
