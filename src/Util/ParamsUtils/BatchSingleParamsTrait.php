<?php
/**
 * @copyright ©2020 jemeryHsiao
 * @author jemeryHsiao
 * @link http://blog.hsiao.ml/
 * Created by PhpStorm
 * Date Time: 2020/9/11 8:58
 */
namespace JemeryHsiao\GetuiUtil\Util\ParamsUtils;

use JemeryHsiao\GetuiUtil\Handle\{PushMessage,Settings};


/**
 * 单推到用户参数工具trait
 * Trait BatchSingleParamsTrait
 * @package JemeryHsiao\GetuiUtil\Util\ParamsUtils
 */
trait BatchSingleParamsTrait
{
    /**
     * @var $is_async boolean 是否异步推送
     */
    public $is_async = false;
    /**
     * @var $msg_list array 消息内容
     */
    public $msg_list = [];

    /**
     * 批量内注册单个
     * @param $body
     * @return mixed
     */
    public function registerContent($body)
    {
        $this->push_message = new PushMessage();
        $this->settings = new Settings();
        return $this->setNotification($body);
    }

    /**
     * 追加到列表
     * @return $this
     */
    public function appendToMsgList()
    {
        $single = [
            'push_message'=>$this->push_message->generate(),
            'settings'=>$this->settings->generate(),
            'audience'=>$this->audience,
            'request_id'=>$this->generateRequestId()
        ];
        $this->msg_list[] = $single;
        return $this;
    }

    /**
     * 是否异步推送
     * @param $is_async
     * @return $this
     */
    public function isAsyncPush($is_async)
    {
        $this->is_async = $is_async;
        return $this;
    }
}
