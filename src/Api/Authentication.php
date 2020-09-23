<?php
/**
 * @copyright ©2020 jemeryHsiao
 * @author jemeryHsiao
 * @link http://blog.hsiao.ml/
 * Created by PhpStorm
 * Date Time: 2020/9/11 8:58
 */
namespace JemeryHsiao\GetuiUtil\Api;

use Exception;
use JemeryHsiao\GetuiUtil\Util\Request;

/**
 * 鉴权API
 * Class Authentication
 * @package JemeryHsiao\GetuiUtil\Api
 */
class Authentication extends Base
{
    public function __construct($app_key, $app_id, $master_secret)
    {
        parent::__construct($app_key, $app_id, $master_secret);
    }

    /**
     * 生成Access Token
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function generateAccessToken()
    {
        $params = $this->generateSign($this->app_key,$this->master_secret);
        $params['appkey'] = $this->app_key;
        return Request::init()->request($this->base_url.'/auth','post',[],$params);
    }

    /**
     * 让Access Token 失效
     * @param $access_token string Access Token
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteAccessToken($access_token)
    {
        if(empty($access_token)){
            throw new Exception('缺少access_token');
        }
        return Request::init()->request($this->base_url.'/auth/'.$access_token,'delete',[]);
    }
}
