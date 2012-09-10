<?php
namespace Epic\Controller;

use Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;

class LocalController extends ActionController
{
    protected $addResources = array(
    );

    public function indexAction($params = null)
    {
        $ip = $_SERVER['REMOTE_ADDR'];

        if ($params['city'] == 1) {
            include (EVA_ROOT_PATH . '/website/Epic/src/Epic/GeoIP/geoipcity.inc');
            include (EVA_ROOT_PATH . '/website/Epic/src/Epic/GeoIP/geoipregionvars.php');
            $gi = geoip_open(EVA_ROOT_PATH . '/website/Epic/src/Epic/GeoIP/GeoLiteCity.dat',GEOIP_STANDARD);
            $record = geoip_record_by_addr($gi, $ip);
            $country = $record->city;
            geoip_close($gi);

        } else {
            include (EVA_ROOT_PATH . '/website/Epic/src/Epic/GeoIP/geoip.inc');
            $gi = geoip_open(EVA_ROOT_PATH . '/website/Epic/src/Epic/GeoIP/GeoIP.dat',GEOIP_STANDARD);
            $country = geoip_country_name_by_addr($gi, $ip);
            geoip_close($gi);
        } 

        return $country;
    }
}
