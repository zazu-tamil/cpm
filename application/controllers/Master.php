<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

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
    
    public function user_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('cr_is_admin') != USER_ADMIN ) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'user.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                'name' => $this->input->post('name'),
                'user_name' => $this->input->post('user_name'),
                'user_pwd' => $this->input->post('user_pwd'),
                'level' => $this->input->post('level'), 
                'status' => $this->input->post('status'),                           
            );
            
            $this->db->insert('user_login', $ins); 
            redirect('user-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                'name' => $this->input->post('name'),
                'user_name' => $this->input->post('user_name'),
                'user_pwd' => $this->input->post('user_pwd'),
                'level' => $this->input->post('level'), 
                'status' => $this->input->post('status'),                
            );
            
           // print_r($upd);
            
            $this->db->where('user_id', $this->input->post('user_id'));
            $this->db->update('user_login', $upd); 
                            
            redirect('user-list/' . $this->uri->segment(2, 0));  
        } 
        
        
         $data['user_level_opt'] = array(
                                        '1' => 'Admin',
                                        '2' => 'Moulding',
                                        '3' => 'Melting',
                                        '4' => 'Despatch',
                                        '5' => 'Purchase',
                                        '6' => 'MachineShop',
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
        $this->db->from('user_login as a');
        $data['total_records'] = $cnt  = $this->db->count_all_results();
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('user-list/'), '/'. $this->uri->segment(2, 0));
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
                 user_id,   
                 name,
                 user_name,
                 level, 
                `status`
                from user_login as a 
                where status != 'Delete'  
                order by  a.name  asc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        $data['record_list'] = array();
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/user-list',$data); 
	} 
    
    public function country_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'country.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'country_name' => $this->input->post('country_name'),
                    'status' => $this->input->post('status')  ,                          
            );
            
            $this->db->insert('crit_country_info', $ins); 
            redirect('country-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'country_name' => $this->input->post('country_name'),
                    'status' => $this->input->post('status'),                 
            );
            
            $this->db->where('country_id', $this->input->post('country_id'));
            $this->db->update('crit_country_info', $upd); 
                            
            redirect('country-list/' . $this->uri->segment(2, 0)); 
        } 
         
        
        $this->load->library('pagination');
        
       
        
        
        $this->db->where('status != ', 'Delete'); 
        $this->db->from('crit_country_info');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('country-list/'), '/'. $this->uri->segment(2, 0));
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
                a.country_id,
                a.country_name,                
                a.status
                from crit_country_info as a 
                where status != 'Delete'
                order by a.status asc , a.country_name asc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/country-list',$data); 
	} 
    
    public function state_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN ) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'state.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'state_name' => $this->input->post('state_name'),
                    'state_code' => $this->input->post('state_code'),
                    'status' => $this->input->post('status'),                           
            );
            
            $this->db->insert('crit_states_info', $ins); 
            redirect('state-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'state_name' => $this->input->post('state_name'),
                    'state_code' => $this->input->post('state_code'),    
                    'status' => $this->input->post('status'),              
            );
            
            $this->db->where('state_id', $this->input->post('state_id'));
            $this->db->update('crit_states_info', $upd); 
                            
            redirect('state-list/' . $this->uri->segment(2, 0)); 
        }
         
        
        $this->load->library('pagination');
        
        $this->db->where('status != ', 'Delete');
        $this->db->from('crit_states_info');
        $data['total_records'] = $cnt  = $this->db->count_all_results();
        
        $data['sno'] = $this->uri->segment(2, 0);	
        	
        $config['base_url'] = trim(site_url('state-list/'), '/'. $this->uri->segment(2, 0));
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
                a.state_id,
                a.state_name,                
                a.state_code,
                a.status                
                from crit_states_info as a  
                where status != 'Delete'
                order by a.state_name asc  
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/state-list',$data); 
	}
    
    
    
    public function commodity_type_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'commodity-type.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'commodity_type_name' => $this->input->post('commodity_type_name'),
                    'status' => $this->input->post('status')  ,                          
            );
            
            $this->db->insert('crit_commodity_type_info', $ins); 
            redirect('commodity-type-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'commodity_type_name' => $this->input->post('commodity_type_name'),
                    'status' => $this->input->post('status'),                 
            );
            
            $this->db->where('commodity_type_id', $this->input->post('commodity_type_id'));
            $this->db->update('crit_commodity_type_info', $upd); 
                            
            redirect('commodity-type-list/' . $this->uri->segment(2, 0)); 
        } 
         
        
        $this->load->library('pagination'); 
        
        
        $this->db->where('status != ', 'Delete'); 
        $this->db->from('crit_commodity_type_info');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('commodity-type-list/'), '/'. $this->uri->segment(2, 0));
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
                a.commodity_type_id,
                a.commodity_type_name,                
                a.status
                from crit_commodity_type_info as a 
                where status != 'Delete'
                order by a.status asc , a.commodity_type_name asc 
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
        
        $this->load->view('page/commodity-type-list',$data); 
	} 
    
    public function franchise_type_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'franchise-type.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'franchise_type_name' => $this->input->post('franchise_type_name'),
                    'status' => $this->input->post('status')  ,                          
            );
            
            $this->db->insert('crit_franchise_type_info', $ins); 
            redirect('franchise-type-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'franchise_type_name' => $this->input->post('franchise_type_name'),
                    'status' => $this->input->post('status'),               
            );
            
            $this->db->where('franchise_type_id', $this->input->post('franchise_type_id'));
            $this->db->update('crit_franchise_type_info', $upd); 
                            
            redirect('franchise-type-list/' . $this->uri->segment(2, 0)); 
        } 
         
        
        $this->load->library('pagination');
        
        
        $this->db->where('status != ', 'Delete'); 
        $this->db->from('crit_franchise_type_info');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('franchise-type-list/'), '/'. $this->uri->segment(2, 0));
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
                a.franchise_type_id,
                a.franchise_type_name,                
                a.status
                from crit_franchise_type_info as a 
                where status != 'Delete'
                order by a.status asc , a.franchise_type_name asc 
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
        
        $this->load->view('page/franchise-type-list',$data); 
	} 
    
      
    
    
    
    public function franchise_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'franchise-list.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'franchise_type_id' => $this->input->post('franchise_type_id'),
                    'contact_person' => $this->input->post('contact_person'),
                    'mobile' => $this->input->post('mobile'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'gst_no' => $this->input->post('gst_no'),
                    'address' => $this->input->post('address'),
                    'state_code' => $this->input->post('state_code'),
                    'city_code' => $this->input->post('city_code'),
                    'servicable_pincode' => implode(',',$this->input->post('servicable_pincode')),
                    'status' => $this->input->post('status'),
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('crit_franchise_info', $ins); 
            redirect('franchise-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'franchise_type_id' => $this->input->post('franchise_type_id'),
                    'contact_person' => $this->input->post('contact_person'),
                    'mobile' => $this->input->post('mobile'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'gst_no' => $this->input->post('gst_no'),
                    'address' => $this->input->post('address'),
                    'state_code' => $this->input->post('state_code'),
                    'city_code' => $this->input->post('city_code'),
                    'servicable_pincode' => implode(',',$this->input->post('servicable_pincode')),
                    'status' => $this->input->post('status')  , 
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('franchise_id', $this->input->post('franchise_id'));
            $this->db->update('crit_franchise_info', $upd); 
                            
            redirect('franchise-list/' . $this->uri->segment(2, 0)); 
        } 
        
        if($this->input->post('mode') == 'Add User')
        {
            
            $insert_sql = "insert into crit_user_info (first_name, user_name, pwd, `level`, email, mobile, state, city, pincodes, franchise_id, `status`) (
                           select 
                           '".$this->input->post('first_name')."' as first_name, 
                           '".$this->input->post('user_name')."' as user_name, 
                           '".$this->input->post('pwd')."' as pwd, 
                           '11' as level,
                           '".$this->input->post('email')."' as email, 
                           '".$this->input->post('mobile')."' as mobile, 
                           a.state_code,
                           a.city_code,
                           a.servicable_pincode,
                           a.franchise_id,
                           '".$this->input->post('status')."' as status
                           from crit_franchise_info as a
                           where a.franchise_id = '".$this->input->post('franchise_id')."'
                            
                          )";
            
            $this->db->query($insert_sql);
             
                             
            redirect('franchise-list/' . $this->uri->segment(2, 0)); 
        }
        
        if($this->input->post('mode') == 'Edit User')
        {
            $upd = array(
                    'first_name' => $this->input->post('first_name'),
                    'user_name' => $this->input->post('user_name'),
                    'pwd' => $this->input->post('pwd'), 
                    'email' => $this->input->post('email'),
                    'mobile' => $this->input->post('mobile'), 
                    'status' => $this->input->post('status')                 
            );
            
            $this->db->where('user_id', $this->input->post('user_id'));
            $this->db->update('crit_user_info', $upd); 
                            
            redirect('franchise-list/' . $this->uri->segment(2, 0)); 
        } 
         
        
        $this->load->library('pagination');
        
       if(isset($_POST['srch_state'])) {
           $data['srch_state'] = $srch_state = $this->input->post('srch_state');
           $data['srch_key'] = $srch_key = $this->input->post('srch_key');
           $this->session->set_userdata('srch_state', $this->input->post('srch_state'));
           $this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_state')){
           $data['srch_state'] = $srch_state = $this->session->userdata('srch_state') ; 
       }else {
           $data['srch_state'] = $srch_state = '';
       }
       
       if(isset($_POST['srch_key'])) { 
           $data['srch_key'] = $srch_key = $this->input->post('srch_key'); 
           $this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_key')){ 
           $data['srch_key'] = $srch_key = $this->session->userdata('srch_key') ;
       } else {
         $data['srch_key'] = $srch_key = '';
       }
       
       if(isset($_POST['srch_franchise'])) { 
           $data['srch_franchise'] = $srch_franchise = $this->input->post('srch_franchise'); 
           $this->session->set_userdata('srch_franchise', $this->input->post('srch_franchise'));
       }
       elseif($this->session->userdata('srch_franchise')){ 
           $data['srch_franchise'] = $srch_franchise = $this->session->userdata('srch_franchise') ;
       } else {
         $data['srch_franchise'] = $srch_franchise = '';
       }
       
       $where = '1';

       if(!empty($srch_franchise)){
         $where .= " and a.franchise_type_id = '". $srch_franchise ."'";
       }
        
       if(!empty($srch_state)){
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
         
       } 
        
        
        $this->db->where('status != ', 'Delete');
        if(!empty($srch_key))
            $this->db->where($where);
        $this->db->from('crit_franchise_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('franchise-list/'), '/'. $this->uri->segment(2, 0));
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
                a.franchise_id,
                b.franchise_type_name as franchise_type,
                a.contact_person, 
                a.mobile, 
                a.phone, 
                a.email, 
                a.gst_no, 
                a.address, 
                a.state_code, 
                a.city_code, 
                a.servicable_pincode, 
                a.`status`
                from crit_franchise_info as a
                left join crit_franchise_type_info as b on b.franchise_type_id = a.franchise_type_id
                where b.`status` = 'Active' and  a.status != 'Delete' 
                and ". $where ."
                order by a.status asc , b.franchise_type_name , a.contact_person asc 
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
                a.state_name,                
                a.state_code             
                from crit_states_info as a  
                where status = 'Active'
                and exists ( select * from crit_franchise_info where state_code = a.state_code )
                order by a.state_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state_code']] = $row['state_name']. ' [ ' . $row['state_code'] . ' ]';     
        }
        
        $sql = "
                select 
                a.franchise_type_id,                
                a.franchise_type_name             
                from crit_franchise_type_info as a  
                where status = 'Active' 
                order by a.franchise_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['franchise_type_opt'][$row['franchise_type_id']] = $row['franchise_type_name'];     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/franchise-list',$data); 
	} 
    
    public function core_item_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'core-item.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'customer_id' => $this->input->post('customer_id'),
                    'pattern_id' => $this->input->post('pattern_id'),
                   // 'core_maker_id' => $this->input->post('core_maker_id'),
                    'core_item_name' => $this->input->post('core_item_name'), 
                    'core_weight' => $this->input->post('core_weight'),
                    'core_per_box' => $this->input->post('core_per_box'),
                   // 'core_maker_rate' => $this->input->post('core_maker_rate'), 
                    'status' => $this->input->post('status'),
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('core_item_info', $ins); 
            redirect('core-item-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array( 
                    'customer_id' => $this->input->post('customer_id'),
                    'pattern_id' => $this->input->post('pattern_id'), 
                    'core_item_name' => $this->input->post('core_item_name'), 
                    'core_weight' => $this->input->post('core_weight'),  
                    'core_per_box' => $this->input->post('core_per_box'),  
                    'status' => $this->input->post('status'),
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('core_item_id', $this->input->post('core_item_id'));
            $this->db->update('core_item_info', $upd); 
                            
            redirect('core-item-list/' . $this->uri->segment(2, 0)); 
        } 
         
        
        $this->load->library('pagination');
        
       if(isset($_POST['srch_customer'])) {
           $data['srch_customer'] = $srch_customer = $this->input->post('srch_customer');
           $data['srch_key'] = $srch_key = $this->input->post('srch_key');
           $this->session->set_userdata('srch_customer', $this->input->post('srch_customer'));
           $this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_customer')){
           $data['srch_customer'] = $srch_customer = $this->session->userdata('srch_customer') ; 
       }else {
           $data['srch_customer'] = $srch_customer = '';
       }
       
       if(isset($_POST['srch_key'])) { 
           $data['srch_key'] = $srch_key = $this->input->post('srch_key'); 
           $this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_key')){ 
           $data['srch_key'] = $srch_key = $this->session->userdata('srch_key') ;
       } else {
         $data['srch_key'] = $srch_key = '';
       }
       
        
       
       $where = '1';

       
        
       if(!empty($srch_customer)){
         $where .= " and a.customer_id = '". $srch_customer ."'";
       }  
       if(!empty($srch_key)) {
         $where .= " and ( 
                        a.core_item_name like '%" . $srch_key . "%' or
                        c.pattern_item like '%" . $srch_key . "%'   
                        ) ";
         
       } 
        
        
        $this->db->where('a.status != ', 'Delete');
        if(!empty($srch_key))
            $this->db->where($where);
        $this->db->from('core_item_info as a');         
        $this->db->join('pattern_info as c ',' c.pattern_id = a.pattern_id');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('core-item-list/'), '/'. $this->uri->segment(2, 0));
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
                a.core_item_id, 
                b.company_name, 
                c.pattern_item, 
                a.core_item_name, 
                d.company_name as core_maker,  
                a.core_per_box, 
                a.core_weight, 
                a.core_maker_rate,  
                a.`status`
                from core_item_info as a 
                left join customer_info as b on b.customer_id = a.customer_id
                left join pattern_info as c on c.pattern_id = a.pattern_id
                left join core_maker_info as d on d.core_maker_id = a.core_maker_id
                where a.status != 'Delete' 
                and ". $where ."
                order by a.status asc , a.customer_id ,a.pattern_id, a.core_item_name asc 
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
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['company_name'] ;     
        }
        
        $sql = "
                select 
                a.core_maker_id,                
                a.company_name            
                from core_maker_info as a  
                where status = 'Active'  
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['core_maker_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['core_maker_opt'][$row['core_maker_id']] = $row['company_name'];     
        }
         
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/core-item-list',$data); 
	} 
    
    public function core_maker_rate_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'core-maker-rate.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'customer_id' => $this->input->post('customer_id'),
                    'pattern_id' => $this->input->post('pattern_id'),
                    'core_maker_id' => $this->input->post('core_maker_id'),
                    'core_item_id' => $this->input->post('core_item_id'),  
                    'rate' => $this->input->post('rate'), 
                    'status' => $this->input->post('status'),
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('core_maker_rate_info', $ins); 
            redirect('core-maker-rate-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array( 
                    'customer_id' => $this->input->post('customer_id'),
                    'pattern_id' => $this->input->post('pattern_id'),
                    'core_maker_id' => $this->input->post('core_maker_id'),
                    'core_item_id' => $this->input->post('core_item_id'),  
                    'rate' => $this->input->post('rate'), 
                    'status' => $this->input->post('status'),
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('core_maker_rate_id', $this->input->post('core_maker_rate_id'));
            $this->db->update('core_maker_rate_info', $upd); 
                            
            redirect('core-maker-rate-list/' . $this->uri->segment(2, 0)); 
        } 
         
        
        $this->load->library('pagination');
        
       if(isset($_POST['srch_customer'])) {
           $data['srch_customer'] = $srch_customer = $this->input->post('srch_customer');
           $data['srch_key1'] = $srch_key1 = $this->input->post('srch_key1');
           $this->session->set_userdata('srch_customer', $this->input->post('srch_customer'));
           $this->session->set_userdata('srch_key1', $this->input->post('srch_key1'));
       }
       elseif($this->session->userdata('srch_customer')){
           $data['srch_customer'] = $srch_customer = $this->session->userdata('srch_customer') ; 
       }else {
           $data['srch_customer'] = $srch_customer = '';
       }
       
       if(isset($_POST['srch_key1'])) { 
           $data['srch_key1'] = $srch_key1 = $this->input->post('srch_key1'); 
           $this->session->set_userdata('srch_key1', $this->input->post('srch_key1'));
       }
       elseif($this->session->userdata('srch_key1')){ 
           $data['srch_key1'] = $srch_key = $this->session->userdata('srch_key1') ;
       } else {
         $data['srch_key1'] = $srch_key1 = '';
       }
       
        
       
       $where = '1';

       
        
       if(!empty($srch_customer)){
         $where .= " and a.customer_id = '". $srch_customer ."'";
       }  
       if(!empty($srch_key1)) {
         $where .= " and ( 
                        c.pattern_item like '%" . $srch_key1 . "%'  or 
                        e.core_item_name like '%" . $srch_key1 . "%'   
                        ) ";
         
       } 
        
        
        $this->db->where('a.status != ', 'Delete');
        if(!empty($srch_key1))
            $this->db->where($where);
        $this->db->from('core_maker_rate_info as a');         
        $this->db->join('pattern_info as c ',' c.pattern_id = a.pattern_id');         
        $this->db->join('core_item_info as e ',' e.core_item_id = a.core_item_id');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('core-maker-rate-list/'), '/'. $this->uri->segment(2, 0));
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
                a.core_maker_rate_id, 
                b.company_name, 
                c.pattern_item, 
                e.core_item_name, 
                d.company_name as core_maker,   
                a.rate as core_maker_rate,  
                a.`status`
                from core_maker_rate_info as a 
                left join customer_info as b on b.customer_id = a.customer_id
                left join pattern_info as c on c.pattern_id = a.pattern_id
                left join core_maker_info as d on d.core_maker_id = a.core_maker_id
                left join core_item_info as e on e.core_item_id = a.core_item_id
                where a.status != 'Delete' 
                and ". $where ."
                order by a.status asc , a.customer_id ,a.pattern_id, e.core_item_name asc 
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
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['company_name'] ;     
        }
        
        $sql = "
                select 
                a.core_maker_id,                
                a.company_name            
                from core_maker_info as a  
                where status = 'Active'  
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['core_maker_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['core_maker_opt'][$row['core_maker_id']] = $row['company_name'];     
        }
         
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/core-maker-rate-list',$data); 
	} 
    
    
    public function customer_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'customer.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array( 
                    'company_name' => $this->input->post('company_name'),
                    'contact_person' => $this->input->post('contact_person'), 
                    'address_line' => $this->input->post('address_line'),
                    'area' => $this->input->post('area'),
                    'city' => $this->input->post('city'),
                    'pincode' => $this->input->post('pincode'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'mobile' => $this->input->post('mobile'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),   
                    'status' => $this->input->post('status'),
                    'gst_no' => $this->input->post('gst_no'),
                    'bank_name' => $this->input->post('bank_name'), 
                    'branch' => $this->input->post('branch'), 
                    'ac_holder_name' => $this->input->post('ac_holder_name'), 
                    'ac_no' => $this->input->post('ac_no'), 
                    'ifsc_code' => $this->input->post('ifsc_code'),  
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('customer_info', $ins); 
            redirect('customer-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array( 
                    'company_name' => $this->input->post('company_name'),
                    'contact_person' => $this->input->post('contact_person'), 
                    'address_line' => $this->input->post('address_line'),
                    'area' => $this->input->post('area'),
                    'city' => $this->input->post('city'),
                    'pincode' => $this->input->post('pincode'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'mobile' => $this->input->post('mobile'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),   
                    'status' => $this->input->post('status'),
                    'gst_no' => $this->input->post('gst_no'),
                    'bank_name' => $this->input->post('bank_name'), 
                    'branch' => $this->input->post('branch'), 
                    'ac_holder_name' => $this->input->post('ac_holder_name'), 
                    'ac_no' => $this->input->post('ac_no'), 
                    'ifsc_code' => $this->input->post('ifsc_code'),  
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('customer_id', $this->input->post('customer_id'));
            $this->db->update('customer_info', $upd); 
                            
            redirect('customer-list/' . $this->uri->segment(2, 0)); 
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
       
       if(isset($_POST['srch_key'])) { 
           $data['srch_key'] = $srch_key = $this->input->post('srch_key'); 
           $this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_key')){ 
           $data['srch_key'] = $srch_key = $this->session->userdata('srch_key') ;
       } else {
         $data['srch_key'] = $srch_key = '';
       }
       
        
        
       
       $where = '1'; 
         
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
         
        
        $this->db->where('status != ', 'Delete');
        if(!empty($srch_key))
            $this->db->where($where);
        $this->db->from('customer_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('customer-list/'), '/'. $this->uri->segment(2, 0));
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
                a.`status`
                from customer_info as a  
                where a.status != 'Delete' 
                and ". $where ."
                order by a.status asc , a.contact_person asc 
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
		
		$sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'LOC'
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
       
	   $this->load->view('page/customer-list',$data); 
	} 
    
    public function pattern_maker_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'pattern-maker.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array( 
                    'company_name' => $this->input->post('company_name'),
                    'contact_person' => $this->input->post('contact_person'), 
                    'address_line' => $this->input->post('address_line'),
                    'area' => $this->input->post('area'),
                    'city' => $this->input->post('city'),
                    'pincode' => $this->input->post('pincode'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'mobile' => $this->input->post('mobile'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),   
                    'status' => $this->input->post('status'),
                    'gst_no' => $this->input->post('gst_no'), 
                    'bank_name' => $this->input->post('bank_name'), 
                    'branch' => $this->input->post('branch'), 
                    'ac_holder_name' => $this->input->post('ac_holder_name'), 
                    'ac_no' => $this->input->post('ac_no'), 
                    'ifsc_code' => $this->input->post('ifsc_code'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('pattern_maker_info', $ins); 
            redirect('pattern-maker-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array( 
                    'company_name' => $this->input->post('company_name'),
                    'contact_person' => $this->input->post('contact_person'), 
                    'address_line' => $this->input->post('address_line'),
                    'area' => $this->input->post('area'),
                    'city' => $this->input->post('city'),
                    'pincode' => $this->input->post('pincode'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'mobile' => $this->input->post('mobile'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),   
                    'status' => $this->input->post('status'),
                    'gst_no' => $this->input->post('gst_no'), 
                    'bank_name' => $this->input->post('bank_name'), 
                    'branch' => $this->input->post('branch'), 
                    'ac_holder_name' => $this->input->post('ac_holder_name'), 
                    'ac_no' => $this->input->post('ac_no'), 
                    'ifsc_code' => $this->input->post('ifsc_code'), 
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('pattern_maker_id', $this->input->post('pattern_maker_id'));
            $this->db->update('pattern_maker_info', $upd); 
                            
            redirect('pattern-maker-list/' . $this->uri->segment(2, 0)); 
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
       
       if(isset($_POST['srch_key'])) { 
           $data['srch_key'] = $srch_key = $this->input->post('srch_key'); 
           $this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_key')){ 
           $data['srch_key'] = $srch_key = $this->session->userdata('srch_key') ;
       } else {
         $data['srch_key'] = $srch_key = '';
       }
       
        
        
       
       $where = '1'; 
         
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
         
        
        $this->db->where('status != ', 'Delete');
        if(!empty($srch_key))
            $this->db->where($where);
        $this->db->from('pattern_maker_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('pattern-maker-list/'), '/'. $this->uri->segment(2, 0));
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
                a.pattern_maker_id, 
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
                a.`status`
                from pattern_maker_info as a  
                where a.status != 'Delete' 
                and ". $where ."
                order by a.status asc , a.contact_person asc 
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
        
        $this->load->view('page/pattern-maker-list',$data); 
	} 
    
    public function core_maker_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'core-maker.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array( 
                    'company_name' => $this->input->post('company_name'),
                    'contact_person' => $this->input->post('contact_person'), 
                    'address_line' => $this->input->post('address_line'),
                    'area' => $this->input->post('area'),
                    'city' => $this->input->post('city'),
                    'pincode' => $this->input->post('pincode'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'mobile' => $this->input->post('mobile'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),   
                    'status' => $this->input->post('status'),
                    'gst_no' => $this->input->post('gst_no'), 
                    'bank_name' => $this->input->post('bank_name'), 
                    'branch' => $this->input->post('branch'), 
                    'ac_holder_name' => $this->input->post('ac_holder_name'), 
                    'ac_no' => $this->input->post('ac_no'), 
                    'ifsc_code' => $this->input->post('ifsc_code'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('core_maker_info', $ins); 
            redirect('core-maker-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array( 
                    'company_name' => $this->input->post('company_name'),
                    'contact_person' => $this->input->post('contact_person'), 
                    'address_line' => $this->input->post('address_line'),
                    'area' => $this->input->post('area'),
                    'city' => $this->input->post('city'),
                    'pincode' => $this->input->post('pincode'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'mobile' => $this->input->post('mobile'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),   
                    'status' => $this->input->post('status'),
                    'gst_no' => $this->input->post('gst_no'), 
                    'bank_name' => $this->input->post('bank_name'), 
                    'branch' => $this->input->post('branch'), 
                    'ac_holder_name' => $this->input->post('ac_holder_name'), 
                    'ac_no' => $this->input->post('ac_no'), 
                    'ifsc_code' => $this->input->post('ifsc_code'), 
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('core_maker_id', $this->input->post('core_maker_id'));
            $this->db->update('core_maker_info', $upd); 
                            
            redirect('core-maker-list/' . $this->uri->segment(2, 0)); 
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
       
       if(isset($_POST['srch_key'])) { 
           $data['srch_key'] = $srch_key = $this->input->post('srch_key'); 
           $this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_key')){ 
           $data['srch_key'] = $srch_key = $this->session->userdata('srch_key') ;
       } else {
         $data['srch_key'] = $srch_key = '';
       }
       
        
        
       
       $where = '1'; 
         
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
         
        
        $this->db->where('status != ', 'Delete');
        if(!empty($srch_key))
            $this->db->where($where);
        $this->db->from('core_maker_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('core-maker-list/'), '/'. $this->uri->segment(2, 0));
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
                a.core_maker_id, 
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
                a.`status`
                from core_maker_info as a  
                where a.status != 'Delete' 
                and ". $where ."
                order by a.status asc , a.contact_person asc 
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
        
        $this->load->view('page/core-maker-list',$data); 
	} 
    
    public function employee_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'employee.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array( 
                    'employee_name' => $this->input->post('employee_name'), 
                    'aadhar_no' => $this->input->post('aadhar_no'),
                    'address_line' => $this->input->post('address_line'),
                    'area' => $this->input->post('area'),
                    'city' => $this->input->post('city'),
                    'pincode' => $this->input->post('pincode'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'mobile' => $this->input->post('mobile'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),   
                    'status' => $this->input->post('status'), 
                    'bank_name' => $this->input->post('bank_name'), 
                    'branch' => $this->input->post('branch'), 
                    'ac_holder_name' => $this->input->post('ac_holder_name'), 
                    'ac_no' => $this->input->post('ac_no'), 
                    'ifsc_code' => $this->input->post('ifsc_code'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('employee_info', $ins); 
            redirect('employee-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array( 
                    'employee_name' => $this->input->post('employee_name'), 
                    'aadhar_no' => $this->input->post('aadhar_no'), 
                    'address_line' => $this->input->post('address_line'),
                    'area' => $this->input->post('area'),
                    'city' => $this->input->post('city'),
                    'pincode' => $this->input->post('pincode'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'mobile' => $this->input->post('mobile'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),   
                    'status' => $this->input->post('status'), 
                    'bank_name' => $this->input->post('bank_name'), 
                    'branch' => $this->input->post('branch'), 
                    'ac_holder_name' => $this->input->post('ac_holder_name'), 
                    'ac_no' => $this->input->post('ac_no'), 
                    'ifsc_code' => $this->input->post('ifsc_code'), 
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('employee_id', $this->input->post('employee_id'));
            $this->db->update('employee_info', $upd); 
                            
            redirect('employee-list/' . $this->uri->segment(2, 0)); 
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
       
       if(isset($_POST['srch_key'])) { 
           $data['srch_key'] = $srch_key = $this->input->post('srch_key'); 
           $this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_key')){ 
           $data['srch_key'] = $srch_key = $this->session->userdata('srch_key') ;
       } else {
         $data['srch_key'] = $srch_key = '';
       }
       
        
        
       
       $where = '1'; 
         
       if(!empty($srch_key)) {
         $where .= " and ( 
                        a.employee_name like '%" . $srch_key . "%' or 
                        a.pincode like '%" . $srch_key . "%' or 
                        a.mobile like '%". $srch_key ."%' or  
                        a.email like '%". $srch_key ."%' or 
                        a.phone like '%". $srch_key ."%'
                        ) ";
         
       } 
         
        
        $this->db->where('status != ', 'Delete');
        if(!empty($srch_key))
            $this->db->where($where);
        $this->db->from('employee_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('employee-list/'), '/'. $this->uri->segment(2, 0));
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
                a.employee_id, 
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
                a.`status`
                from employee_info as a  
                where a.status != 'Delete' 
                and ". $where ."
                order by a.status asc , a.employee_name asc 
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
        
        $this->load->view('page/employee-list',$data); 
	} 
    
    public function sub_contractor_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'sub-contractor.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array( 
                    'company_name' => $this->input->post('company_name'),
                    'contact_person' => $this->input->post('contact_person'), 
                    'type' => $this->input->post('type'), 
                    'customer_id' => $this->input->post('customer_id'), 
                    'grinding_rate' => $this->input->post('grinding_rate'), 
                    'address_line' => $this->input->post('address_line'),
                    'area' => $this->input->post('area'),
                    'city' => $this->input->post('city'),
                    'pincode' => $this->input->post('pincode'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'mobile' => $this->input->post('mobile'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),   
                    'status' => $this->input->post('status'),
                    'gst_no' => $this->input->post('gst_no'), 
                    'bank_name' => $this->input->post('bank_name'), 
                    'branch' => $this->input->post('branch'), 
                    'ac_holder_name' => $this->input->post('ac_holder_name'), 
                    'ac_no' => $this->input->post('ac_no'), 
                    'ifsc_code' => $this->input->post('ifsc_code'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('sub_contractor_info', $ins); 
            redirect('sub-contractor-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array( 
                    'company_name' => $this->input->post('company_name'),
                    'contact_person' => $this->input->post('contact_person'),
                    'type' => $this->input->post('type'), 
                    'customer_id' => $this->input->post('customer_id'), 
                    'grinding_rate' => $this->input->post('grinding_rate'),  
                    'address_line' => $this->input->post('address_line'),
                    'area' => $this->input->post('area'),
                    'city' => $this->input->post('city'),
                    'pincode' => $this->input->post('pincode'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'mobile' => $this->input->post('mobile'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),   
                    'status' => $this->input->post('status'),
                    'gst_no' => $this->input->post('gst_no'), 
                    'bank_name' => $this->input->post('bank_name'), 
                    'branch' => $this->input->post('branch'), 
                    'ac_holder_name' => $this->input->post('ac_holder_name'), 
                    'ac_no' => $this->input->post('ac_no'), 
                    'ifsc_code' => $this->input->post('ifsc_code'), 
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('sub_contractor_id', $this->input->post('sub_contractor_id'));
            $this->db->update('sub_contractor_info', $upd); 
                            
            redirect('sub-contractor-list/' . $this->uri->segment(2, 0)); 
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
       
       if(isset($_POST['srch_key'])) { 
           $data['srch_key'] = $srch_key = $this->input->post('srch_key'); 
           $this->session->set_userdata('srch_key', $this->input->post('srch_key'));
       }
       elseif($this->session->userdata('srch_key')){ 
           $data['srch_key'] = $srch_key = $this->session->userdata('srch_key') ;
       } else {
         $data['srch_key'] = $srch_key = '';
       }
       
        
        
       
       $where = '1'; 
         
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
         
        
        $this->db->where('status != ', 'Delete');
        if(!empty($srch_key))
            $this->db->where($where);
        $this->db->from('sub_contractor_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('sub-contractor-list/'), '/'. $this->uri->segment(2, 0));
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
                a.mobile, 
                a.phone, 
                a.email, 
                a.gst_no,   
                a.`status`
                from sub_contractor_info as a  
                left join customer_info as b on b.customer_id = a.customer_id
                where a.status != 'Delete' 
                and ". $where ."
                order by a.status asc , a.contact_person asc 
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
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['company_name'] ;     
        }
          
         
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/sub-contractor-list',$data); 
	} 
    
    public function uom_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'uom.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'uom_name' => $this->input->post('uom_name'), 
                    'status' => $this->input->post('status')  ,                          
            );
            
            $this->db->insert('uom_info', $ins); 
            redirect('uom-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'uom_name' => $this->input->post('uom_name'), 
                    'status' => $this->input->post('status')  ,                   
            );
            
            $this->db->where('uom_id', $this->input->post('uom_id'));
            $this->db->update('uom_info', $upd); 
                            
            redirect('uom-list/' . $this->uri->segment(2, 0)); 
        } 
         
        
        $this->load->library('pagination');
        
        
        $this->db->where('status != ', 'Delete'); 
        $this->db->from('uom_info');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('uom-list/'), '/'. $this->uri->segment(2, 0));
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
                a.uom_id,                 
                a.uom_name,                
                a.status
                from uom_info as a 
                where status != 'Delete'
                order by a.status asc , a.uom_name asc 
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
        
        $this->load->view('page/uom-list',$data); 
	} 
    
    public function grade_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'grade.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'grade_name' => $this->input->post('grade_name'),
                    'C' => $this->input->post('C'),
                    'SI' => $this->input->post('SI'),
                    'Mn' => $this->input->post('Mn'),
                    'P' => $this->input->post('P'),
                    'S' => $this->input->post('S'),
                    'Cr' => $this->input->post('Cr'),
                    'Cu' => $this->input->post('Cu'),
                    'Mg' => $this->input->post('Mg'),
                    'BHM' => $this->input->post('BHM'),
                    'tensile' => $this->input->post('tensile'),
                    'elongation' => $this->input->post('elongation'),
                    'yeild_strength' => $this->input->post('yeild_strength'),
                    'status' => $this->input->post('status')  ,                          
            );
            
            $this->db->insert('grade_info', $ins); 
            redirect('grade-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'grade_name' => $this->input->post('grade_name'),
                    'C' => $this->input->post('C'),
                    'SI' => $this->input->post('SI'),
                    'Mn' => $this->input->post('Mn'),
                    'P' => $this->input->post('P'),
                    'S' => $this->input->post('S'),
                    'Cr' => $this->input->post('Cr'),
                    'Cu' => $this->input->post('Cu'),
                    'Mg' => $this->input->post('Mg'),
                    'BHM' => $this->input->post('BHM'),
                    'tensile' => $this->input->post('tensile'),
                    'elongation' => $this->input->post('elongation'),
                    'yeild_strength' => $this->input->post('yeild_strength'),
                    'status' => $this->input->post('status')  ,                 
            );
            
            $this->db->where('grade_id', $this->input->post('grade_id'));
            $this->db->update('grade_info', $upd); 
                            
            redirect('grade-list/' . $this->uri->segment(2, 0)); 
        } 
         
        
        $this->load->library('pagination');
        
       
       
        $where = '1';
        
        
        
        $this->db->where('status != ', 'Delete');
        //if(!empty($srch_key))
        //    $this->db->where($where);
        $this->db->from('grade_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('grade-list/'), '/'. $this->uri->segment(2, 0));
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
                a.grade_id, 
                a.grade_name, 
                a.C, 
                a.SI, 
                a.Mn, 
                a.P, 
                a.S, 
                a.Cr, 
                a.Cu, 
                a.Mg, 
                a.BHM, 
                a.tensile, 
                a.elongation, 
                a.yeild_strength, 
                a.`status` 
                from grade_info as a 
                where  a.status != 'Delete' and ". $where ."
                order by a.status asc , a.grade_name asc 
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
        
        $this->load->view('page/grade-list',$data); 
	} 
    
    
    public function rejection_type_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN ) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'rejection_type.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'rejection_group' => $this->input->post('rejection_group'),
                    'rejection_type_name' => $this->input->post('rejection_type_name'), 
                    'rej_code' => $this->input->post('rej_code'),                           
                    'status' => $this->input->post('status'),                           
            );
            
            $this->db->insert('rejection_type_info', $ins); 
            redirect('rejection-type-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'rejection_group' => $this->input->post('rejection_group'),
                    'rejection_type_name' => $this->input->post('rejection_type_name'), 
                    'rej_code' => $this->input->post('rej_code'),                        
                    'status' => $this->input->post('status'),                        
            );
            
            $this->db->where('rejection_type_id', $this->input->post('rejection_type_id'));
            $this->db->update('rejection_type_info', $upd); 
                            
            redirect('rejection-type-list/' . $this->uri->segment(2, 0)); 
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
        $where = " a.rejection_group = '" . $srch_rejection_group . "'";
         
         
       } else {
        $where = " 1";
        $this->session->set_userdata('srch_rejection_group', '');
        $data['srch_rejection_group'] = $srch_rejection_group =  ''; 
       }
        
         
        
        $this->load->library('pagination');
        
        $this->db->where('a.status != ', 'Delete');
        $this->db->where($where);
        $this->db->from('rejection_type_info as a');
        $data['total_records'] = $cnt  = $this->db->count_all_results();
        
        $data['sno'] = $this->uri->segment(2, 0);	
        	
        $config['base_url'] = trim(site_url('rejection-type-list/'), '/'. $this->uri->segment(2, 0));
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
                a.rejection_type_id,
                a.rejection_group,                
                a.rejection_type_name,
                a.rej_code, 
                a.status                
                from rejection_type_info as a  
                where status != 'Delete'
                and $where
                order by a.rejection_group, a.rejection_type_name asc  
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
                order by a.level, a.rejection_group_name asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['rejection_group_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['rejection_group_opt'][$row['rejection_group_name']] = $row['rejection_group_name'] ;     
        }
        
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/rejection-type-list',$data); 
	}
    
    public function customer_domestic_rate($customer_id) 
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN && $this->session->userdata('m_is_admin') != USER_MANAGER ) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'customer-domestic-rate.inc';    
        
       
         
       if(!empty($customer_id)) {          
            $this->db->where('customer_id = ', $customer_id);
            $this->db->from('crit_customer_domestic_rate_info');
            $cnt  = $this->db->count_all_results();
            if($cnt == 0 ) {
            $ins_sql = "insert into crit_customer_domestic_rate_info ( 
                        select
                        '' as id,  
                         '".$customer_id ."' as fr_id,  
                         c_type, 
                         current_date() rate_as_on, 
                         flg_state, 
                         flg_city,
                         min_weight, 
                         min_charges, 
                         addt_weight, 
                         addt_charges, 
                         `status`, 
                         '". $this->session->userdata('cr_user_id') ."' as created_by, 
                         now() created_datetime,
                         '' as updated_by,
                         '' as update_datetime
                        from crit_domestic_rate_info 
                        where status = 'Active'
                        )";
             $this->db->query($ins_sql);  
                     
                        
            }  
            
            $sql = "
                    select 
                    a.customer_domestic_rate_id, 
                    a.customer_id, 
                    a.c_type,
                    a.rate_as_on,
                    a.flg_state, 
                    a.flg_city, 
                    a.min_weight, 
                    a.min_charges, 
                    a.addt_weight, 
                    a.addt_charges, 
                    a.`status`
                    from crit_customer_domestic_rate_info as a  
                    where a.status = 'Active' and a.customer_id = $customer_id
                    order by a.status asc ,a.c_type ,  a.flg_state desc , a.flg_city desc             
            "; 
            
            $query = $this->db->query($sql);
            $data['record_list'] = array();
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][$row['c_type']][] = $row;     
            } 
           
         
       } else { 
            
            $data['record_list']['Air'] = array();
            $data['record_list']['Surface'] = array();
            
             
       } 
        
         
        $this->load->view('page/customer-domestic-rate',$data); 
	}
 
    
    
    public function transporter_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'transporter.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'transporter_name' => $this->input->post('transporter_name'),
                    'transporter_gst' => $this->input->post('transporter_gst'),
                    'status' => $this->input->post('status')  ,                          
            );
            
            $this->db->insert('transporter_info', $ins); 
            redirect('transporter-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'transporter_name' => $this->input->post('transporter_name'),
                    'transporter_gst' => $this->input->post('transporter_gst'),
                    'status' => $this->input->post('status')  ,                 
            );
            
            $this->db->where('transporter_id', $this->input->post('transporter_id'));
            $this->db->update('transporter_info', $upd); 
                            
            //redirect('transporter-list/' . $this->uri->segment(2, 0));
            redirect('transporter-list'); 
        } 
         
        
        $this->load->library('pagination');
        
        
        $this->db->where('status != ', 'Delete'); 
        $this->db->from('transporter_info');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('transporter-list/'), '/'. $this->uri->segment(2, 0));
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
                *
                from transporter_info as a 
                where status != 'Delete'
                order by a.status asc , a.transporter_name asc 
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
        
        $this->load->view('page/transporter-list',$data); 
	} 
    
    
    
    public function service_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'service.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'service_name' => $this->input->post('service_name'),
                    'status' => $this->input->post('status')  ,                          
            );
            
            $this->db->insert('crit_service_info', $ins); 
            redirect('service-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'service_name' => $this->input->post('service_name'),
                    'status' => $this->input->post('status')  ,                 
            );
            
            $this->db->where('service_id', $this->input->post('service_id'));
            $this->db->update('crit_service_info', $upd); 
                            
            redirect('service-list/' . $this->uri->segment(2, 0)); 
        } 
         
        
        $this->load->library('pagination');
        
        
        $this->db->where('status != ', 'Delete'); 
        $this->db->from('crit_service_info');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('service-list/'), '/'. $this->uri->segment(2, 0));
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
                a.service_id,
                a.service_name,                
                a.status
                from crit_service_info as a 
                where status != 'Delete'
                order by a.status asc , a.service_name asc 
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
        
        $this->load->view('page/service-list',$data); 
	} 
    
    public function package_type_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'package-type.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'package_type_name' => $this->input->post('package_type_name'),
                    'status' => $this->input->post('status')  ,                          
            );
            
            $this->db->insert('crit_package_type_info', $ins); 
            redirect('package-type-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'package_type_name' => $this->input->post('package_type_name'),
                    'status' => $this->input->post('status'),               
            );
            
            $this->db->where('package_type_id', $this->input->post('package_type_id'));
            $this->db->update('crit_package_type_info', $upd); 
                            
            redirect('package-type-list/' . $this->uri->segment(2, 0)); 
        } 
         
        
        $this->load->library('pagination');
        
        
        $this->db->where('status != ', 'Delete'); 
        $this->db->from('crit_package_type_info');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('package-type-list/'), '/'. $this->uri->segment(2, 0));
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
                a.package_type_id,
                a.package_type_name,                
                a.status
                from crit_package_type_info as a 
                where status != 'Delete'
                order by a.status asc , a.package_type_name asc 
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
        
        $this->load->view('page/package-type-list',$data); 
	} 
    
    public function product_type_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'product-type.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'product_type_name' => $this->input->post('product_type_name'),
                    'status' => $this->input->post('status')  ,                          
            );
            
            $this->db->insert('crit_product_type_info', $ins); 
            redirect('product-type-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'product_type_name' => $this->input->post('product_type_name'),
                    'status' => $this->input->post('status'),               
            );
            
            $this->db->where('product_type_id', $this->input->post('product_type_id'));
            $this->db->update('crit_product_type_info', $upd); 
                            
            redirect('product-type-list/' . $this->uri->segment(2, 0)); 
        } 
         
        
        $this->load->library('pagination');
        
        
        $this->db->where('status != ', 'Delete'); 
        $this->db->from('crit_product_type_info');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('product-type-list/'), '/'. $this->uri->segment(2, 0));
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
                a.product_type_id,
                a.product_type_name,                
                a.status
                from crit_product_type_info as a 
                where status != 'Delete'
                order by a.status asc , a.product_type_name asc 
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
        
        $this->load->view('page/product-type-list',$data); 
	} 
    
    
    public function customer_type_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'customer-type.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'customer_type_name' => $this->input->post('customer_type_name'),
                    'status' => $this->input->post('status')  ,                          
            );
            
            $this->db->insert('crit_customer_type_info', $ins); 
            redirect('customer-type-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'customer_type_name' => $this->input->post('product_type_name'),
                    'status' => $this->input->post('status')  ,             
            );
            
            $this->db->where('customer_type_id', $this->input->post('customer_type_id'));
            $this->db->update('crit_customer_type_info', $upd); 
                            
            redirect('customer-type-list/' . $this->uri->segment(2, 0)); 
        } 
         
        
        $this->load->library('pagination');
        
        
        $this->db->where('status != ', 'Delete'); 
        $this->db->from('crit_customer_type_info');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('customer-type-list/'), '/'. $this->uri->segment(2, 0));
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
                a.customer_type_id,
                a.customer_type_name,                
                a.status
                from crit_customer_type_info as a 
                where status != 'Delete'
                order by a.status asc , a.customer_type_name asc 
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
        
        $this->load->view('page/customer-type-list',$data); 
	} 
    
    public function domestic_rate() 
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN && $this->session->userdata('m_is_admin') != USER_MANAGER ) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'domestic.inc';  
        
     
        
        if($this->input->post('mode') == 'Edit' && ($this->input->post('domestic_rate_id')!= ''))
        {
            $ins = array(
                    'flg_state' => $this->input->post('flg_state'),
                    'flg_city' => $this->input->post('flg_city'),
                    'min_weight' => $this->input->post('min_weight'),
                    'min_charges' => $this->input->post('min_charges'),
                    'addt_weight' => $this->input->post('addt_weight'),
                    'addt_charges' => $this->input->post('addt_charges'),              
                    'c_type' => $this->input->post('c_type'),              
                    'rate_as_on' => date('Y-m-d'),
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')             
            );
            
            $this->db->where('domestic_rate_id', $this->input->post('domestic_rate_id'));
            $this->db->update('crit_domestic_rate_info', array(
                                                                'status' => 'In-Active' ,
                                                                'updated_by' => $this->session->userdata('cr_user_id'),                          
                                                                'update_datetime' => date('Y-m-d H:i:s')   
                                                               )); 
            
            $this->db->insert('crit_domestic_rate_info', $ins); 
            
                            
            redirect('domestic-rate'); 
        } 
         
        
        $this->load->library('pagination');
        
        $this->db->where('status = ', 'Active');
        $this->db->from('crit_domestic_rate_info');
        $data['total_records'] = $cnt  = $this->db->count_all_results();
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('domestic-rate/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 10;
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
        
        $sql = "
                select 
                a.domestic_rate_id,
                a.c_type,
                a.rate_as_on,
                a.flg_state, 
                a.flg_city, 
                a.min_weight, 
                a.min_charges, 
                a.addt_weight, 
                a.addt_charges, 
                a.`status`
                from crit_domestic_rate_info as a 
                where status = 'Active'
                order by a.status asc , a.flg_state asc , a.flg_city asc
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][$row['c_type']][] = $row;     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/domestic-rate',$data); 
	}
    
    
    public function franchise_domestic_rate() 
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN && $this->session->userdata('m_is_admin') != USER_MANAGER ) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'franchise-domestic-rate.inc';   
        
         
        
        
       if(isset($_POST['srch_franchise_type'])) { 
         $data['srch_franchise_type'] = $srch_franchise_type = $this->input->post('srch_franchise_type'); 
       } else {
         $data['srch_franchise_type'] = $srch_franchise_type = '';
       }
        
       if(isset($_POST['srch_state'])) {
         $data['srch_state'] = $srch_state = $this->input->post('srch_state'); 
       } else {
         $data['srch_state'] = $srch_state = '';
       } 
       
       if(isset($_POST['srch_franchise_id'])) { 
          $data['srch_franchise_id'] = $srch_franchise_id = $this->input->post('srch_franchise_id');  
       } else {
          $data['srch_franchise_id'] = $srch_franchise_id = '';
       }
       
       $where = '1';
       $where1 = '1';

       if(!empty($srch_franchise_type)){
         //$where1 .= " and a.franchise_type_id = '". $srch_franchise_type ."'";
         $data['franchise_opt'] = array();
       } 
       if(!empty($srch_state)){
         //$where1 .= " and a.state_code = '". $srch_state ."'";
         $data['franchise_opt'] = array();
       }  
       if(!empty($srch_franchise_id)) {
         $where .= " and a.franchise_id = " .$srch_franchise_id; 
         
            $this->db->where('franchise_id = ', $srch_franchise_id);
            $this->db->from('crit_franchise_domestic_rate_info');
            $cnt  = $this->db->count_all_results();
            if($cnt == 0 ) {
            $ins_sql = "insert into crit_franchise_domestic_rate_info ( 
                        select
                        '' as id,  
                         '".$srch_franchise_id ."' as fr_id,  
                         c_type, 
                         current_date() rate_as_on, 
                         flg_state, 
                         flg_city,
                         min_weight, 
                         min_charges, 
                         addt_weight, 
                         addt_charges, 
                         `status`, 
                         '". $this->session->userdata('cr_user_id') ."' as created_by, 
                         now() created_datetime,
                         '' as updated_by,
                         '' as update_datetime
                        from crit_domestic_rate_info 
                        where status = 'Active'
                        )";
             $this->db->query($ins_sql);  
                     
                        
            }  
            
            $sql = "
                    select 
                    a.franchise_domestic_rate_id, 
                    a.franchise_id,
                    c.contact_person,
                    a.c_type,
                    a.rate_as_on,
                    a.flg_state, 
                    a.flg_city, 
                    a.min_weight, 
                    a.min_charges, 
                    a.addt_weight, 
                    a.addt_charges, 
                    a.`status`
                    from crit_franchise_domestic_rate_info as a 
                    left join crit_franchise_info as c on c.franchise_id = a.franchise_id 
                    where a.status = 'Active' and $where 
                    order by a.status asc ,a.c_type ,  a.flg_state desc , a.flg_city desc             
            "; 
            
            $query = $this->db->query($sql);
            $data['record_list'] = array();
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][$row['c_type']][] = $row;     
            }
                      
         
            $sql = "select 
                    a.franchise_id,   
                    a.contact_person, 
                    a.mobile,
                    a.city_code    
                    from crit_franchise_info as a 
                    where a.state_code = '". $srch_state ."'
                    and a.franchise_type_id = '". $srch_franchise_type ."'
                    and a.status = 'Active' 
                    order by a.contact_person asc
                    ";
          
            $query = $this->db->query($sql);
       
            foreach ($query->result_array() as $row)
            {
                $data['franchise_opt'][$row['franchise_id']] = $row['contact_person']. " [ " . $row['mobile'] . " ] [" . $row['city_code'] . " ] " ;     
            }      
         
       } else {
            //$data['franchise_opt'] = array();
            
            $data['record_list']['Air'] = array();
            $data['record_list']['Surface'] = array();
            
            if(!empty($srch_franchise_type)) {
             $sql = "select 
                    a.franchise_id,   
                    a.contact_person, 
                    a.mobile,
                    a.city_code    
                    from crit_franchise_info as a 
                    where a.state_code = '". $srch_state ."'
                    and a.franchise_type_id = '". $srch_franchise_type ."'
                    and a.status = 'Active'";
          
            $query = $this->db->query($sql);
       
            foreach ($query->result_array() as $row)
            {
                $data['franchise_opt'][$row['franchise_id']] = $row['contact_person']. " [ " . $row['mobile'] . " ] [" . $row['city_code'] . " ] " ;     
            } 
            } else {
                $data['franchise_opt'] = array();
            }
       }
        
            
        
        
        
        $sql = "
                select 
                a.franchise_type_id,                
                a.franchise_type_name             
                from crit_franchise_type_info as a  
                where status = 'Active' 
                order by a.franchise_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['franchise_type_opt'][$row['franchise_type_id']] = $row['franchise_type_name'];     
        }
        
        $sql = "
                select 
                a.state_name,                
                a.state_code             
                from crit_states_info as a  
                where status = 'Active'
                and exists ( select * from crit_franchise_info where state_code = a.state_code )
                order by a.state_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state_code']] = $row['state_name']. ' [ ' . $row['state_code'] . ' ]';     
        }
        
        
         
        $this->load->view('page/franchise-domestic-rate',$data); 
	}
    
    public function moulding_spec_generate()
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
       } else {
         $data['srch_customer_id'] = $srch_customer_id = '';
       }
       
       if(!empty($srch_customer_id)  ){
         
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
        
         
        $sql = "
                    select 
                    a.pattern_id,
                    a.match_plate_no,
                    a.pattern_item,
                    a.box_size,
                    a.bunch_weight,
                    a.pattern_type,
                    a.no_of_cavity,
                    b.grade_name as grade,
                    a.no_of_core,
                    a.core_weight,
                    a.type_of_core,
                    a.item_description
                    from pattern_info  as a 
                    left join grade_info as b on b.grade_id = a.grade
                    where a.status = 'Active'";
                    if(!empty($srch_customer_id) ){
                        $sql.=" and a.customer_id = '". $srch_customer_id ."'"; 
                    }
                    
                   $sql.="  
                    order by a.pattern_item asc                
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
        
         
        }  
        
        $this->load->view('page/moulding-spec-generate',$data); 
    }
    
    public function iso_label_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'iso-label.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'ason_date' => $this->input->post('ason_date'),
                    'label_for' => $this->input->post('label_for'),
                    'iso_label_ctnt' => $this->input->post('iso_label_ctnt'),
                    'iso_label_ctnt_footer' => $this->input->post('iso_label_ctnt_footer'),
                    'status' => 'Active'  ,                          
            );
            
            $this->db->insert('iso_label_info', $ins); 
            redirect('iso-label-list');
        }
        
        /*
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'country_name' => $this->input->post('country_name'),
                    'status' => $this->input->post('status'),                 
            );
            
            $this->db->where('country_id', $this->input->post('country_id'));
            $this->db->update('crit_country_info', $upd); 
                            
            redirect('country-list/' . $this->uri->segment(2, 0)); 
        } 
        */
         
        
        $this->load->library('pagination'); 
        
        $this->db->where('status != ', 'Delete'); 
        $this->db->from('iso_label_info');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('iso-label-list/'), '/'. $this->uri->segment(2, 0));
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
                a.*
                from iso_label_info as a 
                where status != 'Delete'
                order by a.status asc , a.ason_date desc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        
       $data['label_for_opt'] = array(
                                        'MTC' => 'Material Test Cerificate' , 
                                        'STR' =>'Sand Test Register',
                                        'MML' => 'Melting Master Log' , 
                                        'MOML' => 'Molding Master Log' , 
                                        'FPL' =>'Fettling Production Log Sheet',
                                        'PHC' =>'Pattern History Card',
                                        'IR' =>'Internal Rejection',
                                        'LOC' =>'List Of Customers',
                                        'OR' =>'Order Register',
                                        'PIOD' =>'Purchase Inward & Outward Data',
                                        'PLS' =>'Production Logsheet',
                                        'DAR' =>'Dispatch Advise Register',
                                        'FFSR' =>'First & Final Stage Report',
                                        'MLS' =>'Molding Logsheet',
                                        'MELS' =>'Melting Logsheet',
                                        'CPR' =>'Core Production Report',
                                        'LOP' =>'List Of Patterns',
                                        'IRPD' =>'Inward Register & Purchased Data',
                                        'MIS' =>'Material Issue Slip',
                                        'IMTR' =>'Incoming Material Testing Register',
										'CCHR' =>'Chemical Composition & Hardness Record',
                                        'PIOL' =>'Pattern Incoming & Outgoing List',
                                        'PP' =>'Production Planning',
                                        );
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/iso-label-list',$data); 
	} 
    
    public function MRM_target()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'iso-label.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            //print_r($_POST);
           $this->db->where('status', 'Active'); 
           $this->db->update('mrm_target_info', array('status' => 'In-Active')); 
            
           $mrm_target_name = $this->input->post('mrm_target_name');
           $mrm_target_value = $this->input->post('mrm_target_value');
           
           foreach($mrm_target_name as $k => $mrm_name){ 
            $ins = array(
                    'sno' => ($k + 1),
                    'mrm_target_name' => $mrm_name,
                    'mrm_target_value' => $mrm_target_value[$k], 
                    'status' => 'Active'  ,     
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                     
            );            
            $this->db->insert('mrm_target_info', $ins); 
            }
            redirect('MRM-target');
             
        }
        
         
        $sql = "
                select 
                a.*
                from mrm_target_info as a 
                where status = 'Active'
                order by a.sno asc  
        ";
        
        
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
         
        
        $this->load->view('page/MRM-target',$data); 
	} 
    
    
    public function MRM_target_v2()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
         $data['js'] = 'mrm-target.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
           $mrm_target_name = $this->input->post('mrm_target_name');
           $mrm_target_value = $this->input->post('mrm_target_value');
           $frm_date = $this->input->post('frm_date');
           $to_date = $this->input->post('to_date');
           $grp_id = $this->input->post('grp_id');
           
           foreach($mrm_target_name as $k => $mrm_name){ 
                $ins = array(
                        'sno' => ($k + 1),
                        'grp_id' => $grp_id,
                        'frm_date' => $frm_date,
                        'to_date' => $to_date,
                        'mrm_target_name' => $mrm_name,
                        'mrm_target_value' => $mrm_target_value[$k], 
                        'status' => 'Active'  ,     
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s')                     
                    );            
                $this->db->insert('mrm_target_info', $ins);  
            }
            redirect('MRM-target-v2');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
           
           $mrm_target_name = $this->input->post('mrm_target_name');
           $mrm_target_value = $this->input->post('mrm_target_value');
           $frm_date = $this->input->post('frm_date');
           $to_date = $this->input->post('to_date');
           $grp_id = $this->input->post('grp_id');
           
           $this->db->where('grp_id', $grp_id);
           $this->db->delete('mrm_target_info');
           
           foreach($mrm_target_name as $k => $mrm_name){ 
                $ins = array(
                        'sno' => ($k + 1),
                        'grp_id' => $grp_id,
                        'frm_date' => $frm_date,
                        'to_date' => $to_date,
                        'mrm_target_name' => $mrm_name,
                        'mrm_target_value' => $mrm_target_value[$k], 
                        'status' => 'Active'  ,     
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s')                     
                    );            
                $this->db->insert('mrm_target_info', $ins);  
            }
            
            redirect('MRM-target-v2');
        } 
         
        
        $this->load->library('pagination');
        
        
        $this->db->where('status != ', 'Delete'); 
        $this->db->from('mrm_target_info');         
        $this->db->group_by('grp_id');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('MRM-target-v2/'), '/'. $this->uri->segment(2, 0));
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
                a.grp_id,                 
                a.frm_date,                
                a.to_date
                from mrm_target_info as a 
                where status != 'Delete'
                group by a.grp_id  
                order by a.grp_id  desc 
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
                a.*,
                (select max(q.grp_id) from mrm_target_info as q where q.status = 'Active' group by q.grp_id order by q.grp_id desc limit 1) as grp_id
                from mrm_target_type_info as a 
                where a.status='Active' 
                order by a.sno asc  
        ";
        
        
        
        $query = $this->db->query($sql);
        
        $data['mrm_list'] = array();
        $data['max_grp_id'] = 0;
       
        foreach ($query->result_array() as $row)
        {
            $data['mrm_list'][] = $row;     
            $data['max_grp_id'] = $row['grp_id'];     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/MRM-target-v2',$data); 
	} 
}
