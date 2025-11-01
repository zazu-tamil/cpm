<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>ISO Label List</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Master</a></li> 
    <li class="active">ISO Label List</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
  <!-- Default box -->
   
  <div class="box">
    <div class="box-header with-border">
      <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#add_modal"><span class="fa fa-plus-circle"></span> Add New </button>
        
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body"> 
       <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Valid From</th>  
                <th>Label For</th>  
                <th>Label Header</th>  
                <th>Label Footer</th>  
                <th colspan="2" class="text-center">Action</th>  
            </tr>
        </thead>
          <tbody>
               <?php
                   foreach($record_list as $j=> $ls){
                ?> 
                <tr> 
                    <td class="text-center"><?php echo ($j + 1 + $sno);?></td> 
                    <td><?php echo date('d-m-Y', strtotime($ls['ason_date']));?></td>   
                    <td><?php echo $label_for_opt[$ls['label_for']]?></td>   
                    <td><?php echo str_replace("\n","<br>",$ls['iso_label_ctnt']); ?></td>  
                    <td><?php echo str_replace("\n","<br>",$ls['iso_label_ctnt_footer']); ?></td>  
                    <td class="text-center">
                        <button value="<?php echo $ls['iso_label_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                    </td>                                      
                </tr>
                <?php
                    }
                ?>                                 
            </tbody>
      </table>
        

                
                 
        
        
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

<div class="modal fade" id="add_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form method="post" action="" id="frmadd">
            <div class="modal-header">
                <h3 class="modal-title" id="scrollmodalLabel">ISO Label Info</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" name="mode" value="Add" />
            </div>
            <div class="modal-body">
                 <div class="form-group">
                    <label>Valid From</label>
                    <input class="form-control" type="date" name="ason_date" id="ason_date" value="">                                             
                 </div> 
                 <div class="form-group">
                    <label>ISO Label For</label>
                    <?php echo form_dropdown('label_for',array('' => 'Select') + $label_for_opt ,set_value('label_for') ,' id="label_for" class="form-control"');?>                                              
                 </div>
                 <div class="form-group">
                    <label>ISO Label Header</label>
                    <textarea class="form-control"  name="iso_label_ctnt" id="iso_label_ctnt"></textarea>                                             
                 </div>
                  <div class="form-group">
                    <label>ISO Label Footer</label>
                    <textarea class="form-control"  name="iso_label_ctnt_footer" id="iso_label_ctnt_footer"></textarea>                                             
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

</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
