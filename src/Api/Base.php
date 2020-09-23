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
use JemeryHsiao\GetuiUtil\Util\{Request,
    ToolTrait,
    ParamsUtils\SingleParamsTrait,
    ParamsUtils\BatchSingleParamsTrait,
    ParamsUtils\GroupParamsTrait,
    ParamsUtils\UserParamsTrait
};

/**
 * Api基类
 * Class Base
 * @package JemeryHsiao\GetuiUtil\Api
 */
class Base
{
    use ToolTrait,
        SingleParamsTrait,
        BatchSingleParamsTrait,
        GroupParamsTrait,
        UserParamsTrait;

    /**
     * 个推restAPI v2版本请求地址
     */
    const HOST = "https://restapi.getui.com/v2/";
    /**
     * @var $app_key string APP_KEY
     */
    protected $app_key;
    /**
     * @var $app_id string APP_ID
     */
    protected $app_id;
    /**
     * @var $master_secret string MASTER_SECRET
     */
    protected $master_secret;
    /**
     * @var $base_url string 请求基础地址
     */
    protected $base_url;
    /**
     * @var $access_token string token
     */
    protected $access_token;
    /**
     * @var $api_url string 具体接口请求地址
     */
    protected $api_url;
    /**
     * @var $params array|void 请求参数
     */
    protected $params;
    /**
     * @var $current_function string 当前函数
     */
    protected $current_function;
    /**
     * 公共构造内容
     * Base constructor.
     * @param $app_key
     * @param $app_id
     * @param $master_secret
     */
    public function __construct($app_key,$app_id,$master_secret)
    {
        $this->app_key = $app_key;
        $this->app_id = $app_id;
        $this->master_secret = $master_secret;
        $this->base_url = self::HOST.$app_id;
    }

    /**
     * 公共方法
     * @param $access_token
     * @param $url
     * @return $this
     * @throws Exception
     */
    protected function commonUtil($access_token,$url)
    {
        if(empty($access_token)){
            throw new Exception('缺少access_token');
        }
        $this->access_token = $access_token;
        $this->api_url = $this->base_url.$url;
        return $this;
    }

    /**
     * 设置当前函数
     * @param $current_function
     * @return $this
     */
    protected function setCurrentFunction($current_function)
    {
        $this->current_function = $current_function;
        return $this;
    }

    /**
     * 请求工具类
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {
        return Request::init()->request(
            $this->api_url,
            'post',
            ['token'=>$this->access_token],
            $this->params
        );
    }


}
