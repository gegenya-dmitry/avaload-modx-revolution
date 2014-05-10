<?php
 function getChunksContent($filename) {
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php','?>'),'',$o));
    return $o;
}

$chanks = array();
/* course chanks */
$chanks[1]= $modx->newObject('modChunk');
$chanks[1]->fromArray(array(
    'name' => 'AvaloadAjax',
    'description' => 'Form for loads Avatars',
	'source'=>1,
	'static'=>1,
	'static_file'=>$sources['url_assets'].'/avaloadAjax.tpl',
	'snippet' => getChunksContent($sources['source_assets'].'/avaloadAjax.tpl'),
),'',true,true);

return $chanks;