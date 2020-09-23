<?php
/**
 * @copyright ©2020 jemeryHsiao
 * @author jemeryHsiao
 * @link http://blog.hsiao.ml/
 * Created by PhpStorm
 * Date Time: 2020/9/11 8:58
 */
namespace JemeryHsiao\GetuiUtil;

use Exception;
use JemeryHsiao\GetuiUtil\Config\Map;

/**
 * 个推接口API
 * Class Getui
 * @package JemeryHsiao\GetuiUtil
 */
class Getui
{
    const BASE_FUNC = 'dispense';
    /**
     * @var $class \JemeryHsiao\GetuiUtil\Getui 基类
     */
    private static $class;
    /**
     * @var $target \JemeryHsiao\GetuiUtil\Api\Base 接口基类
     */
    private $target;
    /**
     * @var $app_id string APP_ID
     */
    private $app_id;
    /**
     * @var $app_key string APP_KEY
     */
    private $app_key;
    /**
     * @var $master_secret string MASTER_SECRET
     */
    private $master_secret;

    private function __construct()
    {

    }

    private function __clone()
    {
        throw new Exception('不允许多个实例化',1);
    }

    /**
     * 初始化
     * @param $app_key string APP_KEY
     * @param $app_id string APP_ID
     * @param $master_secret string MASTER_SECRET
     * @return Getui
     * @throws Exception
     */
    public static function instance($app_key,$app_id,$master_secret)
    {
        if(!(self::$class instanceof self)){
            self::$class = new self();
        }
        $args = func_num_args();
        if($args != 3){
            throw new Exception('参数不足',1);
        }
        self::$class->app_key = $app_key;
        self::$class->app_id = $app_id;
        self::$class->master_secret = $master_secret;
        return self::$class;
    }

    /**
     * 实例化指定API类
     * @param $type string API类型
     * @return $this
     */
    public function entry($type)
    {
        $target_class = Map::getMapClass($type);
        $this->target = new $target_class($this->app_key,$this->app_id,$this->master_secret);
        return $this;
    }

    /**
     * 下发事件
     * @param $api string 执行接口
     * @param $args array 参数
     * @return mixed
     */
    public function dispense($api,$args = [])
    {
        return call_user_func_array([$this->target,$api],$args);
    }
}
