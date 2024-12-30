<?php 
    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else {
        $user_id = '' ;
    }

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content=" width=device-width, initial-scale=1">
        <!-- box icon cdn link -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
        <title>Cửa hàng - Vườn Hoa Tươi</title> 
    </head>
    <body>
    <?php include 'components/user_header.php'; ?>

    <div class="banner">  
        <div class="detail">  
            <h1>about us</h1>  
            <p>Chúng tôi cam kết mang đến dịch vụ tốt nhất với sự tận tâm và chuyên nghiệp.  
            <br>Mọi thắc mắc sẽ được giải đáp nhanh chóng để đảm bảo sự hài lòng của bạn.</p>
            <span><a href="home.php">Trang Chủ</a><i class="bx bx-right-arrow-alt"></i>Blog</span>  
        </div>  
    </div>
     
    <div class="use">  
        <div class="box-container">  
            <div class="box">  
                <img src="image/flowers.png" class="img">  
            </div>  
            <div class="box">  
            <h1>Sẵn Sàng Cho Sự Tiện Lợi Và Nhanh Chóng</h1>  
            <p>Sản phẩm của chúng tôi được thiết kế để mang đến sự tiện lợi tức thì cho bạn.  
            <br>Chỉ cần vài bước đơn giản, bạn đã có thể tận hưởng dịch vụ hoàn hảo mà không mất nhiều thời gian.  
            <br>Chúng tôi cam kết đáp ứng mọi nhu cầu của bạn một cách nhanh chóng và hiệu quả nhất.</p>

                <div class="icon">  
                    <div class="icon-detail">  
                        <div class="img-box"><img src="image/use.png"></div>  
                        <p>Hoa Chất Lượng</p>  
                    </div>  
                    <div class="icon-detail">  
                        <div class="img-box"><img src="image/use0.png"></div>  
                        <p>Hoa Mịn Màng & Chắc Chắn</p>  
                    </div>  
                </div>  

                <div class="icon">  
                    <div class="icon-detail">  
                        <div class="img-box"><img src="image/use1.png"></div>  
                        <p>Hoa Trồng Hữu Cơ</p>  
                    </div>  
                    <div class="icon-detail">  
                        <div class="img-box"><img src="image/use2.png"></div>  
                        <p>Không Hóa Chất</p>  
                    </div>  
                </div>  

                <div class="flex-btn">
                    <a href="shop.php" class="btn">Mua Ngay</a>
                    <a href="contact.php" class="btn">hãy gọi cho chúng tôi</a>

                </div>
            </div>  
        </div>  
    </div>




        <!-- -------------------who we are section end------------------->  
        <div class="who">
    <div class="container">
        <div class="box">
        <div class="heading">
            <span>Về Chúng Tôi</span>
            <h1>Chúng Tôi Đam Mê Mang Đến Vẻ Đẹp Tự Nhiên Cho Mỗi Đoá Hoa</h1>
            <img src="image/separator.png" alt="Separator">
        </div>

        <p>
            Chúng tôi là những người đam mê nghệ thuật cắm hoa, với niềm tin rằng mỗi bông hoa đều có thể mang lại sự tươi mới và niềm vui cho cuộc sống. 
            Được nuôi dưỡng bởi sự tận tâm và sáng tạo, chúng tôi luôn không ngừng cải tiến và mang đến những sản phẩm chất lượng cao nhất.
            Mỗi bó hoa là một tác phẩm nghệ thuật, được chăm chút từ những chi tiết nhỏ nhất để đảm bảo vẻ đẹp hoàn hảo.
        </p>

        <div class="flex-btn">
            <a href="menu.php" class="btn">Khám Phá Thêm Bộ Sưu Tập Hoa</a>
            <a href="home.php" class="btn">Thăm Cửa Hàng Của Chúng Tôi</a>
        </div>

        </div>
        <div class="img-box">
            <img src="image/who.jpg" alt="Who We Are" class="img">
            <img src="image/shape.png"  class="shape">
        </div>
    </div>
</div>
            <!-- cms banner section-->
        
<div class="cms-banner">  
    <div class="box-container">  
        <div class="box">  
            <img src="image/cms-banner.avif">  
            <div class="detail">  
            <span>Giảm Giá 35%</span>  
                <h1>Hoa Tươi & <br>Cây Cảnh Tươi Mới</h1>
                <a href="menu.php" class="btn">Mua Ngay</a>  
            </div>  
        </div>  
        <div class="box">  
            <img src="image/cms-banner.jpg">  
            <div class="detail">  
            <span>Giảm Giá 15%</span>  
                <h1>Hoa Tươi & <br>Cây Cảnh Tươi Mới</h1>
                <a href="menu.php" class="btn">Mua Ngay</a>  
            </div>  
        </div>  
    </div>  
</div>

                <!-- story section-->
    <div class="story">  
        <div class="box">  
        <div class="heading">  
    <span>Hoa Tươi & Khỏe Mạnh</span>  
        <h1>Giảm Giá Lên Đến 30% Cho Đơn Hàng Mua Lần Đầu</h1>  
    </div>  
    <p style="color: red; text-transform: uppercase; padding-bottom: .5rem;">Nhận Thêm 20% Giảm Giá</p>  
    <p>Chúng tôi cam kết mang đến những bông hoa tươi đẹp nhất, được chăm sóc kỹ lưỡng để đảm bảo sự tươi mới và độ bền lâu dài.  
    <br>Với nhiều lựa chọn hoa và cây cảnh, bạn có thể tìm thấy sản phẩm phù hợp cho mọi dịp. Mua sắm dễ dàng và nhận được sự phục vụ tận tình từ đội ngũ chuyên nghiệp của chúng tôi.</p>  
    <a href="services.php" class="btn">Dịch Vụ Của Chúng Tôi</a>  

        </div>  
    </div>       

        <!-- team section -->


        <div class="team">
            <div class="heading">
                <span>Đội Ngũ Của Chúng Tôi</span>
                <h1>Chất Lượng & Đam Mê Trong Mỗi Dịch Vụ!</h1>
                <img src="image/separator.png">
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="image/team.avif" class="img">
                    <div class="content">
                        <h2>Fiona Edwards</h2>
                        <p>Chuyên Gia Cắm Hoa</p>
                    </div>
                </div>

                <div class="box">
                    <img src="image/team0.jpg" class="img">
                    <div class="content">
                        <h2>Ealph Johnson</h2>
                        <p>Chuyên Gia Lên Kế Hoạch Cưới</p>

                    </div>
                </div>

                <div class="box">
                    <img src="image/team2.avif" class="img">
                    <div class="content">
                        <h2>Cris H.Van</h2>
                        <p>Tiệc Cưới</p>
                    </div>
                </div>
            </div>
        </div>
            <!-- about section -->
    <div class="about">
        <div class="box-container">
            <div class="box">
                <div class="heading">
                <span>Về Công Ty</span>
                    <h1>Cung Cấp Hoa Hữu Cơ & Lành Mạnh <br> Từ Nông Trại</h1>
                    <p>Chúng tôi cung cấp những bó hoa tươi đẹp, chất lượng cao dành cho các công ty, văn phòng, tạo không gian làm việc tươi mới và đầy cảm hứng.</p>

            </div>
        </div>
    </div>

          <!--Why choose us section -->
    <div class="choose">
        <div class="box-container">
            <div class="img-box">
                <img src="image/about.jpg">
            </div>
            <div class="box">
            <div class="heading">
    <span>Tại Sao Chọn Chúng Tôi</span>
    <h1>Chăm Sóc Đặc Biệt Cho Mỗi Người Yêu Hoa</h1>
        </div>
        <div class="box-detail">
            <div class="detail">
                <img src="image/discount.png" alt="Discount Options">
                <h2>Ưu Đãi Giảm Giá</h2>
                <p>Chúng tôi cung cấp các ưu đãi giảm giá đặc biệt cho các khách hàng thân thiết và đơn hàng số lượng lớn.</p>
                <span>1</span>
            </div>

            <div class="detail">
                <img src="image/gift.png" alt="Gift Offers">
                <h2>Quà Tặng Đặc Biệt</h2>
                <p>Nhận những món quà tặng hấp dẫn khi mua hoa tại cửa hàng của chúng tôi, mang đến niềm vui cho người nhận.</p>
                <span>2</span>
            </div>

            <div class="detail">
                <img src="image/return.png" alt="Return Policy">
                <h2>Chính Sách Đổi Trả Tốt Nhất</h2>
                <p>Chúng tôi cam kết hỗ trợ đổi trả sản phẩm nhanh chóng và dễ dàng nếu bạn không hài lòng với hoa đã nhận.</p>
                <span>3</span>
            </div>

            <div class="detail">
                <img src="image/support.png" alt="Online Support">
                <h2>Hỗ Trợ Trực Tuyến</h2>
                <p>Đội ngũ hỗ trợ của chúng tôi luôn sẵn sàng giúp bạn 24/7 để giải đáp mọi thắc mắc và yêu cầu của bạn.</p>
                <span>4</span>
            </div>
        </div>

                </div>
            </div>
        </div>
    </div>

          <!--testimonial section -->

          <div class="testimonial-container">
                <div class="heading">
                    <h1>Ý Kiến Khách Hàng</h1>
                    <img src="image/separator.png" alt="Separator">
                </div>
                <div class="container">
                    <div class="testimonial-item" active>
                        <i class="bx bxs-qoute-right" id="quote"></i>
                        <img src="image/qtran.jpg" alt="Sara Smith">
                        <h1>quế Trân</h1>
                        <p>Hoa của các bạn thật tuyệt vời! Chất lượng tuyệt hảo và dịch vụ giao hàng rất nhanh chóng. Tôi luôn nhận được những bó hoa tươi mới nhất cho những dịp đặc biệt.</p>
                    </div>

                    <div class="testimonial-item">
                        <i class="bx bxs-qoute-right" id="quote"></i>
                        <img src="image/vantho.png" alt="John Smith">
                        <h1>Văn Thọ</h1>
                        <p>Chúng tôi đã đặt hoa cho sự kiện công ty và nhận được phản hồi rất tích cực. Hoa rất đẹp và bền lâu, thật sự rất ấn tượng!</p>
                    </div>

                    <div class="testimonial-item">
                        <i class="bx bxs-qoute-right" id="quote"></i>
                        <img src="image/ourteam1.webp" alt="CrixH.Van Smith">
                        <h1>CrixH.Van</h1>
                        <p>Hoa tươi, chất lượng vượt trội. Đặc biệt thích cách mà cửa hàng chăm sóc khách hàng và tạo ra những bó hoa đẹp mắt cho mọi dịp.</p>
                    </div>

                    <div class="testimonial-item">
                        <i class="bx bxs-qoute-right" id="quote"></i>
                        <img src="image/vanhoang.png" alt="Alweena Ansari">
                        <h1>Văn Hoàng</h1>
                        <p>Mua hoa từ cửa hàng này luôn mang lại cho tôi niềm vui. Hoa luôn đẹp và bền lâu, đặc biệt là dịch vụ giao hàng đúng giờ.</p>
                    </div>

                    <div class="left-arrow" onclick="rightSlide()"><i class="bx bx-left-arrow-alt"></i></div>
                    <div class="right-arrow" onclick="leftSlide()"><i class="bx bx-right-arrow-alt"></i></div>
                </div>
            </div>


            <!--our mission section -->
    <div class="mission">
        <div class="box-container">
        <div class="box">
            <div class="heading">
                <span>sứ mệnh của chúng tôi</span>
                <h1>Hoa Tươi Với Nụ Cười Tươi Mới</h1>
                <img src="image/separator.png" alt="Separator">
            </div>
            <div class="detail">
                <div class="img-box">
                    <img src="image/flower.png" alt="Fresh Flowers">
                </div>
                <div>
                    <h2>Hoa Tươi Mới</h2>
                    <p>Chúng tôi cam kết cung cấp những bó hoa tươi mới nhất, giúp không gian của bạn trở nên rực rỡ và đầy sức sống.</p>
                </div>
            </div>

            <div class="detail">
                <div class="img-box">
                    <img src="image/delivery.png" alt="Delivery">
                </div>
                <div>
                    <h2>Giao Hàng Trong 24 Giờ</h2>
                    <p>Hoa của bạn sẽ được giao nhanh chóng trong vòng 24 giờ, đảm bảo tươi mới và chất lượng tuyệt vời.</p>
                </div>
            </div>

            <div class="detail">
                <div class="img-box">
                    <img src="image/app.png" alt="Order Online">
                </div>
                <div>
                    <h2>Đặt Hàng Online</h2>
                    <p>Đặt hoa nhanh chóng và dễ dàng ngay trên website của chúng tôi, mang lại sự tiện lợi và tiết kiệm thời gian cho bạn.</p>
                </div>
            </div>

            <div class="detail">
                <div class="img-box">
                    <img src="image/support.png" alt="Support">
                </div>
                <div>
                    <h2>Hỗ Trợ 24/7</h2>
                    <p>Đội ngũ hỗ trợ của chúng tôi luôn sẵn sàng giải đáp mọi thắc mắc và giúp bạn trong suốt quá trình mua sắm.</p>
                </div>
            </div>
        </div>
    </div>

</div></div></div>





    <?php include 'components/user_footer.php'; ?>

        <!-- sweetalert cdnlink -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <!-- cusstom js link -->
         <script type="text/javascript" src="js/user_script.js"></script>
        <!-- alert -->
        <?php include 'components/alert.php'; ?>

    </body>
</html> 