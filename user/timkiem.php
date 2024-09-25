<?php
session_start();//bắt đầu phiên mới
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ocasuid']==0)) { //kiểm tra thông tin người dùng
  header('location:logout.php');//nếu không có thông tin thì logout
  } else{//nếu có
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ONSS || Manage Notes</title>
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        
        <?php include_once('includes/sidebar.php');?>
        <!-- Content Start -->
        <div class="content">
            <?php include_once('includes/header.php');?>


                    <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Tìm kiếm</h6>
                        
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">#</th>
                                   
                                    <th scope="col">Subject</th>
                                    <th scope="col">Notes Title</th>
                                    <th scope="col">Creation Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <form action="timkiem.php" method="get">
                Search: <input type="text" name="search" />
                <input type="submit" name="ok" value="search" />
           
 
 <?php
 
 if (isset($_REQUEST['ok'])){

$ocasuid=$_SESSION['ocasuid'];
$search=addslashes($_GET['search']);
$sqll="SELECT * from tblnotes where UserID=:ocasuid AND NotesTitle=:search ";//chọn tất cả từ bảng tbnotes với dk uerid=ocasuid
$query = $dbh -> prepare($sqll);//chuẩn bị câu lệnh
$query->bindParam(':ocasuid',$ocasuid,PDO::PARAM_STR);
$query->bindParam(':search',$search,PDO::PARAM_STR);//trói buộc giá trị
$query->execute();//thực thi
$results=$query->fetchAll(PDO::FETCH_OBJ);//gán kết quả 

$cnt=1;
if($query->rowCount() == 0){echo "<script>alert('not found');</script>";}
if($query->rowCount() > 0)//nếu số hàng bị bảnh hưởng bới truy vấn>0
{
foreach($results as $row)//dùng vòng foreach để duyệt qua từng đối tượng kết quả, kết uqar ở mỗi vòng lặp gán =$row
{               ?>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <!-- cho row truy cập vào các thuộc tính cần và hiện ra màn hình bằng html-->
                                    <td><?php  echo htmlentities($row->Subject);?></td>
                                    <td><?php  echo htmlentities($row->NotesTitle);?></td>
                                    <td><?php  echo htmlentities($row->CreationDate);?></td>
                                   
                                    <td><a class="btn btn-sm btn-primary" href="edit-notes.php?editid=<?php echo htmlentities ($row->ID);?>">Edit</a> 
                                <?php $cnt=$cnt+1;}}} ?>
                                </form>
        </div></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
           

            <?php include_once('includes/footer.php');?>
        </div>
        <!-- Content End -->
<?php include_once('includes/back-totop.php');?>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html><?php }  ?>