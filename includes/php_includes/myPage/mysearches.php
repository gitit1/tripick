<?php
    if (!$fbId){
    	$fbId = 'Null';
    }
	$queryAct = "SELECT * FROM activitySearch WHERE userName='$userName' AND userFbId='$fbId' ORDER BY queryDate DESC";
	$resultAct = mysqli_query($conn_query, $queryAct);
	
	$queryBuild = "SELECT * FROM buildTripSearch WHERE userName='$userName' AND userFbId='$fbId' ORDER BY queryDate DESC";
	$resultBuild = mysqli_query($conn_query, $queryBuild);	
	
?>			
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
		<div> <!--See activity search results -->												
			<a id='mysearchesActLink' class='mysearchesActHeader' href='#mysearchesPageRstBoxesAct' onclick="toggleElement('mysearchesPageRstBoxesAct');" >
				<h3>Searches for Activity:</h3>
			</a>
			<div id="mysearchesPageRstBoxesAct">
				<?php include_once("includes/php_includes/searchesPhp/mysearchesSrcActRst.php"); ?>
		 	</div>
		</div>
		<div> <!--See build search results -->
			<a id='mysearchesActLink' class='mysearchesBuildHeader' href='#mysearchesPageRstBoxesBuild' onclick="toggleElement('mysearchesPageRstBoxesBuild');" >
				<h3>Searches for Build a trip:</h3>
			</a>
			<div id='mysearchesPageRstBoxesBuild'>
				<?php include_once("includes/php_includes/searchesPhp/mysearchesSrcBuildRst.php"); ?>
		 	</div>							
		</div>
		<div class="clear"></div>	
	</div>																					    									    						    		
</div>
<div class="mobileBtnsMySearches">
<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");} ?>
</div>
<div class="clear"></div>