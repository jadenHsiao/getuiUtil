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

/**
 * 批量单推
 * Class BatchSingle
 * @package JemeryHsiao\GetuiUtil\Api
 */
class BatchSingle extends Base implements ApiInterface
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
        if(count($this->msg_list)>200){
            throw new Exception('推送对象不允许超过200个',1);
        }
        $this->params = [
            'is_async'=>$this->is_async,
            'msg_list'=>$this->msg_list
        ];
        return $this;
    }

    /**
     * 使用cid批量单推
     * @param $access_token
     * @return BatchSingle
     * @throws Exception
     */
    public function batchSingleByCid($access_token)
    {
        return $this->commonUtil($access_token,'/push/single/batch/cid');
    }

    /**
     * 使用别名批量单推
     * @param $access_token
     * @return BatchSingle
     * @throws Exception
     */
    public function batchSingleByAlias($access_token)
    {
        return $this->commonUtil($access_token,'/push/single/batch/alias');
    }



}
