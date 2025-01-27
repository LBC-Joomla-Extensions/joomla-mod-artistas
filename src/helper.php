
<?php
/*Este archivo puede considerarse el modelo (MVC) del módulo*/

defined("_JEXEC") or die;

require_once __DIR__ . "/vendor/autoload.php";

use Joomla\CMS\Factory;
use Joomla\Database\DatabaseInterface;

class modArtistas
{


    public static function getArticulos(&$params, $categoria = "")
    {
        $db = Factory::getContainer()->get(DatabaseInterface::class);

        switch ($categoria) {
            case 'main':
                $id = $params["categoria_main"];
                break;
            case 'alternative':
                $id = $params["categoria_alternative"];
                break;
            default:
                $id = $params["categoria"];
                break;
        }

        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__content');
        $query->where('catid="' . $id . '" AND (language="' . Factory::getApplication()->getLanguage()->getTag() . '" OR language="*") AND state="1"');
        $query->order('title asc');

        $db->setQuery((string)$query);
        $res = $db->loadObjectList();

        return $res;
    }
}
?>