<?php

namespace app\component\widgets;

class XYBubbleChartWidget extends BaseChartWidget
{
    protected function getChartInitJs($chartId, $data)
    {
        return <<<JS
        var root = am5.Root.new("$chartId");
       // root.setThemes([am5themes.Animated.new(root)]);

        var chart = root.container.children.push(
            am5xy.XYChart.new(root, {
                panX: true,
                panY: true,
                wheelX: "panX",
                wheelY: "zoomX"
            })
        );

        var xAxis = chart.xAxes.push(
            am5xy.ValueAxis.new(root, {
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
                xAxis: xAxis,
                yAxis: yAxis,
                valueXField: "x",
                valueYField: "y",
                valueField: "value",
                tooltip: am5.Tooltip.new(root, {
                    labelText: "x: {valueX}, y: {valueY}, size: {value}"
                })
            })
        );

        series.bullets.push(function () {
            return am5.Bullet.new(root, {
                sprite: am5.Circle.new(root, {
                    radius: 5,
                    fill: series.get("fill")
                })
            });
        });

        var data = $data;
        series.data.setAll(data);
JS;
    }
}
