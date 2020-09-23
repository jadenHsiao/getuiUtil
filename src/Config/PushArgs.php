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
 * 推送相关参数
 * Class PushArgs
 * @package JemeryHsiao\GetuiUtil\Config
 */
class PushArgs
{
    /**
     * 表示该消息在用户在线时推送个推通道，用户离线时推送厂商通道;
     */
    const CHANNEL_ONE = 1;
    /**
     * 表示该消息只通过厂商通道策略下发，不考虑用户是否在线;
     */
    const CHANNEL_TWO = 2;
    /**
     * 表示该消息只通过个推通道下发，不考虑用户是否在线；
     */
    const CHANNEL_THREE = 3;
    /**
     * 表示该消息优先从厂商通道下发，若消息内容在厂商通道代发失败后会从个推通道下发。
     */
    const CHANNEL_FOUR = 4;
    /**
     * 渠道推送：IOS
     */
    const BRAND_IOS = 'ios';
    /**
     * 渠道推送：华为
     */
    const BRAND_HUAWEI = 'hw';
    /**
     * 渠道推送：小米
     */
    const BRAND_XIAOMI = 'xm';
    /**
     * 渠道推送：vivo
     */
    const BRAND_VIVO = 'vivo';
    /**
     * 渠道推送：魅族
     */
    const BRAND_MEIZU = 'meizu';
    /**
     * 渠道推送：oppo
     */
    const BRAND_OPPO = 'oppo';
}
