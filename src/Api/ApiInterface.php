<?php
/**
 * @copyright ©2020 jemeryHsiao
 * @author jemeryHsiao
 * @link http://blog.hsiao.ml/
 * Created by PhpStorm
 * Date Time: 2020/9/11 8:58
 */
namespace JemeryHsiao\GetuiUtil\Api;

/**
 * Api规范接口
 * Interface ApiInterface
 * @package JemeryHsiao\GetuiUtil\Api
 */
interface ApiInterface
{
    /**
     * 生成参数
     * @return mixed
     */
    public function generate();
}
