<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

 
	public function index()
	{
		 
	}
    
     
    public function create_booking()
	{
	     if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'create-booking.inc';  
        
        $sql = "
                select 
                a.state_name,                
                a.state_code             
                from crit_states_info as a  
                where status = 'Active' 
                order by a.state_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state_code']] = $row['state_name']. ' [ ' . $row['state_code'] . ' ]';     
        }
        
        $sql = "
                select 
                a.carrier_id,                
                a.carrier_name             
                from crit_carrier_info as a  
                where status = 'Active' 
                order by a.carrier_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['carrier_opt'][$row['carrier_id']] = $row['carrier_name'] ;     
        }
        
        $sql = "
                select 
                a.service_id,                
                a.service_name             
                from crit_service_info as a  
                where status = 'Active' 
                order by a.service_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['service_opt'][$row['service_id']] = $row['service_name'] ;     
        }
        
        $sql = "
                select 
                a.package_type_id,                
                a.package_type_name             
                from crit_package_type_info as a  
                where status = 'Active' 
                order by a.package_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['package_type_opt'][$row['package_type_id']] = $row['package_type_name'] ;     
        }
        
        $sql = "
                select 
                a.product_type_id,                
                a.product_type_name             
                from crit_product_type_info as a  
                where status = 'Active' 
                order by a.product_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['product_type_opt'][$row['product_type_id']] = $row['product_type_name'] ;     
        }
        
        $sql = "
                select                 
                a.commodity_type_name             
                from crit_commodity_type_info as a  
                where status = 'Active' 
                order by a.commodity_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['commodity_type_opt'][$row['commodity_type_name']] = $row['commodity_type_name'] ;     
        }
        
        $sql = "
                select 
                a.customer_id,                
                a.company ,
                a.contact_person,
                a.customer_code            
                from crit_customer_info as a  
                where status = 'Active' 
                order by a.company , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['customer_code'] . ':' . $row['company']. ' - ' . $row['contact_person']  ;     
        }
        
           
		 $this->load->view('page/create-booking',$data); 
	}
    
    public function in_scan()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        if(($this->input->post('mode') == 'Add') && ($this->input->post('btn_inscan') == 'Single'))
        {
            $ins = array(
                        'awbno' => $this->input->post('awbno'),
                        'booking_date' => $this->input->post('booking_date'),
                        'booking_time' => date('H:i:s' , strtotime($this->input->post('booking_time'))),
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s') , 
                        'status' => 'In-Scan'                                              
                );                
          $this->db->insert('crit_booking_info', $ins);
          redirect('in-scan'); 
          //print_r($ins);
          //echo date('H:i:s' , strtotime($this->input->post('booking_time')));
        }
        
        if(($this->input->post('mode') == 'Add') && ($this->input->post('btn_inscan') == 'Multiple'))
        {
            $awbs = explode(',',$this->input->post('awbno'));
            foreach($awbs as $k => $awbno) {
                $ins  = array(
                        'awbno' => str_replace(array("\r", "\n"), '', $awbno),
                        'booking_date' => $this->input->post('booking_date'),
                        'booking_time' => date('H:i:s' , strtotime($this->input->post('booking_time'))),
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s') , 
                        'status' => 'Booked'                                              
                );                
                $this->db->insert('crit_booking_info', $ins);
              /*echo "<pre>";
              print_r($ins);
              echo "</pre>";*/
          }
         
          redirect('in-scan'); 
           
        }
        
        $data['js'] = 'in-scan.inc';  
        $this->load->view('page/in-scan',$data); 
    } 
    
    
    public function in_scan_entry()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                        'awbno' => $this->input->post('awbno'),
                        'booking_date' => $this->input->post('booking_date'),
                        'booking_time' => $this->input->post('booking_time'),
                        'origin_pincode' => $this->input->post('origin_pincode'),
                        'origin_state_code' => $this->input->post('origin_state_code'),
                        'origin_city_code' => $this->input->post('origin_city_code'),                       
                        'dest_pincode' => $this->input->post('dest_pincode'),                       
                        'dest_state_code' => $this->input->post('dest_state_code'),                       
                        'dest_city_code' => $this->input->post('dest_city_code') ,
                        'no_of_pieces' => $this->input->post('no_of_pieces') ,
                        'weight' => $this->input->post('weight') ,
                        'length' => $this->input->post('length') ,
                        'width' => $this->input->post('width') ,
                        'height' => $this->input->post('height') ,
                        'chargable_opt' => $this->input->post('chargable_opt') ,
                        'chargable_weight' => $this->input->post('chargable_weight') ,
                        'consignor_code' => $this->input->post('consignor_code') ,
                        'consignor_id' => $this->input->post('consignor_id') ,
                        'sender_company' => $this->input->post('sender_company') ,
                        'sender_name' => $this->input->post('sender_name') ,
                        'sender_mobile' => $this->input->post('sender_mobile') ,
                        'sender_address' => $this->input->post('sender_address') ,
                        //'sender_state_code' => $this->input->post('sender_state_code') ,
                        'consignee_code' => $this->input->post('consignee_code') ,
                        'consignee_id' => $this->input->post('consignee_id'),
                        'receiver_company' => $this->input->post('receiver_company') ,
                        'receiver_name' => $this->input->post('receiver_name') ,
                        'receiver_mobile' => $this->input->post('receiver_mobile') ,
                        'receiver_address' => $this->input->post('receiver_address') ,
                        
                        'carrier_id' => $this->input->post('carrier_id'),
                        'service_id' => $this->input->post('service_id'),
                        'package_type_id' => $this->input->post('package_type_id'),
                        'product_type_id' => $this->input->post('product_type_id'),
                        'to_pay' => $this->input->post('to_pay'),
                        'cod' => $this->input->post('cod'),
                        'cod_amount' => $this->input->post('cod_amount'),
                        'commodity_type' => $this->input->post('commodity_type'),
                        'commodity_invoice_value' => $this->input->post('commodity_invoice_value'),
                        'description' => $this->input->post('description'),
                        'is_manual_rate' => $this->input->post('is_manual_rate'),
                        'rate' => $this->input->post('rate'),
                        'cod_charges' => $this->input->post('cod_charges'),
                        'fuel_charges' => $this->input->post('fuel_charges'),
                        'sub_total' => $this->input->post('sub_total'),
                        'tax_percentage' => $this->input->post('tax_percentage'),
                        'tax_amt' => $this->input->post('tax_amt'),
                        'grand_total' => $this->input->post('grand_total'),
                        'payment_mode' => $this->input->post('payment_mode'),
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s') , 
                        'status' => 'Booked' ,                                             
                        'status_city_code' => $this->input->post('origin_city_code')                                              
                );                
          $this->db->insert('crit_booking_info', $ins);
          
          redirect('in-scan-entry');   
          
                 
        }
        	    
        $data['js'] = 'in-scan.inc';  
        
       
        
        $sql = "
                select 
                a.state_name,                
                a.state_code             
                from crit_states_info as a  
                where status = 'Active' 
                order by a.state_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state_code']] = $row['state_name']. ' [ ' . $row['state_code'] . ' ]';     
        }
        
        $sql = "
                select 
                a.carrier_id,                
                a.carrier_name             
                from crit_carrier_info as a  
                where status = 'Active' 
                order by a.carrier_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['carrier_opt'][$row['carrier_id']] = $row['carrier_name'] ;     
        }
        
        $sql = "
                select 
                a.service_id,                
                a.service_name             
                from crit_service_info as a  
                where status = 'Active' 
                order by a.service_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['service_opt'][$row['service_id']] = $row['service_name'] ;     
        }
        
        $sql = "
                select 
                a.package_type_id,                
                a.package_type_name             
                from crit_package_type_info as a  
                where status = 'Active' 
                order by a.package_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['package_type_opt'][$row['package_type_id']] = $row['package_type_name'] ;     
        }
        
        $sql = "
                select 
                a.product_type_id,                
                a.product_type_name             
                from crit_product_type_info as a  
                where status = 'Active' 
                order by a.product_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['product_type_opt'][$row['product_type_id']] = $row['product_type_name'] ;     
        }
        
        $sql = "
                select                 
                a.commodity_type_name             
                from crit_commodity_type_info as a  
                where status = 'Active' 
                order by a.commodity_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['commodity_type_opt'][$row['commodity_type_name']] = $row['commodity_type_name'] ;     
        }
        
        $sql = "
                select 
                a.customer_id,                
                a.company ,
                a.contact_person,
                a.customer_code            
                from crit_customer_info as a  
                where status = 'Active' 
                order by a.company , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['customer_code'] . ':' . $row['company']. ' - ' . $row['contact_person']  ;     
        }
           
		 $this->load->view('page/in-scan-entry',$data); 
	}
    
    public function in_scan_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = '';   
         
        
        $this->load->library('pagination');
        
       
        
        
       // $this->db->where('status != ', 'Delete'); 
        $this->db->from('crit_booking_info');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('in-scan-list/'), '/'. $this->uri->segment(2, 0));
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
                a.booking_id,
                a.awbno,                
                a.booking_date,                
                a.booking_time,                
                a.origin_pincode,                
                a.origin_state_code,                
                a.origin_city_code,                
                a.dest_pincode,                
                a.dest_state_code,                
                a.dest_city_code,                
                a.status,
                a.status_city_code
                from crit_booking_info as a 
                where status != 'Delete'
                order by a.booking_date desc, a.booking_time desc , a.awbno desc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/in-scan-list',$data); 
	} 
    
    public function in_scan_edit($booking_id)
	{
	     if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                        'awbno' => $this->input->post('awbno'),
                        'booking_date' => $this->input->post('booking_date'),
                        'booking_time' => $this->input->post('booking_time'),
                        'customer_ref_no' => $this->input->post('customer_ref_no'),
                        'origin_pincode' => $this->input->post('origin_pincode'),
                        'origin_state_code' => $this->input->post('origin_state_code'),
                        'origin_city_code' => $this->input->post('origin_city_code'),                       
                        'dest_pincode' => $this->input->post('dest_pincode'),                       
                        'dest_state_code' => $this->input->post('dest_state_code'),                       
                        'dest_city_code' => $this->input->post('dest_city_code') ,
                        'no_of_pieces' => $this->input->post('no_of_pieces') ,
                        'weight' => $this->input->post('weight') ,
                        'length' => $this->input->post('length') ,
                        'width' => $this->input->post('width') ,
                        'height' => $this->input->post('height') ,
                        'chargable_opt' => $this->input->post('chargable_opt') ,
                        'chargable_weight' => $this->input->post('chargable_weight') ,
                        'consignor_code' => $this->input->post('consignor_code') ,
                        'consignor_id' => $this->input->post('consignor_id') ,
                        'sender_company' => $this->input->post('sender_company') ,
                        'sender_name' => $this->input->post('sender_name') ,
                        'sender_mobile' => $this->input->post('sender_mobile') ,
                        'sender_address' => $this->input->post('sender_address') ,
                        //'sender_state_code' => $this->input->post('sender_state_code') ,
                        
                        'consignee_code' => $this->input->post('consignee_code') ,
                        'consignee_id' => $this->input->post('consignee_id'),
                        'receiver_company' => $this->input->post('receiver_company') ,
                        'receiver_name' => $this->input->post('receiver_name') ,
                        'receiver_mobile' => $this->input->post('receiver_mobile') ,
                        'receiver_address' => $this->input->post('receiver_address') ,
                        
                        'carrier_id' => $this->input->post('carrier_id'),
                        'service_id' => $this->input->post('service_id'),
                        'package_type_id' => $this->input->post('package_type_id'),
                        'product_type_id' => $this->input->post('product_type_id'),
                        'to_pay' => $this->input->post('to_pay'),
                        'cod' => $this->input->post('cod'),
                        'cod_amount' => $this->input->post('cod_amount'),
                        'commodity_type' => $this->input->post('commodity_type'),
                        'commodity_invoice_value' => $this->input->post('commodity_invoice_value'),
                        'description' => $this->input->post('description'),
                        'rate' => $this->input->post('rate'),
                        'cod_charges' => $this->input->post('cod_charges'),
                        'fuel_charges' => $this->input->post('fuel_charges'),
                        'sub_total' => $this->input->post('sub_total'),
                        'tax_percentage' => $this->input->post('tax_percentage'),
                        'tax_amt' => $this->input->post('tax_amt'),
                        'grand_total' => $this->input->post('grand_total'),
                        'payment_mode' => $this->input->post('payment_mode'),
                        'status_city_code' => $this->input->post('origin_city_code'),
                        //'created_by' => $this->session->userdata('cr_user_id'),                          
                        //'created_datetime' => date('Y-m-d H:i:s') , 
                        //'status' => 'Booked'                                              
                );   
          
          $this->db->where('booking_id', $this->input->post('booking_id'));             
          $this->db->update('crit_booking_info', $upd);
          
          redirect('in-scan-list');   
          
                 
        }
        	    
        $data['js'] = 'in-scan-edit.inc';  
        
        $sql = "
                select 
                a.state_name,                
                a.state_code             
                from crit_states_info as a  
                where status = 'Active' 
                order by a.state_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state_code']] = $row['state_name']. ' [ ' . $row['state_code'] . ' ]';     
        }
        
        $sql = "
                select 
                a.carrier_id,                
                a.carrier_name             
                from crit_carrier_info as a  
                where status = 'Active' 
                order by a.carrier_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['carrier_opt'][$row['carrier_id']] = $row['carrier_name'] ;     
        }
        
        $sql = "
                select 
                a.service_id,                
                a.service_name             
                from crit_service_info as a  
                where status = 'Active' 
                order by a.service_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['service_opt'][$row['service_id']] = $row['service_name'] ;     
        }
        
        $sql = "
                select 
                a.package_type_id,                
                a.package_type_name             
                from crit_package_type_info as a  
                where status = 'Active' 
                order by a.package_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['package_type_opt'][$row['package_type_id']] = $row['package_type_name'] ;     
        }
        
        $sql = "
                select 
                a.product_type_id,                
                a.product_type_name             
                from crit_product_type_info as a  
                where status = 'Active' 
                order by a.product_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['product_type_opt'][$row['product_type_id']] = $row['product_type_name'] ;     
        }
        
        $sql = "
                select 
                a.customer_id,                
                a.company ,
                a.contact_person,
                a.customer_code            
                from crit_customer_info as a  
                where status = 'Active' 
                order by a.company , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['customer_code'] . ':' . $row['company']. ' - ' . $row['contact_person']  ;     
        }
        
        $sql = "
                select                 
                a.commodity_type_name             
                from crit_commodity_type_info as a  
                where status = 'Active' 
                order by a.commodity_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['commodity_type_opt'][$row['commodity_type_name']] = $row['commodity_type_name'] ;     
        }
        
        
        $sql = "
                select 
                a.booking_id,
                a.awbno,                
                a.booking_date, 
                TIME_FORMAT(a.booking_time,'%h:%i %p') as booking_time,  
                a.customer_ref_no,
                a.origin_pincode,                
                a.origin_state_code,                
                a.origin_city_code,                
                a.dest_pincode,                
                a.dest_state_code,                
                a.dest_city_code,                
                a.status,
                a.no_of_pieces, 
                a.weight, 
                a.length, 
                a.width, 
                a.height, 
                consignor_code, 
                consignor_id, 
                sender_company, 
                sender_name, 
                sender_mobile, 
                sender_address, 
                sender_state_code, 
                sender_city_code, 
                sender_pincode, 
                consignee_code, 
                consignee_id, 
                receiver_company, 
                receiver_name, 
                receiver_mobile, 
                receiver_address, 
                receiver_state_code, 
                receiver_city_code, 
                receiver_pincode, 
                carrier_id, 
                service_id, 
                package_type_id, 
                product_type_id, 
                to_pay, 
                cod, 
                cod_amount, 
                commodity_type, 
                commodity_invoice_value, 
                description, 
                is_manual_rate,
                rate, 
                cod_charges, 
                fuel_charges, 
                sub_total, 
                tax_percentage, 
                tax_amt, 
                grand_total ,
                a.payment_mode,
                chargable_opt,
                chargable_weight,
                status
                from crit_booking_info as a 
                where status != 'Delete' and a.booking_id = '". $booking_id."'
                order by a.awbno desc 
                            
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
        
        $cnt = $query->num_rows();
        if($cnt == 0){
            redirect('in-scan-list');
        }
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_edit'] = $row;     
        }
           
		 $this->load->view('page/in-scan-edit',$data); 
	}
    
    public function open_manifest()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        //$data['record_list'] = array();
        $data['submit_flg'] = false;
        
        if($this->input->post('btn_inscan') == 'Open Manifest  ')
        {
           $ins = array(
                        'manifest_no' => 000,
                        'manifest_date' => $this->input->post('manifest_date')  ,                          
                        'from_city_code' => $this->input->post('from_city_code')  ,                          
                        'to_city_code' => $this->input->post('to_city_code'),                          
                       // 'co_loader_id' => $this->input->post('co_loader_id'),                          
                       // 'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                       // 'co_loader_remarks' => $this->input->post('co_loader_remarks'),                          
                        'booking_id' => $this->input->post('awbno') ,                          
                        'm_status' => 'Despatched to HUB',  
                        'despatch_by' =>  $this->session->userdata('cr_user_id')  
                        );
           $this->db->insert('crit_manifest_info', $ins);     
           
           //print_r($ins);           
        }
        
        if($this->input->post('btn_save') == 'Save')
        { 
            $ids = $this->input->post('booking_ids');
            if(!empty($ids))
            {                  
                foreach($ids as $j => $booking_id) {
                    $upd  = array(
                            'manifest_no' => $this->input->post('manifest_no'),
                            'manifest_date' => $this->input->post('manifest_date')  ,                          
                            'from_city_code' => $this->input->post('from_city_code')  ,                          
                            'to_city_code' => $this->input->post('to_city_code'),                          
                            'co_loader_id' => $this->input->post('co_loader_id'),                          
                            'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                            'co_loader_remarks' => $this->input->post('co_loader_remarks'),  
                            'm_status' => 'Open Manifest',  
                            'despatch_by' =>  $this->session->userdata('cr_user_id')                      
                    );
                    $this->db->where('awbno' , $booking_id);
                    $this->db->update('crit_manifest_info', $upd); 
                } 
                         
                $this->db->where_in('awbno', $ids);
                $this->db->update('crit_booking_info', array('status' => 'Open Manifest', 'status_city_code' => $this->input->post('from_city_code'))); 
            }
            redirect('open-manifest');  
        } 
        
        if($this->input->post('from_city_code') != '' && $this->input->post('to_city_code') != '')
        {
             $data['submit_flg'] = true;
           
                $this->db->select('(ifnull(max(manifest_no),0) + 1) as manifest_no');
                $query = $this->db->get('crit_manifest_info');
                $row = $query->row();
                if (isset($row)) {
                    $data['manifest_no'] = $row->manifest_no;
                }  
           
            // (a.status = 'Despatched to HUB' and a.status_city_code = '". $this->input->post('to_city_code') ."')  and
            
            //and c.manifest_type = '". $this->input->post('manifest_type') ."' 
            
              $sql = "
                select 
                    c.manifest_no,
                    c.manifest_date,
                    a.booking_id,
                    c.co_loader_id,
                    d.co_loader_name,
                    c.co_loader_awb_no,
                    c.co_loader_remarks,
                    a.awbno,
                    a.origin_state_code,
                    a.origin_city_code,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description
                    from  crit_manifest_info as c  
                    left join crit_booking_info as a on c.awbno = a.awbno
                    left join crit_co_loader_info as d on d.co_loader_id = c.co_loader_id
                    where c.from_city_code = '". $this->input->post('from_city_code') ."' 
                    and c.to_city_code = '". $this->input->post('to_city_code') ."' 
                    
                    order by c.awbno asc               
             "; 
             
            $query = $this->db->query($sql); 
            
            $data['row_count'] = $query->num_rows();
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][] = $row;     
            }
        }
        
        
        
        
        $sql = "
                select 
                c.state_name as state,
                a.state_code , 
                a.branch_code ,
                a.area
                from crit_servicable_pincode_info  as a
                left join crit_states_info as c on c.state_code = a.state_code
                where a.`status` = 'Active'
                group by a.state_code , a.branch_code
                order by a.state_code , a.branch_code              
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state']][$row['branch_code']] =  ( $row['area']. ' [ ' . $row['branch_code'] . ' ]');     
        }
        
        
        /*$sql = "
                select 
                a.origin_state_code,
                a.origin_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.origin_city_code                
                order by a.origin_state_code, a.origin_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_opt'][$row['origin_city_code']] = $row['origin_state_code']. ' - ' . $row['origin_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.dest_state_code,
                a.dest_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.dest_city_code                
                order by a.dest_state_code, a.dest_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['to_city_opt'][$row['dest_city_code']] = $row['dest_state_code']. ' - ' . $row['dest_city_code'] . '';     
        }
        */
        $sql = "
                select 
                a.co_loader_id,
                a.co_loader_name 
                from crit_co_loader_info as a  
                where status = 'Active'       
                order by a.co_loader_name                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['co_loader_opt'][$row['co_loader_id']] = $row['co_loader_name'];     
        }
         
        
        $data['js'] = 'manifest.inc';  
        
        $this->load->view('page/open-manifest',$data); 
    } 
    
    
    public function receive_manifest()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        //$data['record_list'] = array();
        $data['submit_flg'] = false; 
        
        
        if($this->input->post('from_date') != '' &&  $this->input->post('to_date') != '' && $this->input->post('to_city_code') != '')
        {
             $data['submit_flg'] = true;
           
            
              $sql = "
                select 
                a.manifest_no,
                a.manifest_date,
                a.from_city_code,
                d.co_loader_name as co_loader,
                a.co_loader_awb_no,
                a.co_loader_remarks,
                count(a.awbno) as open_mf,
                e.received as received_mf,
                sum(c.no_of_pieces) as no_of_pieces,
                sum(c.weight) as tot_weight
                from crit_manifest_info as a
                left join crit_booking_info as c on c.awbno = a.awbno
                left join crit_co_loader_info as d on d.co_loader_id = a.co_loader_id
                left join ( select w.manifest_no , count(w.awbno) as received from crit_manifest_info as w where w.m_status = 'Received Manifest' group by w.manifest_no ) as e on e.manifest_no = a.manifest_no 
                where a.to_city_code = '". $this->input->post('to_city_code') ."'    
                and a.manifest_date between '". $this->input->post('from_date') ."' and '". $this->input->post('to_date') ."'
                group by a.manifest_no 
                order by a.manifest_date, a.manifest_no asc 
                              
             "; 
             
            $query = $this->db->query($sql); 
            
            $data['row_count'] = $query->num_rows();
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][] = $row;     
            }
        }
        
        
        
        
        $sql = "
                select 
                c.state_name as state,
                a.state_code , 
                a.branch_code ,
                a.area
                from crit_servicable_pincode_info  as a
                left join crit_states_info as c on c.state_code = a.state_code
                where a.`status` = 'Active'
                group by a.state_code , a.branch_code
                order by a.state_code , a.branch_code              
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state']][$row['branch_code']] =  ( $row['area']. ' [ ' . $row['branch_code'] . ' ]');     
        }
        
        
        /*$sql = "
                select 
                a.origin_state_code,
                a.origin_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.origin_city_code                
                order by a.origin_state_code, a.origin_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_opt'][$row['origin_city_code']] = $row['origin_state_code']. ' - ' . $row['origin_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.dest_state_code,
                a.dest_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.dest_city_code                
                order by a.dest_state_code, a.dest_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['to_city_opt'][$row['dest_city_code']] = $row['dest_state_code']. ' - ' . $row['dest_city_code'] . '';     
        }
        */
        $sql = "
                select 
                a.co_loader_id,
                a.co_loader_name 
                from crit_co_loader_info as a  
                where status = 'Active'       
                order by a.co_loader_name                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['co_loader_opt'][$row['co_loader_id']] = $row['co_loader_name'];     
        }
         
        
        $data['js'] = 'manifest.inc';  
        
        $this->load->view('page/receive-manifest',$data); 
    } 
    
    public function delivery_runsheet()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        //$data['record_list'] = array();
        
        if($this->input->post('btn_save') == 'Save')
        { 
            $ids = $this->input->post('booking_ids');
            if(!empty($ids))
            {
                $this->db->select('(ifnull(max(drs_no),0) + 1) as drs_no');
                $query = $this->db->get('crit_drs_info');
                $row = $query->row();
                if (isset($row)) {
                    $drs_no = $row->drs_no;
                }
                 
                foreach($ids as $j => $awbno)
                $ins[] = array(
                        'drs_no' => $drs_no,
                        'drs_date' => $this->input->post('runsheet_date')  ,                          
                        'drs_time' => date('H:i:s' , strtotime($this->input->post('runsheet_time'))) ,                          
                        'branch_city_code' => $this->input->post('branch_city_code'), 
                        'awbno' => $awbno ,                          
                        'delivery_by' => $this->input->post('delivery_by'),                          
                        'drs_status' => 'Out for Delivery',  
                        'drs_created_by' =>  $this->session->userdata('cr_user_id')                      
                );
                $this->db->insert_batch('crit_drs_info', $ins); 
                
                // Changed status 'Booked' to 'Despatched to HUB'            
                $this->db->where_in('awbno', $ids);
                $this->db->update('crit_booking_info', array('status' => 'Out for Delivery', 'status_city_code' => $this->input->post('branch_city_code'))); 
            }
            redirect('delivery-runsheet');  
        } 
        
        
        $data['submit_flg'] = false; 
        
        
        if( $this->input->post('branch_city_code') != '')
        {
             $data['submit_flg'] = true; 
            
             $sql = "
                select 
                a.awbno, 
                a.origin_state_code,
                a.origin_city_code,
                a.no_of_pieces,
                a.weight, 
                a.dest_pincode,
                a.receiver_name,
                a.receiver_mobile,
                a.receiver_address,
                ifnull(a.cod,0) as cod,
                a.cod_amount,
                ifnull(a.to_pay,0) as to_pay,
                a.grand_total
                from crit_booking_info  as a  
                where a.dest_city_code = '". $this->input->post('branch_city_code') ."' 
                and a.`status` = 'Received Manifest'
                and a.status_city_code  = '". $this->input->post('branch_city_code') ."' 
                order by a.dest_pincode asc 
                              
             "; 
             
            $query = $this->db->query($sql); 
            
            $data['row_count'] = $query->num_rows();
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][] = $row;     
            }
        }
        
        
        
        
        $sql = "
                select 
                c.state_name as state,
                a.state_code , 
                a.branch_code ,
                a.area
                from crit_servicable_pincode_info  as a
                left join crit_states_info as c on c.state_code = a.state_code
                where a.`status` = 'Active' 
                group by a.state_code , a.branch_code
                order by a.state_code , a.branch_code              
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state']][$row['branch_code']] =  ( $row['area']. ' [ ' . $row['branch_code'] . ' ]');     
        }
        
        
        /*$sql = "
                select 
                a.origin_state_code,
                a.origin_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.origin_city_code                
                order by a.origin_state_code, a.origin_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_opt'][$row['origin_city_code']] = $row['origin_state_code']. ' - ' . $row['origin_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.dest_state_code,
                a.dest_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.dest_city_code                
                order by a.dest_state_code, a.dest_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['to_city_opt'][$row['dest_city_code']] = $row['dest_state_code']. ' - ' . $row['dest_city_code'] . '';     
        }
        */
        $sql = "
                select 
                a.user_id,
                a.first_name 
                from crit_user_info as a  
                where status = 'Active'       
                order by a.first_name                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['delivery_by_opt'][$row['user_id']] = $row['first_name'];     
        }
         
        
        $data['js'] = 'manifest.inc';  
        
        $this->load->view('page/delivery-runsheet',$data); 
    } 
    
    public function delivery_updation()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        if(($this->input->post('btn_save') == 'delivered'))
        {
            if(($this->input->post('status') == 'Delivered'))
            {
                $config['upload_path'] = 'delivered-pod/';
        		$config['allowed_types'] = 'gif|jpg|png|jpeg';
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('pod_img'))
                {
                    $file_array = $this->upload->data();	
                    $image_path	= 'delivered-pod/'.date('YmdHis') . $file_array['file_name']; 
               
                }
                else
                {
                     $image_path = '';    
                }
                
                $upd = array(
                             'pod_img' => $image_path  ,
                             'drs_status' => $this->input->post('status'),         
                             'remarks' => $this->input->post('remarks'),         
                             'delivered_to' => $this->input->post('delivered_to'),         
                             'delivered_to_mobile' => $this->input->post('delivered_to_mobile'),  
                             'delivered_date' => $this->input->post('delivered_date'),  
                             'delivered_time' => date('H:i:s' , strtotime($this->input->post('delivered_time'))),    
                            );
            
                $this->db->where('awbno', $this->input->post('awbno'));
                $this->db->update('crit_drs_info', $upd); 
                
                $this->db->where('awbno', $this->input->post('awbno'));
                $this->db->update('crit_booking_info', array('status' => $this->input->post('status'))); 
                
                redirect('delivery-updation');
                 
            } else {
                 
                $upd = array( 
                             'drs_status' => $this->input->post('status'),         
                             'remarks' => $this->input->post('remarks'),  
                            );
            
                $this->db->where('awbno', $this->input->post('awbno'));
                $this->db->update('crit_drs_info', $upd); 
                
                $this->db->where('awbno', $this->input->post('awbno'));
                $this->db->update('crit_booking_info', array('status' => $this->input->post('status')));
                
                 $ins = array( 
                             'drs_no' => $this->input->post('drs_no'),         
                             'awbno' => $this->input->post('awbno'),         
                             'ndr_id' => $this->input->post('ndr_id'),         
                             'remarks' => $this->input->post('remarks'), 
                             'ndr_date' => $this->input->post('delivered_date'),  
                             'ndr_time' => date('H:i:s' , strtotime($this->input->post('delivered_time'))),  
                            );
                 $this->db->insert('crit_drs_ndr_info', $ins);    
                 
                 redirect('delivery-updation');        
                
            }
            
        }
        $data['sflg'] = false;
        if(($this->input->post('btn_inscan') == 'Delivery'))
        {
            $data['sflg'] = true;
            $sql = "
                select 
                a.awbno,
                c.drs_no, 
                a.origin_state_code,
                a.origin_city_code,
                a.no_of_pieces,
                a.weight, 
                a.dest_pincode,
                a.receiver_name,
                a.receiver_mobile,
                a.receiver_address,
                ifnull(a.cod,0) as cod,
                a.cod_amount,
                ifnull(a.to_pay,0) as to_pay,
                a.grand_total
                from crit_booking_info  as a  
                left join crit_drs_info as c on c.awbno = a.awbno
                where c.awbno = '". $this->input->post('awbno') ."'  
                and (a.status = 'Out For Delivery' or a.status = 'Un-Delivered')
                order by a.dest_pincode asc 
                              
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][] = $row;     
            } 
            
            
            $sql = " 
                select 
                a.ndr_date,
                a.ndr_time,
                c.ndr_code,
                c.ndr_details,
                a.remarks 
                from crit_drs_ndr_info as a
                left join crit_ndr_info as c on c.ndr_id = a.ndr_id
                where a.awbno = '". $this->input->post('awbno') ."'  
                order by a.ndr_date , a.ndr_time asc 
            "; 
            
            $query = $this->db->query($sql); 
            $data['ndr_info'] = array();
       
            foreach ($query->result_array() as $row)
            {
                $data['ndr_info'][] = $row;     
            } 
            
            
        }
        
        $sql = "
                select 
                a.ndr_id,
                a.ndr_code ,
                a.ndr_details
                from crit_ndr_info as a  
                where status = 'Active'                 
                order by a.ndr_code, a.ndr_details                
        "; 
        
        $query = $this->db->query($sql);
        
        $data['ndr_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['ndr_opt'][$row['ndr_id']] = $row['ndr_code']. ' => ' . $row['ndr_details'];     
        }
        
        
        
        $data['js'] = 'delivery.inc';  
        $this->load->view('page/delivery-updation',$data); 
    } 
    
    public function b2h_manifest()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        $data['record_list'] = array();
        
        if($this->input->post('btn_show') == 'Show AWB')
        {
             $sql = "
                select 
                    a.booking_id,
                    a.awbno,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description
                    from crit_booking_info as a  
                    where status = 'Booked' 
                    and a.origin_city_code = '". $this->input->post('from_city_code') ."' 
                    and a.dest_city_code = '". $this->input->post('to_city_code') ."' 
                    order by a.awbno asc               
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][] = $row;     
            }
        }
        
        if($this->input->post('btn_save') == 'Save')
        { 
            $ids = $this->input->post('booking_ids');
            if(!empty($ids))
            {
                $this->db->select('(ifnull(max(b2h_manifest_no),0) + 1) as b2h_manifest_no');
                $query = $this->db->get('crit_b2h_manifest_info');
                $row = $query->row();
                if (isset($row)) {
                    $b2h_manifest_no = $row->b2h_manifest_no;
                }
                 
                foreach($ids as $j => $booking_id)
                $ins[] = array(
                        'b2h_manifest_no' => $b2h_manifest_no,
                        'manifest_date' => $this->input->post('manifest_date')  ,                          
                        'from_city_code' => $this->input->post('from_city_code')  ,                          
                        'to_city_code' => $this->input->post('to_city_code'),                          
                        'co_loader_id' => $this->input->post('co_loader_id'),                          
                        'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                        'co_loader_remarks' => $this->input->post('co_loader_remarks'),                          
                        'booking_id' => $booking_id ,                          
                        'm_status' => 'Despatched to HUB',  
                        'despatch_by' =>  $this->session->userdata('cr_user_id')                      
                );
                $this->db->insert_batch('crit_b2h_manifest_info', $ins); 
                
                // Changed status 'Booked' to 'Despatched to HUB'            
                $this->db->where_in('booking_id', $ids);
                $this->db->update('crit_booking_info', array('status' => 'Despatched to HUB', 'status_city_code' => $this->input->post('from_city_code'))); 
            }
            redirect('b2h-manifest');  
        } 
        
        
        $sql = "
                select 
                a.origin_state_code,
                a.origin_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.origin_city_code                
                order by a.origin_state_code, a.origin_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_opt'][$row['origin_city_code']] = $row['origin_state_code']. ' - ' . $row['origin_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.dest_state_code,
                a.dest_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.dest_city_code                
                order by a.dest_state_code, a.dest_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['to_city_opt'][$row['dest_city_code']] = $row['dest_state_code']. ' - ' . $row['dest_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.co_loader_id,
                a.co_loader_name 
                from crit_co_loader_info as a  
                where status = 'Active'       
                order by a.co_loader_name                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['co_loader_opt'][$row['co_loader_id']] = $row['co_loader_name'];     
        }
         
        
        $data['js'] = 'manifest.inc';  
        $this->load->view('page/b2h-manifest',$data); 
    } 
    
    public function b2h_manifest_list()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        $data['record_list'] = array();
        $data['new_record_list'] = array();
        
        if($this->input->post('btn_search') == 'Search')
        {
             $sql = "
                select 
                    c.b2h_manifest_no,
                    c.manifest_date,
                    a.booking_id,
                    c.co_loader_id,
                    d.co_loader_name,
                    c.co_loader_awb_no,
                    c.co_loader_remarks,
                    a.awbno,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description
                    from crit_booking_info as a  
                    left join crit_b2h_manifest_info as c on c.booking_id = a.booking_id
                    left join crit_co_loader_info as d on d.co_loader_id = c.co_loader_id
                    where (a.status = 'Despatched to HUB' and a.status_city_code = '". $this->input->post('from_city_code') ."')  
                    and a.origin_city_code = '". $this->input->post('from_city_code') ."' 
                    and a.dest_city_code = '". $this->input->post('to_city_code') ."' 
                    order by a.awbno asc               
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][$row['b2h_manifest_no']][] = $row;     
            }
            
            $sql = "
                select 
                    a.booking_id,
                    a.awbno,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description
                    from crit_booking_info as a  
                    where status = 'Booked' 
                    and a.origin_city_code = '". $this->input->post('from_city_code') ."' 
                    and a.dest_city_code = '". $this->input->post('to_city_code') ."' 
                    order by a.awbno asc               
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['new_record_list'][] = $row;     
            }
        }
        
        if($this->input->post('btn_save') == 'Update')
        { 
            $ids = $this->input->post('booking_ids');
            /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            exit();*/
            if(!empty($ids))
            {
                 
                foreach($ids as $j => $booking_id)
                $ins[] = array(
                        'b2h_manifest_no' => $this->input->post('b2h_manifest_no'),
                        'manifest_date' => $this->input->post('manifest_date')  ,                          
                        'from_city_code' => $this->input->post('from_city_code')  ,                          
                        'to_city_code' => $this->input->post('to_city_code')  ,
                        'co_loader_id' => $this->input->post('co_loader_id'),                          
                        'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                        'co_loader_remarks' => $this->input->post('co_loader_remarks'),                           
                        'booking_id' => $booking_id ,                          
                        'm_status' => 'Despatched to HUB',  
                        'despatch_by' =>  $this->session->userdata('cr_user_id')                      
                );
                $this->db->insert_batch('crit_b2h_manifest_info', $ins); 
                
                // Changed status 'Booked' to 'Despatched to HUB'            
                $this->db->where_in('booking_id', $ids);
                $this->db->update('crit_booking_info', array('status' => 'Despatched to HUB', 'status_city_code' => $this->input->post('from_city_code')));
                 
            } else {
                // Update Co-loader Details
                $upd = array( 
                            'co_loader_id' => $this->input->post('co_loader_id'),                          
                            'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                            'co_loader_remarks' => $this->input->post('co_loader_remarks')
                            );
                
                $this->db->where('b2h_manifest_no', $this->input->post('b2h_manifest_no')); 
                $this->db->update('crit_b2h_manifest_info', $upd);
            }
            redirect('b2h-manifest-list');  
        }
        
        
        $sql = "
                select 
                a.origin_state_code,
                a.origin_city_code 
                from crit_booking_info as a  
                where status = 'Despatched to HUB' 
                group by a.origin_city_code                
                order by a.origin_state_code, a.origin_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_opt'][$row['origin_city_code']] = $row['origin_state_code']. ' - ' . $row['origin_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.dest_state_code,
                a.dest_city_code 
                from crit_booking_info as a  
                where status = 'Despatched to HUB' 
                group by a.dest_city_code                
                order by a.dest_state_code, a.dest_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['to_city_opt'][$row['dest_city_code']] = $row['dest_state_code']. ' - ' . $row['dest_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.co_loader_id,
                a.co_loader_name 
                from crit_co_loader_info as a  
                where status = 'Active'       
                order by a.co_loader_name                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['co_loader_opt'][$row['co_loader_id']] = $row['co_loader_name'];     
        }
         
        
        $data['js'] = 'manifest.inc';  
        $this->load->view('page/b2h-manifest-list',$data); 
    } 
    
    public function h2h_manifest()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        $data['record_list'] = array();
        
        if($this->input->post('btn_show') == 'Show AWB')
        {
             $sql = "
                select 
                    a.booking_id,
                    a.awbno,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description
                    from crit_booking_info as a  
                    where status = 'Booked' 
                    and a.origin_city_code = '". $this->input->post('from_city_code') ."' 
                    and a.dest_city_code = '". $this->input->post('to_city_code') ."' 
                    order by a.awbno asc               
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][] = $row;     
            }
        }
        
        if($this->input->post('btn_save') == 'Save')
        { 
            $ids = $this->input->post('booking_ids');
            if(!empty($ids))
            {
                $this->db->select('(ifnull(max(b2h_manifest_no),0) + 1) as b2h_manifest_no');
                $query = $this->db->get('crit_b2h_manifest_info');
                $row = $query->row();
                if (isset($row)) {
                    $b2h_manifest_no = $row->b2h_manifest_no;
                }
                 
                foreach($ids as $j => $booking_id)
                $ins[] = array(
                        'b2h_manifest_no' => $b2h_manifest_no,
                        'manifest_date' => $this->input->post('manifest_date')  ,                          
                        'from_city_code' => $this->input->post('from_city_code')  ,                          
                        'to_city_code' => $this->input->post('to_city_code'),                          
                        'co_loader_id' => $this->input->post('co_loader_id'),                          
                        'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                        'co_loader_remarks' => $this->input->post('co_loader_remarks'),                          
                        'booking_id' => $booking_id ,                          
                        'm_status' => 'Despatched to HUB',  
                        'despatch_by' =>  $this->session->userdata('cr_user_id')                      
                );
                $this->db->insert_batch('crit_b2h_manifest_info', $ins); 
                
                // Changed status 'Booked' to 'Despatched to HUB'            
                $this->db->where_in('booking_id', $ids);
                $this->db->update('crit_booking_info', array('status' => 'Despatched to HUB', 'status_city_code' => $this->input->post('from_city_code'))); 
            }
            redirect('b2h-manifest');  
        } 
        
        
        $sql = "
                select 
                a.origin_state_code,
                a.origin_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.origin_city_code                
                order by a.origin_state_code, a.origin_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_opt'][$row['origin_city_code']] = $row['origin_state_code']. ' - ' . $row['origin_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.dest_state_code,
                a.dest_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.dest_city_code                
                order by a.dest_state_code, a.dest_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['to_city_opt'][$row['dest_city_code']] = $row['dest_state_code']. ' - ' . $row['dest_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.co_loader_id,
                a.co_loader_name 
                from crit_co_loader_info as a  
                where status = 'Active'       
                order by a.co_loader_name                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['co_loader_opt'][$row['co_loader_id']] = $row['co_loader_name'];     
        }
         
        
        $data['js'] = 'manifest.inc';  
        $this->load->view('page/h2h-manifest',$data); 
    } 
    
    public function h2h_manifest_list()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        $data['record_list'] = array();
        $data['new_record_list'] = array();
        
        if($this->input->post('btn_search') == 'Search')
        {
             $sql = "
                select 
                    c.b2h_manifest_no,
                    c.manifest_date,
                    a.booking_id,
                    c.co_loader_id,
                    d.co_loader_name,
                    c.co_loader_awb_no,
                    c.co_loader_remarks,
                    a.awbno,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description
                    from crit_booking_info as a  
                    left join crit_b2h_manifest_info as c on c.booking_id = a.booking_id
                    left join crit_co_loader_info as d on d.co_loader_id = c.co_loader_id
                    where (a.status = 'Despatched to HUB' and a.status_city_code = '". $this->input->post('from_city_code') ."')  
                    and a.origin_city_code = '". $this->input->post('from_city_code') ."' 
                    and a.dest_city_code = '". $this->input->post('to_city_code') ."' 
                    order by a.awbno asc               
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][$row['b2h_manifest_no']][] = $row;     
            }
            
            $sql = "
                select 
                    a.booking_id,
                    a.awbno,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description
                    from crit_booking_info as a  
                    where status = 'Booked' 
                    and a.origin_city_code = '". $this->input->post('from_city_code') ."' 
                    and a.dest_city_code = '". $this->input->post('to_city_code') ."' 
                    order by a.awbno asc               
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['new_record_list'][] = $row;     
            }
        }
        
        if($this->input->post('btn_save') == 'Update')
        { 
            $ids = $this->input->post('booking_ids');
            /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            exit();*/
            if(!empty($ids))
            {
                 
                foreach($ids as $j => $booking_id)
                $ins[] = array(
                        'b2h_manifest_no' => $this->input->post('b2h_manifest_no'),
                        'manifest_date' => $this->input->post('manifest_date')  ,                          
                        'from_city_code' => $this->input->post('from_city_code')  ,                          
                        'to_city_code' => $this->input->post('to_city_code')  ,
                        'co_loader_id' => $this->input->post('co_loader_id'),                          
                        'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                        'co_loader_remarks' => $this->input->post('co_loader_remarks'),                           
                        'booking_id' => $booking_id ,                          
                        'm_status' => 'Despatched to HUB',  
                        'despatch_by' =>  $this->session->userdata('cr_user_id')                      
                );
                $this->db->insert_batch('crit_b2h_manifest_info', $ins); 
                
                // Changed status 'Booked' to 'Despatched to HUB'            
                $this->db->where_in('booking_id', $ids);
                $this->db->update('crit_booking_info', array('status' => 'Despatched to HUB', 'status_city_code' => $this->input->post('from_city_code')));
                 
            } else {
                // Update Co-loader Details
                $upd = array( 
                            'co_loader_id' => $this->input->post('co_loader_id'),                          
                            'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                            'co_loader_remarks' => $this->input->post('co_loader_remarks')
                            );
                
                $this->db->where('b2h_manifest_no', $this->input->post('b2h_manifest_no')); 
                $this->db->update('crit_b2h_manifest_info', $upd);
            }
            redirect('b2h-manifest-list');  
        }
        
        
        $sql = "
                select 
                a.origin_state_code,
                a.origin_city_code 
                from crit_booking_info as a  
                where status = 'Despatched to HUB' 
                group by a.origin_city_code                
                order by a.origin_state_code, a.origin_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_opt'][$row['origin_city_code']] = $row['origin_state_code']. ' - ' . $row['origin_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.dest_state_code,
                a.dest_city_code 
                from crit_booking_info as a  
                where status = 'Despatched to HUB' 
                group by a.dest_city_code                
                order by a.dest_state_code, a.dest_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['to_city_opt'][$row['dest_city_code']] = $row['dest_state_code']. ' - ' . $row['dest_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.co_loader_id,
                a.co_loader_name 
                from crit_co_loader_info as a  
                where status = 'Active'       
                order by a.co_loader_name                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['co_loader_opt'][$row['co_loader_id']] = $row['co_loader_name'];     
        }
         
        
        $data['js'] = 'manifest.inc';  
        $this->load->view('page/h2h-manifest-list',$data); 
    } 
    
    
}
