<?php
session_start();//bắt đầu phiên mới
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ocasuid']==0)) { //kiểm tra thông tin người dùng
  header('location:logout.php');//nếu không có thông tin thì logiut
  } else{//có thông tin thì
     if(isset($_POST['submit']))//kiểm tra submit từ html có null không
  {//không null
    $uid=$_SESSION['ocasuid'];//gán giá trị biến phiên =$uid
    
    $fname=$_POST['name'];//gán tên 
  $mobno=$_POST['mobilenumber'];//gán sdt
  $email=$_POST['email'];//gán email
  //update từ bảng tbuser đặt fullname=name,MobileNumber=mobilenumber,Email=email  điều kiện ID=uid
  $sql="update tbluser set FullName=:name,MobileNumber=:mobilenumber,Email=:email where ID=:uid";

     $query = $dbh->prepare($sql);//chuẩn bị câu lệnh
     //trói buộc giá trị
     $query->bindParam(':name',$fname,PDO::PARAM_STR);
     $query->bindParam(':email',$email,PDO::PARAM_STR);
     $query->bindParam(':mobilenumber',$mobno,PDO::PARAM_STR);
     $query->bindParam(':uid',$uid,PDO::PARAM_STR);
$query->execute();//thực thi câu lệnh

        echo '<script>alert("Thông tin cá nhân đã được thay đổi")</script>';//thông báo đã update thành công
     

  }
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ONSS || Thông Tin Cá Nhân</title> <!--Đặt tên tiêu đề của website là 'ONSS || Thông Tin Cá Nhân'-->
  
    <!--Tương tự như file signin.php và signup.php-->
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


            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Hồ Sơ Người Dùng</h6>
                            <form method="post">
 <?php
$uid=$_SESSION['ocasuid'];//gán biến phiên =$uid
$sql="SELECT * from tbluser where ID=:uid";//chọn tất cả ở bảng tbuser với đk id=uid
$query = $dbh -> prepare($sql);//chuẩn bị câu lệnh
$query->bindParam(':uid',$uid,PDO::PARAM_STR);//trói buộc gíá trị
$query->execute();//thực thi
$results=$query->fetchAll(PDO::FETCH_OBJ);//kết quả dưới dạng đối tượng = $results
$cnt=1;//??
if($query->rowCount() > 0)//nếu số hàng bị ảnh hưởng>0( có thông tin người dùng)
{
foreach($results as $row)//dùng vòng foreach lặp qua đối tượng 
{               ?>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Họ và tên</label> <!--gán nhãn cho ô trống là 'Họ và tên'-->
                                    <input type="text" class="form-control"  name="name" value="<?php  echo $row->FullName;//row truy cập vào thuộc tính full name và in ra màn hình?>" required='true'> <!--tạo ô trống nhập dữ liệu dạng văn bản để nhập họ và tên-->
                                   
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Email</label> <!--gán nhãn cho ô trống là 'Email'-->
                                    <input type="email" class="form-control" name="email" value="<?php  echo $row->Email;//in ra màn hình email của row?>" required='true'> <!--tạo ô trống nhập dữ liệu dạng email để nhập email-->
                                </div>
                              
                               <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Số điện thoại</label> <!--gán nhãn cho ô trống là 'số điện thoại'-->
                                    <input type="text" class="form-control" name="mobilenumber" value="<?php  echo $row->MobileNumber;?>" required='true' maxlength='10' readonly> <!--tạo ô trống nhập dữ liệu dạng văn bản để nhập số điện thoại-->
                                </div>
                                
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Ngày đăng ký</label> <!--gán nhãn cho ô trống là 'Ngày đăng ký'-->
                                   <input type="text" class="form-control" id="email2" name="" value="<?php  echo $row->RegDate;?>" readonly="true"> <!--tạo ô trống nhập dữ liệu dạng văn bản để nhập ngày đăng ký-->
                                </div>
                                
                                <?php $cnt=$cnt+1;}} ?>
                                <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button> <!--tạo nút 'Cập nhật' kiểu submit-->
                            </form>
                        </div>
                    </div>
                    
                   
                  
                   
                    
                  
                </div>
            </div>
            <!-- Form End -->


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