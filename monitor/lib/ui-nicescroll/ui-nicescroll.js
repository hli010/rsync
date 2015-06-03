// written by tian@atrenta.com
angular.module('ui.nicescroll',[])
.directive('uiNicescroll', function ($timeout) {
    return {
        restrict: 'EACM',
        link: function (scope, element, attr) {
            element.niceScroll({cursorcolor:"#3e643d"});
        }
    }
});


/* use case
<div ui-nicescroll> </div>
*/