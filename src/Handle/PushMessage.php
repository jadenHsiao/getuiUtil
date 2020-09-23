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
 * 生成公共参数PushMessage
 * Class PushMessage
 * @package JemeryHsiao\GetuiUtil\Handle
 */
class PushMessage extends BaseHandle
{
    /**
     * @var $title string 通知消息标题
     */
    public $title;
    /**
     * @var $body string 通知消息内容
     */
    public $body;
    /**
     * @var $big_text string 长文本消息内容
     */
    public $big_text;
    /**
     * @var $big_image string 大图的URL地址
     */
    public $big_image;
    /**
     * @var $logo string 通知的图标名称
     */
    public $logo;
    /**
     * @var $logo_url string 通知图标URL地址
     */
    public $logo_url;
    /**
     * @var $channel_id string 通知渠道id
     */
    public $channel_id = 'Default';
    /**
     * @var $channel_name string 通知渠道名称
     */
    public $channel_name = 'Default';
    /**
     * @var $channel_level int 设置通知渠道重要性（可以控制响铃，震动，浮动，闪灯等等）
     */
    public $channel_level = 3;
    /**
     * @var $click_type string 点击通知后续动作
     */
    public $click_type = 'none';
    /**
     * @var $intent string 点击通知打开应用特定页面
     */
    public $intent;
    /**
     * @var $url string 点击通知打开链接
     */
    public $url;
    /**
     * @var $payload string 点击通知加自定义消息
     */
    public $payload;
    /**
     * @var $notify_id integer 覆盖任务时会使用到该字段
     */
    public $notify_id;
    /**
     * @var $duration array 手机端通知展示时间段
     */
    public $duration = [];
    /**
     * @var $transmission string 纯透传消息内容
     */
    public $transmission;
    /**
     * 验证规则
     * @var array
     */
    protected $validateRules = [
        ['rule'=>'required','fields'=>['title','body'],'skip'=>'transmission'],
        ['rule'=>'string','fields'=>['title','body','big_text','big_image','logo',
            'logo_url','channel_id','channel_name',
            'click_type','intent','url','payload']],
        ['rule'=>'int','fields'=>['channel_level','notify_id']],
        ['rule'=>'in_array','fields'=>'channel_level','array'=>[0,1,2,3,4]],
        ['rule'=>'in_array','fields'=>'click_type','array'=>['intent','url','payload','startapp','none']],
        ['rule'=>'required_if','fields'=>'intent','condition'=>['field'=>'click_type','value'=>'intent']],
        ['rule'=>'required_if','fields'=>'url','condition'=>['field'=>'click_type','value'=>'url']],
        ['rule'=>'required_if','fields'=>'payload','condition'=>['field'=>'click_type','value'=>'payload']],
        ['rule'=>'length','fields'=>'intent','condition'=>['max'=>1]],
        ['rule'=>'length','fields'=>'url','condition'=>['max'=>1024]],
        ['rule'=>'length','fields'=>'payload','condition'=>['max'=>3072]],
        ['rule'=>'length','fields'=>'title','condition'=>['max'=>50]],
        ['rule'=>'length','fields'=>'body','condition'=>['max'=>256]],
        ['rule'=>'custom_util','fields'=>'duration','function'=>'verifyTimeInterval']
    ];

    /**
     * 自定义时间间隔验证
     */
    public function verifyTimeInterval()
    {
        if(is_array($this->duration) && count($this->duration)!=0){
            if(count($this->duration)==2){
                $span = current($this->duration)-end($this->duration);
                if($span < 600000 || $span > -600000){
                    $this->errors[] = "两个时间间隔必须大于10分钟";
                }
            }else{
                $this->errors[] = "只能填写两个时间戳";
            }

        }
    }

    /**
     * 生成notification
     * @return array
     */
    protected function generateNotification()
    {
        $fields = [
            'title','body','big_text','big_image','logo','logo_url','channel_id',
            'channel_name','channel_level','click_type','intent','url','payload',
            'notify_id'
        ];
        $notification = [];
        array_map(function($field) use(&$notification){
            if(!empty($this->$field)){
                $notification[$field] = $this->$field;
            }
        },$fields);
        return $notification;
    }

    /**
     * 生成push_message个推通道消息内容
     * @return array
     * @throws Exception
     */
    public function generate(){
        if(!$this->validate()){
            throw new Exception($this->errors,1);
        }
        $result = [];
        if(count($this->duration)!=0){
            array_merge([
                "duration"=>current($this->duration)."-".end($this->duration)
            ],$result);
        }
        //纯透传消息内容
        if(!empty($this->transmission)){
            return array_merge([
                'transmission'=>$this->transmission
            ],$result);
        }
        return array_merge([
            'notification'=>$this->generateNotification()
        ],$result);
    }
}
