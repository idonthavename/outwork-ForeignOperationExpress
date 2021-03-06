<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages.
    |
    */

    'captcha'                  => ':attribute 不正确，请重新输入。',
    'accepted'             => ':attribute 必须接受。',
    'active_url'           => ':attribute 不是一个有效的网址。',
    'after'                => ':attribute 必须要晚于 :date。',
    'after_or_equal'       => ':attribute 必须要等于 :date 或更晚。',
    'alpha'                => ':attribute 只能由字母组成。',
    'alpha_dash'           => ':attribute 只能由字母、数字和斜杠组成。',
    'alpha_num'            => ':attribute 只能由字母和数字组成。',
    'array'                => ':attribute 必须是一个数组。',
    'before'               => ':attribute 必须要早于 :date。',
    'before_or_equal'      => ':attribute 必须要等于 :date 或更早。',
    'between'              => [
        'numeric' => ':attribute 必须介于 :min - :max 之间。',
        'file'    => ':attribute 必须介于 :min - :max KB 之间。',
        'string'  => ':attribute 必须介于 :min - :max 个字符之间。',
        'array'   => ':attribute 必须只有 :min - :max 个单元。',
    ],
    'boolean'              => ':attribute 必须为布尔值。',
    'confirmed'            => ':attribute 两次输入不一致。',
    'date'                 => ':attribute 不是一个有效的日期。',
    'date_format'          => ':attribute 的格式必须为 :format。',
    'different'            => ':attribute 和 :other 必须不同。',
    'digits'               => ':attribute 必须是 :digits 位的数字。',
    'digits_between'       => ':attribute 必须是介于 :min 和 :max 位的数字。',
    'dimensions'           => ':attribute 图片尺寸不正确。',
    'distinct'             => ':attribute 已经存在。',
    'email'                => ':attribute 不是一个合法的邮箱。',
    'exists'               => ':attribute 不存在。',
    'file'                 => ':attribute 必须是文件。',
    'filled'               => ':attribute 不能为空。',
    'gt'                   => [
        'numeric' => ':attribute 必须大于 :value。',
        'file'    => ':attribute 必须大于 :value KB。',
        'string'  => ':attribute 必须多于 :value 个字符。',
        'array'   => ':attribute 必须多于 :value 个元素。',
    ],
    'gte'                  => [
        'numeric' => ':attribute 必须大于或等于 :value。',
        'file'    => ':attribute 必须大于或等于 :value KB。',
        'string'  => ':attribute 必须多于或等于 :value 个字符。',
        'array'   => ':attribute 必须多于或等于 :value 个元素。',
    ],
    'image'                => ':attribute 必须是图片。',
    'in'                   => '已选的属性 :attribute 非法。',
    'in_array'             => ':attribute 没有在 :other 中。',
    'integer'              => ':attribute 必须是整数。',
    'ip'                   => ':attribute 必须是有效的 IP 地址。',
    'ipv4'                 => ':attribute 必须是有效的 IPv4 地址。',
    'ipv6'                 => ':attribute 必须是有效的 IPv6 地址。',
    'json'                 => ':attribute 必须是正确的 JSON 格式。',
    'lt'                   => [
        'numeric' => ':attribute 必须小于 :value。',
        'file'    => ':attribute 必须小于 :value KB。',
        'string'  => ':attribute 必须少于 :value 个字符。',
        'array'   => ':attribute 必须少于 :value 个元素。',
    ],
    'lte'                  => [
        'numeric' => ':attribute 必须小于或等于 :value。',
        'file'    => ':attribute 必须小于或等于 :value KB。',
        'string'  => ':attribute 必须少于或等于 :value 个字符。',
        'array'   => ':attribute 必须少于或等于 :value 个元素。',
    ],
    'max'                  => [
        'numeric' => ':attribute 不能大于 :max。',
        'file'    => ':attribute 不能大于 :max KB。',
        'string'  => ':attribute 不能大于 :max 个字符。',
        'array'   => ':attribute 最多只有 :max 个单元。',
    ],
    'mimes'                => ':attribute 必须是一个 :values 类型的文件。',
    'mimetypes'            => ':attribute 必须是一个 :values 类型的文件。',
    'min'                  => [
        'numeric' => ':attribute 必须大于等于 :min。',
        'file'    => ':attribute 大小不能小于 :min KB。',
        'string'  => ':attribute 至少为 :min 个字符。',
        'array'   => ':attribute 至少有 :min 个单元。',
    ],
    'not_in'               => '已选的属性 :attribute 非法。',
    'not_regex'            => ':attribute 的格式错误。',
    'numeric'              => ':attribute 必须是一个数字。',
    'present'              => ':attribute 必须存在。',
    'regex'                => ':attribute 格式不正确。',
    'required'             => ':attribute 不能为空。',
    'required_if'          => '当 :other 为 :value 时 :attribute 不能为空。',
    'required_unless'      => '当 :other 不为 :value 时 :attribute 不能为空。',
    'required_with'        => '当 :values 存在时 :attribute 不能为空。',
    'required_with_all'    => '当 :values 存在时 :attribute 不能为空。',
    'required_without'     => '当 :values 不存在时 :attribute 不能为空。',
    'required_without_all' => '当 :values 都不存在时 :attribute 不能为空。',
    'same'                 => ':attribute 和 :other 必须相同。',
    'size'                 => [
        'numeric' => ':attribute 大小必须为 :size。',
        'file'    => ':attribute 大小必须为 :size KB。',
        'string'  => ':attribute 必须是 :size 个字符。',
        'array'   => ':attribute 必须为 :size 个单元。',
    ],
    'string'               => ':attribute 必须是一个字符串。',
    'timezone'             => ':attribute 必须是一个合法的时区值。',
    'unique'               => ':attribute 已经存在。',
    'uploaded'             => ':attribute 上传失败。',
    'url'                  => ':attribute 格式不正确。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention 'attribute.rule' to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of 'email'. This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name'                  => '名称',
        'username'              => '用户名',
        'email'                 => '邮箱',
        'first_name'            => '名',
        'last_name'             => '姓',
        'password'              => '密码',
        'password_confirmation' => '确认密码',
        'city'                  => '城市',
        'country'               => '国家',
        'address'               => '地址',
        'province'               => '省份',
        'town'               => '市、县、区',
        'phone'                 => '电话',
        'mobile'                => '手机',
        'age'                   => '年龄',
        'sex'                   => '性别',
        'gender'                => '性别',
        'day'                   => '天',
        'month'                 => '月',
        'year'                  => '年',
        'hour'                  => '时',
        'minute'                => '分',
        'second'                => '秒',
        'title'                 => '标题',
        'content'               => '内容',
        'description'           => '描述',
        'excerpt'               => '摘要',
        'date'                  => '日期',
        'time'                  => '时间',
        'available'             => '可用的',
        'size'                  => '大小',
        'verifycode'           => '验证码',
        'xing'                     => '姓',
        'ming'                    => '名',

        'sender_xing' => '姓',
        'sender_ming' => '名',
        'sender_city' => '州',
        'sender_area' => '市',
        'sender_paperType' => '证件信息',
        'sender_paperNo' => '证件号',
        'sender_quitAddress' => '发件国退件地址',
        'sender_quitCode' => '退件邮编',
        'sender_phone' => '手机',

        'receive_country' => '所在国家',
        'receive_name' => '姓名',
        'receive_address' => '详细地址',
        'receive_code' => '邮编',
        'receive_phone' => '手机',
        'sfz'=>'身份证/驾照/护照',

        'company_city' => '州',
        'company_area' => '市',
        'company_name' => '公司名称',
        'company_address' => '公司注册地址',
        'company_delegate' => '公司代表人',
        'company_yy' => '营业执照编号',
        'company_sh' => '税号',
        'company_quitAddress' => '发件因退件地址',
        'company_quitCode' => '退件邮编',
        'company_phone' => '手机',
        'company_contact' => '联系人',

        'oldpassword'=>'当前密码',
        'newpassword'=>'新密码',
        'newpassword_confirmation'=>'确认新密码',

        'category_one'=>'产品一级类别',
        'category_two'=>'产品二级类别',
        'brand'=>'品牌',
        'detail'=>'物品名称',
        'price'=>'单价',
        'catname'=>'规格',
        'amount'=>'数量',
        'remark'=>'备注',

        'id_card_front'=>'身份证国徽面',
        'id_card_back'=>'身份证头像面',

        'depot'=>'仓库',
        'addons'=>'附加服务',
        'user_order_no'=>'外部单号',
        's_name'=>'寄件人姓名',
        's_phone' => '寄件人电话',
        's_country' => '寄件人所属国',
        's_province' => '寄件人州',
        's_city' => '寄件人市',
        's_address' => '寄件人详细地址',
        's_code' => '寄件人邮编',

        'r_name'=>'收件人姓名',
        'r_phone' => '收件人电话',
        'r_cre_type' => '收件人证件类型',
        'r_cre_num' => '收件人身份证号码',
        'r_addressDetail' => '收件人详细地址',
        'r_province' => '收件人省份',
        'r_city' => '收件人市',
        'r_town' => '收件人区',
        'r_code' => '收件人邮编',

        'user_identification'=>'用户代码',

        'express_no'=>'快递单号',
    ],
];
