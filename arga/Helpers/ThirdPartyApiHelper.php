<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 7/5/18
 * Time: 6:09 PM
 */

namespace Arga\Helpers;

trait ThirdPartyApiHelper
{
    public $url = null;

    public $header = [];

    private $app_id;

    private $api_key;

    protected function formatHeader()
    {
        return [
            'headers' => [
                'app-id'  => $this->app_id,
                'api-key' => $this->api_key,
            ],
        ];
    }

    function tracking_system()
    {
        $this->url = 'https://trackingmonitoringsystem.com/internal_api/departments';
        $this->app_id = '7oy7G7IstdwcanuL7tfLQFzAKwi6n57u';
        $this->api_key = 'tFCaNkCgx9sHwXtErIqhnZS8vbfSgmnJ';

        $this->header = $this->formatHeader();
    }
}