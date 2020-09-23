<?php
/**
 * @copyright ©2020 jemeryHsiao
 * @author jemeryHsiao
 * @link http://blog.hsiao.ml/
 * Created by PhpStorm
 * Date Time: 2020/9/11 8:58
 */
namespace JemeryHsiao\GetuiUtil\Handle;
/**
 * 推送基础抽象类
 * Class BaseHandle
 * @package JemeryHsiao\GetuiUtil\Handle
 */
abstract class BaseHandle
{
    /**
     * @var $validateRules array 验证规则
     */
    protected $validateRules;
    /**
     * @var $isNeedful array 必要字段
     */
    protected $isNeedful = [];
    /**
     * @var array $errors 错误信息
     */
    protected $errors = [];
    /**
     * @var array $rules 触发的规则
     */
    protected $rules;

    /**
     * 验证返回
     * @return bool
     */
    protected function validate()
    {
        // 获取调用的规则
        $rules = array_column($this->validateRules,'rule');
        $this->rules = $rules;
        foreach($this->rules as $item=>$rule){
            call_user_func([$this,$rule],$this->validateRules[$item]);
        }
        unset($rule);
        if(0 != count($this->errors)){
            return false;
        }
        return true;
    }

    /**
     * 必要字段检查
     * @param $rule
     */
    private function required($rule)
    {
        $errors = [];
        // 检查是否为空
        array_map(function($field){
            // 必要字段设置到属性
            $this->isNeedful[] = $field;
            if(empty($this->$field)){
                $errors[] = "{$field} 不能为空";
            }
        },$rule['fields']);
        // 存在可跳过字段忽略必要字段没填写错误
        if(isset($rule['skip'])){
            $skip_field = $rule['skip'];
            if(!empty($this->$skip_field) && count($errors)>0){
                $errors = [];
            }
        }
        array_merge($this->errors,$errors);
    }

    /**
     * 检查是否为字符串
     * @param $rule
     */
    private function string($rule)
    {
        // 检查是否为空
        array_map(function($field){
            if(!is_string($this->$field) && !empty($this->$field)){
                $this->errors[] = "{$field} 必须是一个字符串";
            }
        },$rule['fields']);
    }

    /**
     * 检查是否为整数
     * @param $rule
     */
    private function int($rule)
    {
        // 检查是否为空
        array_map(function($field){
            if(!is_int($this->$field) && !empty($this->$field)){
                $this->errors[] = "{$field} 必须是一个整数";
            }
        },$rule['fields']);
    }

    /**
     * 检查两个值相等
     * @param $rule
     */
    private function confirmed($rule)
    {
        $fields = $rule['fields'];
        if(is_array($fields) && count($fields)==2){
            $first_val = current($fields);
            $last_val = end($fields);
            if($this->$first_val != $this->$last_val){
                $this->errors[] = "{$first_val} 和 {$last_val} 不一致";
            }
        }else{
            $this->errors[] = "必须设定对比值";
        }
    }

    /**
     * 值是否在数组内
     * @param $rule
     */
    private function in_array($rule)
    {
        $fields = $rule['fields'];
        if(isset($rule['array'])){
            if(!empty($this->$fields) && !in_array($this->$fields,$rule['array'])){
                $this->errors[] = "$fields 不在指定数组内";
            }
        }else{
            $this->errors[] = "$fields 必须指定一个数组";
        }
    }

    /**
     * 一个条件存在另一个条件满足
     * @param $rule
     * ['field'=>'example','value'=>'']
     */
    private function required_if($rule)
    {
        $fields = $rule['fields'];
        if(isset($rule['condition'])){
            $needful_keys = ['field','value'];
            // 检查条件
            foreach ($needful_keys as $needful_key){
                if(!array_key_exists($needful_key,$rule['condition'])){
                    $this->errors[] = "$needful_key must set in condition";
                }
            }
            unset($needful_key);
            $required_field = $rule['condition']['field'];
            if(!empty($this->$required_field)){
                if(!empty($rule['condition']['value'])
                    && ($this->$required_field == $rule['condition']['value'])
                        && empty($this->$fields)){
                    $this->errors[] = "$fields 不能为空";
                }
            }
        }else{
            $this->errors[] = "$fields 必须设定条件";
        }
    }

    /**
     * 判断长度
     * @param $rule
     */
    private function length($rule)
    {
        $fields = [];
        if(is_array($rule['fields'])){
            $fields = $rule['fields'];
        }
        if(is_string($rule['fields'])){
            $fields[] = $rule['fields'];
        }
        foreach($fields as $field){
            if(isset($rule['condition']['max']) && !empty($this->$field)){
                if(strlen($this->$field) > $rule['condition']['max']){
                    $this->errors[] = "$fields 长度不能超过 ".$rule['condition']['max'];
                }
            }
            if(isset($rule['condition']['min']) && !empty($this->$field)){
                if(strlen($this->$field) < $rule['condition']['min']){
                    $this->errors[] = "$fields 长度不能少于 ".$rule['condition']['max'];
                }
            }
        }
    }

    /**
     * 自定义函数验证
     * @param $rule
     * @return mixed
     */
    private function custom_util($rule)
    {
        return call_user_func([$this,$rule['function']]);
    }
}
