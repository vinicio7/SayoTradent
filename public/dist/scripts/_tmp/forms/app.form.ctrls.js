!function(){"use strict";angular.module("app.form.ctrls",[]).controller("WizardMinimalCtrl",["$scope",function($scope){$scope.currentInput=0,$scope.totalInput=4,$scope.progress=0,$scope.inputToggle=[!0,!1,!1,!1],$scope._progress=function(){$scope.progress=$scope.currentInput*(100/$scope.totalInput)},$scope.nextInput=function(){$scope.currentInput+=1,$scope._progress(),$scope.inputToggle.forEach(function(v,i){$scope.inputToggle[i]=!1}),$scope.inputToggle[$scope.currentInput]=!0}}]).controller("FormWizardCtrl",["$scope",function($scope){$scope.steps=[!0,!1,!1],$scope.stepNext=function(index){for(var i=0;i<$scope.steps.length;i++)$scope.steps[i]=!1;$scope.steps[index]=!0},$scope.stepReset=function(){$scope.steps=[!0,!1,!1]}}])}();