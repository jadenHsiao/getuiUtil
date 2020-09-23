<?php
/**
 * @copyright ©2020 jemeryHsiao
 * @author jemeryHsiao
 * @link http://blog.hsiao.ml/
 * Created by PhpStorm
 * Date Time: 2020/9/11 8:58
 */
namespace JemeryHsiao\GetuiUtil\Util\ParamsUtils;

trait UserParamsTrait
{
    public $data_list;
    public $cid;
    public $alias;
    public function singleBind($cid,$alias)
    {
        $this->cid = $cid;
        $this->alias = $alias;
        return $this;
    }
    public function appendToDataList()
    {
        $item = [
            'cid'=>$this->cid,
            'alias'=>$this->alias
        ];
        $this->data_list[] = $item;
        return $this;
    }


}
