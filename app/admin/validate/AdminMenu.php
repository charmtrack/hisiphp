<?php
// +----------------------------------------------------------------------
// | HisiPHP框架[基于ThinkPHP5开发]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 http://www.hisiphp.com
// +----------------------------------------------------------------------
// | HisiPHP承诺基础框架永久免费开源，您可用于学习和商用，但必须保留软件版权信息。
// +----------------------------------------------------------------------
// | Author: 橘子俊 <364666827@qq.com>，开发者QQ群：50304283
// +----------------------------------------------------------------------
namespace app\admin\validate;

use think\Validate;
use app\admin\model\AdminMenu as MenuModel;

/**
 * 菜单验证器
 * @package app\admin\validate
 */
class AdminMenu extends Validate
{
    //定义验证规则
    protected $rule = [
        'title|菜单名称'  => 'require|chsDash',
        'url|菜单链接' => 'require|checkUrl:thinkphp',
        'module|所属模块' => 'require|alphaDash',
        'pid|所属菜单'    => 'require|number',
        'status|状态' => 'require|in:0,1',
        'system|系统菜单' => 'require|in:0,1',
        'nav|后台导航' => 'require|in:0,1|token',
    ];

    //定义验证提示
    protected $message = [
        'module.require' => '请选择所属模块',
        'pid.require'    => '请选择所属菜单',
        'url.require'    => '菜单链接已存在',
    ];

    // 自定义菜单链接验证规则
    protected function checkUrl($value, $rule, $data)
    {
        return true;
        $map = [];
        $map['url'] = $value;
        $map['param'] = $data['param'];
        if (isset($data['id']) && $data['id'] > 0) {
            $map['id'] = ['neq', $data['id']];
        }
        $res = MenuModel::where($map)->find();

        if ($data['param']) {
            return $res ? '菜单链接和扩展参数已存在！' : true;
        }
        return $res ? '菜单链接已存在！' : true;
    }
}
