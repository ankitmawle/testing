<?php 
if(isset($_POST['page'])){ 
    // Include pagination library file 
    include_once 'Pagination.class.php'; 
     
    // Include database configuration file 
    require_once 'include/conn.php'; 
     
    // Set some useful configuration 
    $baseURL = 'getData_off.php'; 
    $offset = !empty($_POST['page'])?$_POST['page']:0; 
    $limit = 10; 
     
    // Set conditions for search 
    $whereSQL = $orderSQL = ''; 
    if(!empty($_POST['keywords'])){ 
        $whereSQL = "WHERE t.coins>0 and (u.fname LIKE '%".$_POST['keywords']."%' or u.lname LIKE '%".$_POST['keywords']."%' or t.id LIKE '%".$_POST['keywords']."%' or t.transaction_id LIKE '%".$_POST['keywords']."%' or t.note LIKE '%".$_POST['keywords']."%')"; 
    } 
    else
    {
      $whereSQL = "WHERE t.coins>0";
    }
    if(!empty($_POST['sortBy'])){ 
        $orderSQL = " ORDER BY u.fname ".$_POST['sortBy']; 
    }else{ 
        $orderSQL = " ORDER BY t.id DESC "; 
    } 
     
    // Count of all records 
    if(!empty($_POST['keywords']))
    {
      $query = $conn->query("select COUNT(*) as rowNum FROM tbl_offline_plyments as t left join user_details as u on u.id=t.user_id ".$whereSQL);
    }
    else
    {
      $query = $conn->query("SELECT COUNT(*) as rowNum FROM tbl_offline_plyments as t ".$whereSQL); 
    }
    $result  = $query->fetch_assoc(); 
    $rowCount= $result['rowNum']; 
     
    // Initialize pagination class 
    $pagConfig = array( 
        'baseURL' => $baseURL, 
        'totalRows' => $rowCount, 
        'perPage' => $limit, 
        'currentPage' => $offset, 
        'contentDiv' => 'postContent', 
        'link_func' => 'searchFilter' 
    ); 
    $pagination =  new Pagination($pagConfig); 
 
    // Fetch records based on the offset and limit 
    $query = $conn->query("select t.*, u.fname, u.lname, u.email, u.mobile, u.cur_balance, u.won_balance, u.id as usrID from tbl_offline_plyments as t
                              left join user_details as u on u.id=t.user_id
                              $whereSQL $orderSQL LIMIT $offset,$limit"); 
     
    if($query->num_rows > 0){ 
    ?> 

    <div class="table-responsive">
                              <table id="datatable-responsive1" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                  <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Transaction_id</th>
                                        <th>Register Name</th>
                                        <!-- <th>Email</th> -->
                                        <th>Coin</th>
                                        <!-- <th>Winning Prize</th> -->
                                        <th>Amount</th>
                                        <th>Wallet</th>
                                        <th>Holder Name</th>
                                        <th>User's Mobile Number/Email</th>
                                        <th>Comment</th>
                                        <th>Req. Date</th>
                                        <th style="text-align: center;">Status</th>
                                        <!--<th>Action</th>-->
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php while($selres = $query->fetch_assoc()){ ?>
                                      <tr>
                                          <td><?php echo $selres['id']; ?></td>
                                          <td><?php echo $selres['transaction_id']; ?></td>
                                          <td>
                                            <?php echo $selres['fname']." ".$selres['lname']; ?>                                      
                                          </td>
                                          <!-- <td><?php //echo $selres['email']; ?></td> -->
                                          <td><?php echo $selres['coins']; ?></td>
                                          <!-- <td><?php //echo $selres['winPrize']; ?></td> -->
                                          <td><?php echo $selres['amount']; ?></td>
                                          <td>Offine Payment</td>
                                          <td><?php echo $selres['fname']; ?></td>
                                          <td><?php echo $selres['email']; ?></td>
                                          <td><?php echo $selres['note']; ?></td>
                                          <td><?php echo date('d-m-Y H:i:s', $selres['created_at']); ?></td>
                                          <!-- <td><?php //echo date('d-m-Y H:i:s', $selres['date']); ?></td> -->

                                          <?php if ($selres['status'] == 0){ ?>
                                            <td>
                                              <div class="flip-card">
                                                <div class="flip-card-inner">
                                                  <div class="flip-card-front">
                                                    Pending
                                                  </div>
                                                  <div class="flip-card-back">
                                                    <a class="btn btn-danger" href="offline.php?withdrawId=<?php echo $selres['id'];?>" data-toggle="tooltip" data-placement="top" title="Reject" data-original-title="Reject"><i class="fa fa-times"></i></a>
                                                    
                                                    <a href="#" data-rid="<?php echo $selres['id'];?>" data-uid="<?php echo $selres['user_id'];?>" data-withCoin="<?php echo $selres['coins_used'];?>" data-remail="<?php echo $selres['email']; ?>" data-rname="<?php echo $selres['fname']." ".$selres['lname']; ?>" class="btn btn-success rejectreq" data-toggle="modal" data-target="#myModal"><i class="fa fa-check"></i></a>
                                                  </div>
                                                </div>
                                              </div>
                                            </td>
                                          <?php } else { ?>
                                            <?php if ($selres['status']==2){ ?>
                                              <td style="text-align: center; color: red;"> Rejected</td>
                                            <?php } else if ($selres['status']==1) { ?>
                                              <td style="text-align: center; color: green;"> Completed</td>
                                            <?php } ?>
                                          <?php } ?>
                                          
                                          <td>
                                            <a class="btn btn-xs btn-primary" href="withdrawal-detail.php?withdrawId=<?php echo $selres['id'];?>" class="edit-row" style="color: #29b6f6;" data-toggle="tooltip" data-placement="top" title="View Details" data-original-title="View Details"><i class="fa fa-external-link"></i></a>&nbsp;&nbsp;
                                            <a class="btn btn-xs btn-primary" href="user-statistic?userStatId=<?php echo $selres['usrID'];?>" class="edit-row" style="color: #29b6f6;" data-toggle="tooltip" data-placement="top" title="View User Statistic" data-original-title="ViewView User Statistic"><i class="fa fa-list"></i></a>
                                          </td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                              </table>
                            </div>
  <!-- Display pagination links -->
  <?php echo $pagination->createLinks(); ?>

<?php 
    }else{ 
        echo '<p>Post(s) not found...</p>'; 
    } 
} 
?>