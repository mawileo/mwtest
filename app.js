(function(){
  var gem = { name: 'Azurite', price: 2.95 };
  var app = angular.module('gemStore', []);
  app.controller('StoreController', function() {
  	this.product = gem;
  });

  var slts = [
    { name: "Slot1", free: true }, { name: "Slot2", free: false}, { name: "Slot3", free: true},
    { name: "Slot4", free: true }, { name: "Slot5", free: 1}, { name: "Slot6", free: 0} 
    ];
  
  app.controller('SlotsController', ['$http', '$rootScope', function($http, $rootScope){

    var slotsCtrl = this;

    slotsCtrl.slots = slts;
    slotsCtrl.slots = [];
    slotsCtrl.nbr = 0;

//    $rootScope.$on('lgnEvent', function(event, args) { ; });

    var reloadSlots = function() {
//	alert("reloading slots...");
	//    $http.get('slotsMap.json').success(function(data, status) {
//	    $http.get('php/authtest.php').success(function(data, status) {
	    $http.defaults.headers.common.Authorization = 'Basic '+btoa($rootScope.usrname+":"+$rootScope.usrpwd);
	    $http.get('php/slotsMap.php').success(function(data, status) {
		slotsCtrl.slots = data.slots;
	      }).error(function(data, status) {
		slotsCtrl.slots = [];
		alert(status+" "+data+" "+atob("dXNyOnB3ZA=="));
	      });   
	}

    reloadSlots();

    $rootScope.rfrsh = reloadSlots;

    var getNumberOfSelectedSlots = function() {
	var retVal = 0;
	for (var i in slotsCtrl.slots) {
		if (slotsCtrl.slots[i].chosen == true) retVal += 1;
	}
	slotsCtrl.nbr = retVal;
    }
    slotsCtrl.getNbr = getNumberOfSelectedSlots; 


  }]);


  app.controller('LoginController', ["$http", "$rootScope", function($http, $rootScope) {

	var loginCtrl =  this;

    this.al = function() {
      alert("function al called");
    }

    this.lgn = function() {
//      	    alert("function lgn called: "+loginCtrl.usrname+"/"+loginCtrl.usrpwd);

	    $http.defaults.headers.common.Authorization = 'Basic '+btoa(loginCtrl.usrname+":"+loginCtrl.usrpwd);
	    $http.get('php/loginService.php').success(function(data, status) {
		if(loginCtrl.usrname === data) {
			$rootScope.usrname = loginCtrl.usrname;
			$rootScope.usrpwd = loginCtrl.usrpwd;
		} else {
			$rootScope.usrname = null;
			$rootScope.usrpwd = null;
			alert("Bad credentials");
		}
		loginCtrl.usrname = null;
		loginCtrl.usrpwd = null;
		$rootScope.rfrsh();
	      }).error(function(data, status) {
			alert("LoginService error");
	      });   
    }

    this.lgt = function() {
		$rootScope.usrname = null;
		$rootScope.usrpwd = null;
		$rootScope.rfrsh();
    }

  }]);


})();

