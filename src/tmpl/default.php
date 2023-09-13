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
$res=array();

?>

<div class='artist-wrapper'>

<?php

$i=0;
foreach($list as $item){ 
    $aux=json_decode($item->images);
    $res[$i]["titulo"]=$item->title;
    $res[$i]["intro"]=$aux->image_intro;
    $res[$i]["imagen"]=$aux->image_fulltext;
    $res[$i]["fulltext"]=$item->fulltext;
?>
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
?>

</div>

<div id='artist-overlay' class='artist-overlay invisible'>
    <div id='artist-overlay-inner' class='artist-overlay__inner'> 
    
    </div>
    <div class='artist-overlay__btn' onclick='cerrarOverlay()'>X</div>
</div>
