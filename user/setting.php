<?php
session_start();//bắt đầu phiên 
error_reporting(0);//khong có lỗi
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['ocasuid']==0)) {//kiểm tra thông tin người dùng(được lưu trong biến phiên ở trang đăng nhập )//kiểm tra độ dài biến phiên 
  header('location:logout.php');//==0 tức không có thôn tin-> chuyển đến trang logout 
  } else{
if(isset($_POST['submit']))//kiểm tra xem submit ở html có khác null không
{//nếu có
$uid=$_SESSION['ocasuid'];//gán biến phiên=$uid
$cpassword=md5($_POST['currentpassword']);//gán thông tin từ html // dưới dạng md5 để bảo mật
$newpassword=md5($_POST['newpassword']);
$sql ="SELECT ID FROM tbluser WHERE ID=:uid and Password=:cpassword";//tìm thôn gtin người dùng 
//tìm ID ở bảng tbusẻ với đk uid và cpassword có mặt
$query= $dbh -> prepare($sql);//chuẩn bị câu lệnh
$query-> bindParam(':uid', $uid, PDO::PARAM_STR);//trói buộc thông số 
$query-> bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
$query-> execute();//thực thi
$results = $query -> fetchAll(PDO::FETCH_OBJ);//kết quả trả về dưới dạng đối tượng =$resurls

if($query -> rowCount() > 0)//nếu số hàng bị câu truy vấn ảnh hưởng >0 : có thông tin người dùng trong csdl
{
$con="update tbluser set Password=:newpassword where ID=:uid";//câu lệnh update từ bảng tbuser đặt Password= newpassword
$chngpwd1 = $dbh->prepare($con);//chuẩn bị câu lệnh
$chngpwd1-> bindParam(':uid', $uid, PDO::PARAM_STR);//trói buộc giá trị
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();//thực thi

echo '<script>alert("Mật khẩu đã được đổi!")</script>';//thôgn báo đổi mật khẩu thành công
 echo "<script>window.location.href ='change-password.php'</script>";//quay về trang change-password.php
} else {
echo '<script>alert("Mật khẩu hiện tại không đúng")</script>';//nếu khôgn thông báo đổi bị lỗi

}
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>OCMMS || Thông Tin Cá Nhân</title><!--tạo tiêu đề OCMMS,Thông tin cá nhân-->
    <!--truy xuất đến link chưa fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet --><!--truy xuất đến link chứa icon-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet --><!--truy xuất đến thư viện-->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet --><!--truy xuất đến bootstrap-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet --><!--truy xuất đến template-->
    <link href="css/style.css" rel="stylesheet">
    <script type="text/javascript">
function checkpass()
{
if(document.changepassword.newpassword.value!=document.changepassword.confirmpassword.value)
{
alert('New Password and Confirm Password field does not match');
document.changepassword.confirmpassword.focus();
return false;
}
return true;
}   

</script>
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        
<?php include_once('includes/sidebar.php');?>


        <!-- Content Start -->
        <div class="content">
         <?php include_once('includes/header.php');?>


            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4"><!--padding-top=4,padding-x=4-->
                <div class="row g-4"><!-- tạo hàng,khoảng cách=4-->
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Đổi mật khẩu</h6><!--tạo nhãn đổi mật khẩu-->
                            <form method="post" name="Đổi mật khẩu" onsubmit="return checkpass();">
                               
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Mật khẩu hiện tại</label>
                                    <input type="password" class="form-control" name="" id="currentpassword"required='true'>
                                   <!--Nhập dữ liệu dạng mk,
                                   form-control để áp dụng kiểu dáng của Bootstrap.
                                 required=true trường này bắt buộc phải điền-->
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Mật khẩu mới</label>
                                    <input type="password" class="form-control" name="newpassword"  class="form-control" required="true">
                                </div>
                               <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Xác nhận mật khẩu</label>
                                    <input type="password" class="form-control"  name="confirmpassword id="confirmpassword"  required='true'>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Xác nhận</button><!--tạo nút xác nhận-->
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