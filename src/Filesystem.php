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

namespace think;

use InvalidArgumentException;
use think\filesystem\Driver;
use think\filesystem\driver\Local;
use think\helper\Arr;

/**
 * Class Filesystem
 * @package think
 * @mixin Driver
 * @mixin Local
 */
class Filesystem extends Manager
{
    protected $namespace = '\\think\\filesystem\\driver\\';

    /**
     * 获取磁盘驱动实例
     * @param null|string $name 磁盘名称
     * @return Driver
     */
    public function disk(?string $name = null): Driver
    {
        return $this->driver($name);
    }

    /**
     * 获取磁盘类型
     * @param string $name 磁盘名称
     * @return string
     */
    protected function resolveType(string $name): string
    {
        return $this->getDiskConfig($name, 'type', 'local');
    }

    /**
     * 获取磁盘配置
     * @param string $name 磁盘名称
     * @return array
     */
    protected function resolveConfig(string $name): array
    {
        return $this->getDiskConfig($name);
    }

    /**
     * 获取文件系统配置
     * @access public
     * @param null|string $name    名称
     * @param mixed       $default 默认值
     * @return mixed
     */
    public function getConfig(?string $name = null, $default = null)
    {
        if (!is_null($name)) {
            return $this->app->config->get('filesystem.' . $name, $default);
        }

        return $this->app->config->get('filesystem');
    }

    /**
     * 获取磁盘配置
     * @param string      $disk
     * @param string|null $name
     * @param mixed       $default
     * @return mixed
     */
    public function getDiskConfig(string $disk, ?string $name = null, $default = null)
    {
        if ($config = $this->getConfig("disks.{$disk}")) {
            return Arr::get($config, $name, $default);
        }

        throw new InvalidArgumentException("Disk [$disk] not found.");
    }

    /**
     * 默认驱动
     * @return string|null
     */
    public function getDefaultDriver(): ?string
    {
        return $this->getConfig('default');
    }
}
