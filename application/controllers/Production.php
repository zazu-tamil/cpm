<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production extends CI_Controller {

 
	public function index()
	{
		 
	}
    
    public function work_planning_v2()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        $data['js'] = 'planning.inc';  
        
         
    }
    
    
    public function work_planning()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        
        $data['js'] = 'planning.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            /*echo "<pre>";
            print_r($_POST);
            echo "<pre>"; 
            exit();*/
             
            
            $work_order_item_ids = $this->input->post('work_order_item_id');    
            $pattern_id = $this->input->post('pattern_id');
            $customer_id = $this->input->post('customer_id'); 
            $work_order_id = $this->input->post('work_order_id');
            $plan_qty = $this->input->post('plan_qty');
            $box_wt = $this->input->post('box_wt');
            $is_parent = $this->input->post('is_parent');
            $no_of_cavity = $this->input->post('no_of_cavity');
            
           // print_r($_POST);
            
            foreach($work_order_item_ids as $k=> $work_order_item_id) {
               $ins = array(
                        'planning_date' => $this->input->post('planning_date'),
                        'shift' => $this->input->post('shift'),
                        'remarks' => $this->input->post('remarks'),
                        'customer_id' => $customer_id[$work_order_item_id], 
                        'no_of_cavity' => $no_of_cavity[$work_order_item_id], 
                        'pattern_id' => $pattern_id[$work_order_item_id],
                        'work_order_id' => $work_order_id[$work_order_item_id],
                        'work_order_item_id' => $work_order_item_id,
                        'planned_box' => $plan_qty[$work_order_item_id], 
                        'planned_box_wt' => ($plan_qty[$work_order_item_id] * $box_wt[$work_order_item_id]), 
                        'status' => 'Planned', 
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s')                           
                );
            
                $this->db->insert('work_planning_info', $ins); 
                $work_planning_id = $this->db->insert_id();
                if(isset($is_parent[$work_order_item_id]))
                {
                    $child_work_order_item_ids = $this->input->post('child_work_order_item_id');    
                    $child_pattern_id = $this->input->post('child_pattern_id');
                    $child_customer_id = $this->input->post('child_customer_id'); 
                    $child_work_order_id = $this->input->post('child_work_order_id');
                    $child_item_no_of_cavity = $this->input->post('child_item_no_of_cavity');
                    if(!empty($child_work_order_item_ids)) {
                    foreach($child_work_order_item_ids[$work_order_item_id] as $j=> $child_work_order_item_id) {
                      // if($work_order_item_id == $j) {
                            $ins = array(
                                    'planning_date' => $this->input->post('planning_date'),
                                    'shift' => $this->input->post('shift'),
                                    'remarks' => $this->input->post('remarks'),
                                    'customer_id' => $child_customer_id[$work_order_item_id][$child_work_order_item_id], 
                                    'pattern_id' => $child_pattern_id[$work_order_item_id][$child_work_order_item_id],
                                    'work_order_id' => $child_work_order_id[$work_order_item_id][$child_work_order_item_id],
                                    'work_order_item_id' => $child_work_order_item_id,
                                    'prt_work_plan_id' => $work_planning_id,
                                    'no_of_cavity' => $child_item_no_of_cavity[$work_order_item_id][$child_work_order_item_id],
                                    'planned_box' => 0, 
                                    'planned_box_wt' => 0, 
                                    'status' => 'Planned', 
                                    'created_by' => $this->session->userdata('cr_user_id'),                          
                                    'created_datetime' => date('Y-m-d H:i:s')                           
                            );
                        
                            $this->db->insert('work_planning_info', $ins); 
                        //}
                    }
                    }
                }
                
                
                
            }
            
            redirect('work-planning-list');   
             
             
        }
        
        /*
            (b.qty + (b.qty * 10/100)) as wo_req_qty, 
            ((b.qty + (b.qty * 10 /100) * d.no_of_core)/ d.no_of_cavity) as wo_req_box ,
            (((b.qty + (b.qty * 10 /100) * d.no_of_core)/ d.no_of_cavity) * d.bunch_weight) as wo_box_wt,
        */
        
         $sql ="
            select 
            DATEDIFF(b.delivery_date,current_date()) as day_left ,
            a.work_order_id,
            b.work_order_item_id,
            a.customer_id,
            b.pattern_id,
            a.customer_PO_No,
			ifnull(( select if(q.pattern_in_out_type = 'Outward', q.reason , 0) from pattern_in_out_ward_info as q where q.status ='Active' and q.pattern_id = b.pattern_id order by q.pattern_in_out_date desc , q.pattern_in_out_id desc limit 1 ),0) as in_out_state,
            a.order_date, 
            b.delivery_date,
            c.company_name as customer,
            d.match_plate_no,
            d.pattern_item,
            d.pattern_type,
            e1.no_of_core,
            d.no_of_cavity,
            d.piece_weight_per_kg,
            d.bunch_weight,
            d.casting_weight,
            ((ifnull(z1.produced_qty,0) - ifnull(cm.closed_mould_qty,0)) - ifnull(z2.rejection_qty,0)) as prod,
            ((b.qty - ifnull(f.produced_qty,0)) + ((b.qty - ifnull(f.produced_qty,0)) * 15/100)) as wo_req_qty1, 
            round((b.qty - ((ifnull(z1.produced_qty,0) - ifnull(cm.closed_mould_qty,0)) - ifnull(z2.rejection_qty,0))) + ((b.qty - ((ifnull(z1.produced_qty,0) - ifnull(cm.closed_mould_qty,0)) - ifnull(z2.rejection_qty,0))) * 15/100)) as wo_req_qty, 
            round(((b.qty - ifnull(f.produced_qty,0)) + ((b.qty - ifnull(f.produced_qty,0)) * 15/100))/ d.no_of_cavity) as wo_req_box1 ,
            round(((b.qty - ((ifnull(z1.produced_qty,0) - ifnull(cm.closed_mould_qty,0)) - ifnull(z2.rejection_qty,0))) + ((b.qty - ((ifnull(z1.produced_qty,0) - ifnull(cm.closed_mould_qty,0)) - ifnull(z2.rejection_qty,0))) * 15/100))/ d.no_of_cavity) as wo_req_box ,
            (round(((b.qty - ifnull(f.produced_qty,0)) + ((b.qty - ifnull(f.produced_qty,0)) * 15/100))/ d.no_of_cavity) * d.bunch_weight) as wo_box_wt1,
            (round(((b.qty - ((ifnull(z1.produced_qty,0) - ifnull(cm.closed_mould_qty,0)) - ifnull(z2.rejection_qty,0))) + ((b.qty - ((ifnull(z1.produced_qty,0) - ifnull(cm.closed_mould_qty,0)) - ifnull(z2.rejection_qty,0))) * 15/100))/ d.no_of_cavity) * d.bunch_weight) as wo_box_wt,
            (e.core_produced_qty - (if(d.pattern_type = 'Core',ifnull(f.produced_qty,0),0 ))) as core_avail_qty,
            f.produced_qty,
            d2.pattern_id as child_pattern_1,
            d3.pattern_id as child_pattern_2,
            d4.pattern_id as child_pattern_3,
            d5.pattern_id as child_pattern_4,
            d6.pattern_id as child_pattern_5,
            d7.pattern_id as child_pattern_6,
            d8.pattern_id as child_pattern_7,
            d.child_pattern_1_cavity,
            d.child_pattern_2_cavity,
            d.child_pattern_3_cavity,
            d.child_pattern_4_cavity,
            d.child_pattern_5_cavity,
            d.child_pattern_6_cavity,
            d.child_pattern_7_cavity,      
            d2.match_plate_no as match_plate_no_ch1,
            d3.match_plate_no as match_plate_no_ch2,
            d4.match_plate_no as match_plate_no_ch3,
            d5.match_plate_no as match_plate_no_ch4,
            d6.match_plate_no as match_plate_no_ch5,
            d7.match_plate_no as match_plate_no_ch6,
            d8.match_plate_no as match_plate_no_ch7,
			d.item_type      
            from work_order_info as a
            left join work_order_items_info as b on b.work_order_id = a.work_order_id 
            left join customer_info as c on c.customer_id = a.customer_id 
            left join pattern_info as d on d.pattern_id = b.pattern_id 
            left join (select sum((z.produced_qty - z.damage_qty)) as core_produced_qty ,z.pattern_id  from core_plan_info as z where z.status != 'Delete' group by z.pattern_id  ) as e on e.pattern_id = b.pattern_id
            left join ( select sum(w.produced_qty) as produced_qty , w1.work_order_id , w1.work_order_item_id  from melting_item_info as w left join  work_planning_info as w1 on w1.work_planning_id = w.work_planning_id  where  w.status != 'Active' and w1.status != 'Delete' group by w1.work_order_id , w1.work_order_item_id) as f on f.work_order_id = a.work_order_id and  f.work_order_item_id = b.work_order_item_id
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
                    	sum((a2.produced_qty) ) as curr_produced_qty
                    	from melting_heat_log_info as a1
                    	left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                    	left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                   	    where a1.`status` = 'Active' and a3.status != 'Delete' and a2.`status` = 'Active'  
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
                   	    where a1.`status` = 'Active' and a3.status != 'Delete' and a2.`status` = 'Active'
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
                where b1.`status` = 'Active' and b2.status != 'Delete'
                group by b2.work_order_id , b2.work_order_item_id 
            ) as z2 on z2.work_order_id = a.work_order_id and z2.work_order_item_id = b.work_order_item_id
            left join pattern_info as d2 on d2.pattern_id = d.child_pattern_1 and d2.status = 'Active'
            left join pattern_info as d3 on d3.pattern_id = d.child_pattern_2 and d3.status = 'Active'
            left join pattern_info as d4 on d4.pattern_id = d.child_pattern_3 and d4.status = 'Active'
            left join pattern_info as d5 on d5.pattern_id = d.child_pattern_4 and d5.status = 'Active'
            left join pattern_info as d6 on d6.pattern_id = d.child_pattern_5 and d6.status = 'Active'
            left join pattern_info as d7 on d7.pattern_id = d.child_pattern_6 and d7.status = 'Active'
            left join pattern_info as d8 on d8.pattern_id = d.child_pattern_7 and d8.status = 'Active'
            left join (select r.customer_id, r.pattern_id , sum(r.core_per_box) as no_of_core from core_item_info as r where r.status = 'Active' group by r.customer_id, r.pattern_id) as e1 on e1.pattern_id = b.pattern_id
            left join (
             select  
             q1.pattern_id,
             q1.customer_id,
             sum(q.closed_mould_qty) as closed_mould_qty 
             from moulding_log_item_info as q
             left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
             where q.`status` = 'Active'  and q1.status != 'Delete'
             group by q1.pattern_id ,q1.customer_id
            ) as cm on cm.pattern_id = d.pattern_id and cm.customer_id = a.customer_id 
            where a.`status` != 'Delete' and a.`status` != 'Close' and b.status = 'Active' and c.status = 'Active'  and d.status = 'Active' 
            
            group by a.customer_id, a.work_order_id, b.work_order_item_id
            order by d.match_plate_no ,c.company_name asc , d.item_type desc  , a.work_order_id asc
              
        ";
        //(18,6,4,2,24,5,10) and b.work_order_item_id = '1395'
        // and a.customer_id in (18,6,4,2,24,5,10)
         
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
        $data['child_record_list'] = array();
        $data['child_wo_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            if($row['wo_req_qty'] > 0) 
			{
                $data['record_list'][$row['match_plate_no']][] = $row;   
               // if($row['child_pattern_1'] != '')  
                {
                    $data['child_record_list'][$row['pattern_id']][] = $row;
                } 
				if($row['item_type'] == 'Child')  
                {
                    $data['child_wo_list'][$row['pattern_id']][$row['work_order_id']][] = $row;
                } 
               
            }  
        }
        
        /*  echo "<pre>";    
         print_r($data['record_list']);  
        // print_r($data['child_record_list']);  
         echo "</pre>";   */
        
        
        $srch_date = date('Y-m-d');
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
            sum(ifnull(p4.pouring_box,0) * p7.no_of_cavity * p.core_per_box) as core_used_qty, 
            (ifnull(p2.stock_qty,0) + sum(ifnull(p3.core_produced_qty,0)) - sum(ifnull(p4.pouring_box,0) * p7.no_of_cavity * p.core_per_box)) as stock_qty            
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
            where b.`status` = 'Active' and b.core_plan_date between ifnull((select max(z.floor_stock_date) from core_floor_stock_info as z where z.core_item_id = b.core_item_id and z.floor_stock_date <= '" .$srch_date. "'),'2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 0 day) 
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
            where a1.`status` = 'Active' and a3.status != 'Delete' and a1.melting_date between ifnull((select max(z.floor_stock_date) from core_floor_stock_info as z where z.pattern_id = a3.pattern_id and z.floor_stock_date <= '" .$srch_date. "'),'2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 0 day)  
            group by a3.customer_id, a3.pattern_id 
            order by a3.customer_id, a3.pattern_id 
            ) as p4 on p4.customer_id = p.customer_id and p4.pattern_id = p.pattern_id  
            left join (select r.customer_id, r.pattern_id , count(r.core_item_id) as no_of_core from core_item_info as r where r.status = 'Active' group by r.customer_id, r.pattern_id) as p5 on p5.customer_id = p.customer_id and p5.pattern_id = p.pattern_id
            left join customer_info as p6 on p6.customer_id = p.customer_id
            left join pattern_info as p7 on p7.pattern_id = p.pattern_id  
            where p.`status` = 'Active'
            and p.customer_id = 18
            group by p.customer_id, p.pattern_id, p.core_item_id
            order by customer ,pattern_item , core_item
         
         ";  
            
        /* echo "<pre>";    
         print_r($op_sql);  
         echo "</pre>"; */
         
         $query = $this->db->query($op_sql);
        
        $data['core_stock_list'] = array();
       
        foreach ($query->result_array() as $row)
        { 
            //$data['core_stock_list'][$row['pattern_id']][$row['core_item']] = (($row['op_stock'] + $row['curr_core_produced_qty']) - $row['curr_pouring_qty']);     
            $data['core_stock_list'][$row['pattern_id']][$row['core_item']] = $row['stock_qty'];     
        } 
		
		
        
        $wo_stock_sql = "
        select 
            a.work_order_id,
            b.work_order_item_id,
            b.pattern_id, 
            b.qty as order_qty,
            ifnull(c.despatch_qty,0) as despatch_qty,
            (ifnull(z.planned_box,0) * d.no_of_cavity) as planned_qty,
            (ifnull(z1.produced_qty,0) - ifnull(cm.closed_mould_qty,0)) as produced_qty1, 
            (ifnull(z2.rejection_qty,0)) as rejection_qty, 
            ((ifnull(z1.produced_qty,0)- ifnull(cm.closed_mould_qty,0)) - (ifnull(z2.rejection_qty,0))) as produced_qty,
            (b.qty - ((ifnull(z1.produced_qty,0) - ifnull(cm.closed_mould_qty,0)) - (ifnull(z2.rejection_qty,0)))) as bal_qty 
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
                a1.work_order_id,
                a1.work_order_item_id,
                a1.pattern_id,
                sum(a1.planned_box) as planned_box
                from work_planning_info as a1  
                where a1.`status` != 'Delete'  
                group by a1.work_order_id , a1.work_order_item_id
            ) as z on z.work_order_id = a.work_order_id and  z.work_order_item_id = b.work_order_item_id
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
                   	    where a1.`status` = 'Active' and a2.`status` = 'Active' and a3.status != 'Delete'  
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
                   	    where a1.`status` = 'Active'  and a2.`status` = 'Active' and a3.status != 'Delete'
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
                where b1.`status` = 'Active' and b2.status != 'Delete'
                group by b2.work_order_id , b2.work_order_item_id 
            ) as z2 on z2.work_order_id = a.work_order_id and z2.work_order_item_id = b.work_order_item_id
            left join (
             select  
             q1.pattern_id,
             q1.customer_id,
             sum(q.closed_mould_qty) as closed_mould_qty 
             from moulding_log_item_info as q
             left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
             where q.`status` = 'Active'  and q1.status != 'Delete'
             group by q1.pattern_id ,q1.customer_id
            ) as cm on cm.pattern_id = d.pattern_id and cm.customer_id = a.customer_id 
            where a.`status` = 'Active'  
            group by a.work_order_id ,  b.work_order_item_id
        ";
        
        $query = $this->db->query($wo_stock_sql);
        
        $data['wo_stock_list'] = array();
       
        foreach ($query->result_array() as $row)
        { 
            $data['wo_stock_list'][$row['work_order_id']][$row['work_order_item_id']] = $row;     
        } 
        
        
        $data['shift_opt'] = array('Shift-A' => 'Shift-A' , 'Shift-B' => 'Shift-B', 'Shift-C' => 'Shift-C'); 
        
        
          
        
        $this->load->view('page/production/work-planning',$data); 
    }
    
    public function work_planning_list()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        
        $data['js'] = 'planning.inc';  
        
        
        
      if(isset($_POST['srch_date'])) {
           $data['srch_date'] = $srch_date = $this->input->post('srch_date');   
       } else {
           $data['srch_date'] = $srch_date = date('Y-m-d');
       }
       
       if(isset($_POST['srch_shift'])) {
           $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift');    
       }  else {
           $data['srch_shift'] =  $srch_shift = 'Shift-A';
       }
        
         
        $sql = "
                select 
                a.work_planning_id,    
                a.planning_date as m_date,
                a.customer_id,
                a.pattern_id, 
                c.company_name as customer,
                d.customer_PO_No,
                b.pattern_item,
                b.bunch_weight,
                b.piece_weight_per_kg,
                (if(ifnull(a.prt_work_plan_id,0) != 0 ,  ifnull(a.no_of_cavity,1) , b.no_of_cavity )) as no_of_cavity1,
                (if(ifnull(a.prt_work_plan_id,0) != 0 ,  ifnull(a.no_of_cavity,1) , a.no_of_cavity )) as no_of_cavity,
                a.prt_work_plan_id,
                b.child_pattern_1,
                b.child_pattern_2,
                b.child_pattern_3,
                b.child_pattern_1_cavity,
                b.child_pattern_2_cavity,
                b.child_pattern_3_cavity,
                (a.planned_box) as planned_box,
                (a.planned_box_wt) as planned_box_wt,
                DATEDIFF(current_date(), a.planning_date) as days , 
                (a.planned_box *  (if(ifnull(a.prt_work_plan_id,0) != 0 ,  ifnull(a.no_of_cavity,1) , b.no_of_cavity ))) as planned_qty1,  
                (a.planned_box *  (if(ifnull(a.prt_work_plan_id,0) != 0 ,  ifnull(a.no_of_cavity,1) , a.no_of_cavity ))) as planned_qty  
                from work_planning_info as a
                left join pattern_info as b on b.pattern_id = a.pattern_id
                left join customer_info as c on c.customer_id = a.customer_id
                left join work_order_info as d on d.work_order_id = a.work_order_id 
                where a.status!='Delete' and b.status ='Active'   
                and a.planning_date = '".$srch_date."'  
                and a.shift = '".$srch_shift."'
                order by a.work_planning_id asc   
            "; 
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
        
        foreach ($query->result_array() as $row)
        { 
            $data['record_list'][] = $row;  
              
        }
        
        
        
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
            ((ifnull(p2.stock_qty,0) + sum(ifnull(p3.core_produced_qty,0))) - (sum(ifnull(p4.pouring_box,0)) * p.core_per_box)) as op_stock,
            ((ifnull(p2.stock_qty,0) + sum(ifnull(p3.core_produced_qty,0))) - (sum(ifnull(p4.pouring_box,0)) * p7.no_of_core * p7.no_of_cavity)) as op_stock1,
            ifnull(q.curr_core_produced_qty,0) as curr_core_produced_qty,
            (ifnull(q1.curr_pouring_box,0) * p.core_per_box) as curr_pouring_qty,                          
            (ifnull(q1.curr_pouring_box,0) * p7.no_of_core * p7.no_of_cavity) as curr_pouring_qty1                          
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
                left join  core_floor_stock_info as p2 on p2.customer_id = p.customer_id and p2.pattern_id = p.pattern_id and p2.core_item_id = p.core_item_id and p2.floor_stock_date = ifnull(p1.floor_stock_date, '2020-12-01') 
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
                where a1.`status` = 'Active' and a3.status != 'Delete' and a1.melting_date between ifnull((select max(z.floor_stock_date) from core_floor_stock_info as z where z.pattern_id = a3.pattern_id and z.floor_stock_date <= '" .$srch_date. "'),'2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)  
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
                    where a1.`status` = 'Active' and a3.status != 'Delete' and a1.planning_date = '" .$srch_date. "'
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id  
                ) as q1 on q1.customer_id = p.customer_id and q1.pattern_id = p.pattern_id
                where p.`status` = 'Active' ";
           // if(!empty($srch_pattern_id) ){
              $op_sql.=" and exists ( select * from work_planning_info as s where s.pattern_id = p.pattern_id and s.status!='Delete' and s.planning_date = '".$srch_date."'  
                    and s.shift = '".$srch_shift."') ";
           // }      
           $op_sql .="     
                group by p.customer_id, p.pattern_id, p.core_item_id
                order by customer ,pattern_item , core_item
            ";
            
        // print_r($op_sql);  
         
         $query = $this->db->query($op_sql);
        
        $data['core_stock_list'] = array();
       
        foreach ($query->result_array() as $row)
        { 
            $data['core_stock_list'][$row['pattern_id']][$row['core_item']] = (($row['op_stock'] + $row['curr_core_produced_qty']));     
        } 
        
        
        
        $data['shift_opt'] = array('Shift-A' => 'Shift-A' , 'Shift-B' => 'Shift-B', 'Shift-C' => 'Shift-C'); 
          
        
        $this->load->view('page/production/work-planning-list',$data); 
    }
    
    public function moulding_material()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        
        $data['js'] = 'moulding-material.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            
               $ins = array(
                        'moulding_date' => $this->input->post('moulding_date'),
                        'work_planning_id' => $this->input->post('work_planning_id'),
                        'new_sand' => $this->input->post('new_sand'), 
                        'green_sand' => $this->input->post('green_sand'), 
                        'water' => $this->input->post('water'), 
                        'bentonite' => $this->input->post('bentonite'), 
                        'bentokol' => $this->input->post('bentokol'), 
                        'total_mix' => $this->input->post('total_mix'), 
                       // 'cum_bentonite' => $this->input->post('cum_bentonite'), 
                      //  'cum_bentokol' => $this->input->post('cum_bentokol'), 
                      //  'total_mix_bento' => $this->input->post('total_mix_bento'), 
                        'remarks' => $this->input->post('remarks'), 
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s')                           
                );
            
                $this->db->insert('moulding_material_log', $ins); 
           
            redirect('moulding-material');  
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'moulding_date' => $this->input->post('moulding_date'),
                    'work_planning_id' => $this->input->post('work_planning_id'),
                    'new_sand' => $this->input->post('new_sand'), 
                    'green_sand' => $this->input->post('green_sand'), 
                    'water' => $this->input->post('water'), 
                    'bentonite' => $this->input->post('bentonite'), 
                    'bentokol' => $this->input->post('bentokol'), 
                    'total_mix' => $this->input->post('total_mix'), 
                    //'cum_bentonite' => $this->input->post('cum_bentonite'), 
                    //'cum_bentokol' => $this->input->post('cum_bentokol'), 
                   // 'total_mix_bento' => $this->input->post('total_mix_bento'), 
                    'remarks' => $this->input->post('remarks'),   
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('moulding_material_log_id', $this->input->post('moulding_material_log_id'));
            $this->db->update('moulding_material_log', $upd); 
                            
            redirect('moulding-material');  
        } 
        
        
       if(isset($_POST['srch_date'])) {
           $data['srch_date'] = $srch_date = $this->input->post('srch_date'); 
           $this->session->set_userdata('srch_date', $this->input->post('srch_date'));  
       } elseif($this->session->userdata('srch_date')) {
           $data['srch_date'] = $srch_date = $this->session->userdata('srch_date') ; 
       } else {
           $data['srch_date'] = $srch_date = date('Y-m-d');
       }
       
       if(isset($_POST['srch_shift'])) {
           $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift');
           $this->session->set_userdata('srch_shift', $this->input->post('srch_shift'));     
       } elseif($this->session->userdata('srch_shift')) {
           $data['srch_shift'] = $srch_shift = $this->session->userdata('srch_shift') ; 
       } else {
        $data['srch_shift'] =  $srch_shift = '';
       }
        
        
        /*$this->db->select('a.work_planning_id'); 
        $this->db->where('a.status != ', 'Delete'); 
        $this->db->where("a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'");
        $this->db->from('work_planning_info as a');  */
        
        
        $sql = "select a.work_planning_id from work_planning_info as a where a.status != 'Delete' and a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
                $data['work_planning_id'] = $row->work_planning_id;
        }
       
       /*
       a.cum_bentonite, 
            a.cum_bentokol, 
            a.total_mix_bento,*/
        
       $sql ="
            select 
            a.moulding_material_log_id, 
            a.work_planning_id,
            a.moulding_date, 
            b.planning_date,
            b.shift,
            a.new_sand, 
            a.green_sand, 
            a.water, 
            a.bentonite, 
            a.bentokol, 
            a.total_mix, 
            a.remarks,
            DATEDIFF(current_date(), a.moulding_date) as days   
            from moulding_material_log as a 
            left join work_planning_info as b on b.work_planning_id = a.work_planning_id
            where a.status != 'Delete' and b.status != 'Delete' and a.moulding_date != 0 
            and b.planning_date = '". $srch_date."' and b.shift = '". $srch_shift ."'
            order by a.moulding_material_log_id asc
        ";  
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        $data['shift_opt'] = array('Shift-A' => 'Shift-A' , 'Shift-B' => 'Shift-B', 'Shift-C' => 'Shift-C'); 
        
         
        
        $this->load->view('page/production/moulding-material',$data); 
    }
    
    public function moulding_heatcode_log()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        
        $data['js'] = 'moulding-headcode.inc';  

        //ALTER TABLE `moulding_log_item_info` 	ADD COLUMN `breakdown_remarks` TEXT NULL AFTER `chk_mold_closing_status`;

        
        if($this->input->post('mode') == 'Add')
        {
            
               $ins = array( 
                        'work_planning_id' => $this->input->post('work_planning_id'),
                        //'pattern_change_time' => $this->input->post('pattern_change_time'), 
                        'pattern_prod_from_time' => $this->input->post('pattern_prod_from_time'), 
                        'pattern_prod_to_time' => $this->input->post('pattern_prod_to_time'), 
                        'pattern_prod_from_datetime' => $this->input->post('pattern_prod_from_datetime'), 
                        'pattern_prod_to_datetime' => $this->input->post('pattern_prod_to_datetime'), 
                        'breakdown_from_time' => $this->input->post('breakdown_from_time'), 
                        'breakdown_to_time' => $this->input->post('breakdown_to_time'), 
                        'breakdown_remarks' => $this->input->post('breakdown_remarks'), 
                        'machine_on_time' => $this->input->post('machine_on_time'), 
                        'machine_off_time' => $this->input->post('machine_off_time'), 
                        'heat_no' => $this->input->post('heat_no'), 
                        'moulding_hrd_top' => $this->input->post('moulding_hrd_top'), 
                        'moulding_hrd_bottom' => $this->input->post('moulding_hrd_bottom'), 
                        'produced_box' => $this->input->post('produced_box'), 
                        'closed_mould_qty' => $this->input->post('closed_mould_qty'), 
                       // 'leftout_box' => $this->input->post('leftout_box'), 
                      //  'leftout_remarks' => $this->input->post('leftout_remarks'), 
                        'knock_out_time' => $this->input->post('knock_out_time'), 
                        //'manpower_comsumption' => $this->input->post('manpower_comsumption'), 
                        'bottom_moulding_machine_operator' => $this->input->post('bottom_moulding_machine_operator'), 
                        'chk_pattern_condition' => $this->input->post('chk_pattern_condition'), 
                        'chk_logo_identify' => $this->input->post('chk_logo_identify'), 
                        'chk_gating_sys_identify' => $this->input->post('chk_gating_sys_identify'), 
                        'chk_mold_closing_status' => $this->input->post('chk_mold_closing_status'),                         
                        'top_moulding_machine_operator' => $this->input->post('top_moulding_machine_operator'), 
                        'core_setter_name' => $this->input->post('core_setter_name'), 
                        'mould_closer_name' => $this->input->post('mould_closer_name'), 
                        'mullar_operator_name' => $this->input->post('mullar_operator_name'), 
                        'addt_other_operators' => $this->input->post('addt_other_operators'), 
                        'supervisor' => $this->input->post('supervisor'), 
                        'remarks' => $this->input->post('remarks'), 
                        'modification_details' => $this->input->post('modification_details'), 
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s')                           
                );
            
                $this->db->insert('moulding_log_item_info', $ins); 
                
                
                $this->session->set_userdata('machine_on_time', $this->input->post('machine_on_time')); 
                $this->session->set_userdata('machine_off_time', $this->input->post('machine_off_time')); 
                $this->session->set_userdata('bottom_moulding_machine_operator', $this->input->post('bottom_moulding_machine_operator')); 
                $this->session->set_userdata('top_moulding_machine_operator', $this->input->post('top_moulding_machine_operator')); 
                $this->session->set_userdata('core_setter_name', $this->input->post('core_setter_name')); 
                $this->session->set_userdata('mould_closer_name', $this->input->post('mould_closer_name')); 
                $this->session->set_userdata('mullar_operator_name', $this->input->post('mullar_operator_name')); 
                $this->session->set_userdata('addt_other_operators', $this->input->post('addt_other_operators')); 
                
                //leftout_flg
               /*if($this->input->post('leftout_box') > 0){
                $this->db->where('work_planning_id', $this->input->post('work_planning_id'));
                $this->db->update('work_planning_info', array('leftout_flg' => '1' , 'leftout_box' => $this->input->post('leftout_box')));                 
               } */
           
            redirect('moulding-heatcode-log');  
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                        'work_planning_id' => $this->input->post('work_planning_id'),
                        'pattern_change_time' => $this->input->post('pattern_change_time'), 
                        'pattern_prod_from_time' => $this->input->post('pattern_prod_from_time'), 
                        'pattern_prod_to_time' => $this->input->post('pattern_prod_to_time'), 
                        'pattern_prod_from_datetime' => $this->input->post('pattern_prod_from_datetime'), 
                        'pattern_prod_to_datetime' => $this->input->post('pattern_prod_to_datetime'), 
                        'breakdown_from_time' => $this->input->post('breakdown_from_time'), 
                        'breakdown_to_time' => $this->input->post('breakdown_to_time'), 
                        'breakdown_remarks' => $this->input->post('breakdown_remarks'), 
                        'machine_on_time' => $this->input->post('machine_on_time'), 
                        'machine_off_time' => $this->input->post('machine_off_time'), 
                        'heat_no' => $this->input->post('heat_no'), 
						'moulding_hrd_top' => $this->input->post('moulding_hrd_top'), 
                        'moulding_hrd_bottom' => $this->input->post('moulding_hrd_bottom'), 
                        'produced_box' => $this->input->post('produced_box'), 
                        'closed_mould_qty' => $this->input->post('closed_mould_qty'), 
                       // 'leftout_box' => $this->input->post('leftout_box'), 
                       // 'leftout_remarks' => $this->input->post('leftout_remarks'), 
                        'knock_out_time' => $this->input->post('knock_out_time'), 
                       // 'manpower_comsumption' => $this->input->post('manpower_comsumption'), 
                        'chk_pattern_condition' => $this->input->post('chk_pattern_condition'), 
                        'chk_logo_identify' => $this->input->post('chk_logo_identify'), 
                        'chk_gating_sys_identify' => $this->input->post('chk_gating_sys_identify'), 
                        'chk_mold_closing_status' => $this->input->post('chk_mold_closing_status'), 
                        'bottom_moulding_machine_operator' => $this->input->post('bottom_moulding_machine_operator'), 
                        'top_moulding_machine_operator' => $this->input->post('top_moulding_machine_operator'), 
                        'core_setter_name' => $this->input->post('core_setter_name'), 
                        'mould_closer_name' => $this->input->post('mould_closer_name'), 
                        'mullar_operator_name' => $this->input->post('mullar_operator_name'), 
                        'addt_other_operators' => $this->input->post('addt_other_operators'), 
                        'supervisor' => $this->input->post('supervisor'), 
                        'remarks' => $this->input->post('remarks'), 
                        'modification_details' => $this->input->post('modification_details'), 
                        'updated_by' => $this->session->userdata('cr_user_id'),                          
                        'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('moulding_log_item_id', $this->input->post('moulding_log_item_id'));
            $this->db->update('moulding_log_item_info', $upd); 
            
            /* if($this->input->post('leftout_box') > 0){
                 $this->db->where('work_planning_id', $this->input->post('work_planning_id'));
                 $this->db->update('work_planning_info', array('leftout_flg' => '1' , 'leftout_box' => $this->input->post('leftout_box')));                      
             } */
                            
            redirect('moulding-heatcode-log');  
        } 
        
        
      if($this->session->userdata('machine_on_time')) {
           $data['machine_on_time'] = $this->session->userdata('machine_on_time') ; 
           $data['machine_off_time'] = $this->session->userdata('machine_off_time') ; 
           $data['bottom_moulding_machine_operator'] = $this->session->userdata('bottom_moulding_machine_operator') ; 
           $data['top_moulding_machine_operator'] = $this->session->userdata('top_moulding_machine_operator') ; 
           $data['core_setter_name'] = $this->session->userdata('core_setter_name') ; 
           $data['mould_closer_name'] = $this->session->userdata('mould_closer_name') ; 
           $data['mullar_operator_name'] = $this->session->userdata('mullar_operator_name') ; 
           $data['addt_other_operators'] = $this->session->userdata('addt_other_operators') ;  
           $data['supervisor'] = $this->session->userdata('supervisor') ;  
           
       } else {
           $data['machine_on_time'] = '' ; 
           $data['machine_off_time'] = '' ; 
           $data['bottom_moulding_machine_operator'] = '' ; 
           $data['top_moulding_machine_operator'] = '' ; 
           $data['core_setter_name'] = '' ; 
           $data['mould_closer_name'] = '' ; 
           $data['mullar_operator_name'] = '' ;
           $data['addt_other_operators'] = '' ;
           $data['supervisor'] = '' ;
       }   
        
        
        
        
       if(isset($_POST['srch_date'])) {
           $data['srch_date'] = $srch_date = $this->input->post('srch_date'); 
           $this->session->set_userdata('srch_date', $this->input->post('srch_date'));  
       } elseif($this->session->userdata('srch_date')) {
           $data['srch_date'] = $srch_date = $this->session->userdata('srch_date') ; 
       } else {
           $data['srch_date'] = $srch_date = date('Y-m-d');
       }
       
       if(isset($_POST['srch_shift'])) {
           $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift');
           $this->session->set_userdata('srch_shift', $this->input->post('srch_shift'));     
       } elseif($this->session->userdata('srch_shift')) {
           $data['srch_shift'] = $srch_shift = $this->session->userdata('srch_shift') ; 
       } else {
        $data['srch_shift'] =  $srch_shift = '';
       }
        
        
        /*$this->db->select('a.work_planning_id'); 
        $this->db->where('a.status != ', 'Delete'); 
        $this->db->where("a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'");
        $this->db->from('work_planning_info as a');  */
        
        
        $sql = "select a.work_planning_id from work_planning_info as a where a.status != 'Delete' and a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
                $data['work_planning_id'] = $row->work_planning_id;
        }
        
        
        $sql = "
                select 
                a.employee_id,                
                a.employee_name             
                from employee_info as a  
                where status = 'Active' 
                order by a.employee_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['employee_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['employee_opt'][$row['employee_name']] = $row['employee_name'];     
        }
       
        
       /* $sql ="
            select 
            a.moulding_log_item_id, 
            a.work_planning_id, 
            b.planning_date,
            b.shift,
            a.machine_on_time, 
            a.machine_off_time, 
            a.heat_no, 
            a.plan_box, 
            a.actual_box, 
            a.pouring_box, 
            a.remaining_box, 
            a.leftout_box, 
            a.leftout_remarks, 
            a.knock_out_time, 
            a.remarks
            from moulding_log_item_info as a
            left join work_planning_info as b on b.work_planning_id = a.work_planning_id
            where a.status != 'Delete'
            and b.planning_date = '". $srch_date."' and b.shift = '". $srch_shift ."'
            order by a.moulding_log_item_id asc
        ";*/
        
         $sql = "
             select 
            	a.work_planning_id,
            	a.planning_date,
            	a.shift,
            	c.company_name as customer,
            	e.customer_PO_No,
            	d.match_plate_no,
            	d.pattern_item,
            	a.planned_box,
            	a1.moulding_log_item_id, 
            	a1.breakdown_from_time, 
            	a1.breakdown_to_time, 
            	a1.pattern_prod_from_time, 
            	a1.pattern_prod_to_time, 
            	a1.heat_no, 
            	a1.plan_box, 
            	a1.produced_box, 
            	a1.pouring_box, 
            	a1.closed_mould_qty, 
            	a1.leftout_box, 
            	a1.leftout_remarks, 
            	a1.knock_out_time, 
            	a1.remarks,
                a.prt_work_plan_id,
                DATEDIFF(current_date(), a.planning_date) as days,  
                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(a1.pattern_prod_to_time,a1.pattern_prod_from_time))) as prod_hrs,
                SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(a1.breakdown_to_time,a1.breakdown_from_time))) as breakdown_hrs,
                SEC_TO_TIME( (TIME_TO_SEC(TIMEDIFF(a1.pattern_prod_to_time,a1.pattern_prod_from_time)) - TIME_TO_SEC(TIMEDIFF(a1.breakdown_to_time,a1.breakdown_from_time))) * a1.manpower_comsumption)  as man_hr1,
                SEC_TO_TIME( (TIME_TO_SEC(TIMEDIFF(concat(a1.pattern_prod_to_datetime ,' ', a1.pattern_prod_to_time),concat(a1.pattern_prod_from_datetime ,' ', a1.pattern_prod_from_time))) - TIME_TO_SEC(TIMEDIFF(a1.breakdown_to_time,a1.breakdown_from_time))) * a1.manpower_comsumption)  as man_hr,
                (a1.produced_box / ( (TIME_TO_SEC(TIMEDIFF(a1.pattern_prod_to_time,a1.pattern_prod_from_time)) - TIME_TO_SEC(TIMEDIFF(a1.breakdown_to_time,a1.breakdown_from_time))) * a1.manpower_comsumption )  * (3600) ) as eff1, 
                (a1.produced_box / ( (TIME_TO_SEC(TIMEDIFF(concat(a1.pattern_prod_to_datetime ,' ', a1.pattern_prod_to_time),concat(a1.pattern_prod_from_datetime ,' ', a1.pattern_prod_from_time))) - TIME_TO_SEC(TIMEDIFF(a1.breakdown_to_time,a1.breakdown_from_time))) * a1.manpower_comsumption )  * (3600) ) as eff 
             from work_planning_info as a
             left join work_order_items_info as b on b.work_order_item_id = a.work_order_item_id
             left join customer_info as c on c.customer_id = a.customer_id
             left join pattern_info as d on d.pattern_id = a.pattern_id 
             left join work_order_info as e on e.work_order_id = a.work_order_id
             left join moulding_log_item_info as a1 on a1.work_planning_id = a.work_planning_id and a1.`status` != 'Delete'
             where a.`status` != 'Delete' and d.`status` = 'Active' and
             a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'
             order by a.work_planning_id asc
        
        ";
        
         //a.prt_work_plan_id is null and
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            //if($row['prt_work_plan_id'] == '')
                $data['record_list'][$row['work_planning_id']][] = $row;     
        }
        
        $data['shift_opt'] = array('Shift-A' => 'Shift-A' , 'Shift-B' => 'Shift-B', 'Shift-C' => 'Shift-C'); 
          
        
        $this->load->view('page/production/moulding-headcode-log',$data); 
    }
    
    public function melting_log_old()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        
        $data['js'] = 'melting-log.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            
               $ins = array( 
                        'work_planning_id' => $this->input->post('work_planning_id'),
                        'melting_date' => $this->input->post('melting_date'), 
                        'lining_heat_no' => $this->input->post('lining_heat_no'), 
                        'heat_code' => $this->input->post('heat_code'), 
                        'days_heat_no' => $this->input->post('days_heat_no'), 
                        'furnace_on_time' => $this->input->post('furnace_on_time'), 
                        'furnace_off_time' => $this->input->post('furnace_off_time'), 
                        'pouring_start_time' => $this->input->post('pouring_start_time'), 
                        'pouring_finish_time' => $this->input->post('pouring_finish_time'), 
                        'total_time' => $this->input->post('total_time'), 
                        'pouring_box' => $this->input->post('pouring_box'), 
                        'tapp_temp' => $this->input->post('tapp_temp'), 
                        'pour_temp' => $this->input->post('pour_temp'), 
                        'temp_first_box' => $this->input->post('temp_first_box'), 
                        'temp_last_box' => $this->input->post('temp_last_box'), 
                        'start_units' => $this->input->post('start_units'), 
                        'end_units' => $this->input->post('end_units'), 
                        'boring' => $this->input->post('boring'), 
                        'ms' => $this->input->post('ms'), 
                        'foundry_return' => $this->input->post('foundry_return'), 
                        'CI_scrap' => $this->input->post('CI_scrap'), 
                        'pig_iron' => $this->input->post('pig_iron'), 
                        'C' => $this->input->post('C'), 
                        'SI' => $this->input->post('SI'), 
                        'Mn' => $this->input->post('Mn'), 
                        'S' => $this->input->post('S'), 
                        'Cu' => $this->input->post('Cu'), 
                        'Cr' => $this->input->post('Cr'), 
                        'fe_si_mg' => $this->input->post('fe_si_mg'), 
                        'fe_sulphur' => $this->input->post('fe_sulphur'), 
                        'inoculant' => $this->input->post('inoculant'), 
                        'pyrometer_tip' => $this->input->post('pyrometer_tip'), 
                        'fc_operator' => $this->input->post('fc_operator'), 
                        'pouring_person_name_1' => $this->input->post('pouring_person_name_1'), 
                        'pouring_person_name_2' => $this->input->post('pouring_person_name_2'), 
                        'pouring_person_name_3' => $this->input->post('pouring_person_name_3'), 
                        'helper_name' => $this->input->post('helper_name'), 
                        'ideal_hrs_from' => $this->input->post('ideal_hrs_from'), 
                        'ideal_hrs_to' => $this->input->post('ideal_hrs_to'), 
                        'total_hrs' => $this->input->post('total_hrs'), 
                        'remarks' => $this->input->post('remarks'), 
                        'status' => 'Active', 
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s')                           
                );
            
                $this->db->insert('melting_log_info', $ins); 
           
            redirect('melting-log');  
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                        'work_planning_id' => $this->input->post('work_planning_id'),
                        'melting_date' => $this->input->post('melting_date'), 
                        'lining_heat_no' => $this->input->post('lining_heat_no'), 
                        'heat_code' => $this->input->post('heat_code'), 
                        'days_heat_no' => $this->input->post('days_heat_no'), 
                        'furnace_on_time' => $this->input->post('furnace_on_time'), 
                        'furnace_off_time' => $this->input->post('furnace_off_time'), 
                        'pouring_start_time' => $this->input->post('pouring_start_time'), 
                        'pouring_finish_time' => $this->input->post('pouring_finish_time'), 
                        'total_time' => $this->input->post('total_time'), 
                        'pouring_box' => $this->input->post('pouring_box'), 
                        'tapp_temp' => $this->input->post('tapp_temp'), 
                        'pour_temp' => $this->input->post('pour_temp'), 
                        'temp_first_box' => $this->input->post('temp_first_box'), 
                        'temp_last_box' => $this->input->post('temp_last_box'), 
                        'start_units' => $this->input->post('start_units'), 
                        'end_units' => $this->input->post('end_units'), 
                        'boring' => $this->input->post('boring'), 
                        'ms' => $this->input->post('ms'), 
                        'foundry_return' => $this->input->post('foundry_return'), 
                        'CI_scrap' => $this->input->post('CI_scrap'), 
                        'pig_iron' => $this->input->post('pig_iron'), 
                        'C' => $this->input->post('C'), 
                        'SI' => $this->input->post('SI'), 
                        'Mn' => $this->input->post('Mn'), 
                        'S' => $this->input->post('S'), 
                        'Cu' => $this->input->post('Cu'), 
                        'Cr' => $this->input->post('Cr'), 
                        'fe_si_mg' => $this->input->post('fe_si_mg'), 
                        'fe_sulphur' => $this->input->post('fe_sulphur'), 
                        'inoculant' => $this->input->post('inoculant'), 
                        'pyrometer_tip' => $this->input->post('pyrometer_tip'), 
                        'fc_operator' => $this->input->post('fc_operator'), 
                        'pouring_person_name_1' => $this->input->post('pouring_person_name_1'), 
                        'pouring_person_name_2' => $this->input->post('pouring_person_name_2'), 
                        'pouring_person_name_3' => $this->input->post('pouring_person_name_3'), 
                        'helper_name' => $this->input->post('helper_name'), 
                        'ideal_hrs_from' => $this->input->post('ideal_hrs_from'), 
                        'ideal_hrs_to' => $this->input->post('ideal_hrs_to'), 
                        'total_hrs' => $this->input->post('total_hrs'), 
                        'remarks' => $this->input->post('remarks'), 
                        'status' => 'Active',
                        'updated_by' => $this->session->userdata('cr_user_id'),                          
                        'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('melting_log_id', $this->input->post('melting_log_id'));
            $this->db->update('melting_log_info', $upd); 
                            
            redirect('melting-log');  
        } 
        
        
        
        
       if(isset($_POST['srch_date'])) {
           $data['srch_date'] = $srch_date = $this->input->post('srch_date'); 
           $this->session->set_userdata('srch_date', $this->input->post('srch_date'));  
       } elseif($this->session->userdata('srch_date')) {
           $data['srch_date'] = $srch_date = $this->session->userdata('srch_date') ; 
       } else {
           $data['srch_date'] = $srch_date = date('Y-m-d');
       }
       
       if(isset($_POST['srch_shift'])) {
           $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift');
           $this->session->set_userdata('srch_shift', $this->input->post('srch_shift'));     
       } elseif($this->session->userdata('srch_shift')) {
           $data['srch_shift'] = $srch_shift = $this->session->userdata('srch_shift') ; 
       } else {
        $data['srch_shift'] =  $srch_shift = '';
       }
        
        
        /*$this->db->select('a.work_planning_id'); 
        $this->db->where('a.status != ', 'Delete'); 
        $this->db->where("a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'");
        $this->db->from('work_planning_info as a');  */
        
        $months = array("A" => 'Jan', "B" => 'Feb', "C" => 'Mar', "D" => 'Apr', "E" => 'May', "F" => 'Jun', "G" => 'Jul', "H" => 'Aug', "J" => 'Sep', "K" => 'Oct', "L" => 'Nov', "M" => 'Dec');
        
        $sql = "select a.work_planning_id,a.planning_date from work_planning_info as a where a.status != 'Delete' and a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
                $data['work_planning_id'] = $row->work_planning_id;
                $va = array_keys($months, date('M',strtotime($row->planning_date)));
                $data['heat_code'] = date('y',strtotime($row->planning_date)). $va[0] . date('d',strtotime($row->planning_date));
        }
       
        
        
        
        $sql = "
             select 
            	a.work_planning_id,
            	a.planning_date,
            	a.shift,
            	c.company_name as customer,
            	e.customer_PO_No,
            	d.match_plate_no,
            	d.pattern_item,
            	a.planned_box,
            	a1.melting_log_id, 
            	a1.lining_heat_no, 
                a1.heat_code,
            	a1.days_heat_no, 
            	a1.furnace_on_time, 
            	a1.furnace_off_time, 
            	a1.pouring_box, 
            	a1.tapp_temp, 
            	a1.pour_temp, 
            	a1.temp_first_box, 
            	a1.temp_last_box, 
            	a1.start_units, 
            	a1.end_units, 
                a1.ideal_hrs_from, 
                a1.ideal_hrs_to, 
                a1.total_hrs, 
            	a1.remarks
             from work_planning_info as a
             left join work_order_items_info as b on b.work_order_item_id = a.work_order_item_id
             left join customer_info as c on c.customer_id = a.customer_id
             left join pattern_info as d on d.pattern_id = a.pattern_id 
             left join work_order_info as e on e.work_order_id = a.work_order_id
             left join melting_log_info as a1 on a1.work_planning_id = a.work_planning_id and a1.`status` != 'Delete'
             where a.`status` != 'Delete' and
             a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'
             order by a.work_planning_id asc
        
        ";
        
         
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['work_planning_id']][] = $row;     
        }
        
        $sql = "
             select 
            	a.work_planning_id,
            	a.planning_date,
            	a.shift,                
                a.leftout_box,
            	c.company_name as customer,
            	e.customer_PO_No,
            	d.match_plate_no,
            	d.pattern_item,
            	a.planned_box,
            	a1.melting_log_id, 
            	a1.lining_heat_no, 
                a1.heat_code,
            	a1.days_heat_no, 
            	a1.furnace_on_time, 
            	a1.furnace_off_time, 
            	a1.pouring_box, 
            	a1.tapp_temp, 
            	a1.pour_temp, 
            	a1.temp_first_box, 
            	a1.temp_last_box, 
            	a1.start_units, 
            	a1.end_units, 
                a1.ideal_hrs_from, 
                a1.ideal_hrs_to, 
                a1.total_hrs, 
            	a1.remarks,
             from work_planning_info as a
             left join work_order_items_info as b on b.work_order_item_id = a.work_order_item_id
             left join customer_info as c on c.customer_id = a.customer_id
             left join pattern_info as d on d.pattern_id = a.pattern_id 
             left join work_order_info as e on e.work_order_id = a.work_order_id
             left join melting_log_info as a1 on a1.work_planning_id = a.work_planning_id and a1.`status` != 'Delete' and a1.melting_date = '". $srch_date."'
             where a.`status` != 'Delete' and a.leftout_flg = 1 and 
             a.planning_date < '". $srch_date."' and a.shift = '". $srch_shift ."'
             order by a.work_planning_id asc
        
        ";
        
         
        
        $query = $this->db->query($sql);
        
        $data['leftout_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['leftout_list'][$row['work_planning_id']][] = $row;     
        }
        
        $data['shift_opt'] = array('Shift-A' => 'Shift-A' , 'Shift-B' => 'Shift-B', 'Shift-C' => 'Shift-C'); 
		
		
		 
          
        
        $this->load->view('page/production/melting-log',$data); 
    }
    
    public function melting_log()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        
        $data['js'] = 'melting-log.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            
               $ins = array( 
                        'planning_date' => $this->input->post('planning_date'), 
                        'shift' => $this->input->post('shift'), 
                        'melting_date' => $this->input->post('melting_date'), 
                        'lining_heat_no' => $this->input->post('lining_heat_no'), 
                        'heat_code' => $this->input->post('heat_code'), 
                        'days_heat_no' => $this->input->post('days_heat_no'), 
                        'furnace_on_time' => $this->input->post('furnace_on_time'), 
                        'furnace_off_time' => $this->input->post('furnace_off_time'), 
                        'pouring_start_time' => $this->input->post('pouring_start_time'), 
                        'pouring_finish_time' => $this->input->post('pouring_finish_time'),  
                        'tapp_temp' => $this->input->post('tapp_temp'), 
                        //'pour_temp' => $this->input->post('pour_temp'), 
                        'ladle_1_first_box_pour_temp' => $this->input->post('ladle_1_first_box_pour_temp'), 
                        'ladle_2_first_box_pour_temp' => $this->input->post('ladle_2_first_box_pour_temp'), 
                        'start_units' => $this->input->post('start_units'), 
                        'end_units' => $this->input->post('end_units'), 
                        'boring' => $this->input->post('boring'), 
                        'ms' => $this->input->post('ms'), 
                        'foundry_return' => $this->input->post('foundry_return'), 
                        'CI_scrap' => $this->input->post('CI_scrap'), 
                        'pig_iron' => $this->input->post('pig_iron'), 
                        'C' => $this->input->post('C'), 
                        'SI' => $this->input->post('SI'), 
                        'Mn' => $this->input->post('Mn'), 
                        'S' => $this->input->post('S'), 
                        'Cu' => $this->input->post('Cu'), 
                        'Cr' => $this->input->post('Cr'), 
                        'fe_si_mg' => $this->input->post('fe_si_mg'), 
                        'fe_sulphur' => $this->input->post('fe_sulphur'), 
                        'inoculant' => $this->input->post('inoculant'), 
                        'pyrometer_tip' => $this->input->post('pyrometer_tip'), 
                        'graphite_coke' => $this->input->post('graphite_coke'), 
                        'spillage' => $this->input->post('spillage'), 
                        'ni' => $this->input->post('ni'), 
                        'mo' => $this->input->post('mo'), 
                        'fc_operator' => $this->input->post('fc_operator'), 
                        'pouring_person_name_1' => $this->input->post('pouring_person_name_1'), 
                        'pouring_person_name_2' => $this->input->post('pouring_person_name_2'), 
                        'pouring_person_name_3' => $this->input->post('pouring_person_name_3'), 
                        'helper_name' => $this->input->post('helper_name'), 
                        'supervisor' => $this->input->post('supervisor'), 
                        'ideal_hrs_from' => $this->input->post('ideal_hrs_from'), 
                        'ideal_hrs_to' => $this->input->post('ideal_hrs_to'), 
                        'total_hrs' => $this->input->post('total_hrs'), 
                        'remarks' => $this->input->post('remarks'), 
                        'b_c' => $this->input->post('b_c'), 
                        'b_si' => $this->input->post('b_si'), 
                        'b_mn' => $this->input->post('b_mn'), 
                        'b_p' => $this->input->post('b_p'), 
                        'b_s' => $this->input->post('b_s'), 
                        'b_cr' => $this->input->post('b_cr'), 
                        'b_cu' => $this->input->post('b_cu'), 
                        'b_mg' => $this->input->post('b_mg'), 
                        'b_bmn' => $this->input->post('b_bmn'), 
                        'f_c' => $this->input->post('f_c'), 
                        'f_si' => $this->input->post('f_si'), 
                        'f_mn' => $this->input->post('f_mn'), 
                        'f_p' => $this->input->post('f_p'), 
                        'f_s' => $this->input->post('f_s'), 
                        'f_cr' => $this->input->post('f_cr'), 
                        'f_cu' => $this->input->post('f_cu'), 
                        'f_mg' => $this->input->post('f_mg'), 
                        'f_bmn' => $this->input->post('f_bmn'), 
                        'tensile' => $this->input->post('tensile'),
                        'elongation' => $this->input->post('elongation'),
                        'yield_strength' => $this->input->post('yield_strength'),
                        'status' => 'Active', 
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s')                           
                );
            
                $this->db->insert('melting_heat_log_info', $ins); 
                $melting_heat_log_id = $this->db->insert_id();
                
                $this->session->set_userdata('pouring_person_name_1', $this->input->post('pouring_person_name_1')); 
                $this->session->set_userdata('pouring_person_name_2', $this->input->post('pouring_person_name_2')); 
                $this->session->set_userdata('pouring_person_name_3', $this->input->post('pouring_person_name_3')); 
                $this->session->set_userdata('fc_operator', $this->input->post('fc_operator')); 
                $this->session->set_userdata('helper_name', $this->input->post('helper_name')); 
                $this->session->set_userdata('supervisor', $this->input->post('supervisor')); 
                
                
                $work_plan_id = $this->input->post('work_plan_id');
                $leftout_box = $this->input->post('leftout_box');
                $leftout_box_close = $this->input->post('leftout_box_close');
                
                
                foreach($work_plan_id as $plan_id => $box)
                {
                    if(($box > 0) || ($leftout_box[$plan_id] > 0) ){
                        $ins_itm = array(
                                    'melting_heat_log_id' => $melting_heat_log_id,
                                    'work_planning_id' => $plan_id,
                                    'pouring_box' => $box ,
                                    'leftout_box' => $leftout_box[$plan_id], 
                                    'leftout_flg' => ($leftout_box[$plan_id] > 0 ? '1': '0'), 
                                    'leftout_box_close' => ($leftout_box_close[$plan_id] == 1 ? '1': '0') 
                                    );
                        $this->db->insert('melting_item_info', $ins_itm); 
                     }             
                }
                
                $lf_work_plan_id = $this->input->post('lf_work_plan_id');
                $lf_leftout_box = $this->input->post('lf_leftout_box');
                $cf_melting_heat_log_id = $this->input->post('cf_melting_heat_log_id');
                //$leftout_box_close = $this->input->post('leftout_box_close');
                if(!empty($lf_work_plan_id)) {
                    foreach($lf_work_plan_id as $lf_plan_id => $lf_box)
                    {
                        if(($lf_box > 0) || ($lf_leftout_box[$lf_plan_id] > 0) ){
                            $ins_itm = array(
                                        'melting_heat_log_id' => $melting_heat_log_id,
                                        'work_planning_id' => $lf_plan_id,
                                        'pouring_box' => $lf_box ,
                                        'leftout_box' => $lf_leftout_box[$lf_plan_id],
                                        'cf_melting_heat_log_id' =>  $cf_melting_heat_log_id[$lf_plan_id]  ,
                                        'leftout_flg' => ($lf_leftout_box[$lf_plan_id] > 0 ? '1': '0')
                                        );
                            $this->db->insert('melting_item_info', $ins_itm); 
                            
                           /* if($lf_box > 0) {
                                $this->db->where('work_planning_id', $lf_plan_id);
                                $this->db->where('leftout_flg', '1');
                                $this->db->update('melting_item_info', array('leftout_flg' => '0'));
                            }*/
                            
                         }             
                    }
                }
           
            redirect('melting-log');  
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                        'planning_date' => $this->input->post('planning_date'), 
                        'shift' => $this->input->post('shift'), 
                        'melting_date' => $this->input->post('melting_date'), 
                        'lining_heat_no' => $this->input->post('lining_heat_no'), 
                        'heat_code' => $this->input->post('heat_code'), 
                        'days_heat_no' => $this->input->post('days_heat_no'), 
                        'furnace_on_time' => $this->input->post('furnace_on_time'), 
                        'furnace_off_time' => $this->input->post('furnace_off_time'), 
                        'pouring_start_time' => $this->input->post('pouring_start_time'), 
                        'pouring_finish_time' => $this->input->post('pouring_finish_time'),  
                        'tapp_temp' => $this->input->post('tapp_temp'), 
                       // 'pour_temp' => $this->input->post('pour_temp'), 
                        'ladle_1_first_box_pour_temp' => $this->input->post('ladle_1_first_box_pour_temp'), 
                        'ladle_2_first_box_pour_temp' => $this->input->post('ladle_2_first_box_pour_temp'), 
                        'start_units' => $this->input->post('start_units'), 
                        'end_units' => $this->input->post('end_units'), 
                        'boring' => $this->input->post('boring'), 
                        'ms' => $this->input->post('ms'), 
                        'foundry_return' => $this->input->post('foundry_return'), 
                        'CI_scrap' => $this->input->post('CI_scrap'), 
                        'pig_iron' => $this->input->post('pig_iron'), 
                        'C' => $this->input->post('C'), 
                        'SI' => $this->input->post('SI'), 
                        'Mn' => $this->input->post('Mn'), 
                        'S' => $this->input->post('S'), 
                        'Cu' => $this->input->post('Cu'), 
                        'Cr' => $this->input->post('Cr'), 
                        'fe_si_mg' => $this->input->post('fe_si_mg'), 
                        'fe_sulphur' => $this->input->post('fe_sulphur'), 
                        'inoculant' => $this->input->post('inoculant'), 
                        'pyrometer_tip' => $this->input->post('pyrometer_tip'), 
                        'graphite_coke' => $this->input->post('graphite_coke'),
                        'spillage' => $this->input->post('spillage'), 
                        'ni' => $this->input->post('ni'), 
                        'mo' => $this->input->post('mo'), 
                        'fc_operator' => $this->input->post('fc_operator'), 
                        'pouring_person_name_1' => $this->input->post('pouring_person_name_1'), 
                        'pouring_person_name_2' => $this->input->post('pouring_person_name_2'), 
                        'pouring_person_name_3' => $this->input->post('pouring_person_name_3'), 
                        'helper_name' => $this->input->post('helper_name'), 
                        'supervisor' => $this->input->post('supervisor'), 
                        'ideal_hrs_from' => $this->input->post('ideal_hrs_from'), 
                        'ideal_hrs_to' => $this->input->post('ideal_hrs_to'), 
                        'total_hrs' => $this->input->post('total_hrs'), 
                        'remarks' => $this->input->post('remarks'), 
                        'b_c' => $this->input->post('b_c'), 
                        'b_si' => $this->input->post('b_si'), 
                        'b_mn' => $this->input->post('b_mn'), 
                        'b_p' => $this->input->post('b_p'), 
                        'b_s' => $this->input->post('b_s'), 
                        'b_cr' => $this->input->post('b_cr'), 
                        'b_cu' => $this->input->post('b_cu'), 
                        'b_mg' => $this->input->post('b_mg'), 
                        'b_bmn' => $this->input->post('b_bmn'), 
                        'f_c' => $this->input->post('f_c'), 
                        'f_si' => $this->input->post('f_si'), 
                        'f_mn' => $this->input->post('f_mn'), 
                        'f_p' => $this->input->post('f_p'), 
                        'f_s' => $this->input->post('f_s'), 
                        'f_cr' => $this->input->post('f_cr'), 
                        'f_cu' => $this->input->post('f_cu'), 
                        'f_mg' => $this->input->post('f_mg'), 
                        'f_bmn' => $this->input->post('f_bmn'),
                        'tensile' => $this->input->post('tensile'),
                        'elongation' => $this->input->post('elongation'),
                        'yield_strength' => $this->input->post('yield_strength'),
                        'status' => 'Active', 
                        'updated_by' => $this->session->userdata('cr_user_id'),                          
                        'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('melting_heat_log_id', $this->input->post('melting_heat_log_id'));
            $this->db->update('melting_heat_log_info', $upd); 
            
            
            $this->db->delete('melting_item_info', 'melting_heat_log_id = ' . $this->input->post('melting_heat_log_id')); 
            //$this->db->delete('melting_item_chemical_info', 'melting_heat_log_id = ' . $this->input->post('melting_heat_log_id')); 
            
            $work_plan_id = $this->input->post('work_plan_id');
            $leftout_box = $this->input->post('leftout_box');
            $ed_cf_melting_heat_log_id = $this->input->post('ed_cf_melting_heat_log_id');
            $leftout_box_close = $this->input->post('leftout_box_close');
                
            foreach($work_plan_id as $plan_id => $box)
            {
                if(($box > 0) or ($leftout_box[$plan_id] > 0)){
                    $ins_itm = array(
                                'melting_heat_log_id' => $this->input->post('melting_heat_log_id'),
                                'work_planning_id' => $plan_id,
                                'pouring_box' => $box ,
                                'leftout_box' => $leftout_box[$plan_id] ,
                                'cf_melting_heat_log_id' =>  (isset($ed_cf_melting_heat_log_id[$plan_id]) ? $ed_cf_melting_heat_log_id[$plan_id] : 0)  ,
                                'leftout_flg' => ($leftout_box[$plan_id] > 0 ? '1': '0'), 
                                'leftout_box_close' => ($leftout_box_close[$plan_id] == 1 ? '1': '0')
                                );
                    $this->db->insert('melting_item_info', $ins_itm);
                    
                    $melting_item_id = $this->db->insert_id();
                    
                    $this->db->where('melting_heat_log_id', $this->input->post('melting_heat_log_id'));
                    $this->db->update('melting_item_chemical_info',array('melting_item_id' => $melting_item_id));
                    
                    
                    $this->db->where('melting_heat_log_id', $this->input->post('melting_heat_log_id'));
                    $this->db->where("work_planning_id in (select a1.work_planning_id from work_planning_info as a1  where a1.`status`!= 'Delete' and a1.prt_work_plan_id = '". $plan_id. "' )");
                    $this->db->delete('melting_child_item_info');
                    
                    $this->db->query("insert into melting_child_item_info (melting_heat_log_id,work_planning_id,produced_qty) (
                                        select
                                        '". $this->input->post('melting_heat_log_id') ."' as melting_heat_log_id,
                                        a1.work_planning_id, 
                                        (ifnull(a1.no_of_cavity,b1.no_of_cavity) * '". $box ."') as produced_qty
                                        from work_planning_info as a1  
                                        left join pattern_info as b1 on b1.pattern_id = a1.pattern_id 
                                        where a1.`status`!= 'Delete' and a1.prt_work_plan_id = '". $plan_id ."' 
                                        )");
                     
                    /*$this->db->where('work_planning_id', $plan_id);
                    $this->db->update('work_planning_info', array('leftout_flg' => '1' , 'leftout_box' =>  $leftout_box[$plan_id]));*/
                    
                 }             
            }
            
            $lf_work_plan_id = $this->input->post('lf_work_plan_id');
            $lf_leftout_box = $this->input->post('lf_leftout_box');
            $cf_melting_heat_log_id = $this->input->post('cf_melting_heat_log_id');
            if(!empty($lf_work_plan_id)) {
                foreach($lf_work_plan_id as $lf_plan_id => $lf_box)
                {
                    if(($lf_box > 0) || ($lf_leftout_box[$lf_plan_id] > 0) ){
                        $ins_itm = array(
                                    'melting_heat_log_id' => $this->input->post('melting_heat_log_id'),
                                    'work_planning_id' => $lf_plan_id,
                                    'pouring_box' => $lf_box ,
                                    'leftout_box' => $lf_leftout_box[$lf_plan_id],
                                    'cf_melting_heat_log_id' =>  $cf_melting_heat_log_id[$lf_plan_id]  ,
                                    'leftout_flg' => ($lf_leftout_box[$lf_plan_id] > 0 ? '1': '0')
                                    );
                        $this->db->insert('melting_item_info', $ins_itm); 
                        
                        /*if($lf_box > 0) {
                            $this->db->where('work_planning_id', $lf_plan_id);
                            $this->db->where('leftout_flg', '1');
                            $this->db->update('melting_item_info', array('leftout_flg' => '0'));
                        }*/
                        
                    $this->db->where('melting_heat_log_id', $this->input->post('melting_heat_log_id'));
                    $this->db->where("work_planning_id in (select a1.work_planning_id from work_planning_info as a1  where a1.`status`!= 'Delete' and a1.prt_work_plan_id = '". $lf_plan_id. "' )");
                    $this->db->delete('melting_child_item_info');
                    
                    $this->db->query("insert into melting_child_item_info (melting_heat_log_id,work_planning_id,produced_qty) (
                                        select
                                        '". $this->input->post('melting_heat_log_id') ."' as melting_heat_log_id,
                                        a1.work_planning_id, 
                                        (ifnull(a1.no_of_cavity,1) * '". $lf_box ."') as produced_qty
                                        from work_planning_info as a1  
                                        where a1.`status`!= 'Delete' and a1.prt_work_plan_id = '". $lf_plan_id ."' 
                                        )");
                     
                        
                     }             
                }
            }
                            
            redirect('melting-log');  
        } 
        
       if($this->session->userdata('pouring_person_name_1')) {
           $data['pouring_person_name_1'] = $this->session->userdata('pouring_person_name_1') ; 
           $data['pouring_person_name_2'] = $this->session->userdata('pouring_person_name_2') ; 
           $data['pouring_person_name_3'] = $this->session->userdata('pouring_person_name_3') ; 
           $data['fc_operator'] = $this->session->userdata('fc_operator') ; 
           $data['helper_name'] = $this->session->userdata('helper_name') ;    
           $data['supervisor'] = $this->session->userdata('supervisor') ;    
           
       } else {
           $data['pouring_person_name_1'] = '' ; 
           $data['pouring_person_name_2'] = '' ; 
           $data['pouring_person_name_3'] = '' ; 
           $data['fc_operator'] = '' ; 
           $data['helper_name'] = '' ;  
           $data['supervisor'] = '' ;  
       }    
        
        
       if(isset($_POST['srch_date'])) {
           $data['srch_date'] = $srch_date = $this->input->post('srch_date'); 
           $this->session->set_userdata('srch_date', $this->input->post('srch_date'));  
       } elseif($this->session->userdata('srch_date')) {
           $data['srch_date'] = $srch_date = $this->session->userdata('srch_date') ; 
       } else {
           $data['srch_date'] = $srch_date = date('Y-m-d');
       }
       
       if(isset($_POST['srch_shift'])) {
           $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift');
           $this->session->set_userdata('srch_shift', $this->input->post('srch_shift'));     
       } elseif($this->session->userdata('srch_shift')) {
           $data['srch_shift'] = $srch_shift = $this->session->userdata('srch_shift') ; 
       } else {
        $data['srch_shift'] =  $srch_shift = '';
       }
        
        
        
        
        /*$this->db->select('a.work_planning_id'); 
        $this->db->where('a.status != ', 'Delete'); 
        $this->db->where("a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'");
        $this->db->from('work_planning_info as a');  */
        
        $months = array("A" => 'Jan', "B" => 'Feb', "C" => 'Mar', "D" => 'Apr', "E" => 'May', "F" => 'Jun', "G" => 'Jul', "H" => 'Aug', "J" => 'Sep', "K" => 'Oct', "L" => 'Nov', "M" => 'Dec');
        
        
        $this->db->select('(ifnull(max(days_heat_no),0) + 1) as days_heat_no');
        $this->db->where('melting_date', $srch_date);
        $query = $this->db->get('melting_heat_log_info');
        $row = $query->row();
        if (isset($row)) {
           $data['days_heat_no'] = str_pad($row->days_heat_no,2,0,STR_PAD_LEFT);
        }  
        
        
        /*
        $sql = "select a.work_planning_id,a.planning_date from work_planning_info as a where a.status != 'Delete' and a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
               // $data['work_planning_id'] = $row->work_planning_id;
                $va = array_keys($months, date('M',strtotime($row->planning_date)));
                $data['heat_code'] = date('y',strtotime($row->planning_date)). $va[0] . date('d',strtotime($row->planning_date));
        }
        */
        $va = array_keys($months, date('M',strtotime($srch_date)));
        $data['heat_code'] = date('y',strtotime($srch_date)). $va[0] . date('d',strtotime($srch_date));
       
       
       
        $sql = "
                select 
                a.work_planning_id, 
                c.customer_PO_No,               
                a.planning_date,
                b.pattern_item,
                a.planned_box,
                d.poured_box ,
				a.status,
				b.pattern_id				
                from work_planning_info as a 
                left join pattern_info as b on b.pattern_id = a.pattern_id
                left join work_order_info as c on c.work_order_id = a.work_order_id
                left join ( select z.work_planning_id , sum(z.pouring_box) as poured_box from melting_item_info as z where z.status = 'Active' group by z.work_planning_id ) as d on d.work_planning_id = a.work_planning_id
                where a.status != 'Delete' and a.planning_date = '". $srch_date."' 
                and a.shift = '". $srch_shift ."' 
                and a.planned_box > 0
                order by b.pattern_item asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['work_planning_itms'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['work_planning_itms'][] = $row;     
        }
        
        
     /*    $sql = "
                select 
                 b.melting_item_id,   
                 a.melting_heat_log_id,
                 b.work_planning_id,                
                 a.planning_date,
                 a.melting_date as leftout_date,
                 e.pattern_item,
                 b.leftout_box ,
                 f.customer_PO_No 
                 from melting_heat_log_info as a 
                 left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
                 left join work_planning_info as c on c.work_planning_id = b.work_planning_id 
                 left join pattern_info as e on e.pattern_id = c.pattern_id
                 left join work_order_info as f on f.work_order_id = c.work_order_id
                 where a.`status` = 'Active' and c.status != 'Delete' 
                 and a.melting_date < '". $srch_date."' and b.leftout_box > 0 and b.leftout_box_close = 0
                 and not exists ( select * from melting_item_info as z where z.cf_melting_heat_log_id = a.melting_heat_log_id ) 
                 order by b.melting_item_id               
          ";*/ 
          
        $sql = "
        select 
        b.melting_item_id,   
        a.melting_heat_log_id,
        b.work_planning_id,                
        a.planning_date,
        a.melting_date as leftout_date,
        e.pattern_item,
        b.leftout_box as act_leftout_box,
        ifnull(g.leftout_pouring_box,0) as leftout_pouring_box,
        (b.leftout_box - ifnull(g.leftout_pouring_box,0) ) as leftout_box,
        f.customer_PO_No ,
		e.pattern_id 
        from melting_heat_log_info as a 
        left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
        left join work_planning_info as c on c.work_planning_id = b.work_planning_id 
        left join pattern_info as e on e.pattern_id = c.pattern_id
        left join work_order_info as f on f.work_order_id = c.work_order_id
        left join (select z.cf_melting_heat_log_id , z.work_planning_id ,  sum(z.pouring_box) as leftout_pouring_box from melting_item_info as z where z.status = 'Active' group by z.cf_melting_heat_log_id ,z.work_planning_id) as g on g.cf_melting_heat_log_id = a.melting_heat_log_id and g.work_planning_id = b.work_planning_id
        where a.`status` = 'Active' and c.status != 'Delete' and b.`status` = 'Active'
        and a.melting_date <= '". $srch_date."' and b.leftout_box > 0 and b.leftout_box_close = 0
        and  (b.leftout_box - ifnull(g.leftout_pouring_box,0) ) > 0
        order by b.melting_item_id
        ";  
        
        $query = $this->db->query($sql);
        
        $data['leftout_itms'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['leftout_itms'][] = $row;     
        }
        
        
        $sql = "
                select 
                a.employee_id,                
                a.employee_name             
                from employee_info as a  
                where status = 'Active' 
                order by a.employee_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['employee_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['employee_opt'][$row['employee_name']] = $row['employee_name'];     
        }
        
        
      /*  $sql = "
             select 
            	a.work_planning_id,
            	a.planning_date,
            	a.shift,
            	c.company_name as customer,
            	e.customer_PO_No,
            	d.match_plate_no,
            	d.pattern_item,
            	a.planned_box,
            	a1.melting_log_id, 
            	a1.lining_heat_no, 
                a1.heat_code,
            	a1.days_heat_no, 
            	a1.furnace_on_time, 
            	a1.furnace_off_time, 
            	a1.pouring_box, 
            	a1.tapp_temp, 
            	a1.pour_temp, 
            	a1.temp_first_box, 
            	a1.temp_last_box, 
            	a1.start_units, 
            	a1.end_units, 
                a1.ideal_hrs_from, 
                a1.ideal_hrs_to, 
                a1.total_hrs, 
            	a1.remarks
             from work_planning_info as a
             left join work_order_items_info as b on b.work_order_item_id = a.work_order_item_id
             left join customer_info as c on c.customer_id = a.customer_id
             left join pattern_info as d on d.pattern_id = a.pattern_id 
             left join work_order_info as e on e.work_order_id = a.work_order_id
             left join melting_log_info as a1 on a1.work_planning_id = a.work_planning_id and a1.`status` != 'Delete'
             where a.`status` != 'Delete' and
             a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'
             order by a.work_planning_id asc ";
        */     
             
        $sql = "      
            select 
                a.melting_heat_log_id, 
                a.planning_date, 
                a.shift, 
                a.melting_date, 
                a.lining_heat_no, 
                a.heat_code, 
                a.days_heat_no, 
                a.furnace_on_time, 
                a.furnace_off_time,  
                a.pouring_start_time, 
                a.pouring_finish_time, 
                a.start_units, 
                a.end_units, 
                a.ideal_hrs_from, 
                a.ideal_hrs_to ,
                TIMEDIFF(a.furnace_off_time,a.furnace_on_time) as furnace_time,
                TIMEDIFF(a.pouring_finish_time,a.pouring_start_time) as pouring_time, 
                (a.end_units - a.start_units) as units, 
                TIMEDIFF(a.ideal_hrs_to,a.ideal_hrs_from ) as ideal_hrs ,
                DATEDIFF(current_date(), a.melting_date) as days  
                from melting_heat_log_info as a 
                where a.`status` = 'Active'  
                and a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'
                order by a.melting_heat_log_id
        ";
        
         
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        if(!empty($data['record_list'])){
            
           /* $sql = "  
                    select 
                    b.work_planning_id,                
                    a.melting_date,
                    d.pattern_item,
                    b.pouring_box ,
                    b.cf_melting_heat_log_id  
                    from melting_heat_log_info as a
                    left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
                    left join work_planning_info as c on c.work_planning_id = b.work_planning_id
                    left join pattern_info as d on d.pattern_id = c.pattern_id
                    where a.melting_date = '". $srch_date."' and a.shift = '". $srch_shift ."' 
                    and a.`status` = 'Active' 
                    group by b.work_planning_id 
                    order by a.melting_heat_log_id , b.melting_item_id asc  
                                  
            ";*/
            
            $sql = "  
                    
                    SELECT 
                    b.work_planning_id, 
                    d.pattern_item,
                    b.cf_melting_heat_log_id,
                    f.customer_PO_No ,
                    b.leftout_box_close,
					d.pattern_id
                    FROM melting_item_info AS b
                    LEFT JOIN work_planning_info AS c ON c.work_planning_id = b.work_planning_id
                    LEFT JOIN pattern_info AS d ON d.pattern_id = c.pattern_id
                    left join work_order_info as f on f.work_order_id = c.work_order_id
                    WHERE b.melting_heat_log_id
                    IN (                    
                    SELECT melting_heat_log_id
                    FROM `melting_heat_log_info`
                    WHERE `melting_date` =  '". $srch_date."' and shift = '". $srch_shift ."' 
                    AND `status` = 'Active'
                    )
                    and b.`status` = 'Active' and c.`status` != 'Delete'
                    GROUP BY b.work_planning_id
                    ORDER BY d.pattern_item ASC               
            "; 
            
            $query = $this->db->query($sql);
            
            $data['work_planning_itms_lft'] = array();
            $data['melting_work_planning_ids'] = array();
           
            foreach ($query->result_array() as $row)
            {
                $data['work_planning_itms_lft'][] = $row;  
                $data['melting_work_planning_ids'][] = $row['work_planning_id'];  
                   
            }
        }
      
      
      /*  
         
        
        $sql = "
             select 
            	a.work_planning_id,
            	a.planning_date,
            	a.shift,                
                a.leftout_box,
            	c.company_name as customer,
            	e.customer_PO_No,
            	d.match_plate_no,
            	d.pattern_item,
            	a.planned_box,
            	a1.melting_log_id, 
            	a1.lining_heat_no, 
                a1.heat_code,
            	a1.days_heat_no, 
            	a1.furnace_on_time, 
            	a1.furnace_off_time, 
            	a1.pouring_box, 
            	a1.tapp_temp, 
            	a1.pour_temp, 
            	a1.temp_first_box, 
            	a1.temp_last_box, 
            	a1.start_units, 
            	a1.end_units, 
                a1.ideal_hrs_from, 
                a1.ideal_hrs_to, 
                a1.total_hrs, 
            	a1.remarks
             from work_planning_info as a
             left join work_order_items_info as b on b.work_order_item_id = a.work_order_item_id
             left join customer_info as c on c.customer_id = a.customer_id
             left join pattern_info as d on d.pattern_id = a.pattern_id 
             left join work_order_info as e on e.work_order_id = a.work_order_id
             left join melting_log_info as a1 on a1.work_planning_id = a.work_planning_id and a1.`status` != 'Delete' and a1.melting_date = '". $srch_date."'
             where a.`status` != 'Delete' and a.leftout_flg = 1 and 
             a.planning_date < '". $srch_date."' and a.shift = '". $srch_shift ."'
             order by a.work_planning_id asc
        
        ";
        
         
        
        $query = $this->db->query($sql);
        
        $data['leftout_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['leftout_list'][$row['work_planning_id']][] = $row;     
        }
        
        */
        
        $data['shift_opt'] = array('Shift-A' => 'Shift-A' , 'Shift-B' => 'Shift-B', 'Shift-C' => 'Shift-C'); 
		
		 $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'CCHR'
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
          
        
        $this->load->view('page/production/melting-log',$data); 
    }

    public function quality_check_v2()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect(); 
        
        $data['js'] = 'qc-v2.js';  

        if($this->input->post('btn-save') == 'Save') 
        {
             
            // echo "<pre>";
            // print_r($_POST);    
            // echo "</pre>";
            //redirect('quality-check-v2'); 

            $qc_inspection_id = $this->input->post('qc_inspection_id');
            $rejection_qty = $this->input->post('rejection_qty');
            foreach($rejection_qty as $m_log_id => $rej_det) 
            { 
                foreach($rej_det as $r_typ_id => $qty) 
                {
                        if($qc_inspection_id[$m_log_id][$r_typ_id] > 0) 
                        {
                            $upd = array(                                
                                
                                'qc_date' => $this->input->post('srch_qc_date'), 
                                'work_planning_id' => $this->input->post('work_planning_id'),
                                'melting_heat_log_id' => $m_log_id,
                                'rejection_group' => $this->input->post('srch_rejection_group'), 
                                'rejection_type_id' => $r_typ_id, 
                                'rejection_qty' => $qty,  
                                'shift_supervisor' => $this->input->post('shift_supervisor'),  
                                'tumblast_machine_operator' => $this->input->post('tumblast_machine_operator'),  
                                'shot_blastng_machine_operator' => $this->input->post('shot_blastng_machine_operator'),  
                                'ag4_machine_operator' => $this->input->post('ag4_machine_operator'),  
                                'contractor_grinding_machine_operator' => $this->input->post('contractor_grinding_machine_operator'),  
                                'company_grinding_machine_operator' => $this->input->post('company_grinding_machine_operator'),  
                                'painting_person' => $this->input->post('painting_person'),  
                                'factory_manager' => $this->input->post('factory_manager'),  
                                'status' => 'Active',
                                'updated_by' => $this->session->userdata('cr_user_id'),                          
                                'updated_datetime' => date('Y-m-d H:i:s')                           
                            );                        
                            $this->db->where('qc_inspection_id', $qc_inspection_id[$m_log_id][$r_typ_id]);
                            $this->db->update('qc_inspection_info', $upd); 
                            
                        } else {
                            if($qty > 0) 
                            {                        
                                $ins = array( 
                                    'qc_date' => $this->input->post('srch_qc_date'), 
                                    'work_planning_id' => $this->input->post('work_planning_id'),
                                    'melting_heat_log_id' => $m_log_id,
                                    'rejection_group' => $this->input->post('srch_rejection_group'), 
                                    'rejection_type_id' => $r_typ_id, 
                                    'rejection_qty' => $qty,  
                                    'shift_supervisor' => $this->input->post('shift_supervisor'),  
                                    'tumblast_machine_operator' => $this->input->post('tumblast_machine_operator'),  
                                    'shot_blastng_machine_operator' => $this->input->post('shot_blastng_machine_operator'),  
                                    'ag4_machine_operator' => $this->input->post('ag4_machine_operator'),  
                                    'contractor_grinding_machine_operator' => $this->input->post('contractor_grinding_machine_operator'),  
                                    'company_grinding_machine_operator' => $this->input->post('company_grinding_machine_operator'),  
                                    'painting_person' => $this->input->post('painting_person'),  
                                    'factory_manager' => $this->input->post('factory_manager'),  
                                    'status' => 'Active',
                                    'created_by' => $this->session->userdata('cr_user_id'),                          
                                    'created_datetime' => date('Y-m-d H:i:s'),
                                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                                    'updated_datetime' => date('Y-m-d H:i:s')                                  
                                );
                            
                                $this->db->insert('qc_inspection_info', $ins);  
                            }
                        }   
                } 
            }
                             
             $this->session->set_userdata('srch_date', $this->input->post('srch_date'));    
             $this->session->set_userdata('srch_shift', $this->input->post('srch_shift')); 
             $this->session->set_userdata('srch_pattern_id', $this->input->post('srch_pattern_id'));             
             $this->session->set_userdata('srch_rejection_group', $this->input->post('srch_rejection_group'));  
             $this->session->set_userdata('srch_qc_date', $this->input->post('srch_qc_date'));  
            redirect('quality-check');
        }

       if(isset($_POST['srch_date'])) {
           $data['srch_date'] = $srch_date = $this->input->post('srch_date'); 
           $this->session->set_userdata('srch_date', $this->input->post('srch_date'));  
       } elseif($this->session->userdata('srch_date')) {
           $data['srch_date'] = $srch_date = $this->session->userdata('srch_date') ; 
       } else {
           $data['srch_date'] = $srch_date = date('Y-m-d');
       }
       
       if(isset($_POST['srch_shift'])) {
           $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift');
           $this->session->set_userdata('srch_shift', $this->input->post('srch_shift'));     
       } elseif($this->session->userdata('srch_shift')) {
           $data['srch_shift'] = $srch_shift = $this->session->userdata('srch_shift') ; 
       } else {
            $data['srch_shift'] =  $srch_shift = '';
       }

        if(isset($_POST['srch_customer'])) {
            $data['srch_customer'] = $srch_customer = $this->input->post('srch_customer'); 
            $this->session->set_userdata('srch_customer', $this->input->post('srch_customer'));     
        } elseif($this->session->userdata('srch_customer')) {
           $data['srch_customer'] = $srch_customer = $this->session->userdata('srch_customer') ; 
        } else {
            $data['srch_customer'] =  $srch_customer = '';
        }
        
        if(isset($_POST['srch_pattern_id'])) {
            $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
            $this->session->set_userdata('srch_pattern_id', $this->input->post('srch_pattern_id'));    
        } elseif($this->session->userdata('srch_pattern_id')) {
           $data['srch_pattern_id'] = $srch_pattern_id = $this->session->userdata('srch_pattern_id') ; 
        } else {
            $data['srch_pattern_id'] =  $srch_pattern_id = '';
        }

        if(isset($_POST['srch_rejection_group'])) {
            $data['srch_rejection_group'] = $srch_rejection_group = $this->input->post('srch_rejection_group');    
            $this->session->set_userdata('srch_rejection_group', $this->input->post('srch_rejection_group'));    
        } elseif($this->session->userdata('srch_rejection_group')) {
           $data['srch_rejection_group'] = $srch_rejection_group = $this->session->userdata('srch_rejection_group') ; 
        } else {
            $data['srch_rejection_group'] =  $srch_rejection_group = '';
        }

        if(isset($_POST['srch_qc_date'])) {
            $data['srch_qc_date'] = $srch_qc_date = $this->input->post('srch_qc_date');    
            $this->session->set_userdata('srch_qc_date', $this->input->post('srch_qc_date'));    
        } elseif($this->session->userdata('srch_qc_date')) {
           $data['srch_qc_date'] = $srch_qc_date = $this->session->userdata('srch_qc_date') ; 
        } else {
            $data['srch_qc_date'] =  $srch_qc_date = date('Y-m-d');
        }
        
        

        $data['rejection_group_opt'] = array('' => 'Select'); 
        $data['employee_opt'] = array('' => 'Select');
        $data['customer_opt'] = array();
        $data['pattern_itm_opt'] = array('' => 'Select');

        $data['shift_opt'] = array('Shift-A' => 'Shift-A' , 'Shift-B' => 'Shift-B', 'Shift-C' => 'Shift-C'); 
        
        
        $sql = "
                select                
                a.rejection_group_name             
                from rejection_group_info as a   
                where a.level = 1
                order by a.rejection_group_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['rejection_group_opt'][$row['rejection_group_name']] = $row['rejection_group_name'] ;     
        }
        
        if($srch_rejection_group != '') 
        {

            $sql = "
                select 
                a.pattern_id,
                b.pattern_item  
                from work_planning_info as a
                left join pattern_info as b on b.pattern_id = a.pattern_id 
                where a.planning_date = '". $srch_date."' 
                and a.shift = '". $srch_shift ."'  
                and a.`status` != 'Delete'
                and b.`status` = 'Active'
                group by a.pattern_id
                order by b.pattern_item Asc 
            ";
            $query = $this->db->query($sql); 
            foreach ($query->result_array() as $row)
            {
                $data['pattern_itm_opt'][$row['pattern_id']] = $row['pattern_item'];      
            } 
        
            $sql = "
                    select 
                    a.employee_id,                
                    a.employee_name             
                    from employee_info as a  
                    where status = 'Active' 
                    order by a.employee_name asc                 
            "; 
            
            $query = $this->db->query($sql);
            
            $data['employee_opt'] = array(); 
        
            foreach ($query->result_array() as $row)
            {
                $data['employee_opt'][$row['employee_name']] = $row['employee_name'];      
            } 

            

             $data['record_list'] = array(); 
             $data['rejection_type_opt'] = array(); 

            if($srch_date != '' && $srch_shift != '' && $srch_pattern_id != ''  && $srch_qc_date != '' ) 
            { 
             $sql =  "
                    select 
                    a.rejection_type_id, 
                    a.rejection_type_name ,
                    a.rej_code
                    from rejection_type_info as a
                    where a.status='Active' and a.rejection_group = '". $srch_rejection_group ."'
                    order by a.rejection_type_name asc 
                    ";
            $query = $this->db->query($sql);
            
            $data['rejection_type_opt'] = $query->result_array();      


             $sql = "
                select 
                z.melting_heat_log_id ,
                z.work_planning_id,  
                concat(s.heat_code ,s.days_heat_no) as heat_code,
                z.prod_qty ,
                group_concat(q.rejection_type_id) as rejection_type_id,
                group_concat(q.rejection_qty) as rejection_qty ,
                group_concat(q.qc_inspection_id) as qc_inspection_id ,
                q.shift_supervisor,
                q.tumblast_machine_operator,
                q.shot_blastng_machine_operator,
                q.ag4_machine_operator,
                q.contractor_grinding_machine_operator,
                q.company_grinding_machine_operator,    
                q.painting_person,
                q.factory_manager 
                from 
                (
                    (   
                        select 
                        a.melting_heat_log_id,
                        a.work_planning_id,
                        sum(a.produced_qty) as prod_qty 
                        from melting_item_info as a
                        left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                        where a.`status` != 'Delete'
                        and b.`status`  != 'Delete'
                        and b.planning_date = '". $srch_date."'  
                        and b.shift = '". $srch_shift."'
                        and b.pattern_id =  '". $srch_pattern_id."'
                        group by a.work_planning_id , a.melting_heat_log_id
                        order by a.melting_heat_log_id
                    ) UNION ALL (
                        select 
                        a.melting_heat_log_id,
                        a.work_planning_id ,
                        sum(a.produced_qty) as prod_qty 
                        from melting_child_item_info as a
                        left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                        where a.`status` != 'Delete'
                        and b.`status`  != 'Delete'
                        and b.planning_date = '". $srch_date."'  
                        and b.shift = '". $srch_shift."'
                        and b.pattern_id =  '". $srch_pattern_id."'
                        group by a.work_planning_id , a.melting_heat_log_id
                        order by a.melting_heat_log_id
                    )
                ) as z
                left join melting_heat_log_info as s on s.melting_heat_log_id = z.melting_heat_log_id
                left join qc_inspection_info as q on q.melting_heat_log_id = z.melting_heat_log_id and q.work_planning_id = z.work_planning_id and q.`status` = 'Active' and q.qc_date = '". $srch_qc_date ."'
                 
                where 1=1
                group by z.melting_heat_log_id
                order by s.heat_code , s.days_heat_no  
                ";
            $query = $this->db->query($sql);
           
            $data['record_list'] = $query->result_array();    
        }

        }
        
        $this->load->view('page/production/quality-check-v2',$data); 
    }
    
    public function quality_check()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        
        $data['js'] = 'qc.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            
               $ins = array( 
                        'work_planning_id' => $this->input->post('work_planning_id'),
                        'melting_heat_log_id' => $this->input->post('melting_heat_log_id'),
                        'qc_date' => $this->input->post('qc_date'), 
                        'rejection_group' => $this->input->post('rejection_group'), 
                        'rejection_type_id' => $this->input->post('rejection_type_id'), 
                        'rejection_qty' => $this->input->post('rejection_qty'),  
                        'shift_supervisor' => $this->input->post('shift_supervisor'),  
                        'tumblast_machine_operator' => $this->input->post('tumblast_machine_operator'),  
                        'shot_blastng_machine_operator' => $this->input->post('shot_blastng_machine_operator'),  
                        'ag4_machine_operator' => $this->input->post('ag4_machine_operator'),  
                        'contractor_grinding_machine_operator' => $this->input->post('contractor_grinding_machine_operator'),  
                        'company_grinding_machine_operator' => $this->input->post('company_grinding_machine_operator'),  
                        'painting_person' => $this->input->post('painting_person'),  
                        'factory_manager' => $this->input->post('factory_manager'),  
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s')                           
                );
            
                $this->db->insert('qc_inspection_info', $ins); 
                
                $this->session->set_userdata('shift_supervisor', $this->input->post('shift_supervisor'));  
                $this->session->set_userdata('tumblast_machine_operator', $this->input->post('tumblast_machine_operator'));  
                $this->session->set_userdata('shot_blastng_machine_operator', $this->input->post('shot_blastng_machine_operator'));  
                $this->session->set_userdata('ag4_machine_operator', $this->input->post('ag4_machine_operator'));  
                $this->session->set_userdata('contractor_grinding_machine_operator', $this->input->post('contractor_grinding_machine_operator'));  
                $this->session->set_userdata('company_grinding_machine_operator', $this->input->post('company_grinding_machine_operator'));  
                $this->session->set_userdata('painting_person', $this->input->post('painting_person'));  
                $this->session->set_userdata('factory_manager', $this->input->post('factory_manager'));  
                
           
            redirect('quality-check');  
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                        'work_planning_id' => $this->input->post('work_planning_id'),
                        'melting_heat_log_id' => $this->input->post('melting_heat_log_id'),
                        'qc_date' => $this->input->post('qc_date'), 
                        'rejection_group' => $this->input->post('rejection_group'), 
                        'rejection_type_id' => $this->input->post('rejection_type_id'), 
                        'rejection_qty' => $this->input->post('rejection_qty'), 
                        'shift_supervisor' => $this->input->post('shift_supervisor'),  
                        'tumblast_machine_operator' => $this->input->post('tumblast_machine_operator'),  
                        'shot_blastng_machine_operator' => $this->input->post('shot_blastng_machine_operator'),  
                        'ag4_machine_operator' => $this->input->post('ag4_machine_operator'),  
                        'contractor_grinding_machine_operator' => $this->input->post('contractor_grinding_machine_operator'),  
                        'company_grinding_machine_operator' => $this->input->post('company_grinding_machine_operator'),  
                        'painting_person' => $this->input->post('painting_person'),  
                        'factory_manager' => $this->input->post('factory_manager'),  
                        'updated_by' => $this->session->userdata('cr_user_id'),                          
                        'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('qc_inspection_id', $this->input->post('qc_inspection_id'));
            $this->db->update('qc_inspection_info', $upd); 
            
            
            $upd = array( 
                        'shift_supervisor' => $this->input->post('shift_supervisor'),  
                        'tumblast_machine_operator' => $this->input->post('tumblast_machine_operator'),  
                        'shot_blastng_machine_operator' => $this->input->post('shot_blastng_machine_operator'),  
                        'ag4_machine_operator' => $this->input->post('ag4_machine_operator'),  
                        'contractor_grinding_machine_operator' => $this->input->post('contractor_grinding_machine_operator'),  
                        'company_grinding_machine_operator' => $this->input->post('company_grinding_machine_operator'),  
                        'painting_person' => $this->input->post('painting_person'),  
                        'factory_manager' => $this->input->post('factory_manager'),  
                        'updated_by' => $this->session->userdata('cr_user_id'),                          
                        'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            $this->db->where('shift_supervisor = ""');
            $this->db->or_where('tumblast_machine_operator = ""');
            $this->db->or_where('shot_blastng_machine_operator = ""');
            $this->db->or_where('ag4_machine_operator = ""');
            $this->db->or_where('contractor_grinding_machine_operator = ""');
            $this->db->or_where('company_grinding_machine_operator = ""');
            $this->db->or_where('painting_person = ""');
            $this->db->or_where('factory_manager = ""');
            $this->db->update('qc_inspection_info', $upd); 
            
                            
            redirect('quality-check');  
        } 
        
        
        
        
       if(isset($_POST['srch_date'])) {
           $data['srch_date'] = $srch_date = $this->input->post('srch_date'); 
           $this->session->set_userdata('srch_date', $this->input->post('srch_date'));  
       } elseif($this->session->userdata('srch_date')) {
           $data['srch_date'] = $srch_date = $this->session->userdata('srch_date') ; 
       } else {
           $data['srch_date'] = $srch_date = date('Y-m-d');
       }
       
       if(isset($_POST['srch_shift'])) {
           $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift');
           $this->session->set_userdata('srch_shift', $this->input->post('srch_shift'));     
       } elseif($this->session->userdata('srch_shift')) {
           $data['srch_shift'] = $srch_shift = $this->session->userdata('srch_shift') ; 
       } else {
        $data['srch_shift'] =  $srch_shift = '';
       }
        
        
        /*$this->db->select('a.work_planning_id'); 
        $this->db->where('a.status != ', 'Delete'); 
        $this->db->where("a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'");
        $this->db->from('work_planning_info as a');  */
        
        
        $sql = "select a.work_planning_id from work_planning_info as a where a.status != 'Delete' and a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
                $data['work_planning_id'] = $row->work_planning_id;
        }
       
        
       
        $sql = "
             select 
            	a.work_planning_id,
            	a.planning_date,
            	a.shift,
            	c.company_name as customer,
            	e.customer_PO_No,
            	d.match_plate_no,
            	d.pattern_item,
            	a.planned_box,
                sum(a1.pouring_box) as pouring_box,
            	sum(a1.produced_qty) as produced_qty ,
                a2.qc_inspection_id,
                a2.qc_date,
                a2.rejection_group,
                a3.rejection_type_name, 
                a2.rejection_qty,
                a2.shift_supervisor,
                a.prt_work_plan_id,
                d.no_of_cavity ,
                a.prt_work_plan_id,
                concat(s.heat_code ,s.days_heat_no) as heat_code 
             from work_planning_info as a
             left join work_order_items_info as b on b.work_order_item_id = a.work_order_item_id
             left join customer_info as c on c.customer_id = a.customer_id
             left join pattern_info as d on d.pattern_id = a.pattern_id 
             left join work_order_info as e on e.work_order_id = a.work_order_id
             left join melting_item_info as a1 on a1.work_planning_id = a.work_planning_id and a1.`status` != 'Delete'
             left join qc_inspection_info as a2 on a2.work_planning_id = a.work_planning_id and a2.`status` != 'Delete'
             left join rejection_type_info as a3 on a3.rejection_type_id = a2.rejection_type_id 
             left join melting_heat_log_info as s on s.melting_heat_log_id = a2.melting_heat_log_id
             where a.`status` != 'Delete' and
             a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."' 
             group by a.work_planning_id , a2.qc_inspection_id
             order by a.work_planning_id,a2.qc_date,a2.rejection_group,a3.rejection_type_name asc
        
        ";
        
         
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
        $data['child_record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['work_planning_id']][] = $row;  
            $data['child_record_list'][$row['work_planning_id']]  = $row['pouring_box'];     
        }
        
        $data['shift_opt'] = array('Shift-A' => 'Shift-A' , 'Shift-B' => 'Shift-B', 'Shift-C' => 'Shift-C'); 
        
        
        $sql = "
                select                
                a.rejection_group_name             
                from rejection_group_info as a   
                where a.level = 1
                order by a.rejection_group_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['rejection_group_opt'][$row['rejection_group_name']] = $row['rejection_group_name'] ;     
        }
        
        $sql = "
                select 
                a.employee_id,                
                a.employee_name             
                from employee_info as a  
                where status = 'Active' 
                order by a.employee_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['employee_opt'] = array();
        //$data['employee_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['employee_opt'][$row['employee_name']] = $row['employee_name'];     
            //$data['employee_list'][$row['employee_id']] = $row['employee_name'];     
        }
          
        
        $this->load->view('page/production/quality-check',$data); 
    }
    
    
    public function sand_test()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        
        $data['js'] = 'sand-test.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            
               $ins = array(  
                        'planning_date' => $this->input->post('planning_date'),
                        'shift' => $this->input->post('shift'), 
                        'test_time' => $this->input->post('test_time'), 
                        'customer_id' => $this->input->post('customer_id'), 
                        'pattern_id' => $this->input->post('pattern_id'), 
                        'temp' => $this->input->post('temp'),  
                        'com' => $this->input->post('com'),  
                        'moi' => $this->input->post('moi'),  
                        'permeability' => $this->input->post('permeability'),  
                        'green_comp_strength' => $this->input->post('green_comp_strength'),  
                        'volatile_matter' => $this->input->post('volatile_matter'),  
                        'loss_on_ignition' => $this->input->post('loss_on_ignition'),  
                        'active_clay' => $this->input->post('active_clay'),  
                        'total_clay' => $this->input->post('total_clay'),  
                        'dead_clay' => $this->input->post('dead_clay'),  
                        'new_sand' => $this->input->post('new_sand'),  
                        'bentonite' => $this->input->post('bentonite'),  
                        'coal_dust' => $this->input->post('coal_dust'),  
                        'remarks' => $this->input->post('remarks'),  
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s')  ,
                        'updated_by' => $this->session->userdata('cr_user_id'),                          
                        'updated_datetime' => date('Y-m-d H:i:s')                               
                );
            
                $this->db->insert('system_sand_register_info', $ins); 
           
            redirect('sand-test');  
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                        'planning_date' => $this->input->post('planning_date'),
                        'shift' => $this->input->post('shift'), 
                        'test_time' => $this->input->post('test_time'), 
                        'customer_id' => $this->input->post('customer_id'), 
                        'pattern_id' => $this->input->post('pattern_id'), 
                        'temp' => $this->input->post('temp'),  
                        'com' => $this->input->post('com'),  
                        'moi' => $this->input->post('moi'),  
                        'permeability' => $this->input->post('permeability'),  
                        'green_comp_strength' => $this->input->post('green_comp_strength'),  
                        'volatile_matter' => $this->input->post('volatile_matter'),  
                        'loss_on_ignition' => $this->input->post('loss_on_ignition'),  
                        'active_clay' => $this->input->post('active_clay'),  
                        'total_clay' => $this->input->post('total_clay'),  
                        'dead_clay' => $this->input->post('dead_clay'),  
                        'new_sand' => $this->input->post('new_sand'),  
                        'bentonite' => $this->input->post('bentonite'),  
                        'coal_dust' => $this->input->post('coal_dust'),  
                        'remarks' => $this->input->post('remarks'),  
                        'updated_by' => $this->session->userdata('cr_user_id'),                          
                        'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('system_sand_register_id', $this->input->post('system_sand_register_id'));
            $this->db->update('system_sand_register_info', $upd); 
                            
            redirect('sand-test');  
        } 
        
        
        
        
       if(isset($_POST['srch_date'])) {
           $data['srch_date'] = $srch_date = $this->input->post('srch_date'); 
           $this->session->set_userdata('srch_date', $this->input->post('srch_date'));  
       } elseif($this->session->userdata('srch_date')) {
           $data['srch_date'] = $srch_date = $this->session->userdata('srch_date') ; 
       } else {
           $data['srch_date'] = $srch_date = date('Y-m-d');
       }
       
       if(isset($_POST['srch_shift'])) {
           $data['srch_shift'] = $srch_shift = $this->input->post('srch_shift');
           $this->session->set_userdata('srch_shift', $this->input->post('srch_shift'));     
       } elseif($this->session->userdata('srch_shift')) {
           $data['srch_shift'] = $srch_shift = $this->session->userdata('srch_shift') ; 
       } else {
        $data['srch_shift'] =  $srch_shift = '';
       }
        
        
        /*$this->db->select('a.work_planning_id'); 
        $this->db->where('a.status != ', 'Delete'); 
        $this->db->where("a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'");
        $this->db->from('work_planning_info as a');  */
        
        
        $sql = "select a.work_planning_id from work_planning_info as a where a.status != 'Delete' and a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
                $data['work_planning_id'] = $row->work_planning_id;
        }
       
        
       
        $sql = "
             select 
                a.system_sand_register_id,
                a.planning_date,
                a.shift,
                a.test_time,
                b.pattern_item,
                a.temp,
                a.com,
                a.moi,
                a.remarks
                from system_sand_register_info as a 
                left join pattern_info as b on b.pattern_id = a.pattern_id
                where a.planning_date = '". $srch_date."' and a.shift = '". $srch_shift ."'
                order by a.system_sand_register_id asc  
        
        ";
        
         
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array(); 
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;  
        }
        
        $data['shift_opt'] = array('Shift-A' => 'Shift-A' , 'Shift-B' => 'Shift-B', 'Shift-C' => 'Shift-C'); 
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name             
                from customer_info as a  
                where status = 'Active' 
                and exists (select * from work_planning_info as q where a.status != 'Delete' and a.customer_id = q.customer_id and  q.planning_date = '". $srch_date."' and q.shift = '". $srch_shift ."' ) 
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['customer_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['company_name'];     
        } 
        
         
          
        
        $this->load->view('page/production/sand-test',$data); 
    }
    
    
    public function customer_despatch_v2(){
        
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        date_default_timezone_set("Asia/Calcutta"); 
        
        if($this->input->post('mode') == 'DC Generate') {
            
            $ins = array( 
                    'dc_no' => $this->input->post('dc_no'),
                    'invoice_no' => $this->input->post('invoice_no'),
                    'despatch_date' => $this->input->post('despatch_date'), 
                    'customer_id' => $this->input->post('customer_id'), 
                    //'sub_contractor_id' => $this->input->post('sub_contractor_id'), 
                    'vehicle_no' => $this->input->post('vehicle_no'),
                    'driver_name' => $this->input->post('driver_name'),
                    'mobile' => $this->input->post('mobile'),
                    'remarks' => $this->input->post('remarks'), 
                    'status' => $this->input->post('status'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            
            //print_r($ins);
            $this->db->insert('customer_despatch_info', $ins); 
            $customer_despatch_id = $this->db->insert_id();
            
            $work_planning_ids =$this->input->post('work_planning_id'); 
            $qtys =$this->input->post('qty'); 
            $work_order_ids =$this->input->post('work_order_id'); 
            $pattern_ids =$this->input->post('pattern_id'); 
            $melting_heat_log_ids =$this->input->post('melting_heat_log_id'); 
            $heat_codes =$this->input->post('heat_code'); 
            $customer_PO_Nos =$this->input->post('customer_PO_No'); 
            
                foreach($pattern_ids as $j => $pattern_id) {
                        $ins = array(
                                'customer_despatch_id' => $customer_despatch_id,
                               // 'work_order_id' => $work_order_id[$ind],
                                'pattern_id' => $pattern_id, 
                                'machining_sub_contractor_id' => $this->input->post('machining_sub_contractor_id'),  
                                'grinding_sub_contractor_id' => $this->input->post('grinding_sub_contractor_id'),  
                                'qty' => $qtys[$j] ,
                                'status' => 'Active'                                               
                        );                
                        $this->db->insert('customer_despatch_item_info', $ins);
                        $customer_despatch_item_id = $this->db->insert_id();
                        
                        
                        $ins_heat = array(
                                'customer_despatch_item_id' => $customer_despatch_item_id,
                                'work_planning_id' => $work_planning_ids[$j], 
                                'melting_heat_log_id' => $melting_heat_log_ids[$j],    
                                'work_order_id' => $work_order_ids[$j],    
                                'heat_code' => $heat_codes[$j],    
                                'customer_PO_No' => $customer_PO_Nos[$j] ,
                                'qty' => $qtys[$j] ,                                             
                                'status' => 'Active'                                           
                        ); 
                         $this->db->insert('heatcode_despatch_info', $ins_heat);     
                          
                }
           redirect('customer-despatch');
            
        }    
        	    
       $data['js'] = 'customer-despatch-v2.inc';  
       
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
       }  else { 
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
                a.company_name             
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['customer_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['company_name'];     
        } 
        
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
        $sql = "
       
           select 
            a1.melting_date ,
            a1.work_planning_id,
            a1.melting_heat_log_id,
            a1.lining_heat_no,
            a1.heat_code,
            a1.days_heat_no,
            a1.customer,
            a1.item,
            a1.customer_PO_No,
            a1.pouring_box,
            a1.produced_qty,
            a2.rejection_qty ,
            (a1.produced_qty - ifnull(a2.rejection_qty,0))  as bal_qty 
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
            b.pouring_box,
            b.produced_qty  ,
            f.customer_PO_No,
            1 as p_mode
            from melting_heat_log_info as a
            left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
            left join work_planning_info as c on c.work_planning_id = b.work_planning_id 
            left join pattern_info as d on d.pattern_id = c.pattern_id
            left join customer_info as e on e.customer_id = c.customer_id
            left join work_order_info as f on f.work_order_id = c.work_order_id
            where a.`status` = 'Active' and b.`status` = 'Active' and c.status != 'Delete' and b.pouring_box > 0  
            ";
            if(!empty($srch_customer_id) ){
                $sql.=" and c.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
                $sql.=" and c.pattern_id = '". $srch_pattern_id ."'"; 
            }
            
            $sql.="order by a.melting_date,  a.heat_code, a.days_heat_no ,d.pattern_item asc ) union all (
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
            b.produced_qty  ,
            f.customer_PO_No,
            0 as p_mode
            from melting_heat_log_info as a
            left join melting_child_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
            left join work_planning_info as c on c.work_planning_id = b.work_planning_id 
            left join pattern_info as d on d.pattern_id = c.pattern_id
            left join customer_info as e on e.customer_id = c.customer_id
            left join work_order_info as f on f.work_order_id = c.work_order_id
            where a.`status` = 'Active' and b.`status` = 'Active' and c.status != 'Delete'  
            ";
            if(!empty($srch_customer_id) ){
                $sql.=" and c.customer_id = '". $srch_customer_id ."'"; 
            }
            if(!empty($srch_pattern_id) ){
                $sql.=" and c.pattern_id = '". $srch_pattern_id ."'"; 
            }
            
            $sql.=" order by a.melting_date,  a.heat_code, a.days_heat_no ,d.pattern_item asc
            )
            ) as a1
            left join ( select q.work_planning_id , q.melting_heat_log_id , sum(q.rejection_qty) as rejection_qty from qc_inspection_info as q where q.status != 'Delete' group by q.work_planning_id , q.melting_heat_log_id ) as a2 on a2.work_planning_id = a1.work_planning_id and a2.melting_heat_log_id = a1.melting_heat_log_id
            order by a1.melting_date,  a1.heat_code, a1.days_heat_no ,a1.p_mode desc , a1.item asc
        ";
        */
        
        if(!empty($srch_customer_id) ){
            
            $this->db->select('(ifnull(max(dc_no),0) + 1) as dc_no');
            $query = $this->db->get('customer_despatch_info');
            $row = $query->row();
            if (isset($row)) {
                $data['dc_no'] = str_pad($row->dc_no,4,0,STR_PAD_LEFT);
            }  
            
        $sql = "
       
           select 
            a1.melting_date ,
            a1.work_planning_id,
            a1.melting_heat_log_id, 
            a1.pattern_id, 
            a1.heat_code,
            a1.days_heat_no, 
            a1.item,
            a1.work_order_id,
            a1.customer_PO_No, 
            a1.produced_qty,
            a2.rejection_qty ,
            v.despatch_qty,
            (a1.produced_qty - (ifnull(a2.rejection_qty,0) + (ifnull(v.despatch_qty,0))))  as bal_qty 
            from (
            (
            select 
                0 as melting_heat_log_id,
                0 as work_planning_id,
                a.pattern_id,
                a.floor_stock_date as melting_date , 
                '' as heat_code,
                '' as days_heat_no, 
                b.pattern_item as item, 
                a.stock_qty as produced_qty ,
                ( select w.customer_PO_No from work_order_info as w left join work_order_items_info as e on e.work_order_id = w.work_order_id where w.status != 'Delete' and e.pattern_id = a.pattern_id order by w.order_date desc limit 1 ) as customer_PO_No,
                0 as p_mode,
                ( select w.work_order_id from work_order_info as w left join work_order_items_info as e on e.work_order_id = w.work_order_id where w.status != 'Delete' and e.pattern_id = a.pattern_id order by w.order_date desc limit 1 )  as work_order_id
                from floor_stock_info as a
                left join pattern_info as b on b.pattern_id = a.pattern_id ";
                /*if(!empty($srch_from_date) ){
                    $sql.=" and a.floor_stock_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'"; 
                }*/
                if(!empty($srch_customer_id) ){
                    $sql.=" where a.customer_id = '". $srch_customer_id ."'"; 
                }
                if(!empty($srch_pattern_id) ){
                    $sql.=" and a.pattern_id = '". $srch_pattern_id ."'"; 
                }
            
            $sql.= " order by a.floor_stock_date , a.customer_id , a.pattern_id 
            ) union all (
                select 
                a.melting_heat_log_id,
                b.work_planning_id,
                c.pattern_id,
                a.melting_date , 
                a.heat_code,
                a.days_heat_no, 
                d.pattern_item as item, 
                b.produced_qty  ,
                f.customer_PO_No,
                1 as p_mode,
                c.work_order_id
                from melting_heat_log_info as a
                left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
                left join work_planning_info as c on c.work_planning_id = b.work_planning_id 
                left join pattern_info as d on d.pattern_id = c.pattern_id
                left join customer_info as e on e.customer_id = c.customer_id
                left join work_order_info as f on f.work_order_id = c.work_order_id
                where a.`status` = 'Active' and b.`status` = 'Active' and c.status != 'Delete' and b.pouring_box > 0  
                ";
                if(!empty($srch_from_date) ){
                    $sql.=" and a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'"; 
                }
                
                if(!empty($srch_customer_id) ){
                    $sql.=" and c.customer_id = '". $srch_customer_id ."'"; 
                }
                if(!empty($srch_pattern_id) ){
                    $sql.=" and c.pattern_id = '". $srch_pattern_id ."'"; 
                } 
                $sql.="order by a.melting_date,  a.heat_code, a.days_heat_no ,d.pattern_item asc 
            ) union all (
                select 
                a.melting_heat_log_id,
                b.work_planning_id,
                c.pattern_id,
                a.melting_date , 
                a.heat_code,
                a.days_heat_no, 
                d.pattern_item as item, 
                b.produced_qty  ,
                f.customer_PO_No,
                0 as p_mode,
                c.work_order_id
                from melting_heat_log_info as a
                left join melting_child_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
                left join work_planning_info as c on c.work_planning_id = b.work_planning_id 
                left join pattern_info as d on d.pattern_id = c.pattern_id
                left join customer_info as e on e.customer_id = c.customer_id
                left join work_order_info as f on f.work_order_id = c.work_order_id
                where a.`status` = 'Active' and b.`status` = 'Active' and c.status != 'Delete'  
                ";
                if(!empty($srch_from_date) ){
                    $sql.=" and a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'"; 
                }
                if(!empty($srch_customer_id) ){
                    $sql.=" and c.customer_id = '". $srch_customer_id ."'"; 
                }
                if(!empty($srch_pattern_id) ){
                    $sql.=" and c.pattern_id = '". $srch_pattern_id ."'"; 
                }
                
                $sql.=" order by a.melting_date,  a.heat_code, a.days_heat_no ,d.pattern_item asc
            )
            ) as a1
            left join ( select q.work_planning_id , q.melting_heat_log_id , sum(q.rejection_qty) as rejection_qty from qc_inspection_info as q where q.status != 'Delete' group by q.work_planning_id , q.melting_heat_log_id ) as a2 on a2.work_planning_id = a1.work_planning_id and a2.melting_heat_log_id = a1.melting_heat_log_id
            left join ( 
                        select 
                        a.customer_id,
                        b.pattern_id,
                        c.work_planning_id,
                        c.melting_heat_log_id,
                        c.work_order_id,
                        sum(c.qty) as despatch_qty
                        from customer_despatch_info as a
                        left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
                        left join heatcode_despatch_info as c on c.customer_despatch_item_id = b.customer_despatch_item_id
                        where a.`status` = 'Active' and c.qty > 0 
                        group by a.customer_id,b.pattern_id,c.work_planning_id,c.melting_heat_log_id,c.work_order_id
                      )  as v on v.work_planning_id = a1.work_planning_id and v.melting_heat_log_id = a1.melting_heat_log_id and v.work_order_id = a1.work_order_id  and  v.pattern_id = a1.pattern_id 
           where ((a1.produced_qty - (ifnull(a2.rejection_qty,0) + (ifnull(v.despatch_qty,0)))) > 0)";
           
           if(!empty($srch_from_date) ){
                    $sql.=" and a1.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'"; 
                }
           
          $sql.="  order by a1.melting_date,  a1.heat_code, a1.days_heat_no ,a1.p_mode desc , a1.item asc
        "; 
       
       /* echo "<pre>";
        echo $sql;
        echo "</pre>";*/
        
       
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['item']][] = $row;     
        }
        }
        
        
        echo "<pre>";
        //print_r($data['record_list']);
        echo "</pre>";
        
        
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
        
        $sql = "
               select 
                a.sub_contractor_id,
                a.company_name  
                from sub_contractor_info as a 
                where a.status='Active' and a.type = 'Grinding' 
                order by a.company_name asc               
        "; 
        
        $query = $this->db->query($sql);
        
        $data['g_sub_contractor_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['g_sub_contractor_opt'][$row['sub_contractor_id']] = $row['company_name'];     
        }
        
        
       // $this->insert_heatcode_despatch_qty(2,6,121,'780.00');
       
       /* $sql = "
        select 
        b.customer_despatch_item_id,
        a.customer_id,
        b.pattern_id,
        b.qty,
        c.company_name,
        d.pattern_item
        from customer_despatch_info as a
        left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
        left join customer_info as c on c.customer_id = a.customer_id
        left join pattern_info as d on d.pattern_id = b.pattern_id
        where a.`status` = 'Active'  
        and not EXISTS ( select * from heatcode_despatch_info as q where q.customer_despatch_item_id = b.customer_despatch_item_id ) 
        order by a.dc_no asc
        ";
        
        $query = $this->db->query($sql);
        
        foreach ($query->result_array() as $row){
            $this->insert_heatcode_despatch_qty($row['customer_despatch_item_id'],$row['customer_id'],$row['pattern_id'],$row['qty']);
        }
        
       */
        
         $this->load->view('page/production/customer-dc-generate',$data); 
        
        
    }
    
    
    
    private function insert_heatcode_despatch_qty($customer_despatch_item_id , $customer_id , $pattern_id , $despatch_qty)
    {
        $sql = "
        select 
            a1.melting_date ,
            a1.work_planning_id,
            a1.melting_heat_log_id, 
            a1.pattern_id, 
            a1.work_order_id,
            a1.heat_code,
            a1.days_heat_no, 
            a1.item,
            a1.customer_PO_No, 
            a1.produced_qty,
            a2.rejection_qty ,
           (a1.produced_qty - (ifnull(a2.rejection_qty,0) + (ifnull(v.despatch_qty,0))))  as bal_qty 
            from (
            (
            select 
                0 as melting_heat_log_id,
                0 as work_planning_id,
                a.pattern_id,
                a.floor_stock_date as melting_date , 
                '' as heat_code,
                '' as days_heat_no, 
                b.pattern_item as item, 
                a.stock_qty as produced_qty ,
                ( select w.customer_PO_No from work_order_info as w left join work_order_items_info as e on e.work_order_id = w.work_order_id where w.status != 'Delete' and e.pattern_id = a.pattern_id order by w.order_date desc limit 1 ) as customer_PO_No,
                0 as p_mode,
                ( select w.work_order_id from work_order_info as w left join work_order_items_info as e on e.work_order_id = w.work_order_id where w.status != 'Delete' and e.pattern_id = a.pattern_id order by w.order_date desc limit 1 )  as work_order_id
                from floor_stock_info as a
                left join pattern_info as b on b.pattern_id = a.pattern_id  where a.customer_id = '". $customer_id ."' and a.pattern_id = '". $pattern_id ."' order by a.floor_stock_date , a.customer_id , a.pattern_id 
            ) union all (
                select 
                a.melting_heat_log_id,
                b.work_planning_id,
                c.pattern_id,
                a.melting_date , 
                a.heat_code,
                a.days_heat_no, 
                d.pattern_item as item, 
                b.produced_qty  ,
                f.customer_PO_No,
                1 as p_mode,
                c.work_order_id
                from melting_heat_log_info as a
                left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
                left join work_planning_info as c on c.work_planning_id = b.work_planning_id 
                left join pattern_info as d on d.pattern_id = c.pattern_id
                left join customer_info as e on e.customer_id = c.customer_id
                left join work_order_info as f on f.work_order_id = c.work_order_id
                where a.`status` = 'Active' and b.`status` = 'Active' and c.status != 'Delete' and b.pouring_box > 0  
                 and c.customer_id = '". $customer_id ."' and c.pattern_id = '". $pattern_id ."' order by a.melting_date,  a.heat_code, a.days_heat_no ,d.pattern_item asc 
            ) union all (
                select 
                a.melting_heat_log_id,
                b.work_planning_id,
                c.pattern_id,
                a.melting_date , 
                a.heat_code,
                a.days_heat_no, 
                d.pattern_item as item, 
                b.produced_qty  ,
                f.customer_PO_No,
                0 as p_mode,
                c.work_order_id
                from melting_heat_log_info as a
                left join melting_child_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
                left join work_planning_info as c on c.work_planning_id = b.work_planning_id 
                left join pattern_info as d on d.pattern_id = c.pattern_id
                left join customer_info as e on e.customer_id = c.customer_id
                left join work_order_info as f on f.work_order_id = c.work_order_id
                where a.`status` = 'Active' and b.`status` = 'Active' and c.status != 'Delete'  
                 and c.customer_id = '". $customer_id ."' and c.pattern_id = '". $pattern_id ."' order by a.melting_date,  a.heat_code, a.days_heat_no ,d.pattern_item asc
            )
            ) as a1
            left join ( select q.work_planning_id , q.melting_heat_log_id , sum(q.rejection_qty) as rejection_qty from qc_inspection_info as q where q.status != 'Delete' group by q.work_planning_id , q.melting_heat_log_id ) as a2 on a2.work_planning_id = a1.work_planning_id and a2.melting_heat_log_id = a1.melting_heat_log_id
            left join ( 
                        select 
                        a.customer_id,
                        b.pattern_id,
                        c.work_planning_id,
                        c.melting_heat_log_id,
                        c.work_order_id,
                        sum(c.qty) as despatch_qty
                        from customer_despatch_info as a
                        left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
                        left join heatcode_despatch_info as c on c.customer_despatch_item_id = b.customer_despatch_item_id
                        where a.`status` = 'Active' and c.qty > 0
                        group by a.customer_id,b.pattern_id,c.work_planning_id,c.melting_heat_log_id,c.work_order_id 
                      )  as v on v.work_planning_id = a1.work_planning_id and v.melting_heat_log_id = a1.melting_heat_log_id and v.work_order_id = a1.work_order_id  and  v.pattern_id = a1.pattern_id 
           where ((a1.produced_qty - (ifnull(a2.rejection_qty,0) + (ifnull(v.despatch_qty,0)))) > 0)
            
            order by a1.melting_date,  a1.heat_code, a1.days_heat_no ,a1.p_mode desc , a1.item asc
        ";
        
        $query = $this->db->query($sql);
        
         
         
        $ins_qty = 0;
        foreach ($query->result_array() as $row)
        {
            IF($row['bal_qty'] > 0 ) {
                
                 if($row['bal_qty'] <= $despatch_qty)
                 {
                    $ins_qty = $row['bal_qty']; 
                 } else {
                    $ins_qty = $despatch_qty;
                 }
                  
                 
                 
                 
                 if($ins_qty > 0) {  
                    $ins = " insert into heatcode_despatch_info 
                            (
                            customer_despatch_item_id , 
                            work_planning_id,  
                            melting_heat_log_id,
                            work_order_id,
                            heat_code,
                            customer_PO_No,
                            qty    
                            ) values (
                            '". $customer_despatch_item_id ."',
                            '". $row['work_planning_id'] ."',
                            '". $row['melting_heat_log_id'] ."',
                            '". $row['work_order_id'] ."',
                            '". $row['heat_code'] . $row['days_heat_no'] ."',
                            '". $row['customer_PO_No'] ."',
                            '". $ins_qty ."'
                            ); "; 
                            
                      $this->db->query($ins);
                      
                      $despatch_qty = ($despatch_qty - $ins_qty);      
                            
                 }    
            }
        }
        
    }

    public function customer_despatch()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'customer-despatch.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array( 
                    'dc_no' => $this->input->post('dc_no'),
                    'invoice_no' => $this->input->post('invoice_no'),
                    'despatch_date' => $this->input->post('despatch_date'), 
                    'customer_id' => $this->input->post('customer_id'), 
                    //'sub_contractor_id' => $this->input->post('sub_contractor_id'), 
                    'vehicle_no' => $this->input->post('vehicle_no'),
                    'driver_name' => $this->input->post('driver_name'),
                    'mobile' => $this->input->post('mobile'),
                    'remarks' => $this->input->post('remarks'), 
                    'dc_type' => $this->input->post('dc_type'), 
                    'transporter_id' => $this->input->post('transporter_id'), 
                    'status' => $this->input->post('status'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('customer_despatch_info', $ins); 
            $insert_id = $this->db->insert_id();
            
            $pattern_ids = $this->input->post('pattern_id');
           // $work_order_id = $this->input->post('work_order_id');
            $machining_sub_contractor_ids = $this->input->post('machining_sub_contractor_id');
            $grinding_sub_contractor_ids = $this->input->post('grinding_sub_contractor_id');
            $qtys = $this->input->post('qty');
            foreach($pattern_ids as $ind => $pattern_id)
              {
                    if(!empty($pattern_id)) {
                        $ins = array(
                                'customer_despatch_id' => $insert_id,
                               // 'work_order_id' => $work_order_id[$ind],
                                'pattern_id' => $pattern_id, 
                                'machining_sub_contractor_id' => $machining_sub_contractor_ids[$ind],  
                                'grinding_sub_contractor_id' => $grinding_sub_contractor_ids[$ind],  
                                'qty' => $qtys[$ind] ,
                                'status' => 'Active'                                               
                        );                
                        $this->db->insert('customer_despatch_item_info', $ins);
                        
                       // $customer_despatch_item_id = $this->db->insert_id();
                        
                       // $this->insert_heatcode_despatch_qty($customer_despatch_item_id ,$customer_id,$pattern_id,$qtys[$ind]);
                    }
              } 
              
              
              $sql = "
                select 
                b.customer_despatch_item_id,
                a.customer_id,
                b.pattern_id,
                b.qty,
                c.company_name,
                d.pattern_item
                from customer_despatch_info as a
                left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
                left join customer_info as c on c.customer_id = a.customer_id
                left join pattern_info as d on d.pattern_id = b.pattern_id
                where a.`status` = 'Active'  
                and not EXISTS ( select * from heatcode_despatch_info as q where q.customer_despatch_item_id = b.customer_despatch_item_id ) 
                order by a.dc_no asc
                ";
                
                $query = $this->db->query($sql);
                
                foreach ($query->result_array() as $row){
                    $this->insert_heatcode_despatch_qty($row['customer_despatch_item_id'],$row['customer_id'],$row['pattern_id'],$row['qty']);
                }
            
            redirect('customer-despatch');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                'dc_no' => $this->input->post('dc_no'),
                'invoice_no' => $this->input->post('invoice_no'),
                'despatch_date' => $this->input->post('despatch_date'), 
                'customer_id' => $this->input->post('customer_id'),  
                'vehicle_no' => $this->input->post('vehicle_no'),
                'driver_name' => $this->input->post('driver_name'),
                'mobile' => $this->input->post('mobile'),
                'remarks' => $this->input->post('remarks'), 
                'dc_type' => $this->input->post('dc_type'), 
                'transporter_id' => $this->input->post('transporter_id'), 
                'status' => $this->input->post('status'), 
                'updated_by' => $this->session->userdata('cr_user_id'),                          
                'updated_datetime' => date('Y-m-d H:i:s')                  
            );
            
            //print_r($upd);
            
            $this->db->where('customer_despatch_id', $this->input->post('customer_despatch_id'));
            $this->db->update('customer_despatch_info', $upd); 
                            
            redirect('customer-despatch/' . $this->uri->segment(2, 0));  
        } 
        
        
        
        
         
        $this->db->select('(ifnull(max(dc_no),0) + 1) as dc_no');
        $query = $this->db->get('customer_despatch_info');
        $row = $query->row();
        if (isset($row)) {
            $data['dc_no'] = str_pad($row->dc_no,4,0,STR_PAD_LEFT);
        }   
         
         
         
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
       else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = ''; 
       }
       
       if(isset($_POST['srch_customer_id'])) {
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
           $this->session->set_userdata('srch_customer_id', $this->input->post('srch_customer_id'));
       }
       elseif($this->session->userdata('srch_customer_id')){ 
           $data['srch_customer_id'] = $srch_customer_id = $this->session->userdata('srch_customer_id') ;
       } 
       else { 
        $data['srch_customer_id'] = $srch_customer_id = '';
       }   
       
       if(isset($_POST['srch_pattern_id'])) {
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id');  
           $this->session->set_userdata('srch_pattern_id', $this->input->post('srch_pattern_id'));
       }
       elseif($this->session->userdata('srch_pattern_id')){ 
           $data['srch_pattern_id'] = $srch_pattern_id = $this->session->userdata('srch_pattern_id') ;
       } 
       else { 
        $data['srch_pattern_id'] = $srch_pattern_id = '';
       }  
         
        
       $this->load->library('pagination');
       
       $data['pattern_opt'] =array();
       $data['dc_type_opt'] =array('Processing' => 'Processing','Sales' => 'Sales');
        
       /*if(isset($_POST['srch_state'])) {
           $data['srch_state'] = $srch_state = $this->input->post('srch_state');
           $data['srch_key'] = $srch_key = $this->input->post('srch_key');
           $this->session->set_userdata('srch_state', $this->input->post('srch_state'));
           $this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_state')){
           $data['srch_state'] = $srch_state = $this->session->userdata('srch_state') ; 
       }else {
           $data['srch_state'] = $srch_state = '';
       }*/
       
     /*  if(isset($_POST['srch_key'])) { 
           $data['srch_key'] = $srch_key = $this->input->post('srch_key'); 
           $this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_key')){ 
           $data['srch_key'] = $srch_key = $this->session->userdata('srch_key') ;
       } else {
         $data['srch_key'] = $srch_key = '';
       }
       
        */
        
       
       $where = '1'; 
      /*   
       if(!empty($srch_key)) {
         $where .= " and ( 
                        a.company_name like '%" . $srch_key . "%' or 
                        a.contact_person like '%" . $srch_key . "%' or 
                        a.pincode like '%" . $srch_key . "%' or 
                        a.mobile like '%". $srch_key ."%' or  
                        a.email like '%". $srch_key ."%' or 
                        a.phone like '%". $srch_key ."%'
                        ) ";
         
       } 
         */
         
        if(!empty($srch_from_date) ){
                $where.=" and a.despatch_date between '". $srch_from_date ."' and '". $srch_to_date ."'" ; 
        }
        if(!empty($srch_customer_id) ){
                $where.=" and a.customer_id = '". $srch_customer_id ."'"; 
        }  
        
        if(!empty($srch_pattern_id)){
         $where .= " and exists (select z.work_order_id from customer_despatch_item_info as z where z.customer_despatch_id = a.customer_despatch_id and z.pattern_id = '". $srch_pattern_id ."') ";
       } 
        
        $this->db->where('status != ', 'Delete');
        if($where != '1')
            $this->db->where($where);
        $this->db->from('customer_despatch_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('customer-despatch/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 20;
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
        /*
        $sql = "
                select 
                a.customer_despatch_id, 
                a.dc_no, 
                a.invoice_no, 
                a.despatch_date, 
                b.company_name as customer, 
                c.company_name as sub_contractor, 
                a.vehicle_no, 
                a.driver_name, 
                a.mobile, 
                a.remarks, 
                a.`status`
                from customer_despatch_info as a  
                left join customer_info as b on b.customer_id = a.customer_id
                left join sub_contractor_info as c on c.sub_contractor_id = a.sub_contractor_id
                where a.status != 'Delete' 
                and ". $where ."
                order by a.customer_despatch_id desc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        */
        
       $sql = "
                select 
                a.customer_despatch_id, 
                a.dc_no, 
                a.invoice_no, 
                a.despatch_date, 
                b.company_name as customer,   
                a.vehicle_no, 
                a.driver_name, 
                a.mobile, 
                a.remarks, 
                d.transporter_name,
                d.transporter_gst,
                a.`status`,
                DATEDIFF(current_date(), a.despatch_date) as days  
                from customer_despatch_info as a  
                left join customer_info as b on b.customer_id = a.customer_id 
                left join transporter_info as d on d.transporter_id = a.transporter_id 
                where a.status != 'Delete' 
                and ". $where ."
                order by a.customer_despatch_id desc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        } 
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name             
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['customer_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['company_name'];     
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
        
        $sql = "
               select 
                a.sub_contractor_id,
                a.company_name  
                from sub_contractor_info as a 
                where a.status='Active' and a.type = 'Grinding' 
                order by a.company_name asc               
        "; 
        
        $query = $this->db->query($sql);
        
        $data['g_sub_contractor_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['g_sub_contractor_opt'][$row['sub_contractor_id']] = $row['company_name'];     
        }
        
        if(!empty($srch_customer_id) ){
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
        }
        
        
        $sql = "
               select 
                a.transporter_id,
                a.transporter_name  
                from transporter_info as a 
                where a.status='Active'  
                order by a.transporter_name asc               
        "; 
        
        $query = $this->db->query($sql);
        
        $data['transporter_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['transporter_opt'][$row['transporter_id']] = $row['transporter_name'];     
        }
         
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/production/customer-despatch',$data); 
	}
    
    
    public function customer_despatch_edit($customer_despatch_id)
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        if($this->input->post('mode') == 'edit')
        {
            
            /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";*/
            
            $upd = array(
                        'dc_no' => $this->input->post('dc_no'),
                        'invoice_no' => $this->input->post('invoice_no'),
                        'despatch_date' => $this->input->post('despatch_date'),
                        'customer_id' => $this->input->post('customer_id'),
                     //   'sub_contractor_id' => $this->input->post('sub_contractor_id'),
                        'vehicle_no' => $this->input->post('vehicle_no'),
                        'driver_name' => $this->input->post('driver_name'),
                        'mobile' => $this->input->post('mobile'),
                        'remarks' => $this->input->post('remarks'),               
                        'updated_datetime' => date('Y-m-d H:i:s')                                               
                );                
          $this->db->where('customer_despatch_id', $customer_despatch_id);
          $this->db->update('customer_despatch_info', $upd);
          
          $ed_work_order_id = $this->input->post('ed_work_order_id');
          $ed_pattern_ids = $this->input->post('ed_pattern_id');
          $ed_machining_sub_contractor_ids = $this->input->post('ed_machining_sub_contractor_id');
          $ed_grinding_sub_contractor_ids = $this->input->post('ed_grinding_sub_contractor_id');
          $ed_qtys = $this->input->post('ed_qty'); 
          
          foreach($ed_pattern_ids as $cr_ind => $cr_pattern_id)
          {
              if(!empty($cr_pattern_id)) {
                    $upd1 = array(
                            'customer_despatch_id' => $customer_despatch_id,
                            'pattern_id' => $cr_pattern_id, 
                            'work_order_id' => $ed_work_order_id[$cr_ind],
                            'machining_sub_contractor_id' => $ed_machining_sub_contractor_ids[$cr_ind],
                            'grinding_sub_contractor_id' => $ed_grinding_sub_contractor_ids[$cr_ind],
                            'qty' => $ed_qtys[$cr_ind] ,
                            'status' => 'Active'                                            
                    );           
                    $this->db->where('customer_despatch_item_id', $cr_ind);     
                    $this->db->update('customer_despatch_item_info', $upd1);
                    
                    $this->db->where('customer_despatch_item_id', $cr_ind);     
                    $this->db->delete('heatcode_despatch_info');
                    
                   // $this->insert_heatcode_despatch_qty($cr_ind ,$this->input->post('customer_id'),$cr_pattern_id,$ed_qtys[$cr_ind]);
               } 
          } 
          
          $work_order_id = $this->input->post('work_order_id');
          $pattern_ids = $this->input->post('pattern_id');
          $machining_sub_contractor_ids = $this->input->post('machining_sub_contractor_id');
          $grinding_sub_contractor_ids = $this->input->post('grinding_sub_contractor_id');
          $qtys = $this->input->post('qty'); 
          if(!empty($pattern_ids)) {
              foreach($pattern_ids as $ind => $pattern_id)
              {
                  if(!empty($pattern_id)) {
                    $ins = array(
                            'customer_despatch_id' => $customer_despatch_id,
                            'pattern_id' => $pattern_id, 
                            'qty' => $qtys[$ind],
                            'work_order_id' => $work_order_id[$ind],                     
                            'machining_sub_contractor_id' => $machining_sub_contractor_ids[$ind],  
                            'grinding_sub_contractor_id' => $grinding_sub_contractor_ids[$ind],  
                            'status' => 'Active'                    
                    );                
                    $this->db->insert('customer_despatch_item_info', $ins);
                    
                    //$customer_despatch_item_id = $this->db->insert_id();
                    
                    //$this->insert_heatcode_despatch_qty($customer_despatch_item_id ,$this->input->post('customer_id'),$pattern_id,$qtys[$ind]);
                    
                    
                    }
              }
          }
          
          $sql = "
            select 
            b.customer_despatch_item_id,
            a.customer_id,
            b.pattern_id,
            b.qty,
            c.company_name,
            d.pattern_item
            from customer_despatch_info as a
            left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
            left join customer_info as c on c.customer_id = a.customer_id
            left join pattern_info as d on d.pattern_id = b.pattern_id
            where a.`status` = 'Active'  
            and not EXISTS ( select * from heatcode_despatch_info as q where q.customer_despatch_item_id = b.customer_despatch_item_id ) 
            order by a.dc_no asc
            ";
            
            $query = $this->db->query($sql);
            
            foreach ($query->result_array() as $row){
                $this->insert_heatcode_despatch_qty($row['customer_despatch_item_id'],$row['customer_id'],$row['pattern_id'],$row['qty']);
            }
          
          redirect('customer-despatch-edit/'. $customer_despatch_id);    
                 
        }
        	    
        $data['js'] = 'customer-despatch.inc';  
        
       
       $sql = "
                select 
                a.customer_id,                
                a.company_name             
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['customer_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['company_name'];     
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
        
        $sql = "
               select 
                a.sub_contractor_id,
                a.company_name  
                from sub_contractor_info as a 
                where a.status='Active' and a.type = 'Grinding' 
                order by a.company_name asc               
        "; 
        
        $query = $this->db->query($sql);
        
        $data['g_sub_contractor_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['g_sub_contractor_opt'][$row['sub_contractor_id']] = $row['company_name'];     
        }
        
       $sql = "
                select 
                a.customer_despatch_id, 
                a.dc_no, 
                a.invoice_no,
                a.despatch_date, 
                a.customer_id, 
                a.vehicle_no, 
                a.driver_name, 
                a.mobile, 
                a.remarks, 
                a.`status`
                from customer_despatch_info as a  
                where a.customer_despatch_id = '". $customer_despatch_id ."'
                order by a.customer_despatch_id desc                 
        ";
      
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list']['mst'] = $row;     
        } 
         
        $sql = "
                select 
                a.customer_despatch_item_id,
                a.work_order_id,
                a.pattern_id,
                a.machining_sub_contractor_id,
                a.grinding_sub_contractor_id,
                a.qty      
                from customer_despatch_item_info as a 
                where a.status != 'Delete' and a.customer_despatch_id = '". $customer_despatch_id ."'
                order by a.customer_despatch_item_id asc                 
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
        
        $data['record_list']['chld'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list']['chld'][] = $row;     
        }  
        
        
        $sql = " 
                select 
                a.work_order_id,
                a.customer_PO_No,
                DATE_FORMAT(a.order_date,'%d-%m-%Y') as order_date 
                from work_order_info as a
                where a.`status`!= 'Delete'   
                and a.customer_id =  '". $data['record_list']['mst']['customer_id']."'
                order by a.order_date desc                
                limit 30
        "; 
        
        $query = $this->db->query($sql);
        
        $data['work_order_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['work_order_opt'][$row['work_order_id']] =  $row['customer_PO_No'] . '||' . $row['order_date'];     
        }
        
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item ,
                a.match_plate_no           
                from pattern_info as a  
                where status = 'Active' and a.customer_id = '". $data['record_list']['mst']['customer_id']."'
                order by a.pattern_item asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['pattern_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item'];     
        }
        
           
		$this->load->view('page/production/customer-despatch-edit',$data); 
	} 
    
    public function sub_contractor_despatch()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'sub-contractor-despatch.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array( 
                    'dc_no' => $this->input->post('dc_no'),
                    'despatch_date' => $this->input->post('despatch_date'), 
                    'customer_id' => $this->input->post('customer_id'), 
                    'sub_contractor_id' => $this->input->post('sub_contractor_id'), 
                    'vehicle_no' => $this->input->post('vehicle_no'),
                    'driver_name' => $this->input->post('driver_name'),
                    'mobile' => $this->input->post('mobile'),
                    'remarks' => $this->input->post('remarks'), 
                    'status' => $this->input->post('status'), 
                    'inward_date' => $this->input->post('inward_date'), 
                    'inward_dc_no' => $this->input->post('inward_dc_no'), 
                    'inward_received_by' => $this->input->post('inward_received_by'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('sub_contractor_despatch_info', $ins); 
            $insert_id = $this->db->insert_id();
            
            $pattern_ids = $this->input->post('pattern_id');
            $qtys = $this->input->post('qty');
            foreach($pattern_ids as $ind => $pattern_id)
              {
                    $ins = array(
                            'sub_contractor_despatch_id' => $insert_id,
                            'pattern_id' => $pattern_id, 
                            'qty' => $qtys[$ind]                                                
                    );                
                    $this->db->insert('sub_contractor_despatch_item_info', $ins);
              } 
            
            redirect('sub-contractor-despatch');
        }
        
         
        
         
        $this->db->select('(ifnull(max(dc_no),0) + 1) as dc_no');
        $query = $this->db->get('sub_contractor_despatch_info');
        $row = $query->row();
        if (isset($row)) {
            $data['dc_no'] = str_pad($row->dc_no,4,0,STR_PAD_LEFT);
        }   
         
         
        
       $this->load->library('pagination');
        
       /*if(isset($_POST['srch_state'])) {
           $data['srch_state'] = $srch_state = $this->input->post('srch_state');
           $data['srch_key'] = $srch_key = $this->input->post('srch_key');
           $this->session->set_userdata('srch_state', $this->input->post('srch_state'));
           $this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_state')){
           $data['srch_state'] = $srch_state = $this->session->userdata('srch_state') ; 
       }else {
           $data['srch_state'] = $srch_state = '';
       }*/
       
     /*  if(isset($_POST['srch_key'])) { 
           $data['srch_key'] = $srch_key = $this->input->post('srch_key'); 
           $this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_key')){ 
           $data['srch_key'] = $srch_key = $this->session->userdata('srch_key') ;
       } else {
         $data['srch_key'] = $srch_key = '';
       }
       
        */
        
       
       $where = '1'; 
      /*   
       if(!empty($srch_key)) {
         $where .= " and ( 
                        a.company_name like '%" . $srch_key . "%' or 
                        a.contact_person like '%" . $srch_key . "%' or 
                        a.pincode like '%" . $srch_key . "%' or 
                        a.mobile like '%". $srch_key ."%' or  
                        a.email like '%". $srch_key ."%' or 
                        a.phone like '%". $srch_key ."%'
                        ) ";
         
       } 
         */
        
        $this->db->where('status != ', 'Delete');
        if(!empty($srch_key))
            $this->db->where($where);
        $this->db->from('sub_contractor_despatch_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('sub-contractor-despatch/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 20;
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
                a.sub_contractor_despatch_id, 
                a.dc_no, 
                a.despatch_date, 
                b.company_name as customer, 
                c.company_name as sub_contractor, 
                a.vehicle_no, 
                a.driver_name, 
                a.mobile, 
                a.remarks, 
                a.`status`
                from sub_contractor_despatch_info as a  
                left join customer_info as b on b.customer_id = a.customer_id
                left join sub_contractor_info as c on c.sub_contractor_id = a.sub_contractor_id
                where a.status != 'Delete' 
                and ". $where ."
                order by a.sub_contractor_despatch_id desc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        } 
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name             
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['customer_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['company_name'];     
        }
        
        $sql = "
                select 
                a.sub_contractor_id,                
                a.company_name             
                from sub_contractor_info as a  
                where status = 'Active' and a.type= 'Grinding'
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['sub_contractor_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['sub_contractor_opt'][$row['sub_contractor_id']] = $row['company_name'];     
        }
        
        $sql = "
                select 
                a.employee_id,                
                a.employee_name             
                from employee_info as a  
                where status = 'Active' 
                order by a.employee_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['employee_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['employee_opt'][$row['employee_name']] = $row['employee_name'];     
        }
        
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/production/sub-contractor-despatch',$data); 
	} 
    
    public function sub_contractor_despatch_edit($sub_contractor_despatch_id)
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        if($this->input->post('mode') == 'edit')
        {
            
            /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";*/
            
            $upd = array(
                        'dc_no' => $this->input->post('dc_no'), 
                        'despatch_date' => $this->input->post('despatch_date'),
                        'customer_id' => $this->input->post('customer_id'),
                        'sub_contractor_id' => $this->input->post('sub_contractor_id'),
                        'vehicle_no' => $this->input->post('vehicle_no'),
                        'driver_name' => $this->input->post('driver_name'),
                        'mobile' => $this->input->post('mobile'),
                        'remarks' => $this->input->post('remarks'),   
                        'status' => $this->input->post('status'),   
                        'inward_date' => $this->input->post('inward_date'), 
                        'inward_dc_no' => $this->input->post('inward_dc_no'), 
                        'inward_received_by' => $this->input->post('inward_received_by'),             
                        'updated_by' => $this->session->userdata('cr_user_id'),               
                        'updated_datetime' => date('Y-m-d H:i:s')                                               
                );                
          $this->db->where('sub_contractor_despatch_id', $sub_contractor_despatch_id);
          $this->db->update('sub_contractor_despatch_info', $upd);
          
           $ed_pattern_ids = $this->input->post('ed_pattern_id'); 
          $ed_qtys = $this->input->post('ed_qty'); 
          
          foreach($ed_pattern_ids as $sub_contractor_despatch_item_id => $cr_pattern_id)
          {
              if(!empty($cr_pattern_id)) {
                    $upd1 = array(
                            'sub_contractor_despatch_id' => $sub_contractor_despatch_id,
                            'pattern_id' => $cr_pattern_id,   
                            'qty' => $ed_qtys[$sub_contractor_despatch_item_id]              
                    );           
                    $this->db->where('sub_contractor_despatch_item_id', $sub_contractor_despatch_item_id);     
                    $this->db->update('sub_contractor_despatch_item_info', $upd1);
               } 
          } 
          
          $pattern_ids = $this->input->post('pattern_id');
          $qtys = $this->input->post('qty'); 
          if(!empty($pattern_ids)) {
              foreach($pattern_ids as $ind => $pattern_id)
              {
                  if(!empty($pattern_id)) {
                    $ins = array(
                            'sub_contractor_despatch_id' => $sub_contractor_despatch_id,
                            'pattern_id' => $pattern_id, 
                            'qty' => $qtys[$ind]                   
                    );                
                    $this->db->insert('sub_contractor_despatch_item_info', $ins);
                    }
              }
          }
          
          redirect('sub-contractor-despatch-edit/'. $sub_contractor_despatch_id);    
                 
        }
        	    
        $data['js'] = 'sub-contractor-despatch.inc';  
        
       
       $sql = "
                select 
                a.customer_id,                
                a.company_name             
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['customer_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['company_name'];     
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
        
       $sql = "
                select 
                a.sub_contractor_despatch_id, 
                a.dc_no,  
                a.despatch_date, 
                a.customer_id, 
                a.sub_contractor_id,
                a.vehicle_no, 
                a.driver_name, 
                a.mobile, 
                a.remarks, 
                a.`status`,
                a.inward_date,
                a.inward_dc_no,
                a.inward_received_by
                from sub_contractor_despatch_info as a  
                where a.sub_contractor_despatch_id = '". $sub_contractor_despatch_id ."'
                order by a.sub_contractor_despatch_id desc                 
        ";
      
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list']['mst'] = $row;     
        } 
         
        $sql = "
                select 
                a.sub_contractor_despatch_item_id, 
                a.pattern_id, 
                a.qty      
                from sub_contractor_despatch_item_info as a 
                where a.sub_contractor_despatch_id = '". $sub_contractor_despatch_id ."'
                order by a.sub_contractor_despatch_item_id asc                 
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
        
        $data['record_list']['chld'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list']['chld'][] = $row;     
        }  
         
        
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item ,
                a.match_plate_no           
                from pattern_info as a  
                where status = 'Active' and a.customer_id = '". $data['record_list']['mst']['customer_id']."'
                order by a.pattern_item asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['pattern_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item'];     
        }
        
        $sql = "
                select 
                a.employee_id,                
                a.employee_name             
                from employee_info as a  
                where status = 'Active' 
                order by a.employee_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['employee_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['employee_opt'][$row['employee_id']] = $row['employee_name'];     
        }
        
           
		$this->load->view('page/production/sub-contractor-despatch-edit',$data); 
	}
    
    public function print_dc($dc_id , $type ='Customer')
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
       
        
        $sql = "
                select  
                a.customer_despatch_id,
                a.dc_no,
                a.despatch_date,
                b.company_name as customer,
                c.transporter_name,
                c.transporter_gst,
                a.driver_name,
                a.vehicle_no,
                a.mobile,
                a.remarks,
                a.invoice_no 
                from customer_despatch_info as a
                left join customer_info as b on b.customer_id= a.customer_id
                left join transporter_info as c on c.transporter_id = a.transporter_id
                where a.`status` != 'Delete' 
                and a.customer_despatch_id = '". $dc_id ."'      
                order by a.despatch_date desc                 
        ";
        
        
        $query = $this->db->query($sql); 
		
		$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list']  = $row;  
        }
        
       /*  $sql = "
                select 
                a.customer_despatch_item_id,
                b.pattern_item as item, 
                c.company_name as machining_sub_contractor,
                d.company_name as grinding_sub_contractor,
                a.qty ,
                b.piece_weight_per_kg,
                (a.qty * b.piece_weight_per_kg) as tot_wt     
                from customer_despatch_item_info as a 
                left join pattern_info as b on b.pattern_id = a.pattern_id
                left join sub_contractor_info as c on c.sub_contractor_id = a.machining_sub_contractor_id
                left join sub_contractor_info as d on d.sub_contractor_id = a.grinding_sub_contractor_id
                where a.status != 'Delete' and a.customer_despatch_id = '". $dc_id ."'
                order by a.customer_despatch_item_id asc             
        ";

		$sql = "
				 select 
                a.customer_despatch_item_id,
                b.pattern_item as item, 
                c.company_name as machining_sub_contractor,
                d.company_name as grinding_sub_contractor,
                a.qty ,
                b.piece_weight_per_kg,
                (a.qty * b.piece_weight_per_kg) as tot_wt ,
				GROUP_CONCAT( e.po_wise_qty) as po_wise_qty
                from customer_despatch_item_info as a 
                left join pattern_info as b on b.pattern_id = a.pattern_id
                left join sub_contractor_info as c on c.sub_contractor_id = a.machining_sub_contractor_id
                left join sub_contractor_info as d on d.sub_contractor_id = a.grinding_sub_contractor_id
                left join (
							select 
							concat(DATE_FORMAT(w.order_date,'%d-%m-%Y'), ' : ', w.customer_PO_No , ' -> ', sum(z.qty)) as po_wise_qty, 
							z.customer_despatch_item_id  
							from heatcode_despatch_info as z 
							left join work_order_info as w on w.work_order_id = z.work_order_id
							group by z.customer_despatch_item_id , z.work_order_id 
						  ) as e on e.customer_despatch_item_id = a.customer_despatch_item_id
                where a.status != 'Delete' and a.customer_despatch_id = '". $dc_id ."'
                group by a.customer_despatch_item_id 
                order by a.customer_despatch_item_id asc          
		
		";*/
        
       $sql = "
				 select 
                a.customer_despatch_id, 
                a.work_order_id , 
                a.pattern_id ,
                b.pattern_item as item, 
                c.company_name as machining_sub_contractor,
                d.company_name as grinding_sub_contractor,
                (a.qty) as qty ,
                b.piece_weight_per_kg,
                (a.qty * b.piece_weight_per_kg) as tot_wt ,
				GROUP_CONCAT( e.po_wise_qty) as po_wise_qty
                from customer_despatch_item_info as a 
                left join pattern_info as b on b.pattern_id = a.pattern_id
                left join sub_contractor_info as c on c.sub_contractor_id = a.machining_sub_contractor_id
                left join sub_contractor_info as d on d.sub_contractor_id = a.grinding_sub_contractor_id
                left join (
							select 
						      concat(DATE_FORMAT(w.order_date,'%d-%m-%Y'), ' : ', w.customer_PO_No , ' -> ', sum(z.qty)) as po_wise_qty, 
							z.customer_despatch_item_id  
							from heatcode_despatch_info as z 
							left join work_order_info as w on w.work_order_id = z.work_order_id
							group by z.customer_despatch_item_id 
						  ) as e on e.customer_despatch_item_id = a.customer_despatch_item_id
                where a.status != 'Delete' and a.customer_despatch_id = '". $dc_id ."'
                group by a.customer_despatch_item_id 
                order by a.customer_despatch_item_id asc          
		
		";
		     
		
        
        $query = $this->db->query($sql); 
       
        foreach ($query->result_array() as $row)
        {
            $data['bill_list'][] = $row;     
        }
		
		$sql = "
				 select 
				b.customer_PO_No,
				b.order_date,
				a.heat_code,
				a.qty
				from heatcode_despatch_info as a
				left join work_order_info as b on b.work_order_id = a.work_order_id
				where a.customer_despatch_item_id in ( select customer_despatch_item_id from customer_despatch_item_info as q where q.customer_despatch_id = '". $dc_id ."' ) 
				order by a.heatcode_despatch_id asc
		";
        
        $query = $this->db->query($sql); 
       
        foreach ($query->result_array() as $row)
        {
            $data['po_list'][] = $row;     
        }
        
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'DAR'
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
        
         /*echo "<pre>";
		 print_r($data['record_list']);
		 echo "</pre>";*/
        
        $this->load->view('page/production/print-dc',$data); 
	}   
    
    public function print_sdc($dc_id , $type ='sub_contractor')
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
       
        
        $sql = "
                select  
                a.sub_contractor_despatch_id,
                a.dc_no,
                a.despatch_date,
                b.company_name as customer,
                c.company_name as sub_contractor,
                a.driver_name,
                a.vehicle_no,
                a.mobile,
                a.remarks  
                from sub_contractor_despatch_info as a
                left join customer_info as b on b.customer_id= a.customer_id
                left join sub_contractor_info as c on c.sub_contractor_id = a.sub_contractor_id
                where a.`status` != 'Delete' 
                and a.sub_contractor_despatch_id = '". $dc_id ."'    
                order by a.despatch_date desc                  
        ";
        
        
        $query = $this->db->query($sql); 
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list']  = $row;  
        }
        
        $sql = "
                select 
                a.sub_contractor_despatch_item_id,
                b.pattern_item as item,  
                a.qty ,
                b.piece_weight_per_kg,
                (a.qty * b.piece_weight_per_kg) as tot_wt     
                from sub_contractor_despatch_item_info as a 
                left join pattern_info as b on b.pattern_id = a.pattern_id 
                where b.status != 'Delete' and a.sub_contractor_despatch_id = '". $dc_id ."'
                order by a.sub_contractor_despatch_item_id asc             
        ";
        
        
        $query = $this->db->query($sql); 
       
        foreach ($query->result_array() as $row)
        {
            $data['bill_list'][] = $row;     
        }
        
         
        
        $this->load->view('page/production/print-sdc',$data); 
	}   
    
    public function print_MTC($dc_id)
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
       
       $cnt = 0; 
        
        
        
        $sql = "
                select 
                d.company_name as customer,
                a.dc_no,
                a.invoice_no,
                a.despatch_date,
                e.pattern_item as item,
                b.qty as tot_qty,
                concat(f.heat_code,f.days_heat_no) as heat_code,
                c.customer_PO_No,
                c.qty as d_qty ,
                h.*,
                e.ni,
                e.mo,
                f.f_c,
                f.f_si,
                f.f_mn,
                f.f_p,
                f.f_s,
                f.f_cr,
                f.f_cu,
                f.f_mg,
                f.f_bmn,
                f.tensile as f_tensile, 
                f.elongation as f_elongation, 
                f.yield_strength as f_yield_strength,
                j.*
                from customer_despatch_info as a
                left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
                left join heatcode_despatch_info as c on c.customer_despatch_item_id = b.customer_despatch_item_id
                left join customer_info as d on d.customer_id = a.customer_id
                left join pattern_info as e on e.pattern_id = b.pattern_id
                left join melting_heat_log_info as f on f.melting_heat_log_id = c.melting_heat_log_id
                left join work_order_info as g on g.work_order_id = c.work_order_id
                left join grade_info as h on h.grade_id = e.grade 
                left join melting_item_info as i on i.melting_heat_log_id = f.melting_heat_log_id and i.work_planning_id = c.work_planning_id 
                left join melting_item_chemical_info as j on j.melting_heat_log_id = i.melting_heat_log_id and j.melting_item_id = i.melting_item_id  and j.`status` = 'Active'
                where a.`status` = 'Active'  and a.customer_despatch_id =  '". $dc_id ."'      
                order by e.pattern_item , c.heat_code asc                 
        ";
        
        
        
        
        $query = $this->db->query($sql); 
        
        $cnt = $query->num_rows();
        
        
        
        if($cnt > 0) {
        
            //echo "CNT: " . $this->db->count_all_results();
           $data['master_range'] = array();
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][]  = $row;  
                //$data['tc_list'][$row['grade_name']][]  = $row;  
                
                $data['mtc_list'][$row['item']][]  = $row;  
                if($row['m_c']!= '' && $row['m_si']!= '')
                    $data['master_range'] = $row;
            }
            
        } else {
            
           $sql = "
                select 
                d.company_name as customer,
                a.dc_no,
                a.invoice_no,
                a.despatch_date,
                e.pattern_item as item,
                b.qty as tot_qty,
               concat(f.heat_code,f.days_heat_no) as heat_code,
                c.customer_PO_No,
                c.qty as d_qty ,
                h.grade_name,
                f.f_c,
                f.f_si,
                f.f_mn,
                f.f_p,
                f.f_s,
                f.f_cr,
                f.f_cu,
                f.f_mg,
                f.f_bmn,
                f.tensile as f_tensile, 
                f.elongation as f_elongation, 
                f.yield_strength as f_yield_strength,
                e.C,
                e.SI, 
                e.Mn,
                e.P, 
                e.S, 
                e.Cr, 
                e.Cu, 
                e.Mg,
                e.BHN, 
                e.tensile, 
                e.elongation, 
                e.yeild_strength
                from customer_despatch_info as a
                left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
                left join heatcode_despatch_info as c on c.customer_despatch_item_id = b.customer_despatch_item_id
                left join customer_info as d on d.customer_id = a.customer_id
                left join pattern_info as e on e.pattern_id = b.pattern_id
                left join melting_heat_log_info as f on f.melting_heat_log_id = c.melting_heat_log_id
                left join work_order_info as g on g.work_order_id = c.work_order_id
                left join grade_info as h on h.grade_id = e.grade 
                where a.`status` = 'Active' and a.customer_despatch_id =  '". $dc_id ."'      
                order by e.pattern_item , c.heat_code asc                 
        ";
        
        
        
        
        $query = $this->db->query($sql); 
        
        //echo "CNT2: " . $this->db->count_all_results();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][]  = $row;  
            //$data['tc_list'][$row['grade_name']][]  = $row;  
            
            $data['mtc_list'][$row['item']][]  = $row;  
        } 
            
        }
        
        $sql = "
                select 
                a.customer_despatch_item_id,
                b.pattern_item as item, 
                c.company_name as machining_sub_contractor,
                d.company_name as grinding_sub_contractor,
                a.qty ,
                b.piece_weight_per_kg,
                (a.qty * b.piece_weight_per_kg) as tot_wt     
                from customer_despatch_item_info as a 
                left join pattern_info as b on b.pattern_id = a.pattern_id
                left join sub_contractor_info as c on c.sub_contractor_id = a.machining_sub_contractor_id
                left join sub_contractor_info as d on d.sub_contractor_id = a.grinding_sub_contractor_id
                where a.status != 'Delete' and a.customer_despatch_id = '". $dc_id ."'
                order by a.customer_despatch_item_id asc             
        ";
        
        
        $query = $this->db->query($sql); 
       
        foreach ($query->result_array() as $row)
        {
            $data['bill_list'][] = $row;     
        }
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'MTC'
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
        
         
        if($cnt > 0)
            $this->load->view('page/production/print-mtc-v2',$data); 
        else
            $this->load->view('page/production/print-mtc',$data); 
            
            
	} 
    
    public function print_STR($sand_register_id)
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
       
         $sql = "
             select  
                c.company_name as customer, 
                b.pattern_item, 
                a.*
                from system_sand_register_info as a 
                left join pattern_info as b on b.pattern_id = a.pattern_id
                left join customer_info as c on c.customer_id = a.customer_id
                where a.system_sand_register_id = '". $sand_register_id."' 
                order by a.system_sand_register_id asc  
        
        "; 
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array(); 
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list']  = $row;  
        } 
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'STR'
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
         
        $this->load->view('page/production/print-str',$data); 
            
            
	} 
    
    public function customer_despatch_restore(){
        
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        $data['js'] = 'customer-despatch-restore.inc';  
        
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
       else {
        $data['srch_from_date'] = $srch_from_date = '';
        $data['srch_to_date'] = $srch_to_date = ''; 
       }
       
       if(isset($_POST['srch_customer_id'])) {
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
           $this->session->set_userdata('srch_customer_id', $this->input->post('srch_customer_id'));
       }
       elseif($this->session->userdata('srch_customer_id')){ 
           $data['srch_customer_id'] = $srch_customer_id = $this->session->userdata('srch_customer_id') ;
       } 
       else { 
        $data['srch_customer_id'] = $srch_customer_id = '';
       }   
       
       if(isset($_POST['srch_pattern_id'])) {
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id');  
           $this->session->set_userdata('srch_pattern_id', $this->input->post('srch_pattern_id'));
       }
       elseif($this->session->userdata('srch_pattern_id')){ 
           $data['srch_pattern_id'] = $srch_pattern_id = $this->session->userdata('srch_pattern_id') ;
       } 
       else { 
        $data['srch_pattern_id'] = $srch_pattern_id = '';
       }  
         
        
       $this->load->library('pagination');
       
       $data['pattern_opt'] =array();
       $data['dc_type_opt'] =array('Processing' => 'Processing','Sales' => 'Sales');
        
        
        
       
       $where = '1'; 
      
         
        if(!empty($srch_from_date) ){
                $where.=" and a.despatch_date between '". $srch_from_date ."' and '". $srch_to_date ."'" ; 
        }
        if(!empty($srch_customer_id) ){
                $where.=" and a.customer_id = '". $srch_customer_id ."'"; 
        }  
        
        if(!empty($srch_pattern_id)){
         $where .= " and exists (select z.work_order_id from customer_despatch_item_info as z where z.customer_despatch_id = a.customer_despatch_id and z.pattern_id = '". $srch_pattern_id ."') ";
       } 
        
        $this->db->where('status = ', 'Delete');
        if($where != '1')
            $this->db->where($where);
        $this->db->from('customer_despatch_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('customer-despatch-restore/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 20;
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
                a.customer_despatch_id, 
                a.dc_no, 
                a.invoice_no, 
                a.despatch_date, 
                b.company_name as customer,   
                a.vehicle_no, 
                a.driver_name, 
                a.mobile, 
                a.remarks, 
                d.transporter_name,
                d.transporter_gst,
                a.`status`,
                DATEDIFF(current_date(), a.despatch_date) as days  
                from customer_despatch_info as a  
                left join customer_info as b on b.customer_id = a.customer_id 
                left join transporter_info as d on d.transporter_id = a.transporter_id 
                where a.status = 'Delete' 
                and ". $where ."
                order by a.customer_despatch_id desc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        } 
        
        $sql = "
                select 
                a.customer_id,                
                a.company_name             
                from customer_info as a  
                where status = 'Active' 
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['customer_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['company_name'];     
        }
        
        
        
         
        
        if(!empty($srch_customer_id) ){
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
        }
        
        
        $sql = "
               select 
                a.transporter_id,
                a.transporter_name  
                from transporter_info as a 
                where a.status='Active'  
                order by a.transporter_name asc               
        "; 
        
        $query = $this->db->query($sql);
        
        $data['transporter_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['transporter_opt'][$row['transporter_id']] = $row['transporter_name'];     
        }
         
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/production/customer-despatch-restore',$data); 
        
    
    }
    
    
    public function print_moulding_log_sheet($moulding_log_item_id)
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
       
         $sql = "
             select 
                b.planning_date,
                b.shift, 
                d.company_name as customer,
                c.pattern_item as pattern_item,
                a.machine_on_time,
                a.machine_off_time,
                a.heat_no,
                a.pattern_prod_from_datetime,
                a.pattern_prod_from_time,
                a.pattern_prod_to_datetime,
                a.pattern_prod_to_time,
                a.breakdown_from_time,
                a.breakdown_to_time,
                a.moulding_hrd_top,
                a.moulding_hrd_bottom,
                a.produced_box,
                a.closed_mould_qty,
                a.chk_pattern_condition,
                a.chk_logo_identify,
                a.chk_gating_sys_identify,
                a.chk_mold_closing_status,
                a.bottom_moulding_machine_operator,
                a.top_moulding_machine_operator,
                a.core_setter_name,
                a.mould_closer_name,
                a.mullar_operator_name,
                a.supervisor,
                a.addt_other_operators,
                a.modification_details,
                a.remarks
                from moulding_log_item_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                left join pattern_info as c on c.pattern_id = b.pattern_id
                left join customer_info as d on d.customer_id = b.customer_id
                where a.moulding_log_item_id = '". $moulding_log_item_id ."'
                order by a.moulding_log_item_id
        
        "; 
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array(); 
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list']  = $row;  
        } 
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'MLS'
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
         
        $this->load->view('page/production/print-moulding-log-sheet',$data); 
            
            
	} 
    
    public function print_melting_log_sheet($melting_heat_log_id)
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
       
         $sql = "
             select 
                a.*
                from melting_heat_log_info as a 
                where a.`status` = 'Active'  
                and  a.melting_heat_log_id = $melting_heat_log_id
                order by a.melting_heat_log_id
        
        "; 
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array(); 
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list']  = $row;  
        }
        
        $sql = "
        
        select 
        d.company_name as customer,
        c.pattern_item as item,
        a.pouring_box,
        a.leftout_box,
        if(a.leftout_box_close != '0', 'Yes' , 'No') as leftout_box_close
        from melting_item_info as a  
        left join work_planning_info as b on b.work_planning_id = a.work_planning_id
        left join pattern_info as c on c.pattern_id = b.pattern_id
        left join customer_info as d on d.customer_id = b.customer_id
        where a.`status` = 'Active'  
        and  a.melting_heat_log_id = $melting_heat_log_id
        order by a.melting_heat_log_id";
        
        $query = $this->db->query($sql);
        
        $data['record_itm_list'] = array(); 
       
        foreach ($query->result_array() as $row)
        {
            $data['record_itm_list'][]  = $row;  
        } 
        
        
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'MELS'
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
         
        $this->load->view('page/production/print-melting-log-sheet',$data); 
            
            
	} 
    
}