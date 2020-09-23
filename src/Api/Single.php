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

/**
 * 推送单例API
 * Class Single
 * @package JemeryHsiao\GetuiUtil\Api
 */
class Single extends Base implements ApiInterface
{
    public function __construct($app_key, $app_id, $master_secret)
    {
        parent::__construct($app_key, $app_id, $master_secret);
        $this->push_message = new PushMessage();
        $this->settings = new Settings();
    }

    /**
     * 生成完整参数
     * @return $this
     * @throws Exception
     */
    public function generate(){
        $this->params = [
            'push_message'=>$this->push_message->generate(),
            'settings'=>$this->settings->generate(),
            'audience'=>$this->audience,
            'request_id'=>$this->generateRequestId()
        ];
        return $this;
    }

    /**
     * 使用cid单推
     * @param $access_token string AccessToken
     * @return Single
     * @throws Exception
     */
    public function singleByCid($access_token)
    {
        return $this->commonUtil($access_token,'/push/single/cid');
    }

    /**
     * 使用别名单推
     * @param $access_token string AccessToken
     * @return Single
     * @throws Exception
     */
    public function singleByAlias($access_token)
    {
        return $this->commonUtil($access_token,'/push/single/alias');
    }

}
