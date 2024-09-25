<?php
session_start();//bắt đầu phiên
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit']))//nếu submit từ html không null
  {
    $email=$_POST['email'];//gán giá trị email,mobile,pass
$mobile=$_POST['mobile'];
$newpassword=md5($_POST['newpassword']);
//kiểm tra email xem đúng k
//chọn email từ bảng tbuser đk email=Email và MobileNumber=:mobile
  $sql ="SELECT Email FROM tbluser WHERE Email=:email and MobileNumber=:mobile";
$query= $dbh -> prepare($sql);//chuẩn bị câu lệnh
//trói buộc giá trị
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$query-> execute();//thực thi
$results = $query -> fetchAll(PDO::FETCH_OBJ);//kết quả trả về dưới dạng object gán bằng $results
if($query -> rowCount() > 0)//nếu số hàng bịanhr hưởng>0(truy vấn thành công, có đối tượng)
{
//thay đổi mật khẩu
//udate từ bảng tbuser đặt Password=:newpassword
$con="update tbluser set Password=:newpassword where Email=:email and MobileNumber=:mobile";
$chngpwd1 = $dbh->prepare($con);//chuân bị câu lệnh
$chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);//trói buộc giá trị
$chngpwd1-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();//thực thi
echo "<script>alert('Thành công thay đổi mật khẩu');</script>";//thông báo đổi pass thành công
}
else {
echo "<script>alert('Email id or Mobile no is invalid');</script>"; //báo lỗi
}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <title>ONSS || Quên Mật Khẩu</title><!--tạo tiêu đề ONS,Quên mật khẩu-->
   

    <!-- Google Web Fonts --><!--truy xuất đến link chứa fonts-->
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
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("New Password and Confirm Password Field do not match  !!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start --><!--tạo biểu tượng quay-->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Đang tải...</span>
                <!--`container-fluid`: Đây là một lớp của Bootstrap để tạo ra một khung chứa toàn màn hình mà không có padding.
                Đặt vị trí của phần tử là tương đối so với vị trí ban đầu.
                backgr màu trắng
                chỉnh các phần tử bên trong theo chiều dọc, padding=0
                 Đặt vị trí của phần tử là cố định trong cửa sổ trình duyệt.
                 Đặt phần tử vào giữa-->
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign In Start --><!--đăng nhập-->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ONSS</h3>
                            </a>
                            <h3>Tạo Mật Khẩu Mới</h3>
                        </div>
                        <form method="post" name="chngpwd" onSubmit="return valid();">
                        <!--phương thức POST tên"chngpwd". Khi gửi đi, hàm valid được gọi để kiểm tra tính hợp lệ của dữ liệu-->
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" placeholder="Email Address" required="true" name="email">
                            <!--Nhập dữ liệu dạng email,lớp form-control để áp dụng kiểu dáng của Bootstrap.
                            placeholder là văn bản gợi ý cho người dùng.
                            required=true trường này bắt buộc phải điền-->
                            <label for="floatingInput">Email </label><!--tạo nhãn để nhập email-->
                        </div>
                        <div class="form-floating mb-4"><!--tạo khảong cách-->
                            <input type="text" class="form-control" placeholder="Mobile Number" required="true" name="mobile" maxlength="10" pattern="[0-9]+">
                            <!--form-control áp dụng kiểu dáng của Bootstrap
                            required=true trường này bắt buộc phải điền
                            độ dài tối đa=10
                            chỉ nhận các kí tự từ 0-9-->
                            <label for="floatingPassword">Số điện thoại</label><!--tạo nhãn để nhập sdt-->
                        </div>
                        <div class="form-floating mb-3"><!--tạo khảong cách-->
                            <input type="password" name="newpassword" class="form-control" placeholder="New Password" required="true">
                            <!--form-control áp dụng kiểu dáng của Bootstrap
                            placeholder là văn bản gợi ý cho người dùng.
                            required=true trường này bắt buộc phải điền-->
    
                            <label for="floatingInput">Mật khẩu mới</label><!--tạo nhãn để nhập mk-->
                        </div>
                        <div class="form-floating mb-3">
                           <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password" required="true">
                            <label for="floatingInput">Xác nhận mật khẩu</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <label class="pull-right">
                                        <a href="signin.php">## Đăng nhập</a><!--chuyển hướng người dùng-->
                                    </label>
                            </div>
                           
                        </div>

                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4" name="submit">Cập nhật</button>
                        <!--tạo nút cập nhật-->
                       
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
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

</html>