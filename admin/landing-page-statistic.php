<?php
include("include/security.php");
include("include/conn.php");

$getquery4 = "select fname,lname,user_id from tbl_user_master where uname='$user'";
$getresult4 = mysqli_query($conn,$getquery4);
$getres4 = mysqli_fetch_array($getresult4);
$userid = $getres4['user_id'];

$selquery4 = "select * from tbl_lndn_statistic where id=1";
$selresult4 = mysqli_query($conn,$selquery4);
$selres4 = mysqli_fetch_array($selresult4);

if(isset($_POST['btnUpdate']))
  {
    $txtTRplayed = mysqli_real_escape_string($conn,$_POST['txtTRplayed']);
    $txtTparti = mysqli_real_escape_string($conn,$_POST['txtTparti']);
    $txtWnAmt = mysqli_real_escape_string($conn,$_POST['txtWnAmt']);
    $txtRewards = mysqli_real_escape_string($conn,$_POST['txtRewards']);
    
    if($_POST['checkbox1'])
    {
      $checkbox1 = '1';
    }
    else
    {
      $checkbox1 = '0'; 
    }

    if($_POST['checkbox2'])
    {
      $checkbox2 = '1';
    }
    else
    {
      $checkbox2 = '0'; 
    }

    if($_POST['checkbox3'])
    {
      $checkbox3 = '1';
    }
    else
    {
      $checkbox3 = '0'; 
    }

    if($_POST['checkbox4'])
    {
      $checkbox4 = '1';
    }
    else
    {
      $checkbox4 = '0'; 
    }

    if(isset($_FILES['txtBGimg']))
    {
      $file1 = $_FILES['txtBGimg'];

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
        $txtBGimg=$file1_destination;
        
      }
      else
      {
        $txtBGimg="";
      }
    }
    else
    {
      echo "image not load";
    }

    $txtDate = date("Y-m-d H:i:s");
      
    if (!empty($_FILES['txtBGimg']['name'])) {
      $updquery = "update tbl_lndn_statistic set bg_img='$txtBGimg', total_tournaments='$txtTRplayed', with_live_tp='$checkbox1', total_participants='$txtTparti', with_live_tparti='$checkbox2', winning_amount='$txtWnAmt', with_live_wa='$checkbox3', rewards='$txtRewards', with_live_rw='$checkbox4', date_modify='$txtDate' where id=1";
    }
    else {// no image uploaded
      $updquery = "update tbl_lndn_statistic set total_tournaments='$txtTRplayed', with_live_tp='$checkbox1', total_participants='$txtTparti', with_live_tparti='$checkbox2', winning_amount='$txtWnAmt', with_live_wa='$checkbox3', rewards='$txtRewards', with_live_rw='$checkbox4', date_modify='$txtDate' where id=1";
    }
    
    if(mysqli_query($conn,$updquery))
    {
        header("Location:landing-page-statistic");
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


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Landing Page Statistic</title>

    <?php include_once("include/head-section.php"); ?>
    <link href="assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />
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
                  
                  <h4 class="m-t-0 header-title"><b>Landing Page - Statistic</b></h4>
                  <p class="text-muted font-13 m-b-30">
                      Manage Landing page Statistic Counter.
                  </p>
                  <form action="landing-page-statistic.php" data-parsley-validate novalidate method="post" enctype="multipart/form-data">
                    
                    <div class="row">
                        <div class="col-lg-12"> 
                            <div class="form-group">
                              <label for="txtBGimg">Background Image *</label>
                              <input type="file" name="txtBGimg" parsley-trigger="change" class="form-control" id="txtBGimg" <?php if($selres4['bg_img']=='') { echo "required"; } ?>>
                              <small><a href="<?php echo $selres4['bg_img']; ?>" target="_blank">current image</a></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                              <label for="txtTRplayed">Tournaments Played *
                                  <div class="checkbox">
                                      <input id="checkbox1" name="checkbox1" <?php if($selres4['with_live_tp']=='1') { echo "checked"; } ?> type="checkbox">
                                      <label for="checkbox1">
                                          Integrate Live Data
                                      </label>
                                  </div>
                              </label>
                              <input type="number" name="txtTRplayed" parsley-trigger="change" required class="form-control" id="txtTRplayed" value="<?php echo $selres4['total_tournaments']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                              <label for="txtTparti">Total Participants *
                                  <div class="checkbox">
                                      <input id="checkbox2" name="checkbox2" <?php if($selres4['with_live_tparti']=='1') { echo "checked"; } ?> type="checkbox">
                                      <label for="checkbox2">
                                          Integrate Live Data
                                      </label>
                                  </div>
                              </label>
                              <input type="number" name="txtTparti" parsley-trigger="change" required class="form-control" id="txtTparti" value="<?php echo $selres4['total_participants']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                              <label for="txtWnAmt">Winning Amount *
                                  <div class="checkbox">
                                      <input id="checkbox3" name="checkbox3" <?php if($selres4['with_live_wa']=='1') { echo "checked"; } ?> type="checkbox">
                                      <label for="checkbox3">
                                          Integrate Live Data
                                      </label>
                                  </div>
                              </label>
                              <input type="number" name="txtWnAmt" parsley-trigger="change" required class="form-control" id="txtWnAmt" value="<?php echo $selres4['winning_amount']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                              <label for="txtRewards">Rewards *
                                  <div class="checkbox">
                                      <input id="checkbox4" name="checkbox4" <?php if($selres4['with_live_rw']=='1') { echo "checked"; } ?> type="checkbox">
                                      <label for="checkbox4">
                                          Integrate Live Data
                                      </label>
                                  </div>
                              </label>
                              <input type="number" name="txtRewards" parsley-trigger="change" required class="form-control" id="txtRewards" value="<?php echo $selres4['rewards']; ?>">
                            </div>
                        </div>
                    </div>
                     <!-- end row -->

                    <div class="row">
                      <div class="col-md-6">
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
      
      <script src="assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>
      <script src="assets/plugins/switchery/js/switchery.min.js"></script>

      <script type="text/javascript" src="assets/pages/jquery.form-advanced.init.js"></script>
      
  </body>
</html>