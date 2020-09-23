<?php
/**
 * @copyright ©2020 jemeryHsiao
 * @author jemeryHsiao
 * @link http://blog.hsiao.ml/
 * Created by PhpStorm
 * Date Time: 2020/9/11 8:58
 */
namespace JemeryHsiao\GetuiUtil\Handle;

use Exception;
/**
 * 生成公共参数Settings
 * Class Settings
 * @package JemeryHsiao\GetuiUtil\Handle
 */
class Settings extends BaseHandle
{
    /**
     * @var int $ttl 消息离线时间设置
     */
    public $ttl = 3600;
    /**
     * @var int $speed 定速推送
     */
    public $speed = 0;
    /**
     * @var array $strategy 厂商通道策略
     */
    public $strategy = ['default'=>1];
    /**
     * @var $strategy_condition array strategy厂商下发策略选择
     */
    public $strategy_condition;
    /**
     * 验证规则
     * @var array
     */
    protected $validateRules = [
        ['rule'=>'custom_util','fields'=>'ttl','function'=>'verifyTimeInterval']
    ];
    /**
     * 自定义时间间隔验证
     */
    public function verifyTimeInterval()
    {
        if($this->ttl < -1 || $this->ttl > 3*24*3600*1000){
            $this->errors[] = "消息离线时间设置设定为-1到三天";
        }
    }

    /**
     * 生成setting推送条件设置
     * @return array
     * @throws Exception
     */
    public function generate()
    {
        if(!$this->validate()){
            throw new Exception($this->errors,1);
        }
        if(is_array($this->strategy_condition)){
            $strategy = array_merge($this->strategy,$this->strategy_condition);
        }else{
            $strategy = $this->strategy;
        }
        return [
            'ttl'=>$this->ttl,
            'strategy'=>$strategy,
            'speed'=>$this->speed
        ];
    }
}
