//Material Controller
'use strict'
app.controller('MaterialEntryController', function ($scope,$http) 
    {
      $scope.reset = function() {
        $scope.user = {
          name: "",
          type: "",
            }
     };
      $scope.submit = function() {        
        $http({
            url: 'http://172.168.0.107/advanced/frontend/web/materials',
            method: "POST",
            data:JSON.stringify({name:$scope.name, unit:$scope.unit}),
            headers: {'Content-Type': 'application/json'}
        })
       }
    });
//Table Controller
app.controller('TableCtrl' ,function($scope, $http,$location) {
        var tmpDate = new Date();
                    $scope.newField = [];
                    $scope.editing = false;
                $http.get("http://172.168.0.107/advanced/frontend/web/materials")
                .success(function(data) {
                 $scope.tabledata = data;
                console.log(data);
        });
            //Edit the table row data
    $scope.editRow = function (eid) {
                for (i in $scope.tabledata) {
                    if ($scope.tabledata[i].id == eid) {
                        //Hiding Save button
                        $scope.DisplaySave = false;
                        //Displaying Update button
                        $scope.DisplayUpdate = true;
                        //Clearing the Status
                        $scope.status = '';
                    }
                }
            }
         
        //Update a table Row data
    $scope.Update = function (eid, name, type , $location){
                $http({
                    method: 'PUT',
                    url: 'http://172.168.0.107/advanced/frontend/web/materials/'+eid,
                    data: JSON.stringify({name:name,unit:type}),
                    headers: { 'Content-Type': 'application/json' }
                }).
                success(function (data) {
                
                    //Showing Success message
                    $scope.status = "The data Updated Successfully!!!";
                    //Displaying save button
                    $scope.DisplaySave = true;
                    //Hiding Update button
                    $scope.DisplayUpdate = false;
                })
                .error(function (error) {
                    //Showing error message
                    $scope.status = 'Unable to updated row: ' + error.message;
                    console.log($scope.status);
                });
               
            }
            $scope.deletePerson = function (eid) {
                //Defining $http service for deleting a person
                $http({
                    method: 'DELETE',
                    url: 'http://172.168.0.107/Projects/project_con/frontend/web/delete-material/' + eid
                }).
                success(function (data) {
                    //Showing Success message
                    $scope.status = "The Person Deleted Successfully!!!";
                    //Loading people to the $scope
                   // GetPersons();
                })
                .error(function (error) {
                    //Showing error message
                    $scope.status = 'Unable to delete a person: ' + error.message;
                    console.log($scope.status);
                });
            }
    $scope.reset = function() {
        $scope.user = {
          name: "",
          unit: "",
        }
      };

});
