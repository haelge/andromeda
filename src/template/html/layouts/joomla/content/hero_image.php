<?php

/**
 * @package     Andromeda
 * @subpackage  carousel
 *
 * @copyright   (C) 2024 Helge Lente <h.lente@gmx.net>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

$params  = $displayData->params;
$images  = json_decode($displayData->images);

if (empty($images->image_intro)) {
    return;
}

$imgclass   = empty($images->float_intro) ? $params->get('float_intro') : $images->float_intro;
$layoutAttr = [
    'src' => $images->image_intro,
    'alt' => empty($images->image_intro_alt) && empty($images->image_intro_alt_empty) ? false : $images->image_intro_alt,
    'class' => 'd-block w-100 '.$imgclass,
];

echo LayoutHelper::render('joomla.html.image', $layoutAttr); ?>

