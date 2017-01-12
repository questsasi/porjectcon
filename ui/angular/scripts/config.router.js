'use strict';

/**
 * @ngdoc function
 * @name app.config:uiRouter
 * @description
 * # Config
 * Config for the router
 */
angular.module('app')
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
          .otherwise('app/login');
        $stateProvider
          .state('app', {
            abstract: true,
            url: '/app',
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
            .state('app.login', {
              url: '/login',
              templateUrl: 'views/ui/form/select.html',
              data : { title: 'login', folded: true },
              //resolve: load(['scripts/controllers/chart.js','scripts/controllers/vectormap.js'])
            })
             .state('app.dashboard', {
              url: '/dashboard',
              templateUrl: 'views/pages/dashboard.html',
              data : { title: 'login', folded: true },
             // resolve: load(['scripts/controllers/chart.js','scripts/controllers/vectormap.js'])
             // authenticate: true

            })
            /*.state('app.analysis', {
              url: '/analysis',
              templateUrl: 'views/pages/dashboard.analysis.html',
              data : { title: 'Analysis' },
              resolve: load(['scripts/controllers/chart.js','scripts/controllers/vectormap.js'])
            })
            .state('app.wall', {
              url: '/wall',
              templateUrl: 'views/pages/dashboard.wall.html',
              data : { title: 'Wall', folded: true }
            })
            .state('app.todo', {
              url: '/todo',
              templateUrl: 'apps/todo/todo.html',
              data : { title: 'Todo', theme: { primary: 'indigo-800'} },
              controller: 'TodoCtrl',
              resolve: load('apps/todo/todo.js')
            })
            .state('app.todo.list', {
                url: '/{fold}'
            })
            .state('app.note', {
              url: '/note',
              templateUrl: 'apps/note/main.html',
              data : { theme: { primary: 'blue-grey'} }
            })
            .state('app.note.list', {
              url: '/list',
              templateUrl: 'apps/note/list.html',
              data : { title: 'Note'},
              controller: 'NoteCtrl',
              resolve: load(['apps/note/note.js', 'moment'])
            })
            .state('app.note.item', {
              url: '/{id}',
              views: {
                '': {
                  templateUrl: 'apps/note/item.html',
                  controller: 'NoteItemCtrl',
                  resolve: load(['apps/note/note.js', 'moment'])
                },
                'navbar@': {
                  templateUrl: 'apps/note/navbar.html',
                  controller: 'NoteItemCtrl'
                }
              },
              data : { title: '', child: true }
            })
            .state('app.inbox', {
                url: '/inbox',
                templateUrl: 'apps/inbox/inbox.html',
                data : { title: 'Inbox', folded: true },
                resolve: load( ['apps/inbox/inbox.js','moment'] )
            })
            .state('app.inbox.list', {
                url: '/inbox/{fold}',
                templateUrl: 'apps/inbox/list.html'
            })
            .state('app.inbox.detail', {
                url: '/{id:[0-9]{1,4}}',
                templateUrl: 'apps/inbox/detail.html'
            })
            .state('app.inbox.compose', {
                url: '/compose',
                templateUrl: 'apps/inbox/new.html',
                resolve: load( ['textAngular', 'ui.select'] )
            })*/
          
            // Employee routers
            .state('ui.employee', {
              url: '/employee',
              template: '<div ui-view></div>'
            })
              .state('ui.employee.attendance', {
                url: '/attendance',
                templateUrl: 'modules/employee/views/attendance.html',
                data : { title: 'Attendance' }
              })
              
            /*.state('app.login', {
              url: '/dashboard',
              templateUrl: 'views/ui/form/select.html',
              data : { title: 'Dashboard', folded: true },
              //resolve: load(['scripts/controllers/chart.js','scripts/controllers/vectormap.js'])
              //authenticate: true

            })*/
                  // Payment Routers
         .state('ui.payment', {
              url: '/payment',
              template: '<div ui-view></div>'
            })
              .state('ui.payment.payment', {
                url: '/payment',
                templateUrl: 'modules/payment/views/payment.html',
                data : { title: 'Payment' ,theme: { primary: 'red'}}
            })
              .state('ui.payment.paymententry', {
                url: '/payment',
                templateUrl: 'modules/payment/views/PaymentEntry.html',
                data : { title: 'PaymentEntry',theme: { primary: 'green'} }
            })
             
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
         .state('material.materiallist',{
            url:'/materiallist',
            templateUrl:'modules/material/views/materiallist.html',
            data:{ title:'Material',theme:{ primary :'green'}}
          })
            .state('material.materialin', {
              url: '/materialin',
              templateUrl: 'modules/material/views/materialin.html',
              data : { title: 'Material In', theme: { primary: 'green'} }
            })
             .state('material.process', {
              url: '/materialprocess',
              templateUrl: 'modules/material/views/materialprocess.html',
              data : { title: 'Material Process', theme: { primary: 'green'} }
            });




          function load(srcs, callback) {
            return {
                deps: ['$ocLazyLoad', '$q',
                  function( $ocLazyLoad, $q ){
                    var deferred = $q.defer();
                    var promise  = false;
                    srcs = angular.isArray(srcs) ? srcs : srcs.split(/\s+/);
                    if(!promise){
                      promise = deferred.promise;
                    }
                    angular.forEach(srcs, function(src) {
                      promise = promise.then( function(){
                        angular.forEach(MODULE_CONFIG, function(module) {
                          if( module.name == src){
                            if(!module.module){
                              name = module.files;
                            }else{
                              name = module.name;
                            }
                          }else{
                            name = src;
                          }
                        });
                        return $ocLazyLoad.load(name);
                      } );
                    });
                    deferred.resolve();
                    return callback ? promise.then(function(){ return callback(); }) : promise;
                }]
            }
          }
      }
    ]
  );
