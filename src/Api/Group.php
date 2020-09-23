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
use JemeryHsiao\GetuiUtil\Handle\{PushMessage,Settings};
use JemeryHsiao\GetuiUtil\Util\Request;

/**
 * 群组推送
 * Class Group
 * @package JemeryHsiao\GetuiUtil\Api
 */
class Group extends Base implements ApiInterface
{
    public function __construct($app_key, $app_id, $master_secret)
    {
        parent::__construct($app_key, $app_id, $master_secret);
    }

    /**
     * 生成完整参数
     * @return $this|mixed
     * @throws Exception
     */
    public function generate()
    {
        if(in_array($this->current_function,['createTask','pushAll'])){
            $this->params = [
                'request_id'=>$this->generateRequestId(),
                'settings'=>$this->settings->generate(),
                'push_message'=>$this->push_message->generate(),
                'group_name'=>$this->group_name
            ];
        }else{
            $this->params = [
                'audience'=>$this->audience,
                'taskid'=>$this->task_id,
                'is_async'=>$this->is_async
            ];
        }
        return $this;
    }

    /**
     * 创建消息
     * @param $access_token string AccessToken
     * @return Group
     * @throws Exception
     */
    public function createTask($access_token)
    {
        $this->setCurrentFunction(__FUNCTION__);
        return $this->commonUtil($access_token,'/push/list/message');
    }

    /**
     * 执行群推
     * @param $access_token string AccessToken
     * @return Group
     * @throws Exception
     */
    public function pushAll($access_token)
    {
        $this->setCurrentFunction(__FUNCTION__);
        return $this->commonUtil($access_token,'/push/all');
    }

    /**
     * 执行cid批量推
     * @param $access_token string AccessToken
     * @return Group
     * @throws Exception
     */
    public function pushListByCid($access_token)
    {
        $this->setCurrentFunction(__FUNCTION__);
        return $this->commonUtil($access_token,'/push/list/cid');
    }

    /**
     * 执行别名批量推
     * @param $access_token string AccessToken
     * @return Group
     * @throws Exception
     */
    public function pushListByAlias($access_token)
    {
        $this->setCurrentFunction(__FUNCTION__);
        return $this->commonUtil($access_token,'/push/list/alias');
    }

    /**
     * 停止任务
     * @param $access_token string AccessToken
     * @param $task_id string 任务ID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function stopTask($access_token,$task_id)
    {
        $this->commonUtil($access_token,"/task/{$task_id}");
        return Request::init()->request($this->api_url,'delete',['token'=>$this->access_token]);
    }

    /**
     * 查询定时任务
     * @param $access_token string AccessToken
     * @param $task_id string 任务ID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTimedTask($access_token,$task_id)
    {
        $this->commonUtil($access_token,"/task/schedule/{$task_id}");
        return Request::init()->request($this->api_url,'get',['token'=>$this->access_token]);
    }

    /**
     * 删除任务
     * @param $access_token string AccessToken
     * @param $task_id string 任务ID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteTask($access_token,$task_id)
    {
        $this->commonUtil($access_token,"/task/schedule/{$task_id}");
        return Request::init()->request($this->api_url,'delete',['token'=>$this->access_token]);
    }
}
