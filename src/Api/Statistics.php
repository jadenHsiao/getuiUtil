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
 * 统计API
 * Class Statistics
 * @package JemeryHsiao\GetuiUtil\Api
 */
class Statistics extends Base
{
    public function __construct($app_key, $app_id, $master_secret)
    {
        parent::__construct($app_key, $app_id, $master_secret);
    }

    /**
     * 通用发送事件
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {
        return Request::init()->request($this->api_url,'get',['token'=>$this->access_token]);
    }

    /**
     * 获取推送结果
     * @param $access_token string AccessToken
     * @param $tasks string|array 任务组ID
     * @return $this
     * @throws Exception
     */
    public function getTasksPushResult($access_token,$tasks)
    {
        if(!is_array($tasks) || !is_string($tasks)){
            throw new Exception('请传入正确的任务ID',1);
        }
        $task_group = is_array($tasks)?implode(',',$tasks):$tasks;
        $this->commonUtil($access_token,"/report/push/task/{$task_group}");
        return $this;
    }

    /**
     * 任务组名查报表
     * @param $access_token string AccessToken
     * @param $group_name string 任务组名
     * @return $this
     * @throws Exception
     */
    public function getTaskGroupPushReport($access_token,$group_name)
    {
        $this->commonUtil($access_token,"/report/push/task_group/{$group_name}");
        return $this;
    }

    /**
     * 获取单日推送数据
     * @param $access_token string AccessToken
     * @param $timestamp integer 日期（时间戳）
     * @return $this
     * @throws Exception
     */
    public function getOneDayPushReport($access_token,$timestamp)
    {
        $date = date("Y-m-d",$timestamp);
        $this->commonUtil($access_token,"/report/push/date/{$date}");
        return $this;
    }

    /**
     * 获取单日用户数据接口
     * @param $access_token string AccessToken
     * @param $timestamp integer 日期（时间戳）
     * @return $this
     * @throws Exception
     */
    public function getOneDayUserReport($access_token,$timestamp)
    {
        $date = date("Y-m-d",$timestamp);
        $this->commonUtil($access_token,"/report/user/date/{$date}");
        return $this;
    }

    /**
     * 获取24个小时在线用户数
     * @param $access_token string AccessToken
     * @return $this
     * @throws Exception
     */
    public function getOnlineUser($access_token)
    {
        $this->commonUtil($access_token,"/report/online_user");
        return $this;
    }
}
