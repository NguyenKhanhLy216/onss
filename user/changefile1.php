<?php
session_start();//bắt đầu phiên 
// changefile 1 2 3 4 giống nhau về cú pháp
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ocasuid']==0)) {//kiểm tra thông tin người dùng
  header('location:logout.php');//nếu không có thì logout
  } else{
    if(isset($_POST['submit']))//nếu submit từ html không null
  {

 
 $eid=$_GET['editid'];//gán editid lấy từ url thông qua method get =$eid
 $file1=$_FILES["file1"]["name"]; //tên gốc của file1 trên máy khách  =$file1
$extension1 = substr($file1,strlen($file1)-4,strlen($file1));//lấy 4 ký tự cuối cùng của tên file 1
$allowed_extensions1 = array(".pdf");//tạo mảng định dạng được phép 

if(!in_array($extension1,$allowed_extensions1))//duyệt $extension1 qua mảng allow, nêu k trùng
{
echo "<script>alert('File has Invalid format. Only pdf format allowed');</script>";//thông báo lỗi định dạng 
}
else
{
//nếu đúng
$file1=md5($file).time().$extension1;//chuỗi gồm tên file, thời gian và định dạng được mã hóa hexa 32 ký tư gán =$file1 
  move_uploaded_file($_FILES["file1"]["tmp_name"],"folder1/".$file1);//chuyển file1 vào folder1 dưới tên file1
//update từ bảng tbnotes đăt File1=:file1
  $sql="update tblnotes set File1=:file1 where ID=:eid";
  //dùng PDO để truy vấn
$query=$dbh->prepare($sql);

$query->bindParam(':file1',$file1,PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
 $query->execute();
  echo '<script>alert("Notes doc file has been updated")</script>';//thônng báo update file hoàn tất
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ONSS || Cập Nhật Ghi Chú</title><!--tạo tiêu đề ONS,Cập nhật ghi chú-->
  
    <!-- Google Web Fonts --> <!--truy xuất đến link chưa fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet --><!--truy xuất đến các biểu tượng-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet --><!--truy xuất đến thư viện-->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet --><!--truy xuất đến Bootstrap một kiểu CSS-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet --><!--truy xuất đến template-->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0"><!--định dạng và kiểm soát vị trí , đặt nền thành màu trắng
    Đặt giá trị padding của phần tử thành 0, loại bỏ khoảng trắng xung quanh nội dung bên trong-->
        
<?php include_once('includes/sidebar.php');?><!-- gắn nội dung của tệp sidebar vào trang hiện tại-->


        <!-- Content Start -->
        <div class="content">
         <?php include_once('includes/header.php');?><!--gắn tệp header.php vào trang hiện tại-->


            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4"><!--tạo một nhóm có màu nền  là light,bo viền, chiều cao 100, padding=4-->
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Chỉnh Sửa File Đã Lưu</h6><!--hiển thị tiêu đề-->
                            <form method="post" enctype="multipart/form-data"><!--tải lên file thông qua enctype multipart/form-data-->
                                <?php
                                $eid=$_GET['editid'];//gán editid lấy từ url thông qua method get =$eid
$sql="SELECT * from tblnotes where tblnotes.ID=:eid";//chọn tất cả từ bảng tbnotes điều kiện ID=eid
//dùng PDO để thực thi
$query = $dbh -> prepare($sql);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)//nếu số hàng bị ảnh hưởng>0
{
foreach($results as $row)////dùng vòng foreach để duyệt qua từng đối tượng kết quả, kết quả ở mỗi vòng lặp gán =$row, sau đó $row sẽ truy cập vào thuộc tính mà người lập trình yêu cầu hiện ra thông qua html 
{               ?>
                                
                                <div class="mb-3"><!--tạo khoảng cách dưới cho phần tử bên trong-->
                                    <label for="exampleInputEmail2" class="form-label">Tên Ghi Chú\</label>
                                    <!--gắn nhãn Tên ghi chú,for="exampleInputEmail2"liên kết nhãn với trường nhập liệu có ID là "exampleInputEmail2". 
                                    form-label sử dụng để tùy chỉnh kiểu dáng của nhãn-->
                                    <input type="text" class="form-control"  name="notestitle" value="<?php  echo htmlentities($row->NotesTitle);?>" readonly='true'>
                                     <!--kiểu dữ liệu là text, form-control áp dụng kiểu dáng cho trường nhập liệu,xác định tên của trường là notes title,không cho phép người dùng chỉnh sửa-->
                                    
                                </div>
                               
                                <div class="mb-3"><!--tạo khoảng cách dưới cho phần tử bên trong-->
                                    <label for="exampleInputEmail2" class="form-label">Xem File1 cũ</label> <!--gắn nhãn Xem file,
                            
                                 for="exampleInputEmail2"liên kết nhãn với trường nhập liệu có ID là "exampleInputEmail2". 
                                    form-label sử dụng để tùy chỉnh kiểu dáng của nhãn-->
                                   <a href="folder1/<?php echo $row->File1;?>" width="100" height="100" target="_blank"> <strong style="color: red">Xem file cũ</strong></a>
                                   <!-- tạo liên kết View Old File dẫn đến tệp tin trong thư mục folder1. Khi người dùng nhấp vào, tệp tin sẽ được mở trong tab mới-->


                                </div>
                               
                                <div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Tải lên file mới</label><!--tạo nhãn thêm file mới-->
                                   <input type="file" class="form-control"  name="file1" value="" required='true'><!--cho phép tải file lên-->

                                </div>
                               
                                <?php $cnt=$cnt+1;}} ?>
                                <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
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