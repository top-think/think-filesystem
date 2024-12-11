<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2024 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace think\facade;

use think\Facade;
use think\filesystem\Driver;

/**
 * Class Filesystem
 * @package think\facade
 * @mixin \think\Filesystem
 * @method static Driver disk(?string $name = null) 获取磁盘驱动实例
 * @method static mixed getConfig(?string $name = null, $default = null) 获取缓存配置
 * @method static mixed getDiskConfig(string $disk, ?string $name = null, $default = null) 获取磁盘配置
 * @method static string|null getDefaultDriver() 默认驱动
 */
class Filesystem extends Facade
{
    protected static function getFacadeClass(): string
    {
        return \think\Filesystem::class;
    }
}
