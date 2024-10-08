<?php

defined("_JEXEC") or die;

JHtml::_('jquery.framework');

$doc = JFactory::getDocument();

$doc->addStyleSheet(JURI::base() . "./modules/mod_artistas/css/main.css");
$doc->addScript(JURI::base() . "./modules/mod_artistas/js/main.js", "text/javascript");

//$idCategoria=$params['categoria'];
require_once __DIR__ . "/../helper.php";

//Obtiene los parametros pasados por el metodo
$list = modArtistas::getArticulos($params);
$list_main = modArtistas::getArticulos($params, 'main');
$list_alternative = modArtistas::getArticulos($params, 'alternative');
$mostrar_titulo = $params['mostrar_titulo'];

$res = array();

?>

<div class='artist-wrapper'>

    <?php
    if (!empty($list_main)) {
        echo "
    <h2 class='artist_section_title'>Main Floor</h2>
    <div>
    ";
        $i = 0;
        foreach ($list_main as $item) {
            write_item($item, $i, $mostrar_titulo);
            $i++;
        }
    }
    echo "</div>";
    ?>


    <?php
    if (!empty($list_alternative)) {
        echo "
    <h2 class='artist_section_title'>Alternative Floor</h2>
    <div>
    ";
        $i = 0;
        foreach ($list_main as $item) {
            write_item($item, $i, $mostrar_titulo);
            $i++;
        }
    }
    echo "</div>";
    ?>



</div>

<div id='artist-overlay' class='artist-overlay invisible'>
    <div id='artist-overlay-inner' class='artist-overlay__inner'>

    </div>
    <div class='artist-overlay__btn' onclick='cerrarOverlay()'>X</div>
</div>

<?php
function write_item($item, $index, $mostrar_titulo = true)
{
    $aux = json_decode($item->images);
    $res[$index]["titulo"] = $item->title;
    $res[$index]["intro"] = $aux->image_intro;
    $res[$index]["imagen"] = $aux->image_fulltext;
    $res[$index]["fulltext"] = $item->fulltext;
?>
    <div class="artist-item">
        <img
            id='artist-item-image-<?= $index ?>'
            class="artist-item__image"
            src='<?= JURI::base() . $res[$index]["intro"] ?>'
            onclick='showArtist(<?= $index ?>)' />
        <h3 class="artist-item__title">
            <?php
            if ($mostrar_titulo) {
                echo "<h3 class='artist-item__title'>" . strtoupper($item->title) . "</h3>";
            }
            ?>
        </h3>
    </div>
    <div
        id='artist-item-page-<?= $index ?>'
        class='artist-item-page invisible'>

        <img src='/<?= $res[$index]["imagen"] ?>' alt='<?= $item->title ?>' />
        <?= $res[$index]["fulltext"] ?>
    </div>

<?php
}
?>