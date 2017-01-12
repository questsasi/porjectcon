"use strict";
var materialModule = angular.module('materialModule', []);

 // materialModule.config(['$routeProvider', function($routeProvider) {
 // 	$routeProvider
	// .when('/materialList', {
 //         templateUrl: 'modules/material/views/materialList.html',
 //         controller: 'materialListController',
 //    })
 // }]);


angular.module('materialModule')
  .run(
    [           '$rootScope', '$state', '$stateParams',
      function ( $rootScope,   $state,   $stateParams ) {
        $rootScope.$state = $state;
        $rootScope.$stateParams = $stateParams;
      }
    ]
  )
  .config(
    [          '$stateProvider', '$urlRouterProvider', 'MODULE_CONFIG',
      function ( $stateProvider,   $urlRouterProvider,  MODULE_CONFIG ) {
        $urlRouterProvider
          .otherwise('materialModule/login');
        $stateProvider
          
            
             
          // Material Routers
          .state('material', {
            url: '/material',
            views: {
              '': {
                templateUrl: 'views/layout.html'
              },
              'aside': {
                templateUrl: 'views/aside.html'
              },
              'content': {
                templateUrl: 'views/content.html'
              }
            }
          })
         .state('material1.materiallist',{
            url:'/materiallist',
            templateUrl:'modules/material/views/materiallist.html',
            data:{ title:'Material',theme:{ primary :'green'}}
          })
            .state('material1.materialin', {
              url: '/materialin',
              templateUrl: 'modules/material/views/materialin.html',
              data : { title: 'Material In', theme: { primary: 'green'} }
            })
             .state('material.process', {
              url: '/materialprocess',
              templateUrl: 'modules/material/views/materialprocess.html',
              data : { title: 'Material Process', theme: { primary: 'green'} }
            });
         }
    ]
  );
