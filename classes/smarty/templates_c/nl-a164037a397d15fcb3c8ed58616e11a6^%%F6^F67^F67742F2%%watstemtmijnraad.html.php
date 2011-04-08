<?php /* Smarty version 2.6.18, created on 2009-08-28 12:29:24
         compiled from /var/www/projects/politix/templates/watstemtmijnraad.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', '/var/www/projects/politix/templates/watstemtmijnraad.html', 33, false),array('modifier', 'urlencode', '/var/www/projects/politix/templates/watstemtmijnraad.html', 50, false),)), $this); ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>politix.nl</title>
		<meta name="robots" content="index, follow" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<link href="/styles/main" rel="stylesheet" type="text/css"/>
    <!--[if lt IE 7]>
			<link href="styles/patchie7less.css" rel="stylesheet" type="text/css" />
		<![endif]-->

		<script src="/javascripts/mootools/moo.tools.v1.11.js" type="text/javascript"></script>
		<?php if (! $this->_tpl_vars['region_page']): ?><script type="text/javascript" src="/javascripts/main.js"></script><?php endif; ?>
		<script type="text/javascript" src="/javascripts/Swiff.base.js"></script>
		<link rel="icon" href="/favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>

		<?php if ($this->_tpl_vars['smartyData']['headerFile'] != ''): ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['smartyData']['headerFile'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>
	</head>
	<body>
    <div id="wrapper">
			<div id="headerBar">
				<div id="headerBarContent">
					<div id="metaMenu">
						<a href="/">home</a> | <a href="/advsearch/">zoeken</a>
					</div>
					<a href="/"><img src="/styles/logo" class="logo" alt="Politix"/></a>
					<h1>politix.nl<span id="slogan"><?php echo ((is_array($_tmp=$this->_tpl_vars['style']->slogan)) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
</span></h1>
				</div>
			</div>
			<div id="headerBarStripes"></div>
			<div id="columnContainer">
				<div id="leftBar">
					<div id="leftBarArrow">&gt;</div>
				</div>
				<div id="leftColumn">
					<div id="menuBar">
						<ul>
							<li<?php if (preg_match ( '!^/(\?.*)?$!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/">Home</a></li>
							<li<?php if (preg_match ( '!^/advsearch/!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/advsearch/">Voorstellen</a></li>
														<li<?php if (preg_match ( '!^/about/!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/about/">Meer informatie</a></li>
							<?php $_from = $this->_tpl_vars['menu_pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
							<?php ob_start(); ?>'!^/<?php echo $this->_tpl_vars['p']->url; ?>
/!'<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('regex', ob_get_contents());ob_end_clean(); ?>
							<li<?php if (preg_match ( $this->_tpl_vars['regex'] , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/<?php echo ((is_array($_tmp=$this->_tpl_vars['p']->url)) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['p']->linkText)) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
</a></li>
							<?php endforeach; endif; unset($_from); ?>
						</ul>
					</div>
					<div id="content">
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['smartyData']['contentFile'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					</div>
				</div>
				<div id="rightColumn">
					<div class="titleBlockSmall"></div><h2>Zoeken</h2>
					<p class="logo"><a href="http://www.publiekezaak.nl"><img src="/images/dpz.png" alt="de publieke zaak" /></a></p>
					<?php if (! $this->_tpl_vars['region_page']): ?>
					<div id="countryFlash"><img src="/styles/map" width="204" height="204" alt="Nederland" /></div>
					<script type="text/javascript">
					<!--//--><![CDATA[//><!--
						window.addEvent('domready', function() {
							var swf1 = new Swiff('/flash/nederland.swf', {
									width: 204,
									height: 204,
									container: $('countryFlash'),
									params: { wmode: 'transparent' },
									vars: { pcolor: '0x<?php echo $this->_tpl_vars['style']->color3; ?>
', pcolorhover: '0x<?php echo $this->_tpl_vars['style']->color2; ?>
' }
							});
						});
					//--><!]]>
					</script>
					<div id="regionSelectForm">
						<h3><label for="province">Stap 1</label></h3>
						<select name="province" id="province" onchange="setProvincie(this)">
							<option value="-1">Kies een provincie</option>
							<option value="3">Drenthe</option>
							<option value="4">Flevoland</option>
							<option value="5">Friesland</option>
							<option value="6">Gelderland</option>
							<option value="7">Groningen</option>
							<option value="8">Limburg</option>
							<option value="9">Noord-Brabant</option>
							<option value="10">Noord-Holland</option>
							<option value="11">Overijssel</option>
							<option value="12">Utrecht</option>
							<option value="13">Zeeland</option>
							<option value="14">Zuid-Holland</option>
						</select>
						<form action="/search" method="post">
							<div id="gemeente_div" class="nodisplay">
								<h3><label for="gemeente">Stap 2</label></h3>
								<select name="region" id="gemeente">
									<option value="-1">Geen</option>
								</select>
							</div>
							<div id="home_search" class="nodisplay">
								<input name="submit" class="submitButton" type="submit" value="Zoeken"/>
							</div>
						</form>
					</div>
					<?php endif; ?>
					<?php if ($_SERVER['SCRIPT_URL'] != '/'): ?>
					<h3>Categorie&euml;n:</h3>
					<div id="categories">
						<ul>
							<?php $_from = $this->_tpl_vars['cat_count']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
							<li><a href="/search<?php if (isset ( $this->_tpl_vars['c']['url'] )): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['c']['url'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
<?php else: ?><?php if ($this->_tpl_vars['region_page']->id): ?>/region/<?php echo $this->_tpl_vars['region_page']->id; ?>
<?php endif; ?>/category/<?php echo $this->_tpl_vars['c']['category']; ?>
/submit/1<?php endif; ?>"><?php echo $this->_tpl_vars['c']['name']; ?>
</a> (<?php echo $this->_tpl_vars['c']['count']; ?>
)</li>
							<?php endforeach; else: ?>
							<li>Geen resultaten</li>
							<?php endif; unset($_from); ?>
						</ul>
					</div>
					<?php endif; ?>
					<p class="extraLogos">in partnerschap met:<br /><?php echo '<a href="http://www.maildepolitiek.nl"><img src="/images/maildepolitiek.gif" alt="Mail de politiek" class="last" /></a><br /><a href="http://www.150vv.nl"><img src="/images/150vv.gif" alt="150 volksvertegenwoordigers" /></a><br/><a href="http://www.burgerbuddy.nl"><img src="/images/burgerbuddys.gif" alt="Burger Buddy\'s" class="last" /></a><br /><a href="http://www.watstemtmijnraad.nl"><img src="/images/wsmr.gif" alt="Wat stemt mijn raad?" class="last" /></a><br /></p>'; ?>

				</div>
			</div>
		</div>


<?php echo '
<!-- Google analytics: 05-02-2009 -->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7333267-1");
pageTracker._trackPageview();
} catch(err) {}</script>
<!-- END of Google analytics script -->
'; ?>


	</body>
</html>