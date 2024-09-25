<!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="dashboard.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                
                <div class="navbar-nav align-items-center ms-auto">
                    
                    
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <?php
                            //dùng PDO để truy vấn chọn tất cả từ bảng tbuer
$uid=$_SESSION['ocasuid'];
$sql="SELECT * from  tbluser where ID=:uid";
$query = $dbh -> prepare($sql);
$query->bindParam(':uid',$uid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)//////dùng vòng foreach để duyệt qua từng đối tượng kết quả, kết quả ở mỗi vòng lặp gán =$row, sau đó $row sẽ truy cập vào thuộc tính mà người lập trình yêu cầu hiện ra thông qua html 
{               ?>
                            <span class="d-none d-lg-inline-flex"><?php  echo $row->FullName;?></span><?php $cnt=$cnt+1;}} ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="profile.php" class="dropdown-item">Hồ sơ cá nhân</a>
                            <a href="setting.php" class="dropdown-item">Cài đặt</a>
                            <a href="logout.php" class="dropdown-item">Đăng xuất</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->