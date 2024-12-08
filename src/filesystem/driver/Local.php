<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2021 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace think\filesystem\driver;

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use think\filesystem\Driver;

class Local extends Driver
{
    /**
     * 配置参数
     * @var array
     */
    protected array $config = [
        // 根目录
        'root'                 => '',
        // 可见性转换
        'visibility_converter' => null,
        // 链接处理方式：skip、disallow
        'links'                => 'skip',
    ];

    /**
     * 创建适配器
     * @return LocalFilesystemAdapter
     */
    protected function createAdapter(): LocalFilesystemAdapter
    {
        // 访问可见性处理
        $visibility = is_array($this->config['visibility_converter'])
            ? PortableVisibilityConverter::fromArray($this->config['visibility_converter'])
            : $this->config['visibility_converter'];

        // 链接处理方式
        $linkHandling = 'skip' === $this->config['links']
            ? LocalFilesystemAdapter::SKIP_LINKS
            : LocalFilesystemAdapter::DISALLOW_LINKS;

        return new LocalFilesystemAdapter($this->config['root'], $visibility, $this->config['write_flag'], $linkHandling);
    }
}
