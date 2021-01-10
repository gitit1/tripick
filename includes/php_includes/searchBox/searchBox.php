<form method="post" class="searchHeader" action="includes/php_includes/searchBox/search.php">												
    <input type="text" name="find" id="autocomplete-ajax" placeholder="Search for Country" class="searchInput1"/>
	<input type="text" name="find" id="autocomplete-ajax-x" disabled="disabled" class="searchInput2">
	<input type="submit" class="searchButtom" name="search" value=""/>
</form>
<div style='display:none'>
	<div id="searchErrorAlert"><p><?php echo $msg ?></p></div>
</div>