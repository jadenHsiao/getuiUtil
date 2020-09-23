<?php
/**
 * @copyright ©2020 jemeryHsiao
 * @author jemeryHsiao
 * @link http://blog.hsiao.ml/
 * Created by PhpStorm
 * Date Time: 2020/9/11 8:58
 */
namespace JemeryHsiao\GetuiUtil\Util;

/**
 * 工具类
 * Trait ToolTrait
 * @package JemeryHsiao\GetuiUtil\Util
 */
trait ToolTrait
{

    /**
     * 生成签名
     * @param $app_key string APP_KEY
     * @param $master_secret string MASTER_SECRET
     * @return array
     */
    public function generateSign($app_key,$master_secret)
    {
        $timestamp = time()*1000;
        $sign = hash('sha256',$app_key.$timestamp.$master_secret);
        return [
            'sign'=>$sign,
            'timestamp'=>$timestamp
        ];
    }

    /**
     * 生成接口根域名
     * @param $host string 接口地址
     * @param $app_id string APP_ID
     * @return string
     */
    public function generateRequestBaseUrl($host,$app_id)
    {
        return $host.$app_id;
    }

    /**
     * 生成请求的唯一标识号（“$request_id”）
     * sha512(返回128位) sha384(返回96位) sha256(返回64位) md5(返回32位)
     * @param int $type 返回格式：0大小写混合  1全大写  2全小写
     * @param string $func 类型
     * @return string
     */
    public function generateRequestId($type=0, $func='md5')
    {
        $uid = md5(uniqid(rand(),true).microtime());
        $hash = hash($func, $uid);
        $arr = str_split($hash);
        foreach($arr as $v){
            if($type==0){
                $newArr[]= empty(rand(0,1)) ? strtoupper($v) : $v;
            }
            if($type==1){
                $newArr[]= strtoupper($v);
            }
            if($type==2){
                $newArr[]= $v;
            }
        }
        return implode('', $newArr);
    }
}
