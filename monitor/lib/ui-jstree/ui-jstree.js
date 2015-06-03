// written by tian@atrenta.com
angular.module('ui.jstree',[])
.directive('uiJstree', function ($timeout) {
    return {
        restrict: 'EACM',
        link: function (scope, elem, attrs) {
            var renderTree = function () {
                var opts = {};
                if (!angular.isUndefined(attrs.treeOptions)) {
                    opts = scope.$eval(attrs.treeOptions);
                    if (!angular.isObject(opts)) {
                        throw 'Invalid ui.jstree options attribute';
                    }
                }

                // HACKED HERE, bcz angularjs and jstree use the same HTML BLOCK 
                var html_content = "";
                html_content += "<div id='divHackedForAngularJsAndJstree'>"
                html_content += "<ul>";
                html_content += "    <li class='jstree-open'> <a id='test-allmodule_in_nav' href='#/home/summary'>All Modules</a>";
                html_content += "        <ul>";
                for (var i = 0; i < scope.page.nav_modules.length; i++) {
                var item = scope.page.nav_modules[i];
                html_content += "            <li><a id='test-module_in_nav' href='#/home/module/" + item.name + "/" + item.param_key + "'>" + item.name + "</a></li>";
                };
                html_content += "        </ul>"
                html_content += "    </li>";
                html_content += "</ul>";
                html_content += "</div>";
                // END HACKED
                
                elem.html(html_content);

                $("#divHackedForAngularJsAndJstree").jstree(opts);

                if (!scope.page.is_nav_modules_changed) { // Why add this if stmt? trigger nicescroll!
                    scope.page.is_nav_modules_changed = true;
                    $timeout(function() {
                        scope.page.is_nav_modules_changed = false;
                    }, 200);
                }
            };
            scope.$on('refresh_nav', function() {
                renderTree();
            });
        }
    }
});
