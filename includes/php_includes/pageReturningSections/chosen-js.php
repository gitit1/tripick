  <!-- stylesheets -->
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
  <?php if($mobile){
  	echo "<link rel=\"stylesheet\" href=\"includes/select2/select2Mobile.css\">";
  }else{
  	echo "<link rel=\"stylesheet\" href=\"includes/select2/select2.css\">";
  	
  } 
  ?>
  <style type="text/css">
  body {
    padding: 40px;
  }
  </style>

  <!-- scripts -->
  <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="includes/select2/select2.js"></script>

  

  <script>
    $(function(){
      // turn the element to select2 select style
      $('#country').select2({
      		  placeholder: "Select a Country",
	  		  allowClear: true
      });
    });
  
    
  </script>