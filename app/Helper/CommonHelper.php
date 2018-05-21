<?php

namespace App\Helper;
use DB;

class CommonHelper
{
    public static function debug($dt=null,$true=false)
    {
        if(defined('DEBUG_REMOTE_ADDR') && $_SERVER['REMOTE_ADDR'] != DEBUG_REMOTE_ADDR) return;
        $bt = debug_backtrace();
        $caller = array_shift($bt);
        $file_line = "<strong>" . $caller['file'] . "(line " . $caller['line'] . ")</strong>\n";
        echo "<br/>";
            print_r ( $file_line );
        echo "<br/>";
        echo "<pre>";
            print_r($dt);
        echo "</pre>";
        if($true)
        {
            die("<b>die();</b>");
        } 
    }
    
    public static function generateDataTables($sql = [], $columns=[], $search=[], $data_id_field = ''){
        $obj = new CommonHelper();
        if(!empty($_REQUEST)){
            
            $requestData = $_REQUEST;
            $final_sql='';

            $main_sql = $sql['sql'];
            $group_by='';
            $order_by='';
            // set where condition
            if(isset($sql['sql']) && $sql['sql']!=''){
                $where =" WHERE {$sql['where']}";
            }else{
                $where =" WHERE 1=1";
            }
            if(isset($sql['group_by']) && $sql['group_by']!=''){
                $group_by =" GROUP BY {$sql['group_by']}";
            }
            if(isset($sql['order_by']) && $sql['order_by']!=''){
                $order_by =" ORDER BY {$sql['order_by']}";
            }
            $final_sql = $main_sql.$where.$group_by.$order_by;
            
            
            //$query = $this->db->query($final_sql);
            //$data = $query->result_array();
            $query = DB::select($final_sql);
            //$obj->debug(count($query),1);
            $data = $query;
            $totalData = count($query);
            $totalFiltered = $totalData;

            if( !empty($requestData['search']['value']) ) {
                $first =0;
                foreach($search as $col){
                    if($first==0){
                        $where .= " AND {$col} LIKE '".$requestData['search']['value']."%' ";
                    }else{
                        $where .="OR {$col} LIKE '".$requestData['search']['value']."%' ";
                    }
                    $first++;
                }
                $final_sql = $main_sql.$where.$group_by;

                //$query=$this->db->query($final_sql);
                //$totalFiltered = $query->num_rows(); 
                $query = DB::select($final_sql);
                $totalFiltered = count($query);
                
                $final_sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
                //$query=$this->db->query($final_sql);
                $query = DB::select($final_sql);
                
                // again run query with limit
            } else {
                $order_by =" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

                // echo  $main_sql.$where.$group_by.$order_by;
                $final_sql = $main_sql.$where.$group_by.$order_by;
                //$query=$this->db->query($final_sql);
                $query = DB::select($final_sql);
            }
            $data = $query;
           // dd($data);
            
            $finalData =[];
            foreach($data as $val){
                $temp =[];
                foreach ($columns as $col){
                    $temp[] = $val->$col;
                }
                $temp['DT_RowId'] = 'row_'.$val->$data_id_field;
                $temp['DT_RowClass'] = 'rows';
                // if(!empty($key)){
                //     $temp[] = str_replace('__KEY__', $val[$key], $action);
                // }
                $finalData[] = $temp;
            }
            $json_data = array(
                "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
                "recordsTotal"    => intval( $totalData ),  // total number of records
                "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $finalData   // total data array
            );
            return $json_data;
        }
        
    }
}
