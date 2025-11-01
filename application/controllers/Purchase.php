<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {

 
	public function index()
	{
		 
	}
    
     public function purchase_item_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
       
        $data['js'] = 'purchase_item.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'item_name' => $this->input->post('item_name'),
                    'status' => $this->input->post('status')  ,                          
            );
            
            $this->db->insert('pur_item_info', $ins); 
            redirect('purchase-item-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'item_name' => $this->input->post('item_name'),
                    'status' => $this->input->post('status')  ,                  
            );
            
            $this->db->where('pur_item_id', $this->input->post('pur_item_id'));
            $this->db->update('pur_item_info', $upd); 
                            
            redirect('purchase-item-list/' . $this->uri->segment(2, 0)); 
        } 
         
        
        $this->load->library('pagination');
        
        
        $this->db->where('status != ', 'Delete'); 
        $this->db->from('pur_item_info');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('purchase-item-list/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 50;
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
                a.*
                from pur_item_info as a 
                where status != 'Delete'
                order by a.status asc ,a.item_name asc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
       
        
        $query = $this->db->query($sql);
       
        $data['record_list'] = array();
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/purchase/purchase-item-list',$data); 
	} 
    
    public function material_inward_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect(); 
        	    
        $data['js'] = 'material-inward.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                'inward_date' => $this->input->post('inward_date'),
                'po_no' => $this->input->post('po_no'),
                'po_date' => $this->input->post('po_date'),
                'item_id' => $this->input->post('item_id'),
                'supplier_name' => $this->input->post('supplier_name'), 
                'inv_no' => $this->input->post('inv_no'), 
                'expected_date' => $this->input->post('expected_date'), 
                'supplied_date' => $this->input->post('supplied_date'), 
                'ordered_qty' => $this->input->post('ordered_qty'), 
                'supplied_qty' => $this->input->post('supplied_qty'), 
                'accepted_qty' => $this->input->post('accepted_qty'), 
                'rejected_qty' => $this->input->post('rejected_qty'), 
                'rework_qty' => $this->input->post('rework_qty'), 
                'rework_qty' => $this->input->post('rework_qty'), 
                'rate_per_kg' => $this->input->post('rate_per_kg'), 
                'remarks' => $this->input->post('remarks'),    
                'status' => $this->input->post('status'),    
                'created_by' => $this->session->userdata('cr_user_id'),                          
                'created_datetime' => date('Y-m-d H:i:s')                         
            );
            
            $this->db->insert('purchase_inward_info', $ins); 
            redirect('material-inward');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                'inward_date' => $this->input->post('inward_date'),
                'po_no' => $this->input->post('po_no'),
                'po_date' => $this->input->post('po_date'),
                'item_id' => $this->input->post('item_id'),
                'supplier_name' => $this->input->post('supplier_name'), 
                'inv_no' => $this->input->post('inv_no'), 
                'expected_date' => $this->input->post('expected_date'), 
                'supplied_date' => $this->input->post('supplied_date'), 
                'ordered_qty' => $this->input->post('ordered_qty'), 
                'supplied_qty' => $this->input->post('supplied_qty'), 
                'accepted_qty' => $this->input->post('accepted_qty'), 
                'rejected_qty' => $this->input->post('rejected_qty'), 
                'rework_qty' => $this->input->post('rework_qty'), 
                'rework_qty' => $this->input->post('rework_qty'), 
                'rate_per_kg' => $this->input->post('rate_per_kg'), 
                'remarks' => $this->input->post('remarks'),  
                'status' => $this->input->post('status'), 
                'updated_by' => $this->session->userdata('cr_user_id'),                          
                'updated_datetime' => date('Y-m-d H:i:s')                  
            );
            
           // print_r($upd);
            
            $this->db->where('purchase_inward_id', $this->input->post('purchase_inward_id'));
            $this->db->update('purchase_inward_info', $upd); 
                            
            redirect('material-inward/' . $this->uri->segment(2, 0));  
        } 
        
        
         $data['user_level_opt'] = array(
                                        '1' => 'Admin',
                                        '2' => 'Moulding',
                                        '3' => 'Melting',
                                        '4' => 'Despatch',
                                        ); 

       /* 
        
       if(isset($_POST['srch_state'])) {
           $data['srch_state'] = $srch_state = $this->input->post('srch_state');
           $data['srch_area'] = $srch_area = $this->input->post('srch_area');
           $this->session->set_userdata('srch_state', $this->input->post('srch_state'));
           $this->session->set_userdata('srch_area', $this->input->post('srch_area'));
       }
       elseif($this->session->userdata('srch_state')){
           $data['srch_state'] = $srch_state = $this->session->userdata('srch_state') ;
           $data['srch_area'] = $srch_area = $this->session->userdata('srch_area') ;
       }
       
       if(!empty($srch_state)){
        $where = " a.state_name = '" . $srch_state . "'";
        $where .= " and (a.area_name like '%" . $srch_area . "%' or a.pincode like '%". $srch_area ."%' or a.district_name like '%". $srch_area ."%') ";
         
       } else {
        $where = " a.state_name = 'Tamil Nadu' ";
        $this->session->set_userdata('srch_state', 'Tamil Nadu');
        $data['srch_state'] = $srch_state =  'Tamil Nadu';
        $data['srch_area'] = $srch_area =  '';
       }
         */
        
        $this->load->library('pagination');
        
        $this->db->where('status != ', 'Delete'); 
        $this->db->from('purchase_inward_info as a');
        $data['total_records'] = $cnt  = $this->db->count_all_results();
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('material-inward/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 50;
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
                a.*,
                b.item_name,
                b.itm_static
                from purchase_inward_info as a 
                left join pur_item_info as b on b.pur_item_id = a.item_id
                where a.status != 'Delete'  
                order by  a.inward_date desc, a.purchase_inward_id  desc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        $data['record_list'] = array();
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        $sql = "
                select 
                a.pur_item_id,                
                a.item_name             
                from pur_item_info as a  
                where status = 'Active' 
                order by a.item_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['itm_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['itm_opt'][$row['pur_item_id']] = $row['item_name'];     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/purchase/material-inward',$data); 
	} 
    
    
    public function inward_register()
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
       if(isset($_POST['srch_item_id'])) {
       $data['srch_item_id'] = $srch_item_id = $this->input->post('srch_item_id');
       } else {
        $data['srch_item_id'] = $srch_item_id = '';
       }
       
       
       $where = " 1=1 ";
      // $where1 = " 1=1 ";
       
       if(!empty($srch_from_date) && !empty($srch_to_date) ){
        $where .= " and a.inward_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";  
        //$where1 .= " and a.inward_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";  
        $data['submit_flg'] = true; 
       } 
       
       if(!empty($srch_item_id)){
        $where .= " and a.item_id = '" . $srch_item_id . "'";  
        //$where1 .= " and a.item_id = '" . $srch_item_id . "'";  
        $data['submit_flg'] = true; 
       } 
       
         
        
        if($data['submit_flg']) { 
            
        /*    
        
        $sql = "
            select * from 
            (
               (
                    select  
                    a.inward_date,
                    a.po_no,
                    a.po_date,
                    a.item_id,
                    a.supplier_name,
                    a.inv_no,
                    a.expected_date,
                    a.supplied_date,
                    a.ordered_qty,
                    a.supplied_qty,
                    a.accepted_qty,
                    a.rejected_qty,
                    a.rework_qty,
                    a.rate_per_kg,
                    a.remarks, 
                    b.item_name as item,
                    DATEDIFF(a.inward_date , a.supplied_date) as diff
                    from purchase_inward_info as a
                    left join pur_item_info as b on b.pur_item_id = a.item_id
                    where a.`status` = 'Active' and b.status = 'Active' and
                    $where      
                    order by a.inward_date asc , b.item_name asc   
                ) union all (
                
                   select
                    z.rej_date as inward_date,
                    '' as po_no,
                    '' as po_date,
                    3 as item_id,
                    z.customer as supplier_name,
                    '' as inv_no,
                    z.rej_date as expected_date,
                    z.rej_date as supplied_date,
                    sum(z.rej_inward_qty) as ordered_qty,
                    sum(z.rej_inward_qty) as supplied_qty,
                    sum(z.rej_inward_qty) as accepted_qty,
                    0 as rejected_qty,
                    0 as rework_qty,
                    0 as rate_per_kg,
                    '' as remarks, 
                    'C.I Scrap' as item,
                    DATEDIFF(z.rej_date , z.rej_date) as diff 
                    from
                    (
                      (
                           select 
                           a.rej_date,
                           b.pattern_id,
                           w.company_name as customer ,
                           round((sum(b.qty) * c.piece_weight_per_kg),2) as rej_inward_qty
                           from customer_rejection_info as a
                           left join customer_rejection_itm_info as b on b.customer_rejection_id = a.customer_rejection_id
                           left join pattern_info as c on c.pattern_id = b.pattern_id
                           left join customer_info as w on w.customer_id = c.customer_id
                           where a.`status` = 'Active' and b.`status` = 'Active'
                           and a.rej_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'
                           group by a.rej_date , b.pattern_id
                           order by a.rej_date , b.pattern_id
                      ) union all (
                           select  
                           a.qc_date as rej_date,
                           b.pattern_id,
                           w.company_name as customer ,
                           round((sum(a.rejection_qty) * c.piece_weight_per_kg),2) as  rej_inward_qty 
                           from qc_inspection_info as a
                           left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                           left join pattern_info as c on c.pattern_id =b.pattern_id
                           left join customer_info as w on w.customer_id = c.customer_id
                           where a.`status`='Active' and b.`status` = 'Planned'
                           and a.qc_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'
                           group by a.qc_date , b.pattern_id
                           order by a.qc_date , b.pattern_id
                      )
                    ) as z
                     
                    group by z.rej_date
                    order by z.rej_date asc  
                )                        
             ) as y 
             order by y.inward_date asc             
        ";
        
        */
        
        $data['record_list'] = array();
        
        $sql = "    select  
                    a.inward_date,
                    a.po_no,
                    a.po_date,
                    a.item_id,
                    a.supplier_name,
                    a.inv_no,
                    a.expected_date,
                    a.supplied_date,
                    a.ordered_qty,
                    a.supplied_qty,
                    a.accepted_qty,
                    a.rejected_qty,
                    a.rework_qty,
                    a.rate_per_kg,
                    a.remarks, 
                    b.item_name as item,
                    DATEDIFF(a.inward_date , a.supplied_date) as diff
                    from purchase_inward_info as a
                    left join pur_item_info as b on b.pur_item_id = a.item_id
                    where a.`status` = 'Active' and b.status = 'Active' and
                    $where      
                    order by a.inward_date asc , b.item_name asc             
                ";
        
        
        $query = $this->db->query($sql); 
        
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['inward_date']][] = $row;     
        }
        
        
        $sql = "
            select
            z.rej_date as inward_date,
            '' as po_no,
            '' as po_date,
            3 as item_id,
            z.customer as supplier_name,
            '' as inv_no,
            z.rej_date as expected_date,
            z.rej_date as supplied_date,
            sum(z.rej_inward_qty) as ordered_qty,
            sum(z.rej_inward_qty) as supplied_qty,
            sum(z.rej_inward_qty) as accepted_qty,
            0 as rejected_qty,
            0 as rework_qty,
            0 as rate_per_kg,
            '' as remarks, 
            'C.I Scrap' as item,
            DATEDIFF(z.rej_date , z.rej_date) as diff 
            from
            (
              (
                   select 
                   a.rej_date,
                   b.pattern_id,
                   w.company_name as customer ,
                   round((sum(b.qty) * c.piece_weight_per_kg),2) as rej_inward_qty
                   from customer_rejection_info as a
                   left join customer_rejection_itm_info as b on b.customer_rejection_id = a.customer_rejection_id
                   left join pattern_info as c on c.pattern_id = b.pattern_id
                   left join customer_info as w on w.customer_id = c.customer_id
                   where a.`status` = 'Active' and b.`status` = 'Active'
                   and a.rej_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'
                   group by a.rej_date ,c.customer_id, b.pattern_id
                   order by a.rej_date , c.customer_id ,b.pattern_id
              ) 
            ) as z
             
            group by z.rej_date , z.customer
            order by z.rej_date , z.customer asc  
        ";
        
        /*
        union all (
                   select  
                   a.qc_date as rej_date,
                   b.pattern_id,
                   w.company_name as customer ,
                   round((sum(a.rejection_qty) * c.piece_weight_per_kg),2) as  rej_inward_qty 
                   from qc_inspection_info as a
                   left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                   left join pattern_info as c on c.pattern_id =b.pattern_id
                   left join customer_info as w on w.customer_id = c.customer_id
                   where a.`status`='Active' and b.`status` = 'Planned'
                   and a.qc_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'
                   group by a.qc_date ,  c.customer_id , b.pattern_id
                   order by a.qc_date ,  c.customer_id , b.pattern_id
              )
        */
        
        
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['inward_date']][] = $row;     
        }
        
        ksort($data['record_list']);
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'IRPD'
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
        
        $sql = "
                select 
                a.pur_item_id,                
                a.item_name             
                from pur_item_info as a  
                where status = 'Active' 
                order by a.item_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['itm_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['itm_opt'][$row['pur_item_id']] = $row['item_name'];     
        } 
        
        $this->load->view('page/purchase/inward_register',$data); 
	}  
    
    
    public function inward_testing_register()
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
       if(isset($_POST['srch_item_id'])) {
       $data['srch_item_id'] = $srch_item_id = $this->input->post('srch_item_id');
       } else {
        $data['srch_item_id'] = $srch_item_id = '';
       }
       
       
       $where = " and 1=1 ";
       
       if(!empty($srch_from_date) && !empty($srch_to_date) ){
        $where .= " and a.inward_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";  
        $data['submit_flg'] = true; 
       } 
       
       if(!empty($srch_item_id)){
        $where .= " and a.item_id = '" . $srch_item_id . "'";  
        $data['submit_flg'] = true; 
       } 
       
         
        
        if($data['submit_flg']) { 
        
        
        $sql = "
            select 
                a.*,
                a.purchase_inward_id as pid,
                b.item_name as item,
                c.*
                from purchase_inward_info as a 
                left join pur_item_info as b on b.pur_item_id = a.item_id
                left join purchase_inward_testing_info as c on c.purchase_inward_id = a.purchase_inward_id and c.status != 'Delete'  
                where a.status != 'Delete'  
                $where  
                order by  a.inward_date asc, a.purchase_inward_id  asc  
        
        ";
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'IMTR'
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
        
        $sql = "
                select 
                a.pur_item_id,                
                a.item_name             
                from pur_item_info as a  
                where status = 'Active' 
                order by a.item_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['itm_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['itm_opt'][$row['pur_item_id']] = $row['item_name'];     
        } 
        
        $this->load->view('page/purchase/inward_testing_register',$data); 
	}  
    
    public function material_issue()
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
       
       
       
       if(!empty($srch_from_date) && !empty($srch_to_date) ){
        $where = " and a.moulding_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";  
        $where_mlt = " and a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";  
        $data['submit_flg'] = true; 
       } 
       
         
        
        if($data['submit_flg']) { 
        
         
        
        $sql = "
                select 
                a.moulding_date as issue_date, 
                sum(a.bentonite) as bentonite,
                sum(a.bentokol) as bentokol  
                from moulding_material_log as a
                where a.`status` = 'Active' 
                $where
                group by a.moulding_date  
                order by a.moulding_date asc
        
        ";
        
        
        $query = $this->db->query($sql);
        
        $data['molding_item_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            foreach($row as $fld => $val){
             if($fld != 'issue_date')
                $data['molding_item_list'][$row['issue_date']][] = array( 'item' => $fld , 'qty' => $val);    
            }   
        }
        
        
       $sql_melt = "
            select 
            a.melting_date,
            sum(if(a.boring = '',0, a.boring)) as boring,
            sum(if(a.ms = '',0, a.ms)) as ms, 
           
            sum(if(a.CI_scrap = '',0, a.CI_scrap)) as CI_scrap,  
            sum(if(a.pig_iron = '',0, a.pig_iron)) as pig_iron,  
            sum(if(a.spillage = '',0, a.spillage)) as spillage,  
            sum(if(a.C = '',0, a.C)) as C,   
            round(sum(if(a.SI = '',0, a.SI)),2) as SI,   
            round(sum(if(a.Mn = '',0, a.Mn)),2) as Mn,  
            sum(if(a.S = '',0, a.S)) as S, 
            sum(if(a.Cu = '',0, a.Cu)) as Cu,  
            sum(if(a.Cr = '',0, a.Cr)) as Cr, 
            sum(if(a.graphite_coke = '',0, a.graphite_coke)) as graphite_coke, 
            sum(if(a.fe_si_mg = '',0, a.fe_si_mg)) as fe_si_mg,  
            sum(if(a.fe_sulphur = '',0, a.fe_sulphur)) as fe_sulphur,  
            sum(if(a.inoculant = '',0, a.inoculant)) as inoculant,  
            sum(if(a.pyrometer_tip = '',0, a.pyrometer_tip)) as pyrometer_tip
            from melting_heat_log_info as a
            where a.`status` = 'Active'
            $where_mlt
            group by a.melting_date
            order by a.melting_date asc
        ";
        
        // sum(if(a.foundry_return = '',0, a.foundry_return)) as foundry_return, 
        
        $query = $this->db->query($sql_melt);
        
       $data['melting_item_list'] = array();
       
        foreach ($query->result_array() as $row)
        {   
            foreach($row as $fld => $val){
             if($fld != 'melting_date' && $val != 0)
                $data['melting_item_list'][$row['melting_date']][] = array( 'item' => $fld , 'qty' => $val);    
            } 
        }
        
         
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'MIS'
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
        
        $sql ="select 
                a.item_name,
                a.itm_static
                from pur_item_info as a
                where a.`status` = 'Active' 
                order by a.item_name asc 
                ";
                
         $query = $this->db->query($sql); 
         
         $data['item_label'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['item_label'][$row['itm_static']] = $row['item_name'];     
        }  
        
        
        
        }
        
        $this->load->view('page/purchase/material_issue',$data); 
	} 
    
    public function material_request()
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
       
       
       
       if(!empty($srch_from_date) && !empty($srch_to_date) ){
        $where = " and a.moulding_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";  
        $where_mlt = " and a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";  
        $data['submit_flg'] = true; 
       } 
       
         
        
        if($data['submit_flg']) { 
        
         
        
        $sql = "
                select 
                a.moulding_date as issue_date, 
                sum(a.bentonite) as bentonite,
                sum(a.bentokol) as bentokol  
                from moulding_material_log as a
                where a.`status` = 'Active' 
                $where
                group by a.moulding_date  
                order by a.moulding_date asc
        
        ";
        
        
        $query = $this->db->query($sql);
        
        $data['molding_item_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            foreach($row as $fld => $val){
             if($fld != 'issue_date')
                $data['molding_item_list'][$row['issue_date']][] = array( 'item' => $fld , 'qty' => $val);    
            }   
        }
        
        
       $sql_melt = "
            select 
            a.melting_date,
            sum(if(a.boring = '',0, a.boring)) as boring,
            sum(if(a.ms = '',0, a.ms)) as ms, 
           
            sum(if(a.CI_scrap = '',0, a.CI_scrap)) as CI_scrap,  
            sum(if(a.pig_iron = '',0, a.pig_iron)) as pig_iron,  
            sum(if(a.spillage = '',0, a.spillage)) as spillage,  
            sum(if(a.C = '',0, a.C)) as C,   
            round(sum(if(a.SI = '',0, a.SI)),2) as SI,   
            round(sum(if(a.Mn = '',0, a.Mn)),2) as Mn,  
            sum(if(a.S = '',0, a.S)) as S, 
            sum(if(a.Cu = '',0, a.Cu)) as Cu,  
            sum(if(a.Cr = '',0, a.Cr)) as Cr, 
            sum(if(a.graphite_coke = '',0, a.graphite_coke)) as graphite_coke, 
            sum(if(a.fe_si_mg = '',0, a.fe_si_mg)) as fe_si_mg,  
            sum(if(a.fe_sulphur = '',0, a.fe_sulphur)) as fe_sulphur,  
            sum(if(a.inoculant = '',0, a.inoculant)) as inoculant,  
            sum(if(a.pyrometer_tip = '',0, a.pyrometer_tip)) as pyrometer_tip
            from melting_heat_log_info as a
            where a.`status` = 'Active'
            $where_mlt
            group by a.melting_date
            order by a.melting_date asc
        ";
        
        // sum(if(a.foundry_return = '',0, a.foundry_return)) as foundry_return, 
        
        $query = $this->db->query($sql_melt);
        
       $data['melting_item_list'] = array();
       
        foreach ($query->result_array() as $row)
        {   
            foreach($row as $fld => $val){
             if($fld != 'melting_date' && $val != 0)
                $data['melting_item_list'][$row['melting_date']][] = array( 'item' => $fld , 'qty' => $val);    
            } 
        }
        
         
        
        $sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'MIS'
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
        
        $sql ="select 
                a.item_name,
                a.itm_static
                from pur_item_info as a
                where a.`status` = 'Active' 
                order by a.item_name asc 
                ";
                
         $query = $this->db->query($sql); 
         
         $data['item_label'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['item_label'][$row['itm_static']] = $row['item_name'];     
        }  
        
        
        
        }
        
        $this->load->view('page/purchase/material_request',$data); 
	} 
    
    
    public function opening_stock_item_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect(); 
        	    
        $data['js'] = 'pur-stock.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'stock_date' => $this->input->post('stock_date'),
                    'item_id' => $this->input->post('item_id'),  
                    'stock_qty' => $this->input->post('stock_qty'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('op_pur_itm_stock_info', $ins); 
            redirect('opening-stock-item-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'stock_date' => $this->input->post('stock_date'),
                    'item_id' => $this->input->post('item_id'),  
                    'stock_qty' => $this->input->post('stock_qty'), 
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('op_pur_itm_stock_id', $this->input->post('op_pur_itm_stock_id'));
            $this->db->update('op_pur_itm_stock_info', $upd); 
                            
            redirect('opening-stock-item-list/' . $this->uri->segment(2, 0)); 
        }  
         
         
        
       $this->load->library('pagination');
        
       if(isset($_POST['srch_customer'])) {
           $data['srch_item'] = $srch_item = $this->input->post('srch_item'); 
           $this->session->set_userdata('srch_item', $this->input->post('srch_item'));
            
       }
       elseif($this->session->userdata('srch_item')){
           $data['srch_item'] = $srch_item = $this->session->userdata('srch_item') ; 
       }else {
           $data['srch_item'] = $srch_item = '';
       }
       
       
       
       
       $where = '1=1';

       if(!empty($srch_item)){
         $where .= " and a.item_id = '". $srch_item ."'";
       } 
         
        $this->db->where($where); 
        $this->db->from('op_pur_itm_stock_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('opening-stock-item/'), '/'. $this->uri->segment(2, 0));
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
                a.*,
                b.*
                from op_pur_itm_stock_info as a
                left join pur_item_info as b on b.pur_item_id = a.item_id 
                where ". $where ."
                order by  a.stock_date desc , b.item_name asc
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
                a.pur_item_id,                
                a.item_name             
                from pur_item_info as a  
                where status = 'Active' 
                order by a.item_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['item_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['item_opt'][$row['pur_item_id']] = $row['item_name'];     
        }
         
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/purchase/opening_stock_item_list',$data); 
	}  
    
    
    public function adj_stock_item_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect(); 
        	    
        $data['js'] = 'adj-pur-stock.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'adj_date' => $this->input->post('adj_date'),
                    'item_id' => $this->input->post('item_id'),  
                    'adj_qty' => $this->input->post('adj_qty'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('adj_pur_itm_stock_info', $ins); 
            redirect('adj-stock-item-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'adj_date' => $this->input->post('adj_date'),
                    'item_id' => $this->input->post('item_id'),  
                    'adj_qty' => $this->input->post('adj_qty'), 
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('adj_pur_itm_stock_id', $this->input->post('adj_pur_itm_stock_id'));
            $this->db->update('adj_pur_itm_stock_info', $upd); 
                            
            redirect('adj-stock-item-list/' . $this->uri->segment(2, 0)); 
        }  
         
         
        
       $this->load->library('pagination');
        
       if(isset($_POST['srch_customer'])) {
           $data['srch_item'] = $srch_item = $this->input->post('srch_item'); 
           $this->session->set_userdata('srch_item', $this->input->post('srch_item'));
            
       }
       elseif($this->session->userdata('srch_item')){
           $data['srch_item'] = $srch_item = $this->session->userdata('srch_item') ; 
       }else {
           $data['srch_item'] = $srch_item = '';
       }
       
       
       
       
       $where = '1=1';

       if(!empty($srch_item)){
         $where .= " and a.item_id = '". $srch_item ."'";
       } 
         
        $this->db->where($where); 
        $this->db->from('adj_pur_itm_stock_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('adj-stock-item/'), '/'. $this->uri->segment(2, 0));
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
                a.*,
                b.*
                from adj_pur_itm_stock_info as a
                left join pur_item_info as b on b.pur_item_id = a.item_id 
                where ". $where ."
                order by  a.adj_date desc , b.item_name asc
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
                a.pur_item_id,                
                a.item_name             
                from pur_item_info as a  
                where status = 'Active' 
                order by a.item_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['item_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['item_opt'][$row['pur_item_id']] = $row['item_name'];     
        }
         
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/purchase/adj_stock_item_list',$data); 
	}  
    
    
    
     public function stock_report()
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
           $data['srch_item_id'] = $srch_item_id = $this->input->post('srch_item_id'); 
           $data['submit_flg'] = true; 
       } else {
            $data['srch_from_date'] = $srch_from_date = '';
            $data['srch_to_date'] = $srch_to_date = '';
            $data['srch_item_id'] = $srch_item_id= ''; 
       }
       
       
       
        $sql = "
                select 
                a.pur_item_id,                
                a.item_name,
                a.itm_static             
                from pur_item_info as a  
                where status = 'Active' 
                order by a.item_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['item_opt'] = array();
        $data['item_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['item_opt'][$row['pur_item_id']] = $row['item_name'];     
            $data['item_list'][$row['pur_item_id']] = $row['itm_static'];     
        } 
       
       
        
        
        
        if($data['submit_flg']) {
            
            $data['item_opt1'][$srch_item_id] = $data['item_opt'][$srch_item_id];
            
             $sql = "
               select 
                a.pur_item_id as item_id,
                a.item_name,
                a.itm_static,
                ifnull(b.stock_date,'" . $srch_from_date . "') as frm_date,
                ifnull(b.stock_qty,0) as op_stock,
                ifnull(sum(c.accepted_qty),0) as inward_qty,
                (ifnull(b.stock_qty,0)  + ifnull(sum(c.accepted_qty),0) + ifnull(sum(d.rej_qty),0) + ifnull(sum(e.fr_wt),0) ) as op_inward_qty
                from pur_item_info as a
                left join (
                				select 
                				a1.stock_date,
                				a1.item_id, 
                				sum(a1.stock_qty) as  stock_qty
                				from op_pur_itm_stock_info as a1 
                				left join ( 
                					SELECT max(`stock_date`) as stock_date,  item_id  
                					FROM op_pur_itm_stock_info 
                					WHERE stock_date <= '" . $srch_from_date . "' group by `item_id` ) as b1 on b1.stock_date = a1.stock_date and b1.item_id = a1.item_id  
                				where 1 
                				group by a1.item_id  
                				order by a1.item_id 
                			 ) as b on b.item_id = a.pur_item_id   
                left join purchase_inward_info as c on c.item_id = a.pur_item_id and c.inward_date between ifnull(b.stock_date,'" . $srch_from_date . "') and  DATE_SUB('" . $srch_from_date . "',INTERVAL 1 day)
                left join (
                            select 
                            '3' as item_id, 
                            z.rej_date,
                            sum(z.rej_qty) as rej_qty
                            from
                                (
                                    (
                                        select 
                                        v.rej_date, 
                                        y.pattern_id ,
                                        round((sum(y.qty) * n.piece_weight_per_kg),2) as rej_qty 
                                        from customer_rejection_info as v
                                        left join customer_rejection_itm_info as y on y.customer_rejection_id = v.customer_rejection_id
                                        left join pattern_info as n on n.pattern_id = y.pattern_id
                                        where v.`status` = 'Active' and y.`status` = 'Active'
                                        and v.rej_date <= '" . $srch_from_date . "'
                                        group by v.rej_date , y.pattern_id
                                        order by v.rej_date, y.pattern_id asc
                                    ) union all (
                                         select 
                                         a.qc_date as rej_date,
                                         b.pattern_id,
                                         round((sum(a.rejection_qty) * c.piece_weight_per_kg),2) as  rej_qty 
                                         from qc_inspection_info as a
                                         left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                                         left join pattern_info as c on c.pattern_id =b.pattern_id
                                         where a.`status`='Active' and b.`status` = 'Planned'
                                         group by a.qc_date, b.pattern_id
                                         order by a.qc_date, b.pattern_id
                                    )
                                ) as z 
                            ) as d on d.item_id = a.pur_item_id and d.rej_date between ifnull(b.stock_date,'" . $srch_from_date . "') and DATE_SUB('" . $srch_from_date . "',INTERVAL 1 day)
                 left join (
                        select 
                        v.melting_date,
                        '18' as item_id, 
                        (sum(v.liq_metal )  - sum(v.p_cast_wt )) as fr_wt
                        from (
                            select 
                            a.melting_date, 
                            (round((c.planned_box_wt / c.planned_box),3)) as box_wt,
                            (b.pouring_box * round((c.planned_box_wt /c.planned_box),3)) as liq_metal ,
                            round((d.casting_weight * b.pouring_box),3) as p_cast_wt 
                            from melting_heat_log_info as a
                            left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
                            left join work_planning_info as c on c.work_planning_id = b.work_planning_id
                            left join pattern_info as d on d.pattern_id = c.pattern_id
                            where a.melting_date <= '" . $srch_from_date . "'
                            order by a.melting_date asc,a.days_heat_no asc 
                        ) as v 
                        group by v.melting_date
                        order by v.melting_date asc
                 ) as e on e.item_id = a.pur_item_id and e.melting_date between ifnull(b.stock_date,'" . $srch_from_date . "') and DATE_SUB('" . $srch_from_date . "',INTERVAL 1 day)
                 where a.`status` = 'Active'  ";
       if(!empty($srch_item_id)) 
            $sql .= " and a.pur_item_id = " . $srch_item_id ;
       $sql .="         
                group by a.pur_item_id 
                order by a.item_name asc	
        ";
        
       /* echo "<pre>";
        print_r($sql);
        echo "</pre>"; */
        
        
        $query = $this->db->query($sql);
        
        $data['op_stock_qty'] = array();
        $data['op_stock_frmdate'] = array();
        
        $data['op_issued_qty'] = array(); 
        $data['op_adj_qty'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['op_stock_qty'][$row['item_id']] = $row['op_inward_qty'];     
             $data['op_stock_frmdate'][$row['item_id']] = $row['frm_date'];  
            
            
            $sql = "
                select 
                a.item_id, 
                sum(a.adj_qty) as   adj_qty               
                from adj_pur_itm_stock_info as a 
                where a.adj_date between '" . $data['op_stock_frmdate'][$row['item_id']]  . "' and  DATE_SUB('" . $srch_from_date . "',INTERVAL 1 day) 
                group by  a.item_id
                order by  a.item_id
        
            ";
        
            
            $query = $this->db->query($sql); 
            
            
           
            foreach ($query->result_array() as $row1)
            {
                 $data['op_adj_qty'][$row1['item_id']]= $row1['adj_qty']; 
            } 
            
            if($row['item_id'] != '4' && $row['item_id'] != '5') 
            {
                
                $sql_melt = "
                    select
                    '". $row['item_id']."' as item_id,
                    '". $row['itm_static']."' as item, 
                    sum(if(a.". $row['itm_static']." = '',0, a.". $row['itm_static'].")) as qty
                    from melting_heat_log_info as a
                    where a.`status` = 'Active'
                    and a.melting_date between '" . $data['op_stock_frmdate'][$row['item_id']]  . "' and  DATE_SUB('" . $srch_from_date . "',INTERVAL 1 day)
                     
                ";
                
               // echo $sql_melt . "<br>";
               
                /*echo "<pre>";
                print_r($sql_melt);
                echo "</pre>";*/
               
               $query = $this->db->query($sql_melt); 
               
                foreach ($query->result_array() as $row)
                {  
                    $data['op_issued_qty'][$row['item_id']] = $row['qty'];   
                }  
            
            } else {
                
            
              $sql_mold = "
                    select
                    '". $row['item_id']."' as item_id,
                    '". $row['itm_static']."' as item, 
                    sum(if(a.". $row['itm_static']." = '',0, a.". $row['itm_static'].")) as qty
                    from moulding_material_log as a
                    where a.`status` = 'Active'
                    and a.moulding_date between '" . $data['op_stock_frmdate'][$row['item_id']]  . "' and  DATE_SUB('" .$srch_from_date. "',INTERVAL 1 day)
                    
                ";
                
               //$sql_mold . "<br>";
                
                 $query = $this->db->query($sql_mold); 
               
                foreach ($query->result_array() as $row)
                {  
                    $data['op_issued_qty'][$row['item_id']]  = $row['qty'];   
                }  
            }
            
            if($row['item_id'] == '18')
            {
                 $sql = "
                    select
                    '18' as item_id,
                    'foundry_return' as item, 
                    sum(if(a.foundry_return = '',0, a.foundry_return) + if(a.spillage = '',0, a.spillage)) as qty
                    from melting_heat_log_info as a
                    where a.`status` = 'Active'
                    and a.melting_date between '" .  $data['op_stock_frmdate'][$row['item_id']]  . "' and  DATE_SUB('" .$srch_from_date. "',INTERVAL 1 day)
                ";
                
                $query = $this->db->query($sql); 
               
                foreach ($query->result_array() as $row)
                {  
                    $data['op_issued_qty'][$row['item_id']]  = $row['qty'];   
                }  
            }
             
        }  
        
        
        //print_r($data['op_issued_qty']);
           
      /*   $sql = "
            select
            z.item_id,
            sum(z.inward_qty) as inward_qty
            from
            (
                (
                select  
                a.item_id,
                sum(a.accepted_qty) as inward_qty 
                from purchase_inward_info as a 
                where a.`status` = 'Active' 
                and a.inward_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'      
                group by a.item_id 
                ) union all (
                select 
                '3' as item_id,
                sum(b.qty) as inward_qty
                from customer_rejection_info as a
                left join customer_rejection_itm_info as b on b.customer_rejection_id = a.customer_rejection_id
                where a.`status` = 'Active' and b.`status` = 'Active'
                and a.rej_date between '" . $srch_from_date . "' and  '". $srch_to_date ."' 
                ) 
            ) as z
            group by z.item_id
            order by z.item_id
        "; */
         
        
       $sql = " 
            select  
            a.item_id,
            a.inward_date,
            sum(a.accepted_qty) as inward_qty 
            from purchase_inward_info as a 
            where a.`status` = 'Active' 
            and a.inward_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
            
      if(!empty($srch_item_id)) 
            $sql .= " and a.item_id = " . $srch_item_id ; 
            
      $sql .="            
            group by a.inward_date,  a.item_id 
            order by a.inward_date , a.item_id  
        ";
        
        
        $query = $this->db->query($sql);
        
        $data['inward_qty'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['inward_qty'][$row['item_id']][$row['inward_date']] = $row['inward_qty'];     
        }
        
        
        if(!empty($srch_item_id) && $srch_item_id == '3'){ 
            
            $sql = "
                    select
                    '3' as item_id,
                    z.rej_date,
                    sum(z.rej_inward_qty) as rej_inward_qty
                    from
                    (
                        (
                             select 
                             a.rej_date,
                             b.pattern_id,
                             round((sum(b.qty) * c.piece_weight_per_kg),2) as rej_inward_qty
                             from customer_rejection_info as a
                             left join customer_rejection_itm_info as b on b.customer_rejection_id = a.customer_rejection_id
                             left join pattern_info as c on c.pattern_id = b.pattern_id
                             where a.`status` = 'Active' and b.`status` = 'Active'
                             and a.rej_date between '" . $srch_from_date . "' and  '". $srch_to_date ."' 
                             group by a.rej_date , b.pattern_id
                             order by a.rej_date , b.pattern_id
                        ) union all (
                             select  
                             a.qc_date as rej_date,
                             b.pattern_id,
                             round((sum(a.rejection_qty) * c.piece_weight_per_kg),2) as  rej_inward_qty 
                             from qc_inspection_info as a
                             left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                             left join pattern_info as c on c.pattern_id =b.pattern_id
                             where a.`status`='Active' and b.`status` = 'Planned'
                             and a.qc_date between '" . $srch_from_date . "' and  '". $srch_to_date ."' 
                             group by a.qc_date , b.pattern_id
                             order by a.qc_date , b.pattern_id
                        )
                    ) as z
                    group by z.rej_date
                    order by z.rej_date asc
                    
            ";
            
            
            $query = $this->db->query($sql);
            
            $data['rej_inward_qty'] = array();
           
            foreach ($query->result_array() as $row)
            {
                $data['rej_inward_qty'][$row['item_id']][$row['rej_date']] = $row['rej_inward_qty'];     
            }
        } else {
            $data['rej_inward_qty'] = array();
        }
        
        
        // foundry_return
       
        if(!empty($srch_item_id) && $srch_item_id == '18'){  
        
            $sql = "
                select 
                v.melting_date,
                '18' as item_id,
                sum(v.liq_metal ) as liq_metal,
                sum(v.p_cast_wt) as p_cast_wt,
                (sum(v.liq_metal )  - sum(v.p_cast_wt )) as fr_wt
                from (
                    select 
                    a.melting_date, 
                    (round((c.planned_box_wt / c.planned_box),3)) as box_wt,
                    (b.pouring_box * round((c.planned_box_wt /c.planned_box),3)) as liq_metal ,
                    round((d.casting_weight * b.pouring_box),3) as p_cast_wt 
                    from melting_heat_log_info as a
                    left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
                    left join work_planning_info as c on c.work_planning_id = b.work_planning_id
                    left join pattern_info as d on d.pattern_id = c.pattern_id
                    where a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."' 
                    order by a.melting_date asc,a.days_heat_no asc 
                ) as v 
                group by v.melting_date
                order by v.melting_date asc
            ";
            
            $query = $this->db->query($sql);
            
            //$data['rej_inward_qty'] = array();
           
            foreach ($query->result_array() as $row)
            {
                $data['rej_inward_qty'][$row['item_id']][$row['melting_date']] = $row['fr_wt'];     
            }
        }
        
        
        
        
        
        $sql_melt = "
            select 
            a.melting_date,
            sum(if(a.boring = '',0, a.boring)) as boring,
            sum(if(a.ms = '',0, a.ms)) as ms, 
            sum(if(a.CI_scrap = '',0, a.CI_scrap)) as CI_scrap,  
            sum(if(a.pig_iron = '',0, a.pig_iron)) as pig_iron,  
            sum(if(a.spillage = '',0, a.spillage)) as spillage,  
            sum(if(a.C = '',0, a.C)) as C,   
            round(sum(if(a.SI = '',0, a.SI)),2) as SI,   
            round(sum(if(a.Mn = '',0, a.Mn)),2) as Mn,  
            sum(if(a.S = '',0, a.S)) as S, 
            sum(if(a.Cu = '',0, a.Cu)) as Cu,  
            sum(if(a.Cr = '',0, a.Cr)) as Cr, 
            sum(if(a.ni = '',0, a.ni)) as ni, 
            sum(if(a.mo = '',0, a.mo)) as mo, 
            sum(if(a.graphite_coke = '',0, a.graphite_coke)) as graphite_coke, 
            sum(if(a.fe_si_mg = '',0, a.fe_si_mg)) as fe_si_mg,  
            sum(if(a.fe_sulphur = '',0, a.fe_sulphur)) as fe_sulphur,  
            sum(if(a.inoculant = '',0, a.inoculant)) as inoculant,  
            sum(if(a.pyrometer_tip = '',0, a.pyrometer_tip)) as pyrometer_tip,
            sum(if(a.foundry_return = '',0, a.foundry_return)) as foundry_return1,
            ( sum(if(a.spillage = '',0, a.spillage)) + sum(if(a.foundry_return = '',0, a.foundry_return)) ) as foundry_return 
            from melting_heat_log_info as a
            where a.`status` = 'Active'
            and a.melting_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'  
            group by a.melting_date
            order by a.melting_date
             
        ";
        
        // sum(if(a.foundry_return = '',0, a.foundry_return)) as foundry_return, 
        
        $query = $this->db->query($sql_melt);
        
       $data['issued_qty'] = array();
       
        foreach ($query->result_array() as $row)
        {   
            foreach($row as $fld => $val){
             if($val != 0){
                if($fld != 'melting_date')
                    $data['issued_qty'][$fld][$row['melting_date']] = $val; 
             }   
            } 
        }
        
        
        $sql = "
                select 
                a.moulding_date as issue_date, 
                sum(a.bentonite) as bentonite,
                sum(a.bentokol) as bentokol  
                from moulding_material_log as a
                where a.`status` = 'Active' 
                and a.moulding_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'  
                group by a.moulding_date
                order by a.moulding_date
        
            ";
        
        
        $query = $this->db->query($sql); 
       
        foreach ($query->result_array() as $row)
        {
            foreach($row as $fld => $val){
              if($val != 0){
                if($fld != 'issue_date')
                    $data['issued_qty'][$fld][$row['issue_date']] = $val; 
             }  
            }   
        }
        
        
          $sql = "
                select 
                a.item_id,
                a.adj_date,
                sum(a.adj_qty) as adj_qty                 
                from adj_pur_itm_stock_info as a 
                where a.adj_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'  
                group by a.adj_date , a.item_id
                order by a.adj_date , a.item_id
        
            ";
        
        
        $query = $this->db->query($sql); 
        
        $data['adj_qty'] = array();
       
        foreach ($query->result_array() as $row)
        {
             $data['adj_qty'][$row['item_id']][$row['adj_date']] = $row['adj_qty']; 
        }
        
       // print_r($data['adj_qty']);
        
         
        }
        
       
        
        $this->load->view('page/purchase/stock_report',$data); 
	} 
    
    public function inward_testing_entry(){
        
         if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        
        $data['js'] = 'inward-testing-entry.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            
               $ins = array(  
                        'purchase_inward_id' => $this->input->post('purchase_inward_id'),
                        'tc_received' => $this->input->post('tc_received'), 
                        'result' => $this->input->post('result'), 
                        'criteria' => $this->input->post('criteria'), 
                        'remarks' => $this->input->post('remarks'),  
                        'status' => 'Active',  
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s')  ,
                        'updated_by' => $this->session->userdata('cr_user_id'),                          
                        'updated_datetime' => date('Y-m-d H:i:s')                               
                );
            
                $this->db->insert('purchase_inward_testing_info', $ins); 
           
            redirect('inward-testing-entry');  
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                        'purchase_inward_id' => $this->input->post('purchase_inward_id'),
                        'tc_received' => $this->input->post('tc_received'), 
                        'result' => $this->input->post('result'), 
                        'criteria' => $this->input->post('criteria'), 
                        'remarks' => $this->input->post('remarks'),  
                        'status' => 'Active',
                        'updated_by' => $this->session->userdata('cr_user_id'),                          
                        'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('purchase_inward_testing_id', $this->input->post('purchase_inward_testing_id'));
            $this->db->update('purchase_inward_testing_info', $upd); 
                            
            redirect('inward-testing-entry');  
        } 
        
        
        
        
       if(isset($_POST['srch_date_from'])) {
           $data['srch_date_from'] = $srch_date_from = $this->input->post('srch_date_from'); 
           $data['srch_date_to'] = $srch_date_to = $this->input->post('srch_date_to'); 
           $this->session->set_userdata('srch_date_from', $this->input->post('srch_date_from'));  
           $this->session->set_userdata('srch_date_to', $this->input->post('srch_date_to'));  
       } elseif($this->session->userdata('srch_date_from')) {
           $data['srch_date_from'] = $srch_date_from = $this->session->userdata('srch_date_from') ; 
           $data['srch_date_to'] = $srch_date_to = $this->session->userdata('srch_date_to') ; 
       } else {
           $data['srch_date_from'] = $srch_date_from = date('Y-m-d');
           $data['srch_date_to'] = $srch_date_to = date('Y-m-d');
       }
       
       
        
        
        
        
       
        $sql = "
            select 
                a.*,
                a.purchase_inward_id as pid,
                b.item_name ,
                c.*
                from purchase_inward_info as a 
                left join pur_item_info as b on b.pur_item_id = a.item_id
                left join purchase_inward_testing_info as c on c.purchase_inward_id = a.purchase_inward_id and c.status != 'Delete'  
                where a.status != 'Delete'  
                and a.inward_date between '". $srch_date_from."' and '". $srch_date_to."' 
                order by  a.inward_date asc, a.purchase_inward_id  asc  
        
        ";
        
         
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array(); 
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;  
        }
         
         $this->load->view('page/purchase/inward_testing_entry',$data); 
    }
    
    
    
}    