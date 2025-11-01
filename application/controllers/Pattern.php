<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pattern extends CI_Controller {

	 
	public function index()
	{
		 
	}
    
    
    public function pattern_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'pattern-list.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'customer_id' => implode(',',$this->input->post('customer_id')),
                    'pattern_type' => $this->input->post('pattern_type'),
                    'no_of_core' => $this->input->post('no_of_core'),
                    'match_plate_no' => $this->input->post('match_plate_no'),
                    'pattern_item' => $this->input->post('pattern_item'),
                    'box_size' => $this->input->post('box_size'),
                    'item_description' => $this->input->post('item_description'),
                    'grade' => $this->input->post('grade'),
                    'no_of_cavity' => $this->input->post('no_of_cavity'),
                    'no_of_core_box' => $this->input->post('no_of_core_box'),
                    'no_of_core_per_box' => $this->input->post('no_of_core_per_box'),
                    'corebox_material' => $this->input->post('corebox_material'),
                    'core_box' => $this->input->post('core_box'),
                    'with_transportation' => $this->input->post('with_transportation'),
                    'type_of_core' => $this->input->post('type_of_core'),
                    'yeild' => $this->input->post('yeild'),
                    'supplied_by' => $this->input->post('supplied_by'),
                    'pattern_material' => $this->input->post('pattern_material'),
                    'pattern_maker_id' => $this->input->post('pattern_maker_id'),
                    'piece_weight_per_kg' => $this->input->post('piece_weight_per_kg'), 
                    'bunch_weight' => $this->input->post('bunch_weight'), 
                    'trial_card_no' => $this->input->post('trial_card_no'), 
                    'core_maker_rate' => $this->input->post('core_maker_rate'), 
                    'grinding_rate' => $this->input->post('grinding_rate'), 
                    'core_weight' => $this->input->post('core_weight'), 
                    'casting_weight' => $this->input->post('casting_weight'), 
                    'rate_per_kg' => $this->input->post('rate_per_kg'), 
                    'rate_per_piece' => $this->input->post('rate_per_piece'), 
                    'status' => $this->input->post('status'),
                    'C' => $this->input->post('C'),
                    'SI' => $this->input->post('SI'),
                    'Mn' => $this->input->post('Mn'),
                    'P' => $this->input->post('P'),
                    'S' => $this->input->post('S'),
                    'Cr' => $this->input->post('Cr'),
                    'Cu' => $this->input->post('Cu'),
                    'Mg' => $this->input->post('Mg'),
                    'ni' => $this->input->post('ni'),
                    'mo' => $this->input->post('mo'),
                    'BHN' => $this->input->post('BHN'),
                    'tensile' => $this->input->post('tensile'),
                    'elongation' => $this->input->post('elongation'),
                    'yeild_strength' => $this->input->post('yeild_strength'),
                    'item_type' => $this->input->post('item_type'),
                    'child_pattern_1' => $this->input->post('child_pattern_1'),
                    'child_pattern_2' => $this->input->post('child_pattern_2'),
                    'child_pattern_3' => $this->input->post('child_pattern_3'),
                    'child_pattern_4' => $this->input->post('child_pattern_4'),
                    'child_pattern_5' => $this->input->post('child_pattern_5'),
                    'child_pattern_6' => $this->input->post('child_pattern_6'),
                    'child_pattern_7' => $this->input->post('child_pattern_7'),
                    'child_pattern_1_cavity' => $this->input->post('child_pattern_1_cavity'),
                    'child_pattern_2_cavity' => $this->input->post('child_pattern_2_cavity'),
                    'child_pattern_3_cavity' => $this->input->post('child_pattern_3_cavity'),
                    'child_pattern_4_cavity' => $this->input->post('child_pattern_4_cavity'),
                    'child_pattern_5_cavity' => $this->input->post('child_pattern_5_cavity'),
                    'child_pattern_6_cavity' => $this->input->post('child_pattern_6_cavity'),
                    'child_pattern_7_cavity' => $this->input->post('child_pattern_7_cavity'),
                    'child_pattern_1_pt_wt' => $this->input->post('child_pattern_1_pt_wt'),
                    'child_pattern_2_pt_wt' => $this->input->post('child_pattern_2_pt_wt'),
                    'child_pattern_3_pt_wt' => $this->input->post('child_pattern_3_pt_wt'),
                    'child_pattern_4_pt_wt' => $this->input->post('child_pattern_4_pt_wt'),
                    'child_pattern_5_pt_wt' => $this->input->post('child_pattern_5_pt_wt'),
                    'child_pattern_6_pt_wt' => $this->input->post('child_pattern_6_pt_wt'),
                    'child_pattern_7_pt_wt' => $this->input->post('child_pattern_7_pt_wt'),
                    'poring_temp' => $this->input->post('poring_temp'),
                    'inoculant_percentage' => $this->input->post('inoculant_percentage'),
                    'knock_out_time' => $this->input->post('knock_out_time'),
                    //'charge_mix' => $this->input->post('charge_mix'),
                    'pig_iron' => $this->input->post('pig_iron'),
                    'boring' => $this->input->post('boring'),
                    'ms' => $this->input->post('ms'),
                    'foundry_return' => $this->input->post('foundry_return'),
                    'CI_scrap' => $this->input->post('CI_scrap'),
                    'chaplet_size' => $this->input->post('chaplet_size'),
                    'core_reinforcement' => $this->input->post('core_reinforcement'),
                    'special_instructions' => $this->input->post('special_instructions'),
                    'moulding_instruction' => $this->input->post('moulding_instruction'),
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('pattern_info', $ins); 
            redirect('pattern-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'customer_id' => implode(',',$this->input->post('customer_id')),
                    'pattern_type' => $this->input->post('pattern_type'),
                    'no_of_core' => $this->input->post('no_of_core'),
                    'match_plate_no' => $this->input->post('match_plate_no'),
                    'pattern_item' => $this->input->post('pattern_item'),
                    'box_size' => $this->input->post('box_size'),
                    'item_description' => $this->input->post('item_description'),
                    'grade' => $this->input->post('grade'),
                    'no_of_cavity' => $this->input->post('no_of_cavity'),
                    'no_of_core_box' => $this->input->post('no_of_core_box'),
                    'no_of_core_per_box' => $this->input->post('no_of_core_per_box'),
                    'corebox_material' => $this->input->post('corebox_material'),
                    'core_box' => $this->input->post('core_box'),
                    'with_transportation' => $this->input->post('with_transportation'),
                    'type_of_core' => $this->input->post('type_of_core'),
                    'yeild' => $this->input->post('yeild'),
                    'supplied_by' => $this->input->post('supplied_by'),
                    'pattern_material' => $this->input->post('pattern_material'),
                    'pattern_maker_id' => $this->input->post('pattern_maker_id'),
                    'piece_weight_per_kg' => $this->input->post('piece_weight_per_kg'), 
                    'bunch_weight' => $this->input->post('bunch_weight'), 
                    'trial_card_no' => $this->input->post('trial_card_no'), 
                    'core_maker_rate' => $this->input->post('core_maker_rate'), 
                    'grinding_rate' => $this->input->post('grinding_rate'), 
                    'core_weight' => $this->input->post('core_weight'), 
                    'casting_weight' => $this->input->post('casting_weight'), 
                    'rate_per_kg' => $this->input->post('rate_per_kg'), 
                    'rate_per_piece' => $this->input->post('rate_per_piece'), 
                    'status' => $this->input->post('status'),
                    'C' => $this->input->post('C'),
                    'SI' => $this->input->post('SI'),
                    'Mn' => $this->input->post('Mn'),
                    'P' => $this->input->post('P'),
                    'S' => $this->input->post('S'),
                    'Cr' => $this->input->post('Cr'),
                    'Cu' => $this->input->post('Cu'),
                    'Mg' => $this->input->post('Mg'),
                    'ni' => $this->input->post('ni'),
                    'mo' => $this->input->post('mo'),
                    'BHN' => $this->input->post('BHN'),
                    'tensile' => $this->input->post('tensile'),
                    'elongation' => $this->input->post('elongation'),
                    'yeild_strength' => $this->input->post('yeild_strength'),
                    'item_type' => $this->input->post('item_type'),
                    'child_pattern_1' => $this->input->post('child_pattern_1'),
                    'child_pattern_2' => $this->input->post('child_pattern_2'),
                    'child_pattern_3' => $this->input->post('child_pattern_3'),
                    'child_pattern_4' => $this->input->post('child_pattern_4'),
                    'child_pattern_5' => $this->input->post('child_pattern_5'),
                    'child_pattern_6' => $this->input->post('child_pattern_6'),
                    'child_pattern_7' => $this->input->post('child_pattern_7'),
                    'child_pattern_1_cavity' => $this->input->post('child_pattern_1_cavity'),
                    'child_pattern_2_cavity' => $this->input->post('child_pattern_2_cavity'),
                    'child_pattern_3_cavity' => $this->input->post('child_pattern_3_cavity'),
                    'child_pattern_4_cavity' => $this->input->post('child_pattern_4_cavity'),
                    'child_pattern_5_cavity' => $this->input->post('child_pattern_5_cavity'),
                    'child_pattern_6_cavity' => $this->input->post('child_pattern_6_cavity'),
                    'child_pattern_7_cavity' => $this->input->post('child_pattern_7_cavity'),
                    'child_pattern_1_pt_wt' => $this->input->post('child_pattern_1_pt_wt'),
                    'child_pattern_2_pt_wt' => $this->input->post('child_pattern_2_pt_wt'),
                    'child_pattern_3_pt_wt' => $this->input->post('child_pattern_3_pt_wt'),
                    'child_pattern_4_pt_wt' => $this->input->post('child_pattern_4_pt_wt'),
                    'child_pattern_5_pt_wt' => $this->input->post('child_pattern_5_pt_wt'),
                    'child_pattern_6_pt_wt' => $this->input->post('child_pattern_6_pt_wt'),
                    'child_pattern_7_pt_wt' => $this->input->post('child_pattern_7_pt_wt'),
                    'poring_temp' => $this->input->post('poring_temp'),
                    'inoculant_percentage' => $this->input->post('inoculant_percentage'),
                    'knock_out_time' => $this->input->post('knock_out_time'),
                    //'charge_mix' => $this->input->post('charge_mix'),
                    'pig_iron' => $this->input->post('pig_iron'),
                    'boring' => $this->input->post('boring'),
                    'ms' => $this->input->post('ms'),
                    'foundry_return' => $this->input->post('foundry_return'),
                    'CI_scrap' => $this->input->post('CI_scrap'),
                    'chaplet_size' => $this->input->post('chaplet_size'),
                    'core_reinforcement' => $this->input->post('core_reinforcement'), 
                    'special_instructions' => $this->input->post('special_instructions'),
                    'moulding_instruction' => $this->input->post('moulding_instruction'),
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('pattern_id', $this->input->post('pattern_id'));
            $this->db->update('pattern_info', $upd); 
            
           /* echo "<pre>";
            print_r($_POST);
            print_r($upd);
            echo "</pre>";*/
                            
            redirect('pattern-list/' . $this->uri->segment(2, 0)); 
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
         //$where .= " and a.customer_id = '". $srch_customer ."'";
         $where .= " and FIND_IN_SET(  '". $srch_customer ."' , a.customer_id)";
       }
        
        
       if(!empty($srch_key)) {
         $where .= " and (  
                        a.pattern_item like '%". $srch_key ."%'  
                        ) ";
         
       } 
        
        
        $this->db->where('status != ', 'Delete');
        if(!empty($srch_customer) )
            $this->db->where("a.customer_id = '". $srch_customer ."'"); 
        if(!empty($srch_key))   
            $this->db->where("a.pattern_item like '%". $srch_key ."%'");  
            
        $this->db->from('pattern_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('pattern-list/'), '/'. $this->uri->segment(2, 0));
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
                    a.pattern_id,
                    GROUP_CONCAT( b.company_name) as customer,
                    a.pattern_type,
                    a.no_of_core, 
                    a.match_plate_no, 
                    a.pattern_item, 
                    a.box_size,
                    a.item_description, 
                    c.grade_name as grade, 
                    a.no_of_cavity, 
                    a.piece_weight_per_kg, 
                    a.bunch_weight,  
                    a.trial_card_no, 
                    a.core_maker_rate, 
                    a.grinding_rate, 
                    a.core_weight,
                    a.casting_weight, 
                    a.rate_per_kg, 
                    a.rate_per_piece, 
                    a.yeild, 
                    a.type_of_core, 
                    a.`status` ,
                    a.item_type                
                    from pattern_info as a
                    left join customer_info as b on FIND_IN_SET( b.customer_id , a.customer_id)
                    left join grade_info as c on c.grade_id = a.grade
                where b.`status` = 'Active' and  a.status != 'Delete' 
                and ". $where ."
                group by a.pattern_id
                order by a.status asc ,b.company_name,a.match_plate_no, a.pattern_item asc 
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
                a.grade_id,                
                a.grade_name             
                from grade_info as a  
                where a.status = 'Active' 
                order by a.grade_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['grade_opt'][$row['grade_id']] = $row['grade_name'];     
        }
        
        
        $sql = "
                select 
                a.pattern_maker_id,                
                a.company_name             
                from pattern_maker_info as a  
                where a.status = 'Active' 
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_maker_opt'][$row['pattern_maker_id']] = $row['company_name'];     
        }
        
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item,
                a.customer_id,
                b.company_name as customer,
                a.piece_weight_per_kg             
                from pattern_info as a  
                left join customer_info as b on FIND_IN_SET(  b.customer_id , a.customer_id )  
                where a.status = 'Active' and a.item_type = 'Child'
                order by b.company_name , a.pattern_item  asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['child_pattern_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['child_pattern_opt'][$row['customer']][$row['pattern_id']] =  $row['pattern_item'] . ' || ' . $row['piece_weight_per_kg'];     
        }
        
        
        $data['type_of_core_opt'] = array('Amine Core' => 'Amine Core' , 'Air Setting Core' => 'Air Setting Core', 'CO2 Core' => 'CO2 Core','Green Sand Core' => 'Green Sand Core');
        
        $data['pagination'] = $this->pagination->create_links();
		
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
        
        $this->load->view('page/pattern-list',$data); 
	} 
    
    
    public function pattern_in_out_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'pattern-in-out.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'customer_id' => $this->input->post('customer_id'),
                    'pattern_in_out_date' => $this->input->post('pattern_in_out_date'),
                    'pattern_in_out_type' => $this->input->post('pattern_in_out_type'),
                    'dc_no' => ($this->input->post('pattern_in_out_type') == 'Outward' ? $this->input->post('dc_no'): '0'),
                    'pattern_id' => $this->input->post('pattern_id'),
                    'pattern_maker_id' => $this->input->post('pattern_maker_id'),
                    'reason' => $this->input->post('reason'),
                    'dc_ref_no' => $this->input->post('dc_ref_no'),
                    'dc_ref_date' => $this->input->post('dc_ref_date'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('pattern_in_out_ward_info', $ins); 
            redirect('pattern-in-out-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'customer_id' => $this->input->post('customer_id'),
                    'pattern_in_out_date' => $this->input->post('pattern_in_out_date'),
                    'pattern_in_out_type' => $this->input->post('pattern_in_out_type'),
                    'dc_no' => ($this->input->post('pattern_in_out_type') == 'Outward' ? $this->input->post('dc_no'): '0'),
                    'pattern_id' => $this->input->post('pattern_id'),
                    'pattern_maker_id' => $this->input->post('pattern_maker_id'),
                    'reason' => $this->input->post('reason'),
                    'dc_ref_no' => $this->input->post('dc_ref_no'),
                    'dc_ref_date' => $this->input->post('dc_ref_date'), 
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('pattern_in_out_id', $this->input->post('pattern_in_out_id'));
            $this->db->update('pattern_in_out_ward_info', $upd); 
                            
            redirect('pattern-in-out-list/' . $this->uri->segment(2, 0)); 
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
       
       
       $where = '1';

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
        
        
        $this->db->where('status != ', 'Delete');
        if(!empty($srch_key))
            $this->db->where($where);
        $this->db->from('pattern_in_out_ward_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('pattern-in-out-list/'), '/'. $this->uri->segment(2, 0));
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
                a.pattern_in_out_id, 
                a.pattern_in_out_date, 
                a.pattern_in_out_type, 
                b.company_name as customer, 
                d.company_name as pattern_maker, 
                c.pattern_item, 
                a.reason, 
                a.dc_ref_no, 
                a.dc_ref_date
                from pattern_in_out_ward_info as a
                left join customer_info as b on b.customer_id = a.customer_id
                left join pattern_info as c on c.pattern_id = a.pattern_id
                left join pattern_maker_info as d on d.pattern_maker_id = a.pattern_maker_id
                where ". $where ." and a.status != 'Delete'
                order by  c.pattern_item asc 
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
                a.pattern_maker_id,                
                a.company_name             
                from pattern_maker_info as a  
                where a.status = 'Active' 
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_maker_opt'][$row['pattern_maker_id']] = $row['company_name'];     
        }
         
        $this->db->select('(ifnull(max(dc_no),0) + 1) as dc_no');
        $this->db->where('status != "Delete"');
        $query = $this->db->get('pattern_in_out_ward_info');
        $row = $query->row();
        if (isset($row)) {
            $data['dc_no'] = str_pad($row->dc_no,5,0,STR_PAD_LEFT);
        }  
         
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/pattern-in-out-list',$data); 
	} 
    
    public function pattern_in_out_list_v2()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'pattern-in-out-v2.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $customer_ids = $this->input->post('customer_id');
            $pattern_ids = $this->input->post('pattern_id');
            $reasons = $this->input->post('reason');
            $show_cavitys = $this->input->post('show_cavity');
            $show_core_boxs = $this->input->post('show_core_box');
            foreach($customer_ids as $k => $customer_id){
                if((!empty($customer_id)) && (!empty($pattern_ids[$k])) && (!empty($reasons[$k]))) {
                    $ins = array(
                            'customer_id' => $customer_id,
                            'pattern_in_out_date' => $this->input->post('pattern_in_out_date'),
                            'pattern_in_out_type' => $this->input->post('pattern_in_out_type'),
                            'dc_no' => ($this->input->post('pattern_in_out_type') == 'Outward' ? $this->input->post('dc_no'): '0'),
                            'pattern_id' => $pattern_ids[$k],
                            'pattern_maker_id' => $this->input->post('pattern_maker_id'),
                            'reason' => $reasons[$k],
                            'dc_ref_no' => $this->input->post('dc_ref_no'),
                            'dc_ref_date' => $this->input->post('dc_ref_date'), 
                            'vehicle_no' => $this->input->post('vehicle_no'), 
                            'show_cavity' => $show_cavitys[$k], 
                            'show_core_box' => $show_core_boxs[$k], 
                            'created_by' => $this->session->userdata('cr_user_id'),                          
                            'created_datetime' => date('Y-m-d H:i:s')                           
                    ); 
                   
                    $this->db->insert('pattern_in_out_ward_info', $ins); 
                }
                
                //
                
                //echo "<pre>";
                //print_r($ins);
               // echo "</pre>";
            }
            redirect('pattern-in-out-list-v2');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            
            $customer_ids = $this->input->post('customer_id');
            $pattern_ids = $this->input->post('pattern_id');
            $reasons = $this->input->post('reason');
            $pattern_in_out_ids = $this->input->post('pattern_in_out_id');
            $show_cavitys = $this->input->post('show_cavity');
            $show_core_boxs = $this->input->post('show_core_box');
            foreach($customer_ids as $k => $customer_id){
                if((!empty($customer_id)) && (!empty($pattern_ids[$k])) && (!empty($reasons[$k])) && (!empty($pattern_in_out_ids[$k]))) {
                    $upd = array(
                            'customer_id' => $customer_id,
                            'pattern_in_out_date' => $this->input->post('pattern_in_out_date'),
                            'pattern_in_out_type' => $this->input->post('pattern_in_out_type'),
                            'dc_no' => ($this->input->post('pattern_in_out_type') == 'Outward' ? $this->input->post('dc_no'): '0'),
                            'pattern_id' => $pattern_ids[$k],
                            'pattern_maker_id' => $this->input->post('pattern_maker_id'),
                            'reason' => $reasons[$k],
                            'dc_ref_no' => $this->input->post('dc_ref_no'),
                            'dc_ref_date' => $this->input->post('dc_ref_date'), 
                            'vehicle_no' => $this->input->post('vehicle_no'), 
                            'show_cavity' => $show_cavitys[$k], 
                            'show_core_box' => $show_core_boxs[$k],  
                            'updated_by' => $this->session->userdata('cr_user_id'),                          
                            'updated_datetime' => date('Y-m-d H:i:s')                          
                    ); 
                   
                    $this->db->where('pattern_in_out_id', $pattern_in_out_ids[$k]);
                    $this->db->update('pattern_in_out_ward_info', $upd); 
                }
                
                if((!empty($customer_id)) && (!empty($pattern_ids[$k])) && (!empty($reasons[$k])) && (empty($pattern_in_out_ids[$k]))) {
                
                     $ins = array(
                            'customer_id' => $customer_id,
                            'pattern_in_out_date' => $this->input->post('pattern_in_out_date'),
                            'pattern_in_out_type' => $this->input->post('pattern_in_out_type'),
                            'dc_no' => ($this->input->post('pattern_in_out_type') == 'Outward' ? $this->input->post('dc_no'): '0'),
                            'pattern_id' => $pattern_ids[$k],
                            'pattern_maker_id' => $this->input->post('pattern_maker_id'),
                            'reason' => $reasons[$k],
                            'dc_ref_no' => $this->input->post('dc_ref_no'),
                            'dc_ref_date' => $this->input->post('dc_ref_date'), 
                            'vehicle_no' => $this->input->post('vehicle_no'), 
                            'show_cavity' => $show_cavitys[$k], 
                            'show_core_box' => $show_core_boxs[$k], 
                            'created_by' => $this->session->userdata('cr_user_id'),                          
                            'created_datetime' => date('Y-m-d H:i:s')                           
                    ); 
                   
                    $this->db->insert('pattern_in_out_ward_info', $ins); 
                
                }
                
                 
            }
            
             
            /*echo "<pre>";
            print_r($_POST); 
            echo "</pre>";*/
                            
            redirect('pattern-in-out-list-v2/' . $this->uri->segment(2, 0)); 
        }  
         
         
        
       $this->load->library('pagination');
        
       if(isset($_POST['srch_customer'])) {
           $data['srch_customer'] = $srch_customer = $this->input->post('srch_customer'); 
           $this->session->set_userdata('srch_customer', $this->input->post('srch_customer'));
            
       } elseif ($this->session->userdata('srch_customer')){
           $data['srch_customer'] = $srch_customer = $this->session->userdata('srch_customer') ; 
       } else {
           $data['srch_customer'] = $srch_customer = '';
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
       
       
       $where = '1';

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
        
        
        $this->db->where('status != ', 'Delete');
        if(!empty($srch_key))
            $this->db->where($where);
        $this->db->from('pattern_in_out_ward_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('pattern-in-out-list-v2/'), '/'. $this->uri->segment(2, 0));
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
        
     /*   $sql = "
                select  
                a.pattern_in_out_id, 
                a.pattern_in_out_date, 
                a.pattern_in_out_type, 
                b.company_name as customer, 
                d.company_name as pattern_maker, 
                c.pattern_item, 
                a.reason, 
                a.dc_ref_no, 
                a.dc_ref_date
                from pattern_in_out_ward_info as a
                left join customer_info as b on b.customer_id = a.customer_id
                left join pattern_info as c on c.pattern_id = a.pattern_id
                left join pattern_maker_info as d on d.pattern_maker_id = a.pattern_maker_id
                where ". $where ." and a.status != 'Delete'
                order by pattern_in_out_date desc, c.pattern_item asc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";*/
        
        $sql = " 
            select  
            b.company_name as pattern_maker,
            a.pattern_in_out_date,
            a.pattern_in_out_type,
            a.dc_no,
            if(a.pattern_in_out_type != 'Inward',a.dc_no, concat(a.dc_ref_no , ' <br> ' ,a.dc_ref_date)) as dc, 
            GROUP_CONCAT(a.pattern_in_out_id) as ids ,
            count(a.pattern_in_out_id) as cnt ,
            DATEDIFF(current_date(), a.pattern_in_out_date) as days
            from pattern_in_out_ward_info as a
            left join pattern_maker_info as b on b.pattern_maker_id = a.pattern_maker_id
            where a.`status` != 'Delete'
            group by a.pattern_in_out_date , a.pattern_in_out_type , a.pattern_maker_id , a.dc_no , a.dc_ref_no  ,a.dc_ref_date
            order by a.pattern_in_out_date desc 
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
                a.pattern_maker_id,                
                a.company_name             
                from pattern_maker_info as a  
                where a.status = 'Active' 
                order by a.company_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_maker_opt'][$row['pattern_maker_id']] = $row['company_name'];     
        }
         
        $this->db->select('(ifnull(max(dc_no),0) + 1) as dc_no');
        $this->db->where('status != "Delete"');
        $query = $this->db->get('pattern_in_out_ward_info');
        $row = $query->row();
        if (isset($row)) {
            $data['dc_no'] = str_pad($row->dc_no,5,0,STR_PAD_LEFT);
        } 
        
        $data['pagination'] = $this->pagination->create_links();
		
		$sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'PIOL'
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
        
        $this->load->view('page/pattern-in-out-list-v2',$data); 
	} 
    
    public function work_order_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'work-order-list.inc';  
        
         
         
        
       $this->load->library('pagination');
       
       if(isset($_POST['srch_date'])) { 
           $data['srch_date'] = $srch_date = $this->input->post('srch_date');  
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $this->session->set_userdata('srch_date', $this->input->post('srch_date')); 
           $this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date')); 
       } 
       elseif($this->session->userdata('srch_date')){
           $data['srch_date'] = $srch_date = $this->session->userdata('srch_date') ; 
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ; 
       } else {
         
        $data['srch_date'] = $srch_date = '';
        $data['srch_to_date'] = $srch_to_date = '';
       } 
        
       if(isset($_POST['srch_customer_id'])) {
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           $this->session->set_userdata('srch_customer_id', $this->input->post('srch_customer_id'));
            
       }
       elseif($this->session->userdata('srch_customer_id')){
           $data['srch_customer_id'] = $srch_customer_id = $this->session->userdata('srch_customer_id') ; 
       }else {
           $data['srch_customer_id'] = $srch_customer_id = '';
       }
       
       if(isset($_POST['srch_pattern_id'])) {
           $data['srch_pattern_id'] = $srch_pattern_id = $this->input->post('srch_pattern_id'); 
           $this->session->set_userdata('srch_pattern_id', $this->input->post('srch_pattern_id'));
            
       }
       elseif($this->session->userdata('srch_customer_id')){
           $data['srch_pattern_id'] = $srch_pattern_id = $this->session->userdata('srch_pattern_id') ; 
       }else {
           $data['srch_pattern_id'] = $srch_pattern_id = '';
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
       
       
       $where = '1';
       if(!empty($srch_date)){
         $where .= " and a.order_date between '". $srch_date ."' and '". $srch_to_date ."'";
       } 
       if(!empty($srch_customer_id)){
         $where .= " and a.customer_id = '". $srch_customer_id ."'";
       }
       if(!empty($srch_pattern_id)){
         $where .= " and exists (select z.work_order_id from work_order_items_info as z where z.status='Active' and z.work_order_id = a.work_order_id and z.pattern_id = '". $srch_pattern_id ."') ";
       } 
       /*if(!empty($srch_state)){
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
       $data['pattern_opt'] =array();
       if(!empty($srch_customer_id) ){    
            
        $sql = "
                select 
                a.pattern_id,                
                a.pattern_item  
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $srch_customer_id. "' , a.customer_id ) 
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
        
        
        $this->db->where('status != ', 'Delete');
        $this->db->where($where); 
        $this->db->from('work_order_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('work-order-list/'), '/'. $this->uri->segment(2, 0));
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
                    a.work_order_id,
                    a.order_date,
                    a.work_order_no,
                    b.company_name as customer,
                    a.customer_PO_No,
                    a.mode_of_order, 
                    a.is_conversion_type, 
                    a.remarks,
                    count(c.work_order_item_id) as no_of_item,
                    round(sum(if(d.item_type = 'Parent',(c.qty / d.no_of_cavity),0)),0) as tot_box, 
                    round((round(sum((if(d.item_type = 'Parent',(c.qty / d.no_of_cavity),0) * d.bunch_weight)),3) /1000),3) as total_tonage                
                    from work_order_info as a
                    left join customer_info as b on b.customer_id = a.customer_id 
                    left join work_order_items_info as c on c.work_order_id = a.work_order_id
                    left join pattern_info as d on d.pattern_id = c.pattern_id  
                where a.`status` != 'Delete'  and d.status= 'Active'
                and ". $where ."
                group by a.work_order_id
                order by a.order_date desc 
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
        
         
        
        
        $data['pagination'] = $this->pagination->create_links();
		
		$sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'OR'
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
        
        $this->load->view('page/work-order-list',$data); 
	} 
    
    public function work_order_entry()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                        'order_date' => $this->input->post('order_date'),
                        'work_order_no' => $this->input->post('work_order_no'),
                        'customer_id' => $this->input->post('customer_id'),
                        'customer_PO_No' => $this->input->post('customer_PO_No'),
                        'mode_of_order' => $this->input->post('mode_of_order'),
                        'remarks' => $this->input->post('remarks'),                       
                        'is_conversion_type' => $this->input->post('is_conversion_type'), 
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s')                                               
                );                
          $this->db->insert('work_order_info', $ins);
          
          $insert_id = $this->db->insert_id();
          
          $pattern_ids = $this->input->post('pattern_id');
          $qtys = $this->input->post('qty');
          $uoms = $this->input->post('uom');
          $weight_per_pieces = $this->input->post('weight_per_piece');
          $total_weights = $this->input->post('total_weight');
          $delivery_dates = $this->input->post('delivery_date');
          foreach($pattern_ids as $ind => $pattern_id)
          {
                $ins = array(
                        'work_order_id' => $insert_id,
                        'pattern_id' => $pattern_id, 
                        'qty' => $qtys[$ind],
                        'uom' => $uoms[$ind],
                        'weight_per_piece' => $weight_per_pieces[$ind],                       
                        'total_weight' => $total_weights[$ind], 
                        'delivery_date' =>$delivery_dates[$ind], 
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s')                                               
                );                
                $this->db->insert('work_order_items_info', $ins);
				
				$sql= "select GROUP_CONCAT( a.child_pattern_1,',', ifnull(a.child_pattern_2,0),',',ifnull(a.child_pattern_3,0),',',ifnull(a.child_pattern_4,0),',',ifnull(a.child_pattern_5,0),',',ifnull(a.child_pattern_6,0),',',ifnull(a.child_pattern_7,0)) as chld_pat_ids from  pattern_info as a where a.item_type = 'Parent' and a.pattern_id = '". $pattern_id ."' ";
				
				$query = $this->db->query($sql);
        
				$chld_pat_ids = '';
			   
				foreach ($query->result_array() as $row)
				{
					$chld_pat_ids = $row['chld_pat_ids'];     
				}    
				
				if(!empty($chld_pat_ids)){
				 $sql_insert = "
						insert into work_order_items_info ( work_order_id,pattern_id ,uom , qty,  weight_per_piece,total_weight, created_by,created_datetime,delivery_date) 
						select '". $insert_id."', q.pattern_id,'". $uoms[$ind] ."' ,'".$qtys[$ind]."',  q.piece_weight_per_kg, ( ".$qtys[$ind]." * q.piece_weight_per_kg ), '".$this->session->userdata('cr_user_id')."' ,   now(), '". $delivery_dates[$ind] ."' from pattern_info as q 
						where q.pattern_id in ( ". $chld_pat_ids .");
					    ";
				 $this->db->query($sql_insert);
				 }
				 
          }
          
          redirect('work-order-entry');   
          
                 
        }
        	    
        $data['js'] = 'work-order-entry.inc';  
        
       
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
                a.uom_id,                
                a.uom_name             
                from uom_info as a  
                where status = 'Active' 
                order by a.uom_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['uom_opt'][$row['uom_id']] = $row['uom_name'] ;     
        }
        
        
        $this->db->select('(ifnull(max(work_order_no),0) + 1) as work_order_no');
        $query = $this->db->get('work_order_info');
        $row = $query->row();
        if (isset($row)) {
            $data['work_order_no'] = str_pad($row->work_order_no,4,0,STR_PAD_LEFT);
        }  
         /*
        
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
           
        */
           
		$this->load->view('page/work-order-entry',$data); 
	}
    
    public function work_order_edit($work_order_id)
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
                        'order_date' => $this->input->post('order_date'),
                        'work_order_no' => $this->input->post('work_order_no'),
                        'customer_id' => $this->input->post('customer_id'),
                        'customer_PO_No' => $this->input->post('customer_PO_No'),
                        'mode_of_order' => $this->input->post('mode_of_order'),
                        'remarks' => $this->input->post('remarks'),                       
                        'is_conversion_type' => $this->input->post('is_conversion_type'),                
                        'status' => $this->input->post('status'),                
                        'updated_datetime' => date('Y-m-d H:i:s')                                               
                );                
          $this->db->where('work_order_id', $work_order_id);
          $this->db->update('work_order_info', $upd);
          
          $cr_pattern_ids = $this->input->post('cr_pattern_id');
          $cr_qtys = $this->input->post('cr_qty');
          $cr_uoms = $this->input->post('cr_uom');
          $cr_weight_per_pieces = $this->input->post('cr_weight_per_piece');
          $cr_total_weights = $this->input->post('cr_total_weight');
          $cr_delivery_dates = $this->input->post('cr_delivery_date');
          
          foreach($cr_pattern_ids as $cr_ind => $cr_pattern_id)
          {
              if(!empty($cr_pattern_id)) {
                    $upd1 = array(
                            'work_order_id' => $work_order_id,
                            'pattern_id' => $cr_pattern_id, 
                            'qty' => $cr_qtys[$cr_ind],
                            'uom' => $cr_uoms[$cr_ind],
                            'weight_per_piece' => $cr_weight_per_pieces[$cr_ind],                       
                            'total_weight' => $cr_total_weights[$cr_ind], 
                            'delivery_date' =>$cr_delivery_dates[$cr_ind],                          
                            'updated_datetime' => date('Y-m-d H:i:s')                                               
                    );           
                    $this->db->where('work_order_item_id', $cr_ind);     
                    $this->db->update('work_order_items_info', $upd1);
               } 
          } 
          
          $pattern_ids = $this->input->post('pattern_id');
          $qtys = $this->input->post('qty');
          $uoms = $this->input->post('uom');
          $weight_per_pieces = $this->input->post('weight_per_piece');
          $total_weights = $this->input->post('total_weight');
          $delivery_dates = $this->input->post('delivery_date');
          if(!empty($pattern_ids)) {
              foreach($pattern_ids as $ind => $pattern_id)
              {
                  if(!empty($pattern_id)) {
                    $ins = array(
                            'work_order_id' => $work_order_id,
                            'pattern_id' => $pattern_id, 
                            'qty' => $qtys[$ind],
                            'uom' => $uoms[$ind],
                            'weight_per_piece' => $weight_per_pieces[$ind],                       
                            'total_weight' => $total_weights[$ind], 
                            'delivery_date' =>$delivery_dates[$ind], 
                            'created_by' => $this->session->userdata('cr_user_id'),                          
                            'created_datetime' => date('Y-m-d H:i:s')                                               
                    );                
                    $this->db->insert('work_order_items_info', $ins);
                    }
              }
          }
          
          redirect('work-order-edit/'. $work_order_id);    
                 
        }
        	    
        $data['js'] = 'work-order-entry.inc';  
        
       
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
                a.uom_id,                
                a.uom_name             
                from uom_info as a  
                where status = 'Active' 
                order by a.uom_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['uom_opt'][$row['uom_id']] = $row['uom_name'] ;     
        }
        
       $sql = "
                select 
                a.work_order_id,
                a.order_date,
                a.work_order_no,
                a.customer_id,
                a.customer_PO_No,
                a.mode_of_order, 
                a.is_conversion_type, 
                a.remarks ,
                a.status               
                from work_order_info as a 
                where a.work_order_id = '". $work_order_id ."'
                order by a.order_date desc                 
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list']['mst'] = $row;     
        } 
         
        $sql = "
                select 
                a.work_order_item_id,
                a.pattern_id,
                a.uom,
                a.qty,
                a.weight_per_piece,
                a.total_weight,
                a.delivery_date         
                from work_order_items_info as a 
                where a.status != 'Delete' and a.work_order_id = '". $work_order_id ."'
                order by a.work_order_item_id asc                 
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
                a.match_plate_no ,
                a.item_type          
                from pattern_info as a  
                where status = 'Active' 
                and FIND_IN_SET( '". $data['record_list']['mst']['customer_id']."' , a.customer_id )  
                order by a.pattern_item asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['pattern_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['pattern_opt'][$row['pattern_id']] = $row['match_plate_no']. " || ". $row['pattern_item'] . ' [ ' . $row['item_type']. ' ]';     
        }
        
           
		$this->load->view('page/work-order-edit',$data); 
	}
    
    public function core_planning()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        
        $data['js'] = 'core.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $pattern_ids = $this->input->post('pattern_id');
            $customer_id = $this->input->post('customer_id');
            $plan_qty = $this->input->post('plan_qty');
           // print_r($_POST);
            
            foreach($pattern_ids as $k=> $pattern_id) {
               $ins = array(
                        'core_plan_date' => $this->input->post('core_plan_date'),
                        'core_maker_id' => $this->input->post('core_maker_id'),
                        'customer_id' => $customer_id[$pattern_id], 
                        'pattern_id' => $pattern_id,
                        'plan_qty' => $plan_qty[$pattern_id], 
                        'status' => 'Plan', 
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s')                           
                );
            
            $this->db->insert('core_plan_info', $ins); 
            }
            
            redirect('core-planning'); 
            
             
        }
        
        $sql = "
                 select 
                    b.pattern_id,
                    a.customer_id,
                    a.order_date,
                    a.work_order_no,
                    c.company_name as customer,
                    a.customer_PO_No,
                    d.pattern_type,
                    d.match_plate_no,
                    d.pattern_item,
                    d.no_of_core,
                    d.no_of_cavity,
                    d.no_of_core_box,
                    d.core_weight,
                    sum((b.qty + (b.qty * 10 /100) * d.no_of_core)) as wo_core_req ,
                    sum((b.qty + (b.qty * 10 /100) * d.no_of_core)/ d.no_of_cavity) as wo_core_req_box ,
                    (ifnull(e.produced_qty,0) * d.no_of_core ) as avail_qty,
                    ((ifnull(e.produced_qty,0) * d.no_of_core ) / d.no_of_cavity) as avail_box,
                    (sum((b.qty + (b.qty * 10 /100) * d.no_of_core)) - 0 ) as bal_qty,
                    (sum((b.qty + (b.qty * 10 /100) * d.no_of_core)/ d.no_of_cavity) - 0 ) as bal_box ,
                    ((sum((b.qty + (b.qty * 10 /100) * d.no_of_core)/ d.no_of_cavity) - 0 ) * d.core_weight) as bal_wt 
                    from work_order_info as a
                    left join work_order_items_info as b on b.work_order_id = a.work_order_id 
                    left join customer_info as c on c.customer_id = a.customer_id
                    left join pattern_info as d on d.pattern_id = b.pattern_id
                    left join (select sum((z.produced_qty - z.damage_qty)) as produced_qty ,z.pattern_id  from core_plan_info as z where z.status != 'Delete' group by z.pattern_id  ) as e on e.pattern_id = b.pattern_id 
                    where a.`status`!= 'Delete'  
                    and d.pattern_type = 'Core'     
                    group by b.pattern_id
                    order by d.match_plate_no  asc , d.pattern_item asc            
        ";
        
         
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
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
        
        
        $this->load->view('page/core-planning',$data); 
    }
    
    public function core_production()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'core.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array( 
                    'core_plan_date' => $this->input->post('core_plan_date'),
                    'core_maker_id' => $this->input->post('core_maker_id'),
                    'customer_id' => $this->input->post('customer_id'),
                    'pattern_id' => $this->input->post('pattern_id'),
                    'core_item_id' => $this->input->post('core_item_id'),
                    'core_hardness' => $this->input->post('core_hardness'),
                    'inspected_qty' => $this->input->post('inspected_qty'),
                    'produced_qty' => $this->input->post('produced_qty'), 
                    'damage_qty' => $this->input->post('damage_qty'),
                    'm_damage_qty' => $this->input->post('m_damage_qty'),
                    'core_maker_rate' => $this->input->post('core_maker_rate'),  
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                   
            ); 
            
            $this->db->insert('core_plan_info', $ins); 
                            
            redirect('core-production'); 
        }  
         
         
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array( 
                    'core_plan_date' => $this->input->post('core_plan_date'),
                    'core_maker_id' => $this->input->post('core_maker_id'),
                    'customer_id' => $this->input->post('customer_id'),
                    'pattern_id' => $this->input->post('pattern_id'),
                    'core_item_id' => $this->input->post('core_item_id'), 
                    'produced_qty' => $this->input->post('produced_qty'), 
                    'core_hardness' => $this->input->post('core_hardness'),
                    'inspected_qty' => $this->input->post('inspected_qty'),
                    'damage_qty' => $this->input->post('damage_qty'),
                    'm_damage_qty' => $this->input->post('m_damage_qty'),
                    'core_maker_rate' => $this->input->post('core_maker_rate'), 
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                
            ); 
            
            $this->db->where('core_plan_id', $this->input->post('core_plan_id')); 
            $this->db->update('core_plan_info', $upd); 
                            
            redirect('core-production'); 
        }   
         
        
       $this->load->library('pagination');
        
       if(isset($_POST['srch_date'])) {
           $data['srch_date'] = $srch_date = $this->input->post('srch_date'); 
           $this->session->set_userdata('srch_date', $this->input->post('srch_date'));
            
       }
       elseif($this->session->userdata('srch_date')){
           $data['srch_date'] = $srch_date = $this->session->userdata('srch_date') ; 
       }else {
           $data['srch_date'] = $srch_date = date('Y-m-d');
       }
       
       
       
       
       $where = '1';

       if(!empty($srch_date)){
         $where .= " and a.core_plan_date = '". $srch_date ."'";
       }
        
       
        
        
        $this->db->where('status != ', 'Delete'); 
        $this->db->where($where);
        $this->db->from('core_plan_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('core-production/'), '/'. $this->uri->segment(2, 0));
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
                a.core_plan_id, 
                a.core_plan_date, 
                d.company_name as core_maker,
                b.company_name as customer, 
                c.pattern_item, 
                e.core_item_name as core_item,
                c.match_plate_no,
                a.plan_qty, 
                a.produced_qty, 
                a.damage_qty, 
                a.core_maker_rate,
                DATEDIFF(current_date(), a.core_plan_date) as days 
                from core_plan_info as a
                left join customer_info as b on b.customer_id = a.customer_id
                left join pattern_info as c on c.pattern_id = a.pattern_id
                left join core_maker_info as d on d.core_maker_id = a.core_maker_id
                left join core_item_info as e on e.core_item_id = a.core_item_id and e.status = 'Active'
                where a.status != 'Delete'  and ". $where ."
                order by  a.core_plan_date desc 
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
		
		
		$sql ="select 
                a.iso_label_ctnt,
                a.iso_label_ctnt_footer
                from iso_label_info as a
                where a.`status` = 'Active'
                and a.label_for = 'CPR'
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
         
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/core-production',$data); 
	} 
    
    public function core_floor_stock()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'floor-core.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'floor_stock_date' => $this->input->post('floor_stock_date'),
                    'customer_id' => $this->input->post('customer_id'), 
                    'pattern_id' => $this->input->post('pattern_id'),
                    'core_item_id' => $this->input->post('core_item_id'),
                    'stock_qty' => $this->input->post('stock_qty'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('core_floor_stock_info', $ins); 
            redirect('core-floor-stock');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'floor_stock_date' => $this->input->post('floor_stock_date'),
                    'customer_id' => $this->input->post('customer_id'), 
                    'pattern_id' => $this->input->post('pattern_id'),
                    'core_item_id' => $this->input->post('core_item_id'),
                    'stock_qty' => $this->input->post('stock_qty'), 
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('core_floor_stock_id', $this->input->post('core_floor_stock_id'));
            $this->db->update('core_floor_stock_info', $upd); 
                            
            redirect('core-floor-stock/' . $this->uri->segment(2, 0)); 
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
       
       
       $where = '1';

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
        if(!empty($srch_customer)){ 
            $this->db->where($where); 
        }
        $this->db->from('core_floor_stock_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('core-floor-stock/'), '/'. $this->uri->segment(2, 0));
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
                a.core_floor_stock_id, 
                a.floor_stock_date, 
                b.company_name as customer, 
                c.pattern_item, 
                d.core_item_name, 
                a.stock_qty ,
                DATEDIFF(current_date(), a.floor_stock_date) as days  
                from core_floor_stock_info as a
                left join customer_info as b on b.customer_id = a.customer_id
                left join pattern_info as c on c.pattern_id = a.pattern_id
                left join core_item_info as d on d.core_item_id = a.core_item_id
                where ". $where ."
                order by  a.floor_stock_date desc ,b.company_name,  c.pattern_item, d.core_item_name 
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
         
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/core-floor-stock',$data); 
	} 
    
    public function floor_stock()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'floor-stock.inc';  
        
        if($this->input->post('mode') == 'Add')
        {
            $ins = array(
                    'floor_stock_date' => $this->input->post('floor_stock_date'),
                    'customer_id' => $this->input->post('customer_id'), 
                    'pattern_id' => $this->input->post('pattern_id'), 
                    'stock_qty' => $this->input->post('stock_qty'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')                           
            );
            
            $this->db->insert('floor_stock_info', $ins); 
            redirect('floor-stock');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'floor_stock_date' => $this->input->post('floor_stock_date'),
                    'customer_id' => $this->input->post('customer_id'), 
                    'pattern_id' => $this->input->post('pattern_id'), 
                    'stock_qty' => $this->input->post('stock_qty'), 
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                 
            );
            
            $this->db->where('floor_stock_id', $this->input->post('core_floor_stock_id'));
            $this->db->update('floor_stock_info', $upd); 
                            
            redirect('core-floor-stock/' . $this->uri->segment(2, 0)); 
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
        $this->db->from('floor_stock_info as a');         
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
                a.floor_stock_id, 
                a.floor_stock_date, 
                b.company_name as customer, 
                c.pattern_item, 
                a.stock_qty,
                DATEDIFF(current_date(), a.floor_stock_date) as days  
                from floor_stock_info as a
                left join customer_info as b on b.customer_id = a.customer_id
                left join pattern_info as c on c.pattern_id = a.pattern_id 
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
         
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/floor-stock',$data); 
	} 
    
    public function print_pattern_out_dc($pattern_in_out_id)
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
       
        
     /*   $sql = "
                select  
                a.pattern_in_out_id,
                a.dc_no,
                a.pattern_in_out_date,
                b.pattern_item,
                c.company_name as pattern_maker,
                c.contact_person,
                c.address_line,
                c.area,
                c.city, 
                c.mobile,
                a.vehicle_no,
                a.reason,
                1 as qty 
                from pattern_in_out_ward_info as a
                left join pattern_info as b on b.pattern_id= a.pattern_id
                left join pattern_maker_info as c on c.pattern_maker_id= a.pattern_maker_id
                where a.`status` != 'Delete' and a.pattern_in_out_type = 'Outward'
                and a.pattern_in_out_id = '". $pattern_in_out_id ."'      
                order by a.pattern_in_out_date desc                 
        ";*/
        
        $sql = "
                select  
                a.pattern_in_out_id,
                a.dc_no,
                a.pattern_in_out_date,
                b.pattern_item,
                c.company_name as pattern_maker,
                c.contact_person,
                c.address_line,
                c.area,
                c.city, 
                c.pincode,
                c.mobile,
                c.gst_no,
                a.reason,
                1 as qty ,
                b.no_of_core_box,
                b.no_of_cavity,
                a.vehicle_no,
                a.show_cavity,
                a.show_core_box
                from pattern_in_out_ward_info as a
                left join pattern_info as b on b.pattern_id= a.pattern_id
                left join pattern_maker_info as c on c.pattern_maker_id= a.pattern_maker_id
                where a.`status` != 'Delete' and a.pattern_in_out_type = 'Outward'
                and a.dc_no =  '". $pattern_in_out_id ."'     
                order by a.pattern_in_out_date desc                 
        ";
        
        
        $query = $this->db->query($sql); 
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][]  = $row;  
        }
        
         
         
        
        $this->load->view('page/print-pattern-out-dc',$data); 
	} 
    
}
