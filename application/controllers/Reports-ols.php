<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

 
	public function index()
	{
		 
	}
    
    public function core_maker_reports()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_core_maker_id'] = $srch_core_maker_id = $this->input->post('srch_core_maker_id'); 
           $data['srch_key'] = $srch_key = $this->input->post('srch_key'); 
           //$this->session->set_userdata('srch_from_date', $this->input->post('srch_from_date'));
           //$this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date'));
           //$this->session->set_userdata('srch_core_maker_id', $this->input->post('srch_core_maker_id'));
           //$this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_from_date')){
           $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ;
           $data['srch_core_maker_id'] = $srch_core_maker_id = $this->session->userdata('srch_core_maker_id') ;
           $data['srch_key'] = $srch_key = $this->session->userdata('srch_key') ;
       } else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
        $data['srch_core_maker_id'] = $srch_core_maker_id = '';
        $data['srch_key'] = $srch_key = '';
       }
       $where = " 1=1 ";
       if(!empty($srch_from_date) && !empty($srch_to_date) && !empty($srch_core_maker_id) ){
        $where .= " and a.core_plan_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
        $where .= " and a.core_maker_id = '". $srch_core_maker_id ."' "; 
        
        $data['submit_flg'] = true;
         
       }  
       
       if(!empty($srch_key)) {
         $where .= " and ( 
                        b.pattern_item like '%" . $srch_key . "%' or 
                        c.core_item_name like '%". $srch_key ."%'  
                        ) ";
                        
          $data['submit_flg'] = true;              
         
       } 
        
        $sql = "
                select  
                a.core_maker_id,                
                a.company_name as company  
                from core_maker_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['core_maker_opt'][$row['core_maker_id']] =  $row['company']   ;     
        }
        
        if($data['submit_flg']) {
        
         
        
        $sql = "
                select  
                a.core_plan_date,
                b.pattern_item as item,
                c.core_item_name as core_item,
                a.produced_qty,
                a.damage_qty,
                a.core_maker_rate ,
                (a.core_maker_rate * (a.produced_qty - a.damage_qty)) as amount
                from core_plan_info as a
                left join pattern_info as b on b.pattern_id = a.pattern_id
                left join core_item_info as c on c.core_item_id = a.core_item_id and c.pattern_id = b.pattern_id
                where a.`status` != 'Delete' and c.status = 'Active' and
                $where      
                order by a.core_plan_date asc , b.pattern_item asc                           
                          
        ";
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        //$data['pagination'] = $this->pagination->create_links();
        }
        
        $this->load->view('page/reports/core_maker_report',$data); 
	}  
    
    public function core_maker_master_rate()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_core_maker_id'])) {
            $data['srch_core_maker_id'] = $srch_core_maker_id = $this->input->post('srch_core_maker_id');  
       } else { 
        $data['srch_core_maker_id'] = $srch_core_maker_id = ''; 
       }
       $where = " 1=1 ";
       if(!empty($srch_core_maker_id) ){
         $where .= " and a.core_maker_id = '". $srch_core_maker_id ."' "; 
        
        $data['submit_flg'] = true;
         
       }  
       
       
       $sql = "
                select 
                a.core_maker_id,                
                a.company_name as company  
                from core_maker_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['core_maker_opt'][$row['core_maker_id']] =  $row['company']   ;     
        }
       
       
       if($this->input->post('export') == 'xls')
       {
          $this->load->library("excel");
          $this->excel->setActiveSheetIndex(0);
         // $this->excel->setActiveSheetIndexByName($data['core_maker_opt'][$srch_core_maker_id]);
          
        $query = $this->db->query(" 
              select  
                d.company_name as core_maker,
                e.company_name as customer,
                b.pattern_item ,
                c.core_item_name as core_item,
                a.rate            
                from core_maker_rate_info as a
                left join pattern_info as b on b.pattern_id = a.pattern_id
                left join core_item_info as c on c.core_item_id = a.core_item_id and c.pattern_id = b.pattern_id
                left join core_maker_info as d on d.core_maker_id = a.core_maker_id
                left join customer_info as e on e.customer_id = a.customer_id
                where a.`status` != 'Delete' and c.status = 'Active' and b.status = 'Active' and d.status = 'Active' and e.status = 'Active'
                 and  $where   
                order by d.company_name , e.company_name , b.pattern_item , c.core_item_name 
        ");
         
        $export_data = array();  

        foreach ($query->result_array() as $row)
        {
            $export_data[] = $row;     
        }
        
        $this->excel->stream( 'Core-Maker-Rate-'. str_replace(' ', '-',  $data['core_maker_opt'][$srch_core_maker_id]) .'-'. date('Y-m-d-his').'.xls', $export_data);
         
       } 
       
       
        
        
        
        if($data['submit_flg']) {
        
         
        
        $sql = "
                select  
                d.company_name as core_maker,
                e.company_name as customer,
                b.pattern_item ,
                c.core_item_name,
                a.rate            
                from core_maker_rate_info as a
                left join pattern_info as b on b.pattern_id = a.pattern_id
                left join core_item_info as c on c.core_item_id = a.core_item_id and c.pattern_id = b.pattern_id
                left join core_maker_info as d on d.core_maker_id = a.core_maker_id
                left join customer_info as e on e.customer_id = a.customer_id
                where a.`status` != 'Delete' and c.status = 'Active' and b.status = 'Active' and d.status = 'Active' and e.status = 'Active'
                 and  $where   
                order by d.company_name , e.company_name , b.pattern_item , c.core_item_name 
                                          
                          
        ";
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        //$data['pagination'] = $this->pagination->create_links();
        }
        
        $this->load->view('page/reports/core_maker_master_rate',$data); 
    }
    
    public function production_summary_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           //$this->session->set_userdata('srch_from_date', $this->input->post('srch_from_date'));
           //$this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date'));
           //$this->session->set_userdata('srch_core_maker_id', $this->input->post('srch_core_maker_id'));
       }
       /*elseif($this->session->userdata('srch_from_date')){
           $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ;
           $data['srch_core_maker_id'] = $srch_core_maker_id = $this->session->userdata('srch_core_maker_id') ;
       } */ 
       else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
        $data['srch_pattern_id'] = $srch_pattern_id = '';
        $data['srch_customer_id'] = $srch_customer_id = '';
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       }    
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)   
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
         
        $sql = "
               select 
                z.customer_id,
                z.pattern_id,
                w.pattern_item,
                z.m_date,
                w.piece_weight_per_kg,
                p.openning_stock,
                sum(z.planned_box) as planned_box,
                sum(z.planned_qty) as planned_qty,
                sum(z.produced_qty) as produced_qty, 
                sum(z.rejection_qty) as rejection_qty,
                sum(z.despatch_qty) as despatch_qty
                from ( 
                                  
                    (
                    select 
                    a.planning_date as m_date,
                    a.customer_id,
                    a.pattern_id, 
                    sum(a.planned_box) as planned_box,
                    sum((a.planned_box * b.no_of_cavity)) as planned_qty,
                    0 as produced_qty,
                    0 as rejection_qty,
                    0 as despatch_qty
                    from work_planning_info as a
                    left join pattern_info as b on b.pattern_id = a.pattern_id
                    where a.status!='Delete' and b.status ='Active'  and  a.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.="   
                    group by a.planning_date,a.customer_id,a.pattern_id
                    order by a.planning_date asc
                    ) union all (
                    
                    select 
                    a.melting_date as m_date,
                    c.customer_id,
                    c.pattern_id, 
                    0 as planned_box, 
                    0 as planned_qty, 
                    (sum(b.produced_qty) - ifnull(d.closed_mould_qty,0)) as produced_qty,
                    0 as rejection_qty,
                    0 as despatch_qty 
                    from melting_heat_log_info as a  
                    left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
                    left join work_planning_info as c on c.work_planning_id = b.work_planning_id
                    left join ( select q.work_planning_id , sum(q.closed_mould_qty) as closed_mould_qty from moulding_log_item_info as q where q.`status` = 'Active' group by q.work_planning_id) as d on d.work_planning_id = b.work_planning_id 
                    where a.`status` = 'Active' and c.`status` !='Delete' and a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and c.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and c.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.=" 
                    group by a.melting_date ,c.customer_id , c.pattern_id
                    order by a.melting_date ,c.customer_id , c.pattern_id 
                   
                    ) union all (
                    select
                    b.planning_date as m_date,
                    b.customer_id,
                    b.pattern_id,
                    0 as planned_box,
                    0 as planned_qty,
                    0 as produced_qty,
                    sum(a.rejection_qty) as rejection_qty,
                    0 as despatch_qty
                    from qc_inspection_info as a
                    left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                    where a.status = 'Active' and b.status != 'Delete' and a.rejection_type_id != '32' 
                    and b.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and b.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.="  
                    group by a.work_planning_id
                    order by b.planning_date asc 
                    ) union all (
                    select 
                    a.despatch_date as m_date,
                    a.customer_id,
                    b.pattern_id,
                    0 as planned_box,
                    0 as planned_qty,
                    0 as produced_qty,
                    0 as rejection_qty,
                    sum(b.qty) as despatch_qty
                    from customer_despatch_info as a 
                    left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
                    where a.despatch_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.="  
                    group by a.despatch_date,a.customer_id,b.pattern_id
                    order by a.despatch_date asc 
                    )
                ) as z
                left join pattern_info as w on w.pattern_id = z.pattern_id
                left join (
                    select 
                    a.customer_id,
                    a.pattern_id , 
                    ifnull(b.floor_stock_date,'2020-12-01') as  open_stock_date,
                    ifnull(b.stock_qty,0) as stock_qty,
                    ifnull(sum(c.produced_qty),0) as produced_qty,
                    ifnull(sum(d.despatch_qty),0) as despatch_qty ,
                    ((ifnull(b.stock_qty,0) + ifnull(sum(c.produced_qty),0)) - ifnull(sum(d.despatch_qty),0)) as openning_stock
                    from pattern_info as a  
                    left join (
                    select 
                    a.customer_id,
                    a.pattern_id,
                    a.stock_qty,
                    w.floor_stock_date
                    from floor_stock_info as a  
                    left join (select max(z.floor_stock_date) as floor_stock_date , z.customer_id ,z.pattern_id from floor_stock_info as z where z.floor_stock_date <= '" . $srch_from_date . "' group by z.customer_id ,z.pattern_id order by z.customer_id ,z.pattern_id , z.floor_stock_date desc  ) as w on w.customer_id = a.customer_id and  w.pattern_id = a.pattern_id  
                    where  1 
                    group by a.customer_id , a.pattern_id  
                    ) as b on FIND_IN_SET( b.customer_id , a.customer_id) and b.pattern_id = a.pattern_id
                    left join (
                    	select 
                    	a.melting_date as m_date,
                    	c.customer_id,
                    	c.pattern_id ,
                    	(sum(b.produced_qty) - ifnull(d.closed_mould_qty,0)) as produced_qty 
                    	from melting_heat_log_info as a  
                    	left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
                    	left join work_planning_info as c on c.work_planning_id = b.work_planning_id
                    	left join ( select q.work_planning_id , sum(q.closed_mould_qty) as closed_mould_qty from moulding_log_item_info as q where q.`status` = 'Active' group by q.work_planning_id) as d on d.work_planning_id = b.work_planning_id 
                    	where a.`status` = 'Active' 
                    	and c.`status` !='Delete' 
                    	and a.melting_date >= '" . $srch_from_date . "'  
                    	group by a.melting_date ,c.customer_id , c.pattern_id
                    	order by a.melting_date ,c.customer_id , c.pattern_id
                    	) as c on c.m_date between ifnull(b.floor_stock_date,'2020-12-01') and DATE_SUB('" . $srch_from_date . "',INTERVAL 1 day) and  c.customer_id = a.customer_id and c.pattern_id = a.pattern_id 
                    left join (
                      select 
                      a.despatch_date as d_date,
                      a.customer_id,
                      b.pattern_id, 
                      sum(b.qty) as despatch_qty
                      from customer_despatch_info as a 
                      left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
                      where a.despatch_date >= '" . $srch_from_date . "'
                      group by a.despatch_date,a.customer_id,b.pattern_id
                      order by a.despatch_date asc
                    ) as d on d.customer_id = a.customer_id and d.pattern_id = a.pattern_id and d.d_date between ifnull(b.floor_stock_date,'2020-12-01') and DATE_SUB('" . $srch_from_date . "',INTERVAL 1 day) 	
                    where a.`status` = 'Active'  
                    group by a.customer_id , a.pattern_id 
                    order by a.customer_id , a.pattern_id 
                ) as p on p.customer_id = z.customer_id and p.pattern_id = z.pattern_id
                group by z.m_date,z.customer_id,z.pattern_id
                order by z.m_date asc                  
        ";
        /*
        
         union all (
                    select 
                    a.despatch_date as m_date,
                    a.customer_id,
                    b.pattern_id,
                    0 as planned_box,
                    0 as planned_qty,
                    0 as produced_qty,
                    0 as rejection_qty,
                    sum(b.qty) as despatch_qty
                    from customer_despatch_info as a 
                    left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
                    where a.despatch_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.="  
                    group by a.despatch_date,a.customer_id,b.pattern_id
                    order by a.despatch_date asc 
                    )
        
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        */
        
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
         
        } else {
            $data['pattern_opt'] =array();
            
        }
        
        $this->load->view('page/reports/production_summary_report',$data); 
	}  
    
    public function customer_wise_despatch_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           //$this->session->set_userdata('srch_from_date', $this->input->post('srch_from_date'));
           //$this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date'));
           //$this->session->set_userdata('srch_core_maker_id', $this->input->post('srch_core_maker_id'));
       }
       /*elseif($this->session->userdata('srch_from_date')){
           $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ;
           $data['srch_core_maker_id'] = $srch_core_maker_id = $this->session->userdata('srch_core_maker_id') ;
       } */ 
       else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = ''; 
       }
       
       if(isset($_POST['srch_pattern_id'])) {
         $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
       } else {
         $data['srch_pattern_id'] = $srch_pattern_id = '';
       }
       if(isset($_POST['srch_customer_id'])) {
         $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
       } else {
         $data['srch_customer_id'] = $srch_customer_id = '';
       }
       if(isset($_POST['srch_sub_contractor_id'])) {
         $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->input->post('srch_sub_contractor_id'); 
       } else {
         $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = '';
       }
        
       
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       }    
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        $sql = "
               select 
                a.sub_contractor_id,
                a.company_name  
                from sub_contractor_info as a 
                where a.status='Active' and a.type = 'Machining' 
                order by a.company_name asc               
        "; 
        
        $query = $this->db->query($sql);
        
        $data['sub_contractor_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['sub_contractor_opt'][$row['sub_contractor_id']] = $row['company_name'];     
        }
        
        
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
         
         
        
        $sql ="
            select 
            a.despatch_date,
            a.dc_no,
            a.invoice_no,
            c.company_name as customer,
            d.company_name as sub_contractor,
            e.pattern_item as item,
            b.qty,
            e.piece_weight_per_kg,
            (b.qty * e.piece_weight_per_kg) as wt
            from customer_despatch_info as a 
            left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
            left join customer_info as c on c.customer_id=a.customer_id
            left join sub_contractor_info as d on d.sub_contractor_id = b.machining_sub_contractor_id
            left join pattern_info as e on e.pattern_id = b.pattern_id
            where a.`status` = 'Active'  and b.`status` = 'Active' 
            and a.despatch_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
            if(!empty($srch_customer_id) ){
                $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
            }
            if(!empty($srch_sub_contractor_id) ){
              $sql.=" and b.machining_sub_contractor_id = '". $srch_sub_contractor_id ."'";
            }
            
            $sql.=" order by c.company_name , a.despatch_date ,a.dc_no, d.company_name , e.pattern_item  ";
        
        /*
        echo "<pre>";
        echo $sql;
        echo "</pre>"; */
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['customer']][] = $row;     
            //$data['record_list'][$row['customer']][] = $row;     
        }
        
         
        } else {
            $data['pattern_opt'] =array();
            
        }
        
        $this->load->view('page/reports/customer_wise_despatch_report',$data); 
	}  
    
    public function customer_wise_despatch_summary()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           
       } else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = ''; 
       }
       
       if(isset($_POST['srch_pattern_id'])) {
         $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
       } else {
         $data['srch_pattern_id'] = $srch_pattern_id = '';
       }
       if(isset($_POST['srch_customer_id'])) {
         $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
       } else {
         $data['srch_customer_id'] = $srch_customer_id = '';
       }
       if(isset($_POST['srch_sub_contractor_id'])) {
         $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->input->post('srch_sub_contractor_id'); 
       } else {
         $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = '';
       }
        
       
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       }    
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        $sql = "
               select 
                a.sub_contractor_id,
                a.company_name  
                from sub_contractor_info as a 
                where a.status='Active' and a.type = 'Machining' 
                order by a.company_name asc               
        "; 
        
        $query = $this->db->query($sql);
        
        $data['sub_contractor_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['sub_contractor_opt'][$row['sub_contractor_id']] = $row['company_name'];     
        }
        
        
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
         
         
        
        $sql ="
            select  
            c.company_name as customer, 
            e.pattern_item as item,
            sum(b.qty) as qty, 
            sum(b.qty * e.piece_weight_per_kg) as wt
            from customer_despatch_info as a 
            left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
            left join customer_info as c on c.customer_id=a.customer_id 
            left join pattern_info as e on e.pattern_id = b.pattern_id
            where a.`status` = 'Active' 
            and a.despatch_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
            if(!empty($srch_customer_id) ){
                $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
            } 
            
            $sql.=" group by c.company_name ,  e.pattern_item  ";
            $sql.=" order by c.company_name ,  e.pattern_item  ";
        
        
       /* echo "<pre>";
        echo $sql;
        echo "</pre>"; */
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['customer']][] = $row;     
            //$data['record_list'][$row['customer']][] = $row;     
        }
        
         
        } else {
            $data['pattern_opt'] =array();
            
        }
        
        $this->load->view('page/reports/customer_wise_despatch_summary',$data); 
	}  
    
    
    public function work_order_wise_despatch_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id');  
           //$this->session->set_userdata('srch_from_date', $this->input->post('srch_from_date'));
           //$this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date'));
           //$this->session->set_userdata('srch_core_maker_id', $this->input->post('srch_core_maker_id'));
       }
       /*elseif($this->session->userdata('srch_from_date')){
           $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ;
           $data['srch_core_maker_id'] = $srch_core_maker_id = $this->session->userdata('srch_core_maker_id') ;
       } */ 
       else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
        $data['srch_pattern_id'] = $srch_pattern_id = '';
        $data['srch_customer_id'] = $srch_customer_id = ''; 
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       }    
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)   
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
         
        /* 
        
        $sql ="
            select 
            a.order_date,
            e.company_name as customer,
            a.customer_PO_No,
            d.pattern_item,
            b.qty,
            (ifnull(z1.produced_qty,0) -  ifnull(cm.closed_mould_qty,0)) as produced_qty,
            (ifnull(z2.rejection_qty,0)) as rejection_qty,
            (ifnull(z1.produced_qty,0) - ifnull(cm.closed_mould_qty,0) - ifnull(z2.rejection_qty,0) - ifnull(c.despatch_qty,0)) as in_process,
            ifnull(c.despatch_qty,0) as despatch_qty,
            (b.qty -  ifnull(c.despatch_qty,0)) as bal_qty
            from work_order_info as a
            left join work_order_items_info as b on b.work_order_id = a.work_order_id
            left join ( select z.work_order_id , z.pattern_id,  sum(z.qty) as despatch_qty from customer_despatch_item_info as z where z.status = 'Active' and exists (select * from customer_despatch_info as s where s.customer_despatch_id = z.customer_despatch_id and s.status = 'Active') group by z.work_order_id ,z.pattern_id  ) as c on c.work_order_id = a.work_order_id and c.pattern_id = b.pattern_id 
            left join pattern_info as d on d.pattern_id = b.pattern_id
            left join customer_info as e on e.customer_id = a.customer_id
            left join (
                 select
                    w.work_order_id,
                    w.work_order_item_id, 
                    sum(w.curr_produced_qty) as produced_qty
                    from
                    (
                    	(
                    	select 
                    	a3.work_order_id, 
                    	a3.work_order_item_id,
                    	a3.pattern_id, 
                    	sum((a2.produced_qty)) as curr_produced_qty
                    	from melting_heat_log_info as a1
                    	left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    	left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    	where a1.`status` = 'Active' and a2.`status` = 'Active'  
                    	group by a3.work_order_id, a3.work_order_item_id
                    	order by a3.work_order_id, a3.work_order_item_id
                    	) union all (
                    	select 
                    	a3.work_order_id, 
                    	a3.work_order_item_id,
                    	a3.pattern_id, 
                    	sum((a2.produced_qty)) as curr_produced_qty
                    	from melting_heat_log_info as a1
                    	left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    	left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                   	    where a1.`status` = 'Active'  and a2.`status` = 'Active'
                    	group by a3.work_order_id, a3.work_order_item_id
                    	order by a3.work_order_id, a3.work_order_item_id
                    	)
                    ) as w 
                    where 1 
                    group by w.work_order_id,w.work_order_item_id
            ) as z1 on z1.work_order_id = a.work_order_id and  z1.work_order_item_id = b.work_order_item_id
            left join (
                select 
                b2.work_order_id,
                b2.work_order_item_id,
                sum(ifnull(b1.rejection_qty,0)) as rejection_qty
                from qc_inspection_info as b1
                left join work_planning_info as b2 on b2.work_planning_id = b1.work_planning_id
                where b1.`status` = 'Active'
                group by b2.work_order_id , b2.work_order_item_id 
            ) as z2 on z2.work_order_id = a.work_order_id and z2.work_order_item_id = b.work_order_item_id
            left join (
             select  
             q1.work_order_id,
             q1.work_order_item_id,
             sum(q.closed_mould_qty) as closed_mould_qty 
             from moulding_log_item_info as q
             left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
             where q.`status` = 'Active'  
             group by q1.pattern_id ,q1.customer_id
            ) as cm on cm.work_order_id = a.work_order_id and cm.work_order_item_id = b.work_order_item_id 
            where a.`status` = 'Active' and b.`status` = 'Active'   
            and a.order_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
            if(!empty($srch_customer_id) ){
                $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
            } 
            $sql.=" order by e.company_name , d.pattern_item , a.order_date ";
        
        */
        
         $sql ="
            select 
            a.order_date,
            e.company_name as customer,
            a.customer_PO_No,
            d.pattern_item,
            b.qty,
            (ifnull(z1.produced_qty,0) -  ifnull(cm.closed_mould_qty,0)) as produced_qty,
            (ifnull(z2.rejection_qty,0)) as rejection_qty,
            (ifnull(z1.produced_qty,0) - ifnull(cm.closed_mould_qty,0) - ifnull(z2.rejection_qty,0) - ifnull(c.despatch_qty,0)) as in_process,
            ifnull(c.despatch_qty,0) as despatch_qty,
            (b.qty -  ifnull(c.despatch_qty,0)) as bal_qty
            from work_order_info as a
            left join work_order_items_info as b on b.work_order_id = a.work_order_id
            left join ( 
                        select 
                        c1.work_order_id,
                        b1.pattern_id,
                        sum(c1.qty) as despatch_qty
                        from customer_despatch_info as a1
                        left join customer_despatch_item_info as b1 on b1.customer_despatch_id = a1.customer_despatch_id
                        left join heatcode_despatch_info as c1 on c1.customer_despatch_item_id = b1.customer_despatch_item_id
                        where a1.`status` = 'Active' 
                        group by c1.work_order_id , b1.pattern_id  
                        ) as c on c.work_order_id = a.work_order_id and c.pattern_id = b.pattern_id 
            left join pattern_info as d on d.pattern_id = b.pattern_id
            left join customer_info as e on e.customer_id = a.customer_id
            left join (
                 select
                    w.work_order_id,
                    w.work_order_item_id, 
                    sum(w.curr_produced_qty) as produced_qty
                    from
                    (
                    	(
                    	select 
                    	a3.work_order_id, 
                    	a3.work_order_item_id,
                    	a3.pattern_id, 
                    	sum((a2.produced_qty)) as curr_produced_qty
                    	from melting_heat_log_info as a1
                    	left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    	left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    	where a1.`status` = 'Active' and a2.`status` = 'Active'  
                    	group by a3.work_order_id, a3.work_order_item_id
                    	order by a3.work_order_id, a3.work_order_item_id
                    	) union all (
                    	select 
                    	a3.work_order_id, 
                    	a3.work_order_item_id,
                    	a3.pattern_id, 
                    	sum((a2.produced_qty)) as curr_produced_qty
                    	from melting_heat_log_info as a1
                    	left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    	left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                   	    where a1.`status` = 'Active'  and a2.`status` = 'Active'
                    	group by a3.work_order_id, a3.work_order_item_id
                    	order by a3.work_order_id, a3.work_order_item_id
                    	)
                    ) as w 
                    where 1 
                    group by w.work_order_id,w.work_order_item_id
            ) as z1 on z1.work_order_id = a.work_order_id and  z1.work_order_item_id = b.work_order_item_id
            left join (
                select 
                b2.work_order_id,
                b2.work_order_item_id,
                sum(ifnull(b1.rejection_qty,0)) as rejection_qty
                from qc_inspection_info as b1
                left join work_planning_info as b2 on b2.work_planning_id = b1.work_planning_id
                where b1.`status` = 'Active' and b1.rejection_type_id != '32'
                group by b2.work_order_id , b2.work_order_item_id 
            ) as z2 on z2.work_order_id = a.work_order_id and z2.work_order_item_id = b.work_order_item_id
            left join (
             select  
             q1.work_order_id,
             q1.work_order_item_id,
             sum(q.closed_mould_qty) as closed_mould_qty 
             from moulding_log_item_info as q
             left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
             where q.`status` = 'Active'  
             group by q1.pattern_id ,q1.customer_id
            ) as cm on cm.work_order_id = a.work_order_id and cm.work_order_item_id = b.work_order_item_id 
            where a.`status` = 'Active' and b.`status` = 'Active'   
            and a.order_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
            if(!empty($srch_customer_id) ){
                $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
            } 
            $sql.=" order by e.company_name , d.pattern_item , a.order_date ";
        
        /*
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        */
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['customer']][] = $row;     
        }
        
         
        } else {
            $data['pattern_opt'] =array();
            
        }
        
        $this->load->view('page/reports/work_order_wise_despatch_report',$data); 
	} 
     
	public function work_order_wise_despatch_summary()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id');  
            
       } else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
        $data['srch_pattern_id'] = $srch_pattern_id = '';
        $data['srch_customer_id'] = $srch_customer_id = ''; 
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       }    
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)   
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
         
         
        
        $sql ="
            select 
			a.work_order_id,
			b.work_order_item_id,			
			a.order_date,
			e.company_name as customer,
			a.customer_PO_No,
			d.pattern_item,
			b.qty,
			b.delivery_date,
			c.despatch_date,
			ifnull(c.despatch_qty,0) as despatch_qty ,
			c.dc_no,
            DATEDIFF(b.delivery_date , c.despatch_date) as diff
			from work_order_info as a
			left join work_order_items_info as b on b.work_order_id = a.work_order_id
			left join ( 
						select 
						c1.work_order_id,
						b1.pattern_id,
						a1.dc_no,
						a1.despatch_date,
						sum(c1.qty) as despatch_qty
						from customer_despatch_info as a1
						left join customer_despatch_item_info as b1 on b1.customer_despatch_id = a1.customer_despatch_id
						left join heatcode_despatch_info as c1 on c1.customer_despatch_item_id = b1.customer_despatch_item_id
						where a1.`status` = 'Active' 
						group by c1.work_order_id , b1.pattern_id , a1.customer_despatch_id   
						) as c on c.work_order_id = a.work_order_id and c.pattern_id = b.pattern_id 
			left join pattern_info as d on d.pattern_id = b.pattern_id
			left join customer_info as e on e.customer_id = a.customer_id
			where a.`status` = 'Active' and b.`status` = 'Active'      
            and a.order_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
            if(!empty($srch_customer_id) ){
                $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
            } 
            $sql.=" order by e.company_name ,a.work_order_id, a.order_date, d.pattern_item, b.delivery_date, c.despatch_date  ";
			
			
        
        /*
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        */
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            //$data['record_list'][$row['customer']][] = $row;     
            $data['record_list1'][$row['customer']][$row['work_order_item_id']][] = $row;     
        }
        
         
        } else {
            $data['pattern_opt'] =array();
            
        }
        
        //echo "<pre>";
       // echo $sql;
        //print_r($data['record_list1']);
        //echo "</pre>";
        
        $this->load->view('page/reports/work_order_wise_despatch_summary',$data); 
	}  
    
    
    public function grinding_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->input->post('srch_sub_contractor_id'); 
            
       } 
       else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = ''; 
        $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = '';
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       } 
       
       if(isset($_POST['srch_customer_id'])) { 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
           $data['submit_flg'] = true;
       } 
       else {
         
        $data['srch_customer_id'] = $srch_customer_id = '';
       }
       if(isset($_POST['srch_pattern_id'])) {  
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id');  
           $data['submit_flg'] = true;
       } 
       else {
        $data['srch_pattern_id'] = $srch_pattern_id = ''; 
       }   
       
       
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
         
        $sql = "
               select 
                a.sub_contractor_id,
                a.company_name  
                from sub_contractor_info as a 
                where a.status='Active' and a.type = 'Grinding' 
                order by a.company_name asc               
        "; 
        
        $query = $this->db->query($sql);
        
        $data['sub_contractor_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['sub_contractor_opt'][$row['sub_contractor_id']] = $row['company_name'];     
        }
        
        
        $data['pattern_opt'] =array();
        
        
        if($data['submit_flg']) { 
            
            if(!empty($srch_customer_id) ){    
                
            $sql = "
                    select 
                    a.pattern_id,                
                    a.pattern_item  
                    from pattern_info as a  
                    where status = 'Active' 
                    and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)   
                    order by a.pattern_item  asc                 
            "; 
            
            $query = $this->db->query($sql);
           
            foreach ($query->result_array() as $row)
            {
                $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
            }
            } else {
                $data['pattern_opt'] =array();
            }
         
        
        $sql ="
            select 
            a.despatch_date,
            a.dc_no,
            a.invoice_no,
            c.company_name as customer,
            d.company_name as sub_contractor,
            e.pattern_item as item,
            b.qty,
            b.grinding_rate,
            (b.qty * b.grinding_rate) as amt
            from customer_despatch_info as a 
            left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
            left join customer_info as c on c.customer_id=a.customer_id
            left join sub_contractor_info as d on d.sub_contractor_id = b.grinding_sub_contractor_id
            left join pattern_info as e on e.pattern_id = b.pattern_id
            where a.`status` = 'Active' and b.`status` = 'Active'
            and a.despatch_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'"; 
            if(!empty($srch_sub_contractor_id) ){
              $sql.=" and b.grinding_sub_contractor_id = '". $srch_sub_contractor_id ."'";
            }
            
            if(!empty($srch_customer_id) ){
              $sql.=" and a.customer_id = '". $srch_customer_id ."'";
            }
            
            if(!empty($srch_pattern_id) ){
              $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
            }
            
            
            $sql.=" order by d.company_name , a.despatch_date ,a.dc_no, d.company_name , e.pattern_item  ";
        
        /*
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        */
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['sub_contractor']][] = $row;     
            //$data['record_list'][$row['customer']][] = $row;     
        }
        
         
        }  
        $this->load->view('page/reports/grinding_report',$data); 
	} 
    
    public function production_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        $data['pattern_opt'] =array();
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');   
            
       } 
       else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = '';  
       }
       
       if(isset($_POST['srch_customer_id'])) { 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
           $data['submit_flg'] = true;
       } 
       else {
         
        $data['srch_customer_id'] = $srch_customer_id = '';
       }
       if(isset($_POST['srch_pattern_id'])) {  
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id');  
           $data['submit_flg'] = true;
       } 
       else {
        $data['srch_pattern_id'] = $srch_pattern_id = ''; 
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       }   
       
       
       $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        
        
        if($data['submit_flg']) { 
            
       if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }     
            
            
       $sql = "
        select 
         z.p_date , 
         z.item,
         sum(z.mould_box) as mould_box,
         sum(z.mould_qty) as mould_qty,
         sum(z.closed_mould_qty) as closed_mould_qty,
         sum(z.poured_box) as poured_box,
         sum(z.poured_qty) as poured_qty,
         sum(z.leftout_box) as leftout_box, 
         sum(z.leftout_qty) as leftout_qty,
         (if(sum(z.leftout_box_close) != '0' ,'Yes', 'No')) as leftout_box_close
        from (
        (
        select 
        b.planning_date as p_date,
        c.pattern_item as item,
        a.produced_box as mould_box,
        (c.no_of_cavity * a.produced_box) as mould_qty,
        a.closed_mould_qty,
        0 as poured_box,
        0 as poured_qty,
        0 as leftout_box,
        0 as leftout_qty, 
        0 as leftout_box_close
        from moulding_log_item_info as a
        left join work_planning_info as b on b.work_planning_id = a.work_planning_id
        left join pattern_info as c on c.pattern_id = b.pattern_id
        where a.`status` = 'Active' and b.`status` != 'Delete' and
        b.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
        if(!empty($srch_customer_id) ){
            $sql.=" and b.customer_id = '". $srch_customer_id ."'"; 
        }
        if(!empty($srch_pattern_id) ){
          $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
        }
         $sql.="
        order by b.planning_date desc , c.pattern_item asc 
        ) union all (
        select 
        a.melting_date as p_date,
        d.pattern_item as item,
        0 as mould_box,
        0 as mould_qty,
        0 as closed_mould_qty,
        sum(b.pouring_box) as poured_box,       
        sum(b.pouring_box * d.no_of_cavity)  as poured_qty,
        sum(b.leftout_box) as leftout_box,
        (sum(b.leftout_box) * d.no_of_cavity) as leftout_qty,
        sum(b.leftout_box_close) as leftout_box_close
        from melting_heat_log_info as a
        left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
        left join work_planning_info as c on c.work_planning_id = b.work_planning_id
        left join pattern_info as d on d.pattern_id = c.pattern_id
        where a.`status` = 'Active' and b.`status` = 'Active' and c.`status` != 'Delete' and  
        a.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
        if(!empty($srch_customer_id) ){
            $sql.=" and c.customer_id = '". $srch_customer_id ."'"; 
        }
        if(!empty($srch_pattern_id) ){
          $sql.=" and c.pattern_id = '". $srch_pattern_id ."'";
        }
         $sql.="
        group by a.melting_date , d.pattern_id
        order by a.planning_date desc , d.pattern_item asc 
        )
        ) as z 
        where 1 ";
        
         $sql.="
        group by z.p_date , z.item 
        order by z.p_date , z.item 
       ";  
         
         /*
        // sum(b.produced_qty) as poured_qty1,
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        
        */
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['p_date']][] = $row;     
        }
        
         
        }  
        $this->load->view('page/reports/production_report',$data); 
	} 
    
    
    public function heat_code_wise_production_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        $data['pattern_opt'] =array();
        
      if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');   
            
       } 
       else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = '';  
       }
       
       if(isset($_POST['srch_customer_id'])) { 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
           $data['submit_flg'] = true;
       } 
       else {
         
        $data['srch_customer_id'] = $srch_customer_id = '';
       }
       if(isset($_POST['srch_pattern_id'])) {  
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id');  
           $data['submit_flg'] = true;
       } 
       else {
        $data['srch_pattern_id'] = $srch_pattern_id = ''; 
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       }   
       
       
       $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        
        
        if($data['submit_flg']) { 
            
       if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }     
            
            
       $sql = "
       
       select 
        a1.melting_date ,
        a1.lining_heat_no,
        a1.heat_code,
        a1.days_heat_no,
        a1.customer,
        a1.item,
        a1.customer_PO_No,
        a1.pouring_box,
        a1.produced_qty ,
        a1.rejection_qty ,
        GROUP_CONCAT(a3.rejection_type_name , ' : ', a2.rejection_qty) as rej_type  
        from (
        (select 
        a.melting_heat_log_id,
        b.work_planning_id,
        a.melting_date ,
        a.lining_heat_no,
        a.heat_code,
        a.days_heat_no,
        e.company_name as customer,
        d.pattern_item as item, 
        sum(b.pouring_box) as pouring_box  ,
        sum(b.produced_qty) as produced_qty  ,
        f.customer_PO_No,
        1 as p_mode,
        (g.rejection_qty) as rejection_qty
        from melting_heat_log_info as a
        left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
        left join work_planning_info as c on c.work_planning_id = b.work_planning_id 
        left join pattern_info as d on d.pattern_id = c.pattern_id
        left join customer_info as e on e.customer_id = c.customer_id
        left join work_order_info as f on f.work_order_id = c.work_order_id
        left join (select x.melting_heat_log_id, x.work_planning_id, sum(x.rejection_qty) as rejection_qty from qc_inspection_info as x where x.status = 'Active' and x.rejection_type_id != '32' group by x.melting_heat_log_id , x.work_planning_id ) as g on g.melting_heat_log_id = a.melting_heat_log_id and g.work_planning_id = b.work_planning_id  
        where a.`status` = 'Active' and b.`status` = 'Active' and c.status != 'Delete' and b.pouring_box > 0  
        and a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
        if(!empty($srch_customer_id) ){
            $sql.=" and c.customer_id = '". $srch_customer_id ."'"; 
        }
        if(!empty($srch_pattern_id) ){
          $sql.=" and c.pattern_id = '". $srch_pattern_id ."'";
        }
        $sql.=" group by a.melting_heat_log_id 
                order by a.melting_date,  a.heat_code, a.days_heat_no ,d.pattern_item asc ) union all (
        select 
        a.melting_heat_log_id,
        b.work_planning_id,
        a.melting_date ,
        a.lining_heat_no,
        a.heat_code,
        a.days_heat_no,
        e.company_name as customer,
        d.pattern_item as item,
        0 as pouring_box,
        sum(b.produced_qty) as produced_qty  ,
        f.customer_PO_No,
        0 as p_mode,
        (g.rejection_qty) as rejection_qty
        from melting_heat_log_info as a
        left join melting_child_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
        left join work_planning_info as c on c.work_planning_id = b.work_planning_id 
        left join pattern_info as d on d.pattern_id = c.pattern_id
        left join customer_info as e on e.customer_id = c.customer_id
        left join work_order_info as f on f.work_order_id = c.work_order_id
        left join (select x.melting_heat_log_id, x.work_planning_id, sum(x.rejection_qty) as rejection_qty from qc_inspection_info as x where x.status = 'Active' and x.rejection_type_id != '32' group by x.melting_heat_log_id , x.work_planning_id ) as g on g.melting_heat_log_id = a.melting_heat_log_id and g.work_planning_id = b.work_planning_id  
        where a.`status` = 'Active' and b.`status` = 'Active' and c.status != 'Delete'  
        and a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
        if(!empty($srch_customer_id) ){
            $sql.=" and c.customer_id = '". $srch_customer_id ."'"; 
        }
        if(!empty($srch_pattern_id) ){
          $sql.=" and c.pattern_id = '". $srch_pattern_id ."'";
        }
        $sql.=" group by a.melting_heat_log_id 
                order by a.melting_date,  a.heat_code, a.days_heat_no ,d.pattern_item asc
        )
        ) as a1
        left join qc_inspection_info as a2 on a2.work_planning_id = a1.work_planning_id and a2.melting_heat_log_id = a1.melting_heat_log_id and a2.`status` = 'Active' and a2.rejection_type_id != '32'
        left join rejection_type_info as a3 on a3.rejection_type_id = a2.rejection_type_id
        group by a1.melting_heat_log_id , a1.work_planning_id
        order by a1.melting_date,  a1.heat_code, a1.days_heat_no ,a1.p_mode desc , a1.item asc
        ";
        
         
        /*
        echo "<pre>";
        echo $sql;
        echo "</pre>";
       */
        
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['melting_date']][] = $row;     
        }
        
         
        }  
        $this->load->view('page/reports/heat_code_wise_production_report',$data); 
	} 
    
    public function customer_wise_planning_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           //$this->session->set_userdata('srch_from_date', $this->input->post('srch_from_date'));
           //$this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date'));
           //$this->session->set_userdata('srch_core_maker_id', $this->input->post('srch_core_maker_id'));
       }
       /*elseif($this->session->userdata('srch_from_date')){
           $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ;
           $data['srch_core_maker_id'] = $srch_core_maker_id = $this->session->userdata('srch_core_maker_id') ;
       } */ 
       else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
        $data['srch_pattern_id'] = $srch_pattern_id = '';
        $data['srch_customer_id'] = $srch_customer_id = '';
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       }    
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
         
        $sql = "
               (
                    select 
                    a.planning_date as m_date,
                    a.customer_id,
                    a.pattern_id, 
                    c.company_name as customer,
                    d.customer_PO_No,
                    b.pattern_item,
                    b.piece_weight_per_kg,
                    b.no_of_cavity,
                    sum(a.planned_box) as planned_box,
                    sum((a.planned_box * b.no_of_cavity)) as planned_qty,
                    0 as produced_qty,
                    0 as rejection_qty,
                    0 as despatch_qty
                    from work_planning_info as a
                    left join pattern_info as b on b.pattern_id = a.pattern_id
                    left join customer_info as c on c.customer_id = a.customer_id
                    left join work_order_info as d on d.work_order_id = a.work_order_id
                    where a.status!='Delete' and b.status ='Active'  and  a.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.="   
                    group by a.planning_date,a.customer_id,a.pattern_id
                    order by a.planning_date  , b.pattern_item asc
               )                  
        ";
        /*
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        */
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
         
        } else {
            $data['pattern_opt'] =array();
            
        }
        
        $this->load->view('page/reports/customer_wise_planning_report',$data); 
	}  
    
    public function customer_wise_production_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift'); 
           //$this->session->set_userdata('srch_from_date', $this->input->post('srch_from_date'));
           //$this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date'));
           //$this->session->set_userdata('srch_core_maker_id', $this->input->post('srch_core_maker_id'));
       }
       /*elseif($this->session->userdata('srch_from_date')){
           $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ;
           $data['srch_core_maker_id'] = $srch_core_maker_id = $this->session->userdata('srch_core_maker_id') ;
       } */ 
       else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
        $data['srch_pattern_id'] = $srch_pattern_id = '';
        $data['srch_customer_id'] = $srch_customer_id = '';
		$data['srch_shift'] = $srch_shift = '';
       }
	   
	   $data['shift_opt'] = array('' => 'All Shift',  'Shift-A' => 'Shift-A' , 'Shift-B' => 'Shift-B', 'Shift-C' => 'Shift-C'); 
       
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       }    
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
         
       /* $sql = "            
               
               select 
                    a.melting_date as m_date,
                    b.customer_id,
                    b.pattern_id,  
                    c.company_name as customer,
                    d.pattern_item,
                    sum(a.pouring_box) as pouring_box,
                    sum(a.produced_qty) as produced_qty,
                    d.piece_weight_per_kg
                    from melting_log_info as a
                    left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                    left join customer_info as c on c.customer_id = b.customer_id
                    left join pattern_info as d on d.pattern_id = b.pattern_id 
                    where a.status = 'Active' and b.status != 'Delete' and a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and b.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.=" 
                    group by a.melting_date,b.customer_id,b.pattern_id
                    order by a.melting_date asc, c.company_name, d.pattern_item asc                
        ";*/
        
        $sql = "            
               
               select 
                    a.work_planning_id,
                    b.planning_date as m_date,
                    b.customer_id,
                    b.pattern_id,  
                    d.company_name as customer,
                    e.pattern_item,
                    sum(b.planned_box) as planned_box,
                    (sum(b.planned_box) * e.no_of_cavity) as planned_qty,
                    sum(b.planned_box_wt) as planned_box_wt,
                    sum(a.produced_box) as produced_box,
                    (sum(a.produced_box) * e.no_of_cavity) as produced_qty,
                    e.piece_weight_per_kg ,
                    SEC_TO_TIME( (TIME_TO_SEC(TIMEDIFF(a.pattern_prod_to_time,a.pattern_prod_from_time)) - TIME_TO_SEC(TIMEDIFF(a.breakdown_to_time,a.breakdown_from_time))) * a.manpower_comsumption)  as man_hr,
                    (a.produced_box / ( (TIME_TO_SEC(TIMEDIFF(a.pattern_prod_to_time,a.pattern_prod_from_time)) - TIME_TO_SEC(TIMEDIFF(a.breakdown_to_time,a.breakdown_from_time))) * a.manpower_comsumption) * (3600) ) as eff
                    from moulding_log_item_info as a 
                    left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                    left join customer_info as d on d.customer_id = b.customer_id
                    left join pattern_info as e on e.pattern_id = b.pattern_id 
                    where b.`status` != 'Delete' and a.`status` != 'Delete'
                    and b.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and b.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    }
					if(!empty($srch_shift) ){
                      $sql.=" and b.shift = '". $srch_shift ."'";
                    }
					
                    $sql.=" 
                    group by a.work_planning_id,b.customer_id,b.pattern_id
                    order by b.planning_date asc, d.company_name, e.pattern_item asc                
        ";
        
      /*  echo "<pre>";
        echo $sql;
        echo "</pre>";*/
       
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
            $data['work_planning_id'][] = $row['work_planning_id'];     
        }
        
        if(isset($data['work_planning_id'])) {
              $sql = " select 
                    a.prt_work_plan_id,
                    a.planning_date as m_date,
                    a.customer_id,
                    a.pattern_id,  
                    d.company_name as customer,
                    e.pattern_item,
                    e.no_of_cavity, 
                    e.piece_weight_per_kg   
                    from work_planning_info as a
                    left join customer_info as d on d.customer_id = a.customer_id
                    left join pattern_info as e on e.pattern_id = a.pattern_id 
                    where a.prt_work_plan_id in (". implode(',',$data['work_planning_id']).") and a.`status` != 'Delete'
                    order by a.work_planning_id asc 
                 ";
                $query = $this->db->query($sql);
        
                $data['child_record_list'] = array();
               
                foreach ($query->result_array() as $row)
                {
                    $data['child_record_list'][$row['prt_work_plan_id']][] = $row;  
                } 
        
        } else {
            $data['child_record_list'] = array();
        }
        
         
        } else {
            $data['pattern_opt'] =array();
            
        }
        
        $this->load->view('page/reports/customer_wise_production_report',$data); 
	} 
    
    
    public function core_stock_reports()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
       if(isset($_POST['srch_date'])) { 
           $data['srch_date'] = $srch_date = $this->input->post('srch_date');  
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
           $data['submit_flg'] = true;
       } 
       else {
         
        $data['srch_date'] = $srch_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
       } 
        
       if(isset($_POST['srch_customer_id'])) { 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
           $data['submit_flg'] = true;
       } 
       else {
         
        $data['srch_customer_id'] = $srch_customer_id = '';
       }
       if(isset($_POST['srch_pattern_id'])) {  
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id');  
           $data['submit_flg'] = true;
       } 
       else {
        $data['srch_pattern_id'] = $srch_pattern_id = ''; 
       }
       
       
       if(!empty($srch_date)    ){
         
        $data['submit_flg'] = true;
         
       }    
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        if($data['submit_flg']) 
        { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
         
        
        /*
        $sql = "            
               select 
                a.customer_id,
                a.pattern_id,   
                e.company_name as customer,
                a.pattern_item as item,
                ifnull(b.stock_qty,0) as op_qty,
                b.floor_stock_date,
                ifnull(b.floor_stock_date,'2020-12-01') as floor_stock_date,
                ifnull(sum(c.produced_qty),0) as produced_qty ,
                (ifnull(d.pouring_box,0) * a.no_of_core_per_box) as used_qty,
                ((ifnull(b.stock_qty,0) + ifnull(sum(c.produced_qty),0)) - (ifnull(d.pouring_box,0) * a.no_of_core_per_box)) as core_stock
                from pattern_info as a 
                left join (
                    select 
                	a.floor_stock_date,
                	a.customer_id,
                	a.pattern_id, 
                	sum(a.stock_qty) as  stock_qty
                	from core_floor_stock_info as a 
                	left join ( 
                	SELECT max(`floor_stock_date`) as floor_stock_date, `customer_id`,`pattern_id`,`core_item_id` FROM `core_floor_stock_info` WHERE 1 group by `customer_id`, `pattern_id`, `core_item_id`) as b on b.floor_stock_date = a.floor_stock_date and b.customer_id = a.customer_id and b.pattern_id = a.pattern_id and b.core_item_id = a.core_item_id
                	where 1 
                    group by a.customer_id, a.pattern_id  
                	order by a.customer_id, a.pattern_id  ) as b on b.customer_id = a.customer_id and b.pattern_id = a.pattern_id  
                left join core_plan_info as c on c.pattern_id = a.pattern_id and c.core_plan_date >= ifnull(b.floor_stock_date,'2020-12-01')
                left join (
                    select 
                    a1.planning_date,
                    a3.customer_id,
                    a3.pattern_id,
                    sum(a2.pouring_box) as pouring_box
                    from melting_heat_log_info as a1
                    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    where a1.`status` = 'Active'
                    group by a3.customer_id, a3.pattern_id, a1.planning_date
                    order by a3.customer_id, a3.pattern_id, a1.planning_date
                    ) as d on d.customer_id = a.customer_id and d.pattern_id = a.pattern_id
                left join customer_info as e on e.customer_id = a.customer_id    
                where a.`status` = 'Active' and a.pattern_type = 'Core'";
                if(!empty($srch_customer_id) ){
                    $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                }
                if(!empty($srch_pattern_id) ){
                  $sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
                }
                    $sql.=" 
                group by a.customer_id, a.pattern_id   
                order by a.customer_id, a.pattern_item asc 
                 
                "; * /
         
        
                
        $sql = "
            select  
                 a.core_item_id,
                 b.company_name as customer,
                 c.pattern_item,
                 a.core_item_name as core_item,
                 d.floor_stock_date,
                 ifnull(d.stock_qty,0) as stock_qty, 
                 ifnull((f.produced_qty),0) as produced_qty,
                 ifnull(sum(e.pouring_box),0) as pouring_box  ,
                 ifnull(g.core_count,0) as core_count,
                 (ifnull(sum(e.pouring_box),0) * ifnull(g.core_count,0)) as used_core,
                 ((ifnull(d.stock_qty,0) + ifnull((f.produced_qty),0)) - (ifnull(sum(e.pouring_box),0) * ifnull(g.core_count,0))) as core_stock
                 from core_item_info as a
                 left join customer_info as b on b.customer_id = a.customer_id
                 left join pattern_info as c on c.pattern_id = a.pattern_id
                 left join (
                	select 
                	a.floor_stock_date,
                	a.customer_id,
                	a.pattern_id, 
                	a.core_item_id,
                	sum(a.stock_qty) as  stock_qty
                	from core_floor_stock_info as a 
                	left join ( 
                	SELECT max(`floor_stock_date`) as floor_stock_date, `customer_id`,`pattern_id`,`core_item_id` FROM `core_floor_stock_info` WHERE 1 group by `customer_id`, `pattern_id`, `core_item_id`) as b on b.floor_stock_date = a.floor_stock_date and b.customer_id = a.customer_id and b.pattern_id = a.pattern_id and b.core_item_id = a.core_item_id
                	where 1 
                	group by a.customer_id, a.pattern_id  , a.core_item_id
                	order by a.customer_id, a.pattern_id  ) 
                 as d on d.customer_id = a.customer_id and d.pattern_id = a.pattern_id and d.core_item_id = a.core_item_id
                 left join (
                    select 
                    a1.planning_date,
                    a3.customer_id,
                    a3.pattern_id,
                    sum(a2.pouring_box) as pouring_box 
                    from melting_heat_log_info as a1
                    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    where a1.`status` = 'Active'
                    group by a3.customer_id, a3.pattern_id, a1.planning_date
                    order by a3.customer_id, a3.pattern_id, a1.planning_date
                    ) as e on e.customer_id = a.customer_id and e.pattern_id = a.pattern_id and e.planning_date >= ifnull(d.floor_stock_date,'2020-12-01')  
                 left join core_plan_info as f on f.pattern_id = a.pattern_id and f.core_item_id = a.core_item_id and f.core_plan_date >= ifnull(d.floor_stock_date,'2020-12-01')   
                 left join (select z.pattern_id , z.customer_id , count(z.core_item_id) as core_count from core_item_info as z where z.status = 'Active' group by z.pattern_id , z.customer_id) as g on g.pattern_id = a.pattern_id and g.customer_id = a.customer_id
                 where a.`status` = 'Active' ";
                if(!empty($srch_customer_id) ){
                    $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                }
                if(!empty($srch_pattern_id) ){
                  $sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
                }
                 $sql.=" 
                 group by  a.customer_id ,a.pattern_id , a.core_item_id
                 order by  b.company_name , c.pattern_item, a.core_item_name asc
                ";                         
                 
        /*
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        
      
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            if($row['core_stock'] > 0 ) 
                $data['record_list'][$row['customer']][$row['pattern_item']][] = $row;      
        }
         */
      /*   
       $op_sql = "
        select 
            p.core_item_id,
            p.customer_id,
            p.pattern_id,
            p6.company_name as customer,
            p7.pattern_item,
            p.core_item_name as core_item, 
            ifnull(p1.floor_stock_date, '2020-12-01') as op_floor_stock_date ,
            ifnull(p2.stock_qty,0) as op_stock_qty,
            sum(ifnull(p3.core_produced_qty,0)) as core_produced_qty,
            sum(ifnull(p4.pouring_box,0)) as pouring_box,
            p5.no_of_core,
            '" .$srch_date. "' as op_stock_date,
            ((ifnull(p2.stock_qty,0) + sum(ifnull(p3.core_produced_qty,0))) - (sum(ifnull(p4.pouring_box,0)) * p5.no_of_core)) as op_stock,
            ifnull(q.curr_core_produced_qty,0) as curr_core_produced_qty,
            (ifnull(q1.curr_pouring_box,0) * p5.no_of_core) as curr_pouring_qty                          
            from core_item_info as p
                left join (
                select 
                max(a.floor_stock_date) as floor_stock_date,
                a.customer_id,
                a.pattern_id,
                a.core_item_id 
                from core_floor_stock_info as a
                where a.floor_stock_date <= '" .$srch_date. "'
                order by a.floor_stock_date, a.customer_id,a.pattern_id,a.core_item_id 
                ) as p1 on p1.customer_id = p.customer_id and p1.pattern_id = p.pattern_id and p1.core_item_id = p.core_item_id 
                left join  core_floor_stock_info as p2 on p2.customer_id = p.customer_id and p2.pattern_id = p.pattern_id and p2.core_item_id = p.core_item_id and p2.floor_stock_date = ifnull(p1.floor_stock_date, '2020-12-01') 
                left join (
                select 
                b.core_plan_date,
                b.customer_id,
                b.pattern_id,
                b.core_item_id,
                sum(b.produced_qty) as core_produced_qty
                from core_plan_info as b 
                where b.`status` = 'Active'  
                group by b.core_plan_date,b.customer_id,b.pattern_id,b.core_item_id
                order by b.core_plan_date,b.customer_id,b.pattern_id,b.core_item_id
                ) as p3 on p3.customer_id = p.customer_id and p3.pattern_id = p.pattern_id and p3.core_item_id = p.core_item_id and p3.core_plan_date between ifnull(p1.floor_stock_date, '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)  
                left join (
                select 
                a1.planning_date,
                a3.customer_id,
                a3.pattern_id,
                sum(a2.pouring_box) as pouring_box 
                from melting_heat_log_info as a1
                left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active'  
                group by a3.customer_id, a3.pattern_id, a1.planning_date
                order by a3.customer_id, a3.pattern_id, a1.planning_date 
                ) as p4 on p4.customer_id = p.customer_id and p4.pattern_id = p.pattern_id and p4.planning_date between ifnull(p1.floor_stock_date, '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                left join (select r.customer_id, r.pattern_id , count(r.core_item_id) as no_of_core from core_item_info as r where r.status = 'Active' group by r.customer_id, r.pattern_id) as p5 on p5.customer_id = p.customer_id and p5.pattern_id = p.pattern_id
                left join customer_info as p6 on p6.customer_id = p.customer_id
                left join pattern_info as p7 on p7.pattern_id = p.pattern_id
                left join (
                    select 
                    b.customer_id,
                    b.pattern_id,
                    b.core_item_id,
                    sum(b.produced_qty) as curr_core_produced_qty
                    from core_plan_info as b 
                    where b.`status` = 'Active' and b.core_plan_date = '" .$srch_date. "'
                    group by b.customer_id,b.pattern_id,b.core_item_id
                    order by b.customer_id,b.pattern_id,b.core_item_id 
                ) as q on q.customer_id = p.customer_id and q.pattern_id = p.pattern_id and q.core_item_id = p.core_item_id
                left join (
                   select  
                    a3.customer_id,
                    a3.pattern_id,
                    sum(a2.pouring_box) as curr_pouring_box  
                    from melting_heat_log_info as a1
                    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                     left join (select z.pattern_id , z.customer_id , count(z.core_item_id) as core_count from core_item_info as z where z.status = 'Active' group by z.pattern_id , z.customer_id) as a4 on a4.pattern_id = a3.pattern_id and a4.customer_id = a3.customer_id
                    where a1.`status` = 'Active'  and a1.planning_date = '" .$srch_date. "'
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id  
                ) as q1 on q1.customer_id = p.customer_id and q1.pattern_id = p.pattern_id
                where p.`status` = 'Active' ";
           if(!empty($srch_customer_id) ){
                $op_sql.=" and p.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $op_sql.=" and p.pattern_id = '". $srch_pattern_id ."'";
            }      
           $op_sql .="     
                group by p.customer_id, p.pattern_id, p.core_item_id
                order by customer ,pattern_item , core_item
            ";  */
       
        /* 
        
        $op_sql = "
        select 
            p.core_item_id,
            p.customer_id,
            p.pattern_id,
            p6.company_name as customer,
            p7.pattern_item,
            p.core_item_name as core_item, 
            ifnull(p1.floor_stock_date, '2020-12-01') as op_floor_stock_date ,
            ifnull(p2.stock_qty,0) as op_stock_qty,
            sum(ifnull(p3.core_produced_qty,0)) as core_produced_qty,
            sum(ifnull(p4.pouring_box,0)) as pouring_box,
            p5.no_of_core,
            '" .$srch_date. "' as op_stock_date,
            ((ifnull(p2.stock_qty,0) + sum(ifnull(p3.core_produced_qty,0))) - (sum(ifnull(p4.pouring_box,0)) * p.core_per_box)) as op_stock1,
            ((ifnull(p2.stock_qty,0) + sum(ifnull(p3.core_produced_qty,0))) - (sum(ifnull(p4.pouring_box,0)) * p7.no_of_core * p7.no_of_cavity)) as op_stock,
            ifnull(q.curr_core_produced_qty,0) as curr_core_produced_qty,
            (ifnull(q1.curr_pouring_box,0) * p.core_per_box ) as curr_pouring_qty1,                          
            (ifnull(q1.curr_pouring_box,0) * p7.no_of_core * p7.no_of_cavity ) as curr_pouring_qty                         
            from core_item_info as p
                left join (
                select 
                max(a.floor_stock_date) as floor_stock_date,
                a.customer_id,
                a.pattern_id,
                a.core_item_id 
                from core_floor_stock_info as a
                where a.floor_stock_date <= '" .$srch_date. "'
                group by a.customer_id,a.pattern_id,a.core_item_id 
                order by a.floor_stock_date, a.customer_id,a.pattern_id,a.core_item_id 
                ) as p1 on p1.customer_id = p.customer_id and p1.pattern_id = p.pattern_id and p1.core_item_id = p.core_item_id 
                left join  core_floor_stock_info as p2 on p2.customer_id = p.customer_id and p2.pattern_id = p.pattern_id and p2.core_item_id = p.core_item_id and p2.floor_stock_date = ifnull((select max(z.floor_stock_date) from core_floor_stock_info as z where z.core_item_id = p.core_item_id and z.floor_stock_date <= '" .$srch_date. "'),'2020-12-01')  
                left join (
                select
                b.customer_id,
                b.pattern_id,
                b.core_item_id,
                sum((b.produced_qty - b.damage_qty)) as core_produced_qty
                from core_plan_info as b 
                where b.`status` = 'Active' and b.core_plan_date between ifnull((select max(z.floor_stock_date) from core_floor_stock_info as z where z.core_item_id = b.core_item_id and z.floor_stock_date <= '" .$srch_date. "'),'2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                group by b.customer_id,b.pattern_id,b.core_item_id
                order by b.customer_id,b.pattern_id,b.core_item_id
                ) as p3 on p3.customer_id = p.customer_id and p3.pattern_id = p.pattern_id and p3.core_item_id = p.core_item_id   
                left join (
                select  
                a3.customer_id,
                a3.pattern_id,
                sum(a2.pouring_box) as pouring_box 
                from melting_heat_log_info as a1
                left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active' and a3.`status` != 'Delete' and a1.melting_date between ifnull((select max(z.floor_stock_date) from core_floor_stock_info as z where z.pattern_id = a3.pattern_id and z.floor_stock_date <= '" .$srch_date. "'),'2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)  
                group by a3.customer_id, a3.pattern_id 
                order by a3.customer_id, a3.pattern_id 
                ) as p4 on p4.customer_id = p.customer_id and p4.pattern_id = p.pattern_id  
                left join (select r.customer_id, r.pattern_id , count(r.core_item_id) as no_of_core from core_item_info as r where r.status = 'Active' group by r.customer_id, r.pattern_id) as p5 on p5.customer_id = p.customer_id and p5.pattern_id = p.pattern_id
                left join customer_info as p6 on p6.customer_id = p.customer_id
                left join pattern_info as p7 on p7.pattern_id = p.pattern_id
                left join (
                    select 
                    b.customer_id,
                    b.pattern_id,
                    b.core_item_id,
                    sum((b.produced_qty - b.damage_qty)) as curr_core_produced_qty
                    from core_plan_info as b 
                    where b.`status` = 'Active' and b.core_plan_date = '" .$srch_date. "'
                    group by b.customer_id,b.pattern_id,b.core_item_id
                    order by b.customer_id,b.pattern_id,b.core_item_id 
                ) as q on q.customer_id = p.customer_id and q.pattern_id = p.pattern_id and q.core_item_id = p.core_item_id
                left join (
                   select  
                    a3.customer_id,
                    a3.pattern_id,
                    sum(a2.pouring_box) as curr_pouring_box  
                    from melting_heat_log_info as a1
                    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                     left join (select z.pattern_id , z.customer_id , count(z.core_item_id) as core_count from core_item_info as z where z.status = 'Active' group by z.pattern_id , z.customer_id) as a4 on a4.pattern_id = a3.pattern_id and a4.customer_id = a3.customer_id
                    where a1.`status` = 'Active' and a3.`status` != 'Delete'  and a1.planning_date = '" .$srch_date. "'
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id  
                ) as q1 on q1.customer_id = p.customer_id and q1.pattern_id = p.pattern_id
                where p.`status` = 'Active' ";
           if(!empty($srch_customer_id) ){
                $op_sql.=" and p.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $op_sql.=" and p.pattern_id = '". $srch_pattern_id ."'";
            }      
           $op_sql .="     
                group by p.customer_id, p.pattern_id, p.core_item_id
                order by customer ,pattern_item , core_item
            ";
            
            $query = $this->db->query($op_sql);
            
            $data['op_stock_list'] = array();
            
            foreach ($query->result_array() as $row)
            {
                 //if((($row['op_stock'] + $row['curr_core_produced_qty']) -  $row['curr_pouring_qty']) != 0)   
                 if( $row['op_stock'] != 0 || $row['curr_core_produced_qty'] != 0 || $row['curr_pouring_qty'] != 0 )   
                    $data['op_stock_list'][$row['customer']][$row['pattern_item']][] = $row;      
            }
           */ 
              
			/*		  
             $op_sql = "
        select 
            p.core_item_id,
            p.customer_id,
            p.pattern_id,
            p6.company_name as customer,
            p7.pattern_item,
            p.core_item_name as core_item, 
            ifnull(p1.floor_stock_date, '2020-12-01') as op_floor_stock_date ,
            ifnull(p2.stock_qty,0) as op_stock_qty,
            sum(ifnull(p3.core_produced_qty,0)) as core_produced_qty,
            sum(ifnull(p4.pouring_box,0)) as pouring_box,
            p5.no_of_core,
            '" .$srch_date. "' as op_stock_date,
            ((ifnull(p2.stock_qty,0) + sum(ifnull(p3.core_produced_qty,0))) - (sum(ifnull(p4.pouring_box,0)) * p.core_per_box)) as op_stock1,
            ((ifnull(p2.stock_qty,0) + sum(ifnull(p3.core_produced_qty,0))) - (sum(ifnull(p4.pouring_box,0)) * p7.no_of_core * p7.no_of_cavity)) as op_stock,
            ifnull(q.curr_core_produced_qty,0) as curr_core_produced_qty,
            (ifnull(q1.curr_pouring_box,0) * p.core_per_box ) as curr_pouring_qty1,                          
            (ifnull(q1.curr_pouring_box,0) * p7.no_of_core * p7.no_of_cavity ) as curr_pouring_qty                          
            from core_item_info as p
                left join (
                select 
                max(a.floor_stock_date) as floor_stock_date,
                a.customer_id,
                a.pattern_id,
                a.core_item_id 
                from core_floor_stock_info as a
                where a.floor_stock_date <= '" .$srch_date. "'
                group by a.customer_id,a.pattern_id,a.core_item_id 
                order by a.floor_stock_date, a.customer_id,a.pattern_id,a.core_item_id 
                ) as p1 on p1.customer_id = p.customer_id and p1.pattern_id = p.pattern_id and p1.core_item_id = p.core_item_id 
                left join  core_floor_stock_info as p2 on p2.customer_id = p.customer_id and p2.pattern_id = p.pattern_id and p2.core_item_id = p.core_item_id and p2.floor_stock_date = ifnull((select max(z.floor_stock_date) from core_floor_stock_info as z where z.core_item_id = p.core_item_id and z.floor_stock_date <= '" .$srch_date. "'),'2020-12-01')  
                left join (
                select
                b.customer_id,
                b.pattern_id,
                b.core_item_id,
                sum((b.produced_qty - b.damage_qty)) as core_produced_qty
                from core_plan_info as b 
                where b.`status` = 'Active' and b.core_plan_date between ifnull((select max(z.floor_stock_date) from core_floor_stock_info as z where z.core_item_id = b.core_item_id and z.floor_stock_date <= '" .$srch_date. "'),'2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                group by b.customer_id,b.pattern_id,b.core_item_id
                order by b.customer_id,b.pattern_id,b.core_item_id
                ) as p3 on p3.customer_id = p.customer_id and p3.pattern_id = p.pattern_id and p3.core_item_id = p.core_item_id   
                left join (
                select  
                a3.customer_id,
                a3.pattern_id,
                sum(a2.pouring_box) as pouring_box 
                from melting_heat_log_info as a1
                left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active' and a3.`status` != 'Delete' and a1.melting_date between ifnull((select max(z.floor_stock_date) from core_floor_stock_info as z where z.pattern_id = a3.pattern_id and z.floor_stock_date <= '" .$srch_date. "'),'2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)  
                group by a3.customer_id, a3.pattern_id 
                order by a3.customer_id, a3.pattern_id 
                ) as p4 on p4.customer_id = p.customer_id and p4.pattern_id = p.pattern_id  
                left join (select r.customer_id, r.pattern_id , count(r.core_item_id) as no_of_core from core_item_info as r where r.status = 'Active' group by r.customer_id, r.pattern_id) as p5 on p5.customer_id = p.customer_id and p5.pattern_id = p.pattern_id
                left join customer_info as p6 on p6.customer_id = p.customer_id
                left join pattern_info as p7 on p7.pattern_id = p.pattern_id
                left join (
                    select 
                    b.customer_id,
                    b.pattern_id,
                    b.core_item_id,
                    sum((b.produced_qty - b.damage_qty)) as curr_core_produced_qty
                    from core_plan_info as b 
                    where b.`status` = 'Active' and b.core_plan_date between '" .$srch_date. "' and '" .$srch_to_date. "'
                    group by b.customer_id,b.pattern_id,b.core_item_id
                    order by b.customer_id,b.pattern_id,b.core_item_id 
                ) as q on q.customer_id = p.customer_id and q.pattern_id = p.pattern_id and q.core_item_id = p.core_item_id
                left join (
                   select  
                    a3.customer_id,
                    a3.pattern_id,
                    sum(a2.pouring_box) as curr_pouring_box  
                    from melting_heat_log_info as a1
                    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                     left join (select z.pattern_id , z.customer_id , count(z.core_item_id) as core_count from core_item_info as z where z.status = 'Active' group by z.pattern_id , z.customer_id) as a4 on a4.pattern_id = a3.pattern_id and a4.customer_id = a3.customer_id
                    where a1.`status` = 'Active' and a3.`status` != 'Delete' and a1.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "'
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id  
                ) as q1 on q1.customer_id = p.customer_id and q1.pattern_id = p.pattern_id
                where p.`status` = 'Active' ";
           if(!empty($srch_customer_id) ){
                $op_sql.=" and p.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $op_sql.=" and p.pattern_id = '". $srch_pattern_id ."'";
            }      
           $op_sql .="     
                group by p.customer_id, p.pattern_id, p.core_item_id
                order by customer ,pattern_item , core_item
            "; */
			$op_sql = "
        select 
            p.core_item_id,
            p.customer_id,
            p.pattern_id,
            p6.company_name as customer,
            p7.pattern_item,
            p.core_item_name as core_item, 
            ifnull(p1.floor_stock_date, '2020-12-01') as op_floor_stock_date ,
            ifnull(p2.stock_qty,0) as op_stock_qty,
            sum(ifnull(p3.core_produced_qty,0)) as core_produced_qty,
            sum(ifnull(p4.produced_qty,0)) as produced_qty,
            p5.no_of_core,
            '" .$srch_date. "' as op_stock_date,
            ((ifnull(p2.stock_qty,0) + sum(ifnull(p3.core_produced_qty,0))) - (sum(ifnull(p4.produced_qty,0)))) as op_stock,
            ifnull(q.curr_core_produced_qty,0) as curr_core_produced_qty,                          
            ((ifnull(q1.curr_pouring_qty,0)) )as curr_pouring_qty ,
            ((ifnull(q1.curr_pouring_qty,0)) * p.core_per_box )as curr_core_used
			 		
            from core_item_info as p
                left join (
                select 
                max(a.floor_stock_date) as floor_stock_date,
                a.customer_id,
                a.pattern_id,
                a.core_item_id 
                from core_floor_stock_info as a
                where a.floor_stock_date <= '" .$srch_date. "'
                group by a.customer_id,a.pattern_id,a.core_item_id 
                order by a.floor_stock_date, a.customer_id,a.pattern_id,a.core_item_id 
                ) as p1 on p1.customer_id = p.customer_id and p1.pattern_id = p.pattern_id and p1.core_item_id = p.core_item_id 
                left join  core_floor_stock_info as p2 on p2.customer_id = p.customer_id and p2.pattern_id = p.pattern_id and p2.core_item_id = p.core_item_id and p2.floor_stock_date = ifnull((select max(z.floor_stock_date) from core_floor_stock_info as z where z.core_item_id = p.core_item_id and z.floor_stock_date <= '" .$srch_date. "'),'2020-12-01')  
                left join (
                select
                b.customer_id,
                b.pattern_id,
                b.core_item_id,
                sum((b.produced_qty - b.damage_qty  - b.m_damage_qty)) as core_produced_qty
                from core_plan_info as b 
                where b.`status` = 'Active' and b.core_plan_date between ifnull((select max(z.floor_stock_date) from core_floor_stock_info as z where z.core_item_id = b.core_item_id and z.floor_stock_date <= '" .$srch_date. "'),'2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                group by b.customer_id,b.pattern_id,b.core_item_id
                order by b.customer_id,b.pattern_id,b.core_item_id
                ) as p3 on p3.customer_id = p.customer_id and p3.pattern_id = p.pattern_id and p3.core_item_id = p.core_item_id   
                left join (
                  select
                  qw.customer_id ,
                  qw.pattern_id,
                  sum(qw.produced_qty) as produced_qty  
                  from
                  (
                    (
                    select  
                    a3.customer_id,
                    a3.pattern_id,
                    sum(a2.produced_qty) as produced_qty 
                    from melting_heat_log_info as a1
                    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    where a1.`status` = 'Active' and a3.`status` != 'Delete' and a1.melting_date between ifnull((select max(z.floor_stock_date) from core_floor_stock_info as z where z.pattern_id = a3.pattern_id and z.floor_stock_date <= '" .$srch_date. "'),'2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)  
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id 
                    ) union all   (
                    select  
                    a3.customer_id,
                    a3.pattern_id,
                    sum(a2.produced_qty) as produced_qty 
                    from melting_heat_log_info as a1
                    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    where a1.`status` = 'Active' and a3.`status` != 'Delete' and a1.melting_date between ifnull((select max(z.floor_stock_date) from core_floor_stock_info as z where z.pattern_id = a3.pattern_id and z.floor_stock_date <= '" .$srch_date. "'),'2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)  
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id 
                    )
                 ) as qw
                 group by qw.customer_id ,qw.pattern_id  
                ) as p4 on p4.customer_id = p.customer_id and p4.pattern_id = p.pattern_id  
                left join (select r.customer_id, r.pattern_id , count(r.core_item_id) as no_of_core from core_item_info as r where r.status = 'Active' group by r.customer_id, r.pattern_id) as p5 on p5.customer_id = p.customer_id and p5.pattern_id = p.pattern_id
                left join customer_info as p6 on p6.customer_id = p.customer_id
                left join pattern_info as p7 on p7.pattern_id = p.pattern_id
                left join (
                    select 
                    b.customer_id,
                    b.pattern_id,
                    b.core_item_id,
                    sum((b.produced_qty - b.damage_qty - b.m_damage_qty)) as curr_core_produced_qty
                    from core_plan_info as b 
                    where b.`status` = 'Active' and b.core_plan_date between '" .$srch_date. "' and '" .$srch_to_date. "'
                    group by b.customer_id,b.pattern_id,b.core_item_id
                    order by b.customer_id,b.pattern_id,b.core_item_id 
                ) as q on q.customer_id = p.customer_id and q.pattern_id = p.pattern_id and q.core_item_id = p.core_item_id
                left join (
                   select
                   qq.customer_id ,
                   qq.pattern_id ,
                   sum(qq.curr_pouring_qty) as curr_pouring_qty
                   from
                   (
                       (
                       select  
                        a3.customer_id,
                        a3.pattern_id,
                        sum(a2.produced_qty) as curr_pouring_qty  
                        from melting_heat_log_info as a1
                        left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                        left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                         left join (select z.pattern_id , z.customer_id , count(z.core_item_id) as core_count from core_item_info as z where z.status = 'Active' group by z.pattern_id , z.customer_id) as a4 on a4.pattern_id = a3.pattern_id and a4.customer_id = a3.customer_id
                        where a1.`status` = 'Active' and a3.`status` != 'Delete' and a1.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "'
                        group by a3.customer_id, a3.pattern_id 
                        order by a3.customer_id, a3.pattern_id 
                        ) union all (
                        select  
                        a3.customer_id,
                        a3.pattern_id,
                        sum(a2.produced_qty) as curr_pouring_qty  
                        from melting_heat_log_info as a1
                        left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                        left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                         left join (select z.pattern_id , z.customer_id , count(z.core_item_id) as core_count from core_item_info as z where z.status = 'Active' group by z.pattern_id , z.customer_id) as a4 on a4.pattern_id = a3.pattern_id and a4.customer_id = a3.customer_id
                        where a1.`status` = 'Active' and a3.`status` != 'Delete' and a1.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "'
                        group by a3.customer_id, a3.pattern_id 
                        order by a3.customer_id, a3.pattern_id  
                        )
                    ) as qq 
                    group by qq.customer_id ,qq.pattern_id   
                ) as q1 on q1.customer_id = p.customer_id and q1.pattern_id = p.pattern_id
                where p.`status` = 'Active' ";
           if(!empty($srch_customer_id) ){
                $op_sql.=" and p.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $op_sql.=" and p.pattern_id = '". $srch_pattern_id ."'";
            }      
           $op_sql .="     
                group by p.customer_id, p.pattern_id, p.core_item_id
                order by customer ,pattern_item , core_item
            ";
			
		    /*  	
			echo "<pre>";
			print_r($op_sql);   
			echo "</pre>"; 
            */
            $query = $this->db->query($op_sql);
            
            $data['op_stock_list'] = array();
            
            foreach ($query->result_array() as $row)
            {
                 //if((($row['op_stock'] + $row['curr_core_produced_qty']) -  $row['curr_pouring_qty']) != 0)   
                // if( $row['op_stock'] != 0 || $row['curr_core_produced_qty'] != 0 || $row['curr_pouring_qty'] != 0 )   
                    $data['op_stock_list'][$row['customer']][$row['pattern_item']][] = $row;      
            }
             
        
         
        } else {
            $data['pattern_opt'] =array();
            
        }
        
        $this->load->view('page/reports/core_stock_report',$data); 
	}   
    
    
    public function day_production_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        $data['op_stock_list'] = array();
        
       if(isset($_POST['srch_date'])) { 
           $data['srch_date'] = $srch_date = $this->input->post('srch_date');  
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
           $data['submit_flg'] = true;
       } 
       else {
         
        $data['srch_date'] = $srch_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
       } 
        
       if(isset($_POST['srch_customer_id'])) { 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
           $data['submit_flg'] = true;
       } 
       else {
         
        $data['srch_customer_id'] = $srch_customer_id = '';
       }
       if(isset($_POST['srch_pattern_id'])) {  
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id');  
           $data['submit_flg'] = true;
       } 
       else {
        $data['srch_pattern_id'] = $srch_pattern_id = ''; 
       }
       
       
       if(!empty($srch_date)    ){
         
        $data['submit_flg'] = true;
         
       }    
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        if($data['submit_flg']) 
        { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
        
      /*  
         
       $op_sql = "
        
        select 
            a.customer_id,
            a.pattern_id,
            a.pattern_item,
            p6.company_name as customer ,
            a.piece_weight_per_kg,
            ifnull(b.floor_stock_date, '2020-12-01') as op_floor_stock_date ,
            ifnull(c.stock_qty,0) as op_stock_qty,
            ifnull(sum(p4.produced_qty),0) as produced_qty,
            ifnull(sum(w.rejection_qty),0) as rejection_qty, 
            ifnull(sum(k.despatch_qty),0) as rejection_qty ,
            ((ifnull(c.stock_qty,0) + ifnull(sum(p4.produced_qty),0)) - (ifnull(sum(w.rejection_qty),0) + ifnull(sum(k.despatch_qty),0))) as opening_stock, 
            ifnull(qa.curr_produced_qty,0) as curr_produced_qty,
            ifnull(qb.curr_rejection_qty,0) as curr_rejection_qty,
            ifnull(qc.curr_despatch_qty,0) as curr_despatch_qty 
            from pattern_info as a
            left join (
                select 
                z.customer_id,
                z.pattern_id,
                max(z.floor_stock_date)  as floor_stock_date
                from floor_stock_info as z  
                where z.floor_stock_date = '" .$srch_date. "'
                order by z.customer_id, z.pattern_id 
            ) as b on b.customer_id = a.customer_id and b.pattern_id = a.pattern_id
            left join  floor_stock_info as c on c.customer_id = a.customer_id and c.pattern_id = a.pattern_id and c.floor_stock_date = ifnull(b.floor_stock_date, '2020-12-01') 
            left join (
                select 
                a1.planning_date,
                a3.customer_id,
                a3.pattern_id, 
                (sum(a2.produced_qty) - ifnull(a4.closed_mould_qty,0)) as produced_qty
                from melting_heat_log_info as a1
                left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                left join ( select q.work_planning_id , sum(q.closed_mould_qty) as closed_mould_qty from moulding_log_item_info as q where q.`status` = 'Active' group by q.work_planning_id) as a4 on a4.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active'  and a1.planning_date <= DATE_SUB('" .$srch_date. "',INTERVAL 1 day)
                group by a3.customer_id, a3.pattern_id, a1.planning_date
                order by a3.customer_id, a3.pattern_id, a1.planning_date 
            ) as p4 on p4.customer_id = a.customer_id and p4.pattern_id = a.pattern_id and p4.planning_date between ifnull(b.floor_stock_date, '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
            left join (
                select
                b.planning_date as m_date,
                b.customer_id,
                b.pattern_id,
                sum(a.rejection_qty) as rejection_qty 
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                where a.status = 'Active' and b.status != 'Delete'  and b.planning_date <= DATE_SUB('" .$srch_date. "',INTERVAL 1 day)
                group by b.customer_id, b.pattern_id,b.planning_date
            ) as w on w.customer_id = a.customer_id and w.pattern_id = a.pattern_id and w.m_date between ifnull(b.floor_stock_date, '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
            left join(
                select 
                t.despatch_date,
                t.customer_id,
                r.pattern_id,
                sum(r.qty) as despatch_qty
                from customer_despatch_info as t 
                left join customer_despatch_item_info as r on r.customer_despatch_id = t.customer_despatch_id
                where t.status = 'Active' and t.despatch_date <= DATE_SUB('" .$srch_date. "',INTERVAL 1 day)
                group by t.despatch_date , t.customer_id , r.pattern_id
            ) as k on k.customer_id = a.customer_id and k.pattern_id = a.pattern_id and k.despatch_date between ifnull(b.floor_stock_date, '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)
            left join (
                select 
                a3.customer_id,
                a3.pattern_id, 
                (sum(a2.produced_qty) - ifnull(a4.closed_mould_qty,0)) as curr_produced_qty
                from melting_heat_log_info as a1
                left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                left join ( select q.work_planning_id , sum(q.closed_mould_qty) as closed_mould_qty from moulding_log_item_info as q where q.`status` = 'Active' group by q.work_planning_id) as a4 on a4.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active'  and a1.planning_date = '" .$srch_date. "'
                group by a3.customer_id, a3.pattern_id 
                order by a3.customer_id, a3.pattern_id 
            ) as qa on qa.customer_id = a.customer_id and qa.pattern_id = a.pattern_id
            left join (
                select 
                b.customer_id,
                b.pattern_id,
                sum(a.rejection_qty) as curr_rejection_qty 
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                where a.status = 'Active' and b.status != 'Delete'  and b.planning_date = '" .$srch_date. "' 
                group by b.customer_id, b.pattern_id,b.planning_date
            ) as qb on qb.customer_id = a.customer_id and qb.pattern_id = a.pattern_id
            left join (
                select  
                t.customer_id,
                r.pattern_id,
                sum(r.qty) as curr_despatch_qty
                from customer_despatch_info as t 
                left join customer_despatch_item_info as r on r.customer_despatch_id = t.customer_despatch_id
                where t.status = 'Active' and t.despatch_date = '" .$srch_date. "' 
                group by  t.customer_id , r.pattern_id
            ) as qc on qc.customer_id = a.customer_id and qc.pattern_id = a.pattern_id
            left join customer_info as p6 on p6.customer_id = a.customer_id 
            where a.`status` = 'Active' ";
            if(!empty($srch_customer_id) ){
                $op_sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $op_sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
            }      
            $op_sql .=" 
                group by a.pattern_id , a.customer_id 
                order by customer , pattern_item 
          
           ";  
           
           */ 
		   $this->db->query("SET sql_mode=''"); 
            
          $op_sql = " 
            select 
            a.customer_id,
            a.pattern_id,
            a.pattern_item, 
            GROUP_CONCAT( p6.company_name) as customer1,
            p6.company_name as customer,
            a.piece_weight_per_kg,
            ifnull(b.floor_stock_date, '2020-12-01') as op_floor_stock_date ,
            ifnull(c.stock_qty,0) as op_stock_qty,
            ifnull(sum(p4.produced_qty),0) as produced_qty,
            ifnull(sum(w.rejection_qty),0) as rejection_qty, 
            ifnull(sum(k.despatch_qty),0) as despatch_qty ,
            ifnull(sum(w11.adj_stock_qty),0) as adj_stock_qty ,
            ((ifnull(c.stock_qty,0) + ifnull(sum(p4.produced_qty),0) - ifnull(p5.closed_mould_qty,0)) - (ifnull(sum(w.rejection_qty),0) + ifnull(sum(k.despatch_qty),0) + ifnull(sum(w11.adj_stock_qty),0))) as opening_stock, 
            ifnull(qa.curr_produced_qty,0) as curr_produced_qty1,
            (ifnull(qa.curr_produced_qty,0) - ifnull(cm.closed_mould_qty,0)) as curr_produced_qty,
            ifnull(qb.curr_rejection_qty,0) as curr_rejection_qty,
            ifnull(qc.curr_despatch_qty,0) as curr_despatch_qty ,
            ifnull(qb11.curr_adj_stock_qty,0) as curr_adj_stock_qty ,
            (
              (  
                ((ifnull(c.stock_qty,0) + ifnull(sum(p4.produced_qty),0) - ifnull(p5.closed_mould_qty,0) ) - (ifnull(sum(w.rejection_qty),0) + ifnull(sum(k.despatch_qty),0)))
                +
                (ifnull(qa.curr_produced_qty,0))
               )
               - 
               (
                (ifnull(qb.curr_rejection_qty,0))
                 +
                (ifnull(qc.curr_despatch_qty,0))
                +
                (ifnull(qb11.curr_adj_stock_qty,0))
               ) 
            ) as closing_stock
            from pattern_info as a
            left join (
                select 
                z.customer_id,
                z.pattern_id,
                max(z.floor_stock_date)  as floor_stock_date
                from floor_stock_info as z  
                where z.floor_stock_date <= '" .$srch_date. "'
                group by z.customer_id, z.pattern_id 
                order by z.customer_id, z.pattern_id 
            ) as b on FIND_IN_SET( b.customer_id , a.customer_id) and b.pattern_id = a.pattern_id
            left join  floor_stock_info as c on FIND_IN_SET( c.customer_id , a.customer_id)  and c.pattern_id = a.pattern_id and c.floor_stock_date = ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = a.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') 
            left join (
                select 
                r.customer_id, 
                r.pattern_id,
                sum(r.produced_qty) as produced_qty
                from
                (
                    (
                    select  
                    a3.customer_id,
                    a3.pattern_id, 
                    sum((a2.produced_qty) ) as produced_qty
                    from melting_heat_log_info as a1
                    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    where a1.`status` = 'Active' and a3.`status` != 'Delete' and a1.planning_date between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = a3.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id
                    ) union all (
                    select  
                    a3.customer_id,
                    a3.pattern_id, 
                    sum((a2.produced_qty)) as produced_qty
                    from melting_heat_log_info as a1
                    left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' and a1.planning_date between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = a3.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id
                    ) 
                ) as r where 1 group by r.customer_id, r.pattern_id
            ) as p4 on FIND_IN_SET( p4.customer_id , a.customer_id) and p4.pattern_id = a.pattern_id  
            left join (
             select 
             q1.pattern_id,
             q1.customer_id,
             sum(q.closed_mould_qty) as closed_mould_qty 
             from moulding_log_item_info as q
             left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
             where q.`status` = 'Active' and q1.`status` != 'Delete' and q1.planning_date  between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = q1.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
             group by q1.pattern_id ,q1.customer_id
            ) as p5 on p5.pattern_id = a.pattern_id and FIND_IN_SET( p5.customer_id , a.customer_id)   
            
            left join (
                select
                b.planning_date as m_date,
                b.customer_id,
                b.pattern_id,
                sum(a.rejection_qty) as rejection_qty 
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                where a.status = 'Active' and b.status != 'Delete' and a.rejection_type_id != '32' and b.planning_date between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = b.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                group by b.customer_id, b.pattern_id 
            ) as w on FIND_IN_SET( w.customer_id , a.customer_id) and w.pattern_id = a.pattern_id  
            left join(
                select 
                t.despatch_date,
                t.customer_id,
                r.pattern_id,
                sum(r.qty) as despatch_qty
                from customer_despatch_info as t 
                left join customer_despatch_item_info as r on r.customer_despatch_id = t.customer_despatch_id
                where t.status = 'Active' and t.despatch_date between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = r.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)
                group by t.customer_id , r.pattern_id
            ) as k on FIND_IN_SET( k.customer_id , a.customer_id)  and k.pattern_id = a.pattern_id 
            left join (
                select
                b.planning_date as m_date,
                b.customer_id,
                b.pattern_id,
                sum(a.rejection_qty) as adj_stock_qty 
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                where a.status = 'Active' and b.status != 'Delete' and a.rejection_type_id = '32' and b.planning_date between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = b.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                group by b.customer_id, b.pattern_id 
            ) as w11 on FIND_IN_SET( w11.customer_id , a.customer_id) and w11.pattern_id = a.pattern_id  
            left join (
                select
                w.customer_id,
                w.pattern_id, 
                sum(w.curr_produced_qty) as curr_produced_qty
                from
                (
                    (
                    select 
                    a3.customer_id,
                    a3.pattern_id, 
                    sum((a2.produced_qty)) as curr_produced_qty
                    from melting_heat_log_info as a1
                    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    where a1.`status` = 'Active' and a3.`status` != 'Delete' and a1.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "'
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id 
                    ) union all (
                    select 
                    a3.customer_id,
                    a3.pattern_id, 
                    sum((a2.produced_qty)) as curr_produced_qty
                    from melting_heat_log_info as a1
                    left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' and a1.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "'
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id
                    )
                ) as w where 1 group by w.customer_id,w.pattern_id
            ) as qa on FIND_IN_SET( qa.customer_id , a.customer_id)  and qa.pattern_id = a.pattern_id
            left join (
                select 
                b.customer_id,
                b.pattern_id,
                sum(a.rejection_qty) as curr_rejection_qty 
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                where a.status = 'Active' and b.status != 'Delete' and a.rejection_type_id != '32' and b.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "' 
                group by b.customer_id, b.pattern_id 
            ) as qb on FIND_IN_SET( qb.customer_id , a.customer_id) and qb.pattern_id = a.pattern_id
            left join (
                select  
                t.customer_id,
                r.pattern_id,
                sum(r.qty) as curr_despatch_qty
                from customer_despatch_info as t 
                left join customer_despatch_item_info as r on r.customer_despatch_id = t.customer_despatch_id
                where t.status = 'Active' and t.despatch_date between '" .$srch_date. "' and '" .$srch_to_date. "'
				
                group by  t.customer_id , r.pattern_id
            ) as qc on FIND_IN_SET( qc.customer_id , a.customer_id) and qc.pattern_id = a.pattern_id
            left join (
                select 
                b.customer_id,
                b.pattern_id,
                sum(a.rejection_qty) as curr_adj_stock_qty 
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                where a.status = 'Active' and b.status != 'Delete' and a.rejection_type_id = '32' and b.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "' 
                group by b.customer_id, b.pattern_id 
            ) as qb11 on FIND_IN_SET( qb11.customer_id , a.customer_id) and qb11.pattern_id = a.pattern_id
            left join (
             select  
             q1.pattern_id,
             q1.customer_id,
             sum(q.closed_mould_qty) as closed_mould_qty 
             from moulding_log_item_info as q
             left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
             where q.`status` = 'Active' and q1.`status` != 'Delete' and q1.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "'
             group by q1.pattern_id ,q1.customer_id
            ) as cm on cm.pattern_id = a.pattern_id and FIND_IN_SET( cm.customer_id , a.customer_id)  
            
            left join customer_info as p6 on FIND_IN_SET( p6.customer_id , a.customer_id)  
            where a.`status` = 'Active' ";
            if(!empty($srch_customer_id) ){
                $op_sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $op_sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
            }   
            $op_sql .=" 
                group by a.pattern_id , a.customer_id 
                order by customer , pattern_item 
          
           ";  
        /*   
		and EXISTS (select * from work_order_info as a where a.work_order_id = r.work_order_id and a.status != 'Delete')
        echo "<pre>";
        print_r($op_sql);   
        echo "</pre>";   
        */
        
       /* 
        
        $op_sql = "
        select 
            p.core_item_id,
            p.customer_id,
            p.pattern_id,
            p6.company_name as customer,
            p7.pattern_item,
            p.core_item_name as core_item, 
            ifnull(p1.floor_stock_date, '2020-12-01') as op_floor_stock_date ,
            ifnull(p2.stock_qty,0) as op_stock_qty,
            sum(ifnull(p3.core_produced_qty,0)) as core_produced_qty,
            sum(ifnull(p4.pouring_box,0)) as pouring_box,
            p5.no_of_core,
            '" .$srch_date. "' as op_stock_date,
            ((ifnull(p2.stock_qty,0) + sum(ifnull(p3.core_produced_qty,0))) - (sum(ifnull(p4.pouring_box,0)) * p5.no_of_core)) as op_stock,
            ifnull(q.curr_core_produced_qty,0) as curr_core_produced_qty,
            (ifnull(q1.curr_pouring_box,0) * p5.no_of_core) as curr_pouring_qty                          
            from core_item_info as p
                left join (
                select 
                max(a.floor_stock_date) as floor_stock_date,
                a.customer_id,
                a.pattern_id,
                a.core_item_id 
                from core_floor_stock_info as a
                where a.floor_stock_date <= '" .$srch_date. "'
                order by a.floor_stock_date, a.customer_id,a.pattern_id,a.core_item_id 
                ) as p1 on p1.customer_id = p.customer_id and p1.pattern_id = p.pattern_id and p1.core_item_id = p.core_item_id 
                left join  core_floor_stock_info as p2 on p2.customer_id = p.customer_id and p2.pattern_id = p.pattern_id and p2.core_item_id = p.core_item_id and p2.floor_stock_date = ifnull(p1.floor_stock_date, '2020-12-01') 
                left join (
                select 
                b.core_plan_date,
                b.customer_id,
                b.pattern_id,
                b.core_item_id,
                sum(b.produced_qty) as core_produced_qty
                from core_plan_info as b 
                where b.`status` = 'Active'  
                group by b.core_plan_date,b.customer_id,b.pattern_id,b.core_item_id
                order by b.core_plan_date,b.customer_id,b.pattern_id,b.core_item_id
                ) as p3 on p3.customer_id = p.customer_id and p3.pattern_id = p.pattern_id and p3.core_item_id = p.core_item_id and p3.core_plan_date between ifnull(p1.floor_stock_date, '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)  
                left join (
                select 
                a1.planning_date,
                a3.customer_id,
                a3.pattern_id,
                sum(a2.pouring_box) as pouring_box 
                from melting_heat_log_info as a1
                left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active'  
                group by a3.customer_id, a3.pattern_id, a1.planning_date
                order by a3.customer_id, a3.pattern_id, a1.planning_date 
                ) as p4 on p4.customer_id = p.customer_id and p4.pattern_id = p.pattern_id and p4.planning_date between ifnull(p1.floor_stock_date, '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                left join (select r.customer_id, r.pattern_id , count(r.core_item_id) as no_of_core from core_item_info as r where r.status = 'Active' group by r.customer_id, r.pattern_id) as p5 on p5.customer_id = p.customer_id and p5.pattern_id = p.pattern_id
                left join customer_info as p6 on p6.customer_id = p.customer_id
                left join pattern_info as p7 on p7.pattern_id = p.pattern_id
                left join (
                    select 
                    b.customer_id,
                    b.pattern_id,
                    b.core_item_id,
                    sum(b.produced_qty) as curr_core_produced_qty
                    from core_plan_info as b 
                    where b.`status` = 'Active' and b.core_plan_date = '" .$srch_date. "'
                    group by b.customer_id,b.pattern_id,b.core_item_id
                    order by b.customer_id,b.pattern_id,b.core_item_id 
                ) as q on q.customer_id = p.customer_id and q.pattern_id = p.pattern_id and q.core_item_id = p.core_item_id
                left join (
                   select  
                    a3.customer_id,
                    a3.pattern_id,
                    sum(a2.pouring_box) as curr_pouring_box  
                    from melting_heat_log_info as a1
                    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                     left join (select z.pattern_id , z.customer_id , count(z.core_item_id) as core_count from core_item_info as z where z.status = 'Active' group by z.pattern_id , z.customer_id) as a4 on a4.pattern_id = a3.pattern_id and a4.customer_id = a3.customer_id
                    where a1.`status` = 'Active'  and a1.planning_date = '" .$srch_date. "'
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id  
                ) as q1 on q1.customer_id = p.customer_id and q1.pattern_id = p.pattern_id
                where p.`status` = 'Active' ";
           if(!empty($srch_customer_id) ){
                $op_sql.=" and p.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $op_sql.=" and p.pattern_id = '". $srch_pattern_id ."'";
            }      
           $op_sql .="     
                group by p.customer_id, p.pattern_id, p.core_item_id
                order by customer ,pattern_item , core_item
            "; 
            
            */
            
            /*echo "<pre>";
            print_r($op_sql);   
            echo "</pre>"; */
            
            $query = $this->db->query($op_sql);
            
            $data['op_stock_list'] = array();
            
            foreach ($query->result_array() as $row)
            {
                 if( $row['op_stock_qty'] != 0 || $row['curr_produced_qty'] != 0 || $row['curr_rejection_qty'] != 0 || $row['curr_despatch_qty'] != 0 )   
                    $data['op_stock_list'][$row['customer']][$row['pattern_item']][] = $row;      
            }
             
        
         
        } else {
            $data['pattern_opt'] =array();
             
            
        }
        
        $this->load->view('page/reports/day_production_report',$data); 
	}   
    
    
    public function mis_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        $data['op_stock_list'] = array();
        
       if(isset($_POST['srch_date'])) { 
           $data['srch_date'] = $srch_date = $this->input->post('srch_date');  
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
           $data['submit_flg'] = true;
       } 
       else {
         
        $data['srch_date'] = $srch_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
       } 
        
       if(isset($_POST['srch_customer_id'])) { 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
           $data['submit_flg'] = true;
       } 
       else {
         
        $data['srch_customer_id'] = $srch_customer_id = '';
       }
       if(isset($_POST['srch_pattern_id'])) {  
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id');  
           $data['submit_flg'] = true;
       } 
       else {
        $data['srch_pattern_id'] = $srch_pattern_id = ''; 
       }
       
       
       if(!empty($srch_date)    ){
         
        $data['submit_flg'] = true;
         
       }    
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        if($data['submit_flg']) 
        { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
        
       
		   $this->db->query("SET sql_mode=''"); 
            
          $op_sql = " 
            select 
            a.customer_id,
            a.pattern_id,
            a.pattern_item, 
            GROUP_CONCAT( p6.company_name) as customer,
            a.piece_weight_per_kg,
            ifnull(b.floor_stock_date, '2020-12-01') as op_floor_stock_date ,
            ifnull(c.stock_qty,0) as op_stock_qty,
            ifnull(sum(p4.produced_qty),0) as produced_qty,
            ifnull(sum(w.rejection_qty),0) as rejection_qty, 
            ifnull(sum(k.despatch_qty),0) as despatch_qty ,
            ((ifnull(c.stock_qty,0) + ifnull(sum(p4.produced_qty),0) - ifnull(p5.closed_mould_qty,0)) - (ifnull(sum(w.rejection_qty),0) + ifnull(sum(k.despatch_qty),0))) as opening_stock, 
            ifnull(qa.curr_produced_qty,0) as curr_produced_qty1,
            (ifnull(qa.curr_produced_qty,0) - ifnull(cm.closed_mould_qty,0)) as curr_produced_qty,
            ifnull(qb.curr_rejection_qty,0) as curr_rejection_qty,
            ifnull(qc.curr_despatch_qty,0) as curr_despatch_qty ,
            (
              (  
                ((ifnull(c.stock_qty,0) + ifnull(sum(p4.produced_qty),0) - ifnull(p5.closed_mould_qty,0) ) - (ifnull(sum(w.rejection_qty),0) + ifnull(sum(k.despatch_qty),0)))
                +
                (ifnull(qa.curr_produced_qty,0))
               )
               - 
               (
                (ifnull(qb.curr_rejection_qty,0))
                 +
                (ifnull(qc.curr_despatch_qty,0))
               ) 
            ) as closing_stock
            from pattern_info as a
            left join (
                select 
                z.customer_id,
                z.pattern_id,
                max(z.floor_stock_date)  as floor_stock_date
                from floor_stock_info as z  
                where z.floor_stock_date <= '" .$srch_date. "'
                group by z.customer_id, z.pattern_id 
                order by z.customer_id, z.pattern_id 
            ) as b on FIND_IN_SET( b.customer_id , a.customer_id) and b.pattern_id = a.pattern_id
            left join  floor_stock_info as c on FIND_IN_SET( c.customer_id , a.customer_id)  and c.pattern_id = a.pattern_id and c.floor_stock_date = ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = a.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') 
            left join (
                select 
                r.customer_id, 
                r.pattern_id,
                sum(r.produced_qty) as produced_qty
                from
                (
                    (
                    select  
                    a3.customer_id,
                    a3.pattern_id, 
                    sum((a2.produced_qty) ) as produced_qty
                    from melting_heat_log_info as a1
                    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    where a1.`status` = 'Active' and a3.`status` != 'Delete' and a1.planning_date between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = a3.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id
                    ) union all (
                    select  
                    a3.customer_id,
                    a3.pattern_id, 
                    sum((a2.produced_qty)) as produced_qty
                    from melting_heat_log_info as a1
                    left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' and a1.planning_date between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = a3.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id
                    ) 
                ) as r where 1 group by r.customer_id, r.pattern_id
            ) as p4 on FIND_IN_SET( p4.customer_id , a.customer_id) and p4.pattern_id = a.pattern_id  
            left join (
             select 
             q1.pattern_id,
             q1.customer_id,
             sum(q.closed_mould_qty) as closed_mould_qty 
             from moulding_log_item_info as q
             left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
             where q.`status` = 'Active' and q1.`status` != 'Delete' and q1.planning_date  between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = q1.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
             group by q1.pattern_id ,q1.customer_id
            ) as p5 on p5.pattern_id = a.pattern_id and FIND_IN_SET( p5.customer_id , a.customer_id)   
            
            left join (
                select
                b.planning_date as m_date,
                b.customer_id,
                b.pattern_id,
                sum(a.rejection_qty) as rejection_qty 
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                where a.status = 'Active' and b.status != 'Delete' and a.rejection_type_id != '32' and b.planning_date between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = b.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                group by b.customer_id, b.pattern_id 
            ) as w on FIND_IN_SET( w.customer_id , a.customer_id) and w.pattern_id = a.pattern_id  
            left join(
                select 
                t.despatch_date,
                t.customer_id,
                r.pattern_id,
                sum(r.qty) as despatch_qty
                from customer_despatch_info as t 
                left join customer_despatch_item_info as r on r.customer_despatch_id = t.customer_despatch_id
                where t.status = 'Active' and t.despatch_date between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = r.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)
                group by t.customer_id , r.pattern_id
            ) as k on FIND_IN_SET( k.customer_id , a.customer_id)  and k.pattern_id = a.pattern_id 
            left join (
                select
                w.customer_id,
                w.pattern_id, 
                sum(w.curr_produced_qty) as curr_produced_qty
                from
                (
                    (
                    select 
                    a3.customer_id,
                    a3.pattern_id, 
                    sum((a2.produced_qty)) as curr_produced_qty
                    from melting_heat_log_info as a1
                    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    where a1.`status` = 'Active' and a3.`status` != 'Delete' and a1.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "'
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id 
                    ) union all (
                    select 
                    a3.customer_id,
                    a3.pattern_id, 
                    sum((a2.produced_qty)) as curr_produced_qty
                    from melting_heat_log_info as a1
                    left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' and a1.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "'
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id
                    )
                ) as w where 1 group by w.customer_id,w.pattern_id
            ) as qa on FIND_IN_SET( qa.customer_id , a.customer_id)  and qa.pattern_id = a.pattern_id
            left join (
                select 
                b.customer_id,
                b.pattern_id,
                sum(a.rejection_qty) as curr_rejection_qty 
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                where a.status = 'Active' and b.status != 'Delete' and a.rejection_type_id != '32' and b.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "' 
                group by b.customer_id, b.pattern_id 
            ) as qb on FIND_IN_SET( qb.customer_id , a.customer_id) and qb.pattern_id = a.pattern_id
            left join (
                select  
                t.customer_id,
                r.pattern_id,
                sum(r.qty) as curr_despatch_qty
                from customer_despatch_info as t 
                left join customer_despatch_item_info as r on r.customer_despatch_id = t.customer_despatch_id
                where t.status = 'Active' and t.despatch_date between '" .$srch_date. "' and '" .$srch_to_date. "'
				
                group by  t.customer_id , r.pattern_id
            ) as qc on FIND_IN_SET( qc.customer_id , a.customer_id) and qc.pattern_id = a.pattern_id
            left join (
             select  
             q1.pattern_id,
             q1.customer_id,
             sum(q.closed_mould_qty) as closed_mould_qty 
             from moulding_log_item_info as q
             left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
             where q.`status` = 'Active' and q1.`status` != 'Delete' and q1.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "'
             group by q1.pattern_id ,q1.customer_id
            ) as cm on cm.pattern_id = a.pattern_id and FIND_IN_SET( cm.customer_id , a.customer_id)  
            
            left join customer_info as p6 on FIND_IN_SET( p6.customer_id , a.customer_id)  
            where a.`status` = 'Active' ";
            if(!empty($srch_customer_id) ){
                $op_sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $op_sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
            }   
            $op_sql .=" 
                group by a.pattern_id , a.customer_id 
                order by customer , pattern_item 
          
           ";  
        /*   
		and EXISTS (select * from work_order_info as a where a.work_order_id = r.work_order_id and a.status != 'Delete')
        echo "<pre>";
        print_r($op_sql);   
        echo "</pre>";   
        */
          
            
            
            $query = $this->db->query($op_sql);
            
            $data['op_stock_list'] = array();
            
            foreach ($query->result_array() as $row)
            {
                 if(  $row['curr_produced_qty'] != 0 || $row['curr_rejection_qty'] != 0 || $row['curr_despatch_qty'] != 0 )   
                    $data['op_stock_list'][$row['customer']][$row['pattern_item']][] = $row;      
            }
            
            $sql = "
                select 
                b.customer_id,
                b.pattern_id,
                e.pattern_item, 
                d.company_name as customer,
                a.rejection_group,
                c.rejection_type_name,
                (a.rejection_qty) as rej_qty 
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                left join rejection_type_info as c on c.rejection_type_id = a.rejection_type_id 
                left join customer_info as d on d.customer_id = b.customer_id 
                left join pattern_info as e on e.pattern_id = b.pattern_id 
                where a.status = 'Active' and b.status != 'Delete' and a.rejection_qty > 0 and a.rejection_type_id != '32'
                and b.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "' 
                
            ";
            if(!empty($srch_customer_id) ){
                $sql.=" and b.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
                $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
            } 
            
             $sql.=" group by b.customer_id, b.pattern_id ,a.rejection_group , a.rejection_type_id 
                    order by a.rejection_group , c.rejection_type_name , rej_qty  asc
                  ";
				  
			$sql = "            
               
               select 
                    a.work_planning_id,
					a.customer_id,
					a.pattern_id,
                    a.planning_date as m_date, 
                    c.company_name as customer,
                    d.pattern_item,
                    d.piece_weight_per_kg as wt  ,
                    z.produced_qty as produced_qty,
                    b.rejection_group,
                    b.rejection_type_id,
					c1.rejection_type_name,
                    sum(b.rejection_qty) as rej_qty 
                    from work_planning_info as a
                    left join pattern_info as d on d.pattern_id = a.pattern_id
                    left join customer_info as c on c.customer_id = a.customer_id
                    left join (select w.work_planning_id ,sum(w.produced_qty) as produced_qty  from melting_item_info as w where w.status ='Active' group by w.work_planning_id )  as z on z.work_planning_id = a.work_planning_id 
                    left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                    where  a.`status` != 'Delete' and a.planning_date between '" . $srch_date . "' and  '". $srch_to_date ."'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.="  and b.rejection_type_id != '' and b.rejection_type_id != '32'
                    group by a.customer_id, a.pattern_id ,b.rejection_group , b.rejection_type_id 
                    order by a.planning_date asc, c.company_name, d.pattern_item asc                
        "; 	  
        
        //echo "<pre>";
        //print_r($sql);   
        //echo "</pre>";
                  
             $query = $this->db->query($sql);
            
            $data['rej_list'] = array();
            
            foreach ($query->result_array() as $row)
            {
               $data['rej_list'][$row['customer_id']][$row['pattern_id']][$row['rejection_group']][] = $row;      
            }     
             
        
         
        } else {
            $data['pattern_opt'] =array();
             
            
        }
        
        $this->load->view('page/reports/mis_report',$data); 
	}  
    
    public function pattern_history_report() 
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        $data['pattern_opt'] =array();
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');   
            
       } 
       else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = '';  
       }
       
       if(isset($_POST['srch_customer_id'])) { 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
           $data['submit_flg'] = true;
       } 
       else {
         
        $data['srch_customer_id'] = $srch_customer_id = '';
       }
       if(isset($_POST['srch_pattern_id'])) {  
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id');  
           $data['submit_flg'] = true;
       } 
       else {
        $data['srch_pattern_id'] = $srch_pattern_id = ''; 
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       }   
       
       
       $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        
        
        if($data['submit_flg']) { 
            
       if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }     
            
            
       $sql = "
        select 
         z.p_date , 
         z.item, 
         sum(z.poured_box) as poured_box, 
         GROUP_CONCAT(z.modification_details) as modification_details,
         ifnull(z.modification_details,'1') as mod_state,
         z.match_plate_no,
         z.pattern_type,
         z.type_of_core,
         z.no_of_core,
         z.pattern_material,
         z.no_of_cavity,
         z.no_of_core_per_box,
         z.corebox_material
        from (
        (
        select 
        b.planning_date as p_date,
        c.pattern_item as item, 
        0 as poured_box, 
        a.modification_details as modification_details,
        c.match_plate_no,
        c.pattern_type,
        c.type_of_core,
        c.no_of_core,
        c.pattern_material,
        c.no_of_cavity,
        c.no_of_core_per_box,
        c.corebox_material,
        ifnull(a.modification_details,'1') as mod_state
        from moulding_log_item_info as a
        left join work_planning_info as b on b.work_planning_id = a.work_planning_id
        left join pattern_info as c on c.pattern_id = b.pattern_id
        where a.`status` = 'Active' and b.`status` != 'Delete' and
        b.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
        if(!empty($srch_customer_id) ){
            $sql.=" and b.customer_id = '". $srch_customer_id ."'"; 
        }
        if(!empty($srch_pattern_id) ){
          $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
        }
         $sql.="
        order by b.planning_date desc , c.pattern_item asc 
        ) union all (
        select 
        a.melting_date as p_date,
        d.pattern_item as item, 
        sum(b.pouring_box) as poured_box, 
        '' as modification_details,
        d.match_plate_no,
        d.pattern_type,
        d.type_of_core,
        d.no_of_core,
        d.pattern_material,
        d.no_of_cavity,
        d.no_of_core_per_box,
        d.corebox_material,
        '0' as mod_state
        from melting_heat_log_info as a
        left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
        left join work_planning_info as c on c.work_planning_id = b.work_planning_id
        left join pattern_info as d on d.pattern_id = c.pattern_id
        where a.`status` = 'Active' and b.`status` = 'Active' and c.`status` != 'Delete' and  
        a.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
        if(!empty($srch_customer_id) ){
            $sql.=" and c.customer_id = '". $srch_customer_id ."'"; 
        }
        if(!empty($srch_pattern_id) ){
          $sql.=" and c.pattern_id = '". $srch_pattern_id ."'";
        }
         $sql.="
        group by a.melting_date , d.pattern_id
        order by a.planning_date desc , d.pattern_item asc 
        )
        ) as z 
        where 1 ";
        
         $sql.="
        group by z.p_date , z.item 
        order by z.p_date , z.item 
       ";  
       
                             
       
       $sql = "
       select 
        a.melting_date as p_date,
        d.pattern_item as item, 
        sum(b.pouring_box) as poured_box, 
        GROUP_CONCAT(e.modification_details) as modification_details1,
		e.modification_details,
        d.match_plate_no,
        d.pattern_type,
        d.type_of_core,
        d.no_of_core,
        d.pattern_material,
        d.no_of_cavity,
        d.no_of_core_per_box,
        d.corebox_material,
        ifnull((e.modification_details) , 1) as mod_state1,
        ifnull((e.modification_details) , 1) as mod_state
        from melting_heat_log_info as a
        left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
        left join work_planning_info as c on c.work_planning_id = b.work_planning_id
        left join pattern_info as d on d.pattern_id = c.pattern_id
        left join moulding_log_item_info as e on e.work_planning_id = b.work_planning_id and LENGTH(e.modification_details) > 1
        where a.`status` = 'Active' and b.`status` = 'Active' and c.`status` != 'Delete' and  
        a.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'
		";
		
        if(!empty($srch_customer_id) ){
            $sql.=" and c.customer_id = '". $srch_customer_id ."'"; 
        }
        if(!empty($srch_pattern_id) ){
          $sql.=" and c.pattern_id = '". $srch_pattern_id ."'";
        }
		
         $sql.="
        group by a.melting_date , d.pattern_id
        order by a.planning_date asc , d.pattern_item asc 
        ";
         
         
        /*
        echo "<pre>";
        echo $sql;         
        echo "</pre>"; 
        */
      
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        /*
        echo "<pre>";
        print_r( $data['record_list']);
        echo "</pre>";
        */
         
		 $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'PHC'
                and a.ason_date <= '". date('Y-m-d') ."'
                order by a.ason_date desc
                limit 1
                ";
                
         $query = $this->db->query($sql); 
         
         $data['iso_label'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['iso_label'] = $row;     
        } 
		 
        }  
        $this->load->view('page/reports/pattern_history_report',$data); 
	} 
    
    public function customer_wise_melting_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
                
                
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift'); 
           //$this->session->set_userdata('srch_from_date', $this->input->post('srch_from_date'));
           //$this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date'));
           //$this->session->set_userdata('srch_core_maker_id', $this->input->post('srch_core_maker_id'));
       }
       /*elseif($this->session->userdata('srch_from_date')){
           $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ;
           $data['srch_core_maker_id'] = $srch_core_maker_id = $this->session->userdata('srch_core_maker_id') ;
       } */ 
       else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
        $data['srch_pattern_id'] = $srch_pattern_id = '';
        $data['srch_customer_id'] = $srch_customer_id = '';
		$data['srch_shift'] = $srch_shift = '';
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       }    
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
		
		
		$data['shift_opt'] = array('' => 'All Shift',  'Shift-A' => 'Shift-A' , 'Shift-B' => 'Shift-B', 'Shift-C' => 'Shift-C'); 
        
        
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
       /*  
        $sql = "
               select 
                    a.melting_date as m_date,
                    b.customer_id,
                    b.pattern_id,  
                    c.company_name as customer,
                    d.pattern_item,
                    sum(a.pouring_box) as pouring_box, 
                    d.bunch_weight,
                    d.casting_weight
                    from melting_log_info as a
                    left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                    left join customer_info as c on c.customer_id = b.customer_id
                    left join pattern_info as d on d.pattern_id = b.pattern_id 
                    where a.status = 'Active' and b.status != 'Delete' and a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and b.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.=" 
                    group by a.melting_date,b.customer_id,b.pattern_id
                    order by a.melting_date asc, c.company_name, d.pattern_item asc                
        ";
        */
        /*
        $sql = "
            select 
            a.melting_heat_log_id, 
            a.planning_date, 
            a.shift, 
            a.melting_date, 
            a.lining_heat_no, 
            a.heat_code, 
            a.days_heat_no, 
            TIMEDIFF(a.furnace_off_time,a.furnace_on_time) as furnace_time,
            TIMEDIFF(a.pouring_finish_time,a.pouring_start_time) as pouring_time, 
            (a.end_units - a.start_units) as units, 
            TIMEDIFF(a.ideal_hrs_to,a.ideal_hrs_from ) as ideal_hrs ,
            d.company_name as customer,
            e.pattern_item as item,
            b.pouring_box,
            sum(e.bunch_weight * b.pouring_box) as liq_metal,
            (((a.end_units - a.start_units) / sum(e.bunch_weight * b.pouring_box)) * 1000) as unit_per_ton
            from melting_heat_log_info as a 
            left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
            left join work_planning_info as c on c.work_planning_id = b.work_planning_id
            left join customer_info as d on d.customer_id = c.customer_id
            left join pattern_info as e on e.pattern_id = c.pattern_id
            where a.`status` = 'Active' and b.status != 'Delete' and c.`status` != 'Delete' 
            and a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'"; 
        
        if(!empty($srch_customer_id) ){
            $sql.=" and c.customer_id = '". $srch_customer_id ."'"; 
        }
        if(!empty($srch_pattern_id) ){
          $sql.=" and c.pattern_id = '". $srch_pattern_id ."'";
        }
       
       $sql.= "group by a.melting_heat_log_id 
               order by a.melting_date asc,a.days_heat_no asc, d.company_name, e.pattern_item asc";
               
       */        
        
        
       $sql = "
            select
			a.melting_heat_log_id as mid,	 
            a.* ,
            TIMEDIFF(a.furnace_off_time,a.furnace_on_time) as furnace_time,
            TIMEDIFF(a.pouring_finish_time,a.pouring_start_time) as pouring_time,
            (a.end_units - a.start_units) as units, 
            TIMEDIFF(a.ideal_hrs_to,a.ideal_hrs_from ) as ideal_hrs ,
            f.*
            from melting_heat_log_info as a 
            left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
            left join work_planning_info as c on c.work_planning_id = b.work_planning_id
            left join customer_info as d on d.customer_id = c.customer_id
            left join pattern_info as e on e.pattern_id = c.pattern_id
            left join melting_item_chemical_info as f on f.melting_heat_log_id = a.melting_heat_log_id and f.melting_item_id = b.melting_item_id
            where a.`status` = 'Active' and b.status != 'Delete' and c.`status` != 'Delete' 
			and a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'
			 
			";        
        
        if(!empty($srch_customer_id) ){
            $sql.=" and c.customer_id = '". $srch_customer_id ."'"; 
        }
        if(!empty($srch_pattern_id) ){
          $sql.=" and c.pattern_id = '". $srch_pattern_id ."'";
        }
		if(!empty($srch_shift) ){
          $sql.=" and a.shift = '". $srch_shift ."'";
        } 
		
       
       $sql.= " group by a.melting_heat_log_id 
                order by a.melting_date asc,a.days_heat_no asc, d.company_name, e.pattern_item asc , melting_item_chemical_id asc";
         
      
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
			//if($row['melting_heat_log_id'] != '')
            $data['record_list'][] = $row;     
        }
		
         //echo "<pre>";
         //echo $sql;
		 //print_r($data['record_list']);
         //echo "</pre>"; 
        
        
        
        $sql = "
            select 
            a.melting_heat_log_id, 
            b.work_planning_id,
            d.company_name as customer,
            e.pattern_item as item,
            e.*,
            f.grade_name ,
            b.pouring_box,
            e.bunch_weight as bunch_weight1,
            (c.planned_box_wt / c.planned_box) as bunch_weight,
            e.casting_weight,
            (if(b.pouring_box > 0 ,(ifnull(g.closed_mould_qty,0)),0)) as closed_mould_qty,
            ((if(b.pouring_box > 0 ,(ifnull(g.closed_mould_qty,0)),0)) * e.piece_weight_per_kg) as closed_mould_qty_wt,   
            ((e.bunch_weight * b.pouring_box) - ((if(b.pouring_box > 0 ,(ifnull(g.closed_mould_qty,0)),0)) * e.piece_weight_per_kg)) as liq_metal2 ,
            ((c.planned_box_wt) - ((if(b.pouring_box > 0 ,(ifnull(g.closed_mould_qty,0)),0)) * e.piece_weight_per_kg)) as liq_metal ,
            (((c.planned_box_wt / c.planned_box) * b.pouring_box) - ((if(b.pouring_box > 0 ,(ifnull(g.closed_mould_qty,0)),0)) * e.piece_weight_per_kg)) as liq_metal1 ,
            ((e.casting_weight * b.pouring_box ) - ((if(b.pouring_box > 0 ,(ifnull(g.closed_mould_qty,0)),0)) * e.piece_weight_per_kg)) as poured_casting_wt  
            from melting_heat_log_info as a 
            left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
            left join work_planning_info as c on c.work_planning_id = b.work_planning_id
            left join customer_info as d on d.customer_id = c.customer_id
            left join pattern_info as e on e.pattern_id = c.pattern_id
            left join grade_info as f on f.grade_id = e.grade
            left join ( select q.work_planning_id , sum(q.closed_mould_qty) as closed_mould_qty from moulding_log_item_info as q where q.`status` = 'Active' group by q.work_planning_id) as g on g.work_planning_id = b.work_planning_id
            where a.`status` = 'Active' and b.status != 'Delete' and c.`status` != 'Delete'
            and a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'"; 
        
        if(!empty($srch_customer_id) ){
            $sql.=" and c.customer_id = '". $srch_customer_id ."'"; 
        }
        if(!empty($srch_pattern_id) ){
          $sql.=" and c.pattern_id = '". $srch_pattern_id ."'";
        }
		if(!empty($srch_shift) ){
          $sql.=" and a.shift = '". $srch_shift ."'";
        } 
       
        $sql.= " 
               order by a.melting_date asc,a.days_heat_no asc, d.company_name, e.pattern_item asc";
        
		
        
        $query = $this->db->query($sql);
        
        $data['tot_liq_metal'] = array();
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['child_list'][$row['melting_heat_log_id']][] = $row;  
            $data['work_planning_list'][] = $row['work_planning_id'];  
            $data['closed_mould_qty_list'][$row['work_planning_id']] = $row['closed_mould_qty_wt'];  
            $data['tot_liq_metal'][$row['melting_heat_log_id']][] =   $row['liq_metal'] ;
        } 
        
          //echo "<pre>";
		 //print_r($sql);
			//print_r($data['tot_liq_metal']);
			//print_r($data['child_list']);
			//print_r($data['record_list']);
	 	//echo "</pre>"; 
        
       $sql = " select  
            a.prt_work_plan_id,
            e.pattern_item   
            from work_planning_info as a 
            left join pattern_info as e on e.pattern_id = a.pattern_id 
            where a.prt_work_plan_id in (". implode(',',$data['work_planning_list']).") and a.`status` != 'Delete'
            order by a.work_planning_id asc 
         ";
        $query = $this->db->query($sql);

        $data['child_record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['child_record_list'][$row['prt_work_plan_id']][] = $row['pattern_item'];  
        } 
        
        
        
         
        } else {
            $data['pattern_opt'] =array();
            
        }
        
        $this->load->view('page/reports/customer_wise_melting_report',$data); 
	} 
    
    public function customer_wise_rejection_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           $data['srch_rej_grp'] = $srch_rej_grp = $this->input->post('srch_rej_grp'); 
           $data['srch_rej_type_id'] = $srch_rej_type_id = $this->input->post('srch_rej_type_id'); 
           $data['srch_more_than'] = $srch_more_than = $this->input->post('srch_more_than'); 
           $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift'); 
		   
            
       } else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
        $data['srch_pattern_id'] = $srch_pattern_id = '';
        $data['srch_customer_id'] = $srch_customer_id = '';
        $data['srch_rej_grp'] = $srch_rej_grp = '';
        $data['srch_rej_type_id'] = $srch_rej_type_id = '';
        $data['srch_more_than'] = $srch_more_than = 0;
		$data['srch_shift'] = $srch_shift = '';
       }
       
	   $data['shift_opt'] = array('' => 'All Shift',  'Shift-A' => 'Shift-A' , 'Shift-B' => 'Shift-B', 'Shift-C' => 'Shift-C'); 
	   
	   
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       }   
       
       /*
        $sql = "
                select 
                a.rejection_type_id,
                a.rejection_group,
                a.rejection_type_name,
                a.rej_code
                from rejection_type_info as a 
                where a.`status` = 'Active'
                order by a.rejection_group asc, a.rejection_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        //$data['no_of_rej_type'] = $query->num_rows();
       
        foreach ($query->result_array() as $row)
        {
            $data['rejection_type_opt'][$row['rejection_group']][$row['rejection_type_id']] =  $row['rej_code'];     
        } 
        */
        
        $sql = "
                select 
                a.rejection_group_name
                from rejection_group_info as a 
                where a.level = 1
                order by a.rejection_group_name asc               
        "; 
        
        $query = $this->db->query($sql);
        
        //$data['no_of_rej_type'] = $query->num_rows();
       
        foreach ($query->result_array() as $row)
        {
            $data['rejection_grp_opt'][$row['rejection_group_name']] =  $row['rejection_group_name'];     
        } 
        
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
        
        if(!empty($srch_rej_grp) ){    
            
        $sql = "
                select 
                a.rejection_type_id, 
                a.rejection_type_name 
                from rejection_type_info as a 
                where a.`status` = 'Active' and a.rejection_group = '". $srch_rej_grp ."'
				and a.rejection_type_id != '32'
                order by a.rejection_type_name asc   
                              
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['rejection_typ_opt'][$row['rejection_type_id']] =  $row['rejection_type_name']   ;     
        }
        } else {
            $data['rejection_typ_opt'] =array();
        }
        
        
         
       /*
        
       $sql = "            
               
               select 
                    a.work_planning_id,
                    e.planning_date as m_date, 
                    c.company_name as customer,
                    d.pattern_item,
                    d.piece_weight_per_kg as wt,
                    a.rejection_group,
                    a.rejection_type_id,
                    a.rejection_qty 
                    from qc_inspection_info as a
                    left join work_planning_info as e on e.work_planning_id = a.work_planning_id
                    left join work_order_items_info as b on b.work_order_item_id = e.work_order_item_id
                    left join pattern_info as d on d.pattern_id = e.pattern_id 
                    left join customer_info as c on c.customer_id = e.customer_id
                    where a.`status` = 'Active' and e.`status` != 'Delete'
                    and e.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and e.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and e.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.="  
                    order by e.planning_date asc, c.company_name, d.pattern_item asc                
        ";
        
        */
        
        $sql ="
            select DISTINCT
            c.planning_date, 
            a.work_planning_id,
            e.company_name as customer,
            d.pattern_item as item,
            (a1.produced_qty) as produced_qty,
            d.piece_weight_per_kg,
            ((a1.produced_qty) * d.piece_weight_per_kg  ) as produced_wt,
            a.rejection_group,
            b.rejection_type_name as rejection_type,
            sum(a.rejection_qty) as rejection_qty,
            (sum(a.rejection_qty) * d.piece_weight_per_kg) as rej_wt,
            round((((sum(a.rejection_qty) * d.piece_weight_per_kg) / ((a1.produced_qty) * d.piece_weight_per_kg  )) * 100 ),2) as rej_pert
            from qc_inspection_info as a
            left join rejection_type_info as b on b.rejection_type_id = a.rejection_type_id
            left join work_planning_info as c on c.work_planning_id = a.work_planning_id
            left join pattern_info as d on d.pattern_id = c.pattern_id
            left join customer_info as e on e.customer_id = c.customer_id
            left join ( (select z.work_planning_id , sum(z.produced_qty) as produced_qty from melting_item_info as z where z.`status` != 'Delete' group by z.work_planning_id) union all (select z1.work_planning_id , sum(z1.produced_qty) as produced_qty from melting_child_item_info as z1 where z1.`status` != 'Delete' group by z1.work_planning_id) ) as a1 on a1.work_planning_id = a.work_planning_id  
            where exists ( select * from work_planning_info as z where z.status != 'Delete' and z.work_planning_id = a.work_planning_id and z.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."' )
            and a.`status` = 'Active' and c.`status` != 'Delete' and b.rejection_type_id != '' and b.rejection_type_id != '32'";
            if(!empty($srch_customer_id) ){
                $sql.=" and c.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $sql.=" and c.pattern_id = '". $srch_pattern_id ."'";
            }
            if(!empty($srch_rej_grp) ){
                  $sql.=" and a.rejection_group = '". $srch_rej_grp ."'";
            }
            if(!empty($srch_rej_type_id) ){
                  $sql.=" and a.rejection_type_id = '". $srch_rej_type_id ."'";
            }
			if(!empty($srch_shift) ){
				  $sql.=" and c.shift = '". $srch_shift ."'";
			}
            
            /*if(!empty($srch_more_than) ){
                      $sql.=" and round((((a.rejection_qty * d.piece_weight_per_kg) / ( sum(a1.produced_qty) * d.piece_weight_per_kg  )) * 100 ),2) >= '". $srch_more_than ."'";
            }*/
            
            
            $sql.="
            group by a.work_planning_id  ,a.rejection_group , a.rejection_type_id
            order by a.work_planning_id , e.company_name , d.pattern_item , a.rejection_group , b.rejection_type_name
        
        ";
        
        /*
        $sql = "
                select DISTINCT
                a.planning_date,
                b.company_name as customer,
                c.pattern_item as item,
                c.piece_weight_per_kg,
                sum(d.produced_qty) as produced_qty,
                (sum(d.produced_qty) * c.piece_weight_per_kg  ) as produced_wt,
                e.rejection_group,
                f.rej_code,
                f.rejection_type_name as rejection_type,
                sum(e.rejection_qty) as rejection_qty,
                (sum(e.rejection_qty) * c.piece_weight_per_kg) as rej_wt,
                round(((((sum(e.rejection_qty) * c.piece_weight_per_kg) / (sum(d.produced_qty))* c.piece_weight_per_kg )) * 100),2) as rej_pert
                from work_planning_info as a
                left join customer_info as b on b.customer_id = a.customer_id
                left join pattern_info as c on c.pattern_id = a.pattern_id
                left join melting_item_info as d on d.work_planning_id = a.work_planning_id 
                left join qc_inspection_info as e on e.work_planning_id = a.work_planning_id 
                left join rejection_type_info as f on f.rejection_type_id = e.rejection_type_id
                where a.`status` != 'Delete' and d.`status` !='Delete' and e.`status` != 'Delete'  
                and a.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                if(!empty($srch_customer_id) ){
                    $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                }
                if(!empty($srch_pattern_id) ){
                  $sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
                }
                if(!empty($srch_rej_grp) ){
                      $sql.=" and e.rejection_group = '". $srch_rej_grp ."'";
                }
                if(!empty($srch_rej_type_id) ){
                      $sql.=" and e.rejection_type_id = '". $srch_rej_type_id ."'";
                }
                if(!empty($srch_more_than) ){
                      $sql.=" and round((((e.rejection_qty) / (d.produced_qty) ) *100),2) >= '". $srch_more_than ."'";
                }
                
                $sql.="  
                group by a.work_planning_id , e.rejection_group , e.rejection_type_id
                order by a.planning_date ,b.company_name , c.pattern_item ,  e.rejection_group ,   rej_pert desc
        "; */
        
        /* echo "<pre>";
        echo $sql;
        echo "</pre>"; */
       
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
        
        $data['no_of_records'] = $query->num_rows();
		$data['tot_rej_qty11'] = 0;
       
        foreach ($query->result_array() as $row)
        {
			$data['tot_rej_qty11'] += $row['rejection_qty'];
            //$data['record_list'][$row['m_date']][$row['customer']][$row['pattern_item']][$row['rejection_group']][$row['rejection_type_id']]  = $row['rejection_qty'];     
            //$data['record_list'][$row['work_planning_id']][]  = $row;     
            //$data['qc_list'][$row['work_planning_id']][$row['rejection_group']][$row['rejection_type_id']]  = $row['rejection_qty'];
            
            /*$data['record_list1'][$row['planning_date']] [] = $row['planning_date'];
            $data['record_list1'][$row['customer']] [] = $row['customer'];
            $data['record_list1'][$row['item']] [] = $row['item'];*/
            if(empty($srch_more_than) ){
                $data['record_list1'][$row['planning_date']][$row['customer']] [$row['item']] [$row['rejection_group']][$row['rejection_type']]  = $row;
            } else 
            {   
                if($row['rej_pert'] >= $srch_more_than)
                    $data['record_list1'][$row['planning_date']][$row['customer']] [$row['item']] [$row['rejection_group']][$row['rejection_type']]  = $row;        
            }
            //$data['record_list'][] = $row;       
        }
        
        
        $sql = "
        select  
        sum(q.tot_qty) as production_qty,
        sum(q.tot_wt) as production_wt
        from ( 
        select
        w.planning_date,
        w.customer_id,
        w.pattern_id, 
        sum(w.curr_produced_qty) as curr_produced_qty,
        sum(ifnull(cm.closed_mould_qty,0)) as closed_mould_qty,
        r.piece_weight_per_kg,
        (sum(w.curr_produced_qty) - sum(ifnull(cm.closed_mould_qty,0))) as tot_qty,
        round(((sum(w.curr_produced_qty) - sum(ifnull(cm.closed_mould_qty,0))) * r.piece_weight_per_kg),3) as tot_wt
        from
        (
          (
          select 
          a3.customer_id,
          a3.pattern_id, 
          a1.planning_date,
          sum((a2.produced_qty)) as curr_produced_qty
          from melting_heat_log_info as a1
          left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
          left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
          where a1.`status` = 'Active' and a3.`status` != 'Delete' and a1.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'
          ";
          if(!empty($srch_customer_id) ){
                $sql.=" and a3.customer_id = '". $srch_customer_id ."'"; 
            }  
          if(!empty($srch_pattern_id) ){
              $sql.=" and a3.pattern_id = '". $srch_pattern_id ."'";
            } 
		  if(!empty($srch_shift) ){
			  $sql.=" and a3.shift = '". $srch_shift ."'";
		  }			
          $sql.="
          group by a3.customer_id, a3.pattern_id ,a1.planning_date
          order by a3.customer_id, a3.pattern_id 
          ) union all (
          select 
          a3.customer_id,
          a3.pattern_id, 
          a3.planning_date,
          sum((a2.produced_qty)) as curr_produced_qty
          from melting_heat_log_info as a1
          left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
          left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
          where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' and a3.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'
          ";
          if(!empty($srch_customer_id) ){
                $sql.=" and a3.customer_id = '". $srch_customer_id ."'"; 
            }  
          if(!empty($srch_pattern_id) ){
              $sql.=" and a3.pattern_id = '". $srch_pattern_id ."'";
            } 
		  if(!empty($srch_shift) ){
			  $sql.=" and a3.shift = '". $srch_shift ."'";
		  }		
          $sql.="
          group by a3.customer_id, a3.pattern_id ,a3.planning_date
          order by a3.customer_id, a3.pattern_id
          )
        ) as w 
        left join (
                     select  
                     q1.pattern_id,
                     q1.customer_id,
                     q1.planning_date,
                     sum(q.closed_mould_qty) as closed_mould_qty 
                     from moulding_log_item_info as q
                     left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
                     where q.`status` = 'Active' and q1.`status` != 'Delete' and q1.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'
                     ";
                      if(!empty($srch_customer_id) ){
                            $sql.=" and q1.customer_id = '". $srch_customer_id ."'"; 
                        } 
                      if(!empty($srch_pattern_id) ){
                          $sql.=" and q1.pattern_id = '". $srch_pattern_id ."'";
                        }    
					  if(!empty($srch_shift) ){
						  $sql.=" and q1.shift = '". $srch_shift ."'";
					  }			
                      $sql.="
                     group by q1.pattern_id ,q1.customer_id, q1.planning_date
                    ) as cm on cm.pattern_id = w.pattern_id and cm.customer_id = w.customer_id and cm.planning_date = w.planning_date
        left join pattern_info as r on r.pattern_id = w.pattern_id             
        where 1 
        group by w.customer_id,w.pattern_id , w.planning_date
        ) as q
           
        ";
        
        $query = $this->db->query($sql);
        $data['production'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $data['production'] = $row;   
        }  
        
         
        } else {
            $data['pattern_opt'] =array();
            $data['rejection_typ_opt'] =array();
            
        }
        
        $this->load->view('page/reports/customer_wise_rejection_report',$data); 
	}  
    
    public function rejection_summary_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           
            
       } else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
        $data['srch_pattern_id'] = $srch_pattern_id = '';
        $data['srch_customer_id'] = $srch_customer_id = ''; 
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       }   
       
       
        $sql = "
                select 
                a.rejection_type_id,
                a.rejection_group,
                a.rejection_type_name,
                a.rej_code
                from rejection_type_info as a 
                where a.`status` = 'Active'
                order by a.rejection_group asc, a.rejection_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        //$data['no_of_rej_type'] = $query->num_rows();
       
        foreach ($query->result_array() as $row)
        {
            $data['rejection_type_opt'][$row['rejection_group']][$row['rejection_type_id']] =  $row['rej_code'];     
        } 
         
        
        $sql = "
                select 
                a.rejection_group_name 
                from rejection_group_info as a 
                where a.level = 1
                order by a.rejection_group_name asc               
        "; 
        
        $query = $this->db->query($sql);
        
        //$data['no_of_rej_type'] = $query->num_rows();
       
        foreach ($query->result_array() as $row)
        {
            $data['rejection_grp_opt'][$row['rejection_group_name']] =  $row['rejection_group_name'];     
        } 
        
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)   
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
        
        if(!empty($srch_rej_grp) ){    
            
        $sql = "
                select 
                a.rejection_type_id, 
                a.rejection_type_name 
                from rejection_type_info as a 
                where a.`status` = 'Active' and a.rejection_group = '". $srch_rej_grp ."'
                order by a.rejection_type_name asc   
                              
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['rejection_typ_opt'][$row['rejection_type_id']] =  $row['rejection_type_name']   ;     
        }
        } else {
            $data['rejection_typ_opt'] =array();
        }
        
        
         
       /*
        
       $sql = "            
               
               select 
                    a.work_planning_id,
                    e.planning_date as m_date, 
                    c.company_name as customer,
                    d.pattern_item,
                    d.piece_weight_per_kg as wt,
                    a.rejection_group,
                    a.rejection_type_id,
                    a.rejection_qty ,
                    sum(z.produced_qty) as produced_qty
                    from qc_inspection_info as a
                    left join work_planning_info as e on e.work_planning_id = a.work_planning_id
                    left join work_order_items_info as b on b.work_order_item_id = e.work_order_item_id
                    left join pattern_info as d on d.pattern_id = e.pattern_id 
                    left join customer_info as c on c.customer_id = e.customer_id
                    left join melting_item_info as z on z.work_planning_id = a.work_planning_id and z.status ='Active'
                    where a.`status` = 'Active' and e.`status` != 'Delete'
                    and e.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and e.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and e.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.="  
                    group by e.work_planning_id ,e.customer_id, e.pattern_id ,a.rejection_group , a.rejection_type_id 
                    order by e.planning_date asc, c.company_name, d.pattern_item asc                
        ";
        */
         
        //echo  $sql;
        
        /*
        $sql = "
                select 
                a.planning_date as m_date,
                b.company_name as customer,
                c.pattern_item,
                c.piece_weight_per_kg,
                sum(d.produced_qty) as produced_qty,
                e.rejection_group,
                f.rej_code,
                e.rejection_type_id,
                f.rejection_type_name as rejection_type,
                sum(e.rejection_qty) as rejection_qty,
                (sum(e.rejection_qty) * c.piece_weight_per_kg) as rej_wt,
                round(((sum(e.rejection_qty) / sum(d.produced_qty) ) *100),2) as rej_pert
                from work_planning_info as a
                left join customer_info as b on b.customer_id = a.customer_id
                left join pattern_info as c on c.pattern_id = a.pattern_id
                left join melting_item_info as d on d.work_planning_id = a.work_planning_id 
                left join qc_inspection_info as e on e.work_planning_id = a.work_planning_id 
                left join rejection_type_info as f on f.rejection_type_id = e.rejection_type_id
                where a.`status` != 'Delete' and d.`status` !='Delete' and e.`status` != 'Delete'  
                and a.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                if(!empty($srch_customer_id) ){
                    $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                }
                if(!empty($srch_pattern_id) ){
                  $sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
                }
                /*if(!empty($srch_rej_grp) ){
                      $sql.=" and e.rejection_group = '". $srch_rej_grp ."'";
                }
                if(!empty($srch_rej_type_id) ){
                      $sql.=" and e.rejection_type_id = '". $srch_rej_type_id ."'";
                }
                if(!empty($srch_more_than) ){
                      $sql.=" and round((((e.rejection_qty) / (d.produced_qty) ) *100),2) >= '". $srch_more_than ."'";
                }* /
                
                $sql.="  
                group by a.work_planning_id  
                order by a.planning_date ,b.company_name , c.pattern_item ,  e.rejection_group ,   rej_pert desc
        ";
        
        */
        
        $sql = "            
               
               select 
                    a.work_planning_id,
                    date_format(a.planning_date,'%d-%m-%Y') as m_date, 
                    a.shift,
                    c.company_name as customer,
                    d.pattern_item,
                    d.piece_weight_per_kg as wt  ,
                    z.produced_qty as produced_qty,
                    b.rejection_group,
                    b.rejection_type_id,
                    sum(b.rejection_qty) as rejection_qty,
                    b.tumblast_machine_operator,
                    b.shot_blastng_machine_operator,
                    b.ag4_machine_operator,
                    b.contractor_grinding_machine_operator,
                    b.company_grinding_machine_operator,
                    b.painting_person ,
                    b.factory_manager,
                    b.shift_supervisor
                    from work_planning_info as a
                    left join pattern_info as d on d.pattern_id = a.pattern_id
                    left join customer_info as c on c.customer_id = a.customer_id
                    left join (select w.work_planning_id ,sum(w.produced_qty) as produced_qty  from melting_item_info as w where w.status ='Active' group by w.work_planning_id )  as z on z.work_planning_id = a.work_planning_id 
                    left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
                    where  a.`status` != 'Delete' and b.rejection_type_id != '32' and a.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.="  
                    group by a.work_planning_id ,a.customer_id, a.pattern_id ,b.rejection_group , b.rejection_type_id 
                    order by a.planning_date asc, a.shift , c.company_name, d.pattern_item asc     
                            
        "; 
        
        /* 
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        */ 
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
        
        $data['no_of_records'] = $query->num_rows();
       
        foreach ($query->result_array() as $row)
        {
           // $data['record_list'][$row['m_date']][$row['customer']][$row['pattern_item']][$row['rejection_group']][$row['rejection_type_id']]  = $row['rejection_qty'];     
            if($row['produced_qty'] > 0) {
               // $data['record_list'][$row['work_planning_id']][]  = $row;     
                $data['qc_list'][$row['work_planning_id']][$row['rejection_group']][$row['rejection_type_id']]  = $row['rejection_qty'];
                
                
               // $data['rej_summary'][$row['customer']][$row['m_date']][$row['shift']][$row['pattern_item']][$row['work_planning_id']] = $row;
             //   $data['rec_list'][$row['work_planning_id']]  = array('wt' => $row['wt'], 'produced_qty' => $row['produced_qty'] , 'rej_qty' => $row['rejection_qty']  ) ;
              //  $data['tot_rej_qty'][$row['customer']][$row['m_date']][$row['shift']][$row['pattern_item']][] = ($row['rejection_qty'] == '' ? 0 : $row['rejection_qty']); 
                
                $data['rej_summary'][$row['m_date']][$row['shift']] [$row['work_planning_id']] = $row;
                $data['rec_list'][$row['work_planning_id']]  = array('wt' => $row['wt'], 'produced_qty' => $row['produced_qty'] , 'rej_qty' => $row['rejection_qty']  ) ;
                $data['tot_rej_qty'][$row['m_date']][$row['shift']][$row['pattern_item']][] = ($row['rejection_qty'] == '' ? 0 : $row['rejection_qty']); 
                if(!empty($row['tumblast_machine_operator'])){
                    $data['operator'][$row['m_date']][$row['shift']] =  array(
                                                                            'tumblast_machine_operator' => $row['tumblast_machine_operator'], 
                                                                            'shot_blastng_machine_operator' => $row['shot_blastng_machine_operator'] , 
                                                                            'ag4_machine_operator' => $row['ag4_machine_operator'] , 
                                                                            'contractor_grinding_machine_operator' => $row['contractor_grinding_machine_operator'] , 
                                                                            'company_grinding_machine_operator' => $row['company_grinding_machine_operator'] , 
                                                                            'painting_person' => $row['painting_person'] , 
                                                                            'factory_manager' => $row['factory_manager'] , 
                                                                            'shift_supervisor' => $row['shift_supervisor'] , 
                                                                            ) ;
                }
            }
            
                
                                                      
            /*$data['record_list1'][$row['planning_date']] [] = $row['planning_date'];
            $data['record_list1'][$row['customer']] [] = $row['customer'];
            $data['record_list1'][$row['item']] [] = $row['item'];*/
            //$data['record_list1'][$row['planning_date']][$row['customer']] [$row['item']] [$row['rejection_group']][$row['rejection_type']]  = $row;
            //$data['record_list'][] = $row;       
        }
        
        if($this->input->post('btn_print') == 'print') {
            
          $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'FPL'
                and a.ason_date <= '". date('Y-m-d') ."'
                order by a.ason_date desc
                limit 1
                ";
                
         $query = $this->db->query($sql); 
         
         $data['iso_label'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['iso_label'] = $row;     
        } 
            
          $this->print_rejection_report($data); 
           
        } else {  
        
        //$this->load->view('page/reports/print-rejection-report',$data); 
        $this->load->view('page/reports/rejection_summary_report',$data); 
        }
         
         
        } else {
            $data['pattern_opt'] =array();
           // $data['rejection_typ_opt'] =array();
           
           $this->load->view('page/reports/rejection_summary_report',$data); 
            
        }
        
        //$this->load->view('page/reports/rejection_summary_report',$data); 
	} 
    
    public function print_rejection_report($data){
        
        
        $this->load->view('page/reports/print-rejection-report',$data); 
    }
    
    
    
    public function moulding_consumption_report()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
            
       }
       elseif($this->session->userdata('srch_from_date')){
           $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ;
            
       } else {
        $data['srch_from_date'] = $srch_from_date = date('Y-m-d');
        $data['srch_to_date'] = $srch_to_date = date('Y-m-d'); 
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date)  ){
        $where = " a.moulding_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'"; 
        $data['submit_flg'] = true;
         
       }  
        
        
        if($data['submit_flg']) { 
        
        $sql = "
                select 
                a.moulding_date, 
                a.bentonite,
                a.bentokol
                from moulding_material_log as a
                where 
                a.`status` = 'Active' and 
                exists ( select * from work_planning_info as z where z.status != 'Delete' and z.work_planning_id = a.work_planning_id ) and
                $where      
                order by a.moulding_date asc                
        ";
        
        $sql = "
                select 
                a.moulding_date, 
                a.bentonite,
                a.bentokol
                from moulding_material_log as a 
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                where a.status != 'Delete' and b.status != 'Delete' and a.moulding_date != 0 and
                $where      
                order by a.moulding_date asc                
        ";
        
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        } 
        
        }
        
        $this->load->view('page/reports/moulding_consumption_report',$data); 
    }
    
    public function melting_consumption_report()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
            
       }
       elseif($this->session->userdata('srch_from_date')){
           $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ;
            
       } else {
        $data['srch_from_date'] = $srch_from_date = date('Y-m-d');
        $data['srch_to_date'] = $srch_to_date = date('Y-m-d'); 
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date)  ){
        $where = " a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'"; 
        $data['submit_flg'] = true;
         
       }  
        
        
        if($data['submit_flg']) { 
        
        $sql = "
                select 
                    a.melting_date, 
                    a.heat_code,
                    a.days_heat_no,
                    TIMEDIFF(a.furnace_off_time,a.furnace_on_time) as furnace,
                    TIMEDIFF(a.pouring_finish_time,a.pouring_start_time) as pouring_time,
                    (a.end_units - a.start_units) as units,
                    if(a.boring = '',0, a.boring) as boring,
                    if(a.ms = '',0, a.ms) as ms, 
                    if(a.foundry_return = '',0, a.foundry_return) as foundry_return, 
                    if(a.CI_scrap = '',0, a.CI_scrap) as CI_scrap,  
                    if(a.pig_iron = '',0, a.pig_iron) as pig_iron,  
                    if(a.spillage = '',0, a.spillage) as spillage,  
                    if(a.C = '',0, a.C) as C,   
                    if(a.SI = '',0, a.SI) as SI,   
                    if(a.Mn = '',0, a.Mn) as Mn,  
                    if(a.S = '',0, a.S) as S, 
                    if(a.Cu = '',0, a.Cu) as Cu,  
                    if(a.Cr = '',0, a.Cr) as Cr, 
                    if(a.graphite_coke = '',0, a.graphite_coke) as graphite_coke, 
                    if(a.fe_si_mg = '',0, a.fe_si_mg) as fe_si_mg,  
                    if(a.fe_sulphur = '',0, a.fe_sulphur) as fe_sulphur,  
                    if(a.inoculant = '',0, a.inoculant) as inoculant,  
                    if(a.pyrometer_tip = '',0, a.pyrometer_tip) as pyrometer_tip,  
                    TIMEDIFF(a.ideal_hrs_to , a.ideal_hrs_from) as ideal_hrs,
                    sum(b.pouring_box) as pouring_box,
                    sum(b.pouring_box * d.bunch_weight) as liq_metal,
                    (((a.end_units - a.start_units) / sum(b.pouring_box * d.bunch_weight) )* 1000) as unit_per_ton,
                    (
                      if(a.pig_iron = '',0, a.pig_iron) 
                    + if(a.foundry_return = '',0, a.foundry_return) 
                    + if(a.ms = '',0, a.ms) 
                    + if(a.spillage = '',0, a.spillage)
                    + if(a.boring = '',0, a.boring)
                    + if(a.CI_scrap = '',0, a.CI_scrap)
                    
                    ) as m_consumpt,
                    (
                    (
                      if(a.pig_iron = '',0, a.pig_iron) 
                    + if(a.foundry_return = '',0, a.foundry_return) 
                    + if(a.ms = '',0, a.ms) 
                    + if(a.spillage = '',0, a.spillage)
                    + if(a.boring = '',0, a.boring)
                    + if(a.CI_scrap = '',0, a.CI_scrap)
                    ) - sum(b.pouring_box * d.bunch_weight)
                    ) melt_loss
                    from melting_heat_log_info as a
                    left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
                    left join work_planning_info as c on c.work_planning_id = b.work_planning_id
                    left join pattern_info as d on d.pattern_id = c.pattern_id
                    where 
                    a.`status` = 'Active' and c.`status` != 'Delete' and 
                    exists ( select * from work_planning_info as z left join melting_item_info as q on q.work_planning_id = z.work_planning_id where q.melting_heat_log_id = a.melting_heat_log_id and z.status != 'Delete' and q.status = 'Active'  ) and
                    $where
                    group by a.melting_heat_log_id             
                    order by a.melting_date asc               
        ";
        
        /*echo "<pre>";
        print_r($sql);
        echo "</pre>";*/
        
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        } 
        
        }
        
        $this->load->view('page/reports/melting_consumption_report',$data); 
    }
    
    public function date_wise_melting_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
       if(isset($_POST['srch_month'])) {
         $data['srch_month'] = $srch_month = $this->input->post('srch_month');  
       } else {
         $data['srch_month'] = $srch_month = date('Y-m');
       } 
       if(isset($_POST['srch_customer_id'])) {
         $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
       } else {
         $data['srch_customer_id'] = $srch_customer_id = '';
       } 
       
       
        
       $where = " and 1=1  ";
       if(!empty($srch_month)){
        $where .= " and date_format(a.planning_date,'%Y-%m') = '" . $srch_month . "'"; 
        $data['submit_flg'] = true;
        }
       
       if(!empty($srch_customer_id)){
        $where .= " and c.customer_id= '" . $srch_customer_id . "'";  
        $data['submit_flg'] = true;         
       }    
        
      $sql = "
                select 
                a.customer_id,                
                a.company_name as customer  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['customer']   ;     
        }  
         
        
        if($data['submit_flg']) {
        
         
        
       /* $sql = "
                select 
                date_format(a.planning_date,'%Y-%m') as num_month,
                date_format(a.planning_date,'%d') as month_date,
                a.planning_date,
                c.company_name as customer,
                d.pattern_item as item, 
                b.pouring_box,
                d.bunch_weight
                from work_planning_info as a
                left join melting_log_info as b on b.work_planning_id = a.work_planning_id
                left join customer_info as c on c.customer_id = a.customer_id
                left join pattern_info as d on d.pattern_id = a.pattern_id
                where a.`status` != 'Delete'  
                $where   
                order by a.planning_date asc                
        ";*/
        
        $sql ="
        select  
        b.work_planning_id,
        date_format(a.planning_date,'%Y-%m') as num_month,
        date_format(a.planning_date,'%d') as month_date,
        d.pattern_item as item,  
        sum(b.pouring_box) as pouring_box,
        d.bunch_weight
        from melting_heat_log_info as a  
        left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
        left join work_planning_info as c on c.work_planning_id = b.work_planning_id
        left join pattern_info as d on d.pattern_id = c.pattern_id
        where a.`status` = 'Active' and c.`status` != 'Delete' 
        $where 
        group by a.planning_date , c.pattern_id 
        order by a.planning_date 
        ";
        
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
        $data['work_planning_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['item']][$row['month_date']] = $row['pouring_box'];     
            $data['record_list'][$row['item']]['weight'] = $row['bunch_weight'];  
           // $data['work_planning_list'][] = $row['work_planning_id'] ;  
        }
        
        /*
        $sql = " select  
            a.prt_work_plan_id,
            e.pattern_item   
            from work_planning_info as a 
            left join pattern_info as e on e.pattern_id = a.pattern_id 
            where a.prt_work_plan_id in (". implode(',',$data['work_planning_list']).") and a.`status` != 'Delete'
            order by a.work_planning_id asc 
         ";
        $query = $this->db->query($sql);

        $data['child_record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['child_record_list'][$row['prt_work_plan_id']][] = $row['pattern_item'];  
        } */
         
        }
        
        $this->load->view('page/reports/date_wise_melting_report',$data); 
	}
    
    public function date_wise_planning_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
       if(isset($_POST['srch_month'])) {
         $data['srch_month'] = $srch_month = $this->input->post('srch_month');  
       } else {
         $data['srch_month'] = $srch_month = date('Y-m');
       } 
       if(isset($_POST['srch_customer_id'])) {
         $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
       } else {
         $data['srch_customer_id'] = $srch_customer_id = '';
       } 
       
       
        
       $where= " and 1=1 "; 
       
       if(!empty($srch_month)){
        $where .= " and date_format(a.planning_date,'%Y-%m') = '" . $srch_month . "'"; 
        $data['submit_flg'] = true;
        }
       
       if(!empty($srch_customer_id)){
        $where .= " and a.customer_id= '" . $srch_customer_id . "'";  
        $data['submit_flg'] = true;         
       }    
        
      $sql = "
                select 
                a.customer_id,                
                a.company_name as customer  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['customer']   ;     
        }  
         
        
        if($data['submit_flg']) {
        
         
        
        $sql = "
                select 
                date_format(a.planning_date,'%Y-%m') as num_month,
                date_format(a.planning_date,'%d') as month_date,
                a.planning_date,
                c.company_name as customer,
                d.pattern_item as item, 
                a.planned_box,
                d.bunch_weight
                from work_planning_info as a 
                left join customer_info as c on c.customer_id = a.customer_id
                left join pattern_info as d on d.pattern_id = a.pattern_id
                where a.`status` != 'Delete'  
                $where   
                order by a.planning_date asc                
        ";
        
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['item']][$row['month_date']] = $row['planned_box'];     
            $data['record_list'][$row['item']]['weight'] = $row['bunch_weight'];     
        }
         
        }
        
        $this->load->view('page/reports/date_wise_planning_report',$data); 
	}
    
    public function date_wise_production_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
       if(isset($_POST['srch_month'])) {
         $data['srch_month'] = $srch_month = $this->input->post('srch_month');  
       } else {
         $data['srch_month'] = $srch_month = date('Y-m');
       } 
       if(isset($_POST['srch_customer_id'])) {
         $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
       } else {
         $data['srch_customer_id'] = $srch_customer_id = '';
       } 
       
       
       $where= " and 1=1 ";  
       
       if(!empty($srch_month)){
        $where .= " and date_format(b.planning_date,'%Y-%m') = '" . $srch_month . "'"; 
        $data['submit_flg'] = true;
        }
       
       if(!empty($srch_customer_id)){
        $where .= " and b.customer_id= '" . $srch_customer_id . "'";  
        $data['submit_flg'] = true;         
       }    
        
      $sql = "
                select 
                a.customer_id,                
                a.company_name as customer  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['customer']   ;     
        }  
         
        
        if($data['submit_flg']) {
        
         
        $sql = "            
               
               select 
                    date_format(b.planning_date,'%Y-%m') as num_month,
                    date_format(b.planning_date,'%d') as month_date,
                    b.planning_date,
                    d.company_name as customer,
                    e.pattern_item as item, 
                    (sum(a.produced_box)) as produced_box,
                    e.piece_weight_per_kg 
                    from moulding_log_item_info as a 
                    left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                    left join customer_info as d on d.customer_id = b.customer_id
                    left join pattern_info as e on e.pattern_id = b.pattern_id 
                    where b.`status` != 'Delete' and a.`status` != 'Delete'
                    ". $where ." 
                    group by a.work_planning_id,b.customer_id,b.pattern_id
                    order by b.planning_date asc, d.company_name, e.pattern_item asc                
        "; 
         
        /*
        $sql = "
                select 
                date_format(a.planning_date,'%Y-%m') as num_month,
                date_format(a.planning_date,'%d') as month_date,
                a.planning_date,
                c.company_name as customer,
                d.pattern_item as item, 
                (sum(b.pouring_box) * d.no_of_cavity) as produced_qty,
                d.piece_weight_per_kg
                from work_planning_info as a
                left join moulding_log_item_info as b on b.work_planning_id = a.work_planning_id
                left join customer_info as c on c.customer_id = a.customer_id
                left join pattern_info as d on d.pattern_id = a.pattern_id
                where a.`status` != 'Delete' and b.status != 'Delete' 
                $where   
                group by a.work_planning_id                
                order by a.planning_date asc                
        ";
        
        */
        
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['item']][$row['month_date']] = $row['produced_box'];     
            $data['record_list'][$row['item']]['weight'] = $row['piece_weight_per_kg'];     
        }
         
        }
        
        $this->load->view('page/reports/date_wise_production_report',$data); 
	}
    
    public function date_wise_rejection_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
       if(isset($_POST['srch_month'])) {
         $data['srch_month'] = $srch_month = $this->input->post('srch_month');  
       } else {
         $data['srch_month'] = $srch_month = date('Y-m');
       } 
       if(isset($_POST['srch_customer_id'])) {
         $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
       } else {
         $data['srch_customer_id'] = $srch_customer_id = '';
       } 
       
       
        $where= " and 1=1 "; 
       
       if(!empty($srch_month)){
        $where .= " and date_format(b.planning_date,'%Y-%m') = '" . $srch_month . "'"; 
        $data['submit_flg'] = true;
        }
       
       if(!empty($srch_customer_id)){
        $where .= " and b.customer_id= '" . $srch_customer_id . "'";  
        $data['submit_flg'] = true;         
       }    
        
      $sql = "
                select 
                a.customer_id,                
                a.company_name as customer  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['customer']   ;     
        }  
         
        
        if($data['submit_flg']) {
        
         
        
        $sql = "
                select 
                date_format(b.planning_date,'%Y-%m') as num_month,
                date_format(b.planning_date,'%d') as month_date,
                c.company_name as customer,
                d.pattern_item as item, 
                sum(a.rejection_qty) as rejection_qty,
                d.piece_weight_per_kg
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                left join customer_info as c on c.customer_id = b.customer_id
                left join pattern_info as d on d.pattern_id = b.pattern_id
                where a.`status` != 'Delete'  and b.`status` != 'Delete' and a.rejection_type_id != '32'
                $where   
                group by b.planning_date , b.customer_id, b.pattern_id
                order by b.planning_date ,c.company_name, d.pattern_item asc                
        ";
        
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['item']][$row['month_date']] = $row['rejection_qty'];     
            $data['record_list'][$row['item']]['weight'] = $row['piece_weight_per_kg'];     
        }
         
        }
        
        $this->load->view('page/reports/date_wise_rejection_report',$data); 
	}
    
    
    public function city_wise_booking_summary()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
           $this->session->set_userdata('srch_from_date', $this->input->post('srch_from_date'));
           $this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date')); 
       }
       elseif($this->session->userdata('srch_from_date')){
           $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ; 
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date)  ){
        $where = " a.booking_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'"; 
        
        $data['submit_flg'] = true;
         
       }    
        
        
         
        
        if($data['submit_flg']) {
        
        $this->load->library('pagination'); 
        
        $this->db->where('a.status != ', 'Delete'); 
        $this->db->where($where); 
        $this->db->from('crit_booking_info as a');         
        $this->db->group_by('a.origin_state_code,a.origin_city_code');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('city-wise-booking-report/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 10;
        $config['uri_segment'] = 2;
        //$config['num_links'] = 2; 
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] =  "Prev";
        $config['next_link'] =  "Next";
        $this->pagination->initialize($config);   
        
        $sql = "
                select  
                a.origin_state_code,
                a.origin_city_code, 
                count(a.awbno) as no_of_booking,
                sum(a.no_of_pieces) as no_of_pieces,
                sum(a.chargable_weight) as weight,
                sum(a.grand_total) as total 
                from crit_booking_info as a
                where a.`status` != 'Delete' and
                $where     
                group by a.origin_state_code,a.origin_city_code                         
                order by sum(a.grand_total) desc, a.origin_state_code,a.origin_city_code asc                         
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        }
        
        $this->load->view('page/reports/city_wise_booking_summary',$data); 
	}  
    
    
      
    
    
    public function get_child_items($work_planning_id)
    {
                $sql = " select 
                    a.prt_work_plan_id,
                    a.planning_date as m_date,
                    a.customer_id,
                    a.pattern_id,  
                    d.company_name as customer,
                    e.pattern_item,
                    e.no_of_cavity, 
                    e.piece_weight_per_kg   
                    from work_planning_info as a
                    left join customer_info as d on d.customer_id = a.customer_id
                    left join pattern_info as e on e.pattern_id = a.pattern_id 
                    where a.prt_work_plan_id = $work_planning_id and a.`status` != 'Delete'
                    order by a.work_planning_id asc 
                 ";
                $query = $this->db->query($sql);
        
                $child_record_list  = array();
               
                foreach ($query->result_array() as $row)
                {
                    $child_record_list[] = $row['pattern_item'];  
                } 
    
          return  $child_record_list; 
    }
    
    
    public function customer_wise_pattern_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_customer_id'])) {
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           $data['submit_flg'] = true;
       }  else {
        $data['srch_pattern_id'] = $srch_pattern_id = '';
        $data['srch_customer_id'] = $srch_customer_id = '';
       }
       
          
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
         
        $sql = "select 
                    a.pattern_id, 
                    GROUP_CONCAT( b.company_name) as customer,
                    a.pattern_item,
					a.match_plate_no,
                    a.no_of_cavity,
                    a.bunch_weight as pouring_weight,
                    a.piece_weight_per_kg,
                    a.casting_weight,
                    a.yeild
                    from pattern_info as a
                    left join customer_info as b on FIND_IN_SET( b.customer_id , a.customer_id)  
                    where a.`status` = 'Active' 
               ";
                    if(!empty($srch_customer_id) ){
                       // $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                        $sql.=" and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  "; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.="   
                    group by a.pattern_id 
                    order by b.company_name , a.pattern_item 
                                
                ";
        /*
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        */
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['customer']][] = $row;     
        }
        
         
        } else {
            $data['pattern_opt'] =array();
            
        }
        
        $this->load->view('page/reports/customer_wise_pattern_report',$data); 
	}  
    
    public function grinding_master_rate_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_customer_id'])) {
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           $data['submit_flg'] = true;
       }  else {
        $data['srch_pattern_id'] = $srch_pattern_id = '';
        $data['srch_customer_id'] = $srch_customer_id = '';
       }
       
          
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
         
        $sql = "select 
                    a.pattern_id, 
                    GROUP_CONCAT( b.company_name) as customer,
                    a.pattern_item,
                    a.grinding_rate
                    from pattern_info as a
                    left join customer_info as b on FIND_IN_SET( b.customer_id , a.customer_id)  
                    where a.`status` = 'Active' 
               ";
                    if(!empty($srch_customer_id) ){
                       // $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                        $sql.=" and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  "; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.="   
                    group by a.pattern_id 
                    order by b.company_name , a.pattern_item 
                                
                ";
        /*
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        */
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['customer']][] = $row;     
        }
        
         
        } else {
            $data['pattern_opt'] =array();
            
        }
        
        $this->load->view('page/reports/grinding_master_rate_list',$data); 
	} 
    
    
    public function customer_wise_moulding_master_report()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        $this->load->view('page/reports/customer_wise_moulding_master_report',$data); 
        
        
    }
    
    public function print_moulding_master($customer_id)
    {
        $sql = " select
                    GROUP_CONCAT( c.company_name) as customer, 
                    a.pattern_item, 
                    a.*,
                    b.grade_name as grade
                    from pattern_info as a 
                    left join grade_info as b on b.grade_id = a.grade 
                    left join customer_info as c on FIND_IN_SET( c.customer_id , a.customer_id)  
                    where a.`status` = 'Active' 
                      
                  ";
                    if(!empty($customer_id) ){
                        //$sql.=" and FIND_IN_SET( '". $customer_id ."' , a.customer_id)  "; 
                        $sql.=" and c.customer_id =  '". $customer_id ."'  "; 
                    }
                   /* if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    } */
                    $sql.=" group by a.pattern_id 
                    order by a.match_plate_no asc,  a.pattern_item asc 
                                
                ";
        /*
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        */
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'MOML'
                and a.ason_date <= '". date('Y-m-d') ."'
                order by a.ason_date desc
                limit 1
                ";
                
         $query = $this->db->query($sql); 
         
         $data['iso_label'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['iso_label'] = $row;     
        }      
        
        $this->load->view('page/reports/print-moulding-master',$data);
        
        
    }
    
    public function customer_wise_melting_master_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_customer_id'])) {
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           //$data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           $data['submit_flg'] = true;
       }  else {
           //$data['srch_pattern_id'] = $srch_pattern_id = '';
           $data['srch_customer_id'] = $srch_customer_id = '';
       }
       
          
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        if($data['submit_flg']) { 
            
       /* if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' and customer_id = '". $srch_customer_id ."'
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        } */
        
         
        $sql = " select
                    GROUP_CONCAT( c.company_name) as customer, 
                    a.pattern_item,
                    b.grade_name as  grade,
                    a.piece_weight_per_kg,
                    a.no_of_cavity,
                    a.C,
                    a.SI,
                    a.Mn,
                    a.P,
                    a.S,
                    a.Cr,
                    a.Cu,
                    a.Mg,
                    a.BHN,
                    a.tensile,
                    a.elongation,
                    a.yeild_strength,
                    a.poring_temp,
                    a.inoculant_percentage,
                    a.knock_out_time,
                    a.charge_mix
                    from pattern_info as a 
                    left join grade_info as b on b.grade_id = a.grade 
                    left join customer_info as c on FIND_IN_SET( c.customer_id , a.customer_id)  
                    where a.`status` = 'Active' 
                      
                  ";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  "; 
                    }
                   /* if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    } */
                    $sql.=" group by a.pattern_id 
                    order by c.company_name asc,  a.pattern_item asc 
                                
                ";
        /*
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        */
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['customer']][] = $row;     
        }
        
         
        }  
        
        $this->load->view('page/reports/customer_wise_melting_master_report',$data); 
	} 
    
    public function customer_wise_melting_master_report_v1()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_customer_id'])) {
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           //$data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           $data['submit_flg'] = true;
       }  else {
           //$data['srch_pattern_id'] = $srch_pattern_id = '';
           $data['srch_customer_id'] = $srch_customer_id = '';
       }
       
          
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        if($data['submit_flg']) { 
            
       /* if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' and customer_id = '". $srch_customer_id ."'
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        } */
        
         
        $sql = " select
                    GROUP_CONCAT( c.company_name) as customer, 
                    a.pattern_item,
                    b.grade_name as  grade,
                    a.piece_weight_per_kg,
                    a.no_of_cavity,
                    a.C,
                    a.SI,
                    a.Mn,
                    a.P,
                    a.S,
                    a.Cr,
                    a.Cu,
                    a.Mg,
                    a.BHN,
                    a.tensile,
                    a.elongation,
                    a.yeild_strength,
                    a.poring_temp,
                    a.inoculant_percentage,
                    a.knock_out_time,
                    a.charge_mix
                    from pattern_info as a 
                    left join grade_info as b on b.grade_id = a.grade 
                    left join customer_info as c on FIND_IN_SET( c.customer_id , a.customer_id)  
                    where a.`status` = 'Active' 
                      
                  ";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  "; 
                    }
                   /* if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    } */
                    $sql.=" group by a.pattern_id 
                    order by c.company_name asc,  a.pattern_item asc 
                                
                ";
        /*
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        */
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['customer']][] = $row;     
        }
        
         
        }  
        
        $this->load->view('page/reports/customer_wise_melting_master_report-v1',$data); 
	} 
    
    
    public function print_melting_master($customer_id)
    {
        $sql = " select
                    GROUP_CONCAT( c.company_name) as customer, 
                    a.pattern_item,
                    a.match_plate_no,
                    b.grade_name as  grade,
                    a.piece_weight_per_kg,
                    a.bunch_weight,
                    a.no_of_cavity,
                    a.C,
                    a.SI,
                    a.Mn,
                    a.P,
                    a.S,
                    a.Cr,
                    a.Cu,
                    a.Mg,
                    a.BHN,
                    a.tensile,
                    a.elongation,
                    a.yeild_strength,
                    a.poring_temp,
                    a.inoculant_percentage,
                    a.knock_out_time, 
                    a.boring,
                    a.ms,
                    a.foundry_return,
                    a.CI_scrap,
                    a.pig_iron,
                    a.ni,
                    a.mo,
                    a.special_instructions
                    from pattern_info as a 
                    left join grade_info as b on b.grade_id = a.grade 
                    left join customer_info as c on FIND_IN_SET( c.customer_id , a.customer_id)  
                    where a.`status` = 'Active' 
                      
                  ";
                    if(!empty($customer_id) ){
                        //$sql.=" and FIND_IN_SET( '". $customer_id ."' , a.customer_id)  "; 
                        $sql.=" and c.customer_id =  '". $customer_id ."'  "; 
                    }
                   /* if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    } */
                    $sql.=" group by a.pattern_id 
                    order by a.match_plate_no asc,  a.pattern_item asc 
                                
                ";
        /*
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        */
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'MML'
                and a.ason_date <= '". date('Y-m-d') ."'
                order by a.ason_date desc
                limit 1
                ";
                
         $query = $this->db->query($sql); 
         
         $data['iso_label'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['iso_label'] = $row;     
        }      
        
        $this->load->view('page/reports/print-melting-master',$data); 
        
    }
    public function work_order_planning_statement()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_date'])) { 
           $data['srch_date'] = $srch_date = $this->input->post('srch_date');  
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
           $data['submit_flg'] = true;
       } 
       else {
         
        $data['srch_date'] = $srch_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
       } 
        
      if(isset($_POST['srch_customer_id'])) {
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
       //    $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           //$data['submit_flg'] = true;
       }  else {
        //$data['srch_pattern_id'] = $srch_pattern_id = '';
        $data['srch_customer_id'] = $srch_customer_id = '';
       }
       
       if(isset($_POST['srch_pattern_id'])) {
            $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           //$data['submit_flg'] = true;
       }  else {
            $data['srch_pattern_id'] = $srch_pattern_id = '';
        
       }
       
          
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
        /*
         
        $sql = " 
                SELECT
                    a.customer_id,
                    a.pattern_id,
                    a.pattern_item,
                    p6.company_name AS customer,
                    a.piece_weight_per_kg,
                    IFNULL(ORD.cf_ord_qty,0) as cf_ord_qty,
                    IFNULL(ORD.curr_order_qty,0) as curr_order_qty,
                    (
                        (
                            IFNULL(c.stock_qty, 0) + IFNULL(SUM(p4.produced_qty),
                            0)
                        ) -(
                            IFNULL(SUM(w.rejection_qty),
                            0) + IFNULL(SUM(k.despatch_qty),
                            0)
                        )
                    ) AS opening_stock,
                    (IFNULL(wp.planned_box, 0) * a.no_of_cavity ) AS curr_planned_qty,
                    IFNULL(qa.curr_produced_qty, 0) AS curr_produced_qty,
                    IFNULL(qb.curr_rejection_qty, 0) AS curr_rejection_qty,
                    IFNULL(qc.curr_despatch_qty, 0) AS curr_despatch_qty,
                    (
                        (
                            (
                                (
                                    IFNULL(c.stock_qty, 0) + IFNULL(SUM(p4.produced_qty),
                                    0)
                                ) -(
                                    IFNULL(SUM(w.rejection_qty),
                                    0) + IFNULL(SUM(k.despatch_qty),
                                    0)
                                )
                            ) +(
                                IFNULL(qa.curr_produced_qty, 0)
                            )
                        ) -(
                            (
                                IFNULL(qb.curr_rejection_qty, 0)
                            ) +(
                                IFNULL(qc.curr_despatch_qty, 0)
                            )
                        )
                    ) AS closing_stock
                FROM
                    pattern_info AS a
                LEFT JOIN(
                    SELECT
                        z.customer_id,
                        z.pattern_id,
                        MAX(z.floor_stock_date) AS floor_stock_date
                    FROM
                        floor_stock_info AS z
                    WHERE
                        z.floor_stock_date <= '" .$srch_date. "'
                    GROUP BY
                        z.customer_id,
                        z.pattern_id
                    ORDER BY
                        z.customer_id,
                        z.pattern_id
                ) AS b
                ON
                    b.customer_id = a.customer_id AND b.pattern_id = a.pattern_id
                LEFT JOIN floor_stock_info AS c
                ON
                    c.customer_id = a.customer_id AND c.pattern_id = a.pattern_id AND c.floor_stock_date = IFNULL(
                        (
                        SELECT
                            MAX(z.floor_stock_date)
                        FROM
                            floor_stock_info AS z
                        WHERE
                            z.pattern_id = a.pattern_id AND z.floor_stock_date <= '" .$srch_date. "'
                    ),
                    '2020-12-01'
                    )
                LEFT JOIN(
                    SELECT
                        r.customer_id,
                        r.pattern_id,
                        SUM(r.produced_qty) AS produced_qty
                    FROM
                        (
                            (
                            SELECT
                                a3.customer_id,
                                a3.pattern_id,
                                SUM(
                                    (a2.produced_qty) - IFNULL(a4.closed_mould_qty, 0)
                                ) AS produced_qty
                            FROM
                                melting_heat_log_info AS a1
                            LEFT JOIN melting_item_info AS a2
                            ON
                                a1.melting_heat_log_id = a2.melting_heat_log_id
                            LEFT JOIN work_planning_info AS a3
                            ON
                                a3.work_planning_id = a2.work_planning_id
                            LEFT JOIN(
                                SELECT
                                    q.work_planning_id,
                                    SUM(q.closed_mould_qty) AS closed_mould_qty
                                FROM
                                    moulding_log_item_info AS q
                                WHERE
                                    q.`status` = 'Active'
                                GROUP BY
                                    q.work_planning_id
                            ) AS a4
                        ON
                            a4.work_planning_id = a2.work_planning_id
                        WHERE
                            a1.`status` = 'Active' AND a1.planning_date BETWEEN IFNULL(
                                (
                                SELECT
                                    MAX(z.floor_stock_date)
                                FROM
                                    floor_stock_info AS z
                                WHERE
                                    z.pattern_id = a3.pattern_id AND z.floor_stock_date <= '" .$srch_date. "'
                            ),
                            '2020-12-01'
                            ) AND DATE_SUB('" .$srch_date. "', INTERVAL 1 DAY)
                        GROUP BY
                            a3.customer_id,
                            a3.pattern_id
                        ORDER BY
                            a3.customer_id,
                            a3.pattern_id
                        )
                    UNION ALL
                        (
                        SELECT
                            a3.customer_id,
                            a3.pattern_id,
                            SUM(
                                (a2.produced_qty) - IFNULL(a4.closed_mould_qty, 0)
                            ) AS produced_qty
                        FROM
                            melting_heat_log_info AS a1
                        LEFT JOIN melting_child_item_info AS a2
                        ON
                            a1.melting_heat_log_id = a2.melting_heat_log_id
                        LEFT JOIN work_planning_info AS a3
                        ON
                            a3.prt_work_plan_id = a2.work_planning_id
                        LEFT JOIN(
                            SELECT
                                q.work_planning_id,
                                SUM(q.closed_mould_qty) AS closed_mould_qty
                            FROM
                                moulding_log_item_info AS q
                            WHERE
                                q.`status` = 'Active'
                            GROUP BY
                                q.work_planning_id
                        ) AS a4
                    ON
                        a4.work_planning_id = a2.work_planning_id
                    WHERE
                        a1.`status` = 'Active' AND a3.customer_id != '' AND a1.planning_date BETWEEN IFNULL(
                            (
                            SELECT
                                MAX(z.floor_stock_date)
                            FROM
                                floor_stock_info AS z
                            WHERE
                                z.pattern_id = a3.pattern_id AND z.floor_stock_date <= '" .$srch_date. "'
                        ),
                        '2020-12-01'
                        ) AND DATE_SUB('" .$srch_date. "', INTERVAL 1 DAY)
                    GROUP BY
                        a3.customer_id,
                        a3.pattern_id
                    ORDER BY
                        a3.customer_id,
                        a3.pattern_id
                    )
                        ) AS r
                    WHERE
                        1
                    GROUP BY
                        r.customer_id,
                        r.pattern_id
                ) AS p4
                ON
                    p4.customer_id = a.customer_id AND p4.pattern_id = a.pattern_id
                LEFT JOIN(
                    SELECT
                        b.planning_date AS m_date,
                        b.customer_id,
                        b.pattern_id,
                        SUM(a.rejection_qty) AS rejection_qty
                    FROM
                        qc_inspection_info AS a
                    LEFT JOIN work_planning_info AS b
                    ON
                        b.work_planning_id = a.work_planning_id
                    WHERE
                        a.status = 'Active' AND b.status != 'Delete' AND a.qc_date BETWEEN IFNULL(
                            (
                            SELECT
                                MAX(z.floor_stock_date)
                            FROM
                                floor_stock_info AS z
                            WHERE
                                z.pattern_id = b.pattern_id AND z.floor_stock_date <= '" .$srch_date. "'
                        ),
                        '2020-12-01'
                        ) AND DATE_SUB('" .$srch_date. "', INTERVAL 1 DAY)
                    GROUP BY
                        b.customer_id,
                        b.pattern_id
                ) AS w
                ON
                    w.customer_id = a.customer_id AND w.pattern_id = a.pattern_id
                LEFT JOIN(
                    SELECT
                        t.despatch_date,
                        t.customer_id,
                        r.pattern_id,
                        SUM(r.qty) AS despatch_qty
                    FROM
                        customer_despatch_info AS t
                    LEFT JOIN customer_despatch_item_info AS r
                    ON
                        r.customer_despatch_id = t.customer_despatch_id
                    WHERE
                        t.status = 'Active' AND t.despatch_date BETWEEN IFNULL(
                            (
                            SELECT
                                MAX(z.floor_stock_date)
                            FROM
                                floor_stock_info AS z
                            WHERE
                                z.pattern_id = r.pattern_id AND z.floor_stock_date <= '" .$srch_date. "'
                        ),
                        '2020-12-01'
                        ) AND DATE_SUB('" .$srch_date. "', INTERVAL 1 DAY)
                    GROUP BY
                        t.customer_id,
                        r.pattern_id
                ) AS k
                ON
                    k.customer_id = a.customer_id AND k.pattern_id = a.pattern_id
                LEFT JOIN(
                    SELECT
                        w.customer_id,
                        w.pattern_id,
                        SUM(w.curr_produced_qty) AS curr_produced_qty
                    FROM
                        (
                            (
                            SELECT
                                a3.customer_id,
                                a3.pattern_id,
                                SUM(
                                    (a2.produced_qty) - IFNULL(a4.closed_mould_qty, 0)
                                ) AS curr_produced_qty
                            FROM
                                melting_heat_log_info AS a1
                            LEFT JOIN melting_item_info AS a2
                            ON
                                a1.melting_heat_log_id = a2.melting_heat_log_id
                            LEFT JOIN work_planning_info AS a3
                            ON
                                a3.work_planning_id = a2.work_planning_id
                            LEFT JOIN(
                                SELECT
                                    q.work_planning_id,
                                    SUM(q.closed_mould_qty) AS closed_mould_qty
                                FROM
                                    moulding_log_item_info AS q
                                WHERE
                                    q.`status` = 'Active'
                                GROUP BY
                                    q.work_planning_id
                            ) AS a4
                        ON
                            a4.work_planning_id = a2.work_planning_id
                        WHERE
                            a1.`status` = 'Active' AND a1.planning_date BETWEEN '" .$srch_date. "' AND '" .$srch_to_date. "'
                        GROUP BY
                            a3.customer_id,
                            a3.pattern_id
                        ORDER BY
                            a3.customer_id,
                            a3.pattern_id
                        )
                    UNION ALL
                        (
                        SELECT
                            a3.customer_id,
                            a3.pattern_id,
                            SUM(
                                (a2.produced_qty) - IFNULL(a4.closed_mould_qty, 0)
                            ) AS curr_produced_qty
                        FROM
                            melting_heat_log_info AS a1
                        LEFT JOIN melting_child_item_info AS a2
                        ON
                            a1.melting_heat_log_id = a2.melting_heat_log_id
                        LEFT JOIN work_planning_info AS a3
                        ON
                            a3.prt_work_plan_id = a2.work_planning_id
                        LEFT JOIN(
                            SELECT
                                q.work_planning_id,
                                SUM(q.closed_mould_qty) AS closed_mould_qty
                            FROM
                                moulding_log_item_info AS q
                            WHERE
                                q.`status` = 'Active'
                            GROUP BY
                                q.work_planning_id
                        ) AS a4
                    ON
                        a4.work_planning_id = a2.work_planning_id
                    WHERE
                        a1.`status` = 'Active' AND a3.customer_id != '' AND a1.planning_date BETWEEN '" .$srch_date. "' AND '" .$srch_to_date. "'
                    GROUP BY
                        a3.customer_id,
                        a3.pattern_id
                    ORDER BY
                        a3.customer_id,
                        a3.pattern_id
                    )
                        ) AS w
                    WHERE
                        1
                    GROUP BY
                        w.customer_id,
                        w.pattern_id
                ) AS qa
                ON
                    qa.customer_id = a.customer_id AND qa.pattern_id = a.pattern_id
                LEFT JOIN(
                    SELECT
                        b.customer_id,
                        b.pattern_id,
                        SUM(a.rejection_qty) AS curr_rejection_qty
                    FROM
                        qc_inspection_info AS a
                    LEFT JOIN work_planning_info AS b
                    ON
                        b.work_planning_id = a.work_planning_id
                    WHERE
                        a.status = 'Active' AND b.status != 'Delete' AND a.qc_date BETWEEN '" .$srch_date. "' AND '" .$srch_to_date. "'
                    GROUP BY
                        b.customer_id,
                        b.pattern_id
                ) AS qb
                ON
                    qb.customer_id = a.customer_id AND qb.pattern_id = a.pattern_id
                LEFT JOIN(
                    SELECT
                        t.customer_id,
                        r.pattern_id,
                        SUM(r.qty) AS curr_despatch_qty
                    FROM
                        customer_despatch_info AS t
                    LEFT JOIN customer_despatch_item_info AS r
                    ON
                        r.customer_despatch_id = t.customer_despatch_id
                    WHERE
                        t.status = 'Active' AND t.despatch_date BETWEEN '" .$srch_date. "' AND '" .$srch_to_date. "'
                    GROUP BY
                        t.customer_id,
                        r.pattern_id
                ) AS qc
                ON
                    qc.customer_id = a.customer_id AND qc.pattern_id = a.pattern_id
                LEFT JOIN (
                select 
                a1.customer_id, 
                a1.pattern_id,
                sum(a1.planned_box) as planned_box
                from work_planning_info as a1  
                where a1.`status` != 'Delete' and a1.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "'
                group by a1.customer_id, a1.pattern_id 
                )  as wp on wp.customer_id AND wp.pattern_id = a.pattern_id  
                LEFT JOIN customer_info AS p6
                ON
                    p6.customer_id = a.customer_id
                LEFT JOIN(
                    SELECT p.pattern_id,
                        SUM(p.cf_ord_qty) AS cf_ord_qty,
                        SUM(p.curr_order_qty) AS curr_order_qty
                    FROM
                        (
                            (
                            SELECT
                                b.pattern_id,
                                0 AS cf_ord_qty,
                                SUM(b.qty) AS curr_order_qty
                            FROM
                                work_order_info AS a
                            LEFT JOIN work_order_items_info AS b
                            ON
                                b.work_order_id = a.work_order_id
                            WHERE
                                a.`status` != 'Delete' AND a.order_date BETWEEN '" .$srch_date. "' AND '" .$srch_to_date. "'
                            GROUP BY
                                b.pattern_id
                            ORDER BY
                                b.pattern_id ASC
                        )
                    UNION ALL
                        (
                        SELECT
                            b.pattern_id,
                            (
                                SUM(b.qty) -(IFNULL(c.despatch_qty, 0))
                            ) AS cf_ord_qty,
                            0 AS curr_order_qty
                        FROM
                            work_order_info AS a
                        LEFT JOIN work_order_items_info AS b
                        ON
                            b.work_order_id = a.work_order_id
                        LEFT JOIN(
                            SELECT
                                w.work_order_id,
                                w.pattern_id,
                                SUM(w.qty) AS despatch_qty
                            FROM
                                customer_despatch_info AS q
                            LEFT JOIN customer_despatch_item_info AS w
                            ON
                                w.customer_despatch_id = q.customer_despatch_id
                            WHERE
                                q.despatch_date < '" .$srch_date. "' AND q.status = 'Active' AND w.status = 'Active'
                            GROUP BY
                                w.work_order_id,
                                w.pattern_id
                        ) AS c
                    ON
                        c.work_order_id = a.work_order_id AND c.pattern_id = b.pattern_id
                    WHERE
                        a.`status` != 'Delete' AND a.`status` != 'Close' AND a.order_date < '" .$srch_date. "'
                    GROUP BY
                        b.pattern_id
                    ORDER BY
                        b.pattern_id ASC
                    )
                        ) AS p
                    WHERE
                        1
                    GROUP BY
                        p.pattern_id
                    ORDER BY
                        p.pattern_id ASC
                ) AS ORD
                ON
                    ORD.pattern_id = a.pattern_id
                WHERE
                    a.`status` = 'Active'
                
               ";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.="   
                    GROUP BY
                        a.pattern_id,
                        a.customer_id
                    ORDER BY
                        customer,
                        pattern_item
                                
                "; */
                
        $sql = " 
                SELECT
                    a.customer_id,
                    a.pattern_id,
                    a.pattern_item,
					a.item_type,
                    p6.company_name AS customer,
                    a.piece_weight_per_kg,
                    a.no_of_cavity, 
                    a.bunch_weight,
                    IFNULL(ORD.cf_ord_qty,0) as cf_ord_qty,
                    IFNULL(ORD.curr_order_qty,0) as curr_order_qty,
                    (
                        (
                            IFNULL(c.stock_qty, 0) + IFNULL(SUM(p4.produced_qty),0) - ifnull(p5.closed_mould_qty,0)
                        ) - (
                            IFNULL(SUM(w.rejection_qty),
                            0) + IFNULL(SUM(k.despatch_qty),
                            0)
                        )
                    ) AS opening_stock,
                    (IFNULL(wp.planned_box, 0) * a.no_of_cavity ) AS curr_planned_qty,
                    (IFNULL(qa.curr_produced_qty, 0) - ifnull(cm.closed_mould_qty,0)) AS curr_produced_qty,
                    IFNULL(qb.curr_rejection_qty, 0) AS curr_rejection_qty,
                    IFNULL(qc.curr_despatch_qty, 0) AS curr_despatch_qty,
                    (
                        (
                            (
                                (
                                    IFNULL(c.stock_qty, 0) + IFNULL(SUM(p4.produced_qty),0) - ifnull(p5.closed_mould_qty,0)
                                ) - (
                                    IFNULL(SUM(w.rejection_qty),
                                    0) + IFNULL(SUM(k.despatch_qty),
                                    0)
                                )
                            ) +(
                                (IFNULL(qa.curr_produced_qty, 0) - ifnull(cm.closed_mould_qty,0))
                            )
                        ) -(
                            (
                                IFNULL(qb.curr_rejection_qty, 0)
                            ) +(
                                IFNULL(qc.curr_despatch_qty, 0)
                            )
                        )
                    ) AS closing_stock
                FROM
                    pattern_info AS a
                LEFT JOIN(
                    SELECT
                        z.customer_id,
                        z.pattern_id,
                        MAX(z.floor_stock_date) AS floor_stock_date
                    FROM
                        floor_stock_info AS z
                    WHERE
                        z.floor_stock_date <= '" .$srch_date. "'
                    GROUP BY
                        z.customer_id,
                        z.pattern_id
                    ORDER BY
                        z.customer_id,
                        z.pattern_id
                ) AS b
                ON
                    b.customer_id = a.customer_id AND b.pattern_id = a.pattern_id
                LEFT JOIN floor_stock_info AS c
                ON
                    c.customer_id = a.customer_id AND c.pattern_id = a.pattern_id AND c.floor_stock_date = IFNULL(
                        (
                        SELECT
                            MAX(z.floor_stock_date)
                        FROM
                            floor_stock_info AS z
                        WHERE
                            z.pattern_id = a.pattern_id AND z.floor_stock_date <= '" .$srch_date. "'
                    ),
                    '2020-12-01'
                    )
                LEFT JOIN(
                    SELECT
                        r.customer_id,
                        r.pattern_id,
                        SUM(r.produced_qty) AS produced_qty
                    FROM
                        (
                            (
                            SELECT
                                a3.customer_id,
                                a3.pattern_id,
                                SUM(
                                    (a2.produced_qty)  
                                ) AS produced_qty
                            FROM
                                melting_heat_log_info AS a1
                            LEFT JOIN melting_item_info AS a2
                            ON
                                a1.melting_heat_log_id = a2.melting_heat_log_id
                            LEFT JOIN work_planning_info AS a3
                            ON
                                a3.work_planning_id = a2.work_planning_id
                             
                        WHERE
                            a1.`status` = 'Active' and a3.`status` != 'Delete' AND a1.planning_date BETWEEN IFNULL(
                                (
                                SELECT
                                    MAX(z.floor_stock_date)
                                FROM
                                    floor_stock_info AS z
                                WHERE
                                    z.pattern_id = a3.pattern_id AND z.floor_stock_date <= '" .$srch_date. "'
                            ),
                            '2020-12-01'
                            ) AND DATE_SUB('" .$srch_date. "', INTERVAL 1 DAY)
                        GROUP BY
                            a3.customer_id,
                            a3.pattern_id
                        ORDER BY
                            a3.customer_id,
                            a3.pattern_id
                        )
                    UNION ALL
                        (
                        SELECT
                            a3.customer_id,
                            a3.pattern_id,
                            SUM(
                                (a2.produced_qty)  
                            ) AS produced_qty
                        FROM
                            melting_heat_log_info AS a1
                        LEFT JOIN melting_child_item_info AS a2
                        ON
                            a1.melting_heat_log_id = a2.melting_heat_log_id
                        LEFT JOIN work_planning_info AS a3
                        ON
                            a3.work_planning_id = a2.work_planning_id
                         
                    WHERE
                        a1.`status` = 'Active' and a3.`status` != 'Delete' AND a3.customer_id != '' AND a1.planning_date BETWEEN IFNULL(
                            (
                            SELECT
                                MAX(z.floor_stock_date)
                            FROM
                                floor_stock_info AS z
                            WHERE
                                z.pattern_id = a3.pattern_id AND z.floor_stock_date <= '" .$srch_date. "'
                        ),
                        '2020-12-01'
                        ) AND DATE_SUB('" .$srch_date. "', INTERVAL 1 DAY)
                    GROUP BY
                        a3.customer_id,
                        a3.pattern_id
                    ORDER BY
                        a3.customer_id,
                        a3.pattern_id
                    )
                        ) AS r
                    WHERE
                        1
                    GROUP BY
                        r.customer_id,
                        r.pattern_id
                ) AS p4
                ON
                    p4.customer_id = a.customer_id AND p4.pattern_id = a.pattern_id
                    
                left join (
                 select  
                 q1.pattern_id,
                 q1.customer_id,
                 sum(q.closed_mould_qty) as closed_mould_qty 
                 from moulding_log_item_info as q
                 left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
                 where q.`status` = 'Active' and q1.`status` != 'Delete' and q1.planning_date  between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = q1.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                 group by q1.pattern_id ,q1.customer_id
                ) as p5 on p5.pattern_id = a.pattern_id and p5.customer_id = a.customer_id     
                LEFT JOIN(
                    SELECT
                        b.planning_date AS m_date,
                        b.customer_id,
                        b.pattern_id,
                        SUM(a.rejection_qty) AS rejection_qty
                    FROM
                        qc_inspection_info AS a
                    LEFT JOIN work_planning_info AS b
                    ON
                        b.work_planning_id = a.work_planning_id
                    WHERE
                        a.status = 'Active' AND b.status != 'Delete' and a.rejection_type_id != '32' AND b.planning_date BETWEEN IFNULL(
                            (
                            SELECT
                                MAX(z.floor_stock_date)
                            FROM
                                floor_stock_info AS z
                            WHERE
                                z.pattern_id = b.pattern_id AND z.floor_stock_date <= '" .$srch_date. "'
                        ),
                        '2020-12-01'
                        ) AND DATE_SUB('" .$srch_date. "', INTERVAL 1 DAY)
                    GROUP BY
                        b.customer_id,
                        b.pattern_id
                ) AS w
                ON
                    w.customer_id = a.customer_id AND w.pattern_id = a.pattern_id
                LEFT JOIN(
                    SELECT
                        t.despatch_date,
                        t.customer_id,
                        r.pattern_id,
                        SUM(r.qty) AS despatch_qty
                    FROM
                        customer_despatch_info AS t
                    LEFT JOIN customer_despatch_item_info AS r
                    ON
                        r.customer_despatch_id = t.customer_despatch_id
                    WHERE
                        t.status = 'Active' AND t.despatch_date BETWEEN IFNULL(
                            (
                            SELECT
                                MAX(z.floor_stock_date)
                            FROM
                                floor_stock_info AS z
                            WHERE
                                z.pattern_id = r.pattern_id AND z.floor_stock_date <= '" .$srch_date. "'
                        ),
                        '2020-12-01'
                        ) AND DATE_SUB('" .$srch_date. "', INTERVAL 1 DAY)
                    GROUP BY
                        t.customer_id,
                        r.pattern_id
                ) AS k
                ON
                    k.customer_id = a.customer_id AND k.pattern_id = a.pattern_id
                LEFT JOIN(
                    SELECT
                        w.customer_id,
                        w.pattern_id,
                        SUM(w.curr_produced_qty) AS curr_produced_qty
                    FROM
                        (
                            (
                            SELECT
                                a3.customer_id,
                                a3.pattern_id,
                                SUM(
                                    (a2.produced_qty)  
                                ) AS curr_produced_qty
                            FROM
                                melting_heat_log_info AS a1
                            LEFT JOIN melting_item_info AS a2
                            ON
                                a1.melting_heat_log_id = a2.melting_heat_log_id
                            LEFT JOIN work_planning_info AS a3
                            ON
                                a3.work_planning_id = a2.work_planning_id
                             
                        WHERE
                            a1.`status` = 'Active' and a3.status != 'Delete' AND a1.planning_date BETWEEN '" .$srch_date. "' AND '" .$srch_to_date. "'
                        GROUP BY
                            a3.customer_id,
                            a3.pattern_id
                        ORDER BY
                            a3.customer_id,
                            a3.pattern_id
                        )
                    UNION ALL
                        (
                        SELECT
                            a3.customer_id,
                            a3.pattern_id,
                            SUM(
                                (a2.produced_qty)  
                            ) AS curr_produced_qty
                        FROM
                            melting_heat_log_info AS a1
                        LEFT JOIN melting_child_item_info AS a2
                        ON
                            a1.melting_heat_log_id = a2.melting_heat_log_id
                        LEFT JOIN work_planning_info AS a3
                        ON
                            a3.work_planning_id = a2.work_planning_id
                         
                    WHERE
                        a1.`status` = 'Active' and a3.status != 'Delete' AND a3.customer_id != '' AND a1.planning_date BETWEEN '" .$srch_date. "' AND '" .$srch_to_date. "'
                    GROUP BY
                        a3.customer_id,
                        a3.pattern_id
                    ORDER BY
                        a3.customer_id,
                        a3.pattern_id
                    )
                        ) AS w
                    WHERE
                        1
                    GROUP BY
                        w.customer_id,
                        w.pattern_id
                ) AS qa
                ON
                    qa.customer_id = a.customer_id AND qa.pattern_id = a.pattern_id
                LEFT JOIN(
                    SELECT
                        b.customer_id,
                        b.pattern_id,
                        SUM(a.rejection_qty) AS curr_rejection_qty
                    FROM
                        qc_inspection_info AS a
                    LEFT JOIN work_planning_info AS b
                    ON
                        b.work_planning_id = a.work_planning_id
                    WHERE
                        a.status = 'Active' AND b.status != 'Delete' and a.rejection_type_id != '32' AND b.planning_date BETWEEN '" .$srch_date. "' AND '" .$srch_to_date. "'
                    GROUP BY
                        b.customer_id,
                        b.pattern_id
                ) AS qb
                ON
                    qb.customer_id = a.customer_id AND qb.pattern_id = a.pattern_id
                LEFT JOIN(
                    SELECT
                        t.customer_id,
                        r.pattern_id,
                        SUM(r.qty) AS curr_despatch_qty
                    FROM
                        customer_despatch_info AS t
                    LEFT JOIN customer_despatch_item_info AS r
                    ON
                        r.customer_despatch_id = t.customer_despatch_id
                    WHERE
                        t.status = 'Active' AND t.despatch_date BETWEEN '" .$srch_date. "' AND '" .$srch_to_date. "'
                    GROUP BY
                        t.customer_id,
                        r.pattern_id
                ) AS qc
                ON
                    qc.customer_id = a.customer_id AND qc.pattern_id = a.pattern_id
                left join (
                 select  
                 q1.pattern_id,
                 q1.customer_id,
                 sum(q.closed_mould_qty) as closed_mould_qty 
                 from moulding_log_item_info as q
                 left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
                 where q.`status` = 'Active' and q1.status != 'Delete' and q1.planning_date between '" .$srch_date. "' AND '" .$srch_to_date. "'
                 group by q1.pattern_id ,q1.customer_id
                ) as cm on cm.pattern_id = a.pattern_id and cm.customer_id = a.customer_id 
                    
                LEFT JOIN (
                select 
                a1.customer_id, 
                a1.pattern_id,
                sum(a1.planned_box) as planned_box
                from work_planning_info as a1  
                where a1.`status` != 'Delete' and a1.planning_date between '" .$srch_date. "' and '" .$srch_to_date. "'
                group by a1.customer_id, a1.pattern_id 
                )  as wp on wp.customer_id AND wp.pattern_id = a.pattern_id  
                LEFT JOIN customer_info AS p6
                ON
                    FIND_IN_SET( p6.customer_id , a.customer_id)  
                LEFT JOIN(
                    SELECT p.pattern_id,
                        SUM(p.cf_ord_qty) AS cf_ord_qty,
                        SUM(p.curr_order_qty) AS curr_order_qty
                    FROM
                        (
                            (
                            SELECT
                                b.pattern_id,
                                0 AS cf_ord_qty,
                                SUM(b.qty) AS curr_order_qty
                            FROM
                                work_order_info AS a
                            LEFT JOIN work_order_items_info AS b
                            ON
                                b.work_order_id = a.work_order_id
                            WHERE
                                a.`status` != 'Delete' and  b.`status` != 'Delete' AND a.order_date BETWEEN '" .$srch_date. "' AND '" .$srch_to_date. "'
                            GROUP BY
                                b.pattern_id
                            ORDER BY
                                b.pattern_id ASC
                        )
                    UNION ALL
                        (
                        SELECT
                            b.pattern_id,
                            (
                                SUM(b.qty) - sum(IFNULL(c.despatch_qty, 0))
                            ) AS cf_ord_qty,
                            0 AS curr_order_qty
                        FROM
                            work_order_info AS a
                        LEFT JOIN work_order_items_info AS b
                        ON
                            b.work_order_id = a.work_order_id
                        LEFT JOIN(
                            SELECT
                                w.work_order_id,
                                w.pattern_id,
                                SUM(w.qty) AS despatch_qty
                            FROM
                                customer_despatch_info AS q
                            LEFT JOIN customer_despatch_item_info AS w
                            ON
                                w.customer_despatch_id = q.customer_despatch_id
                            WHERE
                                q.despatch_date < '" .$srch_date. "' AND q.status = 'Active' AND w.status = 'Active'
                            GROUP BY
                                w.work_order_id,
                                w.pattern_id
                        ) AS c
                    ON
                        c.work_order_id = a.work_order_id AND c.pattern_id = b.pattern_id
                    WHERE
                        a.`status` != 'Delete' AND a.`status` != 'Close' AND a.order_date < '" .$srch_date. "'
                    GROUP BY
                        b.pattern_id
                    ORDER BY
                        b.pattern_id ASC
                    )
                        ) AS p
                    WHERE
                        1
                    GROUP BY
                        p.pattern_id
                    ORDER BY
                        p.pattern_id ASC
                ) AS ORD
                ON
                    ORD.pattern_id = a.pattern_id
                WHERE
                    a.`status` = 'Active'
                
               ";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
                    }
                    $sql.="   
                    GROUP BY
                        a.pattern_id,
                        a.customer_id
                    ORDER BY
                        customer,
                        pattern_item
                                
                ";        
                
        
        /*echo "<pre>"; 
        echo $sql;
        echo "</pre>";*/
        
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            if($row['cf_ord_qty'] > 0 || $row['curr_order_qty'] > 0 || $row['opening_stock'] > 0  || $row['closing_stock'] > 0 )
                $data['record_list'][$row['customer']][] = $row;     
        }
        
         
        } else {
            $data['pattern_opt'] =array();
            
        }
        
        $this->load->view('page/reports/work_order_planning_statement',$data); 
	}  
	
	public function customer_wise_rejection_report_v2()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           $data['srch_rej_grp'] = $srch_rej_grp = $this->input->post('srch_rej_grp'); 
           $data['srch_rej_type_id'] = $srch_rej_type_id = $this->input->post('srch_rej_type_id'); 
           $data['srch_more_than'] = $srch_more_than = $this->input->post('srch_more_than'); 
           $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift'); 
		   
            
       } else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
        $data['srch_pattern_id'] = $srch_pattern_id = '';
        $data['srch_customer_id'] = $srch_customer_id = '';
        $data['srch_rej_grp'] = $srch_rej_grp = '';
        $data['srch_rej_type_id'] = $srch_rej_type_id = '';
        $data['srch_more_than'] = $srch_more_than = 0;
		$data['srch_shift'] = $srch_shift = '';
       }
       
	   $data['shift_opt'] = array('' => 'All Shift',  'Shift-A' => 'Shift-A' , 'Shift-B' => 'Shift-B', 'Shift-C' => 'Shift-C'); 
	   
	   
       if(!empty($srch_from_date) && !empty($srch_to_date)   ){
         
        $data['submit_flg'] = true;
         
       }   
       
       
        
        $sql = "
                select 
                a.rejection_group_name
                from rejection_group_info as a 
                where a.level = 1
                order by a.rejection_group_name asc               
        "; 
        
        $query = $this->db->query($sql);
        
        //$data['no_of_rej_type'] = $query->num_rows();
       
        foreach ($query->result_array() as $row)
        {
            $data['rejection_grp_opt'][$row['rejection_group_name']] =  $row['rejection_group_name'];     
        } 
        
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
        
        if(!empty($srch_rej_grp) ){    
            
        $sql = "
                select 
                a.rejection_type_id, 
                a.rejection_type_name 
                from rejection_type_info as a 
                where a.`status` = 'Active' and a.rejection_group = '". $srch_rej_grp ."'
				and a.rejection_type_id != '32'
                order by a.rejection_type_name asc   
                              
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['rejection_typ_opt'][$row['rejection_type_id']] =  $row['rejection_type_name']   ;     
        }
        } else {
            $data['rejection_typ_opt'] =array();
        }
        
        
         
        
        
        $sql ="
            select 
            a.work_planning_id,
            a.customer_id,
            a.pattern_id,
            a.planning_date as m_date, 
            a.shift,
            c.company_name as customer,
            d.pattern_item,
            d.piece_weight_per_kg as wt  ,
            z.produced_qty as produced_qty,
            round((z.produced_qty * d.piece_weight_per_kg),3) as prod_wt,
            b.rejection_group,
            b.rejection_type_id,
            c1.rejection_type_name,
            sum(b.rejection_qty) as rej_qty , 
            round((sum(b.rejection_qty)* d.piece_weight_per_kg ),3) as rej_wt,
            round((sum(b.rejection_qty) * 100 / z.produced_qty ),2) as rej_qty_pert,
            round(((sum(b.rejection_qty)* d.piece_weight_per_kg ) * 100 / (z.produced_qty * d.piece_weight_per_kg) ),2) as rej_wt_pert
            from work_planning_info as a
            left join pattern_info as d on d.pattern_id = a.pattern_id
            left join customer_info as c on c.customer_id = a.customer_id
            left join (select w.work_planning_id ,sum(w.produced_qty) as produced_qty  from melting_item_info as w where w.status ='Active' group by w.work_planning_id )  as z on z.work_planning_id = a.work_planning_id 
            left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
            left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
            where a.`status` != 'Delete' and c.`status` != 'Delete'
             and b.rejection_type_id != '32' and b.rejection_qty > 0
            and a.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."' 
            ";
            if(!empty($srch_customer_id) ){
                $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
            }
            if(!empty($srch_rej_grp) ){
                  $sql.=" and b.rejection_group = '". $srch_rej_grp ."'";
            }
            if(!empty($srch_rej_type_id) ){
                  $sql.=" and b.rejection_type_id = '". $srch_rej_type_id ."'";
            }
			if(!empty($srch_shift) ){
				  $sql.=" and a.shift = '". $srch_shift ."'";
			}
            
             
        $sql.="
            group by a.planning_date, a.shift, a.customer_id, a.pattern_id ,b.rejection_group , b.rejection_type_id 
            order by a.planning_date asc, a.shift , c.company_name, d.pattern_item , b.rejection_group ,c1.rejection_type_name  asc 
        ";
        
         
       
        
        $query = $this->db->query($sql);
         
        $data['no_of_records'] = $query->num_rows();
        
        
        $data['record_list'] = array();
        $data['tot_rej_qty'] = 0;
       
       /* foreach ($query->result_array() as $row)
        {
            $data['tot_rej_qty'] += $row['produced_qty'];
             
            if(empty($srch_more_than) ){
               // $data['record_list1'][$row['planning_date']][$row['customer']] [$row['item']] [$row['rejection_group']][$row['rejection_type']]  = $row;
               $data['record_list'][$row['m_date'] . " - " . $row['shift']][$row['customer']][$row['pattern_item']][$row['rejection_group']] [] = $row;
                
            } else 
            {   
                if($row['rej_wt_pert'] >= $srch_more_than)
                    //$data['record_list1'][$row['planning_date']][$row['customer']] [$row['item']] [$row['rejection_group']][$row['rejection_type']]  = $row;        
                    $data['record_list'][] = $row;
            }
            
        } */
        
        
       /*  $sql = "
                select
                z.customer_id,
                z.pattern_id, 
                z.planning_date,
                z.shift,
                sum(z.curr_produced_qty) as  curr_produced_qty
                from (
                    (
                    select 
                    a3.customer_id,
                    a3.pattern_id, 
                    a1.planning_date,
                    a3.shift,
                    sum((a2.produced_qty)) as curr_produced_qty
                    from melting_heat_log_info as a1
                    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    where a1.`status` = 'Active' and a3.`status` != 'Delete' 
                    and a1.planning_date between '" .$srch_from_date. "' and '" .$srch_to_date. "'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and a3.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and a3.pattern_id = '". $srch_pattern_id ."'";
                    } 
        			if(!empty($srch_shift) ){
        				  $sql.=" and a3.shift = '". $srch_shift ."'";
        			}
                    $sql.="
                    group by a3.customer_id, a3.pattern_id ,a1.planning_date,a3.shift
                    order by a3.customer_id, a3.pattern_id ,a1.planning_date,a3.shift
                    ) union all (
                    select 
                    a3.customer_id,
                    a3.pattern_id, 
                    a1.planning_date,
                    a3.shift,
                    sum((a2.produced_qty)) as curr_produced_qty
                    from melting_heat_log_info as a1
                    left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                    where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' 
                    and a1.planning_date between '" .$srch_from_date. "' and '" .$srch_to_date. "'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and a3.customer_id = '". $srch_customer_id ."'"; 
                    }
                    if(!empty($srch_pattern_id) ){
                      $sql.=" and a3.pattern_id = '". $srch_pattern_id ."'";
                    } 
        			if(!empty($srch_shift) ){
        				  $sql.=" and a3.shift = '". $srch_shift ."'";
        			}
                    $sql.="
                    group by a3.customer_id, a3.pattern_id ,a1.planning_date ,a3.shift
                    order by a3.customer_id, a3.pattern_id ,a1.planning_date,a3.shift
                    )
                 ) as z
                  
                 group by z.customer_id, z.pattern_id ,z.planning_date  ,z.shift
                 order by z.customer_id, z.pattern_id ,z.planning_date  ,z.shift 
                ";
          */      
        $sql = "
          
            select 
            a.work_planning_id,
            a.planning_date,
            a.shift,
            d.pattern_item,
            c.company_name as customer,
            d.piece_weight_per_kg as wt ,
            z.produced_qty,
            w.rejection_qty,
            (w.rejection_qty * 100 / z.produced_qty ) as rej_qty_pert,
            ((w.rejection_qty * d.piece_weight_per_kg) * 100 / (z.produced_qty * d.piece_weight_per_kg) ) as rej_wt_pert
            from work_planning_info as a
            left join pattern_info as d on d.pattern_id = a.pattern_id
            left join customer_info as c on c.customer_id = a.customer_id
            left join (select w.work_planning_id ,sum(w.produced_qty) as produced_qty  from melting_item_info as w where w.status ='Active' group by w.work_planning_id )  as z on z.work_planning_id = a.work_planning_id 
            left join (
                        select 
                        sum(q.rejection_qty) as rejection_qty , 
                        q.work_planning_id  
                        from  qc_inspection_info as q 
                        where q.rejection_type_id != '32' and q.`status` = 'Active'";
                        if(!empty($srch_rej_grp) ){
                            $sql.=" and q.rejection_group = '". $srch_rej_grp ."'";
                        }
                        if(!empty($srch_rej_type_id) ){
                            $sql.=" and q.rejection_type_id = '". $srch_rej_type_id ."'";
                        } 
                        $sql.=" group by q.work_planning_id 
                       ) as w on w.work_planning_id = a.work_planning_id
            where a.`status` != 'Delete' 
            and a.planning_date between '" .$srch_from_date. "' and '" .$srch_to_date. "'";
            if(!empty($srch_customer_id) ){
                $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
            } 
            
			if(!empty($srch_shift) ){
				  $sql.=" and a.shift = '". $srch_shift ."'";
			}
            $sql.=" 
            group by a.work_planning_id , a.planning_date , a.shift , a.customer_id , a.pattern_id
            order by a.planning_date , a.shift , c.company_name  , d.pattern_item asc  
         
         ";       
                
         $query = $this->db->query($sql);
         
         $data['production_list'] = array();
         
         foreach ($query->result_array() as $row){ 
            
            if(empty($srch_more_than) ){
                $data['production_list'][$row['planning_date']][$row['shift']][] = $row;
                
            } else 
            {   
                if($row['rej_wt_pert'] >= $srch_more_than)
                    $data['production_list'][$row['planning_date']][$row['shift']][] = $row;        
                
            }
             
         }
		 
		 /*
		 echo "<pre>"; 
         print_r($sql);       
         echo "</pre>";
		 */
         
         
         $sql = " 
            select 
            a.work_planning_id,
            a.rejection_group as dept,
            c.rejection_type_name,
            sum(a.rejection_qty) as rej_qty 
            from qc_inspection_info as a
            left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
            left join rejection_type_info as c on c.rejection_type_id = a.rejection_type_id 
            where a.status = 'Active' and b.status != 'Delete' 
            and a.rejection_qty > 0 and a.rejection_type_id != '32'
            and b.planning_date between '" .$srch_from_date. "' and '" .$srch_to_date. "'";
            if(!empty($srch_customer_id) ){
                $sql.=" and b.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
            } 
             if(!empty($srch_rej_grp) ){
                  $sql.=" and a.rejection_group = '". $srch_rej_grp ."'";
            }
            if(!empty($srch_rej_type_id) ){
                  $sql.=" and a.rejection_type_id = '". $srch_rej_type_id ."'";
            }
			if(!empty($srch_shift) ){
				  $sql.=" and b.shift = '". $srch_shift ."'";
			}
            $sql.="  
            group by a.work_planning_id , a.rejection_group , a.rejection_type_id 
            order by a.work_planning_id , a.rejection_group , c.rejection_type_name
         ";
         
         $query = $this->db->query($sql);
         
         $data['rej_list'] = array();
         
         foreach ($query->result_array() as $row){
             $data['rej_list'][$row['work_planning_id']][$row['dept']][] = $row;
         }
                
                 
         /*echo "<pre>"; 
         print_r($sql);       
         echo "</pre>"; */
       
        
         
        } else {
            $data['pattern_opt'] =array();
            $data['rejection_typ_opt'] =array();
            
        }
		
		$sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'IR'
                and a.ason_date <= '". date('Y-m-d') ."'
                order by a.ason_date desc
                limit 1
                ";
                
         $query = $this->db->query($sql); 
         
         $data['iso_label'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['iso_label'] = $row;     
        } 
        
        $this->load->view('page/reports/customer_wise_rejection_report-v2',$data); 
	}  
	
	public function headcode_wise_stock_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false; 
       
      
       if(isset($_POST['srch_customer_id'])) {
         $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
         $data['submit_flg'] = true; 
       } else {
         $data['srch_customer_id'] = $srch_customer_id = '';
       }
       
        if(isset($_POST['srch_pattern_id'])) {
         $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
         
          $data['submit_flg'] = true; 
       } else {
         $data['srch_pattern_id'] = $srch_pattern_id = '';
       }
      
       
      
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        } 
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
         
         
        
        $sql =" 
            select 
            a.work_planning_id,
            a.planning_date,
            a.shift ,
            g.company_name as customer, 
            f.pattern_item as item,
            a.planned_box ,
            b.melting_heat_log_id,
            concat(e.heat_code,e.days_heat_no) as heat_code,
            b.produced_qty,
            ifnull(c.rejection_qty,0) as rejection_qty ,
            ifnull(d.despatch_qty,0) as despatch_qty,
            (b.produced_qty - (ifnull(c.rejection_qty,0) + ifnull(d.despatch_qty,0))) as stock_qty 
            from work_planning_info as a  
            left join ( select p.work_planning_id , p.melting_heat_log_id, sum(p.produced_qty) as produced_qty from melting_item_info as p where p.`status` = 'Active' group by p.work_planning_id , p.melting_heat_log_id ) as b on b.work_planning_id = a.work_planning_id
            left join (select q.work_planning_id, q.melting_heat_log_id ,sum(q.rejection_qty) as rejection_qty from qc_inspection_info as q where q.`status` = 'Active' group by q.work_planning_id, q.melting_heat_log_id) as c on c.work_planning_id = a.work_planning_id and c.melting_heat_log_id = b.melting_heat_log_id 
            left join ( select  r.work_planning_id , r.melting_heat_log_id , sum(r.qty) as despatch_qty from heatcode_despatch_info as r where r.`status` = 'Active' and r.melting_heat_log_id > 0 and r.heat_code != '' and r.work_planning_id > 0 group by r.work_planning_id , r.melting_heat_log_id ) as d on d.work_planning_id = a.work_planning_id and d.melting_heat_log_id = b.melting_heat_log_id
            left join melting_heat_log_info as e on e.melting_heat_log_id = b.melting_heat_log_id
            left join pattern_info as f on f.pattern_id = a.pattern_id
            left join customer_info as g on g.customer_id= a.customer_id
            where a.status != 'Delete'
            and b.melting_heat_log_id != ''            
            "; 
			
			// and (b.produced_qty - (ifnull(c.rejection_qty,0) + ifnull(d.despatch_qty,0))) > 0
            if(!empty($srch_customer_id) ){
                $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
            } 
             
            $sql.=" order by a.planning_date desc , a.customer_id asc, f.pattern_item  asc ";
        
        
         
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['customer']][$row['item']][] = $row;  
        }
        
         
        } else {
            $data['pattern_opt'] =array();
            
        }
        
        /*echo "<pre>";
        echo $sql;
        echo "</pre>";*/ 
        
        $this->load->view('page/reports/headcode_wise_stock_report',$data); 
	} 
	
	public function customer_pattern_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
     
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
       
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        } 
       
        
        $this->load->view('page/reports/customer_pattern_list',$data); 
	} 
    
    
    public function print_pattern_info($customer_id)
    {
        $sql = " select
                    GROUP_CONCAT( c.company_name) as customer, 
                    a.pattern_item,
                    a.*,
                    b.grade_name as  grade
                    from pattern_info as a 
                    left join grade_info as b on b.grade_id = a.grade 
                    left join customer_info as c on FIND_IN_SET( c.customer_id , a.customer_id)  
                    where a.`status` = 'Active' 
                      
                  ";
                    if(!empty($customer_id) ){
                        //$sql.=" and FIND_IN_SET( '". $customer_id ."' , a.customer_id)  "; 
                        $sql.=" and c.customer_id =  '". $customer_id ."'  "; 
                    }
                   
                    $sql.=" group by a.pattern_id 
                    order by a.match_plate_no asc,  a.pattern_item asc 
                                
                ";
        /*
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        */
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'LOP'
                and a.ason_date <= '". date('Y-m-d') ."'
                order by a.ason_date desc
                limit 1
                ";
                
         $query = $this->db->query($sql); 
         
         $data['iso_label'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['iso_label'] = $row;     
        }      
        
        $this->load->view('page/reports/print-pattern-info',$data); 
        
    }
    
    public function headcode_wise_rejection_report()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect(); 
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false; 
        
        
        if(isset($_POST['srch_from_date'])) {
        $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
        $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
        
        }  else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = ''; 
        }
       
      
       if(isset($_POST['srch_customer_id'])) {
         $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
         $data['submit_flg'] = true; 
       } else {
         $data['srch_customer_id'] = $srch_customer_id = '';
       }
       
       if(isset($_POST['srch_pattern_id'])) {
         $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id');  
          $data['submit_flg'] = true; 
       } else {
         $data['srch_pattern_id'] = $srch_pattern_id = '';
       }
       
       
      
       
      
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name as company  
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        } 
        
        if($data['submit_flg']) { 
            
        if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $srch_customer_id ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        } else {
            $data['pattern_opt'] =array();
        }
        
         
         
        
        $sql =" 
            select 
            a.qc_date,
            d.planning_date,
            d.shift,
            e.company_name as customer,
            f.pattern_item as item,
            a.rejection_group,
            concat(b.heat_code,b.days_heat_no) as heat_code,
            c.rejection_type_name as rejection_type,
            a.rejection_qty
            from qc_inspection_info as a
            left join melting_heat_log_info as b on b.melting_heat_log_id = a.melting_heat_log_id
            left join rejection_type_info as c on c.rejection_type_id = a.rejection_type_id
            left join work_planning_info as d on d.work_planning_id = a.work_planning_id
            left join customer_info as e on e.customer_id = d.customer_id
            left join pattern_info as f on f.pattern_id = d.pattern_id
            where a.`status` = 'Active' and d.`status` != 'Delete'          
            ";  
            
            if(!empty($srch_customer_id) ){
                $sql.=" and d.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
              $sql.=" and d.pattern_id = '". $srch_pattern_id ."'";
            } 
            
            if(!empty($srch_from_date) ){
              $sql.=" and a.qc_date between '". $srch_from_date ."' and '". $srch_to_date ."' ";
            }
             
            $sql.=" 
            
            order by  e.company_name , f.pattern_item, a.qc_date , b.heat_code, b.days_heat_no , a.rejection_group , c.rejection_type_name ";
        
        
         
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['customer']][$row['item']][] = $row;  
        }
        
         
        } else {
            $data['pattern_opt'] =array();
            
        }
        
        /*echo "<pre>";
        echo $sql;
        echo "</pre>"; */
        
        $this->load->view('page/reports/headcode_wise_rejection_report',$data); 
	} 
    
    
}
