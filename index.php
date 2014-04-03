<?php
#==========================================================================================
# File: index.php
# Created Date: 02-Apr-2012
# Developer: Santosh Hegde
# Purpose: To write script to fetch and display Flickr images 
#==========================================================================================

# include external files 
require_once 'lib/class.flickr.php';
require_once 'config/config.php';

# set search keyword
if (isset($_POST['hit_it']) && !empty($_POST['search']))
	$keyword = trim($_POST['search']);	
elseif(isset($_GET['keyword']) && !empty($_GET['keyword'])) 
	$keyword = trim($_GET['keyword']);
else
	$keyword = false;

//if page no is not exist set default 1
$page = (isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : 1);

# set default variables
$limit 	 = 5;


# call Flickr method based on search keyword
if (!empty($keyword)) {
	# build search api param
	$params = array (
			'method' 	=> 'flickr.photos.search',
			'text' 		=> $keyword,
			'format' 	=> 'php_serial',
			'per_page' 	=> $limit,
			'page' 		=> $page
	);
} else {
	# if search is not exists call recent photos api call	
	$params = array (
			'method' 	=> 'flickr.photos.getRecent',
			'format' 	=> 'php_serial',
			'per_page' 	=> $limit,
			'page' 		=> $page
	);
}

# create a Flickr object
$obj = Flickr::load(__API_KEY__);
// print_r($obj);
$res = $obj->request($params);

if (is_array($res)) {
	# get total number of images
	$total = $res['photos']['total'];
	
	# get total number of resultant pages
	$pages = ceil($total/$limit);
	
	# set values for page navigation
	$start = $page + 1;
	$end = min(($page + $limit), $total);
	
	# page navigation > previous page
	$prevlink = ($page > 1) ? '<a href="?page=1&keyword='.$keyword.'" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '&keyword='.$keyword.'" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
	
	# page navigation > next page
	$nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '&keyword='.$keyword.'" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '&keyword='.$keyword.'" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
	
	# display the current page's details
	$paginator = '<div id="paging"><p>'. $prevlink. ' Page '. $page. ' of '. $pages. ' pages, displaying '. $start. '-'. $end. ' of '. $total. ' results '. $nextlink. ' </p></div>';
	
	# incldue template/output files to display HTML output
	require_once 'view/search.php';
	
} else {
	require_once 'view/connection_issue.php';
}

#====================================================================================================

?>
