<?php

/**
 * 图形向导
 * @author yangtl
 */
class Chart
{
	
    /**
     * ‘单系列图’的SWF路径
     * @param <type> $v
     * @return <type>
     */

    public static function getSingleSWF($v='')
    {
    	$jspath =  "view/".TPL_NAME."/js/ChartFree";
    	
        $rs = array(
            'line' => $jspath.'/swf/FCF_Line.swf', //直线图
            'pie' => $jspath.'/swf/FCF_Pie2D.swf', //饼状图
            'bar' => $jspath.'/swf/FCF_Bar2D.swf', //条状图
            'column' => $jspath.'/swf/FCF_Column2D.swf', //柱状图
            'area' => $jspath.'/swf/FCF_Area2D.swf', //区域图
        );
        return ((string) $v !== '') ? $rs[$v] : $rs;
    }

    /**
     * ‘多系列图’的SWF路径
     * @param <type> $v
     * @return <type>
     */
    public static function getMultiSWF($v='')
    {
    	$jspath =  "view/".TPL_NAME."/js/ChartFree";
    	
        $rs = array(
            'line' => $jspath.'/swf/FCF_MSLine.swf', //直线图
            'bar' =>  $jspath.'/swf/FCF_MSBar2D.swf', //条状图
            'column' => $jspath.'/swf/FCF_MSColumn2D.swf', //柱状图
            'area' => $jspath.'/swf/FCF_MSArea2D.swf', //区域图
        );
        return ((string) $v !== '') ? $rs[$v] : $rs;
    }

    /**
     * ‘组合图’的SWF路径
     * @param <type> $v
     * @return <type>
     */
    public static function getCombiSWF($v='')
    {
    	$jspath =  "view/".TPL_NAME."/js/ChartFree";
        return $jspath.'/swf/FCF_MSColumn2DLineDY.swf';
    }

    public static function getDataColor($v='')
    {
        $rs = array(
            0 => 'AFD8F8',
            1 => 'F6BD0F',
            2 => '8BBA00',
            3 => 'F00E46',
            4 => '008E8E',
            5 => 'D64646',
            6 => '8E468E',
            7 => '588526',
            8 => 'B3AA00',
            9 => '008ED6',
            10 => '9D080D',
            11 => 'A186BE',
            12 => '888888',
            13 => 'DAA520',
            14 => '87CEFA',
        );
        return ((string) $v !== '') ? $rs[$v] : $rs;
    }

    /**
     * 图形向导
     * @param array $render 图表类型  array('render'=>...,'swf'=>..)
     * @param array $datasets <dataset> 图表数据
     * @param array $graph <graph> 标签属性
     * @param array $categories <categories> x轴坐标
     */
    public static function renderChart($render,$datasets,$graph=array(),$categories=array())
    {
        $r = array();

        //请求格式
        if (!$render['render']):
            $r['error'] = '缺少请求图表格式信息';
            return $r;
        endif;

        //单系列图
        if ($render['render'] == 'renderSingle'):
            return Chart::renderSingle($render,$graph,$datasets);
        endif;

        //多系列图
        if ($render['render'] == 'renderMulti'):
            return Chart::renderMulti($render,$graph,$categories,$datasets);
        endif;

        //双Y轴组合图
        if ($render['render'] == 'renderCombi'):
            return Chart::renderCombi($render,$graph,$categories,$datasets);
        endif;

        $r['error'] = '请求的图表格式不存在';
        return $r;
    }

    /**
     * 生成‘组合图’
     * @param array $render 图表类型  array('render'=>...,'swf'=>..)
     * @param array $graph <graph> 标签属性 array('caption'=>..)
     * @param array $categories <categories> x轴坐标
     * @param array $datasets <dataset> 图表数据 
     * 			array('datasetP'=>array('0'=>array('seriesName'=>..,'rows'=>array()),...),
     * 				  'datasetS'=>array('0'=>array('seriesName'=>..,'rows'=>array()),...))
     */
    public static function renderCombi($render,$graph,$categories,$datasets)
    {
        $r = array();
        
        //X轴字段
        if (!$categories):
            $r['error'] = '请选择用于X轴的字段';
            return $r;
        endif;

        //左Y轴字段
        if (is_array($datasets['datasetP']) == false or count($datasets['datasetP']) == 0):
            $r['error'] = '请选择用于左Y轴的数据字段';
            return $r;
        endif;

        //右Y轴字段
        if (is_array($datasets['datasetS']) == false or count($datasets['datasetS']) == 0):
            $r['error'] = '请选择用于右Y轴的数据字段';
            return $r;
        endif;

        //生成X轴的XML
        $categoryXML = '<categories>';
        foreach ($categories as $category):
            $categoryXML.= "<category name='".$category."'></category>";
        endforeach;
        $categoryXML.= '</categories>';

        //生成左Y轴的XML
        $datasetXML = '';
        foreach ($datasets['datasetP'] as $i => $dataset):
            $color = Chart::getDataColor($i); //颜色
            $seriesName = $dataset['seriesName']; //序列名
            $datasetXML.= "<dataset seriesName='$seriesName' color='$color' >";
            foreach ($dataset['rows'] as $row):
                $datasetXML.= "<set value='".$row."'></set>";
            endforeach;
            $datasetXML.= '</dataset>';
        endforeach;

        //生成右Y轴的XML
       foreach ($datasets['datasetS'] as $j => $dataset):
            $color = Chart::getDataColor($i+$j+1); //颜色
            $seriesName = $dataset['seriesName']; //序列名
            $datasetXML.= "<dataset seriesName='$seriesName' color='$color' parentYAxis='S'>";
            foreach ($dataset['rows'] as $row):
                $datasetXML.= "<set value='".$row."'></set>";
            endforeach;
            $datasetXML.= '</dataset>';
        endforeach;
        
        $graph_attr = '';
        if(is_array($graph)){
        	foreach ($graph as $k => $v){
        		$graph_attr .= $k."='{$v}' ";
        	}
        }

        $dataXML = "<graph {$graph_attr} decimalPrecision='0' formatNumberScale='0' rotateNames='0' showValues='0' chartRightMargin='30'  basefontsize='13'  PYAxisMaxValue='5' SYAxisMaxValue='5'>";
        $dataXML.= $categoryXML;
        $dataXML.= $datasetXML;
        $dataXML.= '</graph>';


        $r['success'] = '操作成功';
        $r['dataXML'] = $dataXML;
        $r['dataSWF'] = Chart::getCombiSWF();
        return $r;
    }
    
    /**
     * 生成多序列图
     * @param array $render 图表类型  array('render'=>'renderMulti','swf'=>..)
     * @param array $graph <graph> 标签属性 array('caption'=>..)
     * @param array $categories <categories> x轴坐标
     * @param array $datasets <dataset> 图表数据
     * 			array('0'=>array('seriesName'=>..,'rows'=>array()),...)
     */
    
    public static function renderMulti($render,$graph,$categories,$datasets)
    {
        $r = array();
        
        //X轴字段
        if (!$categories):
            $r['error'] = '请选择用于X轴的字段';
            return $r;
        endif;

        //Y轴数据
        if (is_array($datasets) == false or count($datasets) == 0):
            $r['error'] = '请选择用于Y轴的数据字段';
            return $r;
        endif;

        //生成X轴的XML
        $categoryXML = '<categories>';
        foreach ($categories as $category):
            $categoryXML.= "<category name='".$category."'></category>";
        endforeach;
        $categoryXML.= '</categories>';

        //生成Y轴的XML
        $datasetXML = '';
        foreach ($datasets as $i => $dataset):
            $color = Chart::getDataColor($i); //颜色
            $seriesName = $dataset['seriesName']; //序列名
            $datasetXML.= "<dataset seriesName='$seriesName' color='$color' >";
            foreach ($dataset['rows'] as $row):
                $datasetXML.= "<set value='".$row."'></set>";
            endforeach;
            $datasetXML.= '</dataset>';
        endforeach;
        
        $graph_attr = '';
        if(is_array($graph)){
        	foreach ($graph as $k => $v){
        		$graph_attr .= $k."='{$v}' ";
        	}
        }

        $dataXML = "<graph  {$graph_attr}".
        	" decimalPrecision='0' formatNumberScale='0' formatNumber='0' rotateNames='0' showValues='0'".
        	" chartRightMargin='30'  basefontsize='13' yAxisMaxValue='10' numdivlines='9'>";
        $dataXML.= $categoryXML;
        $dataXML.= $datasetXML;
        $dataXML.= '</graph>';


        $r['success'] = '操作成功';
        $r['dataXML'] = $dataXML;
        $r['dataSWF'] = Chart::getMultiSWF($render['swf']);
        return $r;
    }
    
    
    /**
     * 生成单序列图表
     * @param array $render 图表类型  array('render'=>'renderSingle','swf'=>..)
     * @param array $graph <graph> 标签属性 array('caption'=>..)
     * @param array $datasets <set> 图表数据
     * 			array('0'=>array('name'=>,'value'=>),...)
     */
    
    public static function renderSingle($render,$graph,$sets)
    {
    	$r = array();
    
    	//数据
    	if (is_array($sets) == false or count($sets) == 0):
    	$r['error'] = '请选择用于Y轴的数据字段';
    	return $r;
    	endif;
    
    	//生成<set>数据的XML
    	$datasetXML = '';
    	foreach ($sets as $i => $set):
    		//$color = Chart::getDataColor($i); //颜色
    		$color = $set['color'];
    		$name = $set['name'];    //x轴名称
    		$value = $set['value'];  //y轴数据
    		$datasetXML .="<set name='{$name}' value='{$value}' color='{$color}' />";
    	endforeach;
    	
    	$graph_attr = '';
    	if(is_array($graph)){
    		foreach ($graph as $k => $v){
    			$graph_attr .= $k."='{$v}' ";
    		}
    	}
    	$dataXML = "<graph {$graph_attr} decimalPrecision='0' formatNumberScale='0' "
    		." basefontsize='12' showShadow='0' pieBorderAlpha='0' showPercentageValues='0' formatNumber='0'>";
    	$dataXML.= $datasetXML;
    	$dataXML.= '</graph>';
    
    
    	$r['success'] = '操作成功';
    	$r['dataXML'] = $dataXML;
    	$r['dataSWF'] = Chart::getSingleSWF($render['swf']);
    	return $r;
    }
    

}
