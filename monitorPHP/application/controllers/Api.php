<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Api extends REST_Controller{
    function __construct(){
        parent::__construct();
    }
    function metric_get()
    {
        $metric_type=$_GET["metric_type"];
        $result = [];
        $metric1 = array("metric_id" => "", "metric_name" => "", "description" => "", "metric_type" => "", "unit" => "");
        array_push($result, $metric1);
        $this->response($result);
    }

//function cloudlet_group_all_get(){
//    $cloudlet_group=array("cloudlet_group_id"=>"","cloudlet_group_name"=>"");
//    $result=[];
//    array_push($result,$cloudlet_group);
//    $this->responese($result);
//
//}

    function cloudlet_group_get($container_id)
    {
        $limit=$_GET["limit"];
        if (container_id==null){
            $cloudlet_group=array("cloudlet_group_id"=>"","cloudlet_group_name"=>"");
            $result=[];
            array_push($result,$cloudlet_group);
            $this->responese($result);
        } else {
            $cloudlet = array(
                "cloudlet_name" => "",
                "cloutlet_id" => "$container_id"
            );
            $result = array(
                "cloudlet_group_id" => "",
                "cloudlet_group_name" => "",
                "cloudlets" => []);
            array_push($result["cloudlets"], $cloudlet);
            $this->response($result);
        }
    }

    function cloudlet_get(){
        $result=array(
            "cloudlet_group_id"=>"",
            "cloudlet_group_name"=>"",
            "cloudlet_id"=>"",
            "cloudlet_name"=>"",
            "pms"=>[]
        );
        $pms=array(
            "pms_id"=>"",
            "pms_name"=>""
        );
        array_push($result["pms"],$pms);
        $this->response($result);
    }

    function server_get(){
        $result=array(
            "cloudlet_group_id"=>"",
            "cloudlet_group_name"=>"",
            "cloudlet_id"=>"",
            "cloudlet_name"=>"",
            "pm_id"=>"",
            "pm_name"=>"",
            "containers"=>[]
        );
        $container=array(
            "container_id"=>"",
            "container_name"=>"",
            "container_type"=>""
        );
        array_push($result["containers"],$container);
        $this->response($result);
    }

    function container_summary_get(){
        $result=array(
            "pm_id"=>"",
            "pm_name"=>"",
            "cpu"=>[],
            "memory"=>[],
            "disk"=>[]
        );

        $cpu=array(
            "timestamp"=>"",
            "metric_id"=> "",
            "metric_name"=>"",
            "value"=> ""
        );
        $memory=array(
            "timestamp"=>"",
            "metric_id"=> "",
            "metric_name"=>"",
            "value"=> ""
        );
        $disk=array(
            "timestamp"=>"",
            "metric_id"=> "",
            "metric_name"=>"",
            "value"=> ""
        );


        array_push($result["cpu"],$cpu);
        array_push($result["memory"],$memory);
        array_push($result["disk"],$disk);
        $this->response($result);
    }

    function pm_summary_get(){
        $result=array(
            "cloudlet_id"=>"",
            "cloudlet_name"=>"",
            "cpu"=>[],
            "memory"=>[],
            "disk"=>[]
        );

        $cpu=array(
            "timestamp"=>"",
            "metric_id"=> "",
            "metric_name"=>"",
            "value"=> ""
        );
        $memory=array(
            "timestamp"=>"",
            "metric_id"=> "",
            "metric_name"=>"",
            "value"=> ""
        );
        $disk=array(
            "timestamp"=>"",
            "metric_id"=> "",
            "metric_name"=>"",
            "value"=> ""
        );


        array_push($result["cpu"],$cpu);
        array_push($result["memory"],$memory);
        array_push($result["disk"],$disk);
        $this->response($result);
    }


    function cloudlet_summary_get(){
        $result=array(
            "cloudlet_group_id"=>"",
            "cloudlet_group_name"=>"",
            "cpu"=>[],
            "memory"=>[],
            "disk"=>[]
        );

        $cpu=array(
            "timestamp"=>"",
            "metric_id"=> "",
            "metric_name"=>"",
            "value"=> ""
        );
        $memory=array(
            "timestamp"=>"",
            "metric_id"=> "",
            "metric_name"=>"",
            "value"=> ""
        );
        $disk=array(
            "timestamp"=>"",
            "metric_id"=> "",
            "metric_name"=>"",
            "value"=> ""
        );


        array_push($result["cpu"],$cpu);
        array_push($result["memory"],$memory);
        array_push($result["disk"],$disk);
        $this->response($result);
    }


    function container_detail_get()
    {
        error_reporting(E_ALL || ~E_NOTICE);
        $this->load->database();
        $cg_id = $_GET["cg_id"];
        $cl_id = $_GET["cl_id"];
        $se_id = $_GET["se_id"];
        $container_id = $_GET["container_id"];
        $limit = $_GET["limit"];
        $metric_type = $_GET["metric_type"];
        $time_start = $_GET["time_start"];
        $time_end = $_GET["time_end"];
        $result = array(
            "container_id" => $container_id,
            "container_name" => "",
            "container_type" => "",
            "cpu" => [],
            "memory"=>[],
            "disk"=>[]);

        if ($limit==null) $limit=20;
        if ($time_start==null) $time_start=0;
        if ($time_end==null) $time_end=PHP_INT_MAX;

//    $cpu = array("timestamp" => "", "metric_id" => "", "metric_name" => "", "value" => "");

        $sqlString="select * from " . $container_id ." where ".timestap." > ".$time_start." and ".timestap.
            "<". $time_end." limit " .$limit;
        $query=$this->db->query($sqlString);
        foreach ($query->result() as $row){
            $wio=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"cpu_wio","value"=>$row->cpu_wio);
            $cpu_idle=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"cpu_idle","value"=>$row->cpu_idle);
        array_push($result["cpu"],$wio,$$cpu_idle);
        $memory_free=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"memory_free","value"=>$row->mem_free);
        $memory_cache=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"memory_cache","value"=>$row->mem_cache);
        array_push($result["memory"],$memory_free,$memory_cache);
        $disk_total=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"disk_total","value"=>$row->disk_total);
        $disk_free=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"disk_free","value"=>$row->disk_free);
        array_push($result["disk"],$disk_total,$disk_free);
    }

//    array_push($result["cpu"], $cpu);
        $this->response($result);

    }



    function server_detail_get(){
        $result=array(
            "server_id"=>"",
            "server_name"=>"",
            "cpu"=>[],
            "memory"=>[],
            "disk"=>[]
        );

        $cpu=array(
            "timestamp"=>"",
            "metric_id"=> "",
            "metric_name"=>"",
            "value"=> ""
        );
        $memory=array(
            "timestamp"=>"",
            "metric_id"=> "",
            "metric_name"=>"",
            "value"=> ""
        );
        $disk=array(
            "timestamp"=>"",
            "metric_id"=> "",
            "metric_name"=>"",
            "value"=> ""
        );
        array_push($result["cpu"],$cpu);
        array_push($result["memory"],$memory);
        array_push($result["disk"],$disk);
        $this->response($result);
    }

    function container_now_get($container_id)
    {
        error_reporting(E_ALL || ~E_NOTICE);
        $this->load->database();
        $cg_id = $_GET["cg_id"];
        $cl_id = $_GET["cl_id"];
        $se_id = $_GET["se_id"];
        $metric_type = $_GET["metric_type"];
        $result = array(
            "container_id" => $container_id,
            "container_name" => "",
            "container_type" => "",
            "cpu" => [],
            "memory"=>[],
            "disk"=>[],
            "io"=>[]
        );
        $sqlString="select * from ".$container_id." where timestap=(select max(timestap) from ".$container_id." )";

        $query=$this->db->query($sqlString);
        foreach ($query->result() as $row){
            $cpu_user=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"cpu_user","value"=>$row->cpu_user);
            $cpu_idle=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"cpu_idle","value"=>$row->cpu_idle);

            array_push($result["cpu"],$cpu_user,$cpu_idle);
            $memory_free=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"memory_free","value"=>$row->mem_free);
            $memory_cache=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"memory_cache","value"=>$row->mem_cache);
            $memory_buffer=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"memory_buffer","value"=>$row->mem_buffer);
            $memory_shared=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"memory_shared","value"=>$row->mem_shared);

            array_push($result["memory"],$memory_free,$memory_cache,$memory_shared,$memory_buffer);

            $disk_total=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"disk_total","value"=>$row->disk_total);
            $disk_free=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"disk_free","value"=>$row->disk_free);
            array_push($result["disk"],$disk_total,$disk_free);

            $pkts_out=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"pkts_out","value"=>$row->pkts_out);
            $pkts_in=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"pkts_in","value"=>$row->pkts_in);
            $bytes_in=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"bytes_in","value"=>$row->bytes_in);
            $bytes_out=array("timestap"=>$row->timestap,"metric_id"=>"","metric_name"=>"bytes_out","value"=>$row->bytes_out);
            array_push($result["io"],$pkts_in,$pkts_out,$bytes_in,$bytes_out);
        }
//    array_push($result["cpu"], $cpu);
        $this->response($result);

    }


}
