<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends CI_Controller {

    public function chart_internal_rejection()
    {
        $data['js'] = 'chart/internal-rejection.inc';
        
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
        } else {
            $data['srch_from_date'] = $srch_from_date = '';
            $data['srch_to_date'] = $srch_to_date = ''; 
        }
        
        
        if(isset($_POST['srch_customer_id'])) {
            $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
        } else {
            $data['srch_customer_id'] = $srch_customer_id = '';
        }
        
        if(isset($_POST['srch_pattern_id'])) {
        $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
        } else {
            $data['srch_pattern_id'] = $srch_pattern_id = '';
        }
        
        if(isset($_POST['srch_more_than'])) {
        $data['srch_more_than'] = $srch_more_than = $this->input->post('srch_more_than'); 
        } else {
            $data['srch_more_than'] = $srch_more_than = '';
        }
        
        if(isset($_POST['srch_shift'])) {
        $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift');
        } else {
            $data['srch_shift'] = $srch_shift = '';
        }
        
        if(isset($_POST['srch_rej_grp'])) {
        $data['srch_rej_grp'] = $srch_rej_grp = $this->input->post('srch_rej_grp');
        } else {
            $data['srch_rej_grp'] = $srch_rej_grp = '';
        }
        
        if(isset($_POST['srch_rej_type_id'])) {
        $data['srch_rej_type_id'] = $srch_rej_type_id = $this->input->post('srch_rej_type_id');
        } else {
            $data['srch_rej_type_id'] = $srch_rej_type_id = '';
        }
        
        
        $where= " and 1=1 "; 
       
       if(!empty($srch_from_date)){
       // $where .= " and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'"; 
        $data['submit_flg'] = true;
        }  
       
       if(!empty($srch_customer_id)){
       // $where .= " and a3.customer_id= '" . $srch_customer_id . "'";   
        
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
        
         $data['pattern_opt'] =array();
         
         $data['rejection_typ_opt'] =array();
        
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
            
        
       /* $sql ="
            select   
            d.pattern_item as item, 
            sum(a.rejection_qty) as rejection_qty,
            d.piece_weight_per_kg,
            round((sum(a.rejection_qty) * d.piece_weight_per_kg),3) as weight
            from qc_inspection_info as a
            left join work_planning_info as b on b.work_planning_id = a.work_planning_id
            left join customer_info as c on c.customer_id = b.customer_id
            left join pattern_info as d on d.pattern_id = b.pattern_id
            where a.`status` != 'Delete'  and b.`status` != 'Delete' and a.rejection_type_id != '32'
            $where 
            group by b.customer_id, b.pattern_id 
            order by d.pattern_item asc 
        "; 
        
       $sql ="
        select 
        w.pattern_item as item,
        q.pattern_id,
        q.customer_id,
        sum(q.produced_qty) as produced_qty,
        round((sum(q.produced_qty) * w.piece_weight_per_kg),3) as prod_wt,
        sum(q.rejection_qty) as rejection_qty,
        round((sum(q.rejection_qty) * w.piece_weight_per_kg),3) as rej_wt
        from (
            select 
            a2.work_planning_id,
            a3.customer_id,
            a3.pattern_id, 
            (sum(ifnull(a2.produced_qty,0)) + sum(ifnull(a4.produced_qty,0)) -  sum(ifnull(a7.closed_mould_qty,0))) as produced_qty ,
            ifnull(a5.rejection_qty,0) as rejection_qty
            from melting_heat_log_info as a1
            left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
            left join melting_child_item_info as a4 on a4.melting_heat_log_id = a2.melting_heat_log_id 
            left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
            left join moulding_log_item_info as a7 on a7.work_planning_id = a2.work_planning_id
            left join ( select w.work_planning_id , sum(w.rejection_qty) as rejection_qty  from qc_inspection_info as w where w.`status` = 'Active' and w.rejection_type_id != '32' group by w.work_planning_id ) as a5 on a5.work_planning_id = a2.work_planning_id
            where a1.`status` = 'Active' and a3.`status` != 'Delete' 
            $where
            group by a2.work_planning_id , a3.customer_id, a3.pattern_id 
            order by a3.customer_id, a3.pattern_id 
        ) as q
        left join pattern_info as w on w.pattern_id = q.pattern_id
        group by q.pattern_id 
        order by w.pattern_item asc
        
        ";
        
        $query = $this->db->query($sql); 
         
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;        
        } */
        
        
        $sql ="
        select 
            z.customer,
            z.pattern_item as item, 
            z.curr_produced_qty as produced_qty,
            z.curr_rejection_qty as rejection_qty,
            round((z.curr_produced_qty * z.piece_weight_per_kg),3) as prod_wt,
            round((z.curr_rejection_qty * z.piece_weight_per_kg),3) as rej_wt 
            from (
            
            select 
            a.customer_id,
            a.pattern_id,
            a.pattern_item, 
            GROUP_CONCAT( p6.company_name) as customer,
            a.piece_weight_per_kg, 
            (ifnull(qa.curr_produced_qty,0) - ifnull(cm.closed_mould_qty,0)) as curr_produced_qty,
            ifnull(qb.curr_rejection_qty,0) as curr_rejection_qty 
            from pattern_info as a  
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
                where a1.`status` = 'Active' and a3.`status` != 'Delete' 
                and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
                 if(!empty($srch_customer_id)){
                    $sql.="and a3.customer_id = '" . $srch_customer_id . "'";
                 }
                 if(!empty($srch_pattern_id)){
                    $sql.="and a3.pattern_id = '" . $srch_pattern_id . "'";
                 }
                 if(!empty($srch_shift)){
                    $sql.="and a3.shift = '" . $srch_shift . "'";
                 }
                 
                $sql.="group by a3.customer_id, a3.pattern_id 
                order by a3.customer_id, a3.pattern_id 
                ) union all (
                select 
                a3.customer_id,
                a3.pattern_id, 
                sum((a2.produced_qty)) as curr_produced_qty
                from melting_heat_log_info as a1
                left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' 
                and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
                 if(!empty($srch_customer_id)){
                    $sql.="and a3.customer_id = '" . $srch_customer_id . "'";
                 }
                 if(!empty($srch_pattern_id)){
                    $sql.="and a3.pattern_id = '" . $srch_pattern_id . "'";
                 }
                  if(!empty($srch_shift)){
                    $sql.="and a3.shift = '" . $srch_shift . "'";
                 }
                $sql.="group by a3.customer_id, a3.pattern_id 
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
            where a.status = 'Active' and b.status != 'Delete' and a.rejection_type_id != '32' 
            and b.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
             if(!empty($srch_customer_id)){
                $sql.="and b.customer_id = '" . $srch_customer_id . "'";
             }
             if(!empty($srch_pattern_id)){
                $sql.="and b.pattern_id = '" . $srch_pattern_id . "'";
             }
             if(!empty($srch_rej_grp) ){
                  $sql.=" and a.rejection_group = '". $srch_rej_grp ."'";
             }
             if(!empty($srch_rej_type_id) ){
                  $sql.=" and a.rejection_type_id = '". $srch_rej_type_id ."'";
             }
             if(!empty($srch_shift)){
                $sql.="and b.shift = '" . $srch_shift . "'";
             }
            $sql.="group by b.customer_id, b.pattern_id 
        ) as qb on FIND_IN_SET( qb.customer_id , a.customer_id) and qb.pattern_id = a.pattern_id
         
        left join (
         select  
         q1.pattern_id,
         q1.customer_id,
         sum(q.closed_mould_qty) as closed_mould_qty 
         from moulding_log_item_info as q
         left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
         where q.`status` = 'Active' and q1.`status` != 'Delete' 
         and q1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
         if(!empty($srch_customer_id)){
            $sql.="and q1.customer_id = '" . $srch_customer_id . "'";
         }
         if(!empty($srch_pattern_id)){
            $sql.="and q1.pattern_id = '" . $srch_pattern_id . "'";
         }
          if(!empty($srch_shift)){
            $sql.="and q1.shift = '" . $srch_shift . "'";
         }
        $sql.="group by q1.pattern_id ,q1.customer_id
        ) as cm on cm.pattern_id = a.pattern_id and FIND_IN_SET( cm.customer_id , a.customer_id)  
        
        left join customer_info as p6 on FIND_IN_SET( p6.customer_id , a.customer_id)  
        where a.`status` = 'Active'    
            group by a.pattern_id , a.customer_id 
            order by customer , pattern_item 
        )  as z  
    where z.curr_produced_qty > 0  or z.curr_rejection_qty > 0 ";
    /*if(!empty($srch_more_than)){
        echo $sql.=" and (z.curr_rejection_qty * 100 / z.curr_produced_qty ) >= '" . $srch_more_than . "'";
    } */
    
    $sql.=" group by  z.customer_id , pattern_id
            order by z.customer, z.pattern_item  
        ";
        
        $query = $this->db->query($sql); 
         
        $tot_prod_wt = $tot_rej_wt = 0;
        $tot_prod_qty = $tot_rej_qty = 0;
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;  
            
            $tot_prod_qty += $row['produced_qty'];       
            $tot_prod_wt += $row['prod_wt'];       
            $tot_rej_qty += $row['rejection_qty'];       
            $tot_rej_wt += $row['rej_wt'];       
        }
        
        $data['tot_prod_qty'] = $tot_prod_qty ;
        $data['tot_rej_qty'] = $tot_rej_qty ;
        
        $data['tot_prod_wt'] = $tot_prod_wt ;
        $data['tot_rej_wt'] = $tot_rej_wt ;
        
        
        
        $sql = "  
                select 
                z.rejection_group , 
                z.rejection_type_id   ,
                z.rejection_type_name,
                sum(z.rej_qty) as rej_qty,
                sum(z.rej_wt) as rej_wt
                from (         
               
                    select
                    a.work_planning_id,  
                    b.rejection_group, 
                    b.rejection_type_id,
					c1.rejection_type_name,
                    sum(b.rejection_qty) as rej_qty ,
                    round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
                    from work_planning_info as a
                    left join pattern_info as d on d.pattern_id = a.pattern_id
                    left join customer_info as c on c.customer_id = a.customer_id
                    left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                    where  a.`status` != 'Delete' and a.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                     if(!empty($srch_customer_id) ){
                        $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                     }
                     if(!empty($srch_pattern_id)){
                        $sql.="and a.pattern_id = '" . $srch_pattern_id . "'";
                     }
                     if(!empty($srch_rej_grp) ){
                          $sql.=" and b.rejection_group = '". $srch_rej_grp ."'";
                     }
                     if(!empty($srch_rej_type_id) ){
                          $sql.=" and b.rejection_type_id = '". $srch_rej_type_id ."'";
                     }
                     if(!empty($srch_shift)){
                        $sql.="and a.shift = '" . $srch_shift . "'";
                     }
                    $sql.="  and b.rejection_type_id != '' and b.rejection_type_id != '32'
                    group by a.work_planning_id, b.rejection_group , b.rejection_type_id 
                    order by a.planning_date asc, c.company_name, d.pattern_item asc  
                    ) as z
                    group by z.rejection_group , z.rejection_type_id           
        "; 	 
        
        
        $query = $this->db->query($sql); 
          
        $data['rej_group'] = array();
        $data['rej_type_group'] = array();
        
         $tot_rej_wt1 = 0;
       
        foreach ($query->result_array() as $row)
        {
            $data['rej_group'][$row['rejection_group']]['qty'][]= $row['rej_qty'];       
            $data['rej_group'][$row['rejection_group']]['wt'][]= $row['rej_wt'];   
            $tot_rej_wt1 += $row['rej_wt'];   
            
            $data['rej_type_group'][$row['rejection_group']][$row['rejection_type_name']]['qty'][]= $row['rej_qty'];      
            $data['rej_type_group'][$row['rejection_group']][$row['rejection_type_name']]['wt'][]= $row['rej_wt'];      
        }
        
       $data['tot_rej_wt1'] = $tot_rej_wt1;
        
        
         //echo "<pre>";
         //print_r($sql);   
        //print_r($data['rej_group']);   
         //print_r($data['rej_type_group']);   
        
        //echo "</pre>"; 
        
        //echo array_sum($data['rej_group']['Moulding']['qty']);
        
        
        }
        
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'TC'
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
         
        
        
         
        $this->load->view('page/chart/internal-rejection', $data);
    }
    
    
    public function chart_internal_rejection_total()
    {
        $data['js'] = 'chart/internal-rejection-total.inc';
        
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
        } else {
            $data['srch_from_date'] = $srch_from_date = '';
            $data['srch_to_date'] = $srch_to_date = ''; 
        }
        
        
        if(isset($_POST['srch_customer_id'])) {
            $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
        } else {
            $data['srch_customer_id'] = $srch_customer_id = '';
        }
        
        if(isset($_POST['srch_pattern_id'])) {
        $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
        } else {
            $data['srch_pattern_id'] = $srch_pattern_id = '';
        }
        
        if(isset($_POST['srch_more_than'])) {
        $data['srch_more_than'] = $srch_more_than = $this->input->post('srch_more_than'); 
        } else {
            $data['srch_more_than'] = $srch_more_than = '';
        }
        
        if(isset($_POST['srch_shift'])) {
        $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift');
        } else {
            $data['srch_shift'] = $srch_shift = '';
        }
        
        if(isset($_POST['srch_rej_grp'])) {
        $data['srch_rej_grp'] = $srch_rej_grp = $this->input->post('srch_rej_grp');
        } else {
            $data['srch_rej_grp'] = $srch_rej_grp = '';
        }
        
        if(isset($_POST['srch_rej_type_id'])) {
        $data['srch_rej_type_id'] = $srch_rej_type_id = $this->input->post('srch_rej_type_id');
        } else {
            $data['srch_rej_type_id'] = $srch_rej_type_id = '';
        }
        
        
        $where= " and 1=1 "; 
       
       if(!empty($srch_from_date)){
       // $where .= " and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'"; 
        $data['submit_flg'] = true;
        }  
       
       if(!empty($srch_customer_id)){
       // $where .= " and a3.customer_id= '" . $srch_customer_id . "'";   
        
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
        
         $data['pattern_opt'] =array();
         
         $data['rejection_typ_opt'] =array();
        
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
            
        
       /* $sql ="
            select   
            d.pattern_item as item, 
            sum(a.rejection_qty) as rejection_qty,
            d.piece_weight_per_kg,
            round((sum(a.rejection_qty) * d.piece_weight_per_kg),3) as weight
            from qc_inspection_info as a
            left join work_planning_info as b on b.work_planning_id = a.work_planning_id
            left join customer_info as c on c.customer_id = b.customer_id
            left join pattern_info as d on d.pattern_id = b.pattern_id
            where a.`status` != 'Delete'  and b.`status` != 'Delete' and a.rejection_type_id != '32'
            $where 
            group by b.customer_id, b.pattern_id 
            order by d.pattern_item asc 
        "; 
        
       $sql ="
        select 
        w.pattern_item as item,
        q.pattern_id,
        q.customer_id,
        sum(q.produced_qty) as produced_qty,
        round((sum(q.produced_qty) * w.piece_weight_per_kg),3) as prod_wt,
        sum(q.rejection_qty) as rejection_qty,
        round((sum(q.rejection_qty) * w.piece_weight_per_kg),3) as rej_wt
        from (
            select 
            a2.work_planning_id,
            a3.customer_id,
            a3.pattern_id, 
            (sum(ifnull(a2.produced_qty,0)) + sum(ifnull(a4.produced_qty,0)) -  sum(ifnull(a7.closed_mould_qty,0))) as produced_qty ,
            ifnull(a5.rejection_qty,0) as rejection_qty
            from melting_heat_log_info as a1
            left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
            left join melting_child_item_info as a4 on a4.melting_heat_log_id = a2.melting_heat_log_id 
            left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
            left join moulding_log_item_info as a7 on a7.work_planning_id = a2.work_planning_id
            left join ( select w.work_planning_id , sum(w.rejection_qty) as rejection_qty  from qc_inspection_info as w where w.`status` = 'Active' and w.rejection_type_id != '32' group by w.work_planning_id ) as a5 on a5.work_planning_id = a2.work_planning_id
            where a1.`status` = 'Active' and a3.`status` != 'Delete' 
            $where
            group by a2.work_planning_id , a3.customer_id, a3.pattern_id 
            order by a3.customer_id, a3.pattern_id 
        ) as q
        left join pattern_info as w on w.pattern_id = q.pattern_id
        group by q.pattern_id 
        order by w.pattern_item asc
        
        ";
        
        $query = $this->db->query($sql); 
         
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;        
        } */
        
        
        $sql ="
        select 
            z.customer,
            z.pattern_item as item, 
            z.curr_produced_qty as produced_qty,
            z.curr_rejection_qty as rejection_qty,
            round((z.curr_produced_qty * z.piece_weight_per_kg),3) as prod_wt,
            round((z.curr_rejection_qty * z.piece_weight_per_kg),3) as rej_wt 
            from (
            
            select 
            a.customer_id,
            a.pattern_id,
            a.pattern_item, 
            GROUP_CONCAT( p6.company_name) as customer,
            a.piece_weight_per_kg, 
            (ifnull(qa.curr_produced_qty,0) - ifnull(cm.closed_mould_qty,0)) as curr_produced_qty,
            ifnull(qb.curr_rejection_qty,0) as curr_rejection_qty 
            from pattern_info as a  
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
                where a1.`status` = 'Active' and a3.`status` != 'Delete' 
                and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
                 if(!empty($srch_customer_id)){
                    $sql.="and a3.customer_id = '" . $srch_customer_id . "'";
                 }
                 if(!empty($srch_pattern_id)){
                    $sql.="and a3.pattern_id = '" . $srch_pattern_id . "'";
                 }
                 if(!empty($srch_shift)){
                    $sql.="and a3.shift = '" . $srch_shift . "'";
                 }
                 
                $sql.="group by a3.customer_id, a3.pattern_id 
                order by a3.customer_id, a3.pattern_id 
                ) union all (
                select 
                a3.customer_id,
                a3.pattern_id, 
                sum((a2.produced_qty)) as curr_produced_qty
                from melting_heat_log_info as a1
                left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' 
                and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
                 if(!empty($srch_customer_id)){
                    $sql.="and a3.customer_id = '" . $srch_customer_id . "'";
                 }
                 if(!empty($srch_pattern_id)){
                    $sql.="and a3.pattern_id = '" . $srch_pattern_id . "'";
                 }
                  if(!empty($srch_shift)){
                    $sql.="and a3.shift = '" . $srch_shift . "'";
                 }
                $sql.="group by a3.customer_id, a3.pattern_id 
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
            where a.status = 'Active' and b.status != 'Delete'   
            and b.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
             if(!empty($srch_customer_id)){
                $sql.="and b.customer_id = '" . $srch_customer_id . "'";
             }
             if(!empty($srch_pattern_id)){
                $sql.="and b.pattern_id = '" . $srch_pattern_id . "'";
             }
             if(!empty($srch_rej_grp) ){
                  $sql.=" and a.rejection_group = '". $srch_rej_grp ."'";
             }
             if(!empty($srch_rej_type_id) ){
                  $sql.=" and a.rejection_type_id = '". $srch_rej_type_id ."'";
             }
             if(!empty($srch_shift)){
                $sql.="and b.shift = '" . $srch_shift . "'";
             }
            $sql.="group by b.customer_id, b.pattern_id 
        ) as qb on FIND_IN_SET( qb.customer_id , a.customer_id) and qb.pattern_id = a.pattern_id
         
        left join (
         select  
         q1.pattern_id,
         q1.customer_id,
         sum(q.closed_mould_qty) as closed_mould_qty 
         from moulding_log_item_info as q
         left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
         where q.`status` = 'Active' and q1.`status` != 'Delete' 
         and q1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
         if(!empty($srch_customer_id)){
            $sql.="and q1.customer_id = '" . $srch_customer_id . "'";
         }
         if(!empty($srch_pattern_id)){
            $sql.="and q1.pattern_id = '" . $srch_pattern_id . "'";
         }
          if(!empty($srch_shift)){
            $sql.="and q1.shift = '" . $srch_shift . "'";
         }
        $sql.="group by q1.pattern_id ,q1.customer_id
        ) as cm on cm.pattern_id = a.pattern_id and FIND_IN_SET( cm.customer_id , a.customer_id)  
        
        left join customer_info as p6 on FIND_IN_SET( p6.customer_id , a.customer_id)  
        where a.`status` = 'Active'    
            group by a.pattern_id , a.customer_id 
            order by customer , pattern_item 
        )  as z  
    where z.curr_produced_qty > 0  or z.curr_rejection_qty > 0 ";
    /*if(!empty($srch_more_than)){
        echo $sql.=" and (z.curr_rejection_qty * 100 / z.curr_produced_qty ) >= '" . $srch_more_than . "'";
    } */
    
    $sql.=" group by  z.customer_id , pattern_id
            order by z.customer, z.pattern_item  
        ";
        
        $query = $this->db->query($sql); 
         
        $tot_prod_wt = $tot_rej_wt = 0;
        $tot_prod_qty = $tot_rej_qty = 0;
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;  
            
            $tot_prod_qty += $row['produced_qty'];       
            $tot_prod_wt += $row['prod_wt'];       
            $tot_rej_qty += $row['rejection_qty'];       
            $tot_rej_wt += $row['rej_wt'];       
        }
        
        $data['tot_prod_qty'] = $tot_prod_qty ;
        $data['tot_rej_qty'] = $tot_rej_qty ;
        
        $data['tot_prod_wt'] = $tot_prod_wt ;
        $data['tot_rej_wt'] = $tot_rej_wt ;
        
        
        
        $sql = "  
                select 
                z.rejection_group , 
                z.rejection_type_id   ,
                z.rejection_type_name,
                sum(z.rej_qty) as rej_qty,
                sum(z.rej_wt) as rej_wt
                from (         
               
                    select
                    a.work_planning_id,  
                    b.rejection_group, 
                    b.rejection_type_id,
					c1.rejection_type_name,
                    sum(b.rejection_qty) as rej_qty ,
                    round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
                    from work_planning_info as a
                    left join pattern_info as d on d.pattern_id = a.pattern_id
                    left join customer_info as c on c.customer_id = a.customer_id
                    left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                    where  a.`status` != 'Delete' and a.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                     if(!empty($srch_customer_id) ){
                        $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                     }
                     if(!empty($srch_pattern_id)){
                        $sql.="and a.pattern_id = '" . $srch_pattern_id . "'";
                     }
                     if(!empty($srch_rej_grp) ){
                          $sql.=" and b.rejection_group = '". $srch_rej_grp ."'";
                     }
                     if(!empty($srch_rej_type_id) ){
                          $sql.=" and b.rejection_type_id = '". $srch_rej_type_id ."'";
                     }
                     if(!empty($srch_shift)){
                        $sql.="and a.shift = '" . $srch_shift . "'";
                     }
                    $sql.="  and b.rejection_type_id != ''  
                    group by a.work_planning_id, b.rejection_group , b.rejection_type_id 
                    order by a.planning_date asc, c.company_name, d.pattern_item asc  
                    ) as z
                    group by z.rejection_group , z.rejection_type_id           
        "; 	 
        
        
        $query = $this->db->query($sql); 
          
        $data['rej_group'] = array();
        $data['rej_type_group'] = array();
        
         $tot_rej_wt1 = 0;
       
        foreach ($query->result_array() as $row)
        {
            $data['rej_group'][$row['rejection_group']]['qty'][]= $row['rej_qty'];       
            $data['rej_group'][$row['rejection_group']]['wt'][]= $row['rej_wt'];   
            $tot_rej_wt1 += $row['rej_wt'];   
            
            $data['rej_type_group'][$row['rejection_group']][$row['rejection_type_name']]['qty'][]= $row['rej_qty'];      
            $data['rej_type_group'][$row['rejection_group']][$row['rejection_type_name']]['wt'][]= $row['rej_wt'];      
        }
        
       $data['tot_rej_wt1'] = $tot_rej_wt1;
        
        
         //echo "<pre>";
         //print_r($sql);   
        //print_r($data['rej_group']);   
         //print_r($data['rej_type_group']);   
        
        //echo "</pre>"; 
        
        //echo array_sum($data['rej_group']['Moulding']['qty']);
        
        
        }
        
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'TC'
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
         
        
        
         
        $this->load->view('page/chart/internal-rejection-total', $data);
    }
    
    public function chart_internal_rejection_dept()
    {
        $data['js'] = 'chart/internal-rejection-dept.inc';
        
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
        } else {
            $data['srch_from_date'] = $srch_from_date = '';
            $data['srch_to_date'] = $srch_to_date = ''; 
        }
        
        
        if(isset($_POST['srch_customer_id'])) {
            $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
        } else {
            $data['srch_customer_id'] = $srch_customer_id = '';
        }
        
        if(isset($_POST['srch_pattern_id'])) {
        $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
        } else {
            $data['srch_pattern_id'] = $srch_pattern_id = '';
        }
        
        if(isset($_POST['srch_more_than'])) {
        $data['srch_more_than'] = $srch_more_than = $this->input->post('srch_more_than'); 
        } else {
            $data['srch_more_than'] = $srch_more_than = '';
        }
        
        if(isset($_POST['srch_shift'])) {
        $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift');
        } else {
            $data['srch_shift'] = $srch_shift = '';
        }
        
        if(isset($_POST['srch_rej_grp'])) {
        $data['srch_rej_grp'] = $srch_rej_grp = $this->input->post('srch_rej_grp');
        } else {
            $data['srch_rej_grp'] = $srch_rej_grp = '';
        }
        
        if(isset($_POST['srch_rej_type_id'])) {
        $data['srch_rej_type_id'] = $srch_rej_type_id = $this->input->post('srch_rej_type_id');
        } else {
            $data['srch_rej_type_id'] = $srch_rej_type_id = '';
        }
        
        
        $where= " and 1=1 "; 
       
       if(!empty($srch_from_date)){
       // $where .= " and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'"; 
        $data['submit_flg'] = true;
        }  
       
       if(!empty($srch_customer_id)){
       // $where .= " and a3.customer_id= '" . $srch_customer_id . "'";   
        
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
        
         $data['pattern_opt'] =array();
         
         $data['rejection_typ_opt'] =array();
        
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
            
        
       /* $sql ="
            select   
            d.pattern_item as item, 
            sum(a.rejection_qty) as rejection_qty,
            d.piece_weight_per_kg,
            round((sum(a.rejection_qty) * d.piece_weight_per_kg),3) as weight
            from qc_inspection_info as a
            left join work_planning_info as b on b.work_planning_id = a.work_planning_id
            left join customer_info as c on c.customer_id = b.customer_id
            left join pattern_info as d on d.pattern_id = b.pattern_id
            where a.`status` != 'Delete'  and b.`status` != 'Delete' and a.rejection_type_id != '32'
            $where 
            group by b.customer_id, b.pattern_id 
            order by d.pattern_item asc 
        "; 
        
       $sql ="
        select 
        w.pattern_item as item,
        q.pattern_id,
        q.customer_id,
        sum(q.produced_qty) as produced_qty,
        round((sum(q.produced_qty) * w.piece_weight_per_kg),3) as prod_wt,
        sum(q.rejection_qty) as rejection_qty,
        round((sum(q.rejection_qty) * w.piece_weight_per_kg),3) as rej_wt
        from (
            select 
            a2.work_planning_id,
            a3.customer_id,
            a3.pattern_id, 
            (sum(ifnull(a2.produced_qty,0)) + sum(ifnull(a4.produced_qty,0)) -  sum(ifnull(a7.closed_mould_qty,0))) as produced_qty ,
            ifnull(a5.rejection_qty,0) as rejection_qty
            from melting_heat_log_info as a1
            left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
            left join melting_child_item_info as a4 on a4.melting_heat_log_id = a2.melting_heat_log_id 
            left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
            left join moulding_log_item_info as a7 on a7.work_planning_id = a2.work_planning_id
            left join ( select w.work_planning_id , sum(w.rejection_qty) as rejection_qty  from qc_inspection_info as w where w.`status` = 'Active' and w.rejection_type_id != '32' group by w.work_planning_id ) as a5 on a5.work_planning_id = a2.work_planning_id
            where a1.`status` = 'Active' and a3.`status` != 'Delete' 
            $where
            group by a2.work_planning_id , a3.customer_id, a3.pattern_id 
            order by a3.customer_id, a3.pattern_id 
        ) as q
        left join pattern_info as w on w.pattern_id = q.pattern_id
        group by q.pattern_id 
        order by w.pattern_item asc
        
        ";
        
        $query = $this->db->query($sql); 
         
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;        
        } */
        
        
        $sql ="
        select 
            z.customer,
            z.pattern_item as item, 
            z.curr_produced_qty as produced_qty,
            z.curr_rejection_qty as rejection_qty,
            round((z.curr_produced_qty * z.piece_weight_per_kg),3) as prod_wt,
            round((z.curr_rejection_qty * z.piece_weight_per_kg),3) as rej_wt 
            from (
            
            select 
            a.customer_id,
            a.pattern_id,
            a.pattern_item, 
            GROUP_CONCAT( p6.company_name) as customer,
            a.piece_weight_per_kg, 
            (ifnull(qa.curr_produced_qty,0) - ifnull(cm.closed_mould_qty,0)) as curr_produced_qty,
            ifnull(qb.curr_rejection_qty,0) as curr_rejection_qty 
            from pattern_info as a  
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
                where a1.`status` = 'Active' and a3.`status` != 'Delete' 
                and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
                 if(!empty($srch_customer_id)){
                    $sql.="and a3.customer_id = '" . $srch_customer_id . "'";
                 }
                 if(!empty($srch_pattern_id)){
                    $sql.="and a3.pattern_id = '" . $srch_pattern_id . "'";
                 }
                 if(!empty($srch_shift)){
                    $sql.="and a3.shift = '" . $srch_shift . "'";
                 }
                 
                $sql.="group by a3.customer_id, a3.pattern_id 
                order by a3.customer_id, a3.pattern_id 
                ) union all (
                select 
                a3.customer_id,
                a3.pattern_id, 
                sum((a2.produced_qty)) as curr_produced_qty
                from melting_heat_log_info as a1
                left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' 
                and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
                 if(!empty($srch_customer_id)){
                    $sql.="and a3.customer_id = '" . $srch_customer_id . "'";
                 }
                 if(!empty($srch_pattern_id)){
                    $sql.="and a3.pattern_id = '" . $srch_pattern_id . "'";
                 }
                  if(!empty($srch_shift)){
                    $sql.="and a3.shift = '" . $srch_shift . "'";
                 }
                $sql.="group by a3.customer_id, a3.pattern_id 
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
            where a.status = 'Active' and b.status != 'Delete' and a.rejection_type_id != '32' 
            and b.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
             if(!empty($srch_customer_id)){
                $sql.="and b.customer_id = '" . $srch_customer_id . "'";
             }
             if(!empty($srch_pattern_id)){
                $sql.="and b.pattern_id = '" . $srch_pattern_id . "'";
             }
             if(!empty($srch_rej_grp) ){
                  $sql.=" and a.rejection_group = '". $srch_rej_grp ."'";
             }
             if(!empty($srch_rej_type_id) ){
                  $sql.=" and a.rejection_type_id = '". $srch_rej_type_id ."'";
             }
             if(!empty($srch_shift)){
                $sql.="and b.shift = '" . $srch_shift . "'";
             }
            $sql.="group by b.customer_id, b.pattern_id 
        ) as qb on FIND_IN_SET( qb.customer_id , a.customer_id) and qb.pattern_id = a.pattern_id
         
        left join (
         select  
         q1.pattern_id,
         q1.customer_id,
         sum(q.closed_mould_qty) as closed_mould_qty 
         from moulding_log_item_info as q
         left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
         where q.`status` = 'Active' and q1.`status` != 'Delete' 
         and q1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
         if(!empty($srch_customer_id)){
            $sql.="and q1.customer_id = '" . $srch_customer_id . "'";
         }
         if(!empty($srch_pattern_id)){
            $sql.="and q1.pattern_id = '" . $srch_pattern_id . "'";
         }
          if(!empty($srch_shift)){
            $sql.="and q1.shift = '" . $srch_shift . "'";
         }
        $sql.="group by q1.pattern_id ,q1.customer_id
        ) as cm on cm.pattern_id = a.pattern_id and FIND_IN_SET( cm.customer_id , a.customer_id)  
        
        left join customer_info as p6 on FIND_IN_SET( p6.customer_id , a.customer_id)  
        where a.`status` = 'Active'    
            group by a.pattern_id , a.customer_id 
            order by customer , pattern_item 
        )  as z  
    where z.curr_produced_qty > 0  or z.curr_rejection_qty > 0 ";
    /*if(!empty($srch_more_than)){
        echo $sql.=" and (z.curr_rejection_qty * 100 / z.curr_produced_qty ) >= '" . $srch_more_than . "'";
    } */
    
    $sql.=" group by  z.customer_id , pattern_id
            order by z.customer, z.pattern_item  
        ";
        
        $query = $this->db->query($sql); 
         
        $tot_prod_wt = $tot_rej_wt = 0;
        $tot_prod_qty = $tot_rej_qty = 0;
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;  
            
            $tot_prod_qty += $row['produced_qty'];       
            $tot_prod_wt += $row['prod_wt'];       
            $tot_rej_qty += $row['rejection_qty'];       
            $tot_rej_wt += $row['rej_wt'];       
        }
        
        $data['tot_prod_qty'] = $tot_prod_qty ;
        $data['tot_rej_qty'] = $tot_rej_qty ;
        
        $data['tot_prod_wt'] = $tot_prod_wt ;
        $data['tot_rej_wt'] = $tot_rej_wt ;
        
        
        
        $sql = "  
                select 
                z.rejection_group , 
                z.rejection_type_id   ,
                z.rejection_type_name,
                sum(z.rej_qty) as rej_qty,
                sum(z.rej_wt) as rej_wt
                from (         
               
                    select
                    a.work_planning_id,  
                    b.rejection_group, 
                    b.rejection_type_id,
					c1.rejection_type_name,
                    sum(b.rejection_qty) as rej_qty ,
                    round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
                    from work_planning_info as a
                    left join pattern_info as d on d.pattern_id = a.pattern_id
                    left join customer_info as c on c.customer_id = a.customer_id
                    left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                    where  a.`status` != 'Delete' and a.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                     if(!empty($srch_customer_id) ){
                        $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                     }
                     if(!empty($srch_pattern_id)){
                        $sql.="and a.pattern_id = '" . $srch_pattern_id . "'";
                     }
                     if(!empty($srch_rej_grp) ){
                          $sql.=" and b.rejection_group = '". $srch_rej_grp ."'";
                     }
                     if(!empty($srch_rej_type_id) ){
                          $sql.=" and b.rejection_type_id = '". $srch_rej_type_id ."'";
                     }
                     if(!empty($srch_shift)){
                        $sql.="and a.shift = '" . $srch_shift . "'";
                     }
                    $sql.="  and b.rejection_type_id != '' and b.rejection_type_id != '32'
                    group by a.work_planning_id, b.rejection_group , b.rejection_type_id 
                    order by a.planning_date asc, c.company_name, d.pattern_item asc  
                    ) as z
                    group by z.rejection_group , z.rejection_type_id           
        "; 	 
        
        
        $query = $this->db->query($sql); 
          
        $data['rej_group'] = array();
        $data['rej_type_group'] = array();
        
         $tot_rej_wt1 = 0;
       
        foreach ($query->result_array() as $row)
        {
            $data['rej_group'][$row['rejection_group']]['qty'][]= $row['rej_qty'];       
            $data['rej_group'][$row['rejection_group']]['wt'][]= $row['rej_wt'];   
            $tot_rej_wt1 += $row['rej_wt'];   
            
            $data['rej_type_group'][$row['rejection_group']][$row['rejection_type_name']]['qty'][]= $row['rej_qty'];      
            $data['rej_type_group'][$row['rejection_group']][$row['rejection_type_name']]['wt'][]= $row['rej_wt'];      
        }
        
       $data['tot_rej_wt1'] = $tot_rej_wt1;
        
        
         //echo "<pre>";
         //print_r($sql);   
        //print_r($data['rej_group']);   
         //print_r($data['rej_type_group']);   
        
        //echo "</pre>"; 
        
        //echo array_sum($data['rej_group']['Moulding']['qty']);
        
        
        }
        
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'TC'
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
         
        
        
         
        $this->load->view('page/chart/internal-rejection-dept', $data);
    }
    
    public function chart_internal_rejection_dept_wt()
    {
        $data['js'] = 'chart/internal-rejection-dept-wt.inc';
        
        $data['submit_flg'] = false;
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
        } else {
            $data['srch_from_date'] = $srch_from_date = '';
            $data['srch_to_date'] = $srch_to_date = ''; 
        }
        
        
        if(isset($_POST['srch_customer_id'])) {
            $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
        } else {
            $data['srch_customer_id'] = $srch_customer_id = '';
        }
        
        if(isset($_POST['srch_pattern_id'])) {
        $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
        } else {
            $data['srch_pattern_id'] = $srch_pattern_id = '';
        }
        
        if(isset($_POST['srch_more_than'])) {
        $data['srch_more_than'] = $srch_more_than = $this->input->post('srch_more_than'); 
        } else {
            $data['srch_more_than'] = $srch_more_than = '';
        }
        
        if(isset($_POST['srch_shift'])) {
        $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift');
        } else {
            $data['srch_shift'] = $srch_shift = '';
        }
        
        if(isset($_POST['srch_rej_grp'])) {
        $data['srch_rej_grp'] = $srch_rej_grp = $this->input->post('srch_rej_grp');
        } else {
            $data['srch_rej_grp'] = $srch_rej_grp = '';
        }
        
        if(isset($_POST['srch_rej_type_id'])) {
        $data['srch_rej_type_id'] = $srch_rej_type_id = $this->input->post('srch_rej_type_id');
        } else {
            $data['srch_rej_type_id'] = $srch_rej_type_id = '';
        }
        
        
        $where= " and 1=1 "; 
       
       if(!empty($srch_from_date)){
       // $where .= " and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'"; 
        $data['submit_flg'] = true;
        }  
       
       if(!empty($srch_customer_id)){
       // $where .= " and a3.customer_id= '" . $srch_customer_id . "'";   
        
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
        
         $data['pattern_opt'] =array();
         
         $data['rejection_typ_opt'] =array();
        
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
            
        
       /* $sql ="
            select   
            d.pattern_item as item, 
            sum(a.rejection_qty) as rejection_qty,
            d.piece_weight_per_kg,
            round((sum(a.rejection_qty) * d.piece_weight_per_kg),3) as weight
            from qc_inspection_info as a
            left join work_planning_info as b on b.work_planning_id = a.work_planning_id
            left join customer_info as c on c.customer_id = b.customer_id
            left join pattern_info as d on d.pattern_id = b.pattern_id
            where a.`status` != 'Delete'  and b.`status` != 'Delete' and a.rejection_type_id != '32'
            $where 
            group by b.customer_id, b.pattern_id 
            order by d.pattern_item asc 
        "; 
        
       $sql ="
        select 
        w.pattern_item as item,
        q.pattern_id,
        q.customer_id,
        sum(q.produced_qty) as produced_qty,
        round((sum(q.produced_qty) * w.piece_weight_per_kg),3) as prod_wt,
        sum(q.rejection_qty) as rejection_qty,
        round((sum(q.rejection_qty) * w.piece_weight_per_kg),3) as rej_wt
        from (
            select 
            a2.work_planning_id,
            a3.customer_id,
            a3.pattern_id, 
            (sum(ifnull(a2.produced_qty,0)) + sum(ifnull(a4.produced_qty,0)) -  sum(ifnull(a7.closed_mould_qty,0))) as produced_qty ,
            ifnull(a5.rejection_qty,0) as rejection_qty
            from melting_heat_log_info as a1
            left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
            left join melting_child_item_info as a4 on a4.melting_heat_log_id = a2.melting_heat_log_id 
            left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
            left join moulding_log_item_info as a7 on a7.work_planning_id = a2.work_planning_id
            left join ( select w.work_planning_id , sum(w.rejection_qty) as rejection_qty  from qc_inspection_info as w where w.`status` = 'Active' and w.rejection_type_id != '32' group by w.work_planning_id ) as a5 on a5.work_planning_id = a2.work_planning_id
            where a1.`status` = 'Active' and a3.`status` != 'Delete' 
            $where
            group by a2.work_planning_id , a3.customer_id, a3.pattern_id 
            order by a3.customer_id, a3.pattern_id 
        ) as q
        left join pattern_info as w on w.pattern_id = q.pattern_id
        group by q.pattern_id 
        order by w.pattern_item asc
        
        ";
        
        $query = $this->db->query($sql); 
         
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;        
        } */
        
        
        $sql ="
        select 
            z.customer,
            z.pattern_item as item, 
            z.curr_produced_qty as produced_qty,
            z.curr_rejection_qty as rejection_qty,
            round((z.curr_produced_qty * z.piece_weight_per_kg),3) as prod_wt,
            round((z.curr_rejection_qty * z.piece_weight_per_kg),3) as rej_wt 
            from (
            
            select 
            a.customer_id,
            a.pattern_id,
            a.pattern_item, 
            GROUP_CONCAT( p6.company_name) as customer,
            a.piece_weight_per_kg, 
            (ifnull(qa.curr_produced_qty,0) - ifnull(cm.closed_mould_qty,0)) as curr_produced_qty,
            ifnull(qb.curr_rejection_qty,0) as curr_rejection_qty 
            from pattern_info as a  
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
                where a1.`status` = 'Active' and a3.`status` != 'Delete' 
                and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
                 if(!empty($srch_customer_id)){
                    $sql.="and a3.customer_id = '" . $srch_customer_id . "'";
                 }
                 if(!empty($srch_pattern_id)){
                    $sql.="and a3.pattern_id = '" . $srch_pattern_id . "'";
                 }
                 if(!empty($srch_shift)){
                    $sql.="and a3.shift = '" . $srch_shift . "'";
                 }
                 
                $sql.="group by a3.customer_id, a3.pattern_id 
                order by a3.customer_id, a3.pattern_id 
                ) union all (
                select 
                a3.customer_id,
                a3.pattern_id, 
                sum((a2.produced_qty)) as curr_produced_qty
                from melting_heat_log_info as a1
                left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' 
                and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
                 if(!empty($srch_customer_id)){
                    $sql.="and a3.customer_id = '" . $srch_customer_id . "'";
                 }
                 if(!empty($srch_pattern_id)){
                    $sql.="and a3.pattern_id = '" . $srch_pattern_id . "'";
                 }
                  if(!empty($srch_shift)){
                    $sql.="and a3.shift = '" . $srch_shift . "'";
                 }
                $sql.="group by a3.customer_id, a3.pattern_id 
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
            where a.status = 'Active' and b.status != 'Delete' and a.rejection_type_id != '32' 
            and b.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
             if(!empty($srch_customer_id)){
                $sql.="and b.customer_id = '" . $srch_customer_id . "'";
             }
             if(!empty($srch_pattern_id)){
                $sql.="and b.pattern_id = '" . $srch_pattern_id . "'";
             }
             if(!empty($srch_rej_grp) ){
                  $sql.=" and a.rejection_group = '". $srch_rej_grp ."'";
             }
             if(!empty($srch_rej_type_id) ){
                  $sql.=" and a.rejection_type_id = '". $srch_rej_type_id ."'";
             }
             if(!empty($srch_shift)){
                $sql.="and b.shift = '" . $srch_shift . "'";
             }
            $sql.="group by b.customer_id, b.pattern_id 
        ) as qb on FIND_IN_SET( qb.customer_id , a.customer_id) and qb.pattern_id = a.pattern_id
         
        left join (
         select  
         q1.pattern_id,
         q1.customer_id,
         sum(q.closed_mould_qty) as closed_mould_qty 
         from moulding_log_item_info as q
         left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
         where q.`status` = 'Active' and q1.`status` != 'Delete' 
         and q1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
         if(!empty($srch_customer_id)){
            $sql.="and q1.customer_id = '" . $srch_customer_id . "'";
         }
         if(!empty($srch_pattern_id)){
            $sql.="and q1.pattern_id = '" . $srch_pattern_id . "'";
         }
          if(!empty($srch_shift)){
            $sql.="and q1.shift = '" . $srch_shift . "'";
         }
        $sql.="group by q1.pattern_id ,q1.customer_id
        ) as cm on cm.pattern_id = a.pattern_id and FIND_IN_SET( cm.customer_id , a.customer_id)  
        
        left join customer_info as p6 on FIND_IN_SET( p6.customer_id , a.customer_id)  
        where a.`status` = 'Active'    
            group by a.pattern_id , a.customer_id 
            order by customer , pattern_item 
        )  as z  
    where z.curr_produced_qty > 0  or z.curr_rejection_qty > 0 ";
    /*if(!empty($srch_more_than)){
        echo $sql.=" and (z.curr_rejection_qty * 100 / z.curr_produced_qty ) >= '" . $srch_more_than . "'";
    } */
    
    $sql.=" group by  z.customer_id , pattern_id
            order by z.customer, z.pattern_item  
        ";
        
        $query = $this->db->query($sql); 
         
        $tot_prod_wt = $tot_rej_wt = 0;
        $tot_prod_qty = $tot_rej_qty = 0;
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;  
            
            $tot_prod_qty += $row['produced_qty'];       
            $tot_prod_wt += $row['prod_wt'];       
            $tot_rej_qty += $row['rejection_qty'];       
            $tot_rej_wt += $row['rej_wt'];       
        }
        
        $data['tot_prod_qty'] = $tot_prod_qty ;
        $data['tot_rej_qty'] = $tot_rej_qty ;
        
        $data['tot_prod_wt'] = $tot_prod_wt ;
        $data['tot_rej_wt'] = $tot_rej_wt ;
        
        
        
        $sql = "  
                select 
                z.rejection_group , 
                z.rejection_type_id   ,
                z.rejection_type_name,
                sum(z.rej_qty) as rej_qty,
                sum(z.rej_wt) as rej_wt
                from (         
               
                    select
                    a.work_planning_id,  
                    b.rejection_group, 
                    b.rejection_type_id,
					c1.rejection_type_name,
                    sum(b.rejection_qty) as rej_qty ,
                    round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
                    from work_planning_info as a
                    left join pattern_info as d on d.pattern_id = a.pattern_id
                    left join customer_info as c on c.customer_id = a.customer_id
                    left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                    where  a.`status` != 'Delete' and a.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                     if(!empty($srch_customer_id) ){
                        $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                     }
                     if(!empty($srch_pattern_id)){
                        $sql.="and a.pattern_id = '" . $srch_pattern_id . "'";
                     }
                     if(!empty($srch_rej_grp) ){
                          $sql.=" and b.rejection_group = '". $srch_rej_grp ."'";
                     }
                     if(!empty($srch_rej_type_id) ){
                          $sql.=" and b.rejection_type_id = '". $srch_rej_type_id ."'";
                     }
                     if(!empty($srch_shift)){
                        $sql.="and a.shift = '" . $srch_shift . "'";
                     }
                    $sql.="  and b.rejection_type_id != '' and b.rejection_type_id != '32'
                    group by a.work_planning_id, b.rejection_group , b.rejection_type_id 
                    order by a.planning_date asc, c.company_name, d.pattern_item asc  
                    ) as z
                    group by z.rejection_group , z.rejection_type_id           
        "; 	 
        
        
        $query = $this->db->query($sql); 
          
        $data['rej_group'] = array();
        $data['rej_type_group'] = array();
        
         $tot_rej_wt1 = 0;
       
        foreach ($query->result_array() as $row)
        {
            $data['rej_group'][$row['rejection_group']]['qty'][]= $row['rej_qty'];       
            $data['rej_group'][$row['rejection_group']]['wt'][]= $row['rej_wt'];   
            $tot_rej_wt1 += $row['rej_wt'];   
            
            $data['rej_type_group'][$row['rejection_group']][$row['rejection_type_name']]['qty'][]= $row['rej_qty'];      
            $data['rej_type_group'][$row['rejection_group']][$row['rejection_type_name']]['wt'][]= $row['rej_wt'];      
        }
        
       $data['tot_rej_wt1'] = $tot_rej_wt1;
        
        
         //echo "<pre>";
         //print_r($sql);   
        //print_r($data['rej_group']);   
         //print_r($data['rej_type_group']);   
        
        //echo "</pre>"; 
        
        //echo array_sum($data['rej_group']['Moulding']['qty']);
        
        
        }
        
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'TC'
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
         
         
         
        $this->load->view('page/chart/internal-rejection-dept-wt', $data);
    }
    
    
    public function chart_internal_rejection_based($typ)
    {
        $data['js'] = 'chart/internal-rejection-based.inc';
        
        $data['submit_flg'] = false;
        $data['type'] = $typ;
        
        //echo (fmod($typ, 2));
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
        } else {
            $data['srch_from_date'] = $srch_from_date = '';
            $data['srch_to_date'] = $srch_to_date = ''; 
        }
        
        
        if(isset($_POST['srch_customer_id'])) {
            $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
        } else {
            $data['srch_customer_id'] = $srch_customer_id = '';
        }
        
        if(isset($_POST['srch_pattern_id'])) {
        $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
        } else {
            $data['srch_pattern_id'] = $srch_pattern_id = '';
        }
        
        if(isset($_POST['srch_more_than'])) {
        $data['srch_more_than'] = $srch_more_than = $this->input->post('srch_more_than'); 
        } else {
            $data['srch_more_than'] = $srch_more_than = '';
        }
        
        if(isset($_POST['srch_shift'])) {
        $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift');
        } else {
            $data['srch_shift'] = $srch_shift = '';
        }
        
        if(isset($_POST['srch_rej_grp'])) {
        $data['srch_rej_grp'] = $srch_rej_grp = $this->input->post('srch_rej_grp');
        } else {
            $data['srch_rej_grp'] = $srch_rej_grp = '3';
        }
        
        if(isset($_POST['srch_rej_type_id'])) {
        $data['srch_rej_type_id'] = $srch_rej_type_id = $this->input->post('srch_rej_type_id');
        } else {
            $data['srch_rej_type_id'] = $srch_rej_type_id = '';
        }
        
        
        $where= " and 1=1 "; 
       
       if(!empty($srch_from_date)){
       // $where .= " and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'"; 
        $data['submit_flg'] = true;
        }  
       
       if(!empty($srch_customer_id)){
       // $where .= " and a3.customer_id= '" . $srch_customer_id . "'";   
        
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
        
         $data['pattern_opt'] =array();
         
         $data['rejection_typ_opt'] =array(); 
         
        
        
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
            $data['rejection_typ_opt'] =array();
           
            foreach ($query->result_array() as $row)
            {
                $data['rejection_typ_opt'][$row['rejection_type_id']] =  $row['rejection_type_name']   ;     
            }
        } else {
            $data['rejection_typ_opt'] =array();
        }   
            
            
            
        
       /* $sql ="
            select   
            d.pattern_item as item, 
            sum(a.rejection_qty) as rejection_qty,
            d.piece_weight_per_kg,
            round((sum(a.rejection_qty) * d.piece_weight_per_kg),3) as weight
            from qc_inspection_info as a
            left join work_planning_info as b on b.work_planning_id = a.work_planning_id
            left join customer_info as c on c.customer_id = b.customer_id
            left join pattern_info as d on d.pattern_id = b.pattern_id
            where a.`status` != 'Delete'  and b.`status` != 'Delete' and a.rejection_type_id != '32'
            $where 
            group by b.customer_id, b.pattern_id 
            order by d.pattern_item asc 
        "; 
        
       $sql ="
        select 
        w.pattern_item as item,
        q.pattern_id,
        q.customer_id,
        sum(q.produced_qty) as produced_qty,
        round((sum(q.produced_qty) * w.piece_weight_per_kg),3) as prod_wt,
        sum(q.rejection_qty) as rejection_qty,
        round((sum(q.rejection_qty) * w.piece_weight_per_kg),3) as rej_wt
        from (
            select 
            a2.work_planning_id,
            a3.customer_id,
            a3.pattern_id, 
            (sum(ifnull(a2.produced_qty,0)) + sum(ifnull(a4.produced_qty,0)) -  sum(ifnull(a7.closed_mould_qty,0))) as produced_qty ,
            ifnull(a5.rejection_qty,0) as rejection_qty
            from melting_heat_log_info as a1
            left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
            left join melting_child_item_info as a4 on a4.melting_heat_log_id = a2.melting_heat_log_id 
            left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
            left join moulding_log_item_info as a7 on a7.work_planning_id = a2.work_planning_id
            left join ( select w.work_planning_id , sum(w.rejection_qty) as rejection_qty  from qc_inspection_info as w where w.`status` = 'Active' and w.rejection_type_id != '32' group by w.work_planning_id ) as a5 on a5.work_planning_id = a2.work_planning_id
            where a1.`status` = 'Active' and a3.`status` != 'Delete' 
            $where
            group by a2.work_planning_id , a3.customer_id, a3.pattern_id 
            order by a3.customer_id, a3.pattern_id 
        ) as q
        left join pattern_info as w on w.pattern_id = q.pattern_id
        group by q.pattern_id 
        order by w.pattern_item asc
        
        ";
        
        $query = $this->db->query($sql); 
         
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;        
        } */
        
        
        $sql ="
        select 
            z.customer,
            z.pattern_item as item, 
            z.curr_produced_qty as produced_qty,
            z.curr_rejection_qty as rejection_qty,
            round((z.curr_produced_qty * z.piece_weight_per_kg),3) as prod_wt,
            round((z.curr_rejection_qty * z.piece_weight_per_kg),3) as rej_wt 
            from (
            
            select 
            a.customer_id,
            a.pattern_id,
            a.pattern_item, 
            GROUP_CONCAT( p6.company_name) as customer,
            a.piece_weight_per_kg, 
            (ifnull(qa.curr_produced_qty,0) - ifnull(cm.closed_mould_qty,0)) as curr_produced_qty,
            ifnull(qb.curr_rejection_qty,0) as curr_rejection_qty 
            from pattern_info as a  
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
                where a1.`status` = 'Active' and a3.`status` != 'Delete' 
                and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
                 if(!empty($srch_customer_id)){
                    $sql.="and a3.customer_id = '" . $srch_customer_id . "'";
                 }
                 if(!empty($srch_pattern_id)){
                    $sql.="and a3.pattern_id = '" . $srch_pattern_id . "'";
                 }
                 if(!empty($srch_shift)){
                    $sql.="and a3.shift = '" . $srch_shift . "'";
                 }
                 
                $sql.="group by a3.customer_id, a3.pattern_id 
                order by a3.customer_id, a3.pattern_id 
                ) union all (
                select 
                a3.customer_id,
                a3.pattern_id, 
                sum((a2.produced_qty)) as curr_produced_qty
                from melting_heat_log_info as a1
                left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' 
                and a1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
                 if(!empty($srch_customer_id)){
                    $sql.="and a3.customer_id = '" . $srch_customer_id . "'";
                 }
                 if(!empty($srch_pattern_id)){
                    $sql.="and a3.pattern_id = '" . $srch_pattern_id . "'";
                 }
                  if(!empty($srch_shift)){
                    $sql.="and a3.shift = '" . $srch_shift . "'";
                 }
                $sql.="group by a3.customer_id, a3.pattern_id 
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
            where a.status = 'Active' and b.status != 'Delete' and a.rejection_type_id != '32' 
            and b.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
             if(!empty($srch_customer_id)){
                $sql.="and b.customer_id = '" . $srch_customer_id . "'";
             }
             if(!empty($srch_pattern_id)){
                $sql.="and b.pattern_id = '" . $srch_pattern_id . "'";
             }
             if(!empty($srch_rej_grp) ){
                  $sql.=" and a.rejection_group = '". $srch_rej_grp ."'";
             }
             if(!empty($srch_rej_type_id) ){
                  $sql.=" and a.rejection_type_id = '". $srch_rej_type_id ."'";
             }
             if(!empty($srch_shift)){
                $sql.="and b.shift = '" . $srch_shift . "'";
             }
            $sql.="group by b.customer_id, b.pattern_id 
        ) as qb on FIND_IN_SET( qb.customer_id , a.customer_id) and qb.pattern_id = a.pattern_id
         
        left join (
         select  
         q1.pattern_id,
         q1.customer_id,
         sum(q.closed_mould_qty) as closed_mould_qty 
         from moulding_log_item_info as q
         left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
         where q.`status` = 'Active' and q1.`status` != 'Delete' 
         and q1.planning_date between '" . $srch_from_date . "' and '" . $srch_to_date . "'";
         if(!empty($srch_customer_id)){
            $sql.="and q1.customer_id = '" . $srch_customer_id . "'";
         }
         if(!empty($srch_pattern_id)){
            $sql.="and q1.pattern_id = '" . $srch_pattern_id . "'";
         }
          if(!empty($srch_shift)){
            $sql.="and q1.shift = '" . $srch_shift . "'";
         }
        $sql.="group by q1.pattern_id ,q1.customer_id
        ) as cm on cm.pattern_id = a.pattern_id and FIND_IN_SET( cm.customer_id , a.customer_id)  
        
        left join customer_info as p6 on FIND_IN_SET( p6.customer_id , a.customer_id)  
        where a.`status` = 'Active'    
            group by a.pattern_id , a.customer_id 
            order by customer , pattern_item 
        )  as z  
    where z.curr_produced_qty > 0  or z.curr_rejection_qty > 0 ";
    /*if(!empty($srch_more_than)){
        echo $sql.=" and (z.curr_rejection_qty * 100 / z.curr_produced_qty ) >= '" . $srch_more_than . "'";
    } */
    
    $sql.=" group by  z.customer_id , pattern_id
            order by z.customer, z.pattern_item  
        ";
        
        $query = $this->db->query($sql); 
         
        $tot_prod_wt = $tot_rej_wt = 0;
        $tot_prod_qty = $tot_rej_qty = 0;
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;  
            
            $tot_prod_qty += $row['produced_qty'];       
            $tot_prod_wt += $row['prod_wt'];       
            $tot_rej_qty += $row['rejection_qty'];       
            $tot_rej_wt += $row['rej_wt'];       
        }
        
        $data['tot_prod_qty'] = $tot_prod_qty ;
        $data['tot_rej_qty'] = $tot_rej_qty ;
        
        $data['tot_prod_wt'] = $tot_prod_wt ;
        $data['tot_rej_wt'] = $tot_rej_wt ;
        
        
        
        $sql = "  
                select 
                z.rejection_group , 
                z.rejection_type_id   ,
                z.rejection_type_name,
                sum(z.rej_qty) as rej_qty,
                sum(z.rej_wt) as rej_wt
                from (         
               
                    select
                    a.work_planning_id,  
                    b.rejection_group, 
                    b.rejection_type_id,
					c1.rejection_type_name,
                    sum(b.rejection_qty) as rej_qty ,
                    round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
                    from work_planning_info as a
                    left join pattern_info as d on d.pattern_id = a.pattern_id
                    left join customer_info as c on c.customer_id = a.customer_id
                    left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                    where  a.`status` != 'Delete' and a.planning_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
                     if(!empty($srch_customer_id) ){
                        $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                     }
                     if(!empty($srch_pattern_id)){
                        $sql.="and a.pattern_id = '" . $srch_pattern_id . "'";
                     }
                     if(!empty($srch_rej_grp) ){
                          $sql.=" and b.rejection_group = '". $srch_rej_grp ."'";
                     }
                     if(!empty($srch_rej_type_id) ){
                          $sql.=" and b.rejection_type_id = '". $srch_rej_type_id ."'";
                     }
                     if(!empty($srch_shift)){
                        $sql.="and a.shift = '" . $srch_shift . "'";
                     }
                    $sql.="  and b.rejection_type_id != '' and b.rejection_type_id != '32'
                    group by a.work_planning_id, b.rejection_group , b.rejection_type_id 
                    order by a.planning_date asc, c.company_name, d.pattern_item asc  
                    ) as z
                    group by z.rejection_group , z.rejection_type_id           
        "; 	 
        
        
        $query = $this->db->query($sql); 
          
        $data['rej_group'] = array();
        $data['rej_type_group'] = array();
        
         $tot_rej_wt1 = 0;
       
        foreach ($query->result_array() as $row)
        {
            $data['rej_group'][$row['rejection_group']]['qty'][]= $row['rej_qty'];       
            $data['rej_group'][$row['rejection_group']]['wt'][]= $row['rej_wt'];   
            $tot_rej_wt1 += $row['rej_wt'];   
            
            $data['rej_type_group'][$row['rejection_group']][$row['rejection_type_name']]['qty'][]= $row['rej_qty'];      
            $data['rej_type_group'][$row['rejection_group']][$row['rejection_type_name']]['wt'][]= $row['rej_wt'];      
        }
        
       $data['tot_rej_wt1'] = $tot_rej_wt1;
        
        
         //echo "<pre>";
         //print_r($sql);   
        //print_r($data['rej_group']);   
         //print_r($data['rej_type_group']);   
        
        //echo "</pre>"; 
        
        //echo array_sum($data['rej_group']['Moulding']['qty']);
        
        
        }
        
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'TC'
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
         
        
        
         
        $this->load->view('page/chart/internal-rejection-based', $data);
    }
    
     
    
    
    public function mrm_report(){
        
        $limit = 12;
        
        $data['js'] = 'chart/mrm.inc';
        
        
        $sql = "
                select 
                a.*
                from mrm_target_info as a 
                where status = 'Active'
                order by a.sno asc  
        ";
        
        
        
        $query = $this->db->query($sql);
        
        $data['mrm_target'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['mrm_target'][$row['sno']] = $row;     
        }
        
        
        $sql = "  
                select 
                DATE_FORMAT(b.planning_date,'%Y%m') as num_month,
                DATE_FORMAT(b.planning_date,'%b-%Y') as al_month,
                sum(a.produced_box) as produced_box
                from moulding_log_item_info as a 
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                where b.`status` != 'Delete' and a.`status` != 'Delete' 
                group by DATE_FORMAT(b.planning_date,'%Y-%m')  
                order by DATE_FORMAT(b.planning_date,'%Y%m') desc
                limit $limit    
             
        ";
        $query = $this->db->query($sql); 

        foreach($query->result_array() as $row)
        {    
            $data['moulding'][]  = $row;      
        } 
        
        /*$sql ="
        select 
            DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
            DATE_FORMAT(z.planning_date,'%M-%Y') as al_month, 
            round(sum(z.liquid_metal),2) as liquid_metal ,
            round(sum(z.poured_casting_wt),2) as poured_casting_wt,
            round((round(sum(z.liquid_metal),2) * 100 / round(sum(z.poured_casting_wt),2)),2) as yield
            from (
            select  
            a.planning_date, 
            b.work_planning_id,
            d.pattern_item as item,  
            sum(b.pouring_box) as pouring_box,
            d.bunch_weight,
            (sum(b.pouring_box) * d.bunch_weight) as liquid_metal,
            (d.casting_weight * sum(b.pouring_box) * d.piece_weight_per_kg) as poured_casting_wt
            from melting_heat_log_info as a  
            left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
            left join work_planning_info as c on c.work_planning_id = b.work_planning_id
            left join pattern_info as d on d.pattern_id = c.pattern_id
            where a.`status` = 'Active' and c.`status` != 'Delete'  
            group by a.planning_date ,b.work_planning_id, c.pattern_id 
            order by a.planning_date desc
            ) as z 
            group by DATE_FORMAT(z.planning_date,'%Y-%m')  
            order by DATE_FORMAT(z.planning_date,'%Y%m') desc
            limit 5
        "; */
        
        $sql ="
        select 
        DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
        DATE_FORMAT(z.planning_date,'%b-%Y') as al_month, 
        round(sum(z.liq_metal1),2) as liquid_metal ,
        round(sum(z.poured_casting_wt),2) as poured_casting_wt,
        round((round(sum(z.poured_casting_wt),2) * 100 / round(sum(z.liq_metal1),2)),2) as yield 
        from (
        select 
        a.planning_date,
        a.melting_heat_log_id, 
        b.work_planning_id,
        d.company_name as customer,
        e.pattern_item as item, 
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
        order by a.planning_date 
        ) as z
        group by DATE_FORMAT(z.planning_date,'%Y-%m')  
        order by DATE_FORMAT(z.planning_date,'%Y%m') desc
        limit $limit
        ";
        
        $query = $this->db->query($sql); 

        foreach($query->result_array() as $row)
        {    
            $data['melting'][]  = $row;      
        } 
        
        	 
        
       /* $sql ="
        select  
        DATE_FORMAT(a.planning_date,'%Y%m') as num_month,
        DATE_FORMAT(a.planning_date,'%M-%Y') as al_month, 
        sum(b.rejection_qty) as rej_qty ,
        round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
        from work_planning_info as a
        left join pattern_info as d on d.pattern_id = a.pattern_id 
        left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
        where  a.`status` != 'Delete' 
        and b.rejection_type_id != '' and b.rejection_type_id != '32' 
        group by  DATE_FORMAT(a.planning_date,'%Y-%m')  
        order by  DATE_FORMAT(a.planning_date,'%Y%m') desc  
        limit 5
        "; */
        
        $sql = "  
                select 
                DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                DATE_FORMAT(z.planning_date,'%b-%Y') as al_month, 
                sum(z.rej_qty) as rej_qty,
                sum(z.rej_wt) as rej_wt
                from (         
               
                    select
                    a.work_planning_id, 
                    a.planning_date, 
                    b.rejection_group, 
                    b.rejection_type_id,
					c1.rejection_type_name,
                    sum(b.rejection_qty) as rej_qty ,
                    round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
                    from work_planning_info as a
                    left join pattern_info as d on d.pattern_id = a.pattern_id
                    left join customer_info as c on c.customer_id = a.customer_id
                    left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                    where  a.`status` != 'Delete'   and b.rejection_type_id != '' and b.rejection_type_id != '32'
                    group by a.work_planning_id, b.rejection_group , b.rejection_type_id 
                    order by a.planning_date asc, c.company_name, d.pattern_item asc  
                    ) as z
                    group by DATE_FORMAT(z.planning_date,'%Y-%m')  
                    order by  DATE_FORMAT(z.planning_date,'%Y%m') desc  
                    limit $limit       
        "; 
        
        $query = $this->db->query($sql); 

        foreach($query->result_array() as $row)
        {    
            $data['rejection'][]  = $row;      
        }
        
        
        
         $sql = "  
                select 
                DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                DATE_FORMAT(z.planning_date,'%b-%Y') as al_month, 
                sum(z.rej_qty) as rej_qty,
                sum(z.rej_wt) as rej_wt
                from (         
               
                    select
                    a.work_planning_id, 
                    a.planning_date, 
                    b.rejection_group, 
                    b.rejection_type_id,
					c1.rejection_type_name,
                    sum(b.rejection_qty) as rej_qty ,
                    round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
                    from work_planning_info as a
                    left join pattern_info as d on d.pattern_id = a.pattern_id
                    left join customer_info as c on c.customer_id = a.customer_id
                    left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                    where  a.`status` != 'Delete'   and b.rejection_type_id != '' and b.rejection_type_id != '32'
                    and b.rejection_group  = 'Fettling' 
                    group by a.work_planning_id, b.rejection_group , b.rejection_type_id 
                    order by a.planning_date asc, c.company_name, d.pattern_item asc  
                    ) as z
                    group by DATE_FORMAT(z.planning_date,'%Y-%m')  
                    order by  DATE_FORMAT(z.planning_date,'%Y%m') desc  
                    limit $limit       
        "; 
        
        $query = $this->db->query($sql); 

        foreach($query->result_array() as $row)
        {    
            $data['fettling_rej'][]  = $row;      
        } 
        
        
        
        $sql = "  
                select 
                DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                DATE_FORMAT(z.planning_date,'%b-%Y') as al_month, 
                sum(z.rej_qty) as rej_qty,
                sum(z.rej_wt) as rej_wt
                from (         
               
                    select
                    a.work_planning_id, 
                    a.planning_date, 
                    b.rejection_group, 
                    b.rejection_type_id,
					c1.rejection_type_name,
                    sum(b.rejection_qty) as rej_qty ,
                    round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
                    from work_planning_info as a
                    left join pattern_info as d on d.pattern_id = a.pattern_id
                    left join customer_info as c on c.customer_id = a.customer_id
                    left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                    where  a.`status` != 'Delete'   and b.rejection_type_id != '' and b.rejection_type_id != '32'
                    and b.rejection_group  = 'Melting' 
                    group by a.work_planning_id, b.rejection_group , b.rejection_type_id 
                    order by a.planning_date asc, c.company_name, d.pattern_item asc  
                    ) as z
                    group by DATE_FORMAT(z.planning_date,'%Y-%m')  
                    order by  DATE_FORMAT(z.planning_date,'%Y%m') desc  
                    limit $limit       
        "; 
        
        $query = $this->db->query($sql); 

        foreach($query->result_array() as $row)
        {    
            $data['melting_rej'][]  = $row;      
        } 
        
        
        
        $sql = "  
                select 
                DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                DATE_FORMAT(z.planning_date,'%b-%Y') as al_month, 
                sum(z.rej_qty) as rej_qty,
                sum(z.rej_wt) as rej_wt
                from (         
               
                    select
                    a.work_planning_id, 
                    a.planning_date, 
                    b.rejection_group, 
                    b.rejection_type_id,
					c1.rejection_type_name,
                    sum(b.rejection_qty) as rej_qty ,
                    round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
                    from work_planning_info as a
                    left join pattern_info as d on d.pattern_id = a.pattern_id
                    left join customer_info as c on c.customer_id = a.customer_id
                    left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                    where  a.`status` != 'Delete'   and b.rejection_type_id != '' and b.rejection_type_id != '32'
                    and b.rejection_group  = 'Moulding' 
                    group by a.work_planning_id, b.rejection_group , b.rejection_type_id 
                    order by a.planning_date asc, c.company_name, d.pattern_item asc  
                    ) as z
                    group by DATE_FORMAT(z.planning_date,'%Y-%m')  
                    order by  DATE_FORMAT(z.planning_date,'%Y%m') desc  
                    limit $limit       
        "; 
        
        $query = $this->db->query($sql); 

        foreach($query->result_array() as $row)
        {    
            $data['moulding_rej'][]  = $row;      
        } 
        
        
        $sql ="
        select 
        u.num_month,
        u.al_month,
        sum(u.prod_wt) as prod_wt,
        sum(u.rej_wt) as rej_wt 
        from 
        (
        
                select 
                    DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                    DATE_FORMAT(z.planning_date,'%b-%Y') as al_month, 
                    z.customer,
                    z.pattern_item as item, 
                    z.curr_produced_qty as produced_qty,
                    z.curr_rejection_qty as rejection_qty,
                    round((z.curr_produced_qty * z.piece_weight_per_kg),3) as prod_wt,
                    round((z.curr_rejection_qty * z.piece_weight_per_kg),3) as rej_wt 
                    from (
                    
                    select 
                    a.customer_id,
                    a.pattern_id,
                    a.pattern_item, 
                    GROUP_CONCAT( p6.company_name) as customer,
                    a.piece_weight_per_kg, 
                    (ifnull(qa.curr_produced_qty,0) - ifnull(cm.closed_mould_qty,0)) as curr_produced_qty,
                    ifnull(qb.curr_rejection_qty,0) as curr_rejection_qty 
                    from pattern_info as a  
                    left join (
                    select
                    w.customer_id,
                    w.pattern_id, 
                    w.planning_date,
                    sum(w.curr_produced_qty) as curr_produced_qty
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
                        where a1.`status` = 'Active' and a3.`status` != 'Delete'  
                        group by a3.customer_id, a3.pattern_id ,a1.planning_date
                        order by a3.customer_id, a3.pattern_id 
                        ) union all (
                        select 
                        a3.customer_id,
                        a3.pattern_id, 
                        a1.planning_date,
                        sum((a2.produced_qty)) as curr_produced_qty
                        from melting_heat_log_info as a1
                        left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                        left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                        where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' 
                        group by a3.customer_id, a3.pattern_id ,a1.planning_date
                        order by a3.customer_id, a3.pattern_id
                        )
                    ) as w where 1 group by w.customer_id,w.pattern_id , w.planning_date
                ) as qa on FIND_IN_SET( qa.customer_id , a.customer_id)  and qa.pattern_id = a.pattern_id
                left join (
                    select 
                    b.customer_id,
                    b.pattern_id,
                    b.planning_date 
                    sum(a.rejection_qty) as curr_rejection_qty 
                    from qc_inspection_info as a
                    left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                    where a.status = 'Active' and b.status != 'Delete' and a.rejection_type_id != '32' 
                    group by b.customer_id, b.pattern_id, b.planning_date 
                ) as qb on FIND_IN_SET( qb.customer_id , a.customer_id) and qb.pattern_id = a.pattern_id
                 
                left join (
                 select  
                 q1.pattern_id,
                 q1.customer_id,
                 q1.planning_date,
                 sum(q.closed_mould_qty) as closed_mould_qty 
                 from moulding_log_item_info as q
                 left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
                 where q.`status` = 'Active' and q1.`status` != 'Delete' 
                 group by q1.customer_id, q1.pattern_id ,q1.planning_date
                ) as cm on cm.pattern_id = a.pattern_id and FIND_IN_SET( cm.customer_id , a.customer_id)  
                
                left join customer_info as p6 on FIND_IN_SET( p6.customer_id , a.customer_id)  
                where a.`status` = 'Active'    
                    group by a.pattern_id , a.customer_id 
                    order by customer , pattern_item 
                )  as z  
            where z.curr_produced_qty > 0  or z.curr_rejection_qty > 0  
            group by  z.customer_id , z.pattern_id , DATE_FORMAT(z.planning_date,'%Y-%m') 
            order by z.customer, z.pattern_item 
        ) as u
        group by u.num_month 
        order by u.num_month desc
        limit 5
        ";
        
        
        $sql = "
        select  
        DATE_FORMAT(q.planning_date,'%Y%m') as num_month,
        DATE_FORMAT(q.planning_date,'%b-%Y') as al_month, 
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
          where a1.`status` = 'Active' and a3.`status` != 'Delete'   
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
          where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != ''   
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
                     where q.`status` = 'Active' and q1.`status` != 'Delete'  
                     group by q1.customer_id, q1.pattern_id , q1.planning_date
                    ) as cm on cm.pattern_id = w.pattern_id and cm.customer_id = w.customer_id and cm.planning_date = w.planning_date
        left join pattern_info as r on r.pattern_id = w.pattern_id             
        where 1 
        group by w.customer_id,w.pattern_id , w.planning_date   
        ) as q
        group by DATE_FORMAT(q.planning_date,'%Y-%m')   
        limit $limit  
        ";
        
        $query = $this->db->query($sql); 

        foreach($query->result_array() as $row)
        {    
            $data['production'][]  = $row;      
        } 
        
        $sql = "
        select  
        DATE_FORMAT(a.planning_date,'%Y%m') as num_month,
        DATE_FORMAT(a.planning_date,'%b-%Y') as al_month, 
        sum(a.end_units - a.start_units) as unit
        from melting_heat_log_info as a
        where a.status = 'Active'
        group by DATE_FORMAT(a.planning_date,'%Y-%m')
        order by DATE_FORMAT(a.planning_date,'%Y%m') desc
        limit $limit
        
        ";
        
        $query = $this->db->query($sql); 

        foreach($query->result_array() as $row)
        {    
            $data['power'][]  = $row;      
        } 
        
        $sql = "
        select    
        DATE_FORMAT(a.despatch_date,'%Y%m') as num_month,
        DATE_FORMAT(a.despatch_date,'%b-%Y') as al_month, 
        round(sum(b.qty * e.piece_weight_per_kg),3) as despatch_wt
        from customer_despatch_info as a 
        left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
        left join pattern_info as e on e.pattern_id = b.pattern_id
        where a.`status` = 'Active'  
        group by DATE_FORMAT(a.despatch_date,'%Y-%m')  
        order by DATE_FORMAT(a.despatch_date,'%Y%m') desc 
        limit $limit
        
        ";
        $query = $this->db->query($sql); 

        foreach($query->result_array() as $row)
        {    
            $data['despatch'][]  = $row;      
        } 
        
       /* echo "<pre>";
        print_r($data);
        echo "</pre>"; */
        
        $this->load->view('page/chart/mrm-report', $data);
        
    }
    
    public function mrm_report_v2(){
        
        $limit = 12;
        
        $data['js'] = 'chart/mrm-v2.inc';
        $data['submit_flg'] = false; 
       
       
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
           $data['submit_flg'] = true; 
        } else {
            $data['srch_from_date'] = $srch_from_date = '';
            $data['srch_to_date'] = $srch_to_date = ''; 
        }
        
        
        if(isset($_POST['srch_opt_type'])) {
            $data['srch_opt_type'] = $srch_opt_type = $this->input->post('srch_opt_type'); 
            $data['submit_flg'] = true; 
        } else {
            $data['srch_opt_type'] = $srch_opt_type = '';
        }  
        
      // echo $srch_opt_type; 
        
        
       $sql = "
                select 
                a.* 
                from mrm_target_type_info as a 
                where a.status='Active' 
                order by a.sno asc  
        ";
        
        
        
        $query = $this->db->query($sql);
        
        $data['mrm_list'] = array(); 
       
        foreach ($query->result_array() as $row)
        {
            $data['mrm_list'][$row['mrm_target_type_name']] = $row['mrm_target_type_name'];        
        }
       
       if($data['submit_flg']) { 
        
            
            
            
            $sql ="
                select 
                 a.grp_id,
                 a.frm_date,
                 a.to_date,
                 a.sno,
                 a.mrm_target_name,
                 a.mrm_target_value,
                 a.`status`
                from mrm_target_info as a 
                where  a.mrm_target_name = '". $srch_opt_type ."'
                and ( DATE_FORMAT(a.frm_date,'%Y-%m') between '". $srch_from_date ."' and '". $srch_to_date ."'  || 
                DATE_FORMAT(a.to_date,'%Y-%m') between  '". $srch_from_date ."' and '". $srch_to_date ."' )
                group by a.grp_id 
                order by a.sno asc  
            ";
            
            
            
            $query = $this->db->query($sql);
            
            $data['mrm_target'] = array();
            $data['chart_data'] = array();
            $data['actual_data'] = array();
            $data['target_data'] = array();
           
            foreach ($query->result_array() as $row)
            {
                $data['mrm_target'][$row['grp_id']] = $row;    
                $data['target_data'][] = $row['mrm_target_value'];    
                
                if($srch_opt_type == 'Total Box Produced')
                {
                    
                     $sql = "  
                            select 
                            DATE_FORMAT(b.planning_date,'%Y%m') as num_month,
                            DATE_FORMAT(b.planning_date,'%b-%Y') as al_month,
                            sum(a.produced_box) as actual_value
                            from moulding_log_item_info as a 
                            left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                            where b.`status` != 'Delete' and a.`status` != 'Delete' 
                            and b.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'  
                            group by DATE_FORMAT(b.planning_date,'%Y-%m')  
                            order by DATE_FORMAT(b.planning_date,'%Y%m') asc 
                         
                    ";
                     
                }
                
                if($srch_opt_type == 'Total Metal Produced <i class="text-sm">in Tons</i>'){
                  
                   $sql = "  
                             select 
                                DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                                DATE_FORMAT(z.planning_date,'%b-%Y') as al_month, 
                                round((sum(z.liq_metal1)/1000),2) as actual_value 
                                from (
                                select 
                                a.planning_date,
                                a.melting_heat_log_id, 
                                b.work_planning_id,
                                d.company_name as customer,
                                e.pattern_item as item, 
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
                                and a.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                                order by a.planning_date 
                                ) as z
                                group by DATE_FORMAT(z.planning_date,'%Y-%m')  
                                order by DATE_FORMAT(z.planning_date,'%Y%m') asc 
                    ";
                    
                    
                    
                } 
                
                if($srch_opt_type == 'Poured Casting <i class="text-sm">in Tons</i>'){
                  
                  $sql = "  
                             select 
                                DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                                DATE_FORMAT(z.planning_date,'%b-%Y') as al_month,  
                                round((sum(z.poured_casting_wt)/1000),2) as actual_value 
                                from (
                                select 
                                a.planning_date,
                                a.melting_heat_log_id, 
                                b.work_planning_id,
                                d.company_name as customer,
                                e.pattern_item as item, 
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
                                and a.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                                order by a.planning_date 
                                ) as z
                                group by DATE_FORMAT(z.planning_date,'%Y-%m')  
                                order by DATE_FORMAT(z.planning_date,'%Y%m') asc 
                    ";
                     
              } 
              
              if($srch_opt_type == 'Total Good Casting <i class="text-sm">in Tons</i>'){
              
                $sql = "  
                    select 
                    m.num_month, 
                    m.al_month, 
                    (sum(m.poured_casting_wt) -  sum(m.rej_wt))  as actual_value 
                    from 
                    (
                        (  
                                select 
                                DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                                DATE_FORMAT(z.planning_date,'%b-%Y') as al_month,  
                                round((sum(z.poured_casting_wt)/1000),3) as poured_casting_wt ,
                                0 as rej_wt
                                from (
                                select 
                                a.planning_date,
                                a.melting_heat_log_id, 
                                b.work_planning_id,
                                d.company_name as customer,
                                e.pattern_item as item, 
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
                                and a.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                                order by a.planning_date 
                                ) as z
                                group by DATE_FORMAT(z.planning_date,'%Y-%m')  
                                order by DATE_FORMAT(z.planning_date,'%Y%m') asc 
                         ) union all (
                            
                            select  
                        z.num_mon as num_month,
                        z.alp_mon as al_month, 
                        0 as poured_casting_wt, 
                        round((sum(z.rej_wt)/1000),3) as rej_wt
                        from (  
                            
                            select  
                            DATE_FORMAT(b.planning_date,'%Y%m')  as num_mon,
                            DATE_FORMAT(b.planning_date,'%b-%Y')  as alp_mon,
                            b.pattern_id,
                            sum(a.rejection_qty) as rej_qty,
                            round((sum(a.rejection_qty) * c.piece_weight_per_kg),2) as rej_wt 
                            from qc_inspection_info as a
                            left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                            left join pattern_info as c on c.pattern_id =b.pattern_id
                            where a.`status`='Active' and b.`status` = 'Planned' 
                            and b.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                            group by b.pattern_id , DATE_FORMAT(b.planning_date,'%Y%m') 
                            order by b.pattern_id , DATE_FORMAT(b.planning_date,'%Y%m')  
                            ) as z
                            group by z.num_mon  
                            order by  z.alp_mon asc   
                         )  
                    ) as m 
                     group by m.num_month
                     order by m.num_month asc    
                    ";
                     
              
              }
              if($srch_opt_type == 'Yield <i class="text-sm">in %</i>'){
                  
                  $sql = "  
                             select 
                                DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                                DATE_FORMAT(z.planning_date,'%b-%Y') as al_month,  
                                round((round(sum(z.poured_casting_wt),2) * 100 / round(sum(z.liq_metal1),2)),2) as actual_value 
                                from (
                                select 
                                a.planning_date,
                                a.melting_heat_log_id, 
                                b.work_planning_id,
                                d.company_name as customer,
                                e.pattern_item as item, 
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
                                and a.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                                order by a.planning_date 
                                ) as z
                                group by DATE_FORMAT(z.planning_date,'%Y-%m')  
                                order by DATE_FORMAT(z.planning_date,'%Y%m') asc 
                    ";
                     
              } 
              
               if($srch_opt_type == 'Production <i class="text-sm">in Tons</i>'){
                  
                 $sql = "  
                        
                        select  
                        DATE_FORMAT(q.planning_date,'%Y%m') as num_month,
                        DATE_FORMAT(q.planning_date,'%b-%Y') as al_month,  
                        round((sum(q.tot_wt)/1000),3) as actual_value
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
                          where a1.`status` = 'Active' and a3.`status` != 'Delete' 
                          and a1.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'  
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
                          where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' 
                          and a3.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'  
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
                                     where q.`status` = 'Active' and q1.`status` != 'Delete'  
                                     group by q1.customer_id, q1.pattern_id , q1.planning_date
                                    ) as cm on cm.pattern_id = w.pattern_id and cm.customer_id = w.customer_id and cm.planning_date = w.planning_date
                        left join pattern_info as r on r.pattern_id = w.pattern_id             
                        where w.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                        group by w.customer_id,w.pattern_id , w.planning_date   
                        ) as q
                        group by DATE_FORMAT(q.planning_date,'%Y-%m') 
                        order by DATE_FORMAT(q.planning_date,'%Y%m') asc 
                        ";
                     
              }   
              
              
              if($srch_opt_type == 'Rejection <i class="text-sm">in Tons</i>'){
                  
               /*  $sql = "  
                        select 
                        DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                        DATE_FORMAT(z.planning_date,'%b-%Y') as al_month, 
                        sum(z.rej_qty) as rej_qty,
                        round((sum(z.rej_wt)/1000),3) as actual_value
                        from (         
                       
                            select
                            a.work_planning_id, 
                            a.planning_date, 
                            b.rejection_group, 
                            b.rejection_type_id,
        					c1.rejection_type_name,
                            sum(b.rejection_qty) as rej_qty ,
                            round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
                            from work_planning_info as a
                            left join pattern_info as d on d.pattern_id = a.pattern_id
                            left join customer_info as c on c.customer_id = a.customer_id
                            left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
        					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                            where  a.`status` != 'Delete'   and b.rejection_type_id != '' and b.rejection_type_id != '32'
                            and a.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                            group by a.work_planning_id, b.rejection_group , b.rejection_type_id 
                            order by a.planning_date asc, c.company_name, d.pattern_item asc  
                            ) as z
                            group by DATE_FORMAT(z.planning_date,'%Y-%m')  
                            order by  DATE_FORMAT(z.planning_date,'%Y%m') asc  
                            ";
                   */          
                  $sql = "  
                        select  
                        z.num_mon,
                        z.alp_mon as al_month, 
                        sum(z.rej_qty) as rej_qty,
                        round((sum(z.rej_wt)/1000),3) as actual_value
                        from (  
                            
                            select  
                            DATE_FORMAT(b.planning_date,'%Y%m')  as num_mon,
                            DATE_FORMAT(b.planning_date,'%b-%Y')  as alp_mon,
                            b.pattern_id,
                            sum(a.rejection_qty) as rej_qty,
                            round((sum(a.rejection_qty) * c.piece_weight_per_kg),2) as rej_wt 
                            from qc_inspection_info as a
                            left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                            left join pattern_info as c on c.pattern_id =b.pattern_id
                            where a.`status`='Active' and b.`status` = 'Planned' 
                            and b.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                            group by b.pattern_id , DATE_FORMAT(b.planning_date,'%Y%m') 
                            order by b.pattern_id , DATE_FORMAT(b.planning_date,'%Y%m')  
                            ) as z
                            group by z.num_mon  
                            order by  z.num_mon asc  
                            ";           
                             
              } 
              
              if($srch_opt_type == 'Rejection <i class="text-sm">in %</i>'){
                  
                    $sql = "  
                    select 
                    m.num_month, 
                    m.al_month, 
                    round((sum(m.rej_wt) * 100 / sum(m.prod_wt)),2)  as actual_value 
                    from 
                    (
                         (  
                          select  
                            DATE_FORMAT(q.planning_date,'%Y%m') as num_month,
                            DATE_FORMAT(q.planning_date,'%b-%Y') as al_month,  
                            round((sum(q.tot_wt)/1000),3) as prod_wt,
                            0 as rej_wt
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
                              where a1.`status` = 'Active' and a3.`status` != 'Delete' 
                              and a1.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'  
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
                              where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' 
                              and a3.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'  
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
                                         where q.`status` = 'Active' and q1.`status` != 'Delete'  
                                         group by q1.customer_id, q1.pattern_id , q1.planning_date
                                        ) as cm on cm.pattern_id = w.pattern_id and cm.customer_id = w.customer_id and cm.planning_date = w.planning_date
                            left join pattern_info as r on r.pattern_id = w.pattern_id             
                            where w.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                            group by w.customer_id,w.pattern_id , w.planning_date   
                            ) as q
                            group by DATE_FORMAT(q.planning_date,'%Y-%m') 
                            order by DATE_FORMAT(q.planning_date,'%Y%m') asc         
                         ) 
                         union all 
                         (
                        
                            select 
                            DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                            DATE_FORMAT(z.planning_date,'%b-%Y') as al_month, 
                            0 as prod_wt, 
                            round((sum(z.rej_wt)/1000),3) as rej_wt
                            from (         
                           
                                select
                                a.work_planning_id, 
                                a.planning_date, 
                                b.rejection_group, 
                                b.rejection_type_id,
            					c1.rejection_type_name,
                                sum(b.rejection_qty) as rej_qty ,
                                round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
                                from work_planning_info as a
                                left join pattern_info as d on d.pattern_id = a.pattern_id
                                left join customer_info as c on c.customer_id = a.customer_id
                                left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
            					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                                where  a.`status` != 'Delete'   and b.rejection_type_id != '' and b.rejection_type_id != '32'
                                and a.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                                group by a.work_planning_id, b.rejection_group , b.rejection_type_id 
                                order by a.planning_date asc, c.company_name, d.pattern_item asc  
                                ) as z
                                group by DATE_FORMAT(z.planning_date,'%Y-%m')  
                                order by  DATE_FORMAT(z.planning_date,'%Y%m') asc  
                         )  
                    ) as m 
                     group by m.num_month
                     order by m.num_month asc    
                    "; 
                             
                            
              }   
              
              
              if($srch_opt_type == 'Moulding Rejection <i class="text-sm">in %</i>'){
                  
                    $sql = "  
                    select 
                    m.num_month, 
                    m.al_month, 
                    round((sum(m.rej_wt) * 100 / sum(m.prod_wt)),2)  as actual_value 
                    from 
                    (
                         (  
                          select  
                            DATE_FORMAT(q.planning_date,'%Y%m') as num_month,
                            DATE_FORMAT(q.planning_date,'%b-%Y') as al_month,  
                            round((sum(q.tot_wt)/1000),3) as prod_wt,
                            0 as rej_wt
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
                              where a1.`status` = 'Active' and a3.`status` != 'Delete' 
                              and a1.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'  
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
                              where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' 
                              and a3.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'  
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
                                         where q.`status` = 'Active' and q1.`status` != 'Delete'  
                                         group by q1.customer_id, q1.pattern_id , q1.planning_date
                                        ) as cm on cm.pattern_id = w.pattern_id and cm.customer_id = w.customer_id and cm.planning_date = w.planning_date
                            left join pattern_info as r on r.pattern_id = w.pattern_id             
                            where w.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                            group by w.customer_id,w.pattern_id , w.planning_date   
                            ) as q
                            group by DATE_FORMAT(q.planning_date,'%Y-%m') 
                            order by DATE_FORMAT(q.planning_date,'%Y%m') asc         
                         ) 
                         union all 
                         (
                        
                            select 
                            DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                            DATE_FORMAT(z.planning_date,'%b-%Y') as al_month, 
                            0 as prod_wt, 
                            round((sum(z.rej_wt)/1000),3) as rej_wt
                            from (         
                           
                                select
                                a.work_planning_id, 
                                a.planning_date, 
                                b.rejection_group, 
                                b.rejection_type_id,
            					c1.rejection_type_name,
                                sum(b.rejection_qty) as rej_qty ,
                                round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
                                from work_planning_info as a
                                left join pattern_info as d on d.pattern_id = a.pattern_id
                                left join customer_info as c on c.customer_id = a.customer_id
                                left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
            					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                                where  a.`status` != 'Delete'   and b.rejection_type_id != '' and b.rejection_type_id != '32'
                                and b.rejection_group  = 'Moulding'
                                and a.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                                group by a.work_planning_id, b.rejection_group , b.rejection_type_id 
                                order by a.planning_date asc, c.company_name, d.pattern_item asc  
                                ) as z
                                group by DATE_FORMAT(z.planning_date,'%Y-%m')  
                                order by  DATE_FORMAT(z.planning_date,'%Y%m') asc  
                         )  
                    ) as m 
                     group by m.num_month
                     order by m.num_month asc    
                    ";
                 
                  
                            
              } 
              
              
              if($srch_opt_type == 'Melting Rejection <i class="text-sm">in %</i>'){
                  
                    $sql = "  
                    select 
                    m.num_month, 
                    m.al_month, 
                    round((sum(m.rej_wt) * 100 / sum(m.prod_wt)),2)  as actual_value 
                    from 
                    (
                         (  
                          select  
                            DATE_FORMAT(q.planning_date,'%Y%m') as num_month,
                            DATE_FORMAT(q.planning_date,'%b-%Y') as al_month,  
                            round((sum(q.tot_wt)/1000),3) as prod_wt,
                            0 as rej_wt
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
                              where a1.`status` = 'Active' and a3.`status` != 'Delete' 
                              and a1.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'  
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
                              where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' 
                              and a3.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'  
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
                                         where q.`status` = 'Active' and q1.`status` != 'Delete'  
                                         group by q1.customer_id, q1.pattern_id , q1.planning_date
                                        ) as cm on cm.pattern_id = w.pattern_id and cm.customer_id = w.customer_id and cm.planning_date = w.planning_date
                            left join pattern_info as r on r.pattern_id = w.pattern_id             
                            where w.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                            group by w.customer_id,w.pattern_id , w.planning_date   
                            ) as q
                            group by DATE_FORMAT(q.planning_date,'%Y-%m') 
                            order by DATE_FORMAT(q.planning_date,'%Y%m') asc         
                         ) 
                         union all 
                         (
                        
                            select 
                            DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                            DATE_FORMAT(z.planning_date,'%b-%Y') as al_month, 
                            0 as prod_wt, 
                            round((sum(z.rej_wt)/1000),3) as rej_wt
                            from (         
                           
                                select
                                a.work_planning_id, 
                                a.planning_date, 
                                b.rejection_group, 
                                b.rejection_type_id,
            					c1.rejection_type_name,
                                sum(b.rejection_qty) as rej_qty ,
                                round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
                                from work_planning_info as a
                                left join pattern_info as d on d.pattern_id = a.pattern_id
                                left join customer_info as c on c.customer_id = a.customer_id
                                left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
            					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                                where  a.`status` != 'Delete'   and b.rejection_type_id != '' and b.rejection_type_id != '32'
                                and b.rejection_group  = 'Melting'
                                and a.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                                group by a.work_planning_id, b.rejection_group , b.rejection_type_id 
                                order by a.planning_date asc, c.company_name, d.pattern_item asc  
                                ) as z
                                group by DATE_FORMAT(z.planning_date,'%Y-%m')  
                                order by  DATE_FORMAT(z.planning_date,'%Y%m') asc  
                         )  
                    ) as m 
                     group by m.num_month
                     order by m.num_month asc    
                    ";
                 
                  
                            
              } 
              
              if($srch_opt_type == 'Fettling Rejection <i class="text-sm">in %</i>'){
                  
                    $sql = "  
                    select 
                    m.num_month, 
                    m.al_month, 
                    round((sum(m.rej_wt) * 100 / sum(m.prod_wt)),2)  as actual_value 
                    from 
                    (
                         (  
                          select  
                            DATE_FORMAT(q.planning_date,'%Y%m') as num_month,
                            DATE_FORMAT(q.planning_date,'%b-%Y') as al_month,  
                            round((sum(q.tot_wt)/1000),3) as prod_wt,
                            0 as rej_wt
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
                              where a1.`status` = 'Active' and a3.`status` != 'Delete' 
                              and a1.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'  
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
                              where a1.`status` = 'Active' and a3.`status` != 'Delete' and a3.customer_id != '' 
                              and a3.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'  
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
                                         where q.`status` = 'Active' and q1.`status` != 'Delete'  
                                         group by q1.customer_id, q1.pattern_id , q1.planning_date
                                        ) as cm on cm.pattern_id = w.pattern_id and cm.customer_id = w.customer_id and cm.planning_date = w.planning_date
                            left join pattern_info as r on r.pattern_id = w.pattern_id             
                            where w.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                            group by w.customer_id,w.pattern_id , w.planning_date   
                            ) as q
                            group by DATE_FORMAT(q.planning_date,'%Y-%m') 
                            order by DATE_FORMAT(q.planning_date,'%Y%m') asc         
                         ) 
                         union all 
                         (
                        
                            select 
                            DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                            DATE_FORMAT(z.planning_date,'%b-%Y') as al_month, 
                            0 as prod_wt, 
                            round((sum(z.rej_wt)/1000),3) as rej_wt
                            from (         
                           
                                select
                                a.work_planning_id, 
                                a.planning_date, 
                                b.rejection_group, 
                                b.rejection_type_id,
            					c1.rejection_type_name,
                                sum(b.rejection_qty) as rej_qty ,
                                round((sum(b.rejection_qty) * d.piece_weight_per_kg),3) as rej_wt
                                from work_planning_info as a
                                left join pattern_info as d on d.pattern_id = a.pattern_id
                                left join customer_info as c on c.customer_id = a.customer_id
                                left join qc_inspection_info as b on b.work_planning_id = a.work_planning_id and b.`status` = 'Active'
            					left join rejection_type_info as c1 on c1.rejection_type_id = b.rejection_type_id 
                                where  a.`status` != 'Delete'   and b.rejection_type_id != '' and b.rejection_type_id != '32'
                                and b.rejection_group  = 'Fettling'
                                and a.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                                group by a.work_planning_id, b.rejection_group , b.rejection_type_id 
                                order by a.planning_date asc, c.company_name, d.pattern_item asc  
                                ) as z
                                group by DATE_FORMAT(z.planning_date,'%Y-%m')  
                                order by  DATE_FORMAT(z.planning_date,'%Y%m') asc  
                         )  
                    ) as m 
                     group by m.num_month
                     order by m.num_month asc    
                    ";
                 
                  
                            
              } 
              
              
              if($srch_opt_type == 'Melting Power Consumption <i class="text-sm">in Units/Ton</i>'){
                  
                $sql = " 
                    select 
                    m.num_month, 
                    m.al_month, 
                    round((sum(m.power)  / sum(m.liq_metal1)),2)  as actual_value 
                    from 
                    (
                       ( 
                            select  
                            DATE_FORMAT(a.planning_date,'%Y%m') as num_month,
                            DATE_FORMAT(a.planning_date,'%b-%Y') as al_month, 
                            sum(a.end_units - a.start_units) as power,
                            0 as liq_metal1
                            from melting_heat_log_info as a
                            where a.status = 'Active'
                            and a.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                            group by DATE_FORMAT(a.planning_date,'%Y-%m')
                            order by DATE_FORMAT(a.planning_date,'%Y%m') desc 
                        ) union all 
                        (
                            select 
                            DATE_FORMAT(z.planning_date,'%Y%m') as num_month,
                            DATE_FORMAT(z.planning_date,'%b-%Y') as al_month, 
                            0 as power,
                            round((sum(z.liq_metal1)/1000),2) as liq_metal1 
                            from (
                            select 
                            a.planning_date,
                            a.melting_heat_log_id, 
                            b.work_planning_id,
                            d.company_name as customer,
                            e.pattern_item as item, 
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
                            and a.planning_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                            order by a.planning_date 
                            ) as z
                            group by DATE_FORMAT(z.planning_date,'%Y-%m')  
                            order by DATE_FORMAT(z.planning_date,'%Y%m') asc 
                        )
                    ) as m 
                     group by m.num_month
                     order by m.num_month asc    
                    ";
                 
         
                            
              } 
              
              
              if($srch_opt_type == 'Despatch <i class="text-sm">in Tons</i>'){
                  
                $sql = " 
                    select    
                    DATE_FORMAT(a.despatch_date,'%Y%m') as num_month,
                    DATE_FORMAT(a.despatch_date,'%b-%Y') as al_month, 
                    round((sum(b.qty * e.piece_weight_per_kg)/1000),3) as actual_value
                    from customer_despatch_info as a 
                    left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
                    left join pattern_info as e on e.pattern_id = b.pattern_id
                    where a.`status` = 'Active'  
                    and a.despatch_date between  '". $row['frm_date'] ."' and '". $row['to_date'] ."'
                    group by DATE_FORMAT(a.despatch_date,'%Y-%m')  
                    order by DATE_FORMAT(a.despatch_date,'%Y%m') desc 
                    "; 
                 
                    
                            
              } 
              
                    //echo $sql;
                    $query = $this->db->query($sql); 
                    
                    $data['mrm_target'][$row['grp_id']]['chart_data'] = array(); 
                    $data['actual_data'][$row['grp_id']] = array();
                     
                    foreach($query->result_array() as $row1)
                    {    
                        $data['mrm_target'][$row['grp_id']]['chart_data'][]  = $row1; 
                        $data['actual_data'][$row['grp_id']]['data'][] = $row1['actual_value'];     
                        $data['actual_data'][$row['grp_id']]['month'][] = $row1['al_month'];     
                    } 
              
            
            
            }
            
            
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'TC'
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
        
        
        
        
        $this->load->view('page/chart/mrm-report-v2', $data);
        
    }


}
