<?php 
//đăng ký
session_start();//bắt đầu một phiên mới=>dùng để lưu trữ thông tin người dùng để phục vụ cho các trang trong web
error_reporting(0);//không có lỗi
include('includes/dbconnection.php');// bao gồm cả file dbconnection.php
if(isset($_POST['submit']))//kiểm tra xem submit được lấy từ html thông qua phương thức post có khác null hay không 
  {//nếu khác null
    $fname=$_POST['fname'];//gán thông tin fname được lấy trên html =$fname
    $mobno=$_POST['mobno'];//gán thông tin monno-sdt được lấy trên html =$mobno
    $email=$_POST['email'];//gán thông tin email được lấy trên html =$email
    
    $password=md5($_POST['password']);//gán thông tin password được lấy trên html =$password dưới dạng 32 ký tự hexa nhằm bảo mật thông tin người dùng,bị tấn công 
    //sử dụng PDO để truy vấn dữ liệu 
    //kiểm tra dữ liệu người dùng đã có trong csdl chưa
    $ret="select Email,MobileNumber from tbluser where Email=:email || MobileNumber=:mobno";//soạn câu lệnh trước//lấy email, sdt từ bảng tbuer với điều kiện email hoặc số dt trung với email,sdt đã nhập
    $query= $dbh -> prepare($ret);//chuẩn bị câu lệnh SQL để thực thi PDO
    $query-> bindParam(':email', $email, PDO::PARAM_STR);//trói buộc thông số biến $email với  tham số :email trong câu truy vấn SQL
    $query->bindParam(':mobno',$mobno,PDO::PARAM_INT);//trói buộc thông số//PDO::PARAM_INT:thông số gán dạng int
    
    $query-> execute();//thực thi
    $results = $query -> fetchAll(PDO::FETCH_OBJ);//kết quả thực thi trả về dưới dạng đối tượng gán bằng $results 
if($query -> rowCount() == 0)// nếu số hàng bị ảnh hưởng ==0: tức là chưa có dữ liệu người dùng này 
{//bắt đầu thêm dl người dùng
$sql="insert into tbluser(FullName,MobileNumber,Email,Password)Values(:fname,:mobno,:email,:password)";//câu lệnh thêm dữ liệu vào bảng tbuser
$query = $dbh->prepare($sql);//chuẩn bị câu lệnh SQL để thực thi PDO
$query->bindParam(':fname',$fname,PDO::PARAM_STR);//trói buộc dữ liệu $fname với :fname
$query->bindParam(':email',$email,PDO::PARAM_STR);//trói buộc dữ liệu $emailvới :email
$query->bindParam(':mobno',$mobno,PDO::PARAM_INT);//trói buộc dữ liệu $mobno với :mobno

$query->bindParam(':password',$password,PDO::PARAM_STR);//trói buộc dữ liệu $password với :password
$query->execute();// thực thi
$lastInsertId = $dbh->lastInsertId();//gán ID của bản ghi được chèn vào dl gần nhất =$lastInsertId 
if($lastInsertId)//nếu có giá trị ID thì 
{

echo "<script>alert('You have successfully registered with us');</script>";//in ra màn hình đã đăng ký thành công
echo "<script>window.location.href ='signin.php'</script>";//chuyển hướng đến trang đăng nhập
}
else
{

echo "<script>alert('Something went wrong.Please try again');</script>";// nếu khônng thì báo lỗi
}
}
 else
{

echo "<script>alert('Email-id or Mobile Number is already exist. Please try again');</script>";
}
}
?>
<!DOCTYPE html>
<html lang="en"><!--khai báo ngôn ngữ mà website sử dụng là tiếng anh-->

<head>
    
    <title>ONSS || Đăng Ký</title> <!--Thêm tiêu đề website là 'ONSS || Đăng ký'-->
   

    <!-- Google Web Fonts --> <!--truy xuất vị trí các liên kết chứa font dùng trong website-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet --> <!--truy xuất vị trí các file biểu tượng dùng trong website-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet --> <!--truy xuất vị trí thư viện-->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet --> <!--truy xuất vị trí của Bootstrap-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet --><!--truy xuất vị trí template-->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0"> <!--tạo một khối gồm các câu lệnh căn chính-->
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Đang tải...</span> <!--hiện dòng chữ 'Đang tải...' khi chuyển kênh-->
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ONSS</h3> <!--tạo tiêu đề 'ONSS' liên kết với file index.html-->
                            </a>
                            <h3>Đăng Ký</h3> <!--tạo tiêu đề 'Đăng Ký'-->
                        </div>
                        <form method="post"> <!--sử dụng phương thức post của html-->
                        <div class="form-floating mb-3">
                            <input type="text" value="" name="fname" required="true" class="form-control"> <!--tạo ô trống nhập dữ liệu dạng văn bản để thêm họ và tên-->
                            <label for="floatingInput">Họ và tên</label><!--gán nhãn 'Họ và tên cho ô trống-->
                        </div>
                        <div class="form-floating mb-4">
                            <input type="text" name="mobno" class="form-control" required="true" maxlength="10" pattern="[0-9]+"><!--tạo ô trống nhập dữ liệu dạng văn bản để thêm số điện thoại-->
                            <label for="floatingPassword">Số điện thoại</label><!--gán nhãn 'số điện thoại cho ô trống-->
                        </div>
                        <div class="form-floating mb-4">
                            <input type="email" class="form-control" value="" name="email" required="true"><!--tạo ô trống nhập dữ liệu dạng văn bản để thêm email-->
                            <label for="floatingPassword">Email</label><!--gán nhãn cho ô trống là 'email'-->
                        </div>
                      
                        <div class="form-floating mb-4">
                            <input type="password" value="" class="form-control" name="password" required="true"><!--tạo ô trống nhập dữ liệu dạng văn bản để thêm mật khẩu-->
                            <label for="floatingPassword">Mật khẩu</label><!--gán nhãn cho ô trống là 'mật khẩu'-->
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                           
                            <a href="signin.php">Đã đăng ký !!</a> <!--tạo link tên là 'đã đăng ký' liên kết với file signin.php-->
                        </div>

                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4" name="submit">Đăng ký</button> <!--tạo nút 'Đăng ký' kiểu submit-->
                       
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