<?php
session_start();//bắt đầu phiên
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ocasuid']==0)) {//kiểm tra thông tin người dùng
  header('location:logout.php');//nếu không có thông tin thì logout
  } else{
    if(isset($_POST['submit']))//kiểm tra xem submit ở html có khác null không
  {

//gán các giá trị lấy từ html thông qua method post bằng các biến tương ứng
 $subject=$_POST['subject'];
 $notestitle=$_POST['notestitle'];
 $notesdesc=$_POST['notesdesc'];
  $eid=$_GET['editid'];// editid lấy qua url bằng pt get gán bằng $eid
  //update từ bảng tbnotes đặt Subject,Subject,NotesDecription điều kiện ID=:eid
$sql="update tblnotes set Subject=:subjectSubject=:notestitle,NotesDecription=:notesdesc where ID=:eid";
$query=$dbh->prepare($sql);//chuẩn bị câu lệnh
//trói buộc các giá trị

$query->bindParam(':subject',$subject,PDO::PARAM_STR);
$query->bindParam(':notestitle',$notestitle,PDO::PARAM_STR);
$query->bindParam(':notesdesc',$notesdesc,PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
 $query->execute();//thực thi
         echo '<script>alert("Ghi chú đã được cập nhập")</script>';//thông báo đã thay đổi thành công
         echo "<script>window.location.href ='manage-notes.php'</script>";//chuyển về trang manage
}
?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ONSS || Cập Nhật Ghi Chú</title> <!--Thêm tiêu đề website 'ONSS || Cập Nhật Ghi Chú'-->
  
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
                            <h6 class="mb-4">Chỉnh Sửa Ghi Chú</h6> <!--Tạo đề mục 'Chỉnh Sửa Ghi Chú'-->
                            <form method="post"> <!--sử dụng phương thức post của html-->
 <?php
  $eid=$_GET['editid'];// editid lấy qua url bằng pt get gán bằng $eid
  //sử dụng PDO để kết nối csdl 
$sql="SELECT * from tblnotes where tblnotes.ID=:eid";//chọn tất cả từ tbnotes dk tblnotes.ID=:eid
$query = $dbh -> prepare($sql);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)//nếu số hàng bị tác động >0
{
foreach($results as $row)//dùng vòng foreach để duyệt qua các ob kết quả, mỗi ob gán bằng $row
{               ?>
                                

                                <br />
                                <div class="mb-3">
                                <label for="exampleInputEmail2" class="form-label">Chủ Đề</label> <!--gán nhãn tên là 'Chủ Đề'-->
                                    <!-- row truy cập vào các thuộc tính cần hiển thị và đưa ra màn hình thông qua html-->
                                    <input type="text" class="form-control"  name="subject" value="<?php  echo htmlentities($row->Subject );?>" required='true'><!--Tạo ô nhập dữ liệu dạng văn bản để thêm chủ để-->
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Tên Ghi Chú</label> <!--gán nhãn tên là 'Tên Ghi Chú'-->
                                    <input type="text" class="form-control"  name="notestitle" value="<?php  echo htmlentities($row->NotesTitle);?>" required='true'> <!--tạo ô nhâp dữ liệu dạng văn bản để thêm tên ghi chú-->

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Nội Dung Ghi Chú</label> <!--gán nhãn tên là 'Nội Dung Ghi Chú'-->
                                    <textarea class="form-control"  name="notesdesc" value="" required='true'><?php  echo htmlentities($row->NotesDecription);?></textarea> <!--tạo trang nhập nội dung ghi chú-->
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Xem File1</label> <!--gán nhãn tên là 'Xem File1'-->
                                   <a href="folder1/<?php echo $row->File1;?>"  target="_blank"> <strong style="color: red">Xem</strong></a> | <!--tạo ô tải xuống file1 để xem-->
<a href="changefile1.php?editid=<?php echo $row->ID;?>" > &nbsp;<strong style="color: red" target="_blank">Chỉnh Sửa</strong></a> <!--tạo ô chỉnh sửa in đậm màu đỏ-->

                                </div>
                                 <?php if($row->File2==""){ ?>
<div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Xem File2</label> <!--gán nhãn tên là 'Xem File2'-->
                                    <strong style="color: red">File không tồn tại</strong> <!--Hiển thi 'File không tồn tại' in đậm màu đỏ-->
                                   
                                </div>
                                    <?php } else{?>
                                <div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Xem File2</label> <!--gán nhãn tên là 'Xem File2'-->
                                    <a href="folder2/<?php echo $row->File2;?>" target="_blank"> <strong style="color: red">Xem</strong></a> | <!--tạo ô tải xuống file2 để xem-->
<a href="changefile2.php?editid=<?php echo $row->ID;?>" > &nbsp;<strong style="color: red" target="_blank">Chỉnh Sửa</strong></a> <!--tạo ô chỉnh sửa in đậm màu đỏ-->
                                   
                                </div><?php } ?>
                                 <?php if($row->File3==""){ //nếu file3 trống?>
<div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Xem File3</label> <!--gán nhãn tên là 'Xem File3'-->
                                    <strong style="color: red">File không tồn tại</strong> <!--Hiển thi 'File không tồn tại' in đậm màu đỏ-->
                                   
                                </div>
                                    <?php } else{?>
                                <div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Xem File3</label> <!--gán nhãn tên là 'Xem File3'-->
                                    <a href="folder3/<?php echo $row->File3;?>"  target="_blank"> <strong style="color: red">Xem</strong></a> | <!--tạo ô tải xuống file3 để xem-->
<a href="changefile3.php?editid=<?php echo $row->ID;?>" target="_blank"> &nbsp;<strong style="color: red">Chỉnh Sửa</strong></a> <!--tạo ô chỉnh sửa in đậm màu đỏ-->
                                   
                                </div><?php } ?>
                                <?php if($row->File3==""){ ?>
<div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Xem File4</label> <!--gán nhãn tên là 'Xem File4'-->
                                    <strong style="color: red">File không tồn tại</strong> <!--Hiển thi 'File không tồn tại' in đậm màu đỏ-->
                                   
                                </div>
                                    <?php } else{?>
                                <div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Xem File4</label> <!--gán nhãn tên là 'Xem File4'-->
                                    <a href="folder4/<?php echo $row->File4;?>"target="_blank"> <strong style="color: red">Xem</strong></a> | <!--tạo ô tải xuống file4 để xem-->
<a href="changefile4.php?editid=<?php echo $row->ID;?>" target="_blank"> &nbsp;<strong style="color: red">Chỉnh Sửa</strong></a> <!--tạo ô chỉnh sửa in đậm màu đỏ-->
                                   
                                </div><?php } ?>
                                <?php $cnt=$cnt+1;}} ?>
                                <button type="submit" name="submit" class="btn btn-primary">Cập Nhật</button> <!--tạo nút 'Cập Nhật' kiểu submit-->
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