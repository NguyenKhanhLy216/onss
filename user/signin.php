<?php
session_start();//bắt đầu một phiên mới
//error_reporting(0);//không báo lỗi
include('includes/dbconnection.php');

if(isset($_POST['login'])) //nếu login ở html không null
  {
    $emailormobnum=$_POST['emailormobnum'];//gán các gía trị lấy từ html thông qua phuong thức post bằng các biến
    $password=md5($_POST['password']);
  // chọn email, sdt,pass, ID từ bảng tbuser với điều kiện email hoặc sdt,password phải bằng với email,sdt nhập,pass vào
    $sql ="SELECT Email,MobileNumber,Password,ID FROM tbluser WHERE (Email=:emailormobnum || MobileNumber=:emailormobnum) and Password=:password";
    
    $query=$dbh->prepare($sql);//chuẩn bị câu lệnh
    $query->bindParam(':emailormobnum',$emailormobnum,PDO::PARAM_STR);//trói buộc giá trị của email or sdt dưới dạng string
    $query-> bindParam(':password', $password, PDO::PARAM_STR);//trói buộc giá trị của password dưới dạng string
    $query-> execute();//thực thi câu lệnh
    $results=$query->fetchAll(PDO::FETCH_OBJ);//kết quả trả về dưới dạng ob được gán =$results
    if($query->rowCount() > 0){//nếu số hàng bị ảnh hưởng>0 : tức là truy vấn tìm thấy thông tin
foreach ($results as $result) {//dùng vòng lặp foreach để lặp qua đối tượng, cho phép truy cập vào thuộc tính của đối tượng
    //gán biến tại mỗi vòng lặp = $result tạm
$_SESSION['ocasuid']=$result->ID;//gán ID của đối tượng =biến phiên//biến phiên sẽ được sử dụng trong các trang khác của web 

}
$_SESSION['login']=$_POST['emailormobnum'];//lưu lại email ơr sdt =biến phiên'login'

echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";// đăng nhập thành công thì chuyển hướng đến bảng điều khiển
} else{
echo "<script>alert('Invalid Details');</script>";//không thành công thì in ra thông báo
}
}
?>
<!DOCTYPE html>
<html lang="en"> <!--khai báo ngôn ngữ website sử dụng là tiếng anh-->
<head>
    <title>OCMMS || Đăng Nhập</title> <!--Thêm tiêu đề website là 'OCMMS || Đăng Nhập'-->
    <!-- Google Web Fonts --> <!--truy xuất đến vị trí các link chứa font dùng trong website-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet --> <!--truy xuất vị trí các file chứa biểu tượng-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet --> <!--truy xuất vị trí thư viện-->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet --> <!--truy xuất đến vị trí của Bootstrap - một CSS framework-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet --> <!--truy xuất tới vị trí của template-->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0"> <!--tạo một khối gồm các câu lệnh căn chỉnh-->
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Đang tải...</span> <!--màn hình hiện dòng chữ 'Đang tải...' khi chuyển kênh-->
            </div>
        </div>
       
        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ONSS</h3> <!--Tạo một tiêu đề tên là 'ONSS' liên kết với file html-->
                            </a>
                            <h3>Đăng Nhập</h3> <!--tạo tiêu đề 'Đăng nhập'-->
                        </div>
                        <form method="post"> <!--sử dụng phương thức post của html-->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Email or Mobile Number" required="true" name="emailormobnum"> <!--tạo ô trống nhập dữ liệu dạng văn bản để thêm email hoặc số điện thoại-->
                            <label for="floatingInput">Email hoặc số điện thoại</label><!--gán nhãn cho ô trống là 'Email hoặc số điện thoại-->
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" placeholder="Password" name="password" required="true"> <!--tạo ô trống nhập dữ liệu dạng văn bản để thêm mật khẩu-->
                            <label for="floatingPassword">Mật khẩu</label> <!--gán nhãn cho ô trống là 'mật khẩu'-->
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <a href="forgot-password.php">Quên mật khẩu</a> <!--tạo ô quên mật khẩu liên kết với file php-->
                        </div>
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4" name="login">Đăng nhập</button> <!--tạo nút đăng nhập-->
                        </form>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <a href="../index.php">Quay lại trang chủ!!</a> <!--tạo link quay lại trang chủ liên kết với file php-->
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <a href="signup.php">Tạo tài khoản mới!!</a> <!--tạo link lập tài khoản mới liên kết với file signup.php-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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