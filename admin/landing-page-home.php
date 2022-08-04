<?php
include("include/security.php");
include("include/conn.php");

$getquery4 = "select fname,lname,user_id from tbl_user_master where uname='$user'";
$getresult4 = mysqli_query($conn,$getquery4);
$getres4 = mysqli_fetch_array($getresult4);
$userid = $getres4['user_id'];

$selquery4 = "select * from tbl_lndn_home_page where id=1";
$selresult4 = mysqli_query($conn,$selquery4);
$selres4 = mysqli_fetch_array($selresult4);

if(isset($_POST['btnUpdate']))
  {
    $txtHStitle = mysqli_real_escape_string($conn,$_POST['txtHStitle']);
    $txtDesc = mysqli_real_escape_string($conn,$_POST['txtDesc']);

    if(isset($_FILES['txtHSimg']))
    {
      $file1 = $_FILES['txtHSimg'];

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
        $txtHSimg=$file1_destination;
        
      }
      else
      {
        $txtHSimg="";
      }
    }
    else
    {
      echo "image not load";
    }

    if(isset($_FILES['txtBHSimg']))
    {
      $file1 = $_FILES['txtBHSimg'];

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
        $txtBHSimg=$file1_destination;
        
      }
      else
      {
        $txtBHSimg="";
      }
    }
    else
    {
      echo "image not load";
    }

    $txtDate = date("Y-m-d H:i:s");
      
    if(!empty($_FILES['txtHSimg']['name']) and !empty($_FILES['txtBHSimg']['name'])) //new image uploaded
    {
      $updquery = "update tbl_lndn_home_page set home_title='$txtHStitle', home_desc='$txtDesc', home_img='$txtHSimg', home_bg_img='$txtBHSimg', last_modi_date='$txtDate' where id=1";
    }
    elseif (!empty($_FILES['txtHSimg']['name'])) {
      $updquery = "update tbl_lndn_home_page set home_title='$txtHStitle', home_desc='$txtDesc', home_img='$txtHSimg', last_modi_date='$txtDate' where id=1";
    }
    elseif (!empty($_FILES['txtBHSimg']['name'])) {
      $updquery = "update tbl_lndn_home_page set home_title='$txtHStitle', home_desc='$txtDesc', home_bg_img='$txtBHSimg', last_modi_date='$txtDate' where id=1";
    }
    else {// no image uploaded
      $updquery = "update tbl_lndn_home_page set home_title='$txtHStitle', home_desc='$txtDesc', last_modi_date='$txtDate' where id=1";
    }

      if(mysqli_query($conn,$updquery))
      {
          header("Location:landing-page-home");
      }
      else
      {
          //echo $updquery;
          echo '<script type="text/javascript">';
          echo 'setTimeout(function () { swal(
                                                "Oops...",
                                                "Something went wrong !!",
                                                "error"
                                              );';
          echo '}, 1000);</script>';
      } 
  }
/*} else {
        header("location:error.php");
      exit;
    }
}
else
{
    header("location:error.php");
    exit;
}*/
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Landing Page Setting</title>

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
    <script src="https://cdn.ckeditor.com/4.11.3/standard/ckeditor.js"></script>
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
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card-box">
                  
                  <h4 class="m-t-0 header-title"><b>Landing Page - Home</b></h4>
                  <p class="text-muted font-13 m-b-30">
                      Update home screen content and images.
                  </p>
                  <form action="landing-page-home.php" data-parsley-validate novalidate method="post" enctype="multipart/form-data">
                    
                    <div class="row">
                        <div class="col-lg-12"> 
                            <div class="form-group">
                              <label for="txtHStitle">Home Screen Title *</label>
                              <input type="text" name="txtHStitle" parsley-trigger="change" required class="form-control" id="txtHStitle" value="<?php echo $selres4['home_title']; ?>">
                            </div>
                        </div>
                        <div class="col-lg-12"> 
                            <div class="form-group">
                              <label for="txtHSimg">Home Screen Img *</label>
                              <input type="file" name="txtHSimg" parsley-trigger="change" class="form-control" id="txtHSimg" <?php if($selres4['home_img']=='') { echo "required"; } ?>>
                              <small><a href="<?php echo $selres4['home_img']; ?>" target="_blank">current image</a></small>
                            </div>
                        </div>
                        <div class="col-lg-12"> 
                            <div class="form-group">
                              <label for="txtBHSimg">Home Screen Background Img *</label>
                              <input type="file" name="txtBHSimg" parsley-trigger="change" class="form-control" id="txtBHSimg" <?php if($selres4['home_bg_img']=='') { echo "required"; } ?>>
                              <small><a href="<?php echo $selres4['home_bg_img']; ?>" target="_blank">current image</a></small>
                            </div>
                        </div>
                        <div class="col-lg-12"> 
                            <div class="form-group">
                              <label for="txtDesc">Description *</label>
                              <textarea name="txtDesc" parsley-trigger="change" required class="form-control" id="txtDesc" ><?php echo $selres4['home_desc']; ?></textarea>
                              <script>
                                      CKEDITOR.replace( 'txtDesc' );
                              </script>
                            </div>
                        </div>
                    </div>
                     <!-- end row -->

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group text-right m-b-0">
                          <button class="btn btn-primary waves-effect waves-light" type="submit" name="btnUpdate" id="btnUpdate" > Update</button>
                          <!-- <a href="user-list.php" class="btn btn-default waves-effect waves-light m-l-5"> Cancel</a> -->
                          <a href="privacy-policy" class="btn btn-default waves-effect waves-light"> Cancel</a>
                        </div>
                      </div>
                    </div>
                  </form>
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
              $('#datatable-responsive').DataTable();
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
          });
          TableManageButtons.init();

      </script>
    
  </body>
</html>