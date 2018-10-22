<?php
return array
(
    'contents' => [
        'title-1'    => '喜豆码详情',
        'title-2'    => '喜豆码列表',
        'package' => [
          'title' => '喜豆码详情',
          'code'  => '喜豆码编码',
          'type' => '码类型',
          'startNo' => '起始编号',
          'endNo' => '终止编号',
          'status' => '状态',
          'totalQnt' => '总码数',
          'usedCnt' => '已用码数',
          'purchaseDate' => '支付日期',
          'activatedDate' => '激活日期',
          'activated' => '已激活',
          'inactivated' => '未激活',
          'multi'       => '多次码',
          'single'      => '单次码',
        ]
    ],
    'table' => [
        'header' => [
            'no'             => 'No',
            'codeNo'         => '喜豆码编码',
            'activated_date'      => '激活日期',
            'used_date'      => '使用日期',
            'status'         => '状态',
        ],
        'pagination' => [
            'prev' => '上一页',
            'next' => '下一页'
        ],
        'no_data' => '尚无数据',
        'search'  => '搜索',
        'status' => [
            'all'       => '所有',
            'used' => '已使用',
            'activated' => '已激活',
            'registered' => '已注册'
        ],
    ],
    'button' => [
        'activation' => '激活',
        'list' => '返回列表'
    ],
    'message' => [
        'activationSuccess'   => '激活成功',
        'requestErr'          => '请求参数错误',
        'serverErr'           => '服务器错误'
    ]
);