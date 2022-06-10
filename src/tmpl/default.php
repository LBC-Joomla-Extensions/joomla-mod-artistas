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

echo "<div class='artist-outer-wrapper'>";
echo "<div class='artist-title'><h3 class='artist-title-text'>Headliners</h3></div>";
echo "<div class='artist-inner-wrapper'>";
$i=0;
foreach($list as $l){    
    $aux=json_decode($l->images);
    $res[$i]["titulo"]=$l->title;
    $res[$i]["imagen"]=$aux->image_intro;
    $res[$i]["fulltext"]=$l->fulltext;

    echo "<div class='artist-item'>";
    echo "<img id='artist-item-image-" . $i . "' class='artist-item-image' src='" . JURI::base() . $res[$i]["imagen"] . "' onclick='showArtist(" . $i . ")'/>";
    echo "</div>";

    echo "<div id='artist-item-page-" . $i . "' class='artist-item-page invisible'>" . $res[$i]["fulltext"] . "</div>";

    $i++;
}

echo "</div>
    </div>";

/*
echo "<div class='artist-full-lineup-wrapper'>
        <img class='artist-full-lineup-imagen' src='" . JURI::base() . "./images/2020/modulos/lineup.jpg' />
    </div>";
*/
echo "<div id='artist-overlay' class='artist-overlay invisible'>
        <div id='artist-overlay-inner'> 
        
        </div>
        <div class='artist-overlay-btn-cerrar' onclick='cerrarOverlay()'>X</div>
    </div>";
?>
