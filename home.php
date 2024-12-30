<?php 
include 'components/connect.php';

if (isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else {
    $user_id = '' ;
}
include 'components/add_wishlist.php';
include 'components/add_cart.php';



?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content=" width=device-width, initial-scale=1">
        <!-- box icon cdn link -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
        <title>Cửa hàng - Vườn Hoa tươi </title> 
    </head>
    <body>
    <?php include 'components/user_header.php'; ?>

    <!-- home slider section start-->  
    <div class="slider-container">
    <div class="container">
        <div class="slider-item active">
            <img src="image/banner-1.jpg" alt="Banner 1">
        </div>
        <div class="slider-item">
            <img src="image/277300476_1573102143053083_3706253653736926493_n.png" alt="Hoa Hướng Dương">
        </div>
        <div class="slider-item">
            <img src="image/main-banner.jpg" alt="Hoa Tượng Trưng Cho Hi Vọng">
        </div>
        <div class="slider-item">
            <img src="image/banner-bo-hoa-sinh-nhat.png" alt="Hoa Tượng Trưng Cho Tình Bạn">
        </div>
        <div class="slider-item">
            <img src="image/banner-hoa-tot-nghiep-2048x853.png" alt="Ý Nghĩa Của 33 Bông Hồng">
        </div>
    </div>
    <div class="left-arrow" onclick="nextSlide()">
        <i class="bx bx-left-arrow-alt"></i>
    </div>
    <div class="right-arrow" onclick="prevSlide()">
        <i class="bx bx-right-arrow-alt"></i>
    </div>
</div>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slider-item');

    function showSlide(index) {
        if (index >= slides.length) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = slides.length - 1;
        } else {
            currentSlide = index;
        }

        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            if (i === currentSlide) {
                slide.classList.add('active');
            }
        });
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    // Đảm bảo slide đầu tiên được hiển thị khi tải trang
    document.addEventListener('DOMContentLoaded', () => showSlide(currentSlide));
</script>

<style>
    .slider-item {
        display: none;
    }

    .slider-item.active {
        display: block;
    }
</style>

        <!-- -------------------home slider section end------------------->  

        <div class="services">  
            <div class="box-container">  
                <div class="box">  
                    <div class="icon">  
                        <img src="image/service.png">  
                    </div>  
                    <div class="detail">  
                        <h4>Đặt Hàng</h4>  
                        <span>100% An toàn</span>  
                    </div>  
                </div>  
                <div class="box">  
                    <div class="icon">  
                        <img src="image/services2.png">  
                    </div>  
                    <div class="detail">  
                        <h4>Hoa tươi </h4>  
                        <span>100% tự nhiên</span>  
                    </div>  
                </div>  

                <div class="box">  
                    <div class="icon">  
                        <img src="image/services.png">  
                    </div>  
                    <div class="detail">  
                        <h4>Vận Chuyển</h4>  
                        <span>24 * 7 giờ</span>  
                    </div>  
                </div>  

                <div class="box">  
                    <div class="icon">  
                        <img src="image/services0.png">  
                    </div>  
                    <div class="detail">  
                        <h4>Dịch Vụ</h4>  
                        <span>Hỗ trợ Khách Hàng</span>  
                    </div>  
                </div>  

                <div class="box">  
                    <div class="icon">  
                        <img src="image/service.png">  
                    </div>  
                    <div class="detail">  
                        <h4>Tổ chức chuyên nghiệp</h4>  
                        <span>24 * 7 hoàn trả miễn phí</span>  
                    </div>  
                </div>  

                <div class="box">  
                    <div class="icon">  
                        <img src="image/services1.png">  
                    </div>  
                    <div class="detail">  
                        <h4>ưu đãi</h4>  
                        <span>-20% khi mua lần đầu</span>  
                    </div>  
                </div>  
            </div>  
        </div>

        <!-- -------------------service section end------------------->  
        <div class="frame-container">  
            <div class="box-container">  
                <div class="frame">  
                    <div class="detail">  
                        <span>Mùa Hoa Yêu Thương</span>  
                        <h2>50% off</h2>  
                        <h1>tất cả sản phẩm</h1>  
                        <a href="menu.php" class="btn">Mua ngay</a>  
                    </div>  
                </div>  
                <div class="box">  
                    <div class="box-detail">  
                        <img src="image/frame.avif" class="img">  
                        <div class="img-detail">  
                            <span>Phạm vi rộng</span>  
                            <h1>Hoa Tươi Hữu Cơ</h1>  
                            <a href="menu.php" class="btn">Mua ngay</a>
                        </div>  
                    </div>  
                </div>  

                <div class="box">  
                    <div class="box-detail">  
                        <img src="image/frame2.webp" class="img">  
                        <div class="img-detail">  
                            <span>Uy tín-An Toàn</span>  
                            <h1>Sắc Hoa Organic</h1>  
                            <a href="menu.php" class="btn">Mua ngay</a>
                        </div>  
                    </div>  
                </div>  
            </div>  
        </div>

        <!-- -------------------frame section end  1h18p------------------->  
         <div class="about-us">
            <div class="box-container">
                <div class="img-box">
                    <img src="image/about.jpg" class="img">
                    <img src="image/about0.jpg" class="img1">
                    <div class="play"><i class="bx bx-play"></i></div>
                </div>
                <div class="box">
                    <div class="heading">
                        <span>why choose us</span>
                        <h1>Tại sao gọi là Vườn Hoa Tươi </h1>
                        <img src="image/separator.png" >
                        <p>Đặt hoa online đòi hỏi sự uy tín và tin cậy từ shop hoa. Thấu hiểu nỗi lo lắng đó của khách hàng, Chúng mình cam kết mang đến những sản phẩm giống mẫu đã chọn, đảm bảo hoa tươi thắm và đạt chuẩn. Tất cả sản phẩm hoa tươi tại tiệm hoa đều được niêm yết giá cả hợp lý, với dòng sản phẩm đa dạng phù hợp với nhiều phân khúc khách hàng, từ sinh viên, nhân viên văn phòng, đến các doanh nghiệp và đối tác.</p>
                        <a href="about.php" class="btn">Biết thêm</a>
                        <a href="contact.php" class="btn">Chúng tôi</a>

                    </div>
                </div>
            </div>
         </div>

        <!-- -------------------about section end------------------->  
        <div class="sub-banner">
            <div class="box-container">
                <img src="image/banner-1-jpg.jpg" height="85%">
                <img src="image/banner-2-jp.jpg" height="85%">

            </div>
        </div>
        <!-- -------------------sub-banner section end------------------->  
        <div class="categories">
            <div class="heading">
                <h1>Danh mục sản phẩm</h1>
                <img src="image/separator.png">
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="image/features4.avif">
                    <div class="detail">
                        <span>Hương Đồng Gió Nội</span>
                        <h1>Bó Hoa</h1>
                        <a href="menu.php" class="btn">Mua ngay</a>
                    </div>
                </div>

                <div class="box">
                    <img src="image/features2.avif">
                    <div class="detail">
                        <span>Hoa Nhà Vườn</span>
                        <h1>Cây xanh</h1>
                        <a href="menu.php" class="btn">Mua ngay</a>
                    </div>
                </div>

                <div class="box">
                    <img src="image/features0.jpg">
                    <div class="detail">
                        <span>Tươi Như Lúc Hái</span>
                        <h1>Hoa cưới</h1>
                        <a href="menu.php" class="btn">Mua ngay</a>
                    </div>
                </div>

                <div class="box">
                    <img src="image/features3.avif">
                    <div class="detail">
                        <span>Tinh Hoa Đồng Nội</span>
                        <h1>Hoa Phượng Xanh</h1>
                        <a href="menu.php" class="btn">Mua ngay</a>
                    </div>
                </div>
            </div>
        </div>

         <!-- -------------------categories section end------------------->  
         <div class="sub-banner">
            <div class="box-container">
                <img src="image/sub-banner2.avif">
                <img src="image/sub-banner3.avif">

            </div>
        </div>
        <!-- -------------------sub-banner section end------------------->  
        <div class="offer">
            <div class="heading">
                <span>Hương Đồng Gió Nội</span>
                <h1>Mua bất kỳ sản phẩm nào từ green organic<br>tặng một sản phẩm miễn phí</h1>
                <img src="image/separator.png">
            </div>
            <div class="box-container">
                <div class="box">
                    <div class="detail">
                        <h1>tulips tươi</h1>
                        <p> Hoa Tulip là một trong những loài hoa biểu tượng của Hà Lan, nổi tiếng với vẻ đẹp kiêu sa và đa dạng về màu sắc.</p>
                        <a href="menu.php" class="btn">Mua ngay</a>
                    </div>
                    <img src="image/categories.avif">
                </div>

                <div class="box">
                    <div class="detail">
                        <h1>Rosa foetida tươi</h1>
                        <p>Hoa hồng được đặt tên theo mùi của nó – foetida, một từ tiếng Latin, có nghĩa là mùi hôi. Nó có hoa màu vàng với mùi hương mạnh mẽ và không hề tạo cảm giác khó chịu.</p>
                        <a href="menu.php" class="btn">Mua ngay</a>
                    </div>
                    <img src="image/categories.jpg">
                </div>

                <div class="box">
                    <div class="detail">
                        <h1>Hoa hướng dương</h1>
                        <p>Hoa hướng dương hay còn được nhiều người gọi là hoa mặt trời. Hoa có màu vàng rực rỡ và là loài hoa được yêu thích nhất. </p>
                        <a href="menu.php" class="btn">Mua ngay</a>
                    </div>
                    <img src="image/categories2.jpg">
                </div>

                <div class="box">
                    <div class="detail">
                        <h1>Hoa levender</h1>
                        <p>Hoa Oải hương (lavender) – loài hoa của những đắm say, nồng nàn, của tình yêu thủy chung bền chặt.</p>
                        <a href="menu.php" class="btn">Mua ngay</a>
                    </div>
                    <img src="image/categories1.avif">
                </div>
            </div>
        </div>
        <!-- -------------------offer section end-------------------> 
         <div class="offer-1">
            <div class="detail">
                <h1>giảm giá đặc biệt cho tất cả <br>sản phẩm hoa </h1> 
                    <p>Việc chăm sóc bệnh nhân là rất quan trọng, bệnh nhân sẽ được theo dõi, nhưng đồng thời chúng cũng gây ra rất nhiều công sức và đau đớn. Để đi đến chi tiết nhỏ nhất, không ai nên thực hiện bất kỳ loại công việc nào trừ khi anh ta thu được lợi ích nào đó từ nó. Đừng tức giận với nỗi đau trong sự khiển trách trong niềm vui mà anh ấy muốn được thoát khỏi nỗi đau với hy vọng rằng không có sự sinh sản. Trừ khi họ bị dục vọng làm cho mù quáng, nếu không họ sẽ không bước ra; họ có lỗi khi từ bỏ nhiệm vụ của mình và làm mềm lòng, tức là lao động của họ.</p>
                    <div class="container">  
                        <div id="countdown" style="color:#fff;">  
                            <ul>  
                                <li><span id="days"></span> Ngày</li>  
                                <li><span id="hours"></span> Giờ</li>  
                                <li><span id="minutes"></span> Phút</li>  
                                <li><span id="seconds"></span> Giây</li>  
                            </ul>  
                        </div>  
                    </div>  
                        <a href="menu.php" class="btn">Mua ngay</a>
                </div>
            </div>
         </div>
        
        <!-- -------------------offer-1 section end------------------->  
        <div class="products">  
            <div class="heading">  
                <h1>Sản Phẩm mới nhất</h1>  
                <img src="image/separator.png">  
            </div>  
            <?php include 'components/shop.php' ;?>
        </div>
        <!-- -------------------products section end-------------------> 
        <div class="offer-2">  
            <div class="detail">  
                <h1>Chúng tôi tự hào về Vườn Hoa<br>  với thiết kế tinh tế, hoàn hảo không tì vết.</h1>  
                <p>Chào mừng đến với 'Vươn Hoa Tươi' – nơi cung cấp hoa tươi hữu cơ, chất lượng cao, được chọn lọc kỹ càng từ vườn hoa tự nhiên. Chúng tôi mang đến các loại hoa theo mùa, hoa cho các dịp lễ hội, sự kiện, với dịch vụ giao tận nơi nhanh chóng và tận tâm. Mỗi bông hoa tại 'Vườn Hoa Tươi' đều đảm bảo tươi mới và đẹp tự nhiên. Hãy để chúng tôi giúp bạn gửi gắm yêu thương qua những cánh hoa xinh đẹp!</p>  
                <a href="shop.php" class="btn">Mua ngay</a>
            </div>  
        </div>
        <!-- -------------------offer-2 section end------------------->  
        <div class="guarantee">  
                <div class="heading">  
                    <h1>Cam kết của chúng tôi</h1>  
                    <p>Tạo dựng không gian hoàn hảo cho bạn. Chúng tôi luôn sẵn sàng mang đến những sản phẩm hoa tươi đẹp và dịch vụ chuyên nghiệp nhất,</p>  
                    <img src="image/separator.png">  
                </div>  
              
            <div class="box-container">  
                <div class="box">  
                    <img src="image/service0.jpg">  
                    <div class="detail">  
                        <h1>Sự kiện</h1>  
                        <p>Chúng tôi tạo ra các sản phẩm thủ công như trà lá rời hữu cơ, các sản phẩm tắm và cơ thể, cũng như đường tẩm hương, tất cả đều được sản xuất theo từng lô nhỏ để đảm bảo chất lượng và sự tươi mới.</p>  
                    </div>  
                </div>  

                <div class="box">  
                    <img src="image/service.avif" style="height: 18rem;">  
                    <div class="detail">  
                        <h1>Giao hàng</h1>  
                        <p>Chúng tôi cung cấp các sản phẩm thủ công như trà lá rời hữu cơ, các sản phẩm tắm và cơ thể, cùng đường tẩm hương, được sản xuất theo từng lô nhỏ để đảm bảo chất lượng và sự tươi mới.</p>  
                    </div>  
                </div>  

                <div class="box">  
                    <img src="image/service3.avif">  
                    <div class="detail">  
                        <h1>Nhà thiết kế hoa nội thất</h1>  
                        <p>Chúng tôi tạo ra những bó hoa tươi đẹp và các sản phẩm trang trí nội thất từ hoa, được lựa chọn kỹ càng để mang lại không gian sống hài hòa và đầy cảm hứng. </p>  
                    </div>  
                </div>  

                <div class="box">  
                    <img src="image/service1.avif">  
                    <div class="detail">  
                        <h1>Nhà thiết kế hoa ngoại thất</h1>  
                        <p> Chúng tôi tạo ra những mẫu hoa trang trí ngoài trời độc đáo và đẹp mắt, được lựa chọn kỹ càng từ các loài hoa tươi, giúp không gian ngoài trời thêm phần sống động và đầy màu sắc.</p>  
                    </div>  
                </div>  

                <div class="box">  
                    <img src="image/service.jpg">  
                    <div class="detail">  
                            <h1>chăm sóc sức khỏe</h1>  
                            <p>Chúng tôi mang đến những sản phẩm chăm sóc sức khỏe thủ công như trà lá rời hữu cơ, sản phẩm tắm và cơ thể, cùng đường tẩm hương, tất cả được sản xuất theo từng lô nhỏ để đảm bảo chất lượng và sự tươi mới.</p>  
                    </div>  
                </div>  

                <div class="box">  
                    <img src="image/service2.jpg">  
                    <div class="detail">  
                        <h1>Hoa Cưới</h1>  
                        <p>Chúng tôi cung cấp các dịch vụ lên kế hoạch và thiết kế đám cưới, từ việc chọn hoa tươi cho đến những chi tiết trang trí tinh tế, tất cả đều được chăm sóc cẩn thận để mang đến một ngày cưới hoàn hảo và đáng nhớ.</p>  
                    </div>  
                </div>  
            </div>
        </div>






        <!-- -------------------guerentee section end------------------->  


    <?php include 'components/user_footer.php'; ?>

        <!-- sweetalert cdnlink -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <!-- cusstom js link -->
         <script type="text/javascript" src="js/user_script.js"></script>
        <!-- alert -->
        <?php include 'components/alert.php'; ?>

    </body>
</html>