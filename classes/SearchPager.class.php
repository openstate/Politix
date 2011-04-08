<?php

require_once('Pager.class.php');

class SearchPager extends Pager {
	protected $query_start = '/';
	protected $query_sep = '/';
	protected $value_sep = '/';
}