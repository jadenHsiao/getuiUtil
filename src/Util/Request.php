<?php
/**
 * @copyright ©2020 jemeryHsiao
 * @author jemeryHsiao
 * @link http://blog.hsiao.ml/
 * Created by PhpStorm
 * Date Time: 2020/9/11 8:58
 */
namespace JemeryHsiao\GetuiUtil\Util;

use Exception;
use GuzzleHttp\Client;

/**
 * 请求类
 * Class Request
 * @package JemeryHsiao\GetuiUtil\Util
 */
class Request{
    /**
     * @var $class \JemeryHsiao\GetuiUtil\Util\Request 请求工具实例
     */
    private static $class;

    /**
     * @var $client \GuzzleHttp\Client Guzzle请求实例
     */
    private $client;
    /**
     * @var array $headers 通用请求头
     */
    protected $headers = ['content-type'=>'application/json;charset=utf-8'];

    /**
     * 私有化构造
     */
    private function __construct(){
        $this->client = new Client();
    }

    /**
     * 禁止克隆
     * @throws Exception
     */
    private function __clone(){
        throw new Exception('不允许多个实例化',1);
    }

    /**
     * 单一入口
     * @return Request
     */
    public static function init(){
        if(!(self::$class instanceof self)){
            self::$class = new self();
        }
        return self::$class;
    }

    /**
     * 执行网络请求
     * @param $url string 请求地址
     * @param $method string 请求方式
     * @param $headers array 请求头
     * @param array $params 请求参数
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($url,$method,$headers = [],$params = []){
        $headers = array_merge($this->headers,$headers);
        $res = $this->client->request($method,$url,[
            'json'=>$params,
            'headers'=>$headers
        ]);
        $content = (string)($res->getBody());
        return json_decode($content,true);
    }
}
