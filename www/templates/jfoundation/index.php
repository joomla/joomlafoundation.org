<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var JDocumentHtml $this */

$app  = JFactory::getApplication();
$user = JFactory::getUser();

// Output as HTML5
$this->setHtml5(true);

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');

if ($task === 'edit' || $layout === 'form')
{
	$fullWidth = 1;
}
else
{
	$fullWidth = 0;
}

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

// Add template js
JHtml::_('script', 'template.js', array('version' => 'auto', 'relative' => true));

// Add html5 shiv
JHtml::_('script', 'jui/html5.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));

// Add Stylesheets
JHtml::_('stylesheet', 'template.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'custom.css', array('version' => 'auto', 'relative' => true));

// Use of Google Font
if ($this->params->get('googleFont'))
{
	$font = $this->params->get('googleFontName');

	// Handle fonts with selected weights and styles, e.g. Source+Sans+Condensed:400,400i
	$fontStyle = str_replace('+', ' ', strstr($font, ':', true) ?: $font);

	JHtml::_('stylesheet', 'https://fonts.googleapis.com/css?family=' . $font);
	$this->addStyleDeclaration("
	h1, h2, h3, h4, h5, h6, .site-title {
		font-family: '" . $fontStyle . "', sans-serif;
	}");
}

// Check for a custom CSS file
JHtml::_('stylesheet', 'user.css', array('version' => 'auto', 'relative' => true));

// Check for a custom js file
JHtml::_('script', 'user.js', array('version' => 'auto', 'relative' => true));

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Adjusting content width
$position7ModuleCount = $this->countModules('position-7');
$position8ModuleCount = $this->countModules('position-8');

if ($position7ModuleCount && $position8ModuleCount)
{
	$span = 'span6';
}
elseif ($position7ModuleCount && !$position8ModuleCount)
{
	$span = 'span9';
}
elseif (!$position7ModuleCount && $position8ModuleCount)
{
	$span = 'span9';
}
else
{
	$span = 'span12';
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="' . htmlspecialchars(JUri::root() . $this->params->get('logoFile'), ENT_QUOTES) . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle'), ENT_COMPAT, 'UTF-8') . '</span>';
}
else
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <jdoc:include type="head"/>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-65M1P5S3R9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-65M1P5S3R9');
    </script>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-WG65GCN');</script>
    <!-- End Google Tag Manager -->
</head>
<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '')
	. ($this->direction === 'rtl' ? ' rtl' : '');
?>">
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WG65GCN"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Header -->
<header class="header" role="banner">
    <div class="header-inner clearfix">
        <div class="container<?php echo $this->params->get('fluidContainer') ? '-fluid' : ''; ?>">
            <a class="brand" href="<?php echo $this->baseurl; ?>/">
				<?php echo $logo; ?>
            </a>
        </div>
    </div>
    <nav class="navigation" role="navigation">
        <div class="navbar">
            <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                <span class="element-invisible"><?php echo JTEXT::_('TPL_PROTOSTAR_TOGGLE_MENU'); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
        </div>
        <div class="nav-collapse">
            <jdoc:include type="modules" name="position-1" style="none"/>
        </div>
    </nav>
</header>

<!-- Body -->
<div class="body">
    <div class="container<?php echo($params->get('fluidContainer') ? '-fluid' : ''); ?>">
		<?php if ($this->countModules('banner')) : ?>
            <!-- Begin Banner -->
            <div class="banner">
                <jdoc:include type="modules" name="banner" style="xhtml"/>
            </div>
            <!-- End Banner -->
		<?php endif; ?>

        <!-- Begin Main Content -->
        <div class="row-fluid" id="main-content">
			<?php if ($position8ModuleCount) : ?>
                <!-- Begin Sidebar -->
                <div id="sidebar" class="span3">
                    <div class="sidebar-nav">
                        <jdoc:include type="modules" name="position-8" style="xhtml"/>
                    </div>
                </div>
                <!-- End Sidebar -->
			<?php endif; ?>
            <main id="content" role="main" class="<?php echo $span; ?>">
                <!-- Begin Content -->
                <jdoc:include type="modules" name="position-3" style="xhtml"/>
                <jdoc:include type="message"/>
                <jdoc:include type="component"/>
                <div class="clearfix"></div>
                <jdoc:include type="modules" name="position-2" style="none"/>
                <!-- End Content -->
            </main>
			<?php if ($position7ModuleCount) : ?>
                <div id="aside" class="span3">
                    <!-- Begin Right Sidebar -->
                    <jdoc:include type="modules" name="position-7" style="well"/>
                    <!-- End Right Sidebar -->
                </div>
			<?php endif; ?>
        </div>
        <!-- End Main Content -->
    </div>
</div>
<!-- Footer -->
<footer class="footer" role="contentinfo">
    <div class="container<?php echo($params->get('fluidContainer') ? '-fluid' : ''); ?>">
        <jdoc:include type="modules" name="footer" style="none"/>

        <p>
            &copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
        </p>
    </div>
</footer>
<jdoc:include type="modules" name="debug" style="none"/>
</body>
</html>
