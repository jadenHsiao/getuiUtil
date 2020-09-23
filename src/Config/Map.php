<?php
/**
 * @copyright ©2020 jemeryHsiao
 * @author jemeryHsiao
 * @link http://blog.hsiao.ml/
 * Created by PhpStorm
 * Date Time: 2020/9/11 8:58
 */
namespace JemeryHsiao\GetuiUtil\Config;
/**
 * 映射类
 * Class Map
 * @package JemeryHsiao\GetuiUtil\Config
 */
class Map
{
    const BASE_NAMESPACE = "JemeryHsiao\\GetuiUtil\\Api\\";

    /**
     * 映射
     * @return array
     */
    public static function apiMap()
    {
        return [
            'auth'=>'Authentication',
            'single'=>'Single',
            'batch-single'=>'BatchSingle',
            'group'=>'Group',
            'stat'=>'Statistics',
            'user'=>'User'
        ];
    }

    /**
     * 根据类型获取类
     * @param $type
     * @return mixed
     */
    public static function getMapClass($type)
    {
        return self::BASE_NAMESPACE.self::apiMap()[$type];
    }
}
