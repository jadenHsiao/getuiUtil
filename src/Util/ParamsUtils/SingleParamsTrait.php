<?php
/**
 * @copyright ©2020 jemeryHsiao
 * @author jemeryHsiao
 * @link http://blog.hsiao.ml/
 * Created by PhpStorm
 * Date Time: 2020/9/11 8:58
 */
namespace JemeryHsiao\GetuiUtil\Util\ParamsUtils;

/**
 * 单推到用户参数工具trait
 * Trait SingleParamsTrait
 * @package JemeryHsiao\GetuiUtil\Util\ParamsUtils
 */
trait SingleParamsTrait
{
    /**
     * @var $push_message \JemeryHsiao\GetuiUtil\Handle\PushMessage 推送配置类
     */
    public $push_message;

    /**
     * @var $settings \JemeryHsiao\GetuiUtil\Handle\Settings 推送设置类
     */
    public $settings;

    /**
     * @var $audience array|string 发送对象用户
     */
    public $audience;

    /**
     * 设置透传内容
     * @param $body string 透传内容
     * @return $this
     */
    public function setTransmission($body)
    {
        $this->push_message->transmission = $body;
        return $this;
    }

    /**
     * 设置发送信息
     * @param $body array 发送内容
     * @return $this
     */
    public function setNotification($body)
    {
        if(is_array($body)){
            foreach($body as $item=>$value){
                $this->push_message->$item = $value;
            }
            unset($value);
        }
        return $this;
    }

    /**
     * 设置接收用户
     * @param $audience array 接收对象
     * @return $this
     */
    public function setAudience($audience)
    {
        $this->audience = $audience;
        return $this;
    }
}
