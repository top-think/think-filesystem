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

namespace think\filesystem;

use Closure;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\FilesystemException;
use League\Flysystem\PathNormalizer;
use League\Flysystem\WhitespacePathNormalizer;
use think\File;

/**
 * Class Driver
 * @package think\filesystem
 * @mixin Filesystem
 */
abstract class Driver
{

    /** @var Filesystem */
    protected Filesystem $filesystem;

    /** @var PathNormalizer */
    protected PathNormalizer $pathNormalizer;

    /**
     * 配置参数
     * @var array
     */
    protected array $config = [];

    public function __construct(array $config)
    {
        $this->config = array_merge($this->config, $config);

        $adapter = $this->createAdapter();
        $this->filesystem = $this->createFilesystem($adapter);
    }

    /**
     * 创建适配器
     * @return FilesystemAdapter
     */
    abstract protected function createAdapter(): FilesystemAdapter;

    /**
     * 创建文件系统
     * @param FilesystemAdapter $adapter 适配器
     * @return Filesystem
     */
    protected function createFilesystem(FilesystemAdapter $adapter): Filesystem
    {
        $config = array_intersect_key($this->config, array_flip(['public_url', 'visibility', 'directory_visibility', 'checksum_algo']));

        // 路径标准化
        if (!empty($this->config['path_normalizer'])) {
            $this->pathNormalizer = new $this->config['path_normalizer'];
        } else {
            $this->pathNormalizer = new WhitespacePathNormalizer();
        }

        return new Filesystem($adapter, $config);
    }

    /**
     * 获取文件完整路径
     * @param string $path
     * @return string
     */
    public function path(string $path): string
    {
        return $this->pathNormalizer->normalizePath($path);
    }

    /**
     * 获取文件 URL
     * @param string $path 文件路径
     * @return string
     */
    public function url(string $path): string
    {
        return $this->filesystem->publicUrl($path);
    }

    /**
     * 保存文件
     * @param string              $path    路径
     * @param File                $file    文件
     * @param string|Closure|null $rule    文件名规则
     * @param array               $options 参数
     * @return string
     * @throws FilesystemException
     */
    public function putFile(string $path, File $file, string|Closure|null $rule = null, array $options = []): string
    {
        return $this->putFileAs($path, $file, $file->hashName($rule), $options);
    }

    /**
     * 指定文件名保存文件
     * @param string $path    路径
     * @param File   $file    文件
     * @param string $name    文件名
     * @param array  $options 参数
     * @return string
     * @throws FilesystemException
     */
    public function putFileAs(string $path, File $file, string $name, array $options = []): string
    {
        $stream = fopen($file->getRealPath(), 'r');
        $path   = trim($path . '/' . $name, '/');

        $this->writeStream($path, $stream, $options);

        return $path;
    }

    /**
     * 直接调用 flysystem 方法
     * @param string $method     方法名
     * @param array  $parameters 参数
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->filesystem->$method(...$parameters);
    }
}
