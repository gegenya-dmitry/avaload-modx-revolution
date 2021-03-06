﻿﻿<?php
/**
 * @title avaload
 * @copyright Дмитрий Гегеня http://progroup.by
 */

require_once $_SERVER["DOCUMENT_ROOT"].'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
include_once MODX_CORE_PATH . 'model/modx/modx.class.php';

function getTrueImageTypes($file,$true_types) {
	if(!$data = getimagesize($file)) return false;

	$extensions = array(1 => 'gif', 2 => 'jpeg',
						3 => 'png', 4 => 'swf',
						5 => 'psd', 6 => 'bmp',
						7 => 'tiff', 8 => 'tiff',
						9 => 'jpc', 10 => 'jp2',
						11 => 'jpx', 12 => 'jb2',
						13 => 'swc', 14 => 'iff',
						15 => 'wbmp', 16 => 'xbmp');

	$result = array('width' => $data[0],
					'height' => $data[1],
					'extension' => $extensions[$data[2]],
					'mime' => $data['mime']);

	return in_array($result['extension'], $true_types);
} 


function avaLoad() {
	$modx = new Modx();
	$modx->initialize('web');
	$modx->lexicon->load('avaload:default');
    //load defaul parameters
    $avaload_height         = $modx->getOption('avaload_height',null,120);
    $avaload_image_patch    = $modx->getOption('avaload_image_patch',null,'{assets_path}avaloadimg/');
    $avaload_true_types     = $modx->getOption('avaload_true_types',null,'jpg,bmp,png');
    $avaload_max_filesizes  = $modx->getOption('avaload_max_filesizes',null,2048000);
    $avaload_output_format  = $modx->getOption('avaload_output_format',null,'jpg');
    $avaload_quality        = $modx->getOption('avaload_quality',null,75);
    $avaload_url_patch      = $modx->getOption('avaload_url_patch',null,'/assets/avaloadimg/');
    $avaload_width          = $modx->getOption('avaload_width',null,120);
    $avaload_zc             = $modx->getOption('avaload_zc',null,1);

	$return_message =array();
	if(!$modx->user->isAuthenticated()){
		$return_message=array(0,'Эта операция запрещена неавторизованным пользователям.','');
		$modx->log(modX::LOG_LEVEL_ERROR,'[avaload] Попытка неавторизированной загрузки файла.');
	}
	else {
	  if(($_FILES['avaloadImage']['size'] == 0)||(!file_exists($_FILES['avaloadImage']['tmp_name']))) {
		  $return_message = array(0,'Файл не был загружен.','');
		  $modx->log(modX::LOG_LEVEL_ERROR,'[avaload] UserID: '.$modx->user->id.', Неудалось загрузить файл ');
	  }
	  elseif (!getTrueImageTypes($_FILES['avaloadImage']['tmp_name'],explode(',',$avaload_true_types))) {
			$return_message = array(0,'Загрузка файлов такого типа запрещена.','');
			$modx->log(modX::LOG_LEVEL_ERROR,'[avaload] UserID: '.$modx->user->id.', Попытка загрузить запрещенный файл '.$_FILES['avaloadImage']['name'].'.'.$_FILES['avaloadImage']['type'].' размер:'.$_FILES['avaloadImage']['size']);
	  }
	  elseif (!$modx->loadClass('modPhpThumb',$modx->getOption('core_path').'model/phpthumb/',true,true)) {
		  $modx->log(modX::LOG_LEVEL_ERROR,'[avaload] Не загружен класс modPhpThumb.');
		  $return_message = array(0,'Не загружен класс modPhpThumb','');
	  }
	  else {

        $avaOptions = array(
			  'zc'=> (int) $avaload_zc,
			  'h' => (int) $avaload_height,
			  'w' => (int) $avaload_width,
			  'q' => (int) $avaload_quality,
			  'f' => (string) $avaload_output_format,
			  'maxb' => (float) $avaload_max_filesizes,
		  );

		  $phpThumb = new modPhpThumb($modx);
		  $phpThumb->config = array_merge($phpThumb->config,$avaOptions);
		  $phpThumb->initialize();
		  $phpThumb->setParameter('config_allow_src_above_phpthumb',true);
		  $phpThumb->setParameter('allow_local_http_src',true);
		  $phpThumb->setParameter('config_allow_src_above_docroot',true);

		  foreach($avaOptions as $param=>$value) {
			  $phpThumb->setParameter($param,$value);
		  }

		  $phpThumb->setCacheDirectory();
		  $phpThumb->set($_FILES['avaloadImage']['tmp_name']);

		  if ($phpThumb->MaxFileSize()) {
			  $return_message = array(0,'Превышен допустимый размер файла','');
			  $modx->log(modX::LOG_LEVEL_ERROR,'[avaload] UserID: '.$modx->user->id.', Превышен допустимый размер файла '.$_FILES['avaloadImage']['name'].'.'.$_FILES['avaloadImage']['type'].' размер:'.$_FILES['avaloadImage']['size']);
			  
		  }
		  else {
			  $phpThumb->GenerateThumbnail();
			  $file_name = $modx->user->id.time().'.'.$avaOptions['f'];
			  $outputImage = $avaload_image_patch.$file_name;
			  $phpThumb->RenderToFile($outputImage);

			  $profile=$modx->user->getOne('Profile');
			  $old_ava = $profile->get('photo');
			  $profile->set('photo',$file_name);
			  $profile->save();
			  $errDelAva='';
			  if ($old_ava!='') 
				if(!unlink($avaload_image_patch.$old_ava))
					$errDelAva =' Старый аватар не был удален';

			  $return_message = array(1,'Аватар загружен.'.$errDelAva,$modx->getOption('avaload_url_patch').$file_name);
		  }
		}  
	}
	return json_encode($return_message);
}

echo avaLoad();
