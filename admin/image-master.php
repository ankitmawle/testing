<?php
include("include/security.php");
include("include/conn.php");


$selquery = "select * from tbl_image order by img_id desc";
$selres1 = mysqli_query($conn,$selquery);

if(isset($_POST['btnSave']))
{
  $txtImgName = mysqli_real_escape_string($conn,$_POST['txtImgName']);
  $txtImgType = mysqli_real_escape_string($conn,$_POST['txtImgType']);

  if(isset($_FILES['txtImg']))
    {
      $file1 = $_FILES['txtImg'];

      //file properties

      $file1_name=$file1['name'];
      $file1_tmp=$file1['tmp_name'];
      $file1_error=$file1['error'];

      //file extension

      $file_ext=explode('.',$file1_name);
      $file_ext = strtolower($file1_name);

      if($file1_error==0)
      {
        $file1_new = uniqid('',true).'.'.$file_ext;
        $file1_destination='upload/'.$file1_new;
        move_uploaded_file($file1_tmp,$file1_destination);
      }

      if(isset($file1_destination))
      {
        $txtImg=$file1_destination;
        
      }
      else
      {
        $txtImg="";
      }
    }
    else
    {
      echo "image not load";
    }

  $txtDate = date("Y-m-d H:i:s");

  $selquery ="select * from tbl_image where image_name='$txtImgName'";
  $selresult = mysqli_query($conn,$selquery);
  if($selres = mysqli_fetch_array($selresult))
  {
      echo "<script>alert(\"Already Added\");</script>";
  }
  else
  {
      $insquery = "insert into tbl_image (img_type,image_name,image,date_created) values($txtImgType, '{$txtImgName}','{$txtImg}','{$txtDate}')";
  }
  if(mysqli_query($conn,$insquery))
    {
      header("Location:image-master");
    }
    else
    {
        //echo $insquery;
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal(
                                              "Oops...",
                                              "Something went wrong !!",
                                              "error"
                                            );';
        echo '}, 1000);</script>';
    }

}

if(isset($_GET['id']))
{
  $id = $_GET['id'];
  
  $getquery1 = "select * from tbl_image where img_id={$id}";
  $getresult1 = mysqli_query($conn,$getquery1);
  $getres1 = mysqli_fetch_array($getresult1); 
}

if(isset($_POST['btnUpdate']))
{
  $txtImgName = mysqli_real_escape_string($conn,$_POST['txtImgName']);
  $txtImgType = mysqli_real_escape_string($conn,$_POST['txtImgType']);

  if(isset($_FILES['txtImg']))
    {
      $file1 = $_FILES['txtImg'];

      //file properties

      $file1_name=$file1['name'];
      $file1_tmp=$file1['tmp_name'];
      $file1_error=$file1['error'];

      //file extension

      $file_ext=explode('.',$file1_name);
      $file_ext = strtolower($file1_name);

      if($file1_error==0)
      {
        $file1_new = uniqid('',true).'.'.$file_ext;
        $file1_destination='upload/'.$file1_new;
        move_uploaded_file($file1_tmp,$file1_destination);
      }

      if(isset($file1_destination))
      {
        $txtImg=$file1_destination;
        
      }
      else
      {
        $txtImg="";
      }
    }
    else
    {
      echo "image not load";
    }
  $txtMdate = date("Y-m-d H:i:s");

  if (!empty($_FILES['txtImg']['name'])) {
    $insquery = "update tbl_image set img_type=$txtImgType, image_name='{$txtImgName}',image='{$txtImg}',date_created='{$txtMdate}' where img_id = $id";
  }
  else
  {
    $insquery = "update tbl_image set img_type=$txtImgType, image_name='{$txtImgName}',date_created='{$txtMdate}' where img_id = $id"; 
  }

  if(mysqli_query($conn,$insquery))
    {
      header("Location:image-master");
    }
    else
    {
        //echo $insquery;
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal(
                                              "Oops...",
                                              "Something went wrong !!",
                                              "error"
                                            );';
        echo '}, 1000);</script>';
    }

}

if(isset($_GET['did']))
{
  $did = $_GET['did'];
  
  $delquery = "delete from tbl_image where img_id=$did";
  if(mysqli_query($conn,$delquery))
    {
      header("Location:image-master");
    }
    else
    {
        //echo $insquery;
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal(
                                              "Oops...",
                                              "Something went wrong !!",
                                              "error"
                                            );';
        echo '}, 1000);</script>';
    }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Image Master</title>

    <?php include_once("include/head-section.php"); ?>
    <!-- DataTables -->
    <link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/datatables/dataTables.colVis.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/datatables/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <script language="JavaScript" type="text/javascript">
      function checkDelete(){
          return confirm('Are you sure you want to delete this Record?');
      }
    </script>
    <style type="text/css">
      .validation
      {
        font-size: 12px;
        color: #f6504d;
      }
      .validation-box
      {
        border-color: #f6504d;
      }
    </style>
  </head>

  <body class="fixed-left">

    <!-- Begin page -->
    <div id="wrapper">

      <!-- topbar and sidebar -->
      <?php include_once("include/navbar.php"); ?>

      <!-- ============================================================== -->
      <!-- Start right Content here -->
      <!-- ============================================================== -->
      <div class="content-page">
        <!-- Start content -->
        <div class="content">
          <div class="container">

            <!-- Page Content -->
            <div class="row">
              <div class="col-lg-5 col-md-5 col-sm-12">
                <div class="card-box">
                  
                  <h4 class="m-t-0 header-title"><b>Add New Image</b></h4>
                  <p class="text-muted font-13 m-b-30">
                      You can manage Image here.
                  </p>
                  <?php if(isset($_GET['id'])) { ?>
                  <form action="image-master.php?id=<?php echo $_GET['id'];?>" data-parsley-validate enctype="multipart/form-data" novalidate method="post">
                    
                    <div class="row">
                        <div class="col-lg-12"> 
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="txtImgName">Image Type *</label>
                                  <select class="form-control" name="txtImgType" parsley-trigger="change" required>
                                    <option value="">--Select--</option>
                                    <option <?php if($getres1['img_type']==0) { echo 'Selected'; } ?> value="0">Match</option>
                                    <option <?php if($getres1['img_type']==1) { echo 'Selected'; } ?> value="1">Lottery</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="txtImgName">Image Title *</label>
                                  <input type="text" name="txtImgName" value="<?php echo $getres1['image_name']?>" parsley-trigger="change" required placeholder="Enter Image Title" class="form-control" id="txtImgName">
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="txtImg">Image *</label>
                                  <input type="file" name="txtImg" parsley-trigger="change" class="form-control" id="txtImg">
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label>Date</label>
                                  <input readonly value="<?php echo date("Y-m-d"); ?>" type="date" class="form-control">
                                </div>
                              </div>
                            </div><br>
                        </div>
                    </div>
                     <!-- end row -->

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group text-right m-b-0">
                          <button class="btn btn-primary waves-effect waves-light" type="submit" name="btnUpdate" id="btnUpdate" > Update</button>
                          <!-- <a href="user-list.php" class="btn btn-default waves-effect waves-light m-l-5"> Cancel</a> -->
                          <a href="image-master" class="btn btn-default waves-effect waves-light"> Cancel</a>
                        </div>
                      </div>
                    </div>
                  </form>
                  <?php } else { ?>
                  <form action="image-master.php" data-parsley-validate enctype="multipart/form-data" novalidate method="post">
                    
                    <div class="row">
                        <div class="col-lg-12"> 
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="txtImgName">Image Type *</label>
                                  <select class="form-control" name="txtImgType" parsley-trigger="change" required>
                                    <option value="">--Select--</option>
                                    <option value="0">Match</option>
                                    <option value="1">Lottery</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="txtImgName">Image Type *</label>
                                  <input type="text" name="txtImgName" parsley-trigger="change" required placeholder="Enter Image Title" class="form-control" id="txtImgName">
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="txtImg">Image *</label>
                                  <input type="file" name="txtImg" parsley-trigger="change" required class="form-control" id="txtImg">
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label>Date</label>
                                  <input readonly value="<?php echo date("Y-m-d"); ?>" type="date" class="form-control">
                                </div>
                              </div>
                            </div><br>
                        </div>
                    </div>
                     <!-- end row -->

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group text-right m-b-0">
                          <button class="btn btn-primary waves-effect waves-light" type="submit" name="btnSave" id="btnSave" > Save</button>
                          <!-- <a href="user-list.php" class="btn btn-default waves-effect waves-light m-l-5"> Cancel</a> -->
                          <a href="image-master" class="btn btn-default waves-effect waves-light"> Cancel</a>
                        </div>
                      </div>
                    </div>
                  </form>
                  <?php } ?>
                </div>
              </div>
              <div class="col-lg-7 col-md-7 col-sm-12">
                <div class="card-box">
                  
                  <h4 class="m-t-0 header-title"><b>Image List</b></h4>
                  <p class="text-muted font-13 m-b-30">
                      You can manage image here.
                  </p>

                  <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap table-loader" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($selres = mysqli_fetch_array($selres1)){ ?>
                          <tr class="font-13">
                              <td><?php echo $selres['img_id']; ?></td>
                              <td><?php echo $selres['image_name']; ?></td>
                              <td><img src="<?php echo $selres['image']; ?>" height=50 width=50></td>
                              <td><?php echo $selres['date_created']; ?></td>
                              
                              <td>
                                <a href="image-master.php?id=<?php echo $selres['img_id'];?>" class="edit-row" style="color: #29b6f6;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update Record"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                <a href="image-master.php?did=<?php echo $selres['img_id'];?>" class="remove-row" style="color: #f05050;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete Permanently" onclick="return checkDelete()"><i class="fa fa-trash-o"></i></a>
                              </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- /Page Content -->

          </div> <!-- container -->
                               
        </div> <!-- content -->

        <?php include_once("include/footer.php"); ?>

      </div>
      <!-- ============================================================== -->
      <!-- End Right content here -->
      <!-- ============================================================== -->
      
    </div>
    <!-- END wrapper -->

    <script>
        var resizefunc = [];
    </script>

    <!-- jQuery  -->
    <?php include_once("include/common_js.php"); ?>
      
      <script src="assets/plugins/moment/moment.js"></script>
      
      <script src="assets/js/jquery.core.js"></script>
      <script src="assets/js/jquery.app.js"></script>
      <script type="text/javascript" src="assets/plugins/parsleyjs/parsley.min.js"></script>
      <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
      <script src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

      <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
      <script src="assets/plugins/datatables/buttons.bootstrap.min.js"></script>
      <script src="assets/plugins/datatables/jszip.min.js"></script>
      <script src="assets/plugins/datatables/pdfmake.min.js"></script>
      <script src="assets/plugins/datatables/vfs_fonts.js"></script>
      <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
      <script src="assets/plugins/datatables/buttons.print.min.js"></script>
      <script src="assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
      <script src="assets/plugins/datatables/dataTables.keyTable.min.js"></script>
      <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
      <script src="assets/plugins/datatables/responsive.bootstrap.min.js"></script>
      <script src="assets/plugins/datatables/dataTables.scroller.min.js"></script>
      <script src="assets/plugins/datatables/dataTables.colVis.js"></script>
      <script src="assets/plugins/datatables/dataTables.fixedColumns.min.js"></script>

      <script src="assets/pages/datatables.init.js"></script>

      <script type="text/javascript">
          $(document).ready(function () {
              $('#datatable').dataTable();
              $('#datatable-keytable').DataTable({keys: true});
              //$('#datatable-responsive').DataTable();
              $('#datatable-colvid').DataTable({
                  "dom": 'C<"clear">lfrtip',
                  "colVis": {
                      "buttonText": "Change columns"
                  }
              });
              $('#datatable-scroller').DataTable({
                  ajax: "assets/plugins/datatables/json/scroller-demo.json",
                  deferRender: true,
                  scrollY: 380,
                  scrollCollapse: true,
                  scroller: true
              });
              var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
              var table = $('#datatable-fixed-col').DataTable({
                  scrollY: "300px",
                  scrollX: true,
                  scrollCollapse: true,
                  paging: false,
                  fixedColumns: {
                      leftColumns: 1,
                      rightColumns: 1
                  }
              });
              $('#datatable-responsive').DataTable( {
                "order": [[ 0, "desc" ]]
            } );
          });
          TableManageButtons.init();

      </script>
    
  </body>
</html>