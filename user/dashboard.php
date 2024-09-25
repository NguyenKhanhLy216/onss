<?php
session_start();//bắt đầu phiên
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ocasuid']==0)) {//Kiểm tra độ dài biến phiên (xem có thông tin người dùng k)
  header('location:logout.php');//nếu không thì logout
  } else{



  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ONSS || Trang Cá Nhân</title><!--tạo tiêu đề ONS,Trang cá nhân-->
    <!-- Google Web Fonts --><!--truy xuất đến link chưa fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet --><!--truy xuất đến link chứa icon-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet --><!--truy xuất đến thư viện-->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        
        <?php include_once('includes/sidebar.php');?> <!--gắn tệp sidebar.php vào trang hiện tại-->
        <!-- Content Start -->
        <div class="content">
            <?php include_once('includes/header.php');?> <!--gắn tệp header.php vào trang hiện tại-->


            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4"> 
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
 <?php
$uid=$_SESSION['ocasuid'];//gán độ dài biến phiên =$uid
$sql="SELECT * from  tbluser where ID=:uid";//chọn tất cả từ bảng tbuser điều kiện ID=:uid
$query = $dbh -> prepare($sql);//chuẩn bị câu lệnh
$query->bindParam(':uid',$uid,PDO::PARAM_STR);//trói buộc giá trị
$query->execute();//thực thi câu lệnh
$results=$query->fetchAll(PDO::FETCH_OBJ);//gán kết quả xuất ra dưới dạng đối tượng=$results
$cnt=1;
if($query->rowCount() > 0)////nếu số hàng bị câu truy vấn ảnh hưởng >0 
{
foreach($results as $row)////dùng vòng lặp foreach để lặp qua đối tượng kết quả ,gán bằng $row,$row truy cập vào các thuôc tính cần hiển thị ra màn hình thông qua html
{               ?>
                               <h1>Xin chào, <?php  echo $row->FullName;?> <span>  Chào mừng đến với trang chủ</span></h1><?php $cnt=$cnt+1;}} ?>
                        
                        </div>
                        
                    </div>
                </div>
                <!-- Recent Sales End -->
    <div class="container-fluid pt-4 px-4"><!-- padding top=4,padding x=4,tạo khoảng cách,định dạng nội dung bên trong-->
                    <div class="row g-8"><!--margin=8-->
                        <div class="col-sm-6 col-xl-4">
                        <!--chiếm 6 cột trên màn hình khi kích thước màn hình là sm (small)
                         chiếm 4 cột trên màn hình khi kích thước màn hình là xl (extra-large)-->
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <!-- Đặt nền màu nhạt, bo góc,các phần tử con bên trong theo hướng dọc.
                              Căn chỉnh các phần tử con theo trục dọc giữa phần tử cha.
                              Căn chỉnh các phần tử con theo hướng ngang và đặt chúng ở hai bên cạnh nhau.
                              padding=4-->
                                <i class="fa fa-file fa-6x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">Tổng file đã tải lên</p>
 <?php 
$uid=$_SESSION['ocasuid'];//gán biến phiên =$uid
$sql1 ="SELECT * from  tblnotes where UserID=:uid";//chọn tất cả thông tin từ bảng tbnotes 
//dùng pdo để truy vấn
$query1 = $dbh -> prepare($sql1);
$query1->bindParam(':uid',$uid,PDO::PARAM_STR);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);//gán kết quả
$totnotes=$query1->rowCount();//tổng note=số các hàng bị ảnh hưởng
?>
                               <h4 style="color: blue"><?php echo htmlentities($totnotes);?></h4>
                                        <a href="manage-notes.php"><h5>Tổng quan</h5></a>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-sm-6 col-xl-4">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-file fa-6x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Tổng file đã tải lên</p>
                                 <?php 
                                 $uid=$_SESSION['ocasuid'];//gán tên biến
$sql1 ="SELECT 

COUNT(IF(File1!= '',0,NULL)) as file,
COUNT(IF(File2!= '',0,NULL)) as file2,
COUNT(IF(File3!= '',0,NULL)) as file3,
COUNT(IF(File4!= '',0,NULL)) as file4
from  tblnotes where UserID=:uid";
// Nếu giá trị của cột File1 không rỗng, thì IF(File1 != '', 0, NULL) trả về 0 (đã đếm), nếu không trả về NULL (không đếm). Kết quả đếm được đặt tên là file.
//dùng PDO truy vấn
$query1 = $dbh -> prepare($sql1);
$query1->bindParam(':uid',$uid,PDO::PARAM_STR);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);
foreach($results1 as $rows)//dùng vòng lặp 
{
    $totalfiles=$rows->file+$rows->file2+$rows->file3+$rows->file4;
    //tổng files= số đếm file+số đếm file2+số đêm file3+số đếm f4
}
?>
                                <h4 style="color: blue"><?php echo htmlentities($totalfiles);?></h4>
                                        <a href="manage-notes.php"><h5>Tổng quan</h5></a>
                            </div>
                        </div>
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