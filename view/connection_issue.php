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
	</form>
</div>

<!--  display resultant images  -->
<div id="image_container">
	<p>Could not able to connect to remote server! Please try again...</p>
</div>
	
<?php
# include footer
require_once 'footer.php';
?>