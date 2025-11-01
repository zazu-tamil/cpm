<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Sub-Contractor List</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Master</a></li> 
    <li class="active">Sub-Contractor List</li>
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
            <form action="" method="post" id="frm">
            <div class="row">  
                 
                <div class="col-sm-5 col-md-5">
                    <label>Search company name , phone , mobile or email</label>
                    <input type="text" class="form-control" name="srch_key" id="srch_key" value="<?php echo set_value('srch_key','') ?>" placeholder="Search Company ,Contact Person , phone , mobile or email" />
                </div>
                <div class="col-sm-3 col-md-2"> 
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
        
       
    </div>
    <div class="box-body table-responsive"> 
       <table class="table table-hover table-bordered table-striped table-responsive">
        <thead> 
            <tr>
                <th>#</th> 
                <th>Company &<br />Contact Person</th>  
                <th>Type &<br /> Customer</th>  
                <th>Mobile,Phone & Email</th> 
                <th>Address</th>  
                <th>State & City</th> 
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
                    <td><?php echo $ls['company_name']?> <br /><?php echo $ls['contact_person']?></td>  
                    <td><?php echo $ls['type']?> <br /><?php echo $ls['customer']?></td>  
                    <td><?php echo '<i class="fa fa-mobile"></i>  '.($ls['mobile']);?><br /><?php echo '<i class="fa fa-phone"></i>  '.($ls['phone']);?><br /><?php echo '<i class="fa fa-envelope"></i> ' . $ls['email']?></td>   
                    <td><?php echo $ls['address_line']?>,<?php echo $ls['area']?></td>   
                    <td><?php echo $ls['state']?><br /><?php echo $ls['city']?></td> 
                    <td><?php echo $ls['status']?></td> 
                     
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#view_modal" value="<?php echo $ls['sub_contractor_id']?>" class="view_record btn btn-warning btn-xs" title="View"><i class="fa fa-eye"></i></button>
                    </td>
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['sub_contractor_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                     </td>
                    <td class="text-center">
                        <button value="<?php echo $ls['sub_contractor_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
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
                        <h4 class="modal-title">Add Sub-Contractor Info</h4>
                        <input type="hidden" name="mode" value="Add" />
                    </div>
                    <div class="modal-body">    
                         <div class="row"> 
                             <div class="form-group col-md-5">
                                <label>Company</label>
                                <input class="form-control" type="text" name="company_name" id="company_name" value="" placeholder="Company Name">                                             
                             </div> 
                             <div class="form-group col-md-5">
                                <label>Contact Person Name</label>
                                <input class="form-control" type="text" name="contact_person" id="contact_person" value="" placeholder="Contact Person Name">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Type</label>
                                <div class="radio"  style="padding-left: 20px;">
                                    <label>
                                        <input type="radio" name="type" class="sub_contractor_type"  value="Machining" checked="true" /> Machining 
                                    </label> 
                                </div>
                                <div class="radio"  style="padding-left: 20px;">
                                    <label>
                                         <input type="radio" name="type" class="sub_contractor_type" value="Grinding"  /> Grinding
                                    </label>
                                </div> 
                             </div>   
                         </div> 
                        <!-- <div class="row">
                            
                             <div class="form-group col-md-5">
                                <label>Customer</label>
                                <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id') ,' id="customer_id" class="form-control" ');?>                                            
                             </div>
                             <div class="form-group col-md-3">
                                <label for="grinding_rate">Grinding Rate</label>
                                <input class="form-control" type="number" step="any" name="grinding_rate" id="grinding_rate" value="0" placeholder="Grinding Rate" >                                             
                             </div> 
                         </div> -->  
                         <div class="row">  
                            <div class="form-group col-md-4">
                                <label>Address</label>
                                <input class="form-control" type="text" name="address_line" id="address_line" value="" placeholder="Address Line">                                             
                             </div>
                            <div class="form-group col-md-4">
                                <label>Area</label>
                                <input class="form-control" type="text" name="area" id="area" value="" placeholder="Area">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>City</label>
                                <input class="form-control" type="text" name="city" id="city" value="" placeholder="City">                                             
                             </div> 
                         </div> 
                         <div class="row">  
                            <div class="form-group col-md-4">
                                <label>Pincode</label>
                                <input class="form-control" type="text" name="pincode" id="pincode" value="" placeholder="Pincode">                                             
                             </div> 
                            <div class="form-group col-md-4">
                                <label>State</label>
                                <input class="form-control" type="text" name="state" id="state" value="Tamilnadu" placeholder="State">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Country</label>
                                <input class="form-control" type="text" name="country" id="country" value="India" placeholder="Country">                                             
                             </div>
                         </div> 
                         <div class="row">   
                            <div class="form-group col-md-4">
                                <label>Mobile</label>
                                <input class="form-control" type="text" name="mobile" id="mobile" value="" placeholder="Mobile">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Phone</label>
                                <input class="form-control" type="text" name="phone" id="phone" value="" placeholder="Phone">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email" id="email" value="" placeholder="Email ID">                                             
                             </div>  
                         </div> 
                         <div class="row">  
                            <div class="form-group col-md-4">
                                <label>GST Number</label>
                                <input class="form-control" type="text" name="gst_no" id="gst_no" value="" placeholder="GST">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Bank Name</label>
                                <input class="form-control" type="text" name="bank_name" id="bank_name" value="" placeholder="Bank Name">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Branch Name</label>
                                <input class="form-control" type="text" name="branch" id="branch" value="" placeholder="Branch Name">                                             
                             </div>
                          </div> 
                         <div class="row">   
                             <div class="form-group col-md-3">
                                <label>IFSC Code</label>
                                <input class="form-control" type="text" name="ifsc_code" id="ifsc_code" value="" placeholder="IFSC Code">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>A/C Holder Name</label>
                                <input class="form-control" type="text" name="ac_holder_name" id="ac_holder_name" value="" placeholder="A/C Holder Name">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>A/C No</label>
                                <input class="form-control" type="text" name="ac_no" id="ac_no" value="" placeholder="A/C No">                                             
                             </div>
                             <div class="form-group col-md-3">
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
                         <h4 class="modal-title">Edit Sub-Contractor Info</h4>
                        <input type="hidden" name="mode" value="Edit" />
                        <input type="hidden" name="sub_contractor_id" id="sub_contractor_id" />
                    </div>
                    <div class="modal-body"> 
                         <div class="row"> 
                             <div class="form-group col-md-5">
                                <label>Company</label>
                                <input class="form-control" type="text" name="company_name" id="company_name" value="" placeholder="Company Name">                                             
                             </div> 
                             <div class="form-group col-md-5">
                                <label>Contact Person Name</label>
                                <input class="form-control" type="text" name="contact_person" id="contact_person" value="" placeholder="Contact Person Name">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Type</label>
                                <div class="radio"  style="padding-left: 20px;">
                                    <label>
                                        <input type="radio" name="type" class="sub_contractor_type"  value="Machining" checked="true" /> Machining 
                                    </label> 
                                </div>
                                <div class="radio"  style="padding-left: 20px;">
                                    <label>
                                         <input type="radio" name="type" class="sub_contractor_type" value="Grinding"  /> Grinding
                                    </label>
                                </div> 
                             </div>  
                         </div> 
                         <!--<div class="row">
                            <div class="form-group col-md-4">
                                <label>Type</label>
                                <div class="radio"  style="padding-left: 20px;">
                                    <label>
                                        <input type="radio" name="type" class="sub_contractor_type"  value="Customer" checked="true" /> Customer 
                                    </label> 
                                </div>
                                <div class="radio"  style="padding-left: 20px;">
                                    <label>
                                         <input type="radio" name="type" class="sub_contractor_type" value="Company"  /> Company
                                    </label>
                                </div> 
                             </div> 
                             <div class="form-group col-md-5">
                                <label>Customer</label>
                                <?php //echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id') ,' id="customer_id" class="form-control" ');?>                                            
                             </div>
                             <div class="form-group col-md-3">
                                <label for="grinding_rate">Grinding Rate</label>
                                <input class="form-control" type="number" step="any" name="grinding_rate" id="grinding_rate" value="0" placeholder="Grinding Rate" >                                             
                             </div> 
                         </div> -->
                         <div class="row">  
                            <div class="form-group col-md-4">
                                <label>Address</label>
                                <input class="form-control" type="text" name="address_line" id="address_line" value="" placeholder="Address Line">                                             
                             </div>
                            <div class="form-group col-md-4">
                                <label>Area</label>
                                <input class="form-control" type="text" name="area" id="area" value="" placeholder="Area">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>City</label>
                                <input class="form-control" type="text" name="city" id="city" value="" placeholder="City">                                             
                             </div> 
                         </div> 
                         <div class="row">  
                            <div class="form-group col-md-4">
                                <label>Pincode</label>
                                <input class="form-control" type="text" name="pincode" id="pincode" value="" placeholder="Pincode">                                             
                             </div> 
                            <div class="form-group col-md-4">
                                <label>State</label>
                                <input class="form-control" type="text" name="state" id="state" value="Tamilnadu" placeholder="State">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Country</label>
                                <input class="form-control" type="text" name="country" id="country" value="India" placeholder="Country">                                             
                             </div>
                         </div> 
                         <div class="row">   
                            <div class="form-group col-md-4">
                                <label>Mobile</label>
                                <input class="form-control" type="text" name="mobile" id="mobile" value="" placeholder="Mobile">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Phone</label>
                                <input class="form-control" type="text" name="phone" id="phone" value="" placeholder="Phone">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email" id="email" value="" placeholder="Email ID">                                             
                             </div>  
                         </div> 
                         <div class="row">  
                            <div class="form-group col-md-4">
                                <label>GST Number</label>
                                <input class="form-control" type="text" name="gst_no" id="gst_no" value="" placeholder="GST">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Bank Name</label>
                                <input class="form-control" type="text" name="bank_name" id="bank_name" value="" placeholder="Bank Name">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Branch Name</label>
                                <input class="form-control" type="text" name="branch" id="branch" value="" placeholder="Branch Name">                                             
                             </div>
                          </div> 
                         <div class="row">   
                             <div class="form-group col-md-3">
                                <label>IFSC Code</label>
                                <input class="form-control" type="text" name="ifsc_code" id="ifsc_code" value="" placeholder="IFSC Code">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>A/C Holder Name</label>
                                <input class="form-control" type="text" name="ac_holder_name" id="ac_holder_name" value="" placeholder="A/C Holder Name">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>A/C No</label>
                                <input class="form-control" type="text" name="ac_no" id="ac_no" value="" placeholder="A/C No">                                             
                             </div>
                             <div class="form-group col-md-3">
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                        <h3 class="modal-title" id="scrollmodalLabel"><strong>View Details</strong></h3>
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
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
