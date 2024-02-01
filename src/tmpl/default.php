<?php

defined("_JEXEC") or die;

JHtml::_('jquery.framework');

$doc=JFactory::getDocument();

$doc->addStyleSheet(JURI::base() . "./modules/mod_artistas/css/main.css");
$doc->addScript(JURI::base() . "./modules/mod_artistas/js/main.js","text/javascript");

//$idCategoria=$params['categoria'];
require_once __DIR__ . "/../helper.php";

//Obtiene los parametros pasados por el metodo
$list=modArtistas::getArticulos($params);
$list_main = modArtistas::getArticulos($params,'main');
$list_alternative = modArtistas::getArticulos($params, 'alternative');
$res=array();

?>

<div class='artist-wrapper'>

<?php
/*
$i=0;
foreach($list as $item){ 
    $aux=json_decode($item->images);
    $res[$i]["titulo"]=$item->title;
    $res[$i]["intro"]=$aux->image_intro;
    $res[$i]["imagen"]=$aux->image_fulltext;
    $res[$i]["fulltext"]=$item->fulltext;
//?>
        <div class="artist-item">
            <img 
                id='artist-item-image-<?= $i ?>'
                class="artist-item__image"
                src='<?= JURI::base() . $res[$i]["intro"] ?>'
                onclick='showArtist(<?= $i ?>)'
            />
            <h3 class="artist-item__title"> <?= strtoupper($item->title) ?></h3>
        </div>
        <div 
            id='artist-item-page-<?= $i ?>' 
            class='artist-item-page invisible'>

            <img src='/<?= $res[$i]["imagen"] ?>' alt='<?= $item->title ?>'/>
            <?= $res[$i]["fulltext"] ?>
        </div>
<?php
    $i++;
}
*/
?>

<h2 class='artist_section_title'>Main Floor</h2>
<div>
<?php

$i = 0;
foreach($list_main as $item){ 
    write_item($item, $i);
    $i++;
}
?>
</div>
<h2 class='artist_section_title'>Alternative Floor</h2>
<div>
<?php

foreach($list_alternative as $item){ 
    write_item($item, $i);
    $i++;
}
?>
</div>

</div>

<div id='artist-overlay' class='artist-overlay invisible'>
    <div id='artist-overlay-inner' class='artist-overlay__inner'> 
    
    </div>
    <div class='artist-overlay__btn' onclick='cerrarOverlay()'>X</div>
</div>

<?php
function write_item($item, $index){
    $aux=json_decode($item->images);
    $res[$index]["titulo"]=$item->title;
    $res[$index]["intro"]=$aux->image_intro;
    $res[$index]["imagen"]=$aux->image_fulltext;
    $res[$index]["fulltext"]=$item->fulltext;
?>
        <div class="artist-item">
            <img 
                id='artist-item-image-<?= $index ?>'
                class="artist-item__image"
                src='<?= JURI::base() . $res[$index]["intro"] ?>'
                onclick='showArtist(<?= $index ?>)'
            />
            <h3 class="artist-item__title"> <?= strtoupper($item->title) ?></h3>
        </div>
        <div 
            id='artist-item-page-<?= $index ?>' 
            class='artist-item-page invisible'>

            <img src='/<?= $res[$index]["imagen"] ?>' alt='<?= $item->title ?>'/>
            <?= $res[$index]["fulltext"] ?>
        </div>

<?php
}
?>