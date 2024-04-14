"use strict";
!(function (NioApp, $) {
    var analyticAuData = {
        labels: [
            "01 Jan",
            "02 Jan",
            "03 Jan",
            "04 Jan",
            "05 Jan",
            "06 Jan",
            "07 Jan",
            "08 Jan",
            "09 Jan",
            "10 Jan",
            "11 Jan",
            "12 Jan",
            "13 Jan",
            "14 Jan",
            "15 Jan",
            "16 Jan",
            "17 Jan",
            "18 Jan",
            "19 Jan",
            "20 Jan",
            "21 Jan",
            "22 Jan",
            "23 Jan",
            "24 Jan",
            "25 Jan",
            "26 Jan",
            "27 Jan",
            "28 Jan",
            "29 Jan",
            "30 Jan",
        ],
        dataUnit: "Revenue",
        lineTension: 0.1,
        datasets: [
            {
                label: "Revenue",
                color: "#9cabff",
                background: "#9cabff",
                data: [1110, 1220, 1310, 980, 900, 770, 1060, 830, 690, 730, 790, 950, 1100, 800, 1250, 850, 950, 450, 900, 1e3, 1200, 1250, 900, 950, 1300, 1200, 1250, 650, 950, 750],
            },
        ],
    };
    function analyticsAu(selector, set_data) {
        var $selector = $(selector || ".analytics-au-chart");
        $selector.each(function () {
            for (
                var $self = $(this), _self_id = $self.attr("id"), _get_data = void 0 === set_data ? eval(_self_id) : set_data, selectCanvas = document.getElementById(_self_id).getContext("2d"), chart_data = [], i = 0;
                i < _get_data.datasets.length;
                i++
            )
                chart_data.push({
                    label: _get_data.datasets[i].label,
                    tension: _get_data.lineTension,
                    backgroundColor: _get_data.datasets[i].background,
                    borderWidth: 2,
                    borderColor: _get_data.datasets[i].color,
                    data: _get_data.datasets[i].data,
                    barPercentage: 0.7,
                    categoryPercentage: 0.7,
                });
            var chart = new Chart(selectCanvas, {
                type: "bar",
                data: { labels: _get_data.labels, datasets: chart_data },
                options: {
                    plugins: {
                        legend: { display: _get_data.legend || !1, labels: { boxWidth: 12, padding: 20, color: "#6783b8" } },
                        tooltip: {
                            enabled: !0,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                title: function () {
                                    return !1;
                                },
                                label: function (a) {
                                    return "".concat(a.parsed.y, " ").concat(_get_data.dataUnit);
                                },
                            },
                            backgroundColor: "#eff6ff",
                            titleFont: { size: 11 },
                            titleColor: "#6783b8",
                            titleMarginBottom: 6,
                            bodyColor: "#9eaecf",
                            bodyFont: { size: 9 },
                            bodySpacing: 4,
                            padding: 6,
                            footerMarginTop: 0,
                            displayColors: !1,
                        },
                    },
                    maintainAspectRatio: !1,
                    scales: {
                        y: {
                            display: !0,
                            position: NioApp.State.isRTL ? "right" : "left",
                            ticks: { beginAtZero: !1, font: { size: 12 }, color: "#9eaecf", padding: 0, display: !1, stepSize: 300 },
                            grid: { color: NioApp.hexRGB("#526484", 0.2), tickLength: 0, zeroLineColor: NioApp.hexRGB("#526484", 0.2), drawTicks: !1 },
                        },
                        x: {
                            display: !1,
                            ticks: { font: { size: 12 }, color: "#9eaecf", source: "auto", padding: 0, reverse: NioApp.State.isRTL },
                            grid: { color: "transparent", tickLength: 0, zeroLineColor: "transparent", offset: !0, drawTicks: !1 },
                        },
                    },
                },
            });
        });
    }
    NioApp.coms.docReady.push(function () {
        analyticsAu();
    });
    var analyticOvData = {
        labels: [
            "01 Jan",
            "02 Jan",
            "03 Jan",
            "04 Jan",
            "05 Jan",
            "06 Jan",
            "07 Jan",
            "08 Jan",
            "09 Jan",
            "10 Jan",
            "11 Jan",
            "12 Jan",
            "13 Jan",
            "14 Jan",
            "15 Jan",
            "16 Jan",
            "17 Jan",
            "18 Jan",
            "19 Jan",
            "20 Jan",
            "21 Jan",
            "22 Jan",
            "23 Jan",
            "24 Jan",
            "25 Jan",
            "26 Jan",
            "27 Jan",
            "28 Jan",
            "29 Jan",
            "30 Jan",
        ],
        dataUnit: "People",
        lineTension: 0.1,
        datasets: [
            {
                label: "Current Month",
                color: "#e85347",
                dash: [5, 5],
                background: "transparent",
                data: [3910, 4420, 4110, 5180, 4400, 5170, 6460, 8830, 5290, 5430, 4690, 4350, 4600, 5200, 5650, 6850, 6950, 4150, 4300, 6e3, 6800, 2250, 6900, 7950, 6900, 4200, 6250, 7650, 8950, 9750],
            },
            {
                label: "Current Month",
                color: "#798bff",
                dash: [0, 0],
                background: NioApp.hexRGB("#798bff", 0.15),
                data: [4110, 4220, 4810, 5480, 4600, 5670, 6660, 4830, 5590, 5730, 4790, 4950, 5100, 5800, 5950, 5850, 5950, 4450, 4900, 8e3, 7200, 7250, 7900, 8950, 6300, 7200, 7250, 7650, 6950, 4750],
            },
        ],
    };
    function analyticsLineLarge(selector, set_data) {
        var $selector = $(selector || ".analytics-line-large");
        $selector.each(function () {
            for (
                var $self = $(this), _self_id = $self.attr("id"), _get_data = void 0 === set_data ? eval(_self_id) : set_data, selectCanvas = document.getElementById(_self_id).getContext("2d"), chart_data = [], i = 0;
                i < _get_data.datasets.length;
                i++
            )
                chart_data.push({
                    label: _get_data.datasets[i].label,
                    tension: _get_data.lineTension,
                    backgroundColor: _get_data.datasets[i].background,
                    fill: !0,
                    borderWidth: 2,
                    borderDash: _get_data.datasets[i].dash,
                    borderColor: _get_data.datasets[i].color,
                    pointBorderColor: "transparent",
                    pointBackgroundColor: "transparent",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: _get_data.datasets[i].color,
                    pointBorderWidth: 2,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                    pointHitRadius: 4,
                    data: _get_data.datasets[i].data,
                });
            var chart = new Chart(selectCanvas, {
                type: "line",
                data: { labels: _get_data.labels, datasets: chart_data },
                options: {
                    plugins: {
                        legend: { display: _get_data.legend || !1, labels: { boxWidth: 12, padding: 20, color: "#6783b8" } },
                        tooltip: {
                            enabled: !0,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                label: function (a) {
                                    return "".concat(a.parsed.y, " ").concat(_get_data.dataUnit);
                                },
                            },
                            backgroundColor: "#fff",
                            borderColor: "#eff6ff",
                            borderWidth: 2,
                            titleFont: { size: 13 },
                            titleColor: "#6783b8",
                            titleMarginBottom: 6,
                            bodyColor: "#9eaecf",
                            bodyFont: { size: 12 },
                            bodySpacing: 4,
                            padding: 10,
                            footerMarginTop: 0,
                            displayColors: !1,
                        },
                    },
                    maintainAspectRatio: !1,
                    scales: {
                        y: {
                            display: !0,
                            position: NioApp.State.isRTL ? "right" : "left",
                            ticks: { beginAtZero: !0, font: { size: 12 }, color: "#9eaecf", padding: 8, stepSize: 2400 },
                            grid: { color: NioApp.hexRGB("#526484", 0.2), tickLength: 0, zeroLineColor: NioApp.hexRGB("#526484", 0.2), drawTicks: !1 },
                        },
                        x: {
                            display: !1,
                            ticks: { font: { size: 12 }, color: "#9eaecf", source: "auto", padding: 0, reverse: NioApp.State.isRTL },
                            grid: { color: "transparent", tickLength: 0, zeroLineColor: "transparent", offset: !0, drawTicks: !1 },
                        },
                    },
                },
            });
        });
    }
    NioApp.coms.docReady.push(function () {
        analyticsLineLarge();
    });
    var BookingData = { labels: ["Singles", "Doubles", "Dluxa", "Suits"], dataUnit: "People", legend: !1, datasets: [{ borderColor: "#fff", background: ["#798bff", "#1ee0ac", "#f9db7b", "#ffa353"], data: [3305, 859, 482, 1380] }] };
    function analyticsDoughnut(selector, set_data) {
        var $selector = $(selector || ".analytics-doughnut");
        $selector.each(function () {
            for (
                var $self = $(this), _self_id = $self.attr("id"), _get_data = void 0 === set_data ? eval(_self_id) : set_data, selectCanvas = document.getElementById(_self_id).getContext("2d"), chart_data = [], i = 0;
                i < _get_data.datasets.length;
                i++
            )
                chart_data.push({ backgroundColor: _get_data.datasets[i].background, borderWidth: 2, borderColor: _get_data.datasets[i].borderColor, hoverBorderColor: _get_data.datasets[i].borderColor, data: _get_data.datasets[i].data });
            var chart = new Chart(selectCanvas, {
                type: "doughnut",
                data: { labels: _get_data.labels, datasets: chart_data },
                options: {
                    plugins: {
                        legend: { display: _get_data.legend || !1, labels: { boxWidth: 12, padding: 20, color: "#6783b8" } },
                        tooltip: {
                            enabled: !0,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                label: function (a) {
                                    return "".concat(a.parsed, " ").concat(_get_data.dataUnit);
                                },
                            },
                            backgroundColor: "#fff",
                            borderColor: "#eff6ff",
                            borderWidth: 2,
                            titleFont: { size: 13 },
                            titleColor: "#6783b8",
                            titleMarginBottom: 6,
                            bodyColor: "#9eaecf",
                            bodyFont: { size: 12 },
                            bodySpacing: 4,
                            padding: 10,
                            footerMarginTop: 0,
                            displayColors: !1,
                        },
                    },
                    rotation: -1.5,
                    cutoutPercentage: 70,
                    maintainAspectRatio: !1,
                },
            });
        });
    }
    NioApp.coms.docReady.push(function () {
        analyticsDoughnut();
    });
    var totalRoom = {
            labels: ["01 Jan", "02 Jan", "03 Jan", "04 Jan", "05 Jan", "06 Jan", "07 Jan"],
            dataUnit: "Room",
            stacked: !0,
            datasets: [
                {
                    label: "User",
                    color: [NioApp.hexRGB("#6576ff", 0.2), NioApp.hexRGB("#6576ff", 0.2), NioApp.hexRGB("#6576ff", 0.2), NioApp.hexRGB("#6576ff", 0.2), NioApp.hexRGB("#6576ff", 0.2), NioApp.hexRGB("#6576ff", 0.2), "#6576ff"],
                    data: [12, 15, 6, 5, 15, 7, 8],
                },
            ],
        },
        totalBooking = {
            labels: ["01 Jan", "02 Jan", "03 Jan", "04 Jan", "05 Jan", "06 Jan", "07 Jan"],
            dataUnit: "Room",
            stacked: !0,
            datasets: [
                {
                    label: "User",
                    color: [NioApp.hexRGB("#816bff", 0.2), NioApp.hexRGB("#816bff", 0.2), NioApp.hexRGB("#816bff", 0.2), NioApp.hexRGB("#816bff", 0.2), NioApp.hexRGB("#816bff", 0.2), NioApp.hexRGB("#816bff", 0.2), "#816bff"],
                    data: [120, 150, 80, 69, 50, 105, 75],
                },
            ],
        },
        totalExpenses = {
            labels: ["01 Jan", "02 Jan", "03 Jan", "04 Jan", "05 Jan", "06 Jan", "07 Jan"],
            dataUnit: "USD",
            stacked: !0,
            datasets: [
                {
                    label: "Expenses",
                    color: [NioApp.hexRGB("#559bfb", 0.2), NioApp.hexRGB("#559bfb", 0.2), NioApp.hexRGB("#559bfb", 0.2), NioApp.hexRGB("#559bfb", 0.2), NioApp.hexRGB("#559bfb", 0.2), NioApp.hexRGB("#559bfb", 0.2), "#559bfb"],
                    data: [600, 700, 800, 500, 600, 500, 1200],
                },
            ],
        };
    function ivDataChart(selector, set_data) {
        var $selector = $(selector || ".iv-data-chart");
        $selector.each(function () {
            for (
                var $self = $(this),
                    _self_id = $self.attr("id"),
                    _get_data = void 0 === set_data ? eval(_self_id) : set_data,
                    _d_legend = void 0 !== _get_data.legend && _get_data.legend,
                    selectCanvas = document.getElementById(_self_id).getContext("2d"),
                    chart_data = [],
                    i = 0;
                i < _get_data.datasets.length;
                i++
            )
                chart_data.push({
                    label: _get_data.datasets[i].label,
                    data: _get_data.datasets[i].data,
                    backgroundColor: _get_data.datasets[i].color,
                    borderWidth: 2,
                    borderColor: "transparent",
                    hoverBorderColor: "transparent",
                    borderSkipped: "bottom",
                    barPercentage: 0.9,
                    categoryPercentage: 0.95,
                });
            var chart = new Chart(selectCanvas, {
                type: "bar",
                data: { labels: _get_data.labels, datasets: chart_data },
                options: {
                    plugins: {
                        legend: { display: _get_data.legend || !1, labels: { boxWidth: 30, padding: 20, color: "#6783b8" } },
                        tooltip: {
                            enabled: !0,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                title: function () {
                                    return !1;
                                },
                                label: function (a) {
                                    return "".concat(a.parsed.y, " ").concat(_get_data.dataUnit);
                                },
                            },
                            backgroundColor: "#eff6ff",
                            titleFont: { size: 11 },
                            titleColor: "#6783b8",
                            titleMarginBottom: 4,
                            bodyColor: "#9eaecf",
                            bodyFont: { size: 10 },
                            bodySpacing: 3,
                            padding: 8,
                            footerMarginTop: 0,
                            displayColors: !1,
                        },
                    },
                    maintainAspectRatio: !1,
                    scales: { y: { display: !1, stacked: _get_data.stacked || !1, ticks: { beginAtZero: !0 } }, x: { display: !1, stacked: _get_data.stacked || !1, ticks: { reverse: NioApp.State.isRTL } } },
                },
            });
        });
    }
    NioApp.coms.docReady.push(function () {
        ivDataChart();
    });
})(NioApp, jQuery);
