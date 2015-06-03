angular.module('ui.chart', [])
.directive('uiChart', function ($window) {
    return {
        restrict: 'EACM',
        template: '<div></div>',
        replace: true,
        link: function (scope, elem, attrs) {
            var renderChart = function () {
                var data = scope.$eval(attrs.uiChart);
                elem.html('');
                if (!angular.isArray(data)) {
                    return;
                }

                var opts = {};
                if (!angular.isUndefined(attrs.chartOptions)) {
                    opts = scope.$eval(attrs.chartOptions);
                    if (!angular.isObject(opts)) {
                        throw 'Invalid ui.chart options attribute';
                    }
                }

                if (BugScope.gl_plot != null) { // avoid memory leak
                    BugScope.gl_plot.destroy();
                    BugScope.gl_plot = null;
                }
                BugScope.gl_plot = jQuery.jqplot(elem.attr("id"), data, opts);
                elem.unbind('jqplotDataClick');
                elem.bind('jqplotDataClick', function (ev, seriesIndex, pointIndex, data) {
                    if ( scope.timeStamp == undefined || ev.timeStamp - scope.timeStamp > 500) { // avoid fire jqplotDataClick twice
                        scope.timeStamp = ev.timeStamp;
                        if (BugScope.gl_report_ty == "Progressive") {
                            var length = scope.page.plot_fcty.getOrderedLegends.length;
                            // seriesIndex == @length, means 'current coverage '
                            if (seriesIndex == length) {
                                scope.popCodeCov(pointIndex, "curr");
                            }
                            // seriesIndex == @length + 1, means 'accumulated coverage'
                            else if (seriesIndex == length + 1) {
                                scope.popCodeCov(pointIndex, "accu");
                            }
                            else if (seriesIndex < length) {
                                // clicked on bar
                                scope.popProp(seriesIndex, pointIndex);
                            }
                        } else if (BugScope.gl_report_ty == "ModuleComplexity") {
                            if (seriesIndex == 1) { // clicked on 'Module Complexity'

                            } else { // clicked on 'Average Hits'
                                scope.popCovHits(seriesIndex, pointIndex);
                            }
                        }
                    }
                });
            };

            scope.$watch(attrs.uiChart, function () {
                renderChart();
            }, true);

            scope.$watch(attrs.chartOptions, function () {
                renderChart();
            });

            scope.$watch(function() {
                return angular.element("#divMainBody").width();
            }, function() {
                renderChart();
            });

            angular.element($window).bind('resize', function () {
                scope.$apply();
            });
        }
    };
});