<?php
session_start();//bắt đầu phiên 
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ocasuid']==0)) {////kiểm tra thông tin người dùng//kiểm tra độ dài biến phiên 
  header('location:logout.php');// nếu không có thông tin thì out
  } else{
    if(isset($_POST['submit']))//nếu submit lấy từ html không null
  {

$ocasuid=$_SESSION['ocasuid'];//gán biến phiên
 //gán các thông tin lấy từ html để gán vào biến tương ứng 
 $subject=$_POST['subject'];
 $notestitle=$_POST['notestitle'];
 $notesdesc=$_POST['notesdesc'];

 $file1=$_FILES["file1"]["name"];//gán tên tệp tin trên máy khách =$file1,2,3,4
$extension1 = substr($file1,strlen($file1)-4,strlen($file1));//trả về 4 ký tự cuối của chuỗi tên file1,2,3,4 gán bằng $extension1
$file2=$_FILES["file2"]["name"];
$extension2 = substr($file2,strlen($file2)-4,strlen($file2));
$file3=$_FILES["file3"]["name"];
$extension3 = substr($file3,strlen($file3)-4,strlen($file3));
$file4=$_FILES["file4"]["name"];
$extension4 = substr($file4,strlen($file4)-4,strlen($file4));
$allowed_extensions = array("docx",".doc",".pdf");//tạo 1 mảng gồm các ký tự gán bằng $allowed_extensions
//mục đích đưa ra các định dạng file được cho phép

if(!in_array($extension1,$allowed_extensions))//in-aray: so sánh đối chiếu $extension1 với mảng định dạng đã tạo 
{//nếu k đúng
echo "<script>alert('File has Invalid format. Only docx / doc/ pdf format allowed');</script>";//thông  báo k đúng
}


else {//đúng định dạng cho phép 

    $file1=md5($file).time().$extension1;//một chuỗi kết hợp của mã hash MD5 của tên tệp tin gốc, timestamp hiện tại và phần mở rộng của tệp tin.
    if($file2!='')://nếu file 2 đã có
    $file2=md5($file).time().$extension2; endif;//tương tự file1//endif:kết thúc điều kiện if
    if($file3!=''):
    $file3=md5($file).time().$extension3; endif;
    if($file4!=''):
    $file4=md5($file).time().$extension4; endif;
    move_uploaded_file($_FILES["file1"]["tmp_name"],"folder1/".$file1);//lấy thông tin file1 bằng đươnhf dẫn dẫn tới thư mục tạm thời trên máy chủ vào folder1 gán= $file1
 move_uploaded_file($_FILES["file2"]["tmp_name"],"folder2/".$file2);//chuyển file 2 vào folder1 gán= $file2
  move_uploaded_file($_FILES["file3"]["tmp_name"],"folder3/".$file3);
   move_uploaded_file($_FILES["file4"]["tmp_name"],"folder4/".$file4);
//câu lệnh thêm dữ liệu vào bảng tbnotes 
$sql="insert into tblnotes(UserID,Subject,NotesTitle,NotesDecription,File1,File2,File3,File4)values(:ocasuid,:subject,:notestitle,:notesdesc,:file1,:file2,:file3,:file4)";
//sử dụng DPO để truy vấn
$query=$dbh->prepare($sql);
$query->bindParam(':ocasuid',$ocasuid,PDO::PARAM_STR);
$query->bindParam(':subject',$subject,PDO::PARAM_STR);
$query->bindParam(':notestitle',$notestitle,PDO::PARAM_STR);
$query->bindParam(':notesdesc',$notesdesc,PDO::PARAM_STR);
$query->bindParam(':file1',$file1,PDO::PARAM_STR);
$query->bindParam(':file2',$file2,PDO::PARAM_STR);
$query->bindParam(':file3',$file3,PDO::PARAM_STR);
$query->bindParam(':file4',$file4,PDO::PARAM_STR);

 $query->execute();

   $LastInsertId=$dbh->lastInsertId();//ID của bản ghi được chèn cuối cùng gán =$LastInsertId
   if ($LastInsertId>0) {//nếu ID>0)
    echo '<script>alert("Notes has been added.")</script>';//thông báo đã thêm note thành công
echo "<script>window.location.href ='add-notes.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';//thông báo lỗi thêm notes
    }

  
}

}
?>
?>
<!DOCTYPE html> <!--khai báo phiên bản html đang sử dụng-->
<html lang="en"> <!--khai báo ngôn ngữ website sử dụng là tiếng anh-->
<head>
    <title>ONSS || Thêm Ghi Chú</title> <!--thêm tiêu đề website là 'ONSS || Thêm ghi chú'-->
    <!--tương tự file signin.php và signup.php-->
    <!-- Google Web Fonts --> <!-- truy xuất vị trí font-->
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
    <script>
function getSubject(val) { 
    //alert(val);
  $.ajax({
type:"POST",
url:"get-subject.php",
data:'subid='+val,
success:function(data){
$("#subject").html(data);
}});
}
 </script>
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        
<?php include_once('includes/sidebar.php');?>


        <!-- Content Start --> <!--bắt đầu tạo nội dung của phần 'thêm ghi chú'-->
        <div class="content"> 
         <?php include_once('includes/header.php');?>


            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Thêm Ghi Chú</h6> <!--tạo đề mục tên là 'Thêm Ghi Chú'-->
                            <form method="post" enctype="multipart/form-data"> <!--sử dụng phương thức post của html-->
                                
                              

                                <br />
                               
                                <div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Tên Ghi Chú</label> <!--gán nhãn cho ô trông là 'Tên Ghi Chú'-->
                                    <input type="text" class="form-control"  name="notestitle" value="" required='true'><!--tạo ô trống nhập dữ liệu dạng văn bản để thêm tên ghi chú-->

                                 
                                </div>
                                 <div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Chủ Đề</label> <!--gán nhãn cho ô trống là 'Chủ Đề'-->
                                    <input type="text" class="form-control"  name="subject" value="" required='true'> <!--tạo ô trống nhập dữ liệu dạng văn bản để thêm chủ đề của ghi chú-->
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Nội Dung Ghi Chú</label> <!--gán nhãn cho ô trống là 'Nội Dung Ghi Chú'-->
                                    <textarea class="form-control"  name="notesdesc" value="" required='true'></textarea> <!--Tạo trang nhập nội dung ghi chú-->
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Tải Lên</label><!--gán nhãn cho nút là 'Tải Lên'-->
                                   <input type="file" class="form-control"  name="file1" value="" required='true'><!--tạo ô tải lên dữ liệu dạng file-->

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Tải Thêm File</label> <!--gán nhãn cho ô là 'Tải Thêm File'-->
                                   <input type="file" class="form-control"  name="file2" value=""> <!--tạo ô tải lên dữ liệu dạng file-->
                                   
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Tải Thêm File</label> <!--gán nhãn cho ô là 'Tải Thêm File'-->
                                   <input type="file" class="form-control"  name="file3" value="" > <!--tạo ô tải lên dữ liệu dạng file-->
                                   
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail2" class="form-label">Tải Thêm File</label> <!--gán nhãn cho ô là 'Tải Thêm File'-->
                                   <input type="file" class="form-control"  name="file4" value="" > <!--tạo ô tải lên dữ liệu dạng file-->
                                   
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Hoàn Thành</button> <!--tạo nút 'Hoàn Thành' kiểu Submit-->
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