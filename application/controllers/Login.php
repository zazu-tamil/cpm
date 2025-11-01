<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	 
public function index()
	{
	   
	    $data['js'] = '';
        $data['login'] = true; 
       
       	 
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_name', 'User Name', 'required');
        $this->form_validation->set_rules('user_pwd', 'Password', 'required',array('required' => 'You must provide %s.'));
        if ($this->form_validation->run() == FALSE)
        {
             
            $this->load->view('page/login',$data); 
        }
        else
        {
              
           $this->db->query('SET GLOBAL sql_mode="STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"');   
              
              
            $user_info = array(); 
            
              $sql = "
              select 
              a.user_id as id, 
              a.name, 
              a.user_name as  user_name , 
              a.level  
              from user_login as a  
              where a.user_name = '".$this->input->post('user_name')."' 
              and a.user_pwd = '".$this->input->post('user_pwd')."' 
              and a.status = 'Active' 
            "; 
          
            $query = $this->db->query($sql); 

            $cnt = $query->num_rows(); 
            
            
             
            $row = $query->row();
            
            if (isset($row))
            { 
                $newdata = array(
                   'cr_user_id'  => $row->id,
                   'cr_user_name'  => $row->user_name, 
                   'cr_name'  => $row->name, 
                  // 'cr_user_type'  => $row->typ, 
                  // 'cr_reset_flg'  => $row->reset_flg, 
                  // 'cr_pstate'  => $row->state, 
                  // 'cr_pcity'  => $row->city, 
                  // 'cr_franchise_id'  => $row->franchise_id, 
                   'cr_is_admin'  =>  $row->level, 
                   'cr_logged_in' => TRUE
               );
               
                $this->session->set_userdata($newdata);
                
                
              //$this->db->insert('crit_user_history_info',array('user_id' => $this->session->userdata('cr_user_id') , 'page' => 'Login', 'date_time' => date('Y-m-d H:i:s'))) ; 
                 
                // if($row->level == 1 or $row->level == 5)
                     redirect('dash');   
                 /*elseif($row->level == 4)
                     redirect('customer-pick-pack-list');
                 elseif($row->level == USER_PICKUP)
                     redirect('pickup-delivery');    
                 else    
                     redirect('pickup-list');*/
                    // redirect('change-login-pwd');   
            
            } 
            else 
            {
				$data['msg'] = ' Invalid User';
				$data['login'] =false;	                 
				$this->load->view('page/login',$data);
			} 			 
        } 		
	} 
    
    
}
