var myApp= angular.module('myApp',['ngAnimate']);


myApp.controller('mainController',['$scope','$http',function($scope,$http){

  $scope.requests=[];
  $scope.summeryData=[];
  $scope.chart=function(){

    var labels=[];
    var data=[];
    angular.forEach($scope.summeryData, function(value, key) {
        //this.push(key + ': ' + value);
        labels.push(value.currencyFrom+'->'+value.convertion);
        data.push(value.count);
        console.log(value);
        });
    var barChartData = {

  		labels : labels,
  		datasets : [
  			{
  				fillColor : "rgba(220,220,220,0.5)",
  				strokeColor : "rgba(220,220,220,0.8)",
  				highlightFill: "rgba(220,220,220,0.75)",
  				highlightStroke: "rgba(220,220,220,1)",
          data : data
  			}

  		]

  	}

  		var ctx = document.getElementById("canvas").getContext("2d");
  		window.myBar = new Chart(ctx).Bar(barChartData, {
  			responsive : true
  		});


  };


   $scope.getRequests=function(){
     console.log('hello');
     $http({
        method: 'GET',
        url: 'http://192.168.33.10/api/v1/analyse.php'
      }).then(function successCallback(response) {
        console.log(response.data);
        $scope.requests=response.data.all;
        $scope.summeryData=response.data.currencyanalsis;
        $scope.chart();



  }, function errorCallback(response) {
    console.log(response);
    // called asynchronously if an error occurs
    // or server returns response with an error status.
  });
};


$scope.getRequests();
}]);
