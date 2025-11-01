<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>
     Grade List
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Master</a></li> 
    <li class="active">Grade List</li>
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
    <div class="box-body table-responsive no-padding">
       
       <table class="table table-hover table-bordered table-striped table-responsive">
        <thead> 
            <tr>
                <th>#</th>
                <th>Grade Name</th>  
                <th>C</th>  
                <th>SI</th>  
                <th>Mn</th>  
                <th>P</th>  
                <th>S</th>  
                <th>Cr</th>  
                <th>Cu</th>  
                <th>Mg</th>  
                <th>BHN</th>  
                <th>Tensile</th>  
                <th>Elongation</th>  
                <th>Yeild Strength</th>  
                <th>Status</th>  
                <th colspan="2" class="text-center">Action</th>  
            </tr> 
        </thead>
          <tbody>
               <?php
                   foreach($record_list as $j=> $ls){
                ?> 
                <tr> 
                    <td class="text-center"><?php echo ($j + 1 + $sno);?></td> 
                    <td><?php echo $ls['grade_name']?></td>   
                    <td><?php echo $ls['C']?></td>  
                    <td><?php echo ($ls['SI']);?></td>   
                    <td><?php echo $ls['Mn']?></td>   
                    <td><?php echo $ls['P']?></td>   
                    <td><?php echo $ls['S']?></td>   
                    <td><?php echo $ls['Cr']?></td>   
                    <td><?php echo $ls['Cu']?></td>   
                    <td><?php echo $ls['Mg']?></td>   
                    <td><?php echo $ls['BHM']?></td>   
                    <td><?php echo $ls['tensile']?></td>   
                    <td><?php echo $ls['elongation']?></td>   
                    <td><?php echo $ls['yeild_strength']?></td>   
                    <td><?php echo $ls['status']?></td>   
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['grade_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                    </td>                                  
                    <td class="text-center">
                        <button value="<?php echo $ls['grade_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
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
                        <h4 class="modal-title" >Add Grade</h4>
                        <input type="hidden" name="mode" value="Add" />
                    </div>
                    <div class="modal-body">  
                       <div class="row">  
                         <div class="form-group col-md-3">
                            <label>Grade Name</label>
                            <input class="form-control" type="text" name="grade_name" id="grade_name" value="">                                             
                         </div> 
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
                       </div>
                       <div class="row">
                         <div class="form-group col-md-3">
                            <label>P</label>
                            <input class="form-control" type="text" name="P" id="P" value="">                                             
                         </div> 
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
                       </div>
                       <div class="row">
                         <div class="form-group col-md-3">
                            <label>Mg</label>
                            <input class="form-control" type="text" name="Mg" id="Mg" value="">                                             
                         </div>
                        <div class="form-group col-md-3">
                            <label>BHN</label>
                            <input class="form-control" type="text" name="BHM" id="BHM" value="">                                             
                         </div>
                         <div class="form-group col-md-3">
                            <label>Tensile</label>
                            <input class="form-control" type="text" name="tensile" id="tensile" value="">                                             
                         </div>
                         <div class="form-group col-md-3">
                            <label>Elongation</label>
                            <input class="form-control" type="text" name="elongation" id="elongation" value="">                                             
                         </div>
                       </div>
                       <div class="row">
                         <div class="form-group col-md-6">
                            <label>Yeild Strength</label>
                            <input class="form-control" type="text" name="yeild_strength" id="yeild_strength" value="">                                             
                         </div>
                         <div class="form-group col-md-6">
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
                        <h4 class="modal-title" >Edit Grade</h4>
                        <input type="hidden" name="mode" value="Edit" />
                        <input type="hidden" name="grade_id" id="grade_id" />
                    </div>
                    <div class="modal-body"> 
                         <div class="row">  
                         <div class="form-group col-md-3">
                            <label>Grade Name</label>
                            <input class="form-control" type="text" name="grade_name" id="grade_name" value="">                                             
                         </div> 
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
                       </div>
                       <div class="row">
                         <div class="form-group col-md-3">
                            <label>P</label>
                            <input class="form-control" type="text" name="P" id="P" value="">                                             
                         </div> 
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
                       </div>
                       <div class="row">
                         <div class="form-group col-md-3">
                            <label>Mg</label>
                            <input class="form-control" type="text" name="Mg" id="Mg" value="">                                             
                         </div>
                        <div class="form-group col-md-3">
                            <label>BHN</label>
                            <input class="form-control" type="text" name="BHM" id="BHM" value="">                                             
                         </div>
                         <div class="form-group col-md-3">
                            <label>Tensile</label>
                            <input class="form-control" type="text" name="tensile" id="tensile" value="">                                             
                         </div>
                         <div class="form-group col-md-3">
                            <label>Elongation</label>
                            <input class="form-control" type="text" name="elongation" id="elongation" value="">                                             
                         </div>
                       </div>
                       <div class="row">
                         <div class="form-group col-md-6">
                            <label>Yeild Strength</label>
                            <input class="form-control" type="text" name="yeild_strength" id="yeild_strength" value="">                                             
                         </div>
                         <div class="form-group col-md-6">
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
