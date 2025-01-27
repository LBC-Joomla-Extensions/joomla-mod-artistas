<?php

defined("_JEXEC") or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Application\WebApplication;
use Joomla\CMS\Uri\Uri;

/** @var WebApplication */
$app = Factory::getApplication();
$wa = $app->getDocument()->getWebAssetManager();


// Registrar y utilizar la hoja de estilo
$wa->registerAndUseStyle('mod_artistas_main_css', Uri::root() . 'modules/mod_artistas/css/main.css');

// Registrar y utilizar el script
$wa->registerAndUseScript('mod_artistas_main_js', Uri::root() . 'modules/mod_artistas/js/main.js', [], ['type' => 'text/javascript']);



//$idCategoria=$params['categoria'];
require_once __DIR__ . "/../helper.php";

//Obtiene los parametros pasados por el metodo
$list = modArtistas::getArticulos($params);
$list_main = modArtistas::getArticulos($params, 'main');
$list_alternative = modArtistas::getArticulos($params, 'alternative');
$mostrar_titulo = $params['mostrar_titulo'];
$mostrar_lineup_texto = $params['mostrar_lineup_texto'];
$bloques_texto_lineup = $params['lineup_blocks'];
$separador = $params['separador_lineup_blocks'];

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
        foreach ($list_alternative as $item) {
            write_item($item, $i, $mostrar_titulo);
            $i++;
        }
    }
    echo "</div>";
    ?>

    <?php
    if ($mostrar_lineup_texto == 1) {
        echo "<div class='artist_lineup_text'>";

        $alternativo = false;

        foreach ($bloques_texto_lineup as $key => $bloque) {
            $contenido = $bloque->bloque_lineup->bloque_lineup_contenido;
            $lineup = explode(",", $contenido);
            $last_in_lineup = trim(end($lineup));

            echo "<div class='artist_lineup_text__bloque'><p>";

            foreach ($lineup as $key => $value) {
                $class_span = "artist_lineup_text__artista";
                $value = trim($value);

                if ($alternativo) {
                    $class_span .= " artist_lineup_text__artista--alt";
                }

                $alternativo = !$alternativo;

                echo "<span class='{$class_span}'>{$value}</span>";

                if ($value != $last_in_lineup) {
                    echo " {$separador} ";
                }
            }

            echo "</p></div>";
        }
        echo "
        </div>
        ";
    }
    ?>

</div>



<div id='artist-overlay' class='artist-overlay invisible'>
    <div id='artist-overlay-inner' class='artist-overlay__inner'>

    </div>
    <div class='artist-overlay__btn'>X</div>
</div>

<script>
    // Escuchar el evento 'keydown' en todo el documento
    document.addEventListener('keydown', function(event) {
        // Verificar si la tecla presionada es 'Escape' (o 'Esc')
        if (event.key === 'Escape' || event.key === 'Esc') {
            // Llamar a la función para cerrar el overlay
            cerrarOverlay();
        }
    });
</script>

<script>
    // Selecciona el overlay y su contenido interno
    var overlay = document.getElementById('artist-overlay');
    var overlayInner = document.getElementById('artist-overlay-inner');

    // Agrega un event listener al overlay
    overlay.addEventListener('click', function(event) {
        // Verifica si el clic fue en el overlay y no en su contenido interno
        if (event.target === overlay) {
            cerrarOverlay();
        }
    });

    // Selecciona el botón de cierre
    var closeButton = document.querySelector('.artist-overlay__btn');

    // Agrega un event listener al botón
    closeButton.addEventListener('click', function() {
        cerrarOverlay();
    });
</script>

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
            src='<?= Uri::root() . $res[$index]["intro"] ?>'
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