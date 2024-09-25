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
    <title>ONSS || Dashboard</title>
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
                                <h1>Xin chào, <?php  echo $row->FullName;?> <span>  lắng nghe nhé!</span></h1><?php $cnt=$cnt+1;}} ?>
                        
                    </div>
                    
                </div>
            </div>
            <!-- Recent Sales End -->
<div class="container-fluid pt-4 px-4"><!--tạo ra một vùng chứa linh hoạt-->
                <div class="row g-8">
                   
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4"><!-- nền sáng, viền bo tròn, được căn giữa dọc -->
                            <i class="fa fa-file fa-6x text-primary"></i><!-- chèn icon thư mục-->
                            <div class="ms-3">
                                <p class="mb-2">Đọc văn bản</p>
                                <form  method="post" enctype="multipart/form-data"><!--Một biểu mẫu với phương thức POST và enctype là "multipart/form-data", được sử dụng để tải lên tệp.-->
                                <div class="mb-3"><!--margin bên trái 3 đơn vị.-->
                                    <label for="exampleInputEmail2" class="form-label">Upload File</label><!-- Một nhãn với thuộc tính for tương ứng với một input, có nội dung là "Upload File".-->
                                   <input type="file" class="form-control"  name="ne" value="" required='true'><!-- tạo một Một ô nhập dữ liệu cho phép người dùng chọn tệp để tải lên, bắt buộc nhâpk-->


                                </div>
                                <?php
                                if(isset($_FILES["ne"])) {//kiểm tra file có null không
                                    $tmp_file_path = $_FILES["ne"]["tmp_name"];//gán đường dẫn đến file tạm trên máy chủ
                                   
                                 $text = file_get_contents( $tmp_file_path);//đọc file, gán đầu ra =$text
                                 echo "<script>alert('File đã được đọc ');</script>";//thông báo đã đọc được file
                                }
                                else{ echo "<script>alert('Không đọc được file rồi !!!!');</script>";}
?>
                         <textarea id="textToConvert" rows="4" cols="50" 
                         placeholder="Nhập nội dung để chuyển văn bản thành giọng nói"> <?php echo $text //in nội dung đọc file ?> , vui lòng nhập để đọc !    </textarea>
                                    <button id="chuyen">Đọc</button>
<script>//sử dụng speechSynthesis để chuyển văn bản thành giọng nói
const textarea = document.querySelector("textarea");//chọn phần tử textare đầu tiên gán bằng textare
const button = document.querySelector("button");//chọn phần tử button đầu tiên gán bằng tbutoon

let isSpeaking = true;//tạo biến ispeaking gán bằng true
const textToSpeech = () => {//tạo hàm
  const synth = window.speechSynthesis;//gọi speechSynthesis từ window, gán 
  const text = textarea.value;// lấy giá trị textare, gán

  if (!synth.speaking && text) {//kiểm tra xem có lời thoại và văn bản nao đang được nhâp và phát k
    const utternace = new SpeechSynthesisUtterance(text);// nêú k thì bắt đầu phát 
    synth.speak(utternace);
  }

  if (text.length > 50) {//nếu độ dài chữ >50
    if (synth.speaking && isSpeaking) {// nếu đang phát
      button.innerText = "Dừng";//dừng
      synth.resume();
      isSpeaking = false;
    } else {
      button.innerText = "Tiếp";//tiếp
      synth.pause();
      isSpeaking = true;
    }
  } else {
    isSpeaking = false;
    button.innerText = "Chuyển ngay";
  }

  setInterval(() => {
    if (!synth.speaking && !isSpeaking) {
      isSpeaking = true;
      button.innerText = "Chuyển ngay";
    }
  });
};
button.addEventListener("click", textToSpeech);
</script>
</div>
</form>

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