<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.cassiopeia
 *
 * @copyright   (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app   = Factory::getApplication();
$input = $app->getInput();
$wa    = $this->getWebAssetManager();

// Browsers support SVG favicons
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon.svg', '', [], true, 1), 'icon', 'rel', ['type' => 'image/svg+xml']);
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'alternate icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon-pinned.svg', '', [], true, 1), 'mask-icon', 'rel', ['color' => '#000']);

// Detecting Active Variables
$option   = $input->getCmd('option', '');
$view     = $input->getCmd('view', '');
$layout   = $input->getCmd('layout', '');
$task     = $input->getCmd('task', '');
$itemid   = $input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

// Color Theme
$paramsColorName = $this->params->get('colorName', 'colors_standard');
$assetColorName  = 'theme.' . $paramsColorName;

// Enable assets
$wa->usePreset('template.cassiopeia.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr'))
    ->useStyle('template.active.language')
    ->registerAndUseStyle($assetColorName, 'global/' . $paramsColorName . '.css')
    ->useStyle('template.user')
    ->useScript('template.user')
    ->useScript('andromeda')
    ->addInlineStyle(":root {
		--hue: 214;
		--template-bg-light: #f0f4fb;
		--template-text-dark: #495057;
		--template-text-light: #ffffff;
		--template-link-color: var(--link-color);
		--template-special-color: #001B4C;
	}");

// Override 'template.active' asset to set correct ltr/rtl dependency
$wa->registerStyle('template.active', '', [], [], ['template.cassiopeia.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr')]);

// Logo file or site title param
if ($this->params->get('logoFile')) {
    $logo = HTMLHelper::_('image', Uri::root(false) . htmlspecialchars($this->params->get('logoFile'), ENT_QUOTES), $sitename, ['class' => 'logo', 'loading' => 'eager', 'decoding' => 'async'], false, 0);
} elseif ($this->params->get('siteTitle')) {
    $logo = '<span title="' . $sitename . '">' . htmlspecialchars($this->params->get('siteTitle'), ENT_COMPAT, 'UTF-8') . '</span>';
} else {
    $logo = HTMLHelper::_('image', 'logo.svg', $sitename, ['class' => 'logo d-inline-block', 'loading' => 'eager', 'decoding' => 'async'], true, 0);
}

$hasClass = '';

if ($this->countModules('sidebar-left', true)) {            
    $hasClass .= ' has-sidebar-left';
}

if ($this->countModules('sidebar-right', true)) {
    $hasClass .= ' has-sidebar-right';
}

// Container
$wrapper = $this->params->get('fluidContainer') ? 'wrapper-fluid' : 'wrapper-static';

$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

$stickyHeader = $this->params->get('stickyHeader') ? 'container-header_sticky' : '';

$stickyPositions = $this->params->get('stickyPositions') ? 'container-header_sticky--topbar' : 'container-header_sticky--menu ';

// Defer fontawesome for increased performance. Once the page is loaded javascript changes it to a stylesheet.
$wa->getAsset('style', 'fontawesome');

//HTMLHelper::_('bootstrap.collapse');

?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />
</head>

<body class="site <?php echo $option
    . ' ' . $wrapper
    . ' view-' . $view
    . ($layout ? ' layout-' . $layout : ' no-layout')
    . ($task ? ' task-' . $task : ' no-task')
    . ($itemid ? ' itemid-' . $itemid : '')
    . ($pageclass ? ' ' . $pageclass : '')
    . $hasClass
    . ($this->direction == 'rtl' ? ' rtl' : '');
?>">
    <header class="header container-header <?php echo $stickyHeader?> <?php echo $stickyPositions?> full-width">
    <a href="#main-content" class="content-shortcut"><?php echo Text::_('TPL_ANDROMEDA_CONTENT_SHORTCUT')?></a>

        <?php if ($this->countModules('topbar')) : ?>
            <div class="grid-child container-topbar">
                <jdoc:include type="modules" name="topbar" style="none" />
            </div>
        <?php endif; ?>
        <nav class="navbar navbar-expand-lg bg-light" aria-label="<?php echo Text::_('TPL_ANDROMEDA_MAIN_MENU')?>">
            <div class="grid-child container-nav">
                <?php if ($this->params->get('brand', 1)) : ?>
                    <a class="navbar-brand" href="<?php echo $this->baseurl; ?>/">
                        <?php echo $logo; ?>
                    </a> 
                <?php endif; ?>

                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-main" aria-controls="navbar-main" aria-expanded="false" aria-label="TRANSLATE_ME:toggle">
                    <span class="icon-menu" aria-hidden="true"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar-main">
                    <?php if ($this->countModules('menu', true) || $this->countModules('search', true)) : ?>
                        <div class="grid-child container-nav">
                            <?php if ($this->countModules('menu', true)) : ?>
                                <jdoc:include type="modules" name="menu" style="none" />
                            <?php endif; ?>
                            <?php if ($this->countModules('search', true)) : ?>
                                <div class="container-search">
                                    <jdoc:include type="modules" name="search" style="none" />
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </nav>
    </header>

    <div id="main-content" class="site-grid">
        <?php if ($this->countModules('banner', true)) : ?>
            <div class="container-banner full-width">
                <jdoc:include type="modules" name="banner" style="none" />
            </div>
        <?php endif; ?>

        <?php if ($this->countModules('top-a', true)) : ?>
            <div class="grid-child container-top-a">
                <jdoc:include type="modules" name="top-a" style="none" />
            </div>
        <?php endif; ?>

        <?php if ($this->countModules('top-b', true)) : ?>
            <div class="full-width background background-grey">
                <div class="grid-child container-top-b">
                    <jdoc:include type="modules" name="top-b" style="fullsizedBackground" />
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->countModules('sidebar-left', true)) : ?>
            <div class="grid-child container-sidebar-left d-none d-lg-flex">
                <jdoc:include type="modules" name="sidebar-left" style="card" />
            </div>
        <?php endif; ?>

        <div class="grid-child container-component">
            <jdoc:include type="modules" name="breadcrumbs" style="none" />
            <jdoc:include type="modules" name="main-top" style="card" />
            <jdoc:include type="message" />
            <main>
                <jdoc:include type="component" />
            </main>
            <jdoc:include type="modules" name="main-bottom" style="card" />
        </div>

        <?php if ($this->countModules('sidebar-right', true)) : ?>
            <div class="grid-child container-sidebar-right">
                <jdoc:include type="modules" name="sidebar-right" style="card" />
            </div>
        <?php endif; ?>

        <?php if ($this->countModules('bottom-a', true)) : ?>
            <div class="full-width background background-grey">
                <div class="grid-child container-bottom-a">
                    <jdoc:include type="modules" name="bottom-a" style="card" />
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->countModules('bottom-b', true)) : ?>
            <div class="full-width background background-blue">
                <div class="grid-child container-bottom-b">
                    <jdoc:include type="modules" name="bottom-b" style="card" />
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($this->countModules('footer', true)) : ?>
        <footer class="container-footer footer full-width">
            <div class="grid-child">
                <jdoc:include type="modules" name="footer" style="none" />
            </div>
        </footer>
    <?php endif; ?>

    <?php if ($this->params->get('backTop') == 1) : ?>
        <a href="#top" id="back-top" class="back-to-top-link" aria-label="<?php echo Text::_('TPL_CASSIOPEIA_BACKTOTOP'); ?>">
            <span class="icon-arrow-up icon-fw" aria-hidden="true"></span>
        </a>
    <?php endif; ?>

    <jdoc:include type="modules" name="debug" style="none" />
</body>

</html>
