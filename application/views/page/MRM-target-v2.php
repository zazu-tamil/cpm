<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>MRM Target List</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Master</a></li> 
    <li class="active">MRM Target List</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
  <!-- Default box -->
   
  <div class="box box-info">
    <div class="box-header with-border">
      <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#add_modal"><span class="fa fa-plus-circle"></span> Add New </button>
      
    </div>
    <div class="box-body table-responsive"> 
       <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>S.No</th>  
                <th>ID</th>  
                <th>Target Valid From</th>   
                <th>Target Valid To</th>   
                <th colspan="2" class="text-center">Action</th>  
            </tr>
        </thead>
          <tbody>
               <?php
                   foreach($record_list as $j=> $ls){
                ?> 
                <tr> 
                    <td class="text-center"><?php echo ($j + 1 + $sno);?></td> 
                    <td><?php echo $ls['grp_id']?></td>   
                    <td><?php echo date('d-M-Y' , strtotime($ls['frm_date']));?></td>   
                    <td><?php echo date('d-M-Y' , strtotime($ls['to_date']));?></td>   
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['grp_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                    </td>                                  
                    <!--<td class="text-center">
                        <button value="<?php echo $ls['grp_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                    </td> -->                                     
                </tr>
                <?php
                    }
                ?>                                 
            </tbody>
      </table>
        
                    <div class="modal fade" id="add_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <form method="post" action="" id="frmadd">
                            <div class="modal-header">
                                
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="scrollmodalLabel">Add MRM Target</h4>
                                <input type="hidden" name="mode" value="Add" />
                                <input type="hidden" name="grp_id" id="grp_id" value="<?php echo ($max_grp_id +1)?>" />
                            </div>
                            <div class="modal-body">
                                    
                                  <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Description</th>
                                            <th>Target</th> 
                                        </tr>
                                    </thead>
                                    <tbody> 
                                         <tr>
                                            <td>#</td>
                                            <td>Date</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                      <div class="input-group"> 
                                                        <input type="date" name="frm_date" id="frm_date" class="form-control">
                                                      </div>
                                                      <!-- /input-group -->
                                                    </div>
                                                    <!-- /.col-lg-6 -->
                                                    <div class="col-lg-6">
                                                      <div class="input-group">
                                                            <input type="date" name="to_date" id="to_date" class="form-control"> 
                                                      </div>
                                                      <!-- /input-group -->
                                                    </div>
                                                    <!-- /.col-lg-6 -->
                                                  </div>
                                                  <!-- /.row --> 
                                                
                                            </td>
                                        </tr>
                                        <?php foreach($mrm_list as $k => $info) { ?>
                                        <tr>
                                             <td><?php echo $info['sno'] ?></td>
                                             <td><?php echo $info['mrm_target_type_name'] ?></td>
                                            <td>
                                            <input type="hidden" name="mrm_target_name[]" value='<?php echo $info['mrm_target_type_name'] ?>' class="form-control" />
                                            <input type="text" name="mrm_target_value[]"  value="0" class="form-control" />
                                            </td> 
                                        </tr>
                                        <?php } ?>
                                         
                                    </tbody>
                                </table>
                                 
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
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <form method="post" action="" id="frmedit">
                            <div class="modal-header"> 
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="scrollmodalLabel">Edit MRM Target</h4>
                                <input type="hidden" name="mode" value="Edit" />
                                <input type="hidden" name="grp_id" id="grp_id" />
                            </div>
                            <div class="modal-body"> 
                                  <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Description</th>
                                            <th>Target</th> 
                                        </tr>
                                    </thead>
                                    <tbody> 
                                         <tr>
                                            <td>#</td>
                                            <td>Date</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                      <div class="input-group"> 
                                                        <input type="date" name="frm_date" id="frm_date" class="form-control">
                                                      </div>
                                                      <!-- /input-group -->
                                                    </div>
                                                    <!-- /.col-lg-6 -->
                                                    <div class="col-lg-6">
                                                      <div class="input-group">
                                                            <input type="date" name="to_date" id="to_date" class="form-control"> 
                                                      </div>
                                                      <!-- /input-group -->
                                                    </div>
                                                    <!-- /.col-lg-6 -->
                                                  </div>
                                                  <!-- /.row --> 
                                                
                                            </td>
                                        </tr>
                                        <?php foreach($mrm_list as $k => $info) { ?>
                                        <tr>
                                            <td><?php echo ($k+1) ?></td>
                                            <td id="mrm_text_<?php echo ($k+1) ?>"><?php //echo $info['mrm_target_name'] ?></td>
                                            <td>
                                            <input type="hidden" name="mrm_target_name[]" id='mrm_target_name_<?php echo ($k+1) ?>' value='<?php echo $info['mrm_target_type_name'] ?>' class="form-control" />
                                            <input type="text" name="mrm_target_value[]" id='mrm_target_value<?php echo ($k+1) ?>'  value="0" class="form-control" />
                                            </td> 
                                        </tr>
                                        <?php } ?>
                                         
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
                                <input type="submit" name="Save" value="Update"  class="btn btn-primary" />
                            </div> 
                            </form>
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
