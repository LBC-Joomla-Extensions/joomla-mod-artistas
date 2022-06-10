<?php
defined("_JEXEC") or die;

//Cargar fichero helper.php
require_once __DIR__ . "/helper.php";

//Obtiene los parametros pasados por el metodo
$list=modArtistas::getArticulos($params);

//Cargar la vista por defecto del módulo
require JModuleHelper::getLayoutPath("mod_artistas");
?>