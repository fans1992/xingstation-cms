<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],


        'qiniu' => [
            'driver' => 'qiniu',
            'domains' => [
                'default' => 'qiniucdn.xingstation.com', //你的七牛域名
                'https' => 'dn-yourdomain.qbox.me',         //你的HTTPS域名
                'custom' => 'static.abc.com',                //你的自定义域名
            ],
            'access_key' => 'QwzBG0rrX-sFVvFft2A2vhqNVAnM1Nrg8PGf3VX4',  //AccessKey
            'secret_key' => '95j_UlL2_PrSYw2q-5Z2R8e29B3V39PXIFZ5IEcf',  //SecretKey
            'bucket' => 'publication',  //Bucket名字
            'notify_url' => '',  //持久化处理回调地址
            'url' => 'http://qiniucdn.xingstation.com/',  // 填写文件访问根url
        ],

        'qiniu_bw' => [
            'driver' => 'qiniu',
            'domains' => [
                'default' => 'cdn.xingstation.cn', //你的七牛域名
                'https' => '',         //你的HTTPS域名
                'custom' => '',                //你的自定义域名
            ],
            'access_key' => 'nC8VTjw612h_bLnKrZW-B1o3ZvN7CTOPPnmGuYMp',  //AccessKey
            'secret_key' => 'XDAkO7Gj-JORvuKelsbEF9IZXzYgCTbdWbuBtcah',  //SecretKey
            'bucket' => 'exe666',  //Bucket名字
            'notify_url' => '',  //持久化处理回调地址
            'url' => 'http://cdn.xingstation.cn',  // 填写文件访问根url
        ],

        'qiniu_yq' => [
            'driver' => 'qiniu',
            'domains' => [
                'default' => 'imagecdn.xingstation.com', //你的七牛域名
                'https' => '',         //你的HTTPS域名
                'custom' => '',                //你的自定义域名
            ],
            'access_key' => '6kYGyUxCsoZV7aY2j57ynx1vCaBO5-KcKQ0JAuR0',  //AccessKey
            'secret_key' => '8gcw54_KPGfxwXMLrXOcHTUrQhKEL6NPDFp5Pbug',  //SecretKey
            'bucket' => 'publication',  //Bucket名字
            'notify_url' => '',  //持久化处理回调地址
            'url' => 'http://imagecdn.xingstation.com/',  // 填写文件访问根url
        ],
    ],

];
