<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>List of Patterns</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Pattern Shop</a></li> 
    <li class="active">Pattern List</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
  <!-- Default box -->
  <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-search"></i> Search</h3>
        </div>
       <div class="box-body"> 
            <form action="<?php echo site_url('pattern-list'); ?>" method="post" id="frm">
            <div class="row"> 
                <div class="col-sm-3 col-md-5"> 
                    <label for="srch_customer">Customer</label>
                    <?php echo form_dropdown('srch_customer',array('' => 'All Customer') + $customer_opt,set_value('srch_customer',$srch_customer) ,' id="srch_customer" class="form-control"');?>
                </div>
                 
                <div class="col-sm-3 col-md-4">
                    <label>Pattern Name</label>
                    <input type="text" class="form-control" name="srch_key" id="srch_key" value="<?php echo set_value('srch_key','') ?>" placeholder="Search Pattern Name" />
                </div>
                <div class="col-sm-3 col-md-3"> 
                <br />
                    <button class="btn btn-info" type="submit">Show</button>
                </div>
            </div>
            </form> 
       </div> 
    </div> 
  <div class="box box-success">
    <div class="box-header with-border">
      <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#add_modal"><span class="fa fa-plus-circle"></span> Add New </button>
        
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
	  <table class="table table-condensed table-bordered " id="content-table"> 
        <tr>
            <th width="30%" class="text-center"><h2>MJP</h2> </th>
            <th class="text-center"><h3>List Of Patterns</h3></b>
            <th width="30%" class="text-left"><b><?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?></b></th>
        </tr>
       </table>
    </div>
    <div class="box-body table-responsive"> 
       <table class="table table-hover table-bordered table-striped table-responsive">
        <thead> 
            <tr>
                <th>#</th>
                <th>Customer</th>  
                <th>Match Plate No</th>  
                <th>Pattern Name</th>  
                <th>Pattern Type</th> 
                <th>Grade</th>  
                <th class="text-center">Core Per Cavity <br />&<br /> No Of Cavity</th>   
                <th>Box Weight</th>   
                <th>Status</th>  
                <th colspan="3" class="text-center">Action</th>  
            </tr> 
        </thead>
          <tbody>
               <?php
                   foreach($record_list as $j=> $ls){
                ?> 
                <tr> 
                    <td class="text-center"><?php echo ($j + 1 + $sno);?></td> 
                    <td><?php echo $ls['customer']?></td>   
                    <td><?php echo $ls['match_plate_no']?></td>  
                    <td><?php echo $ls['pattern_item']?><br /><i class="badge"><?php echo $ls['item_type']?></i></td>  
                    <td><?php echo $ls['pattern_type']?></td>   
                    <td><?php echo $ls['grade']?></td>   
                    <td><?php echo $ls['no_of_core']?><br /><?php echo $ls['no_of_cavity']?></td>  
                    <td><?php echo $ls['bunch_weight']?></td>
                    <td><?php echo $ls['status']?></td>
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#view_modal" value="<?php echo $ls['pattern_id']?>" class="view_record btn btn-warning btn-xs" title="View"><i class="fa fa-eye"></i></button>
                     </td>  
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['pattern_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                    </td>                                  
                    <td class="text-center">
                        <button value="<?php echo $ls['pattern_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                    </td>                                      
                </tr>
                <?php
                    }
                ?>                                 
            </tbody>
      </table>
        
        <div class="modal fade" id="add_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="post" action="" id="frmadd">
                    <div class="modal-header"> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title" id="scrollmodalLabel">Add Pattern</h3>
                        <input type="hidden" name="mode" value="Add" />
                    </div>
                    <div class="modal-body">
                         <div class="row">
                             <div class="form-group col-md-12">
                                <label for="customer_id">Customer</label>
                                <?php echo form_dropdown('customer_id[]',$customer_opt,set_value('customer_id','') ,' id="customer_id" class="form-control select2 " multiple="multiple" style="width: 100%;" required');?> 
                             </div>
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-8">
                                <label for="pattern_item">Pattern Name</label>
                                <input class="form-control" type="text" name="pattern_item" id="pattern_item" value="" placeholder="Pattern Name" required>                                             
                             </div> 
                             <div class="form-group col-md-3"> 
                               <label for="pattern_type">Pattern Type</label>
                                <div class="radio">
                                    <label style="padding-left:50px;">
                                        <input type="radio" name="pattern_type"  value="Core" checked="true" /> Core 
                                    </label> 
                                    
                                    <label style="padding-left:50px;">
                                         <input type="radio" name="pattern_type"  value="Non-Core"  /> Non-Core
                                    </label>
                                </div>                                             
                             </div>   
                         </div> 
                         <div class="row"> 
                             
                             <div class="form-group col-md-3"> 
                               <label for="pattern_type">Core Per Cavity</label> 
                                <?php echo form_dropdown('no_of_core',array('' => 'Select' ,'0.25' => 0.25, '0.50' => 0.50, '0' => 0 ,'1' => 1, '2'=>2,'3'=>3,'4'=>4 ,'5'=>5) ,set_value('no_of_core') ,' id="no_of_core" class="form-control" required');?>                                             
                             </div>   
                             <div class="form-group col-md-3">
                                <label for="match_plate_no">Match Plate No</label>
                                <input class="form-control" type="text" name="match_plate_no" id="match_plate_no" value="" placeholder="Match Plate No" required>                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label for="grade">Grade</label>
                                <?php echo form_dropdown('grade',array('' => 'Select Grade') + $grade_opt,set_value('grade') ,' id="grade" class="form-control" required');?> 
                             </div>
                             <div class="form-group col-md-2">
                                <label for="no_of_cavity">No Of Cavity</label>
                                <input class="form-control pw_calc" type="number" step="any" name="no_of_cavity" id="no_of_cavity" value="" placeholder="No Of Cavity" required>                                             
                             </div> 
                         </div> 
                         <div class="row">
                             <div class="form-group col-md-5">
                                <label for="type_of_core">Type Of Core</label>
                                <?php echo form_dropdown('type_of_core',array('' => 'Select Type Of Core') + $type_of_core_opt ,set_value('type_of_core') ,' id="type_of_core" class="form-control" ');?>                                             
                             </div>                              
                             <div class="form-group col-md-5"> <br />
                                <label for="core_box">Core Box Required</label>
                                <div class="radio-inline">
                                <input class="" type="checkbox" name="core_box" id="core_box" value="1">   
                                </div>                                           
                             </div>  
                             
                         </div>
                         <div class="row">
                            <div class="form-group col-md-4">
                                <label for="no_of_core_box">No Of Core Box</label>
                                <input class="form-control" type="number" step="any" name="no_of_core_box" id="no_of_core_box" value="" placeholder="No Of Core Box" required>                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label for="no_of_core_per_box">No Of Core / Core Box</label>
                                <input class="form-control" type="number" step="any" name="no_of_core_per_box" id="no_of_core_per_box" value="0" placeholder="No Of Core Per Box">                                             
                             </div>
                            <div class="form-group col-md-4">
                                <label for="corebox_material">Core Box Material</label>
                                <input class="form-control" type="text" name="corebox_material" id="corebox_material" value="" placeholder="Core Box Material">                                             
                             </div> 
                         </div>
                         <div class="row">
                            <div class="form-group col-md-4">
                                <label for="pattern_material">Pattern Material</label>
                                <input class="form-control" type="text" name="pattern_material" id="pattern_material" value="" placeholder="Pattern Material" required>                                             
                             </div>     
                             <div class="form-group col-md-4">
                                <label for="pattern_maker_id">Pattern Maker</label>
                                <?php echo form_dropdown('pattern_maker_id',array('' => 'Select Pattern Maker') + $pattern_maker_opt ,set_value('pattern_maker_id') ,' id="pattern_maker_id" class="form-control" required');?>                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Pattern Supplied By</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="supplied_by"  value="Customer" checked="true" /> Customer 
                                    </label> 
                                </div>
                                <div class="radio">
                                    <label>
                                         <input type="radio" name="supplied_by"  value="Own Pattern"  /> Own Pattern
                                    </label>
                                </div> 
                             </div>
                         </div>
                         <hr /> 
                         <div class="row">
                            <div class="form-group col-md-12 text-center"> 
                            <label>Item Type</label>
                                <div class="radio-inline">
                                    <label for="item_type_1">
                                        <input type="radio" name="item_type" id="item_type_1" class="item_type"  value="Parent" checked="true" /> Parent 
                                    </label> 
                                </div>
                                <div class="radio-inline">
                                    <label for="item_type_2">
                                         <input type="radio" name="item_type" id="item_type_2" class="item_type"  value="Child"  /> Child
                                    </label>
                                </div> 
                             </div> 
                         </div>
                         <?php /* ?>
                         <div class="row child_itm">
                             <div class="form-group col-md-4">
                                <label for="grade">Child Pattern Item - 1</label>
                                <?php echo form_dropdown('child_pattern_1',array('' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_1') ,' id="child_pattern_1" class="form-control child_pattern"');?> 
                             </div>
                             <div class="form-group col-md-4">
                                <label for="grade">Child Pattern Item - 2</label>
                                <?php echo form_dropdown('child_pattern_2',array('' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_2') ,' id="child_pattern_2" class="form-control child_pattern" ');?> 
                             </div>
                             <div class="form-group col-md-4">
                                <label for="grade">Child Pattern Item - 3</label>
                                <?php echo form_dropdown('child_pattern_3',array('' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_3') ,' id="child_pattern_3" class="form-control child_pattern" ');?> 
                             </div>
                         </div>
                         <?php */ ?>
                         <div class="row child_itm">
                             <div class="form-group col-md-12">
                                <table class="table table-bordered table-condensed">
                                    <tr>
                                        <td>Child Pattern Item</td>
                                        <td>Cavity</td>
                                        <td>Piece Wt</td>
                                    </tr>    
                                    <tr>
                                        <td><?php echo form_dropdown('child_pattern_1',array('0' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_1') ,' id="child_pattern_1" class="form-control child_pattern"');?></td>
                                        <td><input type="number" step="any" name="child_pattern_1_cavity" id="child_pattern_1_cavity" class="form-control pw_calc" value="0" /></td>
                                        <td><input type="number" step="any" name="child_pattern_1_pt_wt" id="child_pattern_1_pt_wt" class="form-control pw_calc" value="0" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo form_dropdown('child_pattern_2',array('0' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_2') ,' id="child_pattern_2" class="form-control child_pattern"');?></td>
                                        <td><input type="number" step="any" name="child_pattern_2_cavity" id="child_pattern_2_cavity" class="form-control pw_calc" value="0" /></td>
                                        <td><input type="number" step="any" name="child_pattern_2_pt_wt" id="child_pattern_2_pt_wt" class="form-control pw_calc" value="0" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo form_dropdown('child_pattern_3',array('0' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_3') ,' id="child_pattern_3" class="form-control child_pattern"');?></td>
                                        <td><input type="number" step="any" name="child_pattern_3_cavity" id="child_pattern_3_cavity" class="form-control pw_calc" value="0" /></td>
                                        <td><input type="number" step="any" name="child_pattern_3_pt_wt" id="child_pattern_3_pt_wt" class="form-control pw_calc" value="0" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo form_dropdown('child_pattern_4',array('0' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_4') ,' id="child_pattern_4" class="form-control child_pattern"');?></td>
                                        <td><input type="number" step="any" name="child_pattern_4_cavity" id="child_pattern_4_cavity" class="form-control pw_calc" value="0" /></td>
                                        <td><input type="number" step="any" name="child_pattern_4_pt_wt" id="child_pattern_4_pt_wt" class="form-control pw_calc" value="0" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo form_dropdown('child_pattern_5',array('0' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_5') ,' id="child_pattern_5" class="form-control child_pattern"');?></td>
                                        <td><input type="number" step="any" name="child_pattern_5_cavity" id="child_pattern_5_cavity" class="form-control pw_calc" value="0" /></td>
                                        <td><input type="number" step="any" name="child_pattern_5_pt_wt" id="child_pattern_5_pt_wt" class="form-control pw_calc" value="0" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo form_dropdown('child_pattern_6',array('0' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_6') ,' id="child_pattern_6" class="form-control child_pattern"');?></td>
                                        <td><input type="number" step="any" name="child_pattern_6_cavity" id="child_pattern_6_cavity" class="form-control pw_calc" value="0" /></td>
                                        <td><input type="number" step="any" name="child_pattern_6_pt_wt" id="child_pattern_6_pt_wt" class="form-control pw_calc" value="0" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo form_dropdown('child_pattern_7',array('0' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_7') ,' id="child_pattern_7" class="form-control child_pattern"');?></td>
                                        <td><input type="number" step="any" name="child_pattern_7_cavity" id="child_pattern_7_cavity" class="form-control pw_calc" value="0" /></td>
                                        <td><input type="number" step="any" name="child_pattern_7_pt_wt" id="child_pattern_7_pt_wt" class="form-control pw_calc" value="0" /></td>
                                    </tr>
                                </table>
                             </div>
                         </div>
                         <hr />
                         <hr />
                         <div class="row"> 
                             <div class="form-group col-md-2">
                                <label for="piece_weight_per_kg">Piece Weight</label>
                                <input class="form-control" type="number" step="any" name="piece_weight_per_kg" id="piece_weight_per_kg" step="any" value="0" placeholder="Piece Weight">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label for="bunch_weight">Box/Bunch Weight</label>
                                <input class="form-control yeild_calc" type="number" step="any" name="bunch_weight" id="bunch_weight" value="0" placeholder="Box Weight">                                             
                             </div> 
                              <div class="form-group col-md-2">
                                <label for="box_size">Box Size</label>
                                <input class="form-control" type="text"   name="box_size" id="box_size" value="0" placeholder="Box Size">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label for="casting_weight">Casting Weight</label>
                                <input class="form-control yeild_calc" type="number" step="any" name="casting_weight" id="casting_weight" value="0" placeholder="Casting Weight" readonly="true">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label for="core_weight">Core Weight</label>
                                <input class="form-control" type="number" step="any" name="core_weight" id="core_weight" value="0" placeholder="Core Weight">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label for="core_weight">Yield</label>
                                <input class="form-control" type="number" step="any" name="yeild" id="yeild" value="0" placeholder="Yield">                                             
                             </div>   
                         </div> 
                         <div class="row">
                             <div class="form-group col-md-4">
                                <label for="rate_per_kg">Rate Per Kg</label>
                                <input class="form-control" type="number" step="any" name="rate_per_kg" id="rate_per_kg" value="0" placeholder="Rate Per Kg">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label for="rate_per_piece">Rate Per Piece</label>
                                <input class="form-control" type="number" step="any" name="rate_per_piece" id="rate_per_piece" value="0" placeholder="Rate Per Piece">                                             
                             </div> 
                             <div class="form-group col-md-3 hide">
                                <label for="core_maker_rate">Core Maker Rate</label>
                                <input class="form-control" type="number" step="any" name="core_maker_rate" id="core_maker_rate" value="0" placeholder="Core Maker Rate">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label for="grinding_rate">Grinding Rate</label>
                                <input class="form-control" type="number" step="any" name="grinding_rate" id="grinding_rate" value="0" placeholder="Grinding Rate">                                             
                             </div> 
                         </div>
                         <div class="row">
                            <div class="form-group col-md-12 text-center"> 
                            <label>&nbsp;</label>
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="with_transportation"  value="1" checked="true" /> Rate With Transportation 
                                    </label> 
                                </div>
                                <div class="radio-inline">
                                    <label>
                                         <input type="radio" name="with_transportation"  value="0"  /> Rate Without Transportation
                                    </label>
                                </div> 
                             </div> 
                         </div>
                         <hr />
                         <div class="row">  
                             <div class="form-group col-md-3">
                                <label>C</label>
                                <input class="form-control" type="text" name="C" id="C" value="">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>SI</label>
                                <input class="form-control" type="text" name="SI" id="SI" value="">                                             
                             </div> 
                            <div class="form-group col-md-3">
                                <label>Mn</label>
                                <input class="form-control" type="text" name="Mn" id="Mn" value="">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>P</label>
                                <input class="form-control" type="text" name="P" id="P" value="">                                             
                             </div> 
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-3">
                                <label>S</label>
                                <input class="form-control" type="text" name="S" id="S" value="">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Cr</label>
                                <input class="form-control" type="text" name="Cr" id="Cr" value="">                                             
                             </div>  
                             <div class="form-group col-md-3">
                                <label>Cu</label>
                                <input class="form-control" type="text" name="Cu" id="Cu" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Mg</label>
                                <input class="form-control" type="text" name="Mg" id="Mg" value="">                                             
                             </div>
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-3">
                                <label>Ni</label>
                                <input class="form-control" type="text" name="ni" id="ni" value="">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Mo</label>
                                <input class="form-control" type="text" name="mo" id="mo" value="">                                             
                             </div>  
                         </div>
                         <div class="row"> 
                            <div class="form-group col-md-3">
                                <label>BHN</label>
                                <input class="form-control" type="text" name="BHN" id="BHN" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Tensile Strength</label>
                                <input class="form-control" type="text" name="tensile" id="tensile" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Elongation</label>
                                <input class="form-control" type="text" name="elongation" id="elongation" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Yield Strength</label>
                                <input class="form-control" type="text" name="yeild_strength" id="yeild_strength" value="">                                             
                             </div>
                          </div> 
                          <div class="row"> 
                            <div class="form-group col-md-2">
                                <label>Pouring Temp</label>
                                <input class="form-control" type="text" name="poring_temp" id="poring_temp" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Inoculant %</label>
                                <input class="form-control" type="text" name="inoculant_percentage" id="inoculant_percentage" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Knock Out Time</label>
                                <input class="form-control" type="text" name="knock_out_time" id="knock_out_time" value="">                                             
                             </div>
                              <div class="form-group col-md-3">
                                <label>Chaplet Size & Qty/Piece</label>
                                <input class="form-control" type="text" name="chaplet_size" id="chaplet_size" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Core Rein-forcement</label>
                                <input class="form-control" type="text" name="core_reinforcement" id="core_reinforcement" value="">                                             
                             </div>
                            <!-- <div class="form-group col-md-3">
                                <label>Charge Mix</label>
                                <input class="form-control" type="text" name="charge_mix" id="charge_mix" value="">                                             
                             </div>-->
                          </div> 
                          <div class="row">  
                             <div class="form-group col-md-2">
                                <label>Pig Iron	</label>
                                <input class="form-control" type="text" name="pig_iron" id="pig_iron" value="0">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Foundry Return</label>
                                <input class="form-control" type="text" name="foundry_return" id="foundry_return" value="0">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>MS / LMS	</label>
                                <input class="form-control" type="text" name="ms" id="ms" value="0">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>CI Boring</label>
                                <input class="form-control" type="text" name="boring" id="boring" value="0">                                             
                             </div>  
                             <div class="form-group col-md-3">
                                <label>CI Scrap</label>
                                <input class="form-control" type="text" name="CI_scrap" id="CI_scrap" value="0">                                             
                             </div>  
                         </div>
                         <div class="row">
                             <div class="form-group col-md-6">
                                <label>Melting Instructions</label>
                                <textarea class="form-control" name="special_instructions" placeholder="Melting Instructions" id="special_instructions"></textarea>                                             
                             </div>
                             <div class="form-group col-md-6">
                                <label>Moulding Instructions</label>
                                <textarea class="form-control" name="moulding_instruction" placeholder="Moulding Instructions" id="moulding_instruction"></textarea>                                             
                             </div>
                             
                             <div class="form-group col-md-8">
                                <label>Description</label>
                                <textarea class="form-control" name="item_description" placeholder="Description" id="item_description"></textarea>                                             
                             </div>
                             
                             <div class="form-group col-md-2">
                                <label>Status</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="status"  value="Active" checked="true" /> Active 
                                    </label> 
                                </div>
                                <div class="radio">
                                    <label>
                                         <input type="radio" name="status"  value="InActive"  /> InActive
                                    </label>
                                </div> 
                             </div>  
                         </div>  
                         
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
                        <input type="submit" name="Save" value="Save"  class="btn btn-primary" />
                    </div> 
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="edit_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="post" action="" id="frmedit">
                    <div class="modal-header">
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title" id="scrollmodalLabel">Edit Pattern </h3>
                        <input type="hidden" name="mode" value="Edit" />
                        <input type="hidden" name="pattern_id" id="pattern_id" />
                    </div>
                    <div class="modal-body"> 
                        <div class="row">
                             <div class="form-group col-md-12">
                                <label for="customer_id">Customer</label>
                                <?php echo form_dropdown('customer_id[]',$customer_opt,set_value('customer_id','') ,' id="customer_id" class="form-control select2 " multiple="multiple" style="width: 100%;" required');?> 
                             </div>
                         </div>
                        <div class="row"> 
                             <div class="form-group col-md-8">
                                <label for="pattern_item">Pattern Name</label>
                                <input class="form-control" type="text" name="pattern_item" id="pattern_item" value="" placeholder="Pattern Name" required>                                             
                             </div> 
                             <div class="form-group col-md-3"> 
                               <label for="pattern_type">Pattern Type</label>
                                <div class="radio">
                                    <label style="padding-left:50px;">
                                        <input type="radio" name="pattern_type"  value="Core" checked="true" /> Core 
                                    </label> 
                                    
                                    <label style="padding-left:50px;">
                                         <input type="radio" name="pattern_type"  value="Non-Core"  /> Non-Core
                                    </label>
                                </div>                                             
                             </div>   
                         </div> 
                         <div class="row"> 
                             
                             <div class="form-group col-md-3"> 
                               <label for="pattern_type">Core Per Cavity</label> 
                                <?php echo form_dropdown('no_of_core',array('' => 'Select' ,'0.25' => 0.25, '0.50' => 0.50, '0' => 0 ,'1' => 1, '2'=>2,'3'=>3,'4'=>4 ,'5'=>5) ,set_value('no_of_core') ,' id="no_of_core" class="form-control" required');?>                                             
                             </div>   
                             <div class="form-group col-md-3">
                                <label for="match_plate_no">Match Plate No</label>
                                <input class="form-control" type="text" name="match_plate_no" id="match_plate_no" value="" placeholder="Match Plate No" required>                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label for="grade">Grade</label>
                                <?php echo form_dropdown('grade',array('' => 'Select Grade') + $grade_opt,set_value('grade') ,' id="grade" class="form-control" required');?> 
                             </div>
                             <div class="form-group col-md-2">
                                <label for="no_of_cavity">No Of Cavity</label>
                                <input class="form-control pw_calc" type="number" step="any" name="no_of_cavity" id="no_of_cavity" value="" placeholder="No Of Cavity" required>                                             
                             </div> 
                         </div> 
                         <div class="row">
                             <div class="form-group col-md-5">
                                <label for="type_of_core">Type Of Core</label>
                                <?php echo form_dropdown('type_of_core',array('' => 'Select Type Of Core') + $type_of_core_opt ,set_value('type_of_core') ,' id="type_of_core" class="form-control" ');?>                                             
                             </div>                              
                             <div class="form-group col-md-5"> <br />
                                <label for="core_box">Core Box Required</label>
                                <div class="radio-inline">
                                <input class="" type="checkbox" name="core_box" id="core_box" value="1">   
                                </div>                                           
                             </div>  
                              
                         </div>
                         <div class="row">
                            <div class="form-group col-md-4">
                                <label for="no_of_core_box">No Of Core Box</label>
                                <input class="form-control" type="number" step="any" name="no_of_core_box" id="no_of_core_box" value="" placeholder="No Of Core Box" required>                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label for="no_of_core_per_box">No Of Core / Core Box</label>
                                <input class="form-control" type="number" step="any" name="no_of_core_per_box" id="no_of_core_per_box" value="0" placeholder="No Of Core Per Box">                                             
                             </div>
                            <div class="form-group col-md-4">
                                <label for="corebox_material">Core Box Material</label>
                                <input class="form-control" type="text" name="corebox_material" id="corebox_material" value="" placeholder="Core Box Material">                                             
                             </div> 
                         </div>
                         <div class="row">
                         
                            <div class="form-group col-md-4">
                                <label for="pattern_material">Pattern Material</label>
                                <input class="form-control" type="text" name="pattern_material" id="pattern_material" value="" placeholder="Pattern Material" required>                                             
                             </div>     
                             <div class="form-group col-md-4">
                                <label for="pattern_maker_id">Pattern Maker</label>
                                <?php echo form_dropdown('pattern_maker_id',array('' => 'Select Pattern Maker') + $pattern_maker_opt ,set_value('pattern_maker_id') ,' id="pattern_maker_id" class="form-control" required');?>                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Pattern Supplied By</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="supplied_by"  value="Customer" checked="true" /> Customer 
                                    </label> 
                                </div>
                                <div class="radio">
                                    <label>
                                         <input type="radio" name="supplied_by"  value="Own Pattern"  /> Own Pattern
                                    </label>
                                </div> 
                             </div>
                         </div>
                         <hr /> 
                         <div class="row">
                            <div class="form-group col-md-12 text-center"> 
                            <label>Item Type</label>
                                <div class="radio-inline">
                                    <label for="item_type_1">
                                        <input type="radio" name="item_type" id="item_type_1" class="item_type"  value="Parent" checked="true" /> Parent 
                                    </label> 
                                </div>
                                <div class="radio-inline">
                                    <label for="item_type_2">
                                         <input type="radio" name="item_type" id="item_type_2" class="item_type"  value="Child"  /> Child
                                    </label>
                                </div> 
                             </div> 
                         </div>
                         <?php /* ?>
                         <div class="row child_itm">
                             <div class="form-group col-md-4">
                                <label for="grade">Child Pattern Item - 1</label>
                                <?php echo form_dropdown('child_pattern_1',array('' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_1') ,' id="child_pattern_1" class="form-control child_pattern"');?> 
                             </div>
                             <div class="form-group col-md-4">
                                <label for="grade">Child Pattern Item - 2</label>
                                <?php echo form_dropdown('child_pattern_2',array('' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_2') ,' id="child_pattern_2" class="form-control child_pattern" ');?> 
                             </div>
                             <div class="form-group col-md-4">
                                <label for="grade">Child Pattern Item - 3</label>
                                <?php echo form_dropdown('child_pattern_3',array('' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_3') ,' id="child_pattern_3" class="form-control child_pattern" ');?> 
                             </div>
                         </div>
                         <?php */ ?>
                         <div class="row child_itm">
                             <div class="form-group col-md-12">
                                <table class="table table-bordered table-condensed">
                                    <tr>
                                        <td>Child Pattern Item</td>
                                        <td>Cavity</td>
                                        <td>Piece Wt</td>
                                    </tr>    
                                    <tr>
                                        <td><?php echo form_dropdown('child_pattern_1',array('0' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_1') ,' id="child_pattern_1" class="form-control child_pattern"');?></td>
                                        <td><input type="number" step="any" name="child_pattern_1_cavity" id="child_pattern_1_cavity" class="form-control pw_calc" value="0" /></td>
                                        <td><input type="number" step="any" name="child_pattern_1_pt_wt" id="child_pattern_1_pt_wt" class="form-control pw_calc" value="0" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo form_dropdown('child_pattern_2',array('0' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_2') ,' id="child_pattern_2" class="form-control child_pattern"');?></td>
                                        <td><input type="number" step="any" name="child_pattern_2_cavity" id="child_pattern_2_cavity" class="form-control pw_calc" value="0" /></td>
                                        <td><input type="number" step="any" name="child_pattern_2_pt_wt" id="child_pattern_2_pt_wt" class="form-control pw_calc" value="0" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo form_dropdown('child_pattern_3',array('0' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_3') ,' id="child_pattern_3" class="form-control child_pattern"');?></td>
                                        <td><input type="number" step="any" name="child_pattern_3_cavity" id="child_pattern_3_cavity" class="form-control pw_calc" value="0" /></td>
                                        <td><input type="number" step="any" name="child_pattern_3_pt_wt" id="child_pattern_3_pt_wt" class="form-control pw_calc" value="0" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo form_dropdown('child_pattern_4',array('0' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_4') ,' id="child_pattern_4" class="form-control child_pattern"');?></td>
                                        <td><input type="number" step="any" name="child_pattern_4_cavity" id="child_pattern_4_cavity" class="form-control pw_calc" value="0" /></td>
                                        <td><input type="number" step="any" name="child_pattern_4_pt_wt" id="child_pattern_4_pt_wt" class="form-control pw_calc" value="0" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo form_dropdown('child_pattern_5',array('0' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_5') ,' id="child_pattern_5" class="form-control child_pattern"');?></td>
                                        <td><input type="number" step="any" name="child_pattern_5_cavity" id="child_pattern_5_cavity" class="form-control pw_calc" value="0" /></td>
                                        <td><input type="number" step="any" name="child_pattern_5_pt_wt" id="child_pattern_5_pt_wt" class="form-control pw_calc" value="0" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo form_dropdown('child_pattern_6',array('0' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_6') ,' id="child_pattern_6" class="form-control child_pattern"');?></td>
                                        <td><input type="number" step="any" name="child_pattern_6_cavity" id="child_pattern_6_cavity" class="form-control pw_calc" value="0" /></td>
                                        <td><input type="number" step="any" name="child_pattern_6_pt_wt" id="child_pattern_6_pt_wt" class="form-control pw_calc" value="0" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo form_dropdown('child_pattern_7',array('0' => 'Select Child Pattern') + $child_pattern_opt ,set_value('child_pattern_7') ,' id="child_pattern_7" class="form-control child_pattern"');?></td>
                                        <td><input type="number" step="any" name="child_pattern_7_cavity" id="child_pattern_7_cavity" class="form-control pw_calc" value="0" /></td>
                                        <td><input type="number" step="any" name="child_pattern_7_pt_wt" id="child_pattern_7_pt_wt" class="form-control pw_calc" value="0" /></td>
                                    </tr>
                                </table>
                             </div>
                         </div>
                         <hr />
                         <hr />
                         <div class="row"> 
                             <div class="form-group col-md-2">
                                <label for="piece_weight_per_kg">Piece Weight</label>
                                <input class="form-control" type="number" step="any" name="piece_weight_per_kg" id="piece_weight_per_kg" step="any" value="0" placeholder="Piece Weight">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label for="bunch_weight">Box/Bunch Weight</label>
                                <input class="form-control yeild_calc" type="number" step="any" name="bunch_weight" id="bunch_weight" value="0" placeholder="Box Weight">                                             
                             </div> 
                              <div class="form-group col-md-2">
                                <label for="box_size">Box Size</label>
                                <input class="form-control" type="text"   name="box_size" id="box_size" value="0" placeholder="Box Size">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label for="casting_weight">Casting Weight</label>
                                <input class="form-control yeild_calc" type="number" step="any" name="casting_weight" id="casting_weight" value="0" placeholder="Casting Weight" readonly="true">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label for="core_weight">Core Weight</label>
                                <input class="form-control" type="number" step="any" name="core_weight" id="core_weight" value="0" placeholder="Core Weight">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label for="core_weight">Yield</label>
                                <input class="form-control" type="number" step="any" name="yeild" id="yeild" value="0" placeholder="Yield">                                             
                             </div>   
                         </div>  
                         <div class="row">
                             <div class="form-group col-md-4">
                                <label for="rate_per_kg">Rate Per Kg</label>
                                <input class="form-control" type="number" step="any" name="rate_per_kg" id="rate_per_kg" value="0" placeholder="Rate Per Kg">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label for="rate_per_piece">Rate Per Piece</label>
                                <input class="form-control" type="number" step="any" name="rate_per_piece" id="rate_per_piece" value="0" placeholder="Rate Per Piece">                                             
                             </div> 
                             <div class="form-group col-md-3 hide">
                                <label for="core_maker_rate">Core Maker Rate</label>
                                <input class="form-control" type="number" step="any" name="core_maker_rate" id="core_maker_rate" value="0" placeholder="Core Maker Rate">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label for="grinding_rate">Grinding Rate</label>
                                <input class="form-control" type="number" step="any" name="grinding_rate" id="grinding_rate" value="0" placeholder="Grinding Rate">                                             
                             </div> 
                         </div>
                         <div class="row">
                            <div class="form-group col-md-12 text-center"> 
                            <label>&nbsp;</label>
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="with_transportation"  value="1" checked="true" /> Rate With Transportation 
                                    </label> 
                                </div>
                                <div class="radio-inline">
                                    <label>
                                         <input type="radio" name="with_transportation"  value="0"  /> Rate Without Transportation
                                    </label>
                                </div> 
                             </div> 
                         </div>
                         <hr />
                         <div class="row">  
                             <div class="form-group col-md-3">
                                <label>C</label>
                                <input class="form-control" type="text" name="C" id="C" value="">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>SI</label>
                                <input class="form-control" type="text" name="SI" id="SI" value="">                                             
                             </div> 
                            <div class="form-group col-md-3">
                                <label>Mn</label>
                                <input class="form-control" type="text" name="Mn" id="Mn" value="">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>P</label>
                                <input class="form-control" type="text" name="P" id="P" value="">                                             
                             </div> 
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-3">
                                <label>S</label>
                                <input class="form-control" type="text" name="S" id="S" value="">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Cr</label>
                                <input class="form-control" type="text" name="Cr" id="Cr" value="">                                             
                             </div>  
                             <div class="form-group col-md-3">
                                <label>Cu</label>
                                <input class="form-control" type="text" name="Cu" id="Cu" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Mg</label>
                                <input class="form-control" type="text" name="Mg" id="Mg" value="">                                             
                             </div>
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-3">
                                <label>Ni</label>
                                <input class="form-control" type="text" name="ni" id="ni" value="">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Mo</label>
                                <input class="form-control" type="text" name="mo" id="mo" value="">                                             
                             </div>  
                         </div>
                         <div class="row"> 
                            <div class="form-group col-md-3">
                                <label>BHN</label>
                                <input class="form-control" type="text" name="BHN" id="BHN" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Tensile Strength</label>
                                <input class="form-control" type="text" name="tensile" id="tensile" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Elongation</label>
                                <input class="form-control" type="text" name="elongation" id="elongation" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Yield Strength</label>
                                <input class="form-control" type="text" name="yeild_strength" id="yeild_strength" value="">                                             
                             </div>
                          </div> 
                         <div class="row"> 
                            <div class="form-group col-md-2">
                                <label>Pouring Temp</label>
                                <input class="form-control" type="text" name="poring_temp" id="poring_temp" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Inoculant %</label>
                                <input class="form-control" type="text" name="inoculant_percentage" id="inoculant_percentage" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Knock Out Time</label>
                                <input class="form-control" type="text" name="knock_out_time" id="knock_out_time" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Chaplet size & Qty/Piece</label>
                                <input class="form-control" type="text" name="chaplet_size" id="chaplet_size" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Core Rein-forcement</label>
                                <input class="form-control" type="text" name="core_reinforcement" id="core_reinforcement" value="">                                             
                             </div>
                             <!--<div class="form-group col-md-3">
                                <label>Charge Mix</label>
                                <input class="form-control" type="text" name="charge_mix" id="charge_mix" value="">                                             
                             </div>-->
                          </div> 
                          <div class="row">  
                             <div class="form-group col-md-2">
                                <label>Pig Iron	</label>
                                <input class="form-control" type="text" name="pig_iron" id="pig_iron" value="0">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Foundry Return</label>
                                <input class="form-control" type="text" name="foundry_return" id="foundry_return" value="0">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>MS / LMS	</label>
                                <input class="form-control" type="text" name="ms" id="ms" value="0">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>CI Boring</label>
                                <input class="form-control" type="text" name="boring" id="boring" value="0">                                             
                             </div>  
                             <div class="form-group col-md-3">
                                <label>CI Scrap</label>
                                <input class="form-control" type="text" name="CI_scrap" id="CI_scrap" value="0">                                             
                             </div>  
                         </div>
                         <div class="row">
                             <div class="form-group col-md-6">
                                <label>Melting Instructions</label>
                                <textarea class="form-control" name="special_instructions" placeholder="Melting Instructions" id="special_instructions"></textarea>                                             
                             </div>
                             <div class="form-group col-md-6">
                                <label>Moulding Instructions</label>
                                <textarea class="form-control" name="moulding_instruction" placeholder="Moulding Instructions" id="moulding_instruction"></textarea>                                             
                             </div>
                             
                             <div class="form-group col-md-8">
                                <label>Description</label>
                                <textarea class="form-control" name="item_description" placeholder="Description" id="item_description"></textarea>                                             
                             </div>
                             
                             <div class="form-group col-md-2">
                                <label>Status</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="status"  value="Active" checked="true" /> Active 
                                    </label> 
                                </div>
                                <div class="radio">
                                    <label>
                                         <input type="radio" name="status"  value="InActive"  /> InActive
                                    </label>
                                </div> 
                             </div>  
                         </div>   
                         
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
                        <input type="submit" name="Save" value="Update"  class="btn btn-primary" />
                    </div> 
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="view_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content"> 
                    <div class="modal-header">
                        <h3 class="modal-title" id="scrollmodalLabel"><strong>View Details</strong></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                    </div>
                    <div class="modal-body table-responsive">
                    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  
                    </div>  
                </div>
            </div>
        </div> 
        
        
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <div class="form-group col-sm-6">
            <label>Total Records : <?php echo $total_records;?></label>
        </div>
        <div class="form-group col-sm-6">
            <?php echo $pagination; ?>
        </div>
		<table class="table table-condensed table-bordered " id="content-table"> 
		<tr>
			<th>Prepared by</th>
			<th>Approved by/Date</th>
			<th>
				 <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
			 </th>
		</tr> 
		</table> 
		
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
