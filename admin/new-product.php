<?php 
  include("include/security.php");
  include("include/conn.php");  
  
  if(isset($_POST['btnSave']))
  {
    $txtBrand = mysqli_real_escape_string($conn,$_POST['txtBrand']);
    $txtPtitle = mysqli_real_escape_string($conn,$_POST['txtPtitle']);
    $txtPrice = mysqli_real_escape_string($conn,$_POST['txtPrice']);
    $txtDiscount = mysqli_real_escape_string($conn,$_POST['txtDiscount']);
    $txtDesc = mysqli_real_escape_string($conn,$_POST['txtDesc']);
    $txtUrl = mysqli_real_escape_string($conn,$_POST['txtUrl']);

    if(isset($_FILES['txtCover']))
      {
        $file1 = $_FILES['txtCover'];

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
          $txtCover=$file1_destination;
          
        }
        else
        {
          $txtCover="";
        }
      }
      else
      {
        echo "image not load";
      }

    $txtDate = date("Y-m-d H:i:s");

    $selquery ="select * from product_details where name='$txtPtitle'";
    $selresult = mysqli_query($conn,$selquery);
    if($selres = mysqli_fetch_array($selresult))
    {
        echo "<script>alert(\"Already Added\");</script>";
    }
    else
    {
        $insquery = "insert into product_details(brand, name, image, price, price_discount, description, url, status, created_at) VALUES ('$txtBrand', '$txtPtitle', '$txtCover', '$txtPrice', '$txtDiscount', '$txtDesc', '$txtUrl', '0', '$txtDate')";
    }
    if(mysqli_query($conn,$insquery))
      {
        header("Location:product-list");
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
    
    $getquery1 = "select * from product_details where id={$id}";
    $getresult1 = mysqli_query($conn,$getquery1);
    $getres1 = mysqli_fetch_array($getresult1); 
  }

  if(isset($_POST['btnUpdate']))
  {
    $txtBrand = mysqli_real_escape_string($conn,$_POST['txtBrand']);
    $txtPtitle = mysqli_real_escape_string($conn,$_POST['txtPtitle']);
    $txtPrice = mysqli_real_escape_string($conn,$_POST['txtPrice']);
    $txtDiscount = mysqli_real_escape_string($conn,$_POST['txtDiscount']);
    $txtDesc = mysqli_real_escape_string($conn,$_POST['txtDesc']);
    $txtUrl = mysqli_real_escape_string($conn,$_POST['txtUrl']);

    if(isset($_FILES['txtCover']))
      {
        $file1 = $_FILES['txtCover'];

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
          $txtCover=$file1_destination;
          
        }
        else
        {
          $txtCover="";
        }
      }
      else
      {
        echo "image not load";
      }

    $txtMdate = date("Y-m-d H:i:s");

    if (!empty($_FILES['txtCover']['name'])) {
      $insquery = "update product_details SET brand='$txtBrand', name='$txtPtitle', image='$txtCover', price='$txtPrice', price_discount='$txtDiscount', description='$txtDesc', url='$txtUrl', last_update='$txtMdate' WHERE id=$id";
    }
    else
    {
      $insquery = "update product_details SET brand='$txtBrand', name='$txtPtitle', price='$txtPrice', price_discount='$txtDiscount', description='$txtDesc', url='$txtUrl', last_update='$txtMdate' WHERE id=$id"; 
    }

    if(mysqli_query($conn,$insquery))
      {
        header("Location:product-list");
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

    <title>Add/Update Product</title>

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
          return confirm('Are you sure you want to delete this Product?');
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
                  
                  <h4 class="m-t-0 header-title"><b>Product Details</b></h4>
                  <p class="text-muted font-13 m-b-30">
                      Enter product details.
                  </p>
                  <div class="col-md-12 col-sm-12">
                    <?php if(isset($_SESSION['msg'])){?> 
                     <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">??</span></button>
                      <?php echo $_SESSION['msg'] ; ?></a> </div>
                    <?php unset($_SESSION['msg']);}?> 
                  </div>
                  <?php if(isset($_GET['id'])) { ?>
                  <form action="new-product?id=<?php echo $_GET['id'];?>" data-parsley-validate novalidate method="post" enctype="multipart/form-data">
                    
                    <div class="row">
                        <div class="col-lg-12"> 
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="txtBrand">Brand *</label>
                                  <input type="text" name="txtBrand" id="txtBrand" class="form-control" value="<?php echo $getres1['brand']?>" placeholder="" required>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="txtPtitle">Title *</label>
                                  <input type="text" name="txtPtitle" id="txtPtitle" value="<?php echo $getres1['name']?>" class="form-control" required>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="txtCover">Cover Image *</label>
                                  <input type="file" name="txtCover" id="txtCover" class="form-control">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="txtPrice">Price *</label>
                                  <input type="number" name="txtPrice" id="txtPrice" class="form-control" value="<?php echo $getres1['price']?>" required>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="txtDiscount">Discount *</label>
                                  <input type="number" name="txtDiscount" id="txtDiscount" class="form-control" required value="<?php echo $getres1['price_discount']?>">
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="txtDesc">Description *</label>
                                  <textarea class="form-control" name="txtDesc" id="txtDesc"><?php echo $getres1['description']?></textarea>
                                  <script>
                                          CKEDITOR.replace( 'txtDesc' );
                                  </script>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="txtUrl">Url *</label>
                                  <input type="text" name="txtUrl" id="txtUrl" class="form-control" required value="<?php echo $getres1['url']?>" placeholder="http://www.skyforcoding.com">
                                </div>
                              </div>
                            </div><br>
                        </div>
                    </div>
                     <!-- end row -->

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group text-right m-b-0">
                          <button class="btn btn-primary waves-effect waves-light" type="submit" name="btnUpdate"> Update</button>
                          <a href="product-list" class="btn btn-default waves-effect waves-light"> Cancel</a>
                        </div>
                      </div>
                    </div>
                  </form>
                  <?php } else { ?>
                  <form action="new-product" data-parsley-validate novalidate method="post" enctype="multipart/form-data">
                    
                    <div class="row">
                        <div class="col-lg-12"> 
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="txtBrand">Brand *</label>
                                  <input type="text" name="txtBrand" id="txtBrand" class="form-control" value="" placeholder="" required>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="txtPtitle">Title *</label>
                                  <input type="text" name="txtPtitle" id="txtPtitle" class="form-control" required>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="txtCover">Cover Image *</label>
                                  <input type="file" name="txtCover" id="txtCover" class="form-control" required>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="txtPrice">Price *</label>
                                  <input type="number" name="txtPrice" id="txtPrice" class="form-control" required>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="txtDiscount">Discount *</label>
                                  <input type="number" name="txtDiscount" id="txtDiscount" class="form-control" required>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="txtDesc">Description *</label>
                                  <textarea class="form-control" name="txtDesc" id="txtDesc"></textarea>
                                  <script>
                                          CKEDITOR.replace( 'txtDesc' );
                                  </script>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="txtUrl">Url *</label>
                                  <input type="text" name="txtUrl" id="txtUrl" class="form-control" required placeholder="http://www.skyforcoding.com">
                                </div>
                              </div>
                            </div><br>
                        </div>
                    </div>
                     <!-- end row -->

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group text-right m-b-0">
                          <button class="btn btn-primary waves-effect waves-light" type="submit" name="btnSave"> Save</button>
                          <a href="product-list" class="btn btn-default waves-effect waves-light"> Cancel</a>
                        </div>
                      </div>
                    </div>
                  </form>
                  <?php } ?>
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