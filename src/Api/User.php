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

class User extends Base implements ApiInterface
{
    public function __construct($app_key, $app_id, $master_secret)
    {
        parent::__construct($app_key, $app_id, $master_secret);
    }

    /**
     * 发送事件需要具体的参数
     * @var array
     */
    protected $send_map = [
        'bindAlias'=>'post',
        'getUserAliasByCid'=>'get',
        'getUserCidByAlias'=>'get',
        'unbindAlias'=>'delete',
        'unbindAllAlias'=>'delete',
        'getUserCustomTag'=>'get'
    ];

    /**
     * 生成需要的参数
     * @return $this|mixed
     */
    public function generate()
    {
        call_user_func([$this,$this->current_function."GenerateParams"]);
        return $this;
    }

    protected function setDataList()
    {
        $this->params = [
            'data_list'=>$this->data_list
        ];
    }

    /**
     * 发送事件
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {
        $request_setting = $this->send_map[$this->current_function];
        return Request::init()->request($this->api_url,
            $request_setting,['token'=>$this->access_token],$this->params);
    }

    /**
     * 绑定别名参数生成
     */
    protected function bindAliasGenerateParams()
    {
        $this->params = $this->data_list;
        $this->setDataList();
    }

    /**
     * 解绑别名参数生成
     */
    protected function unbindAliasGenerateParams()
    {
        $this->params = $this->data_list;
        $this->setDataList();
    }

    /**
     * 绑定cid和别名
     * @param $access_token string AccessToken
     * @return User
     * @throws Exception
     */
    public function bindAlias($access_token)
    {
        $this->setCurrentFunction(__FUNCTION__);
        return $this->commonUtil($access_token,'/user/alias');
    }

    /**
     * 根据cid获取到用户别名
     * @param $access_token string AccessToken
     * @param $cid string 用户cid
     * @return User
     * @throws Exception
     */
    public function getUserAliasByCid($access_token,$cid)
    {
        $this->setCurrentFunction(__FUNCTION__);
        return $this->commonUtil($access_token,"/user/alias/cid/{$cid}");
    }

    /**
     * 根据别名获取到用户cid
     * @param $access_token string AccessToken
     * @param $alias string 用户别名
     * @return User
     * @throws Exception
     */
    public function getUserCidByAlias($access_token,$alias)
    {
        $this->setCurrentFunction(__FUNCTION__);
        return $this->commonUtil($access_token,"/user/cid/alias/{$alias}");
    }

    /**
     * 解绑cid和别名
     * @param $access_token string AccessToken
     * @return User
     * @throws Exception
     */
    public function unbindAlias($access_token)
    {
        $this->setCurrentFunction(__FUNCTION__);
        return $this->commonUtil($access_token,'/user/alias');
    }

    /**
     * 解绑所有与该别名绑定的cid
     * @param $access_token string AccessToken
     * @param $alias string 别名
     * @return User
     * @throws Exception
     */
    public function unbindAllAlias($access_token,$alias)
    {
        $this->setCurrentFunction(__FUNCTION__);
        return $this->commonUtil($access_token,"/user/alias/{$alias}");
    }

    /**
     * 根据cid查询用户所有标签
     * @param $access_token string AccessToken
     * @param $cid string cid
     * @return User
     * @throws Exception
     */
    public function getUserCustomTag($access_token,$cid)
    {
        $this->setCurrentFunction(__FUNCTION__);
        return $this->commonUtil($access_token,"/user/custom_tag/cid/{$cid}");
    }
}
