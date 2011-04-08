<?php /* Smarty version 2.6.18, created on 2008-12-16 13:11:02
         compiled from /var/www/projects/politix/templates/backoffice.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Politix Backoffice</title>
	<link rel="stylesheet" href="/stylesheets/main.css" type="text/css" />
	<script src="/javascripts/mootools/moo.tools.v1.11.js" type="text/javascript"></script>
	<script src="/javascripts/ie.js" type="text/javascript"></script>
	<script src="/javascripts/formlib.js" type="text/javascript"></script>

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
						<a href="/">home</a> | <?php if (! $this->_tpl_vars['global']->user->loggedIn): ?><a href="/login/">login</a><?php else: ?><a href="/logout/">logout</a><?php endif; ?>
					</div>
					<!-- <a href="/"><img src="/images/wsmr.gif" class="logo" alt="Wat stemt mijn raad?"/></a> -->
					<div style="float: left; border-left: 1px solid #fff; border-right: 1px solid #fff; background-color: #000; width: 42px; height: 50px; margin-right: 33px;"></div>
					<h1>Politix</h1>
				</div>
			</div>
			<div id="headerBarStripes"></div>
			<div id="columnContainer">
				<div id="leftBar">
					<div id="leftBarArrow">&gt;</div>
				</div>
				<div id="leftColumn">
					<div id="menuBar">
						<?php ob_start(); ?>
							<?php if ($this->_tpl_vars['global']->user->rights['selection']->access): ?><li<?php if (preg_match ( '!^/selection!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/selection/">Selectie</a></li><?php endif; ?>
							<?php if ($this->_tpl_vars['smartyData']['role']): ?>
								<?php if ($this->_tpl_vars['global']->user->rights['appointments']->access): ?><li<?php if (preg_match ( '!^/appointments!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/appointments/">Aanstellingen</a></li><?php endif; ?>
								<?php if ($this->_tpl_vars['smartyData']['role'] instanceof BOUserRoleClerk): ?>
									<?php if ($this->_tpl_vars['global']->user->rights['raadsstukken']->access): ?><li<?php if (preg_match ( '!^/raadsstukken!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/raadsstukken/">Voorstellen</a></li><?php endif; ?>
									<?php if (! $this->_tpl_vars['global']->user->isSuperAdmin() && $this->_tpl_vars['global']->user->rights['party']->access): ?><li<?php if (preg_match ( '!^/party!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/party/">Partijen</a></li><?php endif; ?>
									<?php if (! $this->_tpl_vars['global']->user->isSuperAdmin() && $this->_tpl_vars['global']->user->rights['politicians']->access): ?><li<?php if (preg_match ( '!^/politicians!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/politicians/">Politici</a></li><?php endif; ?>
									<?php if ($this->_tpl_vars['global']->user->rights['style']->access): ?><li<?php if (preg_match ( '!^/style!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/style/">Opmaak</a></li><?php endif; ?>
									<?php if ($this->_tpl_vars['global']->user->rights['pages']->access): ?><li<?php if (preg_match ( '!^/pages!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/pages/">Statische Pagina's</a></li><?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>

							<?php if ($this->_tpl_vars['global']->user->rights['categories']->access): ?><li<?php if (preg_match ( '!^/categories!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/categories/">Categorieen</a></li><?php endif; ?>
							<?php if ($this->_tpl_vars['global']->user->isSuperAdmin() && $this->_tpl_vars['global']->user->rights['party']->access): ?><li<?php if (preg_match ( '!^/party!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/party/">Partijen</a></li><?php endif; ?>
							<?php if ($this->_tpl_vars['global']->user->isSuperAdmin() && $this->_tpl_vars['global']->user->rights['politicians']->access): ?><li<?php if (preg_match ( '!^/politicians!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/politicians/">Politici</a></li><?php endif; ?>
							<?php if ($this->_tpl_vars['global']->user->rights['user']->access): ?><li<?php if (preg_match ( '!^/user[^s]!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/user/">Gebruikers</a></li><?php endif; ?>
							<?php if ($this->_tpl_vars['global']->user->rights['users']->access): ?><li<?php if (preg_match ( '!^/users!' , $_SERVER['REQUEST_URI'] )): ?> class="active"<?php endif; ?>><a href="/users/roles/">Rollen</a></li><?php endif; ?>
						<?php $this->_smarty_vars['capture']['menu'] = ob_get_contents(); ob_end_clean(); ?>
						<?php if (! preg_match ( '/^\s+$/' , $this->_smarty_vars['capture']['menu'] )): ?>
						<ul>
							<?php echo $this->_smarty_vars['capture']['menu']; ?>

						</ul>
						<?php endif; ?>
					</div>
					<div id="content">
						<div class="contentSection">
							<div class="titleBlock"></div>
							<div class="padding">
								<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['smartyData']['contentFile'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

</body>
</html>