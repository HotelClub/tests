<?php
# include header
require_once 'header.php';
?>
<!--  search form  -->
<div id="search_container">
	<form name="frmSearch" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
		<input type="text" size="50" name="search"
			value="<?php echo $keyword;?>"><input type="submit" value="Search"
			name="hit_it">
		<div id="info"><?php echo $res['photos']['total']?> records and <?php echo $res['photos']['pages']?> pages found</div>
	</form>
</div>

<!--  display resultant images  -->
<div id="image_container">
	<?php
	foreach ( $res['photos'] ['photo'] as $key => $val ) {
		echo '<span class="thImg"> <a target="_blank" href="http://farm' . $val ['farm'] . '.staticflickr.com/' . $val ['server'] . '/' . $val ['id'] . '_' . $val ['secret'] . '_b.jpg">
			<img alt="' . $val ['title'] . '" src="http://farm' . $val ['farm'] . '.staticflickr.com/' . $val ['server'] . '/' . $val ['id'] . '_' . $val ['secret'] . '_q.jpg" /></a></span>';
	}
	?>
</div>

<!--  display page navigation  -->
<?php echo $paginator;?>
	
<?php
# include footer
require_once 'footer.php';
?>