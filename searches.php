<?php //check login status_activity
	include_once("includes/php_includes/check_login_status.php");
?>
<?php 
	if($user_ok != true){
		header("location: notallowed.php");
	}
?>
<?php
	$queryAct = "SELECT * FROM activitySearch ORDER BY queryDate DESC LIMIT 5";
	$resultAct = mysqli_query($conn_query, $queryAct);
	
	$queryBuild = "SELECT * FROM buildTripSearch ORDER BY queryDate DESC LIMIT 5";
	$resultBuild = mysqli_query($conn_query, $queryBuild);	   	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Search For Partners</title>
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); ?>	    			    		
	</head>
	<body>
		<div id="wrapper"> 	
			<header id="header">
				<?php include_once("includes/php_includes/pageReturningSections/header.php"); ?>		
			</header>		
			<nav id="navigator">
				<?php include_once("includes/php_includes/pageReturningSections/navigator.php"); ?>
			</nav>	
			<main>			
				<nav class="breadCrums">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><img src="images/main/breadcrumsArrows.png" class="navArrows"></li>
						<li class="breadCrumsHighlight"><a href="searches.php">Search for Partners</a></li>
					</ul>
				</nav>
			    <h1 class="pageHeader srcPageHdr">Search For Partners</h1>					
			    <div class="content">
			    	<div class="userMenu">
						<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
			    	</div>
			    	<div class="mapGeneralSettings mapOpacityFixed mapAutoHeight mapWithoutBorder">
			    		<div class='searchesPageCnt'>
			    			<?php if (!$mobile){
								echo "<input type=\"button\" value=\"Activity\" class=\"searchesPageActBtn\"
									   onclick=\"window.location.href='searchactivity.php';\"  alt='Post a search an Activity' title='Post a search an Activity'/>";
								echo "<input type=\"button\" value=\"Build a Trip\" class=\"searchesPageBuildBtn\"
								       onclick=\"window.location.href='searchbuild.php';\" alt='Post a search to build a trip' title='Post a search to build a trip'/>";	    				
			    			}else{
								echo "<button onclick=\"window.location.href='searchactivity.php';\" class=\"generalBtn btnImgActivityMySrc\">
										<img src=\"images/btn/activity.png\" alt=\"Search Partner for Activity\" title=\"Search Partner for Activity\"/>
						  		 	  </button>";
								echo "<label class='btnActLblMblMySrc'>For Activity</label>";
								
								echo "<button onclick=\"window.location.href='searchbuild.php';\" class=\"generalBtn btnImgBuildMySrc\">
										<img src=\"images/btn/build.png\" alt=\"To Build a trip\" title=\"To Build a trip\"/>
						  		 	  </button>";
								echo "<label class='btnBuildLblMblMySrc'>To Build a trip</label>";	  								  
							}
							?>
							<div>									
								<h3 class="searchesPageRstBoxHeader">Latest searches for Activity:</h3>
								<div  class="searchesPageRstBoxes">
									<?php include_once("includes/php_includes/searchesPhp/searchespageActSrcRst.php"); ?>
							 	</div>
							</div>
							<div>											 				
								<h3 class="searchesPageRstBoxHeaderBuild">Latest searches for Build a trip:</h3>
								<div class="searchesPageRstBoxesBuild">
									<?php include_once("includes/php_includes/searchesPhp/searchespageBuildSrcRst.php"); ?>
							 	</div>							
							</div>
							<div class="clear"></div>	
						</div>																					    									    						    		
			    	</div>
			    </div>						    	
				<div class="clear"></div>
				<div class="mobileBtnsSearches">
					<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");}else{/*include_once("includes/php_includes/pageReturningSections/footer.php");*/} ?>
				</div>			    							        
			</main>				
		</div> <!--Wrapper-->	
	</body>
</html>