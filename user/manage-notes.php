<?php
session_start();//bắt đầu phiên mới
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ocasuid']==0)) { //kiểm tra thông tin người dùng
  header('location:logout.php');//nếu không có thông tin thì logout
  } else{//nếu có
    if(isset($_GET['delid']))//nếu  thông số delid lấy  ở url thông qua method GET không null
{
$rid=intval($_GET['delid']);//làm tròn thông số delid dưới dạng số nguyên gán bằng $rid
$sql="delete from tblnotes where ID=:rid";//xóa ở bảng tbnoté với dk ID=rid
$query=$dbh->prepare($sql);//chuẩn bị câu lệnh
$query->bindParam(':rid',$rid,PDO::PARAM_STR);//trói buộc giá trị
$query->execute();//thực thi
 echo "<script>alert('Data deleted');</script>"; //thông báo xóa thành công
  echo "<script>window.location.href = 'manage-notes.php'</script>";     //quay về trang manage


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ONSS || Quản Lí Ghi Chú</title>><!--tạo tiêu đề ONS,Qli ghi chú-->
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
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        
        <?php include_once('includes/sidebar.php');?>
        <!-- Content Start -->
        <div class="content">
            <?php include_once('includes/header.php');?>


                    <div class="container-fluid pt-4 px-4"><!--padding top-4, x=4-->
                <div class="bg-light text-center rounded p-4"><!--backgr sáng, bo góc-->
                    <div class="d-flex align-items-center justify-content-between mb-4"><!--căn chỉnh-->
                        <h6 class="mb-0">Quản Lí Ghi Chú</h6><!--tạo nhãn-->
                        
                    </div>
                    <div class="table-responsive"><!--tạo bảng có các cột dữ liệu, tiêu đề..-->
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">#</th>
                                   
                                    <th scope="col">Chủ đề</th>
                                    <th scope="col">Tiêu đề</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
 <?php
$ocasuid=$_SESSION['ocasuid'];//gán biến phiên 
$sql="SELECT * from tblnotes where UserID=:ocasuid";//chọn tất cả từ bảng tbnotes với dk uerid=ocasuid
$query = $dbh -> prepare($sql);//chuẩn bị câu lệnh
$query->bindParam(':ocasuid',$ocasuid,PDO::PARAM_STR);//trói buộc giá trị
$query->execute();//thực thi
$results=$query->fetchAll(PDO::FETCH_OBJ);//gán kết quả 

$cnt=1;
if($query->rowCount() > 0)//nếu số hàng bị bảnh hưởng bới truy vấn>0
{
foreach($results as $row)//dùng vòng foreach để duyệt qua từng đối tượng kết quả, kết uqar ở mỗi vòng lặp gán =$row
{               ?>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <!-- cho row truy cập vào các thuộc tính cần và hiện ra màn hình bằng html-->
                                    <td><?php  echo htmlentities($row->Subject);?></td>
                                    <td><?php  echo htmlentities($row->NotesTitle);?></td>
                                    <td><?php  echo htmlentities($row->CreationDate);?></td>
                                   
                                    <td><a class="btn btn-sm btn-primary" href="edit-notes.php?editid=<?php echo htmlentities ($row->ID);?>">Sửa</a> <a class="btn btn-sm btn-primary" href="manage-notes.php?delid=<?php echo ($row->ID);?>"  onclick="return confirm('Bạn xác nhận muốn xóa ghi chú ?');">Xóa</a></td>
                                </tr><?php $cnt=$cnt+1;}} ?>
                               
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