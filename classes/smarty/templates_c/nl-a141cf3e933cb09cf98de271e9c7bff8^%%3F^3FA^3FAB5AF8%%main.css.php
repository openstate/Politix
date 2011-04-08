<?php /* Smarty version 2.6.18, created on 2008-12-02 09:39:53
         compiled from /var/www/projects/politix/public_html/stylesheets/watstemtmijnraad/main.css */ ?>
/*

Kleur 1 (zwart): #<?php echo $this->_tpl_vars['color1']; ?>

Kleur 2 (roze): #<?php echo $this->_tpl_vars['color2']; ?>

Kleur 3 (grijs): #<?php echo $this->_tpl_vars['color3']; ?>

Kleur 4 (wit): #<?php echo $this->_tpl_vars['color4']; ?>


*/

*
{
	margin: 0px;
	padding: 0px;
}

html{
	
}

body
{
	font-family: <?php echo $this->_tpl_vars['font_family']; ?>
, Arial, Helvetica, sans-serif;
	color: #000000;
	font-size: <?php echo $this->_tpl_vars['font_size']; ?>
;
	line-height: 14px;
	height: 100%;
	background: #<?php echo $this->_tpl_vars['bg_color']; ?>
;
	<?php if (! $this->_tpl_vars['noimg']): ?>background-image: url(/styles/bg); /* aanpassen obv logo breedte */<?php endif; ?>
	background-repeat: repeat-y;
	background-position: center top;
}

a img
{
	border:none;
}
a
{
	color: #<?php echo $this->_tpl_vars['color2']; ?>
;
}
h2
{
	font-family: Georgia, serif;
	font-size: 16px;
	color: #<?php echo $this->_tpl_vars['color2']; ?>
; /* kleur 2 */
	margin-bottom: 20px;
	padding-top: 1px;
}

h3
{
	font-size: 13px;
	padding-bottom: 4px;
}
div#headerBar
{
	height: <?php echo $this->_tpl_vars['logo']->height; ?>
px;
	background: #<?php echo $this->_tpl_vars['color1']; ?>
; /* kleur 1 */
	position: absolute;
	top: 16px;
	left: 0px;
	width: 100%;
	z-index: 3;		
	border-top: 1px solid #<?php echo $this->_tpl_vars['bg_color']; ?>
;
	border-bottom: 1px solid #<?php echo $this->_tpl_vars['bg_color']; ?>
;
}
	div#metaMenu
	{
		float:right;
		font-size: 10px;
		line-height: <?php echo $this->_tpl_vars['logo']->height; ?>
px;
		padding-right: 25px;
		text-align:right;
		color: #<?php echo $this->_tpl_vars['color4']; ?>
; /* kleur 3 */
	}
	div#metaMenu a
	{
		color: #<?php echo $this->_tpl_vars['color4']; ?>
; /* kleur 3 */
		text-decoration: none;
	}
	div#headerBarContent
	{
		width: 949px;
		margin: 0px auto;
	}
		img.logo
		{
			float:left;
			border-left: 1px solid #<?php echo $this->_tpl_vars['bg_color']; ?>
;
			margin-right: 33px;
			border-right: 1px solid #<?php echo $this->_tpl_vars['bg_color']; ?>
;
		}
		
		h1
		{
			font-family: Georgia, serif;
			font-size: 24px;
			margin:0px;
			font-weight: normal;
			letter-spacing: 2px;
			line-height: <?php echo $this->_tpl_vars['logo']->height; ?>
px;
			color: #<?php echo $this->_tpl_vars['color4']; ?>
; /* kleur 4 */
		}

#slogan {
	color: #<?php echo $this->_tpl_vars['color8']; ?>
;
	margin-left:20px;
}

div#headerBarStripes
{
	background-image: url(/styles/stripes);
	background-repeat: repeat-x;
	height: 21px;	
	position: absolute;
	top: <?php echo $this->_tpl_vars['logo']->height+19; ?>
px;
	left: 0px;
	width: 100%;
	z-index: 5;
}
div#leftBarArrow
{
	height: 47px;
	font-weight:bold;
	background: #<?php echo $this->_tpl_vars['color3']; ?>
; /* kleur 3 */
	text-align: center;
	font-size: 18px;
	color: #cccccc;
	padding-top: 43px;
	display:block;
	width: <?php echo $this->_tpl_vars['logo']->width; ?>
px; /* obv logo breedte */
}

div#leftBar
{
	position: absolute;
	z-index: 1;
	background:#d2d2d2;
	top: <?php echo $this->_tpl_vars['logo']->height+17; ?>
px;
	left: 0px;
	border-left: 1px solid #<?php echo $this->_tpl_vars['bg_color']; ?>
;
	border-right: 1px solid #<?php echo $this->_tpl_vars['bg_color']; ?>
;
}

div#columnContainer
{
	margin: 0px auto 0px auto;
	padding-top: <?php echo $this->_tpl_vars['logo']->height+17; ?>
px;
	position: relative;
	width: 949px;
}

div#leftColumn
{
	float:left;
	width: 715px;
	padding-right:5px;
}
	div#menuBar
	{
		height: 45px;
		padding-left: <?php echo $this->_tpl_vars['logo']->width+1; ?>
px; /* obv logo breedte = breedte logo + 1*/
		overflow:auto;
		padding-top: 45px;
	}
	div#menuBar ul
	{
		list-style: none;		
		border-bottom: 1px solid #<?php echo $this->_tpl_vars['color3']; ?>
; /* kleur 3 */
		padding-left: 35px;
		height: 17px;
	}
	div#menuBar ul li
	{
		display:block;
		float:left;
	}
	div#menuBar ul li a
	{
		display:block;
		float:left;
		font-family: Georgia, serif;
		font-weight: bold;
		text-transform: lowercase;
		font-size: 12px;
		text-decoration: none;
		padding-bottom: 4px;
		color: #000000;
		margin-right: 38px;
	}
	div#menuBar ul li.active a
	{
		padding-bottom: 1px;
		border-bottom: 3px solid #<?php echo $this->_tpl_vars['color1']; ?>
; /* kleur 1 */
	}

	div#menuBar ul li a:hover {	
		padding-bottom: 1px;
		border-bottom: 3px solid #<?php echo $this->_tpl_vars['color1']; ?>
;
	}
	
	div#content p,div#content div.contentBlock
	{
		<?php if (! $this->_tpl_vars['noimg']): ?>padding-left: <?php echo $this->_tpl_vars['logo']->width+35; ?>
px;  /* obv logo breedte = breedte logo + 35*/<?php endif; ?>
		margin-bottom: 14px;
		width: 450px;
	}

	div.contentBlock p {
		padding-left: 0px !important;
	}


div.titleBlock, div.titleBlockSmall
{
	float:left;
	width: <?php echo $this->_tpl_vars['logo']->width; ?>
px; /* obv logo breedte */
	border: 1px solid #<?php echo $this->_tpl_vars['bg_color']; ?>
;
	border-right: none;
	height: 16px;
	background-color: #<?php echo $this->_tpl_vars['color2']; ?>
; /* kleur 2 */
	margin-right: 34px;
	overflow: hidden;
	<?php if ($this->_tpl_vars['noimg']): ?>display: none;<?php endif; ?>
}

div.titleBlockSmall
{
	width: 3px;
	margin-right: 13px;
}

div#rightColumn
{
	float:left;
	width: 205px;
	padding-top: 90px;
	padding-right: 0px;
	padding-left: 0px;
}

div#rightColumn p.logo {
	text-align: center;
}

div#rightColumn p.extraLogos {
	text-align: center;
	font-size: 70%;
	padding-top: 10px;
}

div#rightColumn p.extraLogos img {
	margin-right: 3px;
}

div#rightColumn p.extraLogos img.last {
	margin-right: 0;
}

th
{
	text-align:left;
	padding-right: 10px;
}
td
{
	font-size:11px;
}
div.contentSection
{
	padding-bottom: 30px;
}
div.result
{
	width: <?php echo $this->_tpl_vars['logo']->width*-1+679; ?>
px !important;
	padding-bottom: 15px;
}
div.contentSection div.last
{
	padding-bottom: 0px;
}
div.result div.date
{
	width: 0px;
	padding-right: 30px;
	float:left;
	height: 50px;
	color: #<?php echo $this->_tpl_vars['color3']; ?>
; /* kleur 3 */
	font-size: 16px;
	font-weight: bold;
	text-align: center;
	font-family: Times new roman, serif;
	line-height: 16px;
}
div.result div.link
{
	float:right;
	height: 50px;
	width: 16px;
}
div.result div.link a
{
	color: white;
	display:block;
	padding-top: 18px;
	height: 32px;
	text-align:center;
	font-size: 13px;
	font-weight: bold;
	background-color: #<?php echo $this->_tpl_vars['color6']; ?>
;
	text-decoration: none;
}
div.result div.link a:hover
{
	background-color: #<?php echo $this->_tpl_vars['color3']; ?>
; /* kleur 3 */
}
div.result div.stats
{
	float:right;
	margin-left: 5px;
	height: 50px;
	width: 120px;
	padding-left: 10px;
	border-left: 1px solid #cccccc;
	padding-right: 10px;
	text-align:center;
}
div.result div.stats div.leftStats
{
	width: 60px;
	float:left;
	text-align:left;
}
div.result div.stats div.rightStats
{
	width: 60px;
	float:left;
	text-align:right;
}
div.result div.title
{
	font-size: 13px;
	font-weight: bold;
	padding-bottom: 7px;
}
div.result div.title a
{
	color: #<?php echo $this->_tpl_vars['color2']; ?>
;
	text-decoration: none;
}
div.result div.summary
{
	padding-right: 5px;
}
.green, .result.r1, .vote.r0
{	
	color:#49c100;
}
.red, .result.r2, .vote.r1
{	
	color:#c1001b;
}

.vote.r-1 {
	color: blue;
}

.vote.r2 {
	color: #f60;
}

.vote.r3 {
	color: #aa0;
}

.politician .name {
	text-indent: 30px;
}

input.search {
}
input.submitButton
{
	background-color: #<?php echo $this->_tpl_vars['color2']; ?>
;
	color: #<?php echo $this->_tpl_vars['color4']; ?>
;
	border:none;
	padding: 2px;
	font-family: Georgia, serif;
	font-weight:bold;
}

#province, #gemeente {
	width: 200px;
}

.warning {
	color: #c1001b;
}

#search_toggle a {
	text-decoration: none;
}

#search_toggle a:hover {
	text-decoration: underline;
}

#searchBlock {
	width: auto !important;
	
}
.extramargin
{
	margin-bottom: 25px !important;
}
.nodisplay
{
	display: none;
}
div#regionSelectForm {
	height: 110px;
}
div#home_search
{
	padding-top: 10px;
	text-align:right;
}

table.filter {
	width: 100%;
}

table.filter td.filterDetails {
	border-right: 1px solid #cccccc;
}

table.filter td.filterDetails div.title {
	font-size: 13px;
	font-weight: bold;
	padding-bottom: 7px;
}

table.filter th.filterHeader {
	text-align: center;
	height: 14px;
	width: 60px;
	padding-right: 0px;
}

table.filter td.filterTotals {
	vertical-align: top;
	text-align: center;
	width: 60px;
}

table.filter .first {
	padding-left: 5px !important;
}

table.filter .last {
	padding-right: 5px !important;
}

.nomargin-bottom {
	margin-bottom: 0px !important;
}

div#categories ul {
	list-style: none;
}

.raadsstuk th {
	vertical-align: top;
}

.raadsstuk ul {
	padding-left: 40px;
}

hr.filter {
	border: none;
	margin-top: -20px;
	margin-bottom: 20px;
	margin-left: <?php echo $this->_tpl_vars['logo']->width+2; ?>
px;
	border-bottom: 1px solid #989898;
}