!function(){"use strict";angular.module("app.compras",["app.service.compras"]).controller("ComprasController",["$scope","$filter","$http","$modal","$interval","ComprasService",function($scope,$filter,$http,$modal,$timeout,ComprasService){function MostarDatos(){ComprasService.index().then(function(response){$scope.datas=response.data.records,$scope.search(),$scope.select($scope.currentPage)})}function CargarModal(){ComprasService.proveedores().then(function(response){$scope.proveedores=response.data.records})}function createToast(type,message){$scope.toasts.push({anim:"bouncyflip",type:type,msg:message})}function closeAlert(index){$scope.toasts.splice(index,1)}$scope.datas=[],$scope.currentPageStores=[],$scope.searchKeywords="",$scope.filteredData=[],$scope.row="",$scope.numPerPageOpts=[5,10,25,50,100],$scope.numPerPage=$scope.numPerPageOpts[1],$scope.currentPage=1,$scope.positionModel="topRight",$scope.toasts=[];var modal;$scope.redirect=function(){window.location="../ws/excel/compras",createToast("success","<strong>Éxito: </strong>Reporte Creado Exitosamente"),$timeout(function(){closeAlert(0)},3e3)},$scope.select=function(page){var start=(page-1)*$scope.numPerPage,end=start+$scope.numPerPage;$scope.currentPageStores=$scope.filteredData.slice(start,end)},$scope.onFilterChange=function(){$scope.select(1),$scope.currentPage=1,$scope.row=""},$scope.onNumPerPageChange=function(){$scope.select(1),$scope.currentPage=1},$scope.onOrderChange=function(){$scope.select(1),$scope.currentPage=1},$scope.search=function(){$scope.filteredData=$filter("filter")($scope.datas,$scope.searchKeywords),$scope.onFilterChange()},$scope.order=function(rowName){$scope.row!=rowName&&($scope.row=rowName,$scope.filteredData=$filter("orderBy")($scope.datas,rowName),$scope.onOrderChange())},MostarDatos(),CargarModal(),$scope.saveData=function(customer){"new"==$scope.action?ComprasService.store(customer).then(function(response){response.data.result?(MostarDatos(),modal.close(),createToast("success","<strong>Éxito: </strong>"+response.data.message),$timeout(function(){closeAlert(0)},3e3)):(createToast("danger","<strong>Error: </strong>"+response.data.message),$timeout(function(){closeAlert(0)},3e3))},function(response){createToast("danger","<strong>Error: </strong>"+response.data.message),$timeout(function(){closeAlert(0)},3e3)}):"update"==$scope.action?ComprasService.update(customer).then(function(response){response.data.result?(modal.close(),createToast("success","<strong>Éxito: </strong>"+response.data.message),$timeout(function(){closeAlert(0)},3e3)):(createToast("danger","<strong>Error: </strong>"+response.data.message),$timeout(function(){closeAlert(0)},3e3))},function(response){createToast("danger","<strong>Error: </strong>"+response.data.message),$timeout(function(){closeAlert(0)},3e3)}):"delete"==$scope.action&&ComprasService.destroy(customer.id).then(function(response){response.data.result?(MostarDatos(),modal.close(),createToast("success","<strong>Éxito: </strong>"+response.data.message),$timeout(function(){closeAlert(0)},3e3)):(createToast("danger","<strong>Error: </strong>"+response.data.message),$timeout(function(){closeAlert(0)},3e3))},function(response){createToast("danger","<strong>Error: </strong>"+response.data.message),$timeout(function(){closeAlert(0)},3e3)})},$scope.modalCreateOpen=function(){$scope.compra={},$scope.action="new",modal=$modal.open({templateUrl:"views/compras/modal_compras.html",scope:$scope,size:"lg",resolve:function(){},windowClass:"default"})},$scope.modalEditOpen=function(data){$scope.action="update",$scope.compra=data;var today=new Date(data.fecha);Date.prototype.addDays=function(days){var dat=new Date(this.valueOf());return dat.setDate(dat.getDate()+days),dat},today=today.addDays(1),$scope.compra.fecha=today,modal=$modal.open({templateUrl:"views/compras/modal_compras.html",scope:$scope,size:"lg",resolve:function(){},windowClass:"default"})},$scope.modalDeleteOpen=function(data){$scope.action="delete",$scope.compra=data,modal=$modal.open({templateUrl:"views/compras/modal_compras.html",scope:$scope,size:"md",resolve:function(){},windowClass:"default"})},$scope.modalClose=function(){modal.close(),MostarDatos()}}])}();