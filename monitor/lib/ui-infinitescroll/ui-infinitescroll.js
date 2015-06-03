// written by tian@atrenta.com
angular.module('ui.infinitescroll', []).directive('uiInfinitescroll', function() {
    return function(scope, elm, attr) {
        var raw = elm[0];
        
        elm.bind('scroll', function() {
            if (raw.scrollTop + raw.offsetHeight >= raw.scrollHeight) {
                scope.$apply(attr.uiInfinitescroll);
            }
        });
    };
});

/* use case
<div ui-infinitescroll='loadMode()'> </div>
*/