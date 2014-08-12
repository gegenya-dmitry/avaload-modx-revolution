<?php

/*
 * @package modxRepository
 * @subpackage build
 * @author Fi1osof
 * http://community.modx-cms.ru/profile/Fi1osof/
 * http://modxstore.ru
 */
global  $modx, $sources;
$settings = array();

$settings['avaload_height'] = $modx->newObject('modSystemSetting');
$settings['avaload_height']->fromArray(array(
    'key' => 'avaload_height',
    'value' => '160',
    'xtype' => 'textfield',
    'namespace' => 'avaload',
    'area' => '',
	'desc'=>'Высота аватары',
),'',true,true);

$settings['avaload_width'] = $modx->newObject('modSystemSetting');
$settings['avaload_width']->fromArray(array(
    'key' => 'avaload_width',
    'value' => '160',
    'xtype' => 'textfield',
    'namespace' => 'avaload',
    'area' => '',
	'desc'=>'Ширина аватары',
),'',true,true);

$settings['avaload_max_filesizes'] = $modx->newObject('modSystemSetting');
$settings['avaload_max_filesizes']->fromArray(array(
    'key' => 'avaload_max_filesizes',
    'value' => '2048000',
    'xtype' => 'textfield',
    'namespace' => 'avaload',
    'area' => '',
	'desc'=>'Максимальный размер исходного файла для загрузки',
),'',true,true);

$settings['avaload_output_format'] = $modx->newObject('modSystemSetting');
$settings['avaload_output_format']->fromArray(array(
    'key' => 'avaload_output_format',
    'value' => 'jpg',
    'xtype' => 'textfield',
    'namespace' => 'avaload',
    'area' => '',
	'desc'=>'Формат файла аватары',
),'',true,true);

$settings['avaload_quality'] = $modx->newObject('modSystemSetting');
$settings['avaload_quality']->fromArray(array(
    'key' => 'avaload_quality',
    'value' => '95',
    'xtype' => 'textfield',
    'namespace' => 'avaload',
    'area' => '',
	'desc'=>'Качество аватары',
),'',true,true);

$settings['avaload_true_types'] = $modx->newObject('modSystemSetting');
$settings['avaload_true_types']->fromArray(array(
    'key' => 'avaload_true_types',
    'value' => 'jpg,bmp,gif',
    'xtype' => 'textfield',
    'namespace' => 'avaload',
    'area' => '',
	'desc'=>'Разрешенные типы файлов для загрузки',
),'',true,true);

$settings['avaload_zc'] = $modx->newObject('modSystemSetting');
$settings['avaload_zc']->fromArray(array(
    'key' => 'avaload_zc',
    'value' => '1',
    'xtype' => 'combo-boolean',
    'namespace' => 'avaload',
    'area' => '',
	'desc'=>'Включить зум и кроп аватара',
),'',true,true);

$settings['avaload_image_patch'] = $modx->newObject('modSystemSetting');
$settings['avaload_image_patch']->fromArray(array(
    'key' => 'avaload_image_patch',
    'value' => '{assets_path}avaloadimg/',
    'xtype' => 'textfield',
    'namespace' => 'avaload',
    'area' => '',
	'desc'=>'Путь где будут храниться аватары пользователя',
),'',true,true);

$settings['avaload_url_patch'] = $modx->newObject('modSystemSetting');
$settings['avaload_url_patch']->fromArray(array(
    'key' => 'avaload_url_patch',
    'value' => '/assets/avaloadimg/',
    'xtype' => 'textfield',
    'namespace' => 'avaload',
    'area' => '',
	'desc'=>'Путь к каталогу с аватарами',
),'',true,true);


 
return $settings;