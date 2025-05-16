<?php

namespace app\component\widgets;

class PiesChartWidget extends BaseChartWidget
{
    protected function getChartInitJs($chartId, $data)
    {
        return <<<JS
        var root = am5.Root.new("$chartId");
        //root.setThemes([am5themes.Animated.new(root)]);

        var chart = root.container.children.push(
            am5percent.PieChart.new(root, {
                layout: root.verticalLayout
            })
        );

        
        var series = chart.series.push(
            am5percent.PieSeries.new(root, {
                valueField: "value",
                categoryField: "category"
            })
        );
        
        series.data.setAll($data);
JS;
    }
}
