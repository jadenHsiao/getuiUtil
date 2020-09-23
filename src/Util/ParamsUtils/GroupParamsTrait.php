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
 * 推送到群组trait
 * Trait GroupParamsTrait
 * @package JemeryHsiao\GetuiUtil\Util\ParamsUtils
 */
trait GroupParamsTrait
{
    /**
     * @var string $group_name 任务组名
     */
    public $group_name;
    /**
     * @var string $task_id 任务组taskId
     */
    public $task_id;

    /**
     * 初始化必要参数
     * @return $this
     */
    public function init()
    {
        $this->push_message = new PushMessage();
        $this->settings = new Settings();
        return $this;
    }

    /**
     * 设置任务组名
     * @param $group_name string 任务组名
     * @return $this
     */
    public function setGroupName($group_name)
    {
        $this->group_name = $group_name;
        return $this;
    }

    /**
     * 创建消息接口返回的taskId
     * @param $task_id
     * @return $this
     */
    public function setTaskID($task_id)
    {
        $this->task_id = $task_id;
        return $this;
    }
}
