<?php

return [
    'alipay' => [
        // 支付宝分配的 APPID
        'app_id' => '2016080500174550',

        // 支付宝异步通知地址
        'notify_url' => 'http://requestbin.leo108.com/pweebppw',

        // 支付成功后同步通知地址
        'return_url' => 'http://mapi.jingfree.top/api/payment/alipay/return',

        // 阿里公共密钥，验证签名时使用
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArQJymgQgvhABARR7B9bkRxLOrypKCvBi0bLPk813oq/Ks2F9jTQ9S+M59vF7i/ztzg13qmSDm7/hbEEfLXh+SaqqXXuIJvb6WdNyuNyNqA07eh/pPmR+Hm0VH3Zc+wQ8V3tUKQFmbvlv31YmKTDnNBHqQou6qeJ8xUxWmknMLHK9FH0VDXI31g5MVZpecX8Fj3wQVfQlJ7mJlA54TTAwCCxGucnQ29OZa+q6+5nVM9BVDhJSdu682b40LE9a8govCzyli/+PapAw5EoOioF38Cryrs1knlj8flR7bthMGcuKeAl/Ik0BsN6qedkrXj/ZE6EcCMZDf5by5+VqIK36hQIDAQAB',

        // 自己的私钥，签名时使用
        'private_key' => 'MIIEogIBAAKCAQEArREoX9JzpsMvtelm2vzRETf0b4YGaNgV3XtQAIwlfrxN3z1K7C+wDRL0DSV+rkyQ9ayp0waDbvCeY7/BD+d/iZp88GXgc5hye8aJ7RkF7dKUHLClZX0wncdUcpV/Jm6kPoIXBoSyJtYXfrpggTmWp2SYb+RyU87Hnoa4nDFAa0vIbhwV8d4eVUqaLXIrLSubqmnnxlsbECeMotFMcgHGT8Bgcww/y+CisxwMyu7TL+V1+fOmRHPliVw9FOj6cqP+P3hEmhdykRR9Sw69lY9NUsIF5yfNwoDPENX80Wg+uivzAuFSdNcJU39uuFkheNcc4djnZByoc5dhmBM4KrCWvwIDAQABAoIBAB9Z3FZ/aTPsZ9gsT9WbtsPHvx/0x3R2sH9Ot09iE+jBc9nc4JWojdvQcyVuhWRNunTGsnzn0Sdnr0mikvaumQv0UG28Bszp8NM7RAEPZ2ONogcQeOXJp+TtFv8q1b3AjUBFkKY9o4glgFwUpybBp+jq8DJUz+EetEqjXQ3uXh0RcQsg2CJWHtavqyovXEWWAXItIryffgNgOsowJaVR2++e7eb5xsteuazqHfAaVK184xxB3h9M5ZxkihI+MPY2V1lJT8SCW3uMdctBB2oZ7apmMlVj+lXl+LLknmERMb7WGKGz872pnEvQYml5v/BiyWJslANKmD7bJm/HeyoapQECgYEA2xQ7FHEMqWLxODKq1Kfcr4w/XzQkRJsQZlDlQivK/uOvbgWZkfodjQZ8/j1tnmf3oVq6CV1t731b1B5ceg25xwEKA7o79QrfdxtWbuxo+YKdHtCHGb89a75YbCz938ZuWBovuisoBsCNiw31XZ5Z82WK6aSsXPa93htZT5tJ07sCgYEAyjvScei0c0pcGlluL210CDuF2yn42dh+ANV7OWxZQNXARGnVDk/q/1eqjaRxO4M802PGf+Vn1sucN3rbGHM/fJl//7bBRPy4cgJgRXNMdNdOX/Ax9bKGAX4FILw7Cxz5IaQcFi7UZtsf0Horq3vlfY52OA7SX/wWHzKX3HNUfs0CgYAVnxWFmvKo9P7hkP6TJk39dVX7y2WY78TalDlMIo5SQZ5auWrCoXCxLma/oMhkzdX+srmRmwryi+i4Mpbl5Nzk6xFV9NdeA8iyNJx/Lg3eMinXlLUAsYMaUxre8kHMCAVz5IG5WfEFWZOema4Ro0M1ZlwjWwE325I5jXFvDeBnaQKBgFsLE3K0kIhWsaArIq+3VsVeBqTkAGQSUqeNdCwl2wiVMjmaa5BF6kWJ8f5SSafBLWD9Sh/J5zWL9IgFhx06xRoTAMzeOaQVIfQxnaWmgoUXaPFH8TXraOjDEwvpsasPIBlFCF/0NSsY+vmgBojs/iPIPvB9u7f6hPsGi9dzFFcBAoGADqro6hr+NymLKUUWQdP1rI7rcJKy4DIYPkbliw1GbppqRbcj5Un8kKOxil8pWioIROasEosF2UE252tri7CNOf3Wbuxxlk64Bt3JSvmAC1zTEf5+F3wKv8nRLRoZjoQgUYK0wKTz+m19nb5PCUmCPJzqwUprN13QIMcofASxwyU=',

        // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
        'log' => [
            'file' => storage_path('logs/alipay.log'),
            //     'level' => 'debug'
        ],

        // optional，设置此参数，将进入沙箱模式
        'mode' => 'dev',
    ],

    'wechat' => [
        // 公众号 APPID
        'app_id' => '',

        // 小程序 APPID
        'miniapp_id' => '',

        // APP 引用的 appid
        'appid' => '',

        // 微信支付分配的微信商户号
        'mch_id' => '',

        // 微信支付异步通知地址
        'notify_url' => '',

        // 微信支付签名秘钥
        'key' => '',

        // 客户端证书路径，退款、红包等需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_client' => '',

        // 客户端秘钥路径，退款、红包等需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_key' => '',

        // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
        'log' => [
            'file' => storage_path('logs/wechat.log'),
            //     'level' => 'debug'
        ],

        // optional
        // 'dev' 时为沙箱模式
        // 'hk' 时为东南亚节点
        // 'mode' => 'dev',
    ],
];
