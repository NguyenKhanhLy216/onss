<?php
session_start();//bắt đầu phiên
session_unset();//vô hiệu hóa giá trị các biến
session_destroy();//kết thúc phiên
header('location:signin.php');//trở về trang đăng nhập

?>