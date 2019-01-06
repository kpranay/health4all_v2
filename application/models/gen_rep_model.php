<?php
class Gen_rep_Model extends CI_Model {
    private $queries = array(    //'sbp,dbp,rbs,hb,hba1c'
        'query_name'=>array(
            'filters'=>array(   // set or false

            ),
            'where'=>array(

            ),
            'join_sequence'=>array(

            ),
            'group_by'=>array(

            ),
            'having'=>array(

            )
        ),
        'sbp'=>array(
            'filters'=>array(   // set or false
                '>='=>array('sbp-patient_visit.sbp')
            ),
            'select'=>'COUNT(*) as sbp',
            'from'=>'patient_visit',
            'where'=>false,
            'join_sequence'=>false,
            'group_by'=>false,
            'having'=>false
        ),
        'dbp'=>array(
            'filters'=>array(   // set or false
                '>='=>array('dbp-patient_visit.dbp')
            ),
            'select'=>'COUNT(*) as dbp',
            'from'=>'patient_visit',
            'where'=>false,
            'join_sequence'=>false,
            'group_by'=>false,
            'having'=>false
        ),
        'rbs'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '>='=>array('rbs-test.test_result')
            ),
            'select'=>'COUNT(*) as rbs',
            'from'=>'patient_visit',
            'where'=>array(
                ''=>array("test_master.test_name LIKE 'rbs'")
            ),             // test_master.test_name = rbs, 
            'join_sequence'=>array(
                'test_order.visit_id=patient_visit.visit_id',
                'test.order_id=test_order.order_id',
                'test_master.test_master_id=test.test_master_id'
            ),     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false
        ),
        'hb'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '>='=>array('hb-test.test_result')
            ),
            'select'=>'COUNT(*) as hb',
            'from'=>'patient_visit',
            'where'=>array(
                ''=>array("test_master.test_name LIKE 'hb'")
            ),             // test_master.test_name = rbs, 
            'join_sequence'=>array(
                'test_order.visit_id=patient_visit.visit_id',
                'test.order_id=test_order.order_id',
                'test_master.test_master_id=test.test_master_id'
            ),     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false
        ),
        'hba1c'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '>='=>array('hba1c-test.test_result')
            ),
            'select'=>'COUNT(*) as hb',
            'from'=>'patient_visit',
            'where'=>array(
                ''=>array("test_master.test_name LIKE 'hba1c'")
            ),             // test_master.test_name = rbs, 
            'join_sequence'=>array(
                'test_order.visit_id=patient_visit.visit_id',
                'test.order_id=test_order.order_id',
                'test_master.test_master_id=test.test_master_id'
            ),     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false
        ),
        'nsbp'=>array(
            'filters'=>array(   // set or false
                '<'=>array('sbp-patient_visit.sbp')
            ),
            'select'=>'COUNT(*) as sbp',
            'from'=>'patient_visit',
            'where'=>false,
            'join_sequence'=>false,
            'group_by'=>false,
            'having'=>false
        ),
        'ndbp'=>array(
            'filters'=>array(   // set or false
                '<'=>array('dbp-patient_visit.dbp')
            ),
            'select'=>'COUNT(*) as dbp',
            'from'=>'patient_visit',
            'where'=>false,
            'join_sequence'=>false,
            'group_by'=>false,
            'having'=>false
        ),
        'nrbs'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '<'=>array('rbs-test.test_result')
            ),
            'select'=>'COUNT(*) as rbs',
            'from'=>'patient_visit',
            'where'=>array(
                ''=>array("test_master.test_name LIKE 'rbs'")
            ),             // test_master.test_name = rbs, 
            'join_sequence'=>array(
                'test_order.visit_id=patient_visit.visit_id',
                'test.order_id=test_order.order_id',
                'test_master.test_master_id=test.test_master_id'
            ),     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false
        ),
        'nhb'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '<'=>array('hb-test.test_result')
            ),
            'select'=>'COUNT(*) as hb',
            'from'=>'patient_visit',
            'where'=>array(
                ''=>array("test_master.test_name LIKE 'hb'")
            ),             // test_master.test_name = rbs, 
            'join_sequence'=>array(
                'test_order.visit_id=patient_visit.visit_id',
                'test.order_id=test_order.order_id',
                'test_master.test_master_id=test.test_master_id'
            ),     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false
        ),
        'nhba1c'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '<'=>array('hba1c-test.test_result')
            ),
            'select'=>'COUNT(*) as hb',
            'from'=>'patient_visit',
            'where'=>array(
                ''=>array("test_master.test_name LIKE 'hba1c'")
            ),             // test_master.test_name = rbs, 
            'join_sequence'=>array(
                'test_order.visit_id=patient_visit.visit_id',
                'test.order_id=test_order.order_id',
                'test_master.test_master_id=test.test_master_id'
            ),     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false
        ),
    );
    
    function __construct() {
        parent::__construct();
    }

    function simple_join($query, $post_data) {
        // Failure condition
        if(!array_key_exists($query, $this->queries))
            return false;
        // query extraction
        $select = $this->queries[$query]['select'] ? $this->queries[$query]['select'] : array();
        $from = $this->queries[$query]['from'] ? $this->queries[$query]['from'] : array();
        $filters = $this->queries[$query]['filters'] ? $this->queries[$query]['filters'] : array();
        $where = $this->queries[$query]['where'] ? $this->queries[$query]['where'] : array();
        $join_sequence = $this->queries[$query]['join_sequence'] ? $this->queries[$query]['join_sequence'] : array();
        $group_by = $this->queries[$query]['group_by'] ? $this->queries[$query]['group_by'] : array();
        $having = $this->queries[$query]['having'] ? $this->queries[$query]['having'] : array();
        
        $this->db->select($select);
        $this->db->from($from);
        // Filters{operator=>array(input_key-table_name.column_name)}
        foreach($filters as $op => $filters) {
            foreach($filters as $filter){
                $temp = explode('-', $filter);
                $column = '';
                $input = '';
                if(sizeof($temp)>1){
                    $input = $temp[0];
                    $column = $temp[1];
                } else {
                    $temp = explode('.', $filter);
                    $input = $temp[1];
                    $column = $filter;
                }
                if(array_key_exists($input, $post_data)) {
                    $value = $post_data[$input];
                    $this->db->where("$column ".$op, "$value");
                }
            }
        }
        // Default where condition // Date
        // Set to today and submit by default
        if(array_key_exists('from_date', $post_data) && array_key_exists('to_date', $post_data)){
            if($post_data['from_date']){
                $from_date = date("Y-m-d",strtotime($post_data['from_date']));
                $to_date = date("Y-m-d",strtotime($post_data['to_date']));
                $this->db->where('('.$from.'.admit_date BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
            }
        }
        else {
            $date = date("Y-m-d");
            $this->db->where('('.$from.'.admit_date BETWEEN "'.$date.'" AND "'.$date.'")');
        }

        // Where conditions{string}{(operator_value-table_name.column_name)}
        foreach($where as $op => $columns) {
            foreach($columns as $column){
                $temp = explode('-', $column);
                if($op != ''){
                    $this->db->where("$temp[1] ".$op, "$temp[0]");
                }else {
                    $this->db->where("$column");
                }
                
            }
        }
        // Join conditions{join_from_table_name.column_name, join_to_table_name.column_name}
        foreach($join_sequence as $join) {
            $tables = explode('=', $join);
            $temp = explode('.', $tables[0]);
            $table_one = $temp[0];
            $this->db->join("$table_one", "$join", 'left');
        }
        // Group by conditions{table_name.column_name, table_name.column_name}{string}
        foreach($group_by as $group) {
            $this->db->group_by("$group");
        }
        // Having conditions{$op=>value-table_name.column_name}
        foreach($having as $op => $column) {
            $value = explode('-', $column);
            $value = $value[0];
            $this->db->having("$column $op $value");
        }
        // Execute query
        $query = $this->db->get();
//        echo $this->db->last_query().'<br>';
    
        $result = $query->result();

        return $result;
    }
}