<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 
	public function index()
	{
		//$this->load->view('page/dashboard');
	}
    
    public function update_data()  
    {
        $timezone = "Asia/Calcutta";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
        
        
       $table = $this->input->post('tbl') ;
       $rec_id =$this->input->post('id');
       
       if($table == 'work_planning_info')
         {            
            $this->db->where('work_planning_id', $rec_id);
            $this->db->update('work_planning_info', array('updated_by' => $this->session->userdata('cr_user_id'),
                                                          'updated_date' => date('Y-m-d H:i:s'),
                                                          'planned_box' => $this->input->post('planned_box')
                                                          ));  
            
           
            echo 'Record Successfully Updated'; 
         }
         
       if($table == "customer_despatch_info") {
        
        $this->db->where('customer_despatch_id', $rec_id);
        $this->db->update('customer_despatch_info', array('updated_by' => $this->session->userdata('cr_user_id'),
                                                          'updated_datetime' => date('Y-m-d H:i:s'),
                                                          'status' => 'Active'
                                                          ));  
        $this->db->where('customer_despatch_id', $rec_id);
        $this->db->update('customer_despatch_item_info', array('status' => 'Active'));     
        
        $this->db->where('customer_despatch_item_id in ( select z.customer_despatch_item_id from customer_despatch_item_info as z where z.customer_despatch_id = "' .  $rec_id .'" )');
        $this->db->update('heatcode_despatch_info', array('status' => 'Active'));                                                    
                                                                                                         
                                                        
            
        echo 'Record Successfully Restored'; 
        
       } 
       
         
       
        
    }
    
    public function insert_data()  
    {
        //if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        $timezone = "Asia/Calcutta";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
        
        
       $table = $this->input->post('tbl') ; 
       
       if($table == 'co-loader')
       {    
            $ins = array(
                    'co_loader_name' => $this->input->post('co_loader_name'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')             
            );
            
            $this->db->insert('crit_co_loader_info', $ins); 
            
            return $this->db->insert_id();         
       } 
       
        
       
       if($table == 'melting_item_chemical_info')
       {    
             if($this->input->post('mode') == 'Add Chemical Log') {
                 if($this->input->post('melting_heat_log_id') != '' && $this->input->post('melting_item_id') != '') {
                 
                 $ins = array(
                            'melting_heat_log_id' => $this->input->post('melting_heat_log_id') ,
                            'melting_item_id' => $this->input->post('melting_item_id') ,
                            'm_c' => $this->input->post('m_c'),
                            'm_si' => $this->input->post('m_si'),
                            'm_mn' => $this->input->post('m_mn'),
                            'm_p' => $this->input->post('m_p'),
                            'm_s' => $this->input->post('m_s'),
                            'm_cr' => $this->input->post('m_cr'),
                            'm_cu' => $this->input->post('m_cu'),
                            'm_mg' => $this->input->post('m_mg') ,
                            'm_ni' => $this->input->post('m_ni') ,
                            'm_mo' => $this->input->post('m_mo') ,
                            'b_c' => $this->input->post('b_c') ,
                            'b_si' => $this->input->post('b_si') ,
                            'b_mn' => $this->input->post('b_mn') ,
                            'b_p' => $this->input->post('b_p') ,
                            'b_s' => $this->input->post('b_s') ,
                            'b_cr' => $this->input->post('b_cr') ,
                            'b_cu' => $this->input->post('b_cu') ,
                            'b_mg' => $this->input->post('b_mg') ,
                            'b_ni' => $this->input->post('b_ni') ,
                            'b_mo' => $this->input->post('b_mo') ,
                            'f_c' => $this->input->post('f_c') ,
                            'f_si' => $this->input->post('f_si') ,
                            'f_mn' => $this->input->post('f_mn') ,
                            'f_p' => $this->input->post('f_p') , 
                            'f_s' => $this->input->post('f_s') ,
                            'f_cr' => $this->input->post('f_cr') ,
                            'f_cu' => $this->input->post('f_cu') ,
                            'f_mg' => $this->input->post('f_mg') ,
                            'f_ni' => $this->input->post('f_ni') ,
                            'f_mo' => $this->input->post('f_mo') ,
                            'f2_c' => $this->input->post('f2_c') ,
                            'f2_si' => $this->input->post('f2_si') ,
                            'f2_mn' => $this->input->post('f2_mn') ,
                            'f2_p' => $this->input->post('f2_p') ,
                            'f2_s' => $this->input->post('f2_s') ,
                            'f2_cr' => $this->input->post('f2_cr') ,
                            'f2_cu' => $this->input->post('f2_cu') ,
                            'f2_mg' => $this->input->post('f2_mg') ,
                            'f2_ni' => $this->input->post('f2_ni') ,
                            'f2_mo' => $this->input->post('f2_mo') ,
                            'm_bmn' => $this->input->post('m_bmn') ,
                            'm_tensile' => $this->input->post('m_tensile') ,
                            'm_yield_strength' => $this->input->post('m_yield_strength') ,
                            'm_elongation' => $this->input->post('m_elongation') ,
                            'f_bmn' => $this->input->post('f_bmn') ,
                            'tensile' => $this->input->post('tensile') ,
                            'yield_strength' => $this->input->post('yield_strength') ,
                            'elongation' => $this->input->post('elongation') ,
                            );
                    $this->db->insert('melting_item_chemical_info', $ins);     
                
                    echo "Melting Chemical Log Recorded";
                } else {
                    echo " Chemical Log Not Recorded!!! ";
                }
         } elseif($this->input->post('mode') == 'Edit Chemical Log' && $this->input->post('melting_item_chemical_id') != '') {
            
                    $upd = array(
                            'melting_heat_log_id' => $this->input->post('melting_heat_log_id') ,
                            'melting_item_id' => $this->input->post('melting_item_id') ,
                            'm_c' => $this->input->post('m_c'),
                            'm_si' => $this->input->post('m_si'),
                            'm_mn' => $this->input->post('m_mn'),
                            'm_p' => $this->input->post('m_p'),
                            'm_s' => $this->input->post('m_s'),
                            'm_cr' => $this->input->post('m_cr'),
                            'm_cu' => $this->input->post('m_cu'),
                            'm_mg' => $this->input->post('m_mg') ,
                            'b_c' => $this->input->post('b_c') ,
                            'b_si' => $this->input->post('b_si') ,
                            'b_mn' => $this->input->post('b_mn') ,
                            'b_p' => $this->input->post('b_p') ,
                            'b_s' => $this->input->post('b_s') ,
                            'b_cr' => $this->input->post('b_cr') ,
                            'b_cu' => $this->input->post('b_cu') ,
                            'b_mg' => $this->input->post('b_mg') ,
                            'b_ni' => $this->input->post('b_ni') ,
                            'b_mo' => $this->input->post('b_mo') ,
                            'f_c' => $this->input->post('f_c') ,
                            'f_si' => $this->input->post('f_si') ,
                            'f_mn' => $this->input->post('f_mn') ,
                            'f_p' => $this->input->post('f_p') , 
                            'f_s' => $this->input->post('f_s') ,
                            'f_cr' => $this->input->post('f_cr') ,
                            'f_cu' => $this->input->post('f_cu') ,
                            'f_mg' => $this->input->post('f_mg') ,
                            'f_ni' => $this->input->post('f_ni') ,
                            'f_mo' => $this->input->post('f_mo') ,
                            'f2_c' => $this->input->post('f2_c') ,
                            'f2_si' => $this->input->post('f2_si') ,
                            'f2_mn' => $this->input->post('f2_mn') ,
                            'f2_p' => $this->input->post('f2_p') ,
                            'f2_s' => $this->input->post('f2_s') ,
                            'f2_cr' => $this->input->post('f2_cr') ,
                            'f2_cu' => $this->input->post('f2_cu') ,
                            'f2_mg' => $this->input->post('f2_mg') ,
                            'f2_ni' => $this->input->post('f2_ni') ,
                            'f2_mo' => $this->input->post('f2_mo') ,
                            'm_bmn' => $this->input->post('m_bmn') ,
                            'm_tensile' => $this->input->post('m_tensile') ,
                            'm_yield_strength' => $this->input->post('m_yield_strength') ,
                            'm_elongation' => $this->input->post('m_elongation') ,
                            'f_bmn' => $this->input->post('f_bmn') ,
                            'tensile' => $this->input->post('tensile') ,
                            'yield_strength' => $this->input->post('yield_strength') ,
                            'elongation' => $this->input->post('elongation') ,
                            );
                            
                    $this->db->where('melting_item_chemical_id', $this->input->post('melting_item_chemical_id'));        
                    $this->db->update('melting_item_chemical_info', $upd);     
                
                    echo "Melting Chemical Log Recorded Updated";
         
         } else {
                    echo " Chemical Log Not Recorded!!! ";
         }
                     
       }  
        
    } 
    
    
    public function get_courier_charges()
    {
        //$booking_id = $this->input->post('booking_id');
        $origin_pincode = $this->input->post('origin_pincode');
        $dest_pincode = $this->input->post('dest_pincode');
        $consignor_id = $this->input->post('consignor_id');
        $weight = $this->input->post('weight');
        $c_type = $this->input->post('c_type');
        
       /* $sql = "
            select 
            a.booking_id,
            a.awbno,
            a.origin_pincode,
            a.origin_state_code,
            a.origin_city_code,
            a.dest_pincode,
            a.dest_state_code,
            a.origin_city_code,
            c.min_weight,
            c.min_charges,
            c.addt_weight,
            c.addt_charges,
            a.weight,
            a.no_of_pieces,
            if(c.min_weight <= a.weight, (a.weight - c.min_weight) , 0 ) as addt_wt,
            if(c.min_weight <= a.weight, CEILING((a.weight - c.min_weight) / c.addt_weight) , 0 ) as addt_no_of_wt,
            if(c.min_weight <= a.weight, CEILING((a.weight - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ) as addt_charges_value,
            (c.min_charges + (if(c.min_weight <= a.weight, CEILING((a.weight - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ))) as tot_charges
            from crit_booking_info as a
            left join crit_customer_domestic_rate_info as c on c.customer_id = a.consignor_id and c.flg_state = (if(a.origin_state_code = a.dest_state_code,1,0)) and c.flg_city = (if(a.origin_city_code = a.dest_city_code,1,0)) and c.`status` = 'Active'
            where a.booking_id = '". $booking_id ."'  and c.c_type = 'Air'
        
        "; */
        
         $sql = "
            select 
            a.origin_state_code,
            a.origin_city_code, 
            b.dest_state_code,
            b.dest_city_code,
            c.min_weight,
            c.min_charges,
            c.addt_weight,
            c.addt_charges, 
            if(c.min_weight <= '".$weight."', ('".$weight."' - c.min_weight) , 0 ) as addt_wt,
            if(c.min_weight <= '".$weight."', CEILING(('".$weight."' - c.min_weight) / c.addt_weight) , 0 ) as addt_no_of_wt,
            if(c.min_weight <= '".$weight."', CEILING(('".$weight."' - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ) as addt_charges_value,
            (c.min_charges + (if(c.min_weight <= '".$weight."', CEILING(('".$weight."' - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ))) as tot_charges
            from (select q.state_code as origin_state_code, q.branch_code as origin_city_code  from crit_servicable_pincode_info as q where q.pincode = '". $origin_pincode ."'  and q.status = 'Active') as a  
            left join (select q1.state_code as dest_state_code, q1.branch_code as dest_city_code  from crit_servicable_pincode_info as q1 where q1.pincode = '". $dest_pincode ."'  and q1.status = 'Active') as b on 1=1
            left join crit_customer_domestic_rate_info as c on c.customer_id = '". $consignor_id ."' and c.flg_state = (if(b.dest_state_code = a.origin_state_code,1,0)) and c.flg_city = (if(b.dest_city_code = a.origin_city_code,1,0)) and c.`status` = 'Active'
            where 1 and c.c_type = '". $c_type ."'
        
        ";
        
        $query = $this->db->query($sql);
        
        $charges = array();
        
        foreach ($query->result_array() as $row)
        {
          $charges = $row ;    
        }  
        
        //$charges['sql'] = $sql;
        
        header('Content-Type: application/x-json; charset=utf-8');
        
        echo (json_encode($charges));
        
        //echo $sql;
        
    }
    
    public function get_data()  
	{
	   //if(!$this->session->userdata('zazu_logged_in'))  redirect();
       
        $timezone = "Asia/Calcutta";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
       
       $table = $this->input->post('tbl') ;
       $rec_id =$this->input->post('id');
       
       
       if($table == 'get-shift-itms-list')
       {
            $sql = "
            select 
            a.pattern_id,
            b.pattern_item  
            from work_planning_info as a
            left join pattern_info as b on b.pattern_id = a.pattern_id 
            where a.planning_date = '". $this->input->post('shift_date') ."' 
            and a.shift = '". $this->input->post('shift') ."'  
            and a.`status` != 'Delete'
            and b.`status` = 'Active'
            group by a.pattern_id
            order by b.pattern_item Asc 
            ";
            $query = $this->db->query($sql);
            $rec_list = $query->result_array();
            
       }


       if($table == 'melting_items_list')
       {
          $query = $this->db->query(" 
                select 
                a.melting_item_id,
                b.pattern_id,
                c.pattern_item,
                a.pouring_box
                from melting_item_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                left join pattern_info as c on c.pattern_id = b.pattern_id
                where a.melting_heat_log_id = '". $rec_id. "' 
                and a.status = 'Active'
                order by c.pattern_item asc   
                 
            "); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row;      
            }  
                      
       }
       
       
       if($table == 'customer_rejection_info')
       {
          $query = $this->db->query(" 
                select 
                a.* 
                from customer_rejection_info as a
                where a.customer_rejection_id = '". $rec_id. "'  
                order by a.customer_rejection_id desc   
                 
            "); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list = $row;      
            }
            
            $query = $this->db->query(" 
                select 
                a.* ,
                b.pattern_item,
                c.rejection_type_name as rejection_type
                from customer_rejection_itm_info as a
                left join pattern_info as b on b.pattern_id = a.pattern_id
                left join rejection_type_info as c on c.rejection_type_id = a.rej_type_id
                where a.customer_rejection_id = '". $rec_id. "'  
                order by a.customer_rejection_itm_id asc   
                 
            ");  
    
            foreach($query->result_array() as $row)
            {
                $rec_list['itm'][] = $row;      
            }
            
                            
       }
        
       if($table == 'get-pattern-info')
       {
          $query = $this->db->query(" 
                select 
                a.* 
                from pattern_info as a
                where a.pattern_id = '". $rec_id. "' 
                and a.status = 'Active'
                order by a.pattern_item asc   
                 
            "); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list = $row;      
            }            
       }
       
       
       
       
      if($table == 'purchase_inward_info')
       {
          $query = $this->db->query(" 
                select 
                a.* 
                from purchase_inward_info as a
                where a.purchase_inward_id = '". $rec_id. "' 
                and a.status = 'Active'
                order by a.purchase_inward_id asc   
                 
            "); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list = $row;      
            }            
       } 
        
       if($table == 'purchase_inward_testing_info')
       {
          $query = $this->db->query(" 
                select 
                a.* 
                from purchase_inward_testing_info as a
                where a.purchase_inward_testing_id = '". $rec_id. "' 
                and a.status = 'Active'
                order by a.purchase_inward_testing_id asc   
                 
            "); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list = $row;      
            }            
       }   
       
              
       
       
       if($table == 'get-customer-pattern')
       {
          if($this->input->post('pattern_type')!= '') {
              $query = $this->db->query("
                 select 
                    a.pattern_id,
                    a.pattern_item ,
                    a.match_plate_no ,
                    a.item_type
                    from pattern_info as a
                    where a.customer_id = '". $rec_id. "' 
                    and a.status = 'Active' and a.pattern_type = '". $this->input->post('pattern_type')."'
                    order by a.pattern_item asc   
              "
              ); 
          } else {
            $query = $this->db->query("
             select 
                a.pattern_id,
                a.pattern_item,
                a.match_plate_no,
                a.item_type  
                from pattern_info as a
                where a.customer_id = '". $rec_id. "' 
                and a.status = 'Active' 
                order by a.pattern_item asc   
          "
          ); 
          }
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }
       
       if($table == 'get-customer-pattern-stock')
       {
        
        $srch_date = date('Y-m-d');
        $srch_customer_id = $rec_id ;
        
                    
           
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
            ifnull(qc.curr_despatch_qty,0) as curr_despatch_qty ,
            (
              (  
                ((ifnull(c.stock_qty,0) + ifnull(sum(p4.produced_qty),0)) - (ifnull(sum(w.rejection_qty),0) + ifnull(sum(k.despatch_qty),0)))
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
                where z.floor_stock_date = '" .$srch_date. "'
                group by z.customer_id, z.pattern_id 
                order by z.customer_id, z.pattern_id 
            ) as b on b.customer_id = a.customer_id and b.pattern_id = a.pattern_id
            left join  floor_stock_info as c on c.customer_id = a.customer_id and c.pattern_id = a.pattern_id and c.floor_stock_date = ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = a.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') 
            left join (
                select  
                a3.customer_id,
                a3.pattern_id, 
                sum((a2.produced_qty) - ifnull(a4.closed_mould_qty,0)) as produced_qty
                from melting_heat_log_info as a1
                left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                left join ( select q.work_planning_id , sum(q.closed_mould_qty) as closed_mould_qty from moulding_log_item_info as q where q.`status` = 'Active' group by q.work_planning_id) as a4 on a4.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active' and a3.status != 'Delete' and a1.planning_date between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = a3.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                group by a3.customer_id, a3.pattern_id 
                order by a3.customer_id, a3.pattern_id 
            ) as p4 on p4.customer_id = a.customer_id and p4.pattern_id = a.pattern_id  
            left join (
                select
                b.planning_date as m_date,
                b.customer_id,
                b.pattern_id,
                sum(a.rejection_qty) as rejection_qty 
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                where a.status = 'Active' and b.status != 'Delete'  and b.planning_date between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = b.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                group by b.customer_id, b.pattern_id 
            ) as w on w.customer_id = a.customer_id and w.pattern_id = a.pattern_id  
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
            ) as k on k.customer_id = a.customer_id and k.pattern_id = a.pattern_id 
            left join (
                select 
                a3.customer_id,
                a3.pattern_id, 
                sum((a2.produced_qty) - ifnull(a4.closed_mould_qty,0)) as curr_produced_qty
                from melting_heat_log_info as a1
                left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                left join ( select q.work_planning_id , sum(q.closed_mould_qty) as closed_mould_qty from moulding_log_item_info as q where q.`status` = 'Active' group by q.work_planning_id) as a4 on a4.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active' and a3.status != 'Delete'  and a1.planning_date = '" .$srch_date. "'
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
            where a.`status` = 'Active'";
            if(!empty($srch_customer_id) ){
                $op_sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
            }
            /*if(!empty($srch_pattern_id) ){
              $op_sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
            }*/      
            $op_sql .=" 
                group by a.pattern_id , a.customer_id 
                order by customer , pattern_item 
          
           ";  
           
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
            ) as b on b.customer_id = a.customer_id and b.pattern_id = a.pattern_id
            left join  floor_stock_info as c on c.customer_id = a.customer_id and c.pattern_id = a.pattern_id and c.floor_stock_date = ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = a.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') 
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
                    where a1.`status` = 'Active' and a3.status != 'Delete'  and a1.planning_date between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = a3.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
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
                    where a1.`status` = 'Active' and a3.status != 'Delete' and a3.customer_id != '' and a1.planning_date between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = a3.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id
                    ) 
                ) as r where 1 group by r.customer_id, r.pattern_id
            ) as p4 on p4.customer_id = a.customer_id and p4.pattern_id = a.pattern_id  
            left join (
             select 
             q1.pattern_id,
             q1.customer_id,
             sum(q.closed_mould_qty) as closed_mould_qty 
             from moulding_log_item_info as q
             left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
             where q.`status` = 'Active' and q1.status != 'Delete' and q1.planning_date  between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = q1.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
             group by q1.pattern_id ,q1.customer_id
            ) as p5 on p5.pattern_id = a.pattern_id and p5.customer_id = a.customer_id 
            
            left join (
                select
                b.planning_date as m_date,
                b.customer_id,
                b.pattern_id,
                sum(a.rejection_qty) as rejection_qty 
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                where a.status = 'Active' and b.status != 'Delete' and b.planning_date between ifnull((select max(z.floor_stock_date) from floor_stock_info as z where z.pattern_id = b.pattern_id and z.floor_stock_date <= '" .$srch_date. "'), '2020-12-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                group by b.customer_id, b.pattern_id 
            ) as w on w.customer_id = a.customer_id and w.pattern_id = a.pattern_id  
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
            ) as k on k.customer_id = a.customer_id and k.pattern_id = a.pattern_id 
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
                    where a1.`status` = 'Active' and a3.status != 'Delete' and a1.planning_date = '" .$srch_date. "'  
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
                    where a1.`status` = 'Active' and a3.status != 'Delete' and a3.customer_id != '' and a1.planning_date = '" .$srch_date. "'  
                    group by a3.customer_id, a3.pattern_id 
                    order by a3.customer_id, a3.pattern_id
                    )
                ) as w where 1 group by w.customer_id,w.pattern_id
            ) as qa on qa.customer_id = a.customer_id and qa.pattern_id = a.pattern_id
            left join (
                select 
                b.customer_id,
                b.pattern_id,
                sum(a.rejection_qty) as curr_rejection_qty 
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                where a.status = 'Active' and b.status != 'Delete' and b.planning_date = '" .$srch_date. "'   
                group by b.customer_id, b.pattern_id 
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
            left join (
             select  
             q1.pattern_id,
             q1.customer_id,
             sum(q.closed_mould_qty) as closed_mould_qty 
             from moulding_log_item_info as q
             left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
             where q.`status` = 'Active' and q1.status != 'Delete' and q1.planning_date = '" .$srch_date. "'  
             group by q1.pattern_id ,q1.customer_id
            ) as cm on cm.pattern_id = a.pattern_id and cm.customer_id = a.customer_id 
            
            left join customer_info as p6 on p6.customer_id = a.customer_id 
            where a.`status` = 'Active' ";
            if(!empty($srch_customer_id) ){
                $op_sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
            }
             
            $op_sql .=" 
                group by a.pattern_id , a.customer_id 
                order by customer , pattern_item 
          
           ";   
           
           
          $query = $this->db->query($op_sql);  
             
           $rec_list = array();  
           
           //$rec_list['sql']  = $op_sql; 
    
            foreach($query->result_array() as $row)
            {
                if($row['closing_stock'] > 0 )
                {
                   /* $rec_list[] = array(
                                        'pattern_id' => $row['pattern_id'],
                                        'pattern_item' => $row['pattern_item'],
                                        'stock' => $row['closing_stock']
                                        ); */
                                        
                    $rec_list[]  = $row;                    
                                        
                }
               // $rec_list[]  = $row; 
            }  
          
       }
       
       if($table == 'get-pattern-in-out')
       {
          $query = $this->db->query(" 
                select  
                a.* 
                from pattern_in_out_ward_info as a  
                where a.pattern_in_out_id = '". $rec_id ."'
                order by a.pattern_in_out_date asc
                 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list  = $row;      
            }            
       }
       
       if($table == 'get-pattern-in-out-v2')
       {
          $query = $this->db->query(" 
                select  
                a.* 
                from pattern_in_out_ward_info as a  
                where a.pattern_in_out_id in (". $rec_id .")
                order by a.pattern_in_out_id asc
                 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[]  = $row;      
            }            
       }
       if($table == 'core-floor-stock')
       {
          $query = $this->db->query(" 
                select 
                a.core_floor_stock_id,   
                a.floor_stock_date, 
                a.customer_id,
                a.pattern_id,    
                a.core_item_id,    
                a.stock_qty    
                from core_floor_stock_info as a 
                where a.core_floor_stock_id = '". $rec_id ."' 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'get-core-maker-rate')
       {
          $query = $this->db->query(" 
                select  
                a.rate
                from core_maker_rate_info as a 
                where a.status = 'Active'     
                and a.core_item_id = '". $rec_id ."' 
                and a.core_maker_id = '". $this->input->post('core_maker_id')."'
				order by core_maker_rate_id desc limit 1
            ");
             
           $rec_list = array();      
		   
    
            foreach($query->result_array() as $row)
            {  
                $rec_list   = $row;      
            }  
          
       }
       
       if($table == 'core-plan')
       {
          $query = $this->db->query(" 
                select  
                a.* 
                from core_plan_info as a 
                where a.core_plan_id = '". $rec_id ."' 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list   = $row;      
            }  
          
       }
       
       if($table == 'get-moulding-material')
       {
          $query = $this->db->query(" 
                select  
                a.* 
                from moulding_material_log as a  
                where a.moulding_material_log_id = '". $rec_id ."'
                order by a.moulding_material_log_id asc
                 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list  = $row;      
            }            
       }
       
       if($table == 'get-moulding-log-item')
       {
          $query = $this->db->query(" 
                select  
                a.moulding_log_item_id, 
                a.pattern_change_time, 
                a.pattern_prod_from_time, 
                a.pattern_prod_from_datetime, 
                a.pattern_prod_to_time, 
                a.pattern_prod_to_datetime, 
                a.breakdown_from_time, 
                a.breakdown_to_time, 
                a.machine_on_time, 
                a.machine_off_time, 
                a.heat_no, 
                a.produced_box,  
                a.pouring_box,  
                a.leftout_box, 
                a.leftout_remarks, 
                a.knock_out_time, 
                a.remarks,
                a.work_planning_id,
                d.match_plate_no,
                d.pattern_item,
                a.manpower_comsumption,
                a.bottom_moulding_machine_operator,
                a.top_moulding_machine_operator,
                a.core_setter_name,
                a.mould_closer_name,
                a.mullar_operator_name ,
                a.addt_other_operators,
                a.closed_mould_qty,
				a.moulding_hrd_top,
				a.moulding_hrd_bottom,
				a.supervisor,
                a.modification_details,
                a.chk_pattern_condition,
                a.chk_logo_identify,
                a.chk_gating_sys_identify,
                a.chk_mold_closing_status,
                a.breakdown_remarks
                from moulding_log_item_info as a   
                left join work_planning_info as e on e.work_planning_id = a.work_planning_id
                left join work_order_items_info as b on b.work_order_item_id = e.work_order_item_id
                left join pattern_info as d on d.pattern_id = b.pattern_id  
                where a.moulding_log_item_id = '". $rec_id ."'
                order by a.moulding_log_item_id asc
                 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list  = $row;      
            }            
       }
       
       if($table == 'get-melting-log')
       {
          $query = $this->db->query(" 
                select  
                a.* 
                from melting_heat_log_info as a     
                where a.melting_heat_log_id = '". $rec_id ."'
                order by a.melting_heat_log_id asc
                 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list  = $row;      
            }    
            
          $query = $this->db->query(" 
                select  
                a.* 
                from melting_item_info as a     
                where a.melting_heat_log_id = '". $rec_id ."'
                order by a.melting_item_id asc
                 
            ");
             
           
            foreach($query->result_array() as $row)
            {
                $rec_list['itm'][]  = $row;      
            }          
       }
       
       
       if($table == 'get-grade')
       {
          $query = $this->db->query(" 
                select 
                *
                from grade_info as a
                where a.grade_id = '". $rec_id ."'
                and a.`status` = 'Active' 
                order by a.grade_id asc
                 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list   = $row;      
            }  
          
       }
       if($table == 'get-pattern')
       {
          $query = $this->db->query(" 
                select 
                a.*
                from pattern_info as a 
                where a.pattern_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'get-pattern-maker')
       {
          $query = $this->db->query(" 
                select 
                a.*  
                from pattern_maker_info as a 
                where a.pattern_maker_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }            
       }
       
       if($table == 'core_item_info')
       {
          $query = $this->db->query(" 
                select 
                a.*  
                from core_item_info as a 
                where a.core_item_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }            
       }
       
       if($table == 'get-pattern-core-item')
       {
          if($this->input->post('core_maker_id') != '') {
                $query = $this->db->query(" 
                    select 
                    a.core_item_id,
                    a.core_item_name,
                    a.core_maker_rate
                    from core_item_info as a
                    where a.pattern_id = '". $rec_id ."'
                    and a.core_maker_id = '". $this->input->post('core_maker_id') ."'
                    and a.`status` = 'Active' 
                    order by a.core_item_name asc
                     
                ");
            } else {
                $query = $this->db->query(" 
                    select 
                    a.core_item_id,
                    a.core_item_name,
                    a.core_maker_rate
                    from core_item_info as a
                    where a.pattern_id = '". $rec_id ."' 
                    and a.`status` = 'Active' 
                    order by a.core_item_name asc
                     
                ");
            }
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[]   = $row;      
            }  
          
       }
       
       if($table == 'get-core-maker')
       {
          $query = $this->db->query(" 
                select 
                a.*  
                from core_maker_info as a 
                where a.core_maker_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'core-maker-rate-info')
       {
          $query = $this->db->query(" 
                select 
                a.*  
                from core_maker_rate_info as a 
                where a.core_maker_rate_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'get-customer-WO')
       {
          $query = $this->db->query(" 
                select 
                a.work_order_id,
                a.customer_PO_No,
                DATE_FORMAT(a.order_date,'%d-%m-%Y') as order_date 
                from work_order_info as a
                where a.`status`!= 'Delete' 
                and a.customer_id =  '". $rec_id ."'
                order by a.order_date asc
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list[] = $row;      
            }  
          
       }
       
       if($table == 'get-WO-item')
       {
          $query = $this->db->query(" 
                select 
                a.pattern_id,
                b.pattern_item as item
                from work_order_items_info as a
                left join pattern_info as b on b.pattern_id = a.pattern_id 
                where  a.work_order_id = '". $rec_id ."'
                order by a.work_order_item_id asc
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list[] = $row;      
            }  
          
       }
       
       
       if($table == 'get-sub-contractor')
       {
          $query = $this->db->query(" 
                select 
                a.*  
                from sub_contractor_info as a 
                where a.sub_contractor_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'get-customer-sub-contractor')
       {
          $query = $this->db->query(" 
                select 
                a.sub_contractor_id,
                a.company_name  
                from sub_contractor_info as a 
                where a.status='Active' and a.type = 'Customer'
                and a.customer_id = '". $rec_id ."'
                order by a.company_name asc
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list[]  = $row;      
            }  
          
       }
       
       if($table == 'get-customer')
       {
          $query = $this->db->query(" 
                select 
                a.customer_id, 
                a.company_name, 
                a.contact_person, 
                a.address_line, 
                a.area, 
                a.city, 
                a.pincode, 
                a.state, 
                a.country, 
                a.mobile, 
                a.phone, 
                a.email, 
                a.gst_no,  
                a.melting_loss_percentage,  
                a.`status`
                from customer_info as a
                where a.customer_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'get-customer-contact')
       {
          $query = $this->db->query(" 
                select 
                a.customer_contact_id, 
                a.cc_code,
                a.customer_group,
                a.company, 
                a.contact_person, 
                a.mobile, 
                a.phone, 
                a.email,  
                a.address, 
                a.state_code, 
                a.city_code, 
                a.pincode, 
                a.gst_no,
                a.aadhar_no,
                a.`status` 
                from crit_customer_contact_info as a
                where a.customer_contact_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       if($table == 'get-rejection-type')
       {
          $query = $this->db->query(" 
                select 
                a.rejection_type_id, 
                a.rejection_type_name 
                from rejection_type_info as a
                where a.status='Active' and a.rejection_group = '". $rec_id ."'
                order by a.rejection_type_name asc 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list[]  = $row;      
            }  
          
       }
       
       
       if($table == 'get-qc-inspection-info')
       {
          $query = $this->db->query("  
                select 
                a.*,
                d.* 
                from qc_inspection_info as a
                left join work_planning_info as e on e.work_planning_id = a.work_planning_id
                left join work_order_items_info as b on b.work_order_item_id = e.work_order_item_id
                left join pattern_info as d on d.pattern_id = b.pattern_id 
                where a.qc_inspection_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'get-customer-despatch')
       {
           $query = $this->db->query(" 
                select 
                a.* 
                from customer_despatch_info as a
                where a.customer_despatch_id = '". $rec_id ."'
                order by a.customer_despatch_id asc 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list['dc']  = $row;      
            } 
            
           /* $query = $this->db->query(" 
                select 
                a.* 
                from customer_despatch_item_info as a
                where a.customer_despatch_id = '". $rec_id ."'
                order by a.customer_despatch_item_id asc 
            ");
           
            foreach($query->result_array() as $row)
            {  
                $rec_list['item'][]  = $row;      
            }  */
          
       }
       
       
       if($table == 'get-days-heat-no')
       {
         
        
        $query = $this->db->query(" 
                select 
                (ifnull(max(days_heat_no),0) + 1) as days_heat_no
                from melting_heat_log_info as a
                where a.melting_date = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list['days_heat_no'] = str_pad($row['days_heat_no'],2,0,STR_PAD_LEFT);    
            }  
        
       } 
       
       
       if($table == 'get_items_PO_bal_qty') {
          $sql = "
                select 
                a.work_order_id,
                a.order_date, 
                a.customer_PO_No,
                d.pattern_item,
                b.qty,
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
                where a.`status` = 'Active' and ((b.qty -  ifnull(c.despatch_qty,0)) > 0) and b.`status` = 'Active'
                and b.pattern_id = '". $rec_id ."' 
                order by a.order_date asc, a.customer_PO_No 
          ";
          
          $query = $this->db->query($sql);
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list[]  = $row;      
            }  
       }
       
       if($table == 'get_customer_plan_item') {
          $sql = "
                select  
                a.pattern_id ,
                b.pattern_item             
                from work_planning_info as a
                left join pattern_info as b on b.pattern_id = a.pattern_id  
                where a.status != 'Delete' 
                and a.planning_date = '". $this->input->post('planning_date') ."'
                and a.shift = '". $this->input->post('shift') ."'  and a.customer_id = '". $rec_id ."' 
                and (a.prt_work_plan_id = 0  || a.prt_work_plan_id is null)
                group by a.pattern_id
                order by b.pattern_item 
          ";
          
          $query = $this->db->query($sql);
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list[]  = $row;      
            }  
       }
       
       if($table == 'system_sand_register_info') {
          $sql = "
                select  
                a.*           
                from system_sand_register_info as a 
                where a.system_sand_register_id = '". $rec_id ."'  
                order by a.system_sand_register_id 
          ";
          
          $query = $this->db->query($sql);
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list = $row;      
            }  
       }
       
       if($table == 'get_work_plan_headcode') {
          $sql = "
                select 
                z.melting_heat_log_id ,  
                concat(s.heat_code ,s.days_heat_no) as heat_code,
                z.produced_qty   
                from (
                (
                select 
                a.melting_heat_log_id,
                sum(a.produced_qty) as produced_qty
                from melting_item_info as a
                where a.`status` != 'Delete'
                and a.work_planning_id = '". $rec_id ."'
                group by a.work_planning_id , a.melting_heat_log_id
                order by a.melting_heat_log_id
                ) union all (
                select 
                a.melting_heat_log_id,
                sum(a.produced_qty) as produced_qty
                from melting_child_item_info as a
                where a.`status` != 'Delete'
                and a.work_planning_id = '". $rec_id ."'
                group by a.work_planning_id , a.melting_heat_log_id
                order by a.melting_heat_log_id
                )
                ) as z 
                left join melting_heat_log_info as s on s.melting_heat_log_id = z.melting_heat_log_id
                order by s.heat_code , s.days_heat_no 
          ";
          
            $query = $this->db->query($sql);  
            $rec_list = array();   
            foreach($query->result_array() as $row)
            {  
                $rec_list[] = $row;      
            }  
       }
       
       if($table == 'user_login')
       {
          $query = $this->db->query(" 
                select 
                *
                from user_login as a
                where a.user_id = '". $rec_id ."'
                order by a.user_id asc 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list = $row;      
            }  
          
       }
       
       if($table == 'melting_item_chemical_info')
       {
          $query = $this->db->query(" 
                select 
                *
                from melting_item_chemical_info as a
                where a.melting_item_chemical_id = '". $rec_id ."'
                order by a.melting_item_chemical_id asc 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list = $row;      
            }  
          
       }
        
        
      if($table == 'mrm_target_info')
       {
          $query = $this->db->query(" 
                select 
                a.*
                from mrm_target_info as a 
                where grp_id =  $rec_id
                order by a.sno asc   
                 
            "); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row;      
            }            
       }  
       
         
       if($table == 'get-despatch-pattern-headcode')
       {
          $query = $this->db->query(" 
               select 
                c.heat_code,
                c.qty
                from customer_despatch_info as a 
                left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id 
                left join heatcode_despatch_info as c on c.customer_despatch_item_id = b.customer_despatch_item_id
                where a.`status` = 'Active' and b.`status` = 'Active' and c.`status` = 'Active'
                and a.customer_id = '". $rec_id ."'
                and b.pattern_id = '". $this->input->post('pattern_id') ."'
                order by a.despatch_date desc , c.heat_code
                 
            "); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row;      
            }            
       }   
          
       
       
       if($table == 'user')
       {
            $query = $this->db->query(" 
                select 
                a.*
                from rh_user_info as a
                where a.user_id =  $rec_id
                order by  a.first_name asc 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list  = $row;     
            }
       }
        
          
       if($table == 'district_list')
       {
          $query = $this->db->query("
            select 
            a.districts_name as city  
            from zazu_districts_info as a
            left join zazu_states_info as b on b.state_id = a.state_id
            where b.state_name = '".$rec_id ."'
            order by a.districts_name asc
          "
          );
             
            $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[]  = $row;     
            }  
          
       }
       
       if($table == 'district_lookup')
       {
          $query = $this->db->query("
            select 
            a.district_name as district
            from crit_pincode_info as a
            where a.state_name = '".$rec_id ."'
            group by a.district_name 
            order by a.district_name asc 
          "
          );
             
            $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[]  = $row;     
            }  
          
       }
       if($table == 'area_list')
       {
          $query = $this->db->query("
          select  
            a.area_name as area
            from zazu_city_area_info as a   
            left join zazu_districts_info as b on b.districts_id = a.districts_id
            where b.districts_name = '".$rec_id ."'
            order by a.area_name asc  
          "
          );
             
            $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row;     
            }  
          
         }
       
       if($table == 'area')
       {
          $query = $this->db->query("
          select 
            a.city_area_id,
            a.state_id,
            a.districts_id,
            a.city_name,
            a.area_name 
            from zazu_city_area_info as a   
            where a.city_area_id =  '".$rec_id ."'
          "
          );
             
            $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list = $row;     
            }  
          
         } 
         
        if($table == 'pickup_info')
        {
              
            $query = $this->db->query("
            select 
            a.* ,
            DATE_FORMAT(a.pickup_schedule_timing,'%Y-%m-%dT%H:%i') as schedule_time,
            b.invoice_no,
            b.invoice_id
            from rh_pickup_info as a  
            left join crit_invoice_info as b on b.pickup_id = a.pickup_id 
            where a.pickup_id =  '".$rec_id ."'
            "
            );
             
            $rec_list = array();  
            
            foreach($query->result_array() as $row)
            {
                $rec_list = $row;     
            }  
            
            //echo (json_encode($rec_list)); exit;
        
        }
        
        if($table == 'pick_pack_info')
        {
              
            $query = $this->db->query("
            select 
            a.*  
            from crit_pick_pack_info as a   
            where a.pick_pack_id =  '".$rec_id ."'
            "
            );
             
            $rec_list = array();  
            
            foreach($query->result_array() as $row)
            {
                $rec_list = $row;     
            }  
            
            //echo (json_encode($rec_list)); exit;
        
        }
        
        
        
       if($table == 'delivery_alert')
       {
            $query = $this->db->query(" set SQL_BIG_SELECTS=1 ");
            $query = $this->db->query("  
                select 
                a.pickup_id as ref_no,
                b.state_name as src_state,
                lower(b.district_name) as src_city,
                c.state_name as dest_state,
                lower(c.district_name) as  dest_city
                from rh_pickup_info as a
                left join ( select q.pincode, q.state_name, q.district_name from  crit_pincode_info as q group by q.pincode ) as b on b.pincode = a.source_pincode
                left join ( select q.pincode, q.state_name, q.district_name from  crit_pincode_info as q group by q.pincode ) as c on c.pincode = a.destination_pincode
                where a.`status` = 'Picked' and a.courier_type = 'Domestic'
                and a.delivered_date = '". date('Y-m-d') ."'  
                order by a.pickup_id asc 
            ");
             
           $rec_list = array();  
           
           $cnt = $query->num_rows(); 
           //$rec_list[]  = array(); 
            foreach($query->result_array() as $row)
            {
                $rec_list[]  = $row ;
            }  
       } 
       
       if($table == 'pincode-state-district')
       {
            $query = $this->db->query(" set SQL_BIG_SELECTS=1 ");
            $query = $this->db->query("  
                select 
                q.state_name as state, 
                q.district_name as district
                from crit_pincode_info as q 
                where q.pincode = '". $rec_id."' 
                and q.`status` = 'Active'
                group by q.state_name , q.district_name 
            ");
             
           $rec_list = array();  
           
            //$cnt = $query->num_rows();  
           
            foreach($query->result_array() as $row)
            {
                $rec_list  = $row ;
            } 
             
       } 
       if($table == 'account_head')
           {
              $query = $this->db->query(" 
                    select
                    a.account_head_id as id,
                    a.account_head_name as value
                    from crit_account_head as a 
                    where a.type =  '".$rec_id . "'
                    order by a.account_head_name asc 
                ");
                 
               $rec_list = array();  
        
                foreach($query->result_array() as $row)
                {
                    $rec_list[]  = $row;     
                }  
              
           }
           
        if($table == 'sub_account_head')
        {
              $query = $this->db->query(" 
                    select
                    a.sub_account_head_id, 
                    a.type,
                    a.account_head_id,
                    a.sub_account_head_name,
                    a.status
                    from crit_sub_account_head as a 
                    where a.sub_account_head_id =  '".$rec_id . "'
                    order by a.sub_account_head_name asc 
                ");
                 
               $rec_list = array();  
        
                foreach($query->result_array() as $row)
                {
                    $rec_list  = $row;     
                }                
        } 
        
        
        if($table == 'load_sub_account_head')
        {
              $query = $this->db->query(" 
                    select
                    a.sub_account_head_id as id,  
                    a.sub_account_head_name as value 
                    from crit_sub_account_head as a 
                    where a.account_head_id =  '".$rec_id . "' 
                    and a.type = '". $this->input->post('typ') ."' 
                    and a.status='Active'
                    order by a.sub_account_head_name asc 
                ");
                 
               $rec_list = array();  
        
                foreach($query->result_array() as $row)
                {
                    $rec_list[] = $row;     
                }  
              
        } 
       
       
        if($table == 'cash_inward')
        {
              $query = $this->db->query(" 
                    select
                    a.cash_inward_id, 
                    a.inward_date,
                    a.account_head_id,
                    a.sub_account_head_id,
                    a.amount,
                    a.remarks
                    from crit_cash_inward as a 
                    where a.cash_inward_id =  '".$rec_id . "'
                    order by a.cash_inward_id asc 
                ");
                 
               $rec_list = array();  
        
                foreach($query->result_array() as $row)
                {
                    $rec_list  = $row;     
                }  
              
        }     
        
        if($table == 'cash_outward')
        {
              $query = $this->db->query(" 
                    select
                    a.cash_outward_id, 
                    a.outward_date,
                    a.account_head_id,
                    a.sub_account_head_id,
                    a.amount,
                    a.cash_received_by,
                    a.remarks
                    from crit_cash_outward as a 
                    where a.cash_outward_id =  '".$rec_id . "'
                    order by a.cash_outward_id asc 
                ");
                 
               $rec_list = array();  
        
                foreach($query->result_array() as $row)
                {
                    $rec_list  = $row;     
                }  
              
        }
        
        if($table == 'invoice')
        {
              $query = $this->db->query(" 
                    select  
                    a.invoice_id,
                    a.invoice_no,   
                    a.invoice_date,   
                    a.client_name,  
                    a.address, 
                    a.state, 
                    a.contact_no, 
                    a.client_GSTIN,
                    a.way_bill,
                    a.weight,
                    a.amount,
                    a.GST_percentage,
                    a.total_amount        
                    from crit_invoice_info as a 
                    where a.invoice_id =  '".$rec_id . "'
                    order by a.invoice_id asc 
                ");
                 
               $rec_list = array();  
        
                foreach($query->result_array() as $row)
                {
                    $rec_list  = $row;     
                }  
              
        } 
       
       
       $this->db->close();
       
       header('Content-Type: application/x-json; charset=utf-8');

       echo (json_encode($rec_list));  
	}
    
    
    public function get_content($table = '', $rec_id = '')
    {
       //if(!$this->session->userdata('zazu_logged_in'))  redirect();
       
       if(empty($table) && empty($rec_id)) {
           $table = $this->input->post('tbl') ;
           $rec_id = $this->input->post('id'); 
           $edit_mode = $this->input->post('edit_mode'); 
           $del_mode = $this->input->post('del_mode'); 
           $flg = true;
       } else {
        $flg = false;
       }
       
       
       if($table == 'customer_info')
       {
          $query = $this->db->query("
            select 
                a.customer_id as id, 
                a.company_name, 
                a.contact_person, 
                a.address_line, 
                a.area, 
                a.city, 
                a.pincode, 
                a.state, 
                a.country, 
                a.mobile, 
                a.phone, 
                a.email, 
                a.gst_no,
                a.bank_name, 
                a.branch, 
                a.ac_holder_name, 
                a.ac_no, 
                a.ifsc_code,  
                a.`status`,
                a.created_datetime,
                d.name as created_by,
                a.updated_datetime as last_updated_datetime,
                d.name as last_updated_by 
                from customer_info as a
                left join user_login as d on d.user_id = a.created_by
                left join user_login as e on e.user_id = a.updated_by
                where a.customer_id =  '". $rec_id. "' 
                order by a.created_datetime    
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }
       
       if($table == 'pattern_maker_info')
       {
          $query = $this->db->query("
            select 
                a.pattern_maker_id as id, 
                a.company_name, 
                a.contact_person, 
                a.address_line, 
                a.area, 
                a.city, 
                a.pincode, 
                a.state, 
                a.country, 
                a.mobile, 
                a.phone, 
                a.email, 
                a.gst_no, 
                a.bank_name, 
                a.branch, 
                a.ac_holder_name, 
                a.ac_no, 
                a.ifsc_code,
                a.`status`,
                a.created_datetime,
                d.name as created_by,
                a.updated_datetime as last_updated_datetime,
                d.name as last_updated_by 
                from pattern_maker_info as a
                left join user_login as d on d.user_id = a.created_by
                left join user_login as e on e.user_id = a.updated_by 
                where a.pattern_maker_id =  '". $rec_id. "' 
                order by a.created_datetime    
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }
       
       if($table == 'core_maker_info')
       {
          $query = $this->db->query("
            select 
                a.core_maker_id as id, 
                a.company_name, 
                a.contact_person, 
                a.address_line, 
                a.area, 
                a.city, 
                a.pincode, 
                a.state, 
                a.country, 
                a.mobile, 
                a.phone, 
                a.email, 
                a.gst_no, 
                a.bank_name, 
                a.branch, 
                a.ac_holder_name, 
                a.ac_no, 
                a.ifsc_code, 
                a.`status`,
                a.created_datetime,
                d.name as created_by,
                a.updated_datetime as last_updated_datetime,
                d.name as last_updated_by 
                from core_maker_info as a
                left join user_login as d on d.user_id = a.created_by
                left join user_login as e on e.user_id = a.updated_by
                where a.core_maker_id =  '". $rec_id. "' 
                order by a.created_datetime    
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }
       
       if($table == 'melting_item_chemical_info')
       {
          $query = $this->db->query("
            select 
            d.melting_item_chemical_id as id,
            c.pattern_item,
            a.pouring_box as poured_box
            from melting_item_chemical_info as d
            left join melting_item_info as a on a.melting_item_id  = d.melting_item_id
            left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
            left join pattern_info as c on c.pattern_id = b.pattern_id
            where d.melting_heat_log_id = '". $rec_id. "' and d.status = 'Active'
            order by c.pattern_item asc   
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }
       
       
       if($table == 'employee_info')
       {
          $query = $this->db->query("
            select 
                a.employee_id as id, 
                a.employee_name,
                a.aadhar_no, 
                a.address_line, 
                a.area, 
                a.city, 
                a.pincode, 
                a.state, 
                a.country, 
                a.mobile, 
                a.phone, 
                a.email,  
                a.bank_name, 
                a.branch, 
                a.ac_holder_name, 
                a.ac_no, 
                a.ifsc_code, 
                a.`status`,
                a.created_datetime,
                d.name as created_by,
                a.updated_datetime as last_updated_datetime,
                d.name as last_updated_by 
                from employee_info as a
                left join user_login as d on d.user_id = a.created_by
                left join user_login as e on e.user_id = a.updated_by
                where a.employee_id =  '". $rec_id. "' 
                order by a.created_datetime    
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }
        
       
       if($table == 'pattern_info')
       {
          $query = $this->db->query("
            select 
                    a.pattern_id,
                    b.company_name as customer,
                    a.pattern_type, 
                    if(a.core_box = '1','Yes','No') as core_box_req,
                    a.no_of_core, 
                    a.type_of_core, 
                    a.match_plate_no, 
                    a.pattern_item,  
                    a.item_description, 
                    c.grade_name as grade, 
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
                    a.no_of_cavity, 
                    if(a.with_transportation = '1','Yes','No') as with_transportation,
                    a.piece_weight_per_kg, 
                    a.bunch_weight,  
                    a.trial_card_no, 
                    a.core_maker_rate, 
                    a.grinding_rate, 
                    a.core_weight,
                    a.casting_weight, 
                    a.yeild,
                    a.rate_per_kg, 
                    a.rate_per_piece, 
                    a.`status` ,
                    a.item_type , 
                    a.created_datetime,
                    d.name as created_by,
                    a.updated_datetime as last_updated_datetime,
                    d.name as last_updated_by 
                    from pattern_info as a
                    left join customer_info as b on b.customer_id = a.customer_id
                    left join grade_info as c on c.grade_id = a.grade 
                    left join user_login as d on d.user_id = a.created_by
                    left join user_login as e on e.user_id = a.updated_by
                where   a.status != 'Delete' and a.pattern_id = '". $rec_id. "'   
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }
	   
	   if($table == 'pattern-chem-compo')
       {
          $query = $this->db->query("
             select
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
				a.yeild_strength as yield_strength
				from pattern_info as a
				where a.pattern_id = '". $rec_id. "'
				and a.`status` = 'Active' 
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }
       
       if($table == 'work_order_info')
       {
          $query = $this->db->query("
             select 
                    a.work_order_id,
                    a.order_date,
                    a.work_order_no,
                    b.company_name as customer,
                    a.customer_PO_No,
                    a.mode_of_order, 
                    a.is_conversion_type, 
                    a.remarks ,
                    a.created_datetime,
                    d.name as created_by,
                    a.updated_datetime as last_updated_datetime                
                    from work_order_info as a
                    left join customer_info as b on b.customer_id = a.customer_id 
                    left join user_login as d on d.user_id = a.created_by
                where a.`status` != 'Delete' and a.work_order_id = '". $rec_id. "'   
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }
       
       if($table == 'work_order_item_info')
       {
          $query = $this->db->query("
             select 
                    a.work_order_item_id as id,
                    b.pattern_item,  
                    c.uom_name as uom, 
                    a.qty,
                    if(b.item_type = 'Parent' ,round((a.qty / b.no_of_cavity),0),0) as box,
                    a.rate_per_piece, 
                    a.weight_per_piece, 
                    if(b.item_type = 'Parent' ,round(((a.qty / b.no_of_cavity) * b.bunch_weight),3),0) as box_wt,
                    a.total_weight,
                    a.total as total_amount,
                    a.delivery_date,
                    d.despatch_qty                
                    from work_order_items_info as a
                    left join pattern_info as b on b.pattern_id = a.pattern_id 
                    left join uom_info as c on c.uom_id = a.uom 
                    left join ( 
                        select 
                        c1.work_order_id,
                        b1.pattern_id,
                        sum(c1.qty) as despatch_qty
                        from customer_despatch_info as a1
                        left join customer_despatch_item_info as b1 on b1.customer_despatch_id = a1.customer_despatch_id
                        left join heatcode_despatch_info as c1 on c1.customer_despatch_item_id = b1.customer_despatch_item_id
                        where a1.`status` = 'Active' and c1.work_order_id = '". $rec_id. "'
                        group by c1.work_order_id , b1.pattern_id 
                        ) as d on d.work_order_id = a.work_order_id and d.pattern_id = a.pattern_id
                where a.status='Active' and a.work_order_id = '". $rec_id. "'   
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }       
        
       
       if($table == 'melting_log_info')
       {
          $query = $this->db->query("
            select 
                e.planning_date,
                e.shift,
                c.company_name as customer,
                f.customer_PO_No,
                d.match_plate_no,
                d.pattern_item,
                a.melting_date,
                a.lining_heat_no, 
                a.heat_code, 
                a.days_heat_no, 
                a.furnace_on_time, 
                a.furnace_off_time, 
                a.pouring_start_time,
                a.pouring_finish_time,
                a.total_time,
                a.pouring_box, 
                a.produced_qty,
                a.tapp_temp, 
                a.pour_temp, 
                a.temp_first_box, 
                a.temp_last_box, 
                a.start_units, 
                a.end_units, 
                a.boring, 
                a.ms, 
                a.foundry_return, 
                a.CI_scrap, 
                a.pig_iron, 
                a.C, 
                a.SI, 
                a.Mn, 
                a.S, 
                a.Cu, 
                a.Cr, 
                a.fe_si_mg, 
                a.fe_sulphur, 
                a.inoculant, 
                a.pyrometer_tip, 
                a.ideal_hrs_from, 
                a.ideal_hrs_to, 
                a.total_hrs, 
                a.fc_operator,
                a.pouring_person_name_1,
                a.pouring_person_name_2,
                a.pouring_person_name_3,
                a.helper_name,
                a.remarks
                from melting_log_info as a   
                left join work_planning_info as e on e.work_planning_id = a.work_planning_id
                left join work_order_items_info as b on b.work_order_item_id = e.work_order_item_id
                left join pattern_info as d on d.pattern_id = b.pattern_id  
                left join customer_info as c on c.customer_id = e.customer_id
                left join work_order_info as f on f.work_order_id = e.work_order_id
                where a.melting_log_id = '". $rec_id ."'
                order by a.melting_log_id asc
            
              
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }
       
        if($table == 'melting_heat_log_info')
       {
          $query = $this->db->query("
            select 
                melting_heat_log_id, 
                planning_date, 
                shift, 
                melting_date, 
                lining_heat_no, 
                heat_code, 
                days_heat_no, 
                furnace_on_time, 
                furnace_off_time, 
                tapp_temp, 
                temp_first_box, 
                temp_last_box, 
                ladle_1_first_box_pour_temp, 
                ladle_2_first_box_pour_temp, 
                pouring_start_time, 
                pouring_finish_time,
                start_units, 
                end_units, 
                boring, 
                ms, 
                foundry_return, 
                CI_scrap, 
                pig_iron, 
                C, 
                SI, 
                Mn, 
                S, 
                Cu, 
                Cr, 
                graphite_coke,
                fe_si_mg,
                fe_sulphur, 
                inoculant, 
                pyrometer_tip, 
                spillage, 
                ni, 
                mo, 
                ideal_hrs_from, 
                ideal_hrs_to, 
                b_c, 
                b_si, 
                b_mn, 
                b_p, 
                b_s, 
                b_cr, 
                b_cu, 
                b_mg, 
                b_bmn, 
                f_c, 
                f_si, 
                f_mn, 
                f_p, 
                f_s, 
                f_cr, 
                f_cu, 
                f_mg, 
                f_bmn, 
                remarks, 
                fc_operator, 
                pouring_person_name_1, 
                pouring_person_name_2, 
                pouring_person_name_3, 
                helper_name,
                a.created_datetime,
                b.user_name as created_by,
                a.updated_datetime,
                c.user_name as updated_by
                from melting_heat_log_info as a   
                left join user_login as b on b.user_id = a.created_by
                left join user_login as c on c.user_id = a.updated_by
                where a.melting_heat_log_id = '". $rec_id ."'
                order by a.melting_heat_log_id asc
            
              
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }
       
       if($table == 'sub_contractor_info')
       {
          $query = $this->db->query("
                select 
                a.sub_contractor_id, 
                a.company_name, 
                a.contact_person, 
                a.type,
                b.company_name as customer,
                a.grinding_rate,
                a.address_line, 
                a.area, 
                a.city, 
                a.pincode, 
                a.state, 
                a.country, 
                a.phone, 
                a.mobile, 
                a.email, 
                a.gst_no, 
                a.bank_name, 
                a.branch, 
                a.ac_holder_name, 
                a.ac_no, 
                a.ifsc_code, 
                a.`status`
                from sub_contractor_info as a  
                left join customer_info as b on b.customer_id = a.customer_id
                where a.sub_contractor_id = '". $rec_id. "' 
                order by a.sub_contractor_id desc
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row;
                /*foreach($row as $fld => $val){
                    $rec_list[$fld]  = $val;     
                }*/
            }  
          
       } 
       
       if($table == 'customer_despatch_info')
       {
          $query = $this->db->query("
             select 
                a.customer_despatch_id, 
                a.dc_no, 
                a.despatch_date, 
                b.company_name as customer,  
                a.dc_type,
                c.transporter_name,
                c.transporter_gst,
                a.vehicle_no, 
                a.driver_name, 
                a.mobile, 
                a.remarks, 
                a.`status`
                from customer_despatch_info as a  
                left join customer_info as b on b.customer_id = a.customer_id 
                left join transporter_info as c on c.transporter_id = a.transporter_id 
                where a.customer_despatch_id = '". $rec_id. "'   
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       } 
       
       if($table == 'customer_despatch_item_info')
       {
         /* $query = $this->db->query("
             select 
                a.customer_despatch_item_id as id,
                d.company_name as sub_contractor_machining,
                c.company_name as sub_contractor_grinding,
                b.pattern_item, 
                a.qty 
                from customer_despatch_item_info as a  
                left join pattern_info as b on b.pattern_id = a.pattern_id
                left join sub_contractor_info as c on c.sub_contractor_id = a.grinding_sub_contractor_id
                left join sub_contractor_info as d on d.sub_contractor_id = a.machining_sub_contractor_id
                where a.customer_despatch_id = '". $rec_id. "'  
                order by  a.customer_despatch_item_id
          "
          ); */
             
			$query = $this->db->query("
             select 
                a.customer_despatch_item_id as id,
                d.company_name as sub_contractor_machining,
                c.company_name as sub_contractor_grinding,
                b.pattern_item, 
                sum(a.qty) as qty 
                from customer_despatch_item_info as a  
                left join pattern_info as b on b.pattern_id = a.pattern_id
                left join sub_contractor_info as c on c.sub_contractor_id = a.grinding_sub_contractor_id
                left join sub_contractor_info as d on d.sub_contractor_id = a.machining_sub_contractor_id
                where a.customer_despatch_id = '". $rec_id. "'  
                group by  a.customer_despatch_id, a.work_order_id ,a.pattern_id 
                order by  a.customer_despatch_id, a.work_order_id ,a.pattern_id 
          "
          );  
			 
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       } 
       if($table == 'heatcode_despatch_info')
       {
          $query = $this->db->query("
             select 
                concat(d.heat_code,d.days_heat_no) as heat_code,
                a.customer_PO_No, 
                c.pattern_item,
                a.qty 
                from heatcode_despatch_info as a  
                left join customer_despatch_item_info as b on b.customer_despatch_item_id = a.customer_despatch_item_id 
                 left join pattern_info as c on c.pattern_id = b.pattern_id
                left join melting_heat_log_info as d on d.melting_heat_log_id = a.melting_heat_log_id
                where b.customer_despatch_id = '". $rec_id. "' 
                order by a.customer_despatch_item_id , a.heat_code asc  
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       } 
       
        if($table == 'ms_despatch_info')
       {
          $query = $this->db->query("
             select 
                a.ms_despatch_id, 
                a.dc_no, 
                a.despatch_date, 
                b.company_name as customer,  
                c.transporter_name,
                c.transporter_gst,
                a.vehicle_no, 
                a.driver_name, 
                a.mobile, 
                a.remarks, 
                a.`status`
                from ms_despatch_info as a  
                left join customer_info as b on b.customer_id = a.customer_id 
                left join transporter_info as c on c.transporter_id = a.transporter_id 
                where a.ms_despatch_id = '". $rec_id. "'   
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       } 
       
       if($table == 'ms_despatch_itm_info')
       {
          
             
			$query = $this->db->query("
             select 
                a.ms_despatch_itm_id as id, 
                b.pattern_item, 
                a.qty as qty 
                from ms_despatch_itm_info as a  
                left join pattern_info as b on b.pattern_id = a.pattern_id 
                where a.ms_despatch_id = '". $rec_id. "' 
                order by a.ms_despatch_itm_id, b.pattern_item  
          "
          );  
			 
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       } 
       
       if($table == 'customer_rejection_info')
       {
          $query = $this->db->query("
             select 
                a.customer_rejection_id, 
                a.rej_date, 
                a.dc_info, 
                a.invoice_info,  
                b.company_name as customer,   
                a.veh_reg_no as vehicle_no, 
                a.rej_grp,  
                a.`status`
                from customer_rejection_info as a  
                left join customer_info as b on b.customer_id = a.customer_id  
                where a.customer_rejection_id = '". $rec_id. "'   
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       } 
       
        if($table == 'customer_rejection_itm_info')      
       {
          $query = $this->db->query("
             select 
                a.customer_rejection_itm_id as id,    
                b.pattern_item as item,
                c.rejection_type_name as rejection_type,
                a.qty,
                b.piece_weight_per_kg as piece_weight,
                round((a.qty * b.piece_weight_per_kg),3) as weight, 
				a.remarks 
                from customer_rejection_itm_info as a  
                left join pattern_info as b on b.pattern_id = a.pattern_id  
                left join rejection_type_info as c on c.rejection_type_id = a.rej_type_id    
                where a.customer_rejection_id = '". $rec_id. "'   
                order by a.customer_rejection_itm_id
          "
          ); 
             
           $rec_list = array();                                                          
		   
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row;      
            }  
          
       } 
       
       if($table == 'ms_rework_info')
       {
          $query = $this->db->query("
             select 
                a.ms_rework_id, 
                a.rework_date, 
                a.dc_info, 
                a.invoice_info,  
                b.company_name as customer,   
                a.veh_reg_no as vehicle_no, 
                a.rework_type AS type,  
                a.`status`
                from ms_rework_info as a  
                left join customer_info as b on b.customer_id = a.customer_id  
                where a.ms_rework_id = '". $rec_id. "'   
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       } 
       
        if($table == 'ms_rework_itm_info')
       {
          $query = $this->db->query("
             select  
                b.pattern_item as item, 
                a.qty,
                a.status
                from ms_rework_itm_info as a  
                left join pattern_info as b on b.pattern_id = a.pattern_id    
                where a.ms_rework_id = '". $rec_id. "'   
                order by a.ms_rework_itm_id
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       } 
       
       if($table == 'sub_contractor_despatch_info')
       {
          $query = $this->db->query("
             select 
                a.sub_contractor_despatch_id, 
                a.dc_no, 
                a.despatch_date, 
                c.company_name as sub_contractor, 
                b.company_name as customer, 
                a.vehicle_no, 
                a.driver_name, 
                a.mobile, 
                a.remarks, 
                a.`status`
                from sub_contractor_despatch_info as a  
                left join customer_info as b on b.customer_id = a.customer_id
                left join sub_contractor_info as c on c.sub_contractor_id = a.sub_contractor_id
                where a.sub_contractor_despatch_id = '". $rec_id. "'   
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       } 
       
       if($table == 'sub_contractor_despatch_item_info')
       {
          $query = $this->db->query("
             select 
                a.sub_contractor_despatch_item_id as id, 
                b.pattern_item, 
                a.qty 
                from sub_contractor_despatch_item_info as a  
                left join pattern_info as b on b.pattern_id = a.pattern_id
                where a.sub_contractor_despatch_id = '". $rec_id. "'   
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       } 
       
       if($table == 'melting_item_info')
       {
           
          $query = $this->db->query("
               select 
                a.melting_heat_log_id, 
                d.company_name as customer,
                e.pattern_item as item,  
                b.pouring_box,
                b.leftout_box,
                e.bunch_weight,
                ROUND((e.bunch_weight * b.pouring_box),3) as liq_metal 
                from melting_heat_log_info as a 
                left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
                left join work_planning_info as c on c.work_planning_id = b.work_planning_id
                left join customer_info as d on d.customer_id = c.customer_id
                left join pattern_info as e on e.pattern_id = c.pattern_id
                where b.melting_heat_log_id = '". $rec_id. "' and b.status='Active' 
                order by b.melting_item_id asc
          "
          ); 
             
            $rec_list = array();  
    
            foreach($query->result_array() as $row)
            { 
                $rec_list[]  = $row;     
            }  
          
       } 
       
       if($table == 'planning-moulding-melting')
       {
           
          $query = $this->db->query("
               select 
                z.planned_box,
                w.produced_box,
                q.pouring_box as  poured_box
                from work_planning_info as z 
                left join (
                select
                a.work_planning_id , 
                sum(a.produced_box) as produced_box 
                from moulding_log_item_info as a 
                where a.work_planning_id = '". $rec_id. "' and a.`status` = 'Active') as w on w.work_planning_id = z.work_planning_id  
                left join ( 
                select 
                b.work_planning_id ,
                sum(b.pouring_box) as pouring_box 
                from melting_item_info as b 
                where b.work_planning_id = '". $rec_id. "' and b.`status` = 'Active' ) as q on q.work_planning_id = z.work_planning_id
                where z.work_planning_id = '". $rec_id. "' 
          "
          ); 
             
            $rec_list = array();  
    
            foreach($query->result_array() as $row)
            { 
                $rec_list[]  = $row;     
            }  
          
       } 
       

       
       
       if(!empty($rec_list)) {
        
        if(count($rec_list) > 1  ) {
       
           $content = '
           <table class="table table-bordered table-responsive table-striped" id="sts">
             <thead>
                <tr>';
                $content .= '<th>S.No</th>';
                foreach($rec_list[0] as $fld => $val) { 
                    if($fld != 'id' && $fld != 'tbl')
                        $content .= '<th class="text-capitalize">'.   str_replace('_',' ',$fld) .'</th>';
                } 
                if($edit_mode == 1)  
                   $content .= '<th>Edit</th>';
                if($del_mode == 1) 
                   $content .= '<th>Delete</th>'; 
           $content .= '</tr>
              </thead>  
              <tbody>';
                foreach($rec_list as $k => $info) {  
                   $content .= '<tr>
                      <td>'.($k+1).'</td>';
                    foreach($rec_list[0] as $fld => $val) { 
                        if($fld != 'id') {
                             if($fld != 'tbl')
                                $content .= '<td>'. $info[$fld]  .'</td>';
                        }
                            
                    } 
                    if($edit_mode == 1)                 
                        $content .= '<td><button type="button" class="btn btn-info btn-sm btn_chld_edit" value="'. $info['id']  .'" data="'. $table  .'"><i class="fa fa-edit"></i></button></td>';    
                    if($del_mode == 1)  
                        $content .= '<td><button type="button" class="btn btn-danger btn-sm btn_chld_del" value="'. $info['id']  .'" data="'. $table  .'"><i class="fa fa-remove"></i></button></td>';    
                   $content .= '</tr>';     
                  }  
              $content .= '
              </tbody>  
            </table>';
            } else
            {
                $content = ' <table class="table table-bordered table-responsive table-striped">  ';
                $content .= '<tr><th colspan="2">'.  strtoupper(str_replace('_',' ', $table)) .'</th></tr>';
                foreach($rec_list[0] as $fld => $val) { 
                    if($fld != 'id' && $fld != 'tbl')
                    {
                        $content .= '<tr>';      
                        $content .= '<th>'. strtoupper(str_replace('_',' ',$fld)) .'</th>';
                        $content .= '<td>'.  $val.'</td>';
                        $content .= '</tr>';  
                    }
                }   
                if($edit_mode == 1)                 
                        $content .= '<tr><th>Edit</th><td><button type="button" class="btn btn-info btn-sm btn_chld_edit" value="'. $rec_list[0]['id']  .'" data="'. $table  .'"><i class="fa fa-edit"></i></button></td></tr>';    
                    if($del_mode == 1)  
                        $content .= '<tr><th>Delete</th><td><button type="button" class="btn btn-danger btn-sm btn_chld_del" value="'. $rec_list[0]['id']  .'" data="'. $table  .'"><i class="fa fa-remove"></i></button></td></tr>';
                
                $content .= '</table>';              
            }
        } else {
            $content = "<strong>No Record Found</strong>";
        }
         
        if(!$flg)
            return $content;  
        else
            echo $content;    
       
    }
    
    public function delete_record()  
    {
        
        if(!$this->session->userdata('cr_logged_in'))  redirect(); 
        
        
        $table = $this->input->post('tbl') ;
        $rec_id =$this->input->post('id');
        

        
         if($table == 'work-order')
         {            
            /*$this->db->where('booking_id', $rec_id);
            $this->db->delete('crit_b2h_manifest_info');  */
            
            $this->db->where('work_order_id', $rec_id);
            $this->db->update('work_order_info', array('status' => 'Delete'));  
            
            $this->db->where('work_order_id', $rec_id);
            $this->db->update('work_order_items_info', array('status' => 'Delete'));   


            $this->db->where('work_order_id', $rec_id);
            $this->db->update('work_planning_info', array('status' => 'Delete'));   
            
            echo 'Record Successfully deleted'; 
         }
         
         if($table == 'work_planning_info')
         {            
            /*$this->db->where('booking_id', $rec_id);
            $this->db->delete('crit_b2h_manifest_info');  */
            
            $this->db->where('work_planning_id', $rec_id);
            $this->db->update('work_planning_info', array('status' => 'Delete',
                                                          'updated_by' => $this->session->userdata('cr_user_id'),                          
                                                          'updated_date' => date('Y-m-d H:i:s')
                                                          ));  
                                                          
            /*$this->db->where('work_planning_id', $rec_id);
            $this->db->from('moulding_log_item_info as a');         
            $cnt  = $this->db->count_all_results();                                                
            if($cnt > 0) {*/
                $this->db->where('work_planning_id', $rec_id);
                $this->db->update('moulding_log_item_info', array('status' => 'Delete',
                                                              'updated_by' => $this->session->userdata('cr_user_id'),                          
                                                              'updated_datetime' => date('Y-m-d H:i:s')
                                                          )); 
           // }  

           /* $this->db->where('work_planning_id', $rec_id);
            $this->db->from('melting_item_info');         
            $cnt  = $this->db->count_all_results();                                                
            if($cnt > 0) {*/
                $this->db->where('work_planning_id', $rec_id);
                $this->db->update('melting_item_info', array('status' => 'Delete'));  
           // } 
           
           
           $this->db->where('work_planning_id', $rec_id);
           $this->db->update('qc_inspection_info', array('status' => 'Delete',
                                                              'updated_by' => $this->session->userdata('cr_user_id'),                          
                                                              'updated_datetime' => date('Y-m-d H:i:s')
                                                          )); 
            
            echo 'Record Successfully deleted'; 
         }  
         
         if($table == 'work-order-item')
         {            
             
            $this->db->where('work_order_item_id', $rec_id);
            $this->db->update('work_order_items_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }
         
         if($table == 'ms-floor-stock')
         {            
            $this->db->where('ms_floor_stock_id', $rec_id);
            $this->db->delete('ms_floor_stock_info');   
            echo 'Record Successfully deleted'; 
         }   
         
         if($table == 'core-floor-stock')
         {            
            $this->db->where('core_floor_stock_id', $rec_id);
            $this->db->delete('core_floor_stock_info');   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'system_sand_register_info')
         {            
            $this->db->where('system_sand_register_id', $rec_id);
            $this->db->delete('system_sand_register_info');   
            echo 'Record Successfully deleted'; 
         }
         
         if($table == 'floor-stock')
         {            
            $this->db->where('floor_stock_id', $rec_id);
            $this->db->delete('floor_stock_info');   
            echo 'Record Successfully deleted'; 
         }
         if($table == 'transporter_info')
         {            
            $this->db->where('transporter_id', $rec_id); 
            $this->db->update('transporter_info', array('status' => 'Delete')); 
            echo 'Record Successfully deleted'; 
         }
         if($table == 'core-plan')
         {            
            $this->db->where('core_plan_id', $rec_id);
            $this->db->update('core_plan_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'moulding-material')
         {            
            $this->db->where('moulding_material_log_id', $rec_id);
            $this->db->update('moulding_material_log', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'moulding-log-item')
         {            
            $this->db->where('moulding_log_item_id', $rec_id);
            $this->db->update('moulding_log_item_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'melting-log')
         {            
            $this->db->where('melting_heat_log_id', $rec_id);
            $this->db->update('melting_heat_log_info', array('status' => 'Delete'));
            
            $this->db->where('melting_heat_log_id', $rec_id);   
            $this->db->update('melting_item_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'qc_inspection_info')
         {            
            $this->db->where('qc_inspection_id', $rec_id);
            $this->db->update('qc_inspection_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'sub_contractor_info')
         {            
            $this->db->where('sub_contractor_id', $rec_id);
            $this->db->update('sub_contractor_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         if($table == 'customer_info')
         {            
            $this->db->where('customer_id', $rec_id);
            $this->db->update('customer_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         if($table == 'core_maker_info')
         {            
            $this->db->where('core_maker_id', $rec_id);
            $this->db->update('core_maker_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         if($table == 'pattern_maker_info')
         {            
            $this->db->where('pattern_maker_id', $rec_id);
            $this->db->update('pattern_maker_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }  
         if($table == 'customer_despatch_info')
         {            
            $this->db->where('customer_despatch_id', $rec_id);
            $this->db->update('customer_despatch_info', array('status' => 'Delete'));  
            $this->db->where('customer_despatch_id', $rec_id); 
            $this->db->update('customer_despatch_item_info', array('status' => 'Delete'));  
            
            echo 'Record Successfully deleted'; 
         }  
         if($table == 'sub_contractor_despatch_info')
         {            
            $this->db->where('sub_contractor_despatch_id', $rec_id);
            $this->db->update('sub_contractor_despatch_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }  
         if($table == 'core-item')
         {            
            $this->db->where('core_item_id', $rec_id);
            $this->db->update('core_item_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }  
         if($table == 'rejection_type_info')
         {            
            $this->db->where('rejection_type_id', $rec_id);
            $this->db->update('rejection_type_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         if($table == 'sub_contractor_despatch_item_info')
         {            
            $this->db->where('sub_contractor_despatch_item_id', $rec_id);
            $this->db->delete('sub_contractor_despatch_item_info');   
            echo 'Record Successfully deleted'; 
         }
         if($table == 'pattern_in_out_ward_info')
         {            
            $this->db->where('pattern_in_out_id', $rec_id);
            $this->db->update('pattern_in_out_ward_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         if($table == 'pattern_info')
         {            
            $this->db->where('pattern_id', $rec_id);
            $this->db->update('pattern_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         if($table == 'core-maker-rate')
         {            
            $this->db->where('core_maker_rate_id', $rec_id);
            $this->db->update('core_maker_rate_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         if($table == 'employee_info')
         {            
            $this->db->where('employee_id', $rec_id);
            $this->db->update('employee_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'melting_item_chemical_info')
         {            
            $this->db->where('melting_item_chemical_id', $rec_id);
            $this->db->update('melting_item_chemical_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'iso_label_info')
         {            
            $this->db->where('iso_label_id', $rec_id);
            $this->db->update('iso_label_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'pur_item_info')
         {            
            $this->db->where('pur_item_id', $rec_id);
            $this->db->update('pur_item_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'purchase_inward_info')
         {            
            $this->db->where('purchase_inward_id', $rec_id);
            $this->db->update('purchase_inward_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }  
          
         if($table == 'op_pur_itm_stock_info')
         {            
            $this->db->where('op_pur_itm_stock_id', $rec_id);
            $this->db->delete('op_pur_itm_stock_info');   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'adj_pur_itm_stock_info')
         {            
            $this->db->where('adj_pur_itm_stock_id', $rec_id);
            $this->db->delete('adj_pur_itm_stock_info');   
            echo 'Record Successfully deleted'; 
         } 
           
         if($table == 'purchase_inward_testing_info')
         {            
            $this->db->where('purchase_inward_testing_id', $rec_id);
             $this->db->update('purchase_inward_testing_info', array('status' => 'Delete')); 
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'customer_rejection_info')
         {            
            $this->db->where('customer_rejection_id', $rec_id);
            $this->db->update('customer_rejection_info', array('status' => 'Delete'));   
            
            $this->db->where('customer_rejection_id', $rec_id);
            $this->db->update('customer_rejection_itm_info', array('status' => 'Delete'));   
            
            echo 'Record Successfully deleted'; 
         } 
         
         
         if($table == 'ms_despatch_info')
         {            
            $this->db->where('ms_despatch_id', $rec_id);
            $this->db->update('ms_despatch_info', array('status' => 'Delete'));   
            $this->db->where('ms_despatch_id', $rec_id);
            $this->db->update('ms_despatch_itm_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'ms_rework_info')
         {            
            $this->db->where('ms_rework_id', $rec_id);
            $this->db->update('ms_rework_info', array('status' => 'Delete'));   
            
            $this->db->where('ms_rework_id', $rec_id);
            $this->db->update('ms_rework_itm_info', array('status' => 'Delete'));   
            
            echo 'Record Successfully deleted'; 
         } 
         
         
         
          
          
    } 
    
    
    public function get_supplier()  
	{
	    
        $timezone = "Asia/Calcutta";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
        
       $key = $this->input->get('term');
         
        
         $query = $this->db->query(" 
                select 
                UPPER(a.supplier_name) as supplier_name 
                from purchase_inward_info as a
                where a.`status` = 'Active'
                and a.supplier_name like '%". $key ."%'
                group by a.supplier_name
                order by a.supplier_name asc  
            "); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $values[$row['supplier_name']]  = $row['supplier_name'];    
            }
         
            
         $this->db->close();
       
         header('Content-Type: application/x-json; charset=utf-8');

         echo (json_encode($values));     
            
    }
    
    public function logout()
    {
        $this->session->unset_userdata('back_url');
        $this->session->sess_destroy();
        redirect('', 'refresh');
    }
    
}
