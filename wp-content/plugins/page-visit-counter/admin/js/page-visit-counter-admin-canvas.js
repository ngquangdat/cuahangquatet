/* Chart JS */
(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 */

	$(window).load(function() {
        var currentURL = window.location.href;
        var dash_url_check = currentURL.indexOf("pvcp-main-dashboard");
        if( dash_url_check != -1 ) {
            $.ajax({
                type: 'GET',
                url: adminajax.ajaxurl,
                data: {
                    action: "pvcp_dashboard_summary",
                },
                success: function (response) {
                    var resultarr = JSON.parse(response);
                    var topBrowsersArr = resultarr['topBrowser'];
                    var topOsArr = resultarr['topOs'];
                    // browser chart variable
                    var browser_chart = new CanvasJS.Chart("chartContainerByBrowser", {
                        animationEnabled: true,
                        theme: "light2",
                        data: [{
                            type: "pie",
                            indexLabel: "{y}",
                            yValueFormatString: "#,##0.00\"%\"",
                            indexLabelPlacement: "inside",
                            indexLabelFontColor: "#ffffff",
                            indexLabelFontSize: 15,
                            showInLegend: true,
                            legendText: "{label}",
                            dataPoints: topBrowsersArr,
                        }]
                    });
                    // os chart variable
                    var os_chart = new CanvasJS.Chart("chartContainerByOs", {
                        animationEnabled: true,
                        theme: "light2",
                        data: [{
                            type: "pie",
                            indexLabel: "{y}",
                            yValueFormatString: "#,##0.00\"%\"",
                            indexLabelPlacement: "inside",
                            indexLabelFontColor: "#ffffff",
                            indexLabelFontSize: 15,
                            showInLegend: true,
                            legendText: "{label}",
                            dataPoints: topOsArr,
                        }]
                    });

                    if(topBrowsersArr != ""){
                        browser_chart.render();
                    }else{
                        $( "#chartContainerByBrowser" ).html( "<div class='pvcp_blank_graph'><strong>No Data Available</strong></div>" );
                    }
                    if(topOsArr != ""){
                        os_chart.render();
                    }else{
                        $( "#chartContainerByOs" ).html( "<div class='pvcp_blank_graph'><strong>No Data Available</strong></div>" );
                    }
                }
            });
        }

        $.urlParam = function(name){
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            if (results==null) {
                return null;
            }
            return decodeURI(results[1]) || 0;
        }
        var page_id  =  $.urlParam('page_id');
        var post_id  =  $.urlParam('post_id');
        var type     =  $.urlParam('type');
        var duration =  $.urlParam('duration');
        if( duration == '365' ){
            var xFormat = "MMM YYYY";
            var xInterval = 1;
            var xIntervalType = "month";
        }else{
            var xFormat = "DD MMM";
            var xInterval = "";
            var xIntervalType = "";
        }
        if( page_id != null || post_id != null) {

            $.ajax({
                type: 'GET',
                url: adminajax.ajaxurl,
                data: {
                    action: "pvcp_page_summary",
                    page_id: page_id,
                    post_id: post_id,
                    type: type,
                    duration: duration,
                },
                success: function (response) {
                    var resultArr = JSON.parse(response);
                    var chart_id = "chartContainerByPage" + page_id;
                    var chart = new CanvasJS.Chart(chart_id, {
                        animationEnabled: true,
                        theme: "light2",
                        axisX: {
                            valueFormatString: xFormat,
                            interval: xInterval,
                            intervalType: xIntervalType
                        },
                        axisY: {
                            title: "Total Number of Visits",
                            maximum: resultArr['max_count'],
                            titleFontSize: 15,
                            titleFontWeight: "bold",
                        },
                        data: [{
                            type: "splineArea",
                            color: "#6599FF",
                            xValueType: "dateTime",
                            yValueFormatString: "#,##0 Visits",
                            dataPoints: resultArr['data']
                        }]
                    });
                    chart.render();
                }
            });

        }
        var page_url_page_duration = currentURL.indexOf("duration");
        var page_url_check = currentURL.indexOf("pvcp-dashboard-page");
        if( page_url_check != -1 && page_url_page_duration == -1 ) {
            $.ajax({
                type: 'GET',
                url: adminajax.ajaxurl,
                data: {
                    action: "pvcp_page_summary_report",
                },
                success: function (response) {
                    var resultArr = JSON.parse(response);
                    var datapoint = [];
                    $.each(resultArr, function (key, value) {
                        datapoint.push(
                            {
                                type: "area",
                                name: key,
                                showInLegend: "true",
                                xValueType: "dateTime",
                                xValueFormatString: "DD MMM",
                                dataPoints: resultArr[key]
                            },
                        );
                    });
                    var report_month_cha = new CanvasJS.Chart("chartContainerReportByMonthPage", {
                        animationEnabled: true,
                        axisY: {
                            includeZero: false,
                            title: "Total Number of Visits",
                            gridColor: "lightgray",
                            lineColor: "lightgray",
                            titleFontSize: 15,
                            titleFontWeight: "bold",
                        },
                        axisX: {
                            valueFormatString: "DD MMM",
                            lineColor: "lightgray"
                        },

                        legend: {
                            cursor: "pointer",
                            itemclick: toggleDataSeries
                        },
                        toolTip: {
                            shared: true
                        },
                        data: datapoint
                    });
                    if(datapoint != ""){
                        report_month_cha.render();
                    }else{
                        $( "#chartContainerReportByMonthPage" ).html( "<div class='pvcp_blank_graph'><strong>No Data Available</strong></div>" );
                    }

                    function toggleDataSeries(e) {
                        if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        } else {
                            e.dataSeries.visible = true;
                        }
                        report_month_cha.render();
                    }
                }
            });
        }

        var post_url_check = currentURL.indexOf("pvcp-dashboard-post");
        if( post_url_check != -1 && page_url_page_duration == -1 ) {
            $.ajax({
                type: 'GET',
                url: adminajax.ajaxurl,
                data: {
                    action: "pvcp_post_summary_report",
                },
                success: function (response) {
                    var resultArr = JSON.parse(response);
                    var datapoint = [];
                    $.each(resultArr, function (key, value) {
                        datapoint.push(
                            {
                                type: "area",
                                name: key,
                                showInLegend: "true",
                                xValueType: "dateTime",
                                xValueFormatString: "DD MMM",
                                dataPoints: resultArr[key]
                            },
                        );
                    });
                    var report_month_post = new CanvasJS.Chart("chartContainerReportByMonthPost", {
                        animationEnabled: true,
                        axisY: {
                            includeZero: false,
                            title: "Total Number of Visits",
                            gridColor: "lightgray",
                            lineColor: "lightgray",
                            titleFontSize: 15,
                            titleFontWeight: "bold",
                        },
                        axisX: {
                            valueFormatString: "DD MMM",
                            lineColor: "lightgray"
                        },

                        legend: {
                            cursor: "pointer",
                            itemclick: toggleDataSeries
                        },
                        toolTip: {
                            shared: true
                        },
                        data: datapoint
                    });
                    if(datapoint != ""){
                        report_month_post.render();
                    }else{
                        $( "#chartContainerReportByMonthPost" ).html( "<div class='pvcp_blank_graph'><strong>No Data Available</strong></div>" );
                    }

                    function toggleDataSeries(e) {
                        if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        } else {
                            e.dataSeries.visible = true;
                        }
                        report_month_post.render();
                    }
                }
            });
        }

	});

})( jQuery );
