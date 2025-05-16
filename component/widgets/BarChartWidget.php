<?php
namespace app\component\widgets;

class BarChartWidget extends BaseChartWidget
{
    protected function getChartInitJs($chartId, $data)
    {
        return <<<JS
        var root = am5.Root.new("$chartId");
        //root.setThemes([am5themes.Animated.new(root)]);

        var chart = root.container.children.push(
            am5xy.XYChart.new(root, {
                panX: true,
                panY: true,
                wheelX: "panX",
                wheelY: "zoomX",
                pinchZoomX: true
            })
        );

        var xAxis = chart.xAxes.push(
            am5xy.CategoryAxis.new(root, {
                categoryField: "category",
                renderer: am5xy.AxisRendererX.new(root, { minGridDistance: 30 })
            })
        );

        var yAxis = chart.yAxes.push(
            am5xy.ValueAxis.new(root, {
                renderer: am5xy.AxisRendererY.new(root, {})
            })
        );

        var series = chart.series.push(
            am5xy.ColumnSeries.new(root, {
                name: "Series 1",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "value",
                categoryXField: "category"
            })
        );

        var data = $data;
        xAxis.data.setAll(data);
        series.data.setAll(data);
JS;
    }
}
