<?php

namespace app\component\widgets;

use app\component\widgets\BaseChartWidget;

class LineChartWidget extends BaseChartWidget
{
    protected function getChartInitJs($chartId, $data)
    {
        return <<<JS
        var root = am5.Root.new("$chartId");
       // root.setThemes([am5themes.Animated.new(root)]);
       
        var chart = root.container.children.push(
            am5xy.XYChart.new(root, {})
        );

        var xAxis = chart.xAxes.push(
            am5xy.CategoryAxis.new(root, {
                categoryField: "category",
                renderer: am5xy.AxisRendererX.new(root, {})
            })
        );

        var yAxis = chart.yAxes.push(
            am5xy.ValueAxis.new(root, {
                renderer: am5xy.AxisRendererY.new(root, {})
            })
        );

        var series = chart.series.push(
            am5xy.LineSeries.new(root, {
                name: "Series",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "value",
                categoryXField: "category",
                stroke: am5.color(0x3366cc)
            })
        );

        series.strokes.template.setAll({ strokeWidth: 2 });

        var data = $data;
        xAxis.data.setAll(data);
        series.data.setAll(data);
JS;
    }
}
