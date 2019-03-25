<?php
/** @var modX $modx */
/** @var array $sources */

$settings = array();

$tmp = array(
    'tpl' => array(
        'xtype' => 'textfield',
        'value' => 'tpl.wrapYoutube',
        'area' => 'wrapyoutube_main',
    ),
    'front_css' => array(
        'xtype' => 'textfield',
        'value' => '[[++assets_url]]components/wrapyoutube/css/web/default.css',
        'area' => 'wrapyoutube_main',
    ),
    'front_js' => array(
        'xtype' => 'textfield',
        'value' => '[[++assets_url]]components/wrapyoutube/js/web/default.js',
        'area' => 'wrapyoutube_main',
    ),
    'excluded_templates' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'wrapyoutube_main',
    ),
);

foreach ($tmp as $k => $v) {
    /** @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(
        array(
            'key' => 'wrapyoutube_' . $k,
            'namespace' => PKG_NAME_LOWER,
        ), $v
    ), '', true, true);

    $settings[] = $setting;
}
unset($tmp);

return $settings;
