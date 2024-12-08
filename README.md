# think-filesystem for ThinkPHP 8.*

## 安装

```shell
composer require topthink/think-filesystem:^3.0
```
## 配置

```php
[
    // 磁盘类型
    'type'                 => 'local',
    // 磁盘路径
    'root'                 => app()->getRootPath() . 'public/storage',
    // 外部 URL
    'public_url'           => '',
    // 新文件/目录可见性：private、public
    'visibility'           => 'public',
    // 默认目录的可见性：private、public
    'directory_visibility' => 'public',
    // 可见性转换
    'visibility_converter' => [
        'file' => [
            'public' => 0640,
            'private' => 0604,
        ],
        'dir' => [
            'public' => 0740,
            'private' => 7604,
        ],
    ],
    // 链接处理方式：skip、disallow
    'links'                => 'skip',
    // 默认文件校验算法
    'checksum_algo'        => 'sha256',
];
```