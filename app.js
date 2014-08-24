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
  
  app.controller('SlotsController', ['$http', function($http){

    var slotsCtrl = this;

    slotsCtrl.slots = slts;

//    $http.get('slotsMap.json').success(function(data, status) {
    $http.get('php/slotsMap.php').success(function(data, status) {
        slotsCtrl.slots = data.slots;
      }).error(function(data, status) {
        slotsCtrl.slots = [];
      });   

  }]);



})();

