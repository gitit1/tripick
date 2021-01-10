var app = angular.module('app', ['angularUtils.directives.dirPagination']);

function addressController($scope,$http){
	

  $scope.currentPage = 1;
  $scope.pageSize = 2;
  $scope.list = [];
	
		
	$scope.groups ='Work,Home,Friends,Shops,Spam'.split(',');
	$scope.genders ='Man,Woman'.split(',');
	$scope.version = angular.version.full;
	
	
	$scope.importFile = function () {
		$http.get("try.json").then(function(response) {
				  for (var i = 1; i <= response.data.length; i++) {
				    angular.extend($scope.list, response.data);
				  }	    	
		    	});     		
    }
	
	$scope.exportFile = function(){
		var data = "text/json;charset=utf-8," + encodeURIComponent(JSON.stringify($scope.list));
		
			$scope.toJSON = '';
			$scope.toJSON = angular.toJson($scope.list);
			var blob = new Blob([$scope.toJSON], { type:"application/json;charset=utf-8;" });			
			var downloadLink = angular.element('<a></a>');
                        downloadLink.attr('href',window.URL.createObjectURL(blob));
                        downloadLink.attr('download', 'contacts.json');
			downloadLink[0].click();				
	}
	
	$scope.newContact = function(){ //add new record in database
		var addItem = document.querySelector('.addItem');
		if(!addItem.querySelector('.fname').value || !addItem.querySelector('.phone').value){
			if(!$scope.fname) addItem.querySelector('.fname').classList.add('bg-danger');
			if(!$scope.phone) addItem.querySelector('.phone').classList.add('bg-danger');
			return false;
		}
		if (!/^0\d([\d]{0,1})([-]{0,1})\d{7}$/.test(addItem.querySelector('.phone').value)) {
		    return false;;
		}
		
		addItem.querySelector('.fname').classList.remove('bg-danger');
		addItem.querySelector('.phone').classList.remove('bg-danger');
		
		if(addItem.querySelector('.gender').value == "Man"){
			var img = 'contact_man.png';
		}else{
			var img = 'contact_woman.png';
		}		
		
		$scope.list.push({
			fname: addItem.querySelector('.fname').value,
			surname: addItem.querySelector('.surname').value,
			gender: addItem.querySelector('.gender').options[addItem.querySelector('.gender').selectedIndex].value,			
			phone: addItem.querySelector('.phone').value,
			address: addItem.querySelector('.address').value,
			group: addItem.querySelector('.group').options[addItem.querySelector('.group').selectedIndex].value,
			profile_image: img
		});
		addItem.querySelector('.fname').value ='';
		addItem.querySelector('.surname').value ='';
		addItem.querySelector('.gender').selectedIndex =0;
		addItem.querySelector('.phone').value ='';
		addItem.querySelector('.address').value ='';
		addItem.querySelector('.group').selectedIndex =0;
		addItem.style.display ='none';

	};
	$scope.removeContact = function(item){
		for(var i in $scope.list) if($scope.list[i] === item)
			$scope.list.splice(i, 1);
	};
	$scope.toggleAddForm = function(){
		var addItem = document.querySelector('.addItem');
		addItem.style.display = addItem.style.display =='block' ?'none':'block';
	};
};

function addressEditController($scope){ //edit record in database
	$scope.editorEnabled = false;

	$scope.enableEditor = function(){
		$scope.editorEnabled = true;
		this.fname = this.listItem.fname;
		this.surname = this.listItem.surname;
		this.gender = this.listItem.gender;
		this.phone = this.listItem.phone;
		this.address = this.listItem.address;
		this.group = this.listItem.group;
	};
	$scope.disableEditor = function(){
		$scope.editorEnabled = false;
	};
	$scope.save = function(){
		if(this.fname =='')
			return false;
		this.listItem.fname = this.fname;
		this.listItem.surname = this.surname;
		this.listItem.gender = this.gender;
		this.listItem.phone = this.phone;
		this.listItem.address = this.address;
		this.listItem.group = this.group;
		$scope.disableEditor();
	};
};

app.controller('addressEditController', addressEditController)
app.controller('addressController', addressController)
app.controller('mainCtrl', function ($scope) {  
    $scope.phoneNumbr = /^0\d([\d]{0,1})([-]{0,1})\d{7}$/;  
}); 


