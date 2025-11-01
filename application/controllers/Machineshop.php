<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Machineshop extends CI_Controller {
    
    
    public function customer_rejection_list_old()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN ) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'machineshop/customer-rejection.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'rej_date' => $this->input->post('rej_date'),
                    'customer_id' => $this->input->post('customer_id'),
                    'pattern_id' => $this->input->post('pattern_id'), 
                    'heat_code' => $this->input->post('heat_code'),                           
                    'rej_group' => $this->input->post('rej_group'),                           
                    'rej_type_id' => $this->input->post('rej_type_id'),                           
                    'qty' => $this->input->post('qty'),                           
                    'status' => 'Active',  
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')  ,
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('customer_rejection_info', $ins); 
            redirect('customer-rejection-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'rej_date' => $this->input->post('rej_date'),
                    'customer_id' => $this->input->post('customer_id'),
                    'pattern_id' => $this->input->post('pattern_id'), 
                    'heat_code' => $this->input->post('heat_code'),                           
                    'rej_group' => $this->input->post('rej_group'),                           
                    'rej_type_id' => $this->input->post('rej_type_id'),                           
                    'qty' => $this->input->post('qty'),                           
                    'status' => 'Active',  
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                                   
            );
            
            $this->db->where('customer_rejection_id', $this->input->post('customer_rejection_id'));
            $this->db->update('customer_rejection_info', $upd); 
                            
            redirect('customer-rejection-list/' . $this->uri->segment(2, 0)); 
        }
        
        $where = '1=1';
        
       if(isset($_POST['srch_rejection_group'])) {
           $data['srch_rejection_group'] = $srch_rejection_group = $this->input->post('srch_rejection_group'); 
           $this->session->set_userdata('srch_rejection_group', $this->input->post('srch_rejection_group')); 
       }
       elseif($this->session->userdata('srch_rejection_group')){
           $data['srch_rejection_group'] = $srch_rejection_group = $this->session->userdata('srch_rejection_group') ; 
       }
       
       if(!empty($srch_rejection_group)){
        $where = " a.rej_group = '" . $srch_rejection_group . "'";
         
         
       } else {
        $where = " 1=1 ";
        $this->session->set_userdata('srch_rejection_group', '');
        $data['srch_rejection_group'] = $srch_rejection_group =  ''; 
       }
        
       if(isset($_POST['srch_customer_id'])) {
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
           
       }  else { 
           $data['srch_customer_id'] = $srch_customer_id = '';
       } 
       
        if(isset($_POST['srch_pattern_id'])) {
          $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           
       }  else {
           $data['srch_pattern_id'] = $srch_pattern_id = ''; 
       } 
       
      if(!empty($srch_customer_id) ){
        $where.=" and a.customer_id = '". $srch_customer_id ."'"; 
      }
      if(!empty($srch_pattern_id) ){
            $where.=" and a.pattern_id = '". $srch_pattern_id ."'"; 
      }
        
        
        $this->load->library('pagination');
        
        $this->db->where('a.status != ', 'Delete');
        $this->db->where($where);
        $this->db->from('customer_rejection_info as a');
        $data['total_records'] = $cnt  = $this->db->count_all_results();
        
        $data['sno'] = $this->uri->segment(2, 0);	
        	
        $config['base_url'] = trim(site_url('customer-rejection-list/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 50;
        $config['uri_segment'] = 2;
        //$config['num_links'] = 2; 
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
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
        
        // a.status = 'Active'
        
        $sql = "
                select 
                a.*,
                b.rejection_type_name ,
                c.company_name as customer,
                d.pattern_item           
                from customer_rejection_info as a  
                left join rejection_type_info as b on b.rejection_type_id = a.rej_type_id
                left join customer_info as c on c.customer_id = a.customer_id
                left join pattern_info as d on d.pattern_id = a.pattern_id  
                where a.status != 'Delete'
                and $where
                order by a.customer_rejection_id desc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
      
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        
        $sql = "
                select 
                a.rejection_group_name   
                from rejection_group_info as a   
                where a.level = 2
                order by a.level, a.rejection_group_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['rejection_group_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['rejection_group_opt'][$row['rejection_group_name']] = $row['rejection_group_name'] ;     
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
        $data['customer_opt'] = array();
        $data['pattern_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        
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
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/machineshop/customer-rejection-list-old',$data); 
	}
    
    public function customer_rejection_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN ) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'machineshop/customer-rejection.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'rej_date' => $this->input->post('rej_date'),
                    'sub_contractor_id' => $this->input->post('sub_contractor_id'),
                    'dc_info' => $this->input->post('dc_info'),
                    'invoice_info' => $this->input->post('invoice_info'),
                    'veh_reg_no' => $this->input->post('veh_reg_no'),
                    'customer_id' => $this->input->post('customer_id'),
                    'rej_grp' => $this->input->post('rej_grp'),           
                    'status' => $this->input->post('status'),   
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')  ,
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('customer_rejection_info', $ins); 
            
            $customer_rejection_id = $this->db->insert_id();
            
            $pattern_ids = $this->input->post('pattern_id'); 
            $rej_type_ids = $this->input->post('rej_type_id');
            $qtys = $this->input->post('qty');
            $remarks = $this->input->post('remarks');
            foreach($pattern_ids as $ind => $pattern_id)
              {
                    if(!empty($pattern_id)) {
                        $ins = array(
                                'customer_rejection_id' => $customer_rejection_id, 
                                'pattern_id' => $pattern_id, 
                                'rej_type_id' => $rej_type_ids[$ind],    
                                'qty' => $qtys[$ind] ,
                                'remarks' => $remarks[$ind] ,
                                'status' => 'Active'                                               
                        );                
                        $this->db->insert('customer_rejection_itm_info', $ins); 
                      
                    }
              } 
            redirect('customer-rejection-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'rej_date' => $this->input->post('rej_date'),
                    'sub_contractor_id' => $this->input->post('sub_contractor_id'),
                    'dc_info' => $this->input->post('dc_info'),
                    'invoice_info' => $this->input->post('invoice_info'),
                    'veh_reg_no' => $this->input->post('veh_reg_no'),
                 //   'customer_id' => $this->input->post('customer_id'),
                 //   'rej_grp' => $this->input->post('rej_grp'),           
                    'status' => $this->input->post('status'),   
                   // 'created_by' => $this->session->userdata('cr_user_id'),                          
                  //  'created_datetime' => date('Y-m-d H:i:s')  ,
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                                       
            );
            
            $this->db->where('customer_rejection_id', $this->input->post('customer_rejection_id'));
            $this->db->update('customer_rejection_info', $upd); 
            
            
            $customer_rejection_itm_ids = $this->input->post('customer_rejection_itm_id'); 
            $pattern_ids = $this->input->post('pattern_id'); 
            $rej_type_ids = $this->input->post('rej_type_id');
            $qtys = $this->input->post('qty');
            $remarks = $this->input->post('remarks');
            foreach($customer_rejection_itm_ids as $ind => $customer_rejection_itm_id)
              {
                    if(empty($customer_rejection_itm_id)) {
                       if((!empty($pattern_ids[$ind]))){
                            $ins = array(
                                    'customer_rejection_id' => $this->input->post('customer_rejection_id'), 
                                    'pattern_id' => $pattern_ids[$ind], 
                                    'rej_type_id' => $rej_type_ids[$ind],    
                                    'qty' => $qtys[$ind] ,
                                    'remarks' => $remarks[$ind] ,
                                    'status' => 'Active'                                               
                            );                
                            $this->db->insert('customer_rejection_itm_info', $ins);  
                        }
                    } else {
                        $upd_itm = array(
                              //  'customer_rejection_id' => $this->input->post('customer_rejection_id'), 
                                //'pattern_id' => $pattern_ids[$ind], 
                               // 'rej_type_id' => $rej_type_ids[$ind],    
                                'qty' => $qtys[$ind] ,
                                'remarks' => $remarks[$ind] ,
                                //'status' => 'Active'                                               
                        );   
                        $this->db->where('customer_rejection_itm_id', $customer_rejection_itm_id);
                        $this->db->update('customer_rejection_itm_info', $upd_itm);              
                    }  
              } 
                            
            redirect('customer-rejection-list/' . $this->uri->segment(2, 0)); 
        }
        
        $where = '1=1';
        
      if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
           
            $this->session->set_userdata('srch_from_date', $this->input->post('srch_from_date'));  
            $this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date'));  
            
       } 
       else {
        $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_to_date') ;
        $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ;  
        
       }   
       
       
        
       if(isset($_POST['srch_rejection_group'])) {
           $data['srch_rejection_group'] = $srch_rejection_group = $this->input->post('srch_rejection_group'); 
           $this->session->set_userdata('srch_rejection_group', $this->input->post('srch_rejection_group')); 
       }
       elseif($this->session->userdata('srch_rejection_group')){
           $data['srch_rejection_group'] = $srch_rejection_group = $this->session->userdata('srch_rejection_group') ; 
       }
       
       if(!empty($srch_rejection_group)){
        $where = " a.rej_group = '" . $srch_rejection_group . "'"; 
         
       } else {
        $where = " 1=1 ";
        $this->session->set_userdata('srch_rejection_group', '');
        $data['srch_rejection_group'] = $srch_rejection_group =  ''; 
       }
        
       if(isset($_POST['srch_customer_id'])) {
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
           
       }  else { 
           $data['srch_customer_id'] = $srch_customer_id = '';
       } 
       
        if(isset($_POST['srch_pattern_id'])) {
          $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           
       }  else {
           $data['srch_pattern_id'] = $srch_pattern_id = ''; 
       } 
       
       if(isset($_POST['srch_sub_contractor_id'])) {
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->input->post('srch_sub_contractor_id');  
           $this->session->set_userdata('srch_sub_contractor_id', $this->input->post('srch_sub_contractor_id'));
       }
       elseif($this->session->userdata('srch_sub_contractor_id')){ 
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->session->userdata('srch_sub_contractor_id') ;
       } 
       else { 
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = '';
       } 
       
      if(!empty($srch_customer_id) ){
        $where.=" and a.customer_id = '". $srch_customer_id ."'"; 
      }
      if(!empty($srch_pattern_id) ){
            $where.=" and a.pattern_id = '". $srch_pattern_id ."'"; 
      }
      
       if(!empty($srch_from_date) ){
                $where.=" and a.rej_date between '". $srch_from_date ."' and '". $srch_to_date."'"; 
       } 
       
       if(!empty($srch_sub_contractor_id) ){
                $where.=" and a.sub_contractor_id = '". $srch_sub_contractor_id ."'"; 
       }
        
        
        $this->load->library('pagination');
        
        $this->db->where('a.status != ', 'Delete');
        $this->db->where($where);
        $this->db->from('customer_rejection_info as a');
        $data['total_records'] = $cnt  = $this->db->count_all_results();
        
        $data['sno'] = $this->uri->segment(2, 0);	
        	
        $config['base_url'] = trim(site_url('customer-rejection-list/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 50;
        $config['uri_segment'] = 2;
        //$config['num_links'] = 2; 
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
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
        
        // a.status = 'Active'
        
        $sql = "
                select 
                a.*, 
                c.company_name as customer, 
                b.company_name as sub_contractor 
                from customer_rejection_info as a   
                left join sub_contractor_info as b on b.sub_contractor_id = a.sub_contractor_id 
                left join customer_info as c on c.customer_id = a.customer_id 
                where a.status != 'Delete'
                and $where
                order by a.customer_rejection_id desc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
      
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        
        $sql = "
                select 
                a.rejection_group_name   
                from rejection_group_info as a   
                where a.level = 2
                order by a.level, a.rejection_group_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['rejection_group_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['rejection_group_opt'][$row['rejection_group_name']] = $row['rejection_group_name'] ;     
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
        $data['customer_opt'] = array();
        $data['pattern_opt'] = array();
       
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
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/machineshop/customer-rejection-list',$data); 
	}
    
    public function customer_rejection_edit($customer_rejection_itm_id)
	{
	   if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        date_default_timezone_set("Asia/Calcutta");  
     
        
	    $data = array(); 
        
        
        $data['js'] = 'machineshop/customer-rejection-edit.inc';  
        
        if($this->input->post('mode') == 'Edit')
        {
             
           $upd = array(
                    'rej_date' => $this->input->post('rej_date'),
                    'sub_contractor_id' => $this->input->post('sub_contractor_id'),
                    'dc_info' => $this->input->post('dc_info'),
                    'invoice_info' => $this->input->post('invoice_info'),
                    'veh_reg_no' => $this->input->post('veh_reg_no'),
                    'customer_id' => $this->input->post('customer_id'),
                    'rej_grp' => $this->input->post('rej_grp'),           
                    'status' => $this->input->post('status'),   
                   // 'created_by' => $this->session->userdata('cr_user_id'),                          
                  //  'created_datetime' => date('Y-m-d H:i:s')  ,
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                                       
            );
            
            $this->db->where('customer_rejection_id', $this->input->post('customer_rejection_id'));
            $this->db->update('customer_rejection_info', $upd); 
            
            
            $customer_rejection_itm_ids = $this->input->post('customer_rejection_itm_id'); 
            $pattern_ids = $this->input->post('pattern_id'); 
            $rej_type_ids = $this->input->post('rej_type_id');
            $qtys = $this->input->post('qty');
            $remarks = $this->input->post('remarks');
            foreach($customer_rejection_itm_ids as $ind => $customer_rejection_itm_id)
              {
                    if(empty($customer_rejection_itm_id)) {
                       if((!empty($pattern_ids[$ind]))){
                            $ins = array(
                                    'customer_rejection_id' => $this->input->post('customer_rejection_id'), 
                                    'pattern_id' => $pattern_ids[$ind], 
                                    'rej_type_id' => $rej_type_ids[$ind],    
                                    'qty' => $qtys[$ind] ,
                                    'remarks' => $remarks[$ind] ,
                                    'status' => 'Active'                                               
                            );    
                            
                                          
                            $this->db->insert('customer_rejection_itm_info', $ins);  
                        }
                    } else {
                        $upd_itm = array(
                                //'customer_rejection_id' => $this->input->post('customer_rejection_id'), 
                                'pattern_id' => $pattern_ids[$ind], 
                                'rej_type_id' => $rej_type_ids[$ind],    
                                'qty' => $qtys[$ind] ,
                                'remarks' => $remarks[$ind] ,
                                //'status' => 'Active'                                               
                        );   
                        $this->db->where('customer_rejection_itm_id', $customer_rejection_itm_id);
                        $this->db->update('customer_rejection_itm_info', $upd_itm);              
                    }  
              } 
		  
            
          redirect('customer-rejection-list');
        }
         
            
        $sql = "
                select 
                a.* 
                from customer_rejection_info as a
                where a.customer_rejection_id = '". $customer_rejection_itm_id. "'  
                order by a.customer_rejection_id desc                  
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'] = $row;     
        }   
        
        $sql = "
                select 
                a.* ,
                b.pattern_item,
                c.rejection_type_name as rejection_type
                from customer_rejection_itm_info as a
                left join pattern_info as b on b.pattern_id = a.pattern_id
                left join rejection_type_info as c on c.rejection_type_id = a.rej_type_id
                where a.customer_rejection_id = '". $customer_rejection_itm_id. "'  
                order by a.customer_rejection_itm_id asc                   
        ";
         
        $query = $this->db->query($sql);
        
        
        foreach ($query->result_array() as $row)
        {
            $data['record_list']['itm'][] = $row;     
        }  
          
       $sql = "
                select 
                a.rejection_group_name   
                from rejection_group_info as a   
                where a.level = 2
                order by a.level, a.rejection_group_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['rejection_group_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['rejection_group_opt'][$row['rejection_group_name']] = $row['rejection_group_name'] ;     
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
        $data['customer_opt'] = array();
         
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $data['record_list']['customer_id'] ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql); 
        $data['pattern_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
        }
        
        
        $sql = "
                select 
                a.rejection_type_id,                
                a.rejection_type_name  
                from rejection_type_info as a  
                where status = 'Active' 
                and a.rejection_group ='". $data['record_list']['rej_grp'] ."'   
                order by a.rejection_type_name  asc                 
        "; 
        
        $query = $this->db->query($sql); 
        $data['rej_type_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['rej_type_opt'][$row['rejection_type_id']] =  $row['rejection_type_name']   ;     
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
         
        
	    $this->load->view('page/machineshop/customer-rejection-edit',$data); 	
	} 
    
    
    
    
    public function ms_despatch_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'machineshop/ms-despatch.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array( 
                    'dc_no' => $this->input->post('dc_no'),
                    'invoice_no' => $this->input->post('invoice_no'),
                    'despatch_date' => $this->input->post('despatch_date'), 
                    'customer_id' => $this->input->post('customer_id'),  
                    'sub_contractor_id' => $this->input->post('sub_contractor_id'),  
                    'vehicle_no' => $this->input->post('vehicle_no'),
                    'driver_name' => $this->input->post('driver_name'),
                    'mobile' => $this->input->post('mobile'),
                    'remarks' => $this->input->post('remarks'), 
                    'transporter_id' => $this->input->post('transporter_id'), 
                    'status' => $this->input->post('status'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('ms_despatch_info', $ins); 
            $insert_id = $this->db->insert_id();
            
            $pattern_ids = $this->input->post('pattern_id'); 
            $qtys = $this->input->post('qty');
            foreach($pattern_ids as $ind => $pattern_id)
              {
                    if(!empty($pattern_id)) {
                        $ins = array(
                                'ms_despatch_id' => $insert_id, 
                                'pattern_id' => $pattern_id,  
                                'qty' => $qtys[$ind] ,
                                'status' => 'Active'                                               
                        );                
                        $this->db->insert('ms_despatch_itm_info', $ins);  
                    }
              }  
              
               
            redirect('ms-despatch-list');
        }
        
        
        
         
        $this->db->select('(ifnull(max(dc_no),0) + 1) as dc_no');
        $query = $this->db->get('ms_despatch_info');
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
        $data['srch_from_date'] = $srch_from_date = date('Y-m-d');
        $data['srch_to_date'] = $srch_to_date = date('Y-m-d'); 
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
       
       if(isset($_POST['srch_sub_contractor_id'])) {
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->input->post('srch_sub_contractor_id');  
           $this->session->set_userdata('srch_sub_contractor_id', $this->input->post('srch_sub_contractor_id'));
       }
       elseif($this->session->userdata('srch_sub_contractor_id')){ 
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->session->userdata('srch_sub_contractor_id') ;
       } 
       else { 
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = '';
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
        
       
        
       
       $where = '1'; 
     
         
        if(!empty($srch_from_date) ){
                $where.=" and a.despatch_date between '". $srch_from_date ."' and '". $srch_to_date ."'" ; 
        }
        
        if(!empty($srch_sub_contractor_id) ){
                $where.=" and a.sub_contractor_id = '". $srch_sub_contractor_id ."'"; 
        } 
        
        if(!empty($srch_customer_id) ){
                $where.=" and a.customer_id = '". $srch_customer_id ."'"; 
        }  
        
        if(!empty($srch_pattern_id)){
         //$where .= " and exists (select z.work_order_id from customer_despatch_item_info as z where z.customer_despatch_id = a.customer_despatch_id and z.pattern_id = '". $srch_pattern_id ."') ";
          $where.=" and b.pattern_id = '". $srch_pattern_id ."'";    
        } 
        
        $this->db->where('a.status != ', 'Delete');
        $this->db->where('b.status != ', 'Delete');
        if($where != '1')
            $this->db->where($where);
        $this->db->select('a.ms_despatch_id');         
        $this->db->from('ms_despatch_info as a');         
        $this->db->join('ms_despatch_itm_info as b','b.ms_despatch_id = a.ms_despatch_id' , 'left');         
        $this->db->group_by('a.ms_despatch_id');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('ms-despatch-list/'), '/'. $this->uri->segment(2, 0));
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
                a.ms_despatch_id, 
                a.dc_no, 
                a.invoice_no, 
                a.despatch_date, 
                c.company_name as customer,   
                a.vehicle_no, 
                a.driver_name, 
                a.mobile, 
                a.remarks, 
                d.transporter_name,
                d.transporter_gst,
                a.`status`,
                e.company_name as sub_contractor,
                DATEDIFF(current_date(), a.despatch_date) as days  
                from ms_despatch_info as a  
                left join ms_despatch_itm_info as b on b.ms_despatch_id = a.ms_despatch_id
                left join customer_info as c on c.customer_id = a.customer_id 
                left join transporter_info as d on d.transporter_id = a.transporter_id 
                left join sub_contractor_info as e on e.sub_contractor_id = a.sub_contractor_id 
                where a.status != 'Delete' and b.status != 'Delete' 
                and ". $where ."
                group by a.ms_despatch_id  
                order by a.ms_despatch_id desc 
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
        
        $this->load->view('page/machineshop/ms-despatch-list',$data); 
	}
    
    public function ms_despatch_edit($ms_despatch_id)
	{
	   if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        date_default_timezone_set("Asia/Calcutta");  
     
        
	    $data = array(); 
        
        
        $data['js'] = 'machineshop/ms-despatch-edit.inc';  
        
        if($this->input->post('mode') == 'Edit')
        {
             
           $upd = array(
                    'dc_no' => $this->input->post('dc_no'),
                    'invoice_no' => $this->input->post('invoice_no'),
                    'despatch_date' => $this->input->post('despatch_date'), 
                    'customer_id' => $this->input->post('customer_id'),  
                    'sub_contractor_id' => $this->input->post('sub_contractor_id'),  
                    'vehicle_no' => $this->input->post('vehicle_no'),
                    'driver_name' => $this->input->post('driver_name'),
                    'mobile' => $this->input->post('mobile'),
                    'remarks' => $this->input->post('remarks'), 
                    'transporter_id' => $this->input->post('transporter_id'), 
                    'status' => $this->input->post('status'), 
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                                       
            );
            
            $this->db->where('ms_despatch_id', $this->input->post('ms_despatch_id'));
            $this->db->update('ms_despatch_info', $upd); 
            
            
            $ms_despatch_itm_ids = $this->input->post('ms_despatch_itm_id'); 
            $pattern_ids = $this->input->post('pattern_id');  
            $qtys = $this->input->post('qty');
            foreach($ms_despatch_itm_ids as $ind => $ms_despatch_itm_id)
              {
                    if(empty($ms_despatch_itm_id)) {
                       if((!empty($pattern_ids[$ind]))){
                            $ins = array(
                                    'ms_despatch_id' => $this->input->post('ms_despatch_id'), 
                                    'pattern_id' => $pattern_ids[$ind],    
                                    'qty' => $qtys[$ind] ,
                                    'status' => 'Active'                                               
                            );    
                            
                                          
                            $this->db->insert('ms_despatch_itm_info', $ins);  
                        }
                    } else {
                        $upd_itm = array(
                                'pattern_id' => $pattern_ids[$ind],   
                                'qty' => $qtys[$ind] ,                                              
                        );   
                        $this->db->where('ms_despatch_itm_id', $ms_despatch_itm_id);
                        $this->db->update('ms_despatch_itm_info', $upd_itm);              
                    }  
              } 
		  
            
          redirect('ms-despatch-list');
        }
         
            
        $sql = "
                select 
                a.* 
                from ms_despatch_info as a
                where a.ms_despatch_id = '". $ms_despatch_id. "'  
                order by a.ms_despatch_id desc                  
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'] = $row;     
        }   
        
        $sql = "
                select 
                a.* ,
                b.pattern_item
                from ms_despatch_itm_info as a
                left join pattern_info as b on b.pattern_id = a.pattern_id 
                where a.ms_despatch_id = '". $ms_despatch_id . "'  
                order by a.ms_despatch_itm_id asc                   
        ";
         
        $query = $this->db->query($sql);
        
        
        foreach ($query->result_array() as $row)
        {
            $data['record_list']['itm'][] = $row;     
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
        $data['customer_opt'] = array();
         
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $data['record_list']['customer_id'] ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql); 
        $data['pattern_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
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
         
        
	    $this->load->view('page/machineshop/ms-despatch-edit',$data); 	
	} 
    
    public function print_ms_dc($dc_id )
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
       
        
        $sql = "
                select  
                a.ms_despatch_id,
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
                from ms_despatch_info as a
                left join customer_info as b on b.customer_id= a.customer_id
                left join transporter_info as c on c.transporter_id = a.transporter_id 
                where a.`status` != 'Delete' 
                and a.ms_despatch_id = '". $dc_id ."'      
                order by a.despatch_date desc                 
        ";
        
        
        $query = $this->db->query($sql); 
		
		$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list']  = $row;  
        }
        
        
        
       $sql = "
				 select 
                a.ms_despatch_id,  
                a.pattern_id ,
                b.pattern_item as item,  
                (a.qty) as qty ,
                b.piece_weight_per_kg,
                (a.qty * b.piece_weight_per_kg) as tot_wt  
                from ms_despatch_itm_info as a 
                left join pattern_info as b on b.pattern_id = a.pattern_id 
                where a.status != 'Delete' 
                and a.ms_despatch_id = '". $dc_id ."'
                group by a.ms_despatch_id ,a.pattern_id 
                order by a.ms_despatch_id asc          
		
		";
		     
		
        
        $query = $this->db->query($sql); 
       
        foreach ($query->result_array() as $row)
        {
            $data['bill_list'][] = $row;     
        }
		
		 
        
        $this->load->view('page/machineshop/print-ms-dc',$data); 
	}
    
    public function ms_floor_stock()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'machineshop/ms-floor-stock.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'floor_stock_date' => $this->input->post('floor_stock_date'),
                    'sub_contractor_id' => $this->input->post('sub_contractor_id'), 
                    'customer_id' => $this->input->post('customer_id'), 
                    'pattern_id' => $this->input->post('pattern_id'), 
                    'stock_qty' => $this->input->post('stock_qty'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s') ,
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                            
            );
            
            $this->db->insert('ms_floor_stock_info', $ins); 
            redirect('ms-floor-stock');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'floor_stock_date' => $this->input->post('floor_stock_date'),
                    'sub_contractor_id' => $this->input->post('sub_contractor_id'), 
                    'customer_id' => $this->input->post('customer_id'), 
                    'pattern_id' => $this->input->post('pattern_id'), 
                    'stock_qty' => $this->input->post('stock_qty'), 
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('floor_stock_id', $this->input->post('core_floor_stock_id'));
            $this->db->update('ms_floor_stock_info', $upd); 
                            
            redirect('ms-floor-stock/' . $this->uri->segment(2, 0)); 
        }  
         
         
        
       $this->load->library('pagination');
        
       if(isset($_POST['srch_customer'])) {
           $data['srch_customer'] = $srch_customer = $this->input->post('srch_customer'); 
           $this->session->set_userdata('srch_customer', $this->input->post('srch_customer'));
            
       }
       elseif($this->session->userdata('srch_customer')){
           $data['srch_customer'] = $srch_customer = $this->session->userdata('srch_customer') ; 
       }else {
           $data['srch_customer'] = $srch_customer = '';
       }
       
       if(isset($_POST['srch_sub_contractor_id'])) {
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->input->post('srch_sub_contractor_id');  
           $this->session->set_userdata('srch_sub_contractor_id', $this->input->post('srch_sub_contractor_id'));
       }
       elseif($this->session->userdata('srch_sub_contractor_id')){ 
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->session->userdata('srch_sub_contractor_id') ;
       } 
       else { 
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = '';
       } 
       
       /*if(isset($_POST['srch_key'])) { 
           $data['srch_key'] = $srch_key = $this->input->post('srch_key'); 
           $this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_key')){ 
           $data['srch_key'] = $srch_key = $this->session->userdata('srch_key') ;
       } else {
         $data['srch_key'] = $srch_key = '';
       }
       */
       
       
       $where = '1=1';

       if(!empty($srch_customer)){
         $where .= " and a.customer_id = '". $srch_customer ."'";
       }
        
      /* if(!empty($srch_state)){
         $where .= " and a.state_code = '". $srch_state ."'";
       }  
       if(!empty($srch_key)) {
         $where .= " and ( 
                        a.servicable_pincode like '%" . $srch_key . "%' or 
                        a.mobile like '%". $srch_key ."%' or 
                        a.contact_person like '%". $srch_key ."%' or 
                        a.email like '%". $srch_key ."%' or 
                        a.phone like '%". $srch_key ."%'
                        ) ";
         
       } */
        
        
        //$this->db->where('status != ', 'Delete');
         
        $this->db->where($where);
        $this->db->from('ms_floor_stock_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('floor-stock/'), '/'. $this->uri->segment(2, 0));
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
                a.ms_floor_stock_id, 
                a.floor_stock_date, 
                b.company_name as customer, 
                d.company_name as sub_contractor, 
                c.pattern_item, 
                a.stock_qty,
                DATEDIFF(current_date(), a.floor_stock_date) as days  
                from ms_floor_stock_info as a
                left join customer_info as b on b.customer_id = a.customer_id
                left join pattern_info as c on c.pattern_id = a.pattern_id 
                left join sub_contractor_info as d on d.sub_contractor_id = a.sub_contractor_id 
                where ". $where ."
                order by  a.floor_stock_date desc , b.company_name , c.pattern_item
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
         
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/machineshop/ms-floor-stock',$data); 
	}   
    
    
    public function ms_stock_report()
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
       
       if(isset($_POST['srch_sub_contractor_id'])) { 
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->input->post('srch_sub_contractor_id');  
           $data['submit_flg'] = true;
       } 
       else { 
        $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = '';
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
	       $op_sql = "select 
                a.pattern_id,
                a.pattern_item,
                f.company_name as customer,
                b.sub_contractor_id,
                b.floor_stock_date as op_floor_stock_date,
                b.stock_qty  as op_stock_qty ,
                c.inward_qty,
                d.intl_rej_qty,
                e.despatch_qty
                from pattern_info as a
                left join (
                    select 
                    q.floor_stock_date,
                    q.sub_contractor_id,
                    q.customer_id,
                    q.pattern_id,
                    q.stock_qty,
                    w.op_floor_stock_date
                    from ms_floor_stock_info as q
                    left join (
                        select 
                        max(q1.floor_stock_date) as op_floor_stock_date,
                        q1.sub_contractor_id,
                        q1.customer_id,
                        q1.pattern_id
                        from ms_floor_stock_info as q1
                        where q1.floor_stock_date <= '" .$srch_date. "'
                        group by q1.sub_contractor_id, q1.customer_id, q1.pattern_id 
                        order by q1.sub_contractor_id, q1.customer_id, q1.pattern_id 
                    ) as w on w.sub_contractor_id = q.sub_contractor_id and w.customer_id = q.customer_id and w.pattern_id = q.pattern_id
                
                ) as b on b.pattern_id = a.pattern_id and FIND_IN_SET(b.customer_id , a.customer_id)
                left join (
                    select 
                    z.despatch_date,
                    z1.machining_sub_contractor_id,
                    z.customer_id,
                    z1.pattern_id,
                    sum(z1.qty) as inward_qty
                    from customer_despatch_info as z
                    left join customer_despatch_item_info as z1 on z1.customer_despatch_id = z.customer_despatch_id
                    where z.status='Active' and z1.status='Active' and z.dc_type='Processing'
                    group by z1.machining_sub_contractor_id,z.customer_id,z1.pattern_id,z.despatch_date
                    order by z1.machining_sub_contractor_id,z.customer_id,z1.pattern_id,z.despatch_date
                ) as c on c.machining_sub_contractor_id = b.sub_contractor_id 
                and c.pattern_id = a.pattern_id and FIND_IN_SET(c.customer_id , a.customer_id) 
                and c.machining_sub_contractor_id = b.sub_contractor_id
                and c.despatch_date between (ifnull(b.floor_stock_date,'0000-00-00')) and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                left join (
                    select 
                    p.sub_contractor_id , 
                    p.customer_id , 
                    p1.pattern_id , 
                    p.rej_date ,
                    sum(p1.qty) as intl_rej_qty 
                    from customer_rejection_info as p
                    left join customer_rejection_itm_info as p1 on p1.customer_rejection_id = p.customer_rejection_id
                    where p.status='Active' and p1.status='Active' and p.rej_grp = 'Machine Shop'
                    group by p.sub_contractor_id , p.customer_id , p1.pattern_id , p.rej_date 
                    order by p.sub_contractor_id , p.customer_id , p1.pattern_id , p.rej_date  
                ) as d on  d.sub_contractor_id = b.sub_contractor_id 
                and d.pattern_id = a.pattern_id and FIND_IN_SET(d.customer_id , a.customer_id)
                and d.rej_date between (ifnull(b.floor_stock_date,'0000-00-00')) and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                left join (
                    select 
                    k.despatch_date,
                    k.customer_id,
                    k.sub_contractor_id,
                    k1.pattern_id,
                    sum(k1.qty) as despatch_qty
                    from ms_despatch_info as k
                    left join ms_despatch_itm_info as k1 on k1.ms_despatch_id = k.ms_despatch_id
                    where k.status='Active' and k1.status='Active'  
                    group by k.sub_contractor_id , k.customer_id , k1.pattern_id ,k.despatch_date
                    order by k.sub_contractor_id , k.customer_id , k1.pattern_id , k.despatch_date  
                ) as e on e.sub_contractor_id = b.sub_contractor_id 
                and e.pattern_id = a.pattern_id and FIND_IN_SET(e.customer_id , a.customer_id)
                and e.despatch_date between (ifnull(b.floor_stock_date,'0000-00-00')) and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                left join customer_info as f on FIND_IN_SET(f.customer_id,a.customer_id)
                where a.`status` = 'Active' ";
          
          
           if(!empty($srch_customer_id) ){
                $op_sql.=" and f.customer_id = '". $srch_customer_id ."'"; 
            }
           if(!empty($srch_pattern_id) ){
              $op_sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
            }   
           if(!empty($srch_sub_contractor_id) ){
              $op_sql.=" and (
                            b.sub_contractor_id = '". $srch_sub_contractor_id ."' or
                            c.machining_sub_contractor_id = '". $srch_sub_contractor_id ."' or
                            d.sub_contractor_id = '". $srch_sub_contractor_id ."' or
                            e.sub_contractor_id = '". $srch_sub_contractor_id ."'   
                            )";
            } 
               
           $op_sql .="  
                group by f.customer_id  , a.pattern_id   
                order by a.pattern_item  
            "; */
            
            
          /*  
            
           $op_sql = "select 
                        b.machining_sub_contractor_id, 
                        a.customer_id, 
                        b.pattern_id ,
                        c.company_name as sub_contractor,
                        d.company_name as customer,
                        e.pattern_item as pattern_item,
                        ifnull(f.op_floor_stock_date,'0000-00-00') as op_floor_stock_date,
                        ifnull(f.stock_qty,0) as op_stock_qty,
                        ifnull(g.inward_qty,0) as inward_qty,
                        ifnull(h.intl_rej_qty,0) as intl_rej_qty,
                        ifnull(i.despatch_qty,0) as despatch_qty,
                        ifnull(r.rework_in,0) as rework_in,
                        ifnull(v.rework_out,0) as rework_out,
                        (ifnull(f.stock_qty,0)  + ifnull(g.inward_qty,0) + ifnull(r.rework_in,0) - (ifnull(h.intl_rej_qty,0) + ifnull(i.despatch_qty,0) + ifnull(v.rework_out,0))) as op_qty
                        from customer_despatch_info as a
                        left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
                        left join sub_contractor_info as c on c.sub_contractor_id = b.machining_sub_contractor_id
                        left join customer_info as d on d.customer_id = a.customer_id
                        left join pattern_info as e on e.pattern_id = b.pattern_id
                        left join 
                        	( 
                        	 select 
                                q.floor_stock_date,
                                q.sub_contractor_id,
                                q.customer_id,
                                q.pattern_id,
                                q.stock_qty,
                                w.op_floor_stock_date
                                from ms_floor_stock_info as q
                                left join (
                                    select 
                                    max(q1.floor_stock_date) as op_floor_stock_date,
                                    q1.sub_contractor_id,
                                    q1.customer_id,
                                    q1.pattern_id
                                    from ms_floor_stock_info as q1
                                    where q1.floor_stock_date <= '" .$srch_date. "'
                                    group by q1.sub_contractor_id, q1.customer_id, q1.pattern_id 
                                    order by q1.sub_contractor_id, q1.customer_id, q1.pattern_id 
                                ) as w on w.sub_contractor_id = q.sub_contractor_id and w.customer_id = q.customer_id and w.pattern_id = q.pattern_id
                        		) as f on f.sub_contractor_id = b.machining_sub_contractor_id and f.customer_id = a.customer_id and f.pattern_id = b.pattern_id
                        
                        left join 
                        		(
                                   select 
                                   z.despatch_date,
                                   z1.machining_sub_contractor_id,
                                   z.customer_id,
                                   z1.pattern_id,
                                   sum(z1.qty) as inward_qty
                                   from customer_despatch_info as z
                                   left join customer_despatch_item_info as z1 on z1.customer_despatch_id = z.customer_despatch_id
                                   where z.status='Active' and z1.status='Active' and z.dc_type='Processing'
                                   group by z1.machining_sub_contractor_id,z.customer_id,z1.pattern_id,z.despatch_date
                                   order by z1.machining_sub_contractor_id,z.customer_id,z1.pattern_id,z.despatch_date
                               ) as g on g.machining_sub_contractor_id = b.machining_sub_contractor_id and 
                               			  g.customer_id = a.customer_id and 
                    					  g.pattern_id = b.pattern_id and
                    					  g.despatch_date between ifnull(f.op_floor_stock_date,'0000-00-00') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                        
                        left join 
                        	(
                        		select 
                        		p.sub_contractor_id , 
                        		p.customer_id , 
                        		p1.pattern_id , 
                        		p.rej_date ,
                        		sum(p1.qty) as intl_rej_qty 
                        		from customer_rejection_info as p
                        		left join customer_rejection_itm_info as p1 on p1.customer_rejection_id = p.customer_rejection_id
                        		where p.status='Active' and p1.status='Active' and p.rej_grp = 'Machine Shop'
                        		group by p.sub_contractor_id , p.customer_id , p1.pattern_id , p.rej_date 
                        		order by p.sub_contractor_id , p.customer_id , p1.pattern_id , p.rej_date 
                        	) as h on h.sub_contractor_id = b.machining_sub_contractor_id and
                        				 h.customer_id = a.customer_id and
                        				 h.pattern_id = b.pattern_id and
                        				 h.rej_date between ifnull(f.op_floor_stock_date,'0000-00-00') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                        left join 
                        	(
                        	  select 
                             k.despatch_date,
                             k.customer_id,
                             k.sub_contractor_id,
                             k1.pattern_id,
                             sum(k1.qty) as despatch_qty
                             from ms_despatch_info as k
                             left join ms_despatch_itm_info as k1 on k1.ms_despatch_id = k.ms_despatch_id
                             where k.status='Active' and k1.status='Active'  
                             group by k.sub_contractor_id , k.customer_id , k1.pattern_id ,k.despatch_date
                             order by k.sub_contractor_id , k.customer_id , k1.pattern_id , k.despatch_date  
                        	) as i on i.sub_contractor_id = b.machining_sub_contractor_id and 
                        				 i.customer_id = a.customer_id and
                        				 i.pattern_id = b.pattern_id and
                         				 i.despatch_date between ifnull(f.op_floor_stock_date,'0000-00-00') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 					 
                          left join 
                        	(
                        	 select
                                j.rework_date,
                                j.sub_contractor_id , 
                                j.customer_id, 
                                u.pattern_id,
                                sum(u.qty) as rework_in
                                from ms_rework_info as j
                                left join ms_rework_itm_info as u on u.ms_rework_id = j.ms_rework_id
                                where j.`status` = 'Active' and u.`status` ='Active'
                                and j.rework_type = 'Inward'
                                group by j.rework_date ,j.sub_contractor_id , j.customer_id, u.pattern_id
                                order by j.rework_date , j.sub_contractor_id , j.customer_id, u.pattern_id 
                        	) as r on r.sub_contractor_id = b.machining_sub_contractor_id and 
                        				 r.customer_id = a.customer_id and
                        				 r.pattern_id = b.pattern_id and
                         				 r.rework_date between ifnull(f.op_floor_stock_date,'0000-00-00') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 					 
                        
                           left join 
                        	(
                        	 select
                                j.rework_date,
                                j.sub_contractor_id , 
                                j.customer_id, 
                                u.pattern_id,
                                sum(u.qty) as rework_out
                                from ms_rework_info as j
                                left join ms_rework_itm_info as u on u.ms_rework_id = j.ms_rework_id
                                where j.`status` = 'Active' and u.`status` ='Active'
                                and j.rework_type = 'Outward'
                                group by j.rework_date ,j.sub_contractor_id , j.customer_id, u.pattern_id
                                order by j.rework_date , j.sub_contractor_id , j.customer_id, u.pattern_id 
                        	) as v on v.sub_contractor_id = b.machining_sub_contractor_id and 
                        				 v.customer_id = a.customer_id and
                        				 v.pattern_id = b.pattern_id and
                         				 v.rework_date between ifnull(f.op_floor_stock_date,'0000-00-00') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 					 
                        
                         
                        where a.dc_type = 'Processing' and a.`status` ='Active'
                        and b.machining_sub_contractor_id > 0 
                        "; 
                        
               if(!empty($srch_customer_id) ){
                    $op_sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                }
               if(!empty($srch_pattern_id) ){
                  $op_sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                }   
               if(!empty($srch_sub_contractor_id) ){
                  $op_sql.=" and b.machining_sub_contractor_id = '". $srch_sub_contractor_id ."'  ";
                } 
                   
               $op_sql .="  
                    group by b.machining_sub_contractor_id, a.customer_id, b.pattern_id 
                    order by c.company_name ,d.company_name ,e.pattern_item 
                ";     
                
             */
             
            /*
             
             $op_sql = "select 
                        b.machining_sub_contractor_id, 
                        a.customer_id, 
                        b.pattern_id ,
                        c.company_name as sub_contractor,
                        d.company_name as customer,
                        e.pattern_item as pattern_item,
                        ifnull(f.op_floor_stock_date,'0000-00-00') as op_floor_stock_date,
                        ifnull(f.stock_qty,0) as op_stock_qty,
                        ifnull(g.inward_qty,0) as inward_qty,
                        ifnull(h.intl_rej_qty,0) as intl_rej_qty,
                        ifnull(i.despatch_qty,0) as despatch_qty,
                        ifnull(r.rework_in,0) as rework_in,
                        ifnull(v.rework_out,0) as rework_out,
                        (ifnull(f.stock_qty,0)  + ifnull(g.inward_qty,0) + ifnull(r.rework_in,0) - (ifnull(h.intl_rej_qty,0) + ifnull(i.despatch_qty,0) + ifnull(v.rework_out,0))) as op_qty
                        from customer_despatch_info as a
                        left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
                        left join sub_contractor_info as c on c.sub_contractor_id = b.machining_sub_contractor_id
                        left join customer_info as d on d.customer_id = a.customer_id
                        left join pattern_info as e on e.pattern_id = b.pattern_id
                        left join 
                        	( 
                        	 select 
                                q.floor_stock_date,
                                q.sub_contractor_id,
                                q.customer_id,
                                q.pattern_id,
                                q.stock_qty,
                                w.op_floor_stock_date
                                from ms_floor_stock_info as q
                                left join (
                                    select 
                                    max(q1.floor_stock_date) as op_floor_stock_date,
                                    q1.sub_contractor_id,
                                    q1.customer_id,
                                    q1.pattern_id
                                    from ms_floor_stock_info as q1
                                    where q1.floor_stock_date <= '" .$srch_date. "'
                                    group by q1.sub_contractor_id, q1.customer_id, q1.pattern_id 
                                    order by q1.sub_contractor_id, q1.customer_id, q1.pattern_id 
                                ) as w on w.sub_contractor_id = q.sub_contractor_id and w.customer_id = q.customer_id and w.pattern_id = q.pattern_id
                        		) as f on f.sub_contractor_id = b.machining_sub_contractor_id and f.customer_id = a.customer_id and f.pattern_id = b.pattern_id
                        
                        left join 
                        		(
                                   select  
                                   z1.machining_sub_contractor_id,
                                   z.customer_id,
                                   z1.pattern_id,
                                   sum(z1.qty) as inward_qty
                                   from customer_despatch_info as z
                                   left join customer_despatch_item_info as z1 on z1.customer_despatch_id = z.customer_despatch_id
                                   where z.status='Active' and z1.status='Active' and z.dc_type='Processing'
                                   and z.despatch_date between ifnull((select max(r1.floor_stock_date) from ms_floor_stock_info as r1 where r1.sub_contractor_id = z1.machining_sub_contractor_id and r1.customer_id = z.customer_id  and r1.pattern_id = z1.pattern_id and r1.floor_stock_date <= '" .$srch_date. "'),'2024-04-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                                   group by z1.machining_sub_contractor_id,z.customer_id,z1.pattern_id 
                                   order by z1.machining_sub_contractor_id,z.customer_id,z1.pattern_id 
                               ) as g on g.machining_sub_contractor_id = b.machining_sub_contractor_id and 
                               			  g.customer_id = a.customer_id and 
                    					  g.pattern_id = b.pattern_id  
                        left join 
                        	(
                        		select 
                        		p.sub_contractor_id , 
                        		p.customer_id , 
                        		p1.pattern_id ,  
                        		sum(p1.qty) as intl_rej_qty 
                        		from customer_rejection_info as p
                        		left join customer_rejection_itm_info as p1 on p1.customer_rejection_id = p.customer_rejection_id
                        		where p.status='Active' and p1.status='Active' and p.rej_grp = 'Machine Shop'
                                and p.rej_date between ifnull((select max(r1.floor_stock_date) from ms_floor_stock_info as r1 where r1.sub_contractor_id = p.sub_contractor_id and r1.customer_id = p.customer_id  and r1.pattern_id = p1.pattern_id and r1.floor_stock_date <= '" .$srch_date. "'),'2024-04-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)
                        		group by p.sub_contractor_id , p.customer_id , p1.pattern_id  
                        		order by p.sub_contractor_id , p.customer_id , p1.pattern_id  
                        	) as h on h.sub_contractor_id = b.machining_sub_contractor_id and
                        				 h.customer_id = a.customer_id and
                        				 h.pattern_id = b.pattern_id 
                        				   
                        left join 
                        	(
                        	  select  
                             k.customer_id,
                             k.sub_contractor_id,
                             k1.pattern_id,
                             sum(k1.qty) as despatch_qty
                             from ms_despatch_info as k
                             left join ms_despatch_itm_info as k1 on k1.ms_despatch_id = k.ms_despatch_id
                             where k.status='Active' and k1.status='Active'  
                             and k.despatch_date between ifnull((select max(r1.floor_stock_date) from ms_floor_stock_info as r1 where r1.sub_contractor_id = k.sub_contractor_id and r1.customer_id = k.customer_id  and r1.pattern_id = k1.pattern_id and r1.floor_stock_date <= '" .$srch_date. "'),'2024-04-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)
                             group by k.sub_contractor_id , k.customer_id , k1.pattern_id  
                             order by k.sub_contractor_id , k.customer_id , k1.pattern_id   
                        	) as i on i.sub_contractor_id = b.machining_sub_contractor_id and 
                        				 i.customer_id = a.customer_id and
                        				 i.pattern_id = b.pattern_id                          				   					 
                          left join 
                        	(
                        	 select 
                                j.sub_contractor_id , 
                                j.customer_id, 
                                u.pattern_id,
                                sum(u.qty) as rework_in
                                from ms_rework_info as j
                                left join ms_rework_itm_info as u on u.ms_rework_id = j.ms_rework_id
                                where j.`status` = 'Active' and u.`status` ='Active'
                                and j.rework_type = 'Inward'
                                and j.rework_date between ifnull((select max(r1.floor_stock_date) from ms_floor_stock_info as r1 where r1.sub_contractor_id = j.sub_contractor_id and r1.customer_id = j.customer_id  and r1.pattern_id = u.pattern_id and r1.floor_stock_date <= '" .$srch_date. "'),'2024-04-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)
                                group by  j.sub_contractor_id , j.customer_id, u.pattern_id
                                order by  j.sub_contractor_id , j.customer_id, u.pattern_id 
                        	) as r on r.sub_contractor_id = b.machining_sub_contractor_id and 
                        				 r.customer_id = a.customer_id and
                        				 r.pattern_id = b.pattern_id  
                           left join 
                        	(
                        	 select
                                j.rework_date,
                                j.sub_contractor_id , 
                                j.customer_id, 
                                u.pattern_id,
                                sum(u.qty) as rework_out
                                from ms_rework_info as j
                                left join ms_rework_itm_info as u on u.ms_rework_id = j.ms_rework_id
                                where j.`status` = 'Active' and u.`status` ='Active'
                                and j.rework_type = 'Outward'
                                and j.rework_date between ifnull((select max(r1.floor_stock_date) from ms_floor_stock_info as r1 where r1.sub_contractor_id = j.sub_contractor_id and r1.customer_id = j.customer_id  and r1.pattern_id = u.pattern_id and r1.floor_stock_date <= '" .$srch_date. "'),'2024-04-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)
                                group by  j.sub_contractor_id , j.customer_id, u.pattern_id
                                order by  j.sub_contractor_id , j.customer_id, u.pattern_id 
                        	) as v on v.sub_contractor_id = b.machining_sub_contractor_id and 
                        				 v.customer_id = a.customer_id and
                        				 v.pattern_id = b.pattern_id   
                         
                        where a.dc_type = 'Processing' and a.`status` ='Active'
                        and b.machining_sub_contractor_id > 0 
                        "; 
                        
               if(!empty($srch_customer_id) ){
                    $op_sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                }
               if(!empty($srch_pattern_id) ){
                  $op_sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
                }   
               if(!empty($srch_sub_contractor_id) ){
                  $op_sql.=" and b.machining_sub_contractor_id = '". $srch_sub_contractor_id ."'  ";
                } 
                   
               $op_sql .="  
                    group by b.machining_sub_contractor_id, a.customer_id, b.pattern_id 
                    order by c.company_name ,d.company_name ,e.pattern_item 
                ";     
              
              */  
              
               
             $op_sql ="
             select 
                a.sub_contractor_id, 
                a.customer_id, 
                a.pattern_id ,
                c.company_name as sub_contractor,
                d.company_name as customer,
                e.pattern_item as pattern_item,
                ifnull(b.op_floor_stock_date,'0000-00-00') as op_floor_stock_date,
                ifnull(a.stock_qty,0) as op_stock_qty,
                ifnull(g.inward_qty,0) as inward_qty,
                ifnull(h.intl_rej_qty,0) as intl_rej_qty,
                ifnull(i.despatch_qty,0) as despatch_qty,
                ifnull(r.rework_in,0) as rework_in,
                ifnull(v.rework_out,0) as rework_out,
                (ifnull(a.stock_qty,0)  + ifnull(g.inward_qty,0) + ifnull(r.rework_in,0) - (ifnull(h.intl_rej_qty,0) + ifnull(i.despatch_qty,0) + ifnull(v.rework_out,0))) as op_qty
                 
                from ms_floor_stock_info as a
                left join (
                               select 
                               max(q1.floor_stock_date) as op_floor_stock_date,
                               q1.sub_contractor_id,
                               q1.customer_id,
                               q1.pattern_id
                               from ms_floor_stock_info as q1
                               where q1.floor_stock_date <= '" .$srch_date. "'
                               group by q1.sub_contractor_id, q1.customer_id, q1.pattern_id 
                               order by q1.sub_contractor_id, q1.customer_id, q1.pattern_id 
                           ) as b on b.sub_contractor_id = a.sub_contractor_id and b.customer_id = a.customer_id and b.pattern_id = a.pattern_id
                left join sub_contractor_info as c on c.sub_contractor_id = a.sub_contractor_id
                left join customer_info as d on d.customer_id = a.customer_id
                left join pattern_info as e on e.pattern_id = a.pattern_id
                left join 
                   		(
                              select  
                              z1.machining_sub_contractor_id,
                              z.customer_id,
                              z1.pattern_id,
                              sum(z1.qty) as inward_qty
                              from customer_despatch_info as z
                              left join customer_despatch_item_info as z1 on z1.customer_despatch_id = z.customer_despatch_id
                              where z.status='Active' and z1.status='Active' and z.dc_type='Processing'
                              and z.despatch_date between ifnull((select max(r1.floor_stock_date) from ms_floor_stock_info as r1 where r1.sub_contractor_id = z1.machining_sub_contractor_id and r1.customer_id = z.customer_id  and r1.pattern_id = z1.pattern_id and r1.floor_stock_date <= '" .$srch_date. "'),'2024-04-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day) 
                              group by z1.machining_sub_contractor_id,z.customer_id,z1.pattern_id 
                              order by z1.machining_sub_contractor_id,z.customer_id,z1.pattern_id 
                          ) as g on g.machining_sub_contractor_id = a.sub_contractor_id and 
                          			  g.customer_id = a.customer_id and 
                				        g.pattern_id = a.pattern_id  
                left join 
                      	(
                      		select 
                      		p.sub_contractor_id , 
                      		p.customer_id , 
                      		p1.pattern_id ,  
                      		sum(p1.qty) as intl_rej_qty 
                      		from customer_rejection_info as p
                      		left join customer_rejection_itm_info as p1 on p1.customer_rejection_id = p.customer_rejection_id
                      		where p.status='Active' and p1.status='Active' and p.rej_grp = 'Machine Shop'
                              and p.rej_date between ifnull((select max(r1.floor_stock_date) from ms_floor_stock_info as r1 where r1.sub_contractor_id = p.sub_contractor_id and r1.customer_id = p.customer_id  and r1.pattern_id = p1.pattern_id and r1.floor_stock_date <= '" .$srch_date. "'),'2024-04-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)
                      		group by p.sub_contractor_id , p.customer_id , p1.pattern_id  
                      		order by p.sub_contractor_id , p.customer_id , p1.pattern_id  
                      	) as h on h.sub_contractor_id = a.sub_contractor_id and
                      				 h.customer_id = a.customer_id and
                      				 h.pattern_id = a.pattern_id 	
                left join 
                (
                  select  
                  k.customer_id,
                  k.sub_contractor_id,
                  k1.pattern_id,
                  sum(k1.qty) as despatch_qty
                  from ms_despatch_info as k
                  left join ms_despatch_itm_info as k1 on k1.ms_despatch_id = k.ms_despatch_id
                  where k.status='Active' and k1.status='Active'  
                  and k.despatch_date between ifnull((select max(r1.floor_stock_date) from ms_floor_stock_info as r1 where r1.sub_contractor_id = k.sub_contractor_id and r1.customer_id = k.customer_id  and r1.pattern_id = k1.pattern_id and r1.floor_stock_date <= '" .$srch_date. "'),'2024-04-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)
                  group by k.sub_contractor_id , k.customer_id , k1.pattern_id  
                  order by k.sub_contractor_id , k.customer_id , k1.pattern_id   
                ) as i on i.sub_contractor_id = a.sub_contractor_id and 
                			 i.customer_id = a.customer_id and
                			 i.pattern_id = a.pattern_id                          				   					 
                left join 
                (
                 select 
                     j.sub_contractor_id , 
                     j.customer_id, 
                     u.pattern_id,
                     sum(u.qty) as rework_in
                     from ms_rework_info as j
                     left join ms_rework_itm_info as u on u.ms_rework_id = j.ms_rework_id
                     where j.`status` = 'Active' and u.`status` ='Active'
                     and j.rework_type = 'Inward'
                     and j.rework_date between ifnull((select max(r1.floor_stock_date) from ms_floor_stock_info as r1 where r1.sub_contractor_id = j.sub_contractor_id and r1.customer_id = j.customer_id  and r1.pattern_id = u.pattern_id and r1.floor_stock_date <= '" .$srch_date. "'),'2024-04-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)
                     group by  j.sub_contractor_id , j.customer_id, u.pattern_id
                     order by  j.sub_contractor_id , j.customer_id, u.pattern_id 
                ) as r on r.sub_contractor_id = a.sub_contractor_id and 
                			 r.customer_id = a.customer_id and
                			 r.pattern_id = a.pattern_id  
                left join 
                (
                 select
                     j.rework_date,
                     j.sub_contractor_id , 
                     j.customer_id, 
                     u.pattern_id,
                     sum(u.qty) as rework_out
                     from ms_rework_info as j
                     left join ms_rework_itm_info as u on u.ms_rework_id = j.ms_rework_id
                     where j.`status` = 'Active' and u.`status` ='Active'
                     and j.rework_type = 'Outward'
                     and j.rework_date between ifnull((select max(r1.floor_stock_date) from ms_floor_stock_info as r1 where r1.sub_contractor_id = j.sub_contractor_id and r1.customer_id = j.customer_id  and r1.pattern_id = u.pattern_id and r1.floor_stock_date <= '" .$srch_date. "'),'2024-04-01') and DATE_SUB('" .$srch_date. "',INTERVAL 1 day)
                     group by  j.sub_contractor_id , j.customer_id, u.pattern_id
                     order by  j.sub_contractor_id , j.customer_id, u.pattern_id 
                ) as v on v.sub_contractor_id = a.sub_contractor_id and 
                			 v.customer_id = a.customer_id and
                			 v.pattern_id = a.pattern_id  						 
                						 			        
                				        
                where 1=1
               "; 
                        
               if(!empty($srch_customer_id) ){
                    $op_sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                }
               if(!empty($srch_pattern_id) ){
                  $op_sql.=" and a.pattern_id = '". $srch_pattern_id ."'";
                }   
               if(!empty($srch_sub_contractor_id) ){
                  $op_sql.=" and a.sub_contractor_id = '". $srch_sub_contractor_id ."'  ";
                } 
                   
               $op_sql .="  
                group by a.sub_contractor_id, a.customer_id, a.pattern_id 
                order by c.company_name ,d.company_name ,e.pattern_item 
             ";  
             
              
            
            /* echo "<pre>";
             print_r($op_sql);
             echo "<pre>";*/
			
		     	
		
            $query = $this->db->query($op_sql); 
            
            $data['op_stock_list'] = array();
            
            foreach ($query->result_array() as $row)
            {
                 $data['op_stock_list'][$row['customer']][$row['pattern_item']]= $row['op_qty']; 
                  
            }
            
            
             
            
            $sql = "
            select
            c.company_name as sub_contractor,
            d.company_name as customer,
            e.pattern_item as pattern_item,
            DATE_FORMAT(t.e_date,'%d-%m-%Y') as e_date,
            sum(t.inward_qty) as inward_qty,
            sum(t.intl_rej_qty) as intl_rej_qty,
            sum(t.despatch_qty) as despatch_qty ,            
            sum(t.rework_in) as rework_in,             
            sum(t.rework_out) as rework_out             
            from
            (
             (
                select  
                z1.machining_sub_contractor_id as sub_contractor_id,
                z.customer_id,
                z1.pattern_id,
                z.despatch_date as e_date,
                sum(z1.qty) as inward_qty, 
                0 as intl_rej_qty,
                0 as despatch_qty,
                0 as rework_in,
                0 as rework_out
                from customer_despatch_info as z
                left join customer_despatch_item_info as z1 on z1.customer_despatch_id = z.customer_despatch_id
                where z.status='Active' and z1.status='Active' and z.dc_type='Processing'
                and z.despatch_date between '". $srch_date."' and '". $srch_to_date."'";
                if(!empty($srch_customer_id) ){
                    $sql.=" and z.customer_id = '". $srch_customer_id ."'"; 
                }
                if(!empty($srch_pattern_id) ){
                    $sql.=" and z1.pattern_id = '". $srch_pattern_id ."'"; 
                }
                if(!empty($srch_sub_contractor_id) ){
                    $sql.=" and z1.machining_sub_contractor_id = '". $srch_sub_contractor_id ."'"; 
                }
            $sql.=" group by z1.machining_sub_contractor_id,z.customer_id,z1.pattern_id,z.despatch_date
                order by z1.machining_sub_contractor_id,z.customer_id,z1.pattern_id,z.despatch_date
            ) union all (
                select 
            	p.sub_contractor_id , 
            	p.customer_id , 
            	p1.pattern_id , 
            	p.rej_date as e_date,
                0 as inward_qty,
            	sum(p1.qty) as intl_rej_qty ,
                0 as despatch_qty,
                0 as rework_in,
                0 as rework_out
            	from customer_rejection_info as p
            	left join customer_rejection_itm_info as p1 on p1.customer_rejection_id = p.customer_rejection_id
            	where p.status='Active' and p1.status='Active' and p.rej_grp = 'Machine Shop'
                and p.rej_date between '". $srch_date."' and '". $srch_to_date."'";
                if(!empty($srch_customer_id) ){
                    $sql.=" and p.customer_id = '". $srch_customer_id ."'"; 
                }
                if(!empty($srch_pattern_id) ){
                    $sql.=" and p1.pattern_id = '". $srch_pattern_id ."'"; 
                }
                if(!empty($srch_sub_contractor_id) ){
                    $sql.=" and p.sub_contractor_id = '". $srch_sub_contractor_id ."'"; 
                }
            $sql.="
            	group by p.sub_contractor_id , p.customer_id , p1.pattern_id , p.rej_date 
            	order by p.sub_contractor_id , p.customer_id , p1.pattern_id , p.rej_date
            ) union all (
                select  
                k.sub_contractor_id,
                k.customer_id, 
                k1.pattern_id,
                k.despatch_date as e_date,
                0 as inward_qty,
                0 as intl_rej_qty,
                sum(k1.qty) as despatch_qty,
                0 as rework_in,
                0 as rework_out
                from ms_despatch_info as k
                left join ms_despatch_itm_info as k1 on k1.ms_despatch_id = k.ms_despatch_id
                where k.status='Active' and k1.status='Active'  
                and k.despatch_date between '". $srch_date."' and '". $srch_to_date."'";
                if(!empty($srch_customer_id) ){
                    $sql.=" and k.customer_id = '". $srch_customer_id ."'"; 
                }
                if(!empty($srch_pattern_id) ){
                    $sql.=" and k1.pattern_id = '". $srch_pattern_id ."'"; 
                }
                if(!empty($srch_sub_contractor_id) ){
                    $sql.=" and k.sub_contractor_id = '". $srch_sub_contractor_id ."'"; 
                }
                $sql.="
                    group by k.sub_contractor_id , k.customer_id , k1.pattern_id ,k.despatch_date
                    order by k.sub_contractor_id , k.customer_id , k1.pattern_id , k.despatch_date  
              ) union all (
                select
                j.sub_contractor_id , 
                j.customer_id, 
                u.pattern_id,
                j.rework_date as e_date,
                0 as inward_qty,
                0 as intl_rej_qty,
                0 as despatch_qty,
                sum(u.qty) as rework_in,
                0 as rework_out
                from ms_rework_info as j
                left join ms_rework_itm_info as u on u.ms_rework_id = j.ms_rework_id
                where j.`status` = 'Active' and u.`status` ='Active'
                and j.rework_type = 'Inward'
                and j.rework_date between '". $srch_date."' and '". $srch_to_date."'";
                if(!empty($srch_customer_id) ){
                    $sql.=" and j.customer_id = '". $srch_customer_id ."'"; 
                }
                if(!empty($srch_pattern_id) ){
                    $sql.=" and u.pattern_id = '". $srch_pattern_id ."'"; 
                }
                if(!empty($srch_sub_contractor_id) ){
                    $sql.=" and j.sub_contractor_id = '". $srch_sub_contractor_id ."'"; 
                }
                $sql.=" 
                group by j.rework_date ,j.sub_contractor_id , j.customer_id, u.pattern_id
                order by j.rework_date , j.sub_contractor_id , j.customer_id, u.pattern_id
              ) union all (
                select
                j.sub_contractor_id , 
                j.customer_id, 
                u.pattern_id,
                j.rework_date as e_date,
                0 as inward_qty,
                0 as intl_rej_qty,
                0 as despatch_qty,
                0 as rework_in,
                sum(u.qty) as rework_out
                from ms_rework_info as j
                left join ms_rework_itm_info as u on u.ms_rework_id = j.ms_rework_id
                where j.`status` = 'Active' and u.`status` ='Active'
                and j.rework_type = 'Outward'
                and j.rework_date between '". $srch_date."' and '". $srch_to_date."'";
                if(!empty($srch_customer_id) ){
                    $sql.=" and j.customer_id = '". $srch_customer_id ."'"; 
                }
                if(!empty($srch_pattern_id) ){
                    $sql.=" and u.pattern_id = '". $srch_pattern_id ."'"; 
                }
                if(!empty($srch_sub_contractor_id) ){
                    $sql.=" and j.sub_contractor_id = '". $srch_sub_contractor_id ."'"; 
                }
                $sql.=" 
                group by j.rework_date ,j.sub_contractor_id , j.customer_id, u.pattern_id
                order by j.rework_date , j.sub_contractor_id , j.customer_id, u.pattern_id
              )
           ) as t
            left join sub_contractor_info as c on c.sub_contractor_id = t.sub_contractor_id
            left join customer_info as d on d.customer_id = t.customer_id
            left join pattern_info as e on e.pattern_id = t.pattern_id
            where 1
            group by t.sub_contractor_id, t.customer_id, t.pattern_id , t.e_date
            order by c.company_name ,d.company_name ,e.pattern_item 
            ";
            
            $query = $this->db->query($sql);
            
            $data['frm_to_rec'] = array();
            
            foreach ($query->result_array() as $row)
            {
                 $data['frm_to_rec'][$row['customer']][$row['pattern_item']][$row['e_date']] = $row; 
            }
           	
             
            //echo "<pre>";
		//	print_r($data['op_stock_list']);   
			//print_r($sql);   
			//echo "</pre>"; 
            
             
             
        
         
        } else {
            $data['pattern_opt'] =array();
            
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
        
        $this->load->view('page/machineshop/ms_stock_report',$data); 
	}   
    
    public function customer_rejection_report()
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
       
       if(isset($_POST['srch_sub_contractor_id'])) { 
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->input->post('srch_sub_contractor_id');  
           $data['submit_flg'] = true;
       } 
       else { 
        $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = '';
       }
       
       if(isset($_POST['srch_dc_type'])) { 
           $data['srch_dc_type'] = $srch_dc_type = $this->input->post('srch_dc_type');  
           $data['submit_flg'] = true;
       } 
       else { 
           $data['srch_dc_type'] = $srch_dc_type = 'Delivery';
       }
       if(isset($_POST['srch_rej_grp'])) { 
           $data['srch_rej_grp'] = $srch_rej_grp = $this->input->post('srch_rej_grp');  
           $data['submit_flg'] = true;
       } 
       else { 
           $data['srch_rej_grp'] = $srch_rej_grp = 'Customer';
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
        
        $sql = "
                select 
                a.rejection_type_id, 
                a.rejection_type_name 
                from rejection_type_info as a
                where a.status='Active' and a.rejection_group = 'Customer'
                order by a.rejection_type_name asc                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['rej_opt'][$row['rejection_type_id']] =  $row['rejection_type_name']   ;     
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
                k.customer_id,
                k.sub_contractor_id,
                k1.pattern_id,
                c.company_name as customer,
                d.pattern_item as item,
                k.despatch_date,
                sum(k1.qty) as despatch_qty
                from ms_despatch_info as k
                left join ms_despatch_itm_info as k1 on k1.ms_despatch_id = k.ms_despatch_id
                left join customer_info as c on c.customer_id = k.customer_id
                left join pattern_info as d on d.pattern_id = k1.pattern_id 
                where k.status='Active' 
                and k1.status='Active' 
                and k.despatch_date between '" . $srch_date . "' and  '". $srch_to_date ."'";
                
           if(!empty($srch_customer_id) ){
              $sql.=" and k.customer_id = '". $srch_customer_id ."'"; 
           }
           if(!empty($srch_pattern_id) ){
              $sql.=" and k1.pattern_id = '". $srch_pattern_id ."'";
           }   
           if(!empty($srch_sub_contractor_id) ){
              $sql.=" and k.sub_contractor_id = '". $srch_sub_contractor_id ."'";
           }         
                
        $sql .="              
                group by k.sub_contractor_id , k.customer_id , k1.pattern_id  ,k.despatch_date
                order by k.sub_contractor_id , k.customer_id , k1.pattern_id  ,k.despatch_date
        ";

        
        
        $query = $this->db->query($sql);
        
        $data['despatch_qty'] = array();
        $data['record_info'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['despatch_qty'][$row['customer']][$row['item']][] = $row;     
            $data['record_info'][$row['customer']][$row['item']]['despatch'][] = $row;     
        }
        
        */
        
         $sql = "
                select  
                k.customer_id,
                k.sub_contractor_id,
                k1.pattern_id,
                c.company_name as customer,
                d.pattern_item as item,
                k.despatch_date,
                sum(k1.qty) as despatch_qty
                from customer_despatch_info as k
                left join customer_despatch_item_info as k1 on k1.customer_despatch_id = k.customer_despatch_id
                left join customer_info as c on c.customer_id = k.customer_id
                left join pattern_info as d on d.pattern_id = k1.pattern_id 
                where k.status='Active' 
                and k1.status='Active' 
                and k.despatch_date between '" . $srch_date . "' and  '". $srch_to_date ."'
                and k.dc_type = '" . $srch_dc_type . "'
                ";
                
           if(!empty($srch_customer_id) ){
              $sql.=" and k.customer_id = '". $srch_customer_id ."'"; 
           }
           if(!empty($srch_pattern_id) ){
              $sql.=" and k1.pattern_id = '". $srch_pattern_id ."'";
           }   
           /*if(!empty($srch_sub_contractor_id) ){
              $sql.=" and k.sub_contractor_id = '". $srch_sub_contractor_id ."'";
           }   */      
                
        $sql .="              
                group by   k.customer_id , k1.pattern_id  ,k.despatch_date
                order by   k.customer_id , k1.pattern_id  ,k.despatch_date
        ";

        
        
        $query = $this->db->query($sql);
        
       // $data['despatch_qty'] = array();
        $data['record_info'] = array();
       
        foreach ($query->result_array() as $row)
        {
            //$data['despatch_qty'][$row['customer']][$row['item']][] = $row;     
            $data['record_info'][$row['customer']][$row['item']]['despatch'][] = $row;     
        }
        
        
        $sql = "
                select 
                a.sub_contractor_id , 
                a.customer_id , 
                b.pattern_id ,  
                d.company_name as customer,
                e.pattern_item as item,
                a.rej_date,
                c.rejection_type_name as rejection_type,
                sum(b.qty) as rej_qty,
                b.remarks 
                from customer_rejection_info as a
                left join customer_rejection_itm_info as b on b.customer_rejection_id = a.customer_rejection_id
                left join rejection_type_info as c on c.rejection_type_id = b.rej_type_id
                left join customer_info as d on d.customer_id = a.customer_id
                left join pattern_info as e on e.pattern_id = b.pattern_id 
                where a.status='Active' 
                and b.status='Active'  
                and a.rej_date between '" . $srch_date . "' and  '". $srch_to_date ."'";
                
           if(!empty($srch_customer_id) ){
              $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
           }
           if(!empty($srch_pattern_id) ){
              $sql.=" and b.pattern_id = '". $srch_pattern_id ."'";
           }   
           if(!empty($srch_rej_grp) ){
              $sql.=" and a.rej_grp = '". $srch_rej_grp ."' ";
           }  
           
          /* if(!empty($srch_sub_contractor_id) ){
              $sql.=" and a.sub_contractor_id = '". $srch_sub_contractor_id ."'";
           } */        
                
        $sql .="              
                
                group by a.customer_id , b.pattern_id ,a.rej_date, b.rej_type_id  
                order by a.rej_date, c.rejection_type_name  
        ";
        
        //echo $sql;
        //group by a.sub_contractor_id , a.customer_id , b.pattern_id ,a.rej_date, b.rej_type_id  
        
        
        $query = $this->db->query($sql);
        
       // $data['rej_qty'] = array();
       
        foreach ($query->result_array() as $row)
        {
            //$data['rej_qty'][$row['customer']][$row['item']][] = $row;    
            $data['record_info'][$row['customer']][$row['item']]['rej'][] = $row;  
        }
        
         
	 
             
             
        
         
        } else {
            $data['pattern_opt'] =array();
            
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
        
        $data['dc_type_opt'] =array('Processing' => 'Machineshop [Processing]','Delivery' => 'Customer[Delivery]');
        $data['rej_grp_opt'] =array('Machine Shop' => 'Machine Shop','Customer' => 'Customer');
        
        
        $this->load->view('page/machineshop/customer_rejection_report',$data); 
	} 
    
    public function rework_inward_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN ) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'machineshop/rework-inward.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'rework_date' => $this->input->post('rework_date'),
                    'sub_contractor_id' => $this->input->post('sub_contractor_id'),
                    'dc_info' => $this->input->post('dc_info'),
                    'invoice_info' => $this->input->post('invoice_info'),
                    'veh_reg_no' => $this->input->post('veh_reg_no'),
                    'customer_id' => $this->input->post('customer_id'),
                    'rework_type' => $this->input->post('rework_type'),           
                    'status' => $this->input->post('status'),   
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')  ,
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('ms_rework_info', $ins); 
            
            $ms_rework_id = $this->db->insert_id();
            
            $pattern_ids = $this->input->post('pattern_id');  
            $qtys = $this->input->post('qty');
            foreach($pattern_ids as $ind => $pattern_id)
              {
                    if(!empty($pattern_id)) {
                        $ins = array(
                                'ms_rework_id' => $ms_rework_id, 
                                'pattern_id' => $pattern_id,   
                                'qty' => $qtys[$ind] ,
                                'status' => 'Active'                                               
                        );                
                        $this->db->insert('ms_rework_itm_info', $ins); 
                      
                    }
              } 
            redirect('rework-inward-list');
        }
        
         
        
        $where = '1=1';
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
        } else {
            $data['srch_from_date'] = $srch_from_date = date('Y-m-d');
            $data['srch_to_date'] = $srch_to_date = date('Y-m-d'); 
        }
       
       
        $where = " 1=1 ";
          
        
       if(isset($_POST['srch_customer_id'])) {
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
           
       }  else { 
           $data['srch_customer_id'] = $srch_customer_id = '';
       } 
       
        if(isset($_POST['srch_pattern_id'])) {
          $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           
       }  else {
           $data['srch_pattern_id'] = $srch_pattern_id = ''; 
       } 
       
       if(isset($_POST['srch_sub_contractor_id'])) {
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->input->post('srch_sub_contractor_id');  
           $this->session->set_userdata('srch_sub_contractor_id', $this->input->post('srch_sub_contractor_id'));
       }
       elseif($this->session->userdata('srch_sub_contractor_id')){ 
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->session->userdata('srch_sub_contractor_id') ;
       } 
       else { 
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = '';
       } 
       
      if(!empty($srch_customer_id) ){
        $where.=" and a.customer_id = '". $srch_customer_id ."'"; 
      }
      if(!empty($srch_pattern_id) ){
            $where.=" and a.pattern_id = '". $srch_pattern_id ."'"; 
      }
      
        if(!empty($srch_sub_contractor_id) ){
            $where.=" and a.sub_contractor_id = '". $srch_sub_contractor_id ."'"; 
        } 
        
        if(!empty($srch_from_date) ){
            $where.=" and a.rework_date between '". $srch_from_date ."' and '". $srch_to_date ."'"; 
        } 
        
        
        $this->load->library('pagination');
        
        $this->db->where('a.status != ', 'Delete');
        $this->db->where("a.rework_type = 'Inward'");
        $this->db->where($where);
        $this->db->from('ms_rework_info as a');
        $data['total_records'] = $cnt  = $this->db->count_all_results();
        
        $data['sno'] = $this->uri->segment(2, 0);	
        	
        $config['base_url'] = trim(site_url('rework-inward-list/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 50;
        $config['uri_segment'] = 2;
        //$config['num_links'] = 2; 
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
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
        
        // a.status = 'Active'
        
        $sql = "
                select 
                a.*, 
                c.company_name as customer, 
                b.company_name as sub_contractor 
                from ms_rework_info as a   
                left join sub_contractor_info as b on b.sub_contractor_id = a.sub_contractor_id 
                left join customer_info as c on c.customer_id = a.customer_id 
                where a.status != 'Delete' and a.rework_type = 'Inward'
                and $where
                order by a.rework_date desc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
      
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
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
        $data['customer_opt'] = array();
        $data['pattern_opt'] = array();
       
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
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/machineshop/rework-inward-list',$data); 
	}
    
    public function rework_in_out_edit($ms_rework_id)
	{
	   if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        date_default_timezone_set("Asia/Calcutta");  
     
        
	    $data = array(); 
        
        
        $data['js'] = 'machineshop/rework-in-out-edit.inc';  
        
        if($this->input->post('mode') == 'Edit')
        {
             
           $upd = array(
                    'rework_date' => $this->input->post('rework_date'),
                    'sub_contractor_id' => $this->input->post('sub_contractor_id'),
                    'dc_info' => $this->input->post('dc_info'),
                    'invoice_info' => $this->input->post('invoice_info'),
                    'veh_reg_no' => $this->input->post('veh_reg_no'),
                    'customer_id' => $this->input->post('customer_id'),
                    'rework_type' => $this->input->post('rework_type'),           
                    'status' => $this->input->post('status'),  
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                                       
            );
            
            $this->db->where('ms_rework_id', $this->input->post('ms_rework_id'));
            $this->db->update('ms_rework_info', $upd); 
            
            
            $ms_rework_itm_ids = $this->input->post('ms_rework_itm_id'); 
            $pattern_ids = $this->input->post('pattern_id');  
            $qtys = $this->input->post('qty');
            foreach($ms_rework_itm_ids as $ind => $ms_rework_itm_id)
              {
                    if(empty($ms_rework_itm_id)) {
                       if((!empty($pattern_ids[$ind]))){
                            $ins = array(
                                    'ms_rework_id' => $this->input->post('ms_rework_id'), 
                                    'pattern_id' => $pattern_ids[$ind],  
                                    'qty' => $qtys[$ind] ,
                                    'status' => 'Active'                                               
                            );    
                            
                                          
                            $this->db->insert('ms_rework_itm_info', $ins);  
                        }
                    } else {
                        $upd_itm = array(
                                'pattern_id' => $pattern_ids[$ind],     
                                'qty' => $qtys[$ind] ,                                               
                        );   
                        $this->db->where('ms_rework_itm_id', $ms_rework_itm_id);
                        $this->db->update('ms_rework_itm_info', $upd_itm);              
                    }  
              } 
		  
          if($this->input->post('rework_type') == 'Inward')  
            redirect('rework-inward-list');
          else  
            redirect('rework-outward-list');
        }
         
            
        $sql = "
                select 
                a.* 
                from ms_rework_info as a
                where a.ms_rework_id = '". $ms_rework_id. "'  
                order by a.ms_rework_id desc                  
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'] = $row;     
            $data['rework_type'] = $row['rework_type'];     
        }   
        
        $sql = "
                select 
                a.* ,
                b.pattern_item
                from ms_rework_itm_info as a
                left join pattern_info as b on b.pattern_id = a.pattern_id 
                where a.ms_rework_id = '". $ms_rework_id. "'  
                order by a.ms_rework_itm_id asc                   
        ";
         
        $query = $this->db->query($sql);
        
        
        foreach ($query->result_array() as $row)
        {
            $data['record_list']['itm'][] = $row;     
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
        $data['customer_opt'] = array();
         
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] =  $row['company']   ;     
        }
        
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $data['record_list']['customer_id'] ."' , a.customer_id)  
                order by a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql); 
        $data['pattern_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] =  $row['pattern_item']   ;     
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
         
        
	    $this->load->view('page/machineshop/rework-in-out-edit',$data); 	
	} 
    
    
     public function rework_outward_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN ) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'machineshop/rework-inward.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'rework_date' => $this->input->post('rework_date'),
                    'sub_contractor_id' => $this->input->post('sub_contractor_id'),
                    'dc_info' => $this->input->post('dc_info'),
                    'invoice_info' => $this->input->post('invoice_info'),
                    'veh_reg_no' => $this->input->post('veh_reg_no'),
                    'customer_id' => $this->input->post('customer_id'),
                    'rework_type' => $this->input->post('rework_type'),           
                    'status' => $this->input->post('status'),   
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')  ,
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('ms_rework_info', $ins); 
            
            $ms_rework_id = $this->db->insert_id();
            
            $pattern_ids = $this->input->post('pattern_id');  
            $qtys = $this->input->post('qty');
            foreach($pattern_ids as $ind => $pattern_id)
              {
                    if(!empty($pattern_id)) {
                        $ins = array(
                                'ms_rework_id' => $ms_rework_id, 
                                'pattern_id' => $pattern_id,   
                                'qty' => $qtys[$ind] ,
                                'status' => 'Active'                                               
                        );                
                        $this->db->insert('ms_rework_itm_info', $ins); 
                      
                    }
              } 
            redirect('rework-outward-list');
        }
        
         
        
        $where = '1=1';
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
        } else {
            $data['srch_from_date'] = $srch_from_date = date('Y-m-d');
            $data['srch_to_date'] = $srch_to_date = date('Y-m-d'); 
        }
       
       
         
          
        
       if(isset($_POST['srch_customer_id'])) {
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id');  
           
       }  else { 
           $data['srch_customer_id'] = $srch_customer_id = '';
       } 
       
        if(isset($_POST['srch_pattern_id'])) {
          $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           
       }  else {
           $data['srch_pattern_id'] = $srch_pattern_id = ''; 
       } 
       
       if(isset($_POST['srch_sub_contractor_id'])) {
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->input->post('srch_sub_contractor_id');  
           $this->session->set_userdata('srch_sub_contractor_id', $this->input->post('srch_sub_contractor_id'));
       }
       elseif($this->session->userdata('srch_sub_contractor_id')){ 
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = $this->session->userdata('srch_sub_contractor_id') ;
       } 
       else { 
           $data['srch_sub_contractor_id'] = $srch_sub_contractor_id = '';
       } 
       
      if(!empty($srch_customer_id) ){
        $where.=" and a.customer_id = '". $srch_customer_id ."'"; 
      }
      if(!empty($srch_pattern_id) ){
            $where.=" and a.pattern_id = '". $srch_pattern_id ."'"; 
      }
      
        if(!empty($srch_sub_contractor_id) ){
            $where.=" and a.sub_contractor_id = '". $srch_sub_contractor_id ."'"; 
        } 
        
        if(!empty($srch_from_date) ){
            $where.=" and a.rework_date between '". $srch_from_date ."' and '". $srch_to_date ."'"; 
        } 
        
        
        $this->load->library('pagination');
        
        $this->db->where('a.status != ', 'Delete');
        $this->db->where("a.rework_type = 'Outward'");
        $this->db->where($where);
        $this->db->from('ms_rework_info as a');
        $data['total_records'] = $cnt  = $this->db->count_all_results();
        
        $data['sno'] = $this->uri->segment(2, 0);	
        	
        $config['base_url'] = trim(site_url('rework-outward-list/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 50;
        $config['uri_segment'] = 2;
        //$config['num_links'] = 2; 
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
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
        
        // a.status = 'Active'
        
        $sql = "
                select 
                a.*, 
                c.company_name as customer, 
                b.company_name as sub_contractor 
                from ms_rework_info as a   
                left join sub_contractor_info as b on b.sub_contractor_id = a.sub_contractor_id 
                left join customer_info as c on c.customer_id = a.customer_id 
                where a.status != 'Delete' and a.rework_type = 'Outward'
                and $where
                order by a.rework_date desc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
      
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
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
        $data['customer_opt'] = array();
        $data['pattern_opt'] = array();
       
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
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/machineshop/rework-outward-list',$data); 
	}
     

}
?>