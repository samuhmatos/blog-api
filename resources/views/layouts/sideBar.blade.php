<div class="sidebar">
    <div class="widget">
        <div class="banner-spot clearfix">
            <div class="banner-img">
                <!-- <img src="upload/banner_07.jpg" alt="" class="img-fluid"> -->
                Propaganda
            </div><!-- end banner-img -->
        </div><!-- end banner -->
    </div><!-- end widget -->

    <div class="widget">
        <h2 class="widget-title">Trend Videos</h2>
        <div class="trend-videos">
        <?php
            foreach ($args['trendVideos'] as $key => $value) {
                $trendVideosTitle = $value['title'];
                $trendVideosCategory = $value['category'];
                $trendVideosSlug = $value['slug'];
                $trendVideosBanner = $value['banner'];
                $trendVideosDate = $value['date'];
                $trendVideosDate_url = $value['date_url'];


                $trendVideosUrl = "/noticia/".$trendVideosCategory."/".$trendVideosDate_url."/".$trendVideosSlug;

                if(strlen($trendVideosTitle) > 32) {
                    $trendVideosTitle = substr($trendVideosTitle, 0, 32)."...";
                }

                echo "
                    <div class='blog-box'>
                        <div class='post-media'>
                            <a href='$trendVideosUrl' title=''>
                                <img src='$trendVideosBanner' alt='' class='img-fluid'>
                                <div class='hovereffect'>
                                    <span class='videohover'></span>
                                </div>
                            </a>
                        </div>
                        <div class='blog-meta'>
                            <h4><a href='$trendVideosUrl' title=''>$trendVideosTitle</a></h4>
                        </div>
                    </div>
                    <hr class='invis'>

                ";
            }
        ?>
        </div><!-- end videos -->
    </div><!-- end widget -->

    <div class="widget">
        <h2 class="widget-title">Posts Populares</h2>
        <div class="blog-list-widget">
            <div class="list-group">
            <?php
                foreach ($args['popularPosts'] as $key => $value) {
                    $popularTitle = $value['title'];
                    $popularCategory = $value['category'];
                    $popularSlug = $value['slug'];
                    $popularBanner = $value['banner'];
                    $popularDate = $value['date'];
                    $popularDate_url = $value['date_url'];

                    $popularUrl = "/noticia/".$popularCategory."/".$popularDate_url."/".$popularSlug;

                    if(strlen($popularTitle) > 32) {
                        $popularTitle = substr($popularTitle, 0, 32)."...";
                    }

                    echo "
                        <a href='$popularUrl' class='list-group-item list-group-item-action flex-column align-items-start'>
                            <div class='w-100 justify-content-between'>
                                <img src='$popularBanner' alt='' class='img-fluid float-left'>
                                <h5 class='mb-1'>$popularTitle</h5>
                                <small>$popularDate</small>
                            </div>
                        </a>
                    ";
                }
            ?>
            </div>
        </div><!-- end blog-list -->
    </div><!-- end widget -->

    <div class="widget">
        <h2 class="widget-title">Recent Reviews</h2>
        <div class="blog-list-widget">
            <div class="list-group">
            <?php
                foreach ($args['recentReviews'] as $key => $value) {
                    $recentReviewsTitle = $value['title'];
                    $recentReviewsCategory = $value['category'];
                    $recentReviewsSlug = $value['slug'];
                    $recentReviewsBanner = $value['banner'];
                    $recentReviewsDate = $value['date'];
                    $recentReviewsDate_url = $value['date_url'];


                    $recentReviewsUrl = "/noticia/".$recentReviewsCategory."/".$recentReviewsDate_url."/".$recentReviewsSlug;

                    if(strlen($recentReviewsTitle) > 36) {
                        $recentReviewsTitle = substr($recentReviewsTitle, 0, 36)."...";
                    }

                    echo "
                        <a href='$recentReviewsUrl' class='list-group-item list-group-item-action flex-column align-items-start'>
                            <div class='w-100 justify-content-between'>
                                <img src='$recentReviewsBanner' alt='' class='img-fluid float-left'>
                                <h5 class='mb-1'>$recentReviewsTitle</h5>

                            </div>
                        </a>
                    ";
                }
            ?>
            </div>
        </div><!-- end blog-list -->
    </div><!-- end widget -->

    <!-- <div class="widget">
        <h2 class="widget-title">Me siga</h2>

        <div class="row text-center">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                <a href="#" class="social-button facebook-button">
                    <i class="fa-brands fa-facebook"></i>
                    <p>27k</p>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                <a href="#" class="social-button twitter-button">
                    <i class="fa-brands fa-twitter"></i>
                    <p>98k</p>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                <a href="#" class="social-button google-button">
                    <i class="fa-brands fa-google-plus"></i>
                    <p>17k</p>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                <a href="#" class="social-button youtube-button">
                    <i class="fa-brands fa-youtube"></i>
                    <p>22k</p>
                </a>
            </div>
        </div>
    </div> -->

    <div class="widget">
        <div class="banner-spot clearfix">
            <div class="banner-img">
                <!-- <img src="upload/banner_03.jpg" alt="" class="img-fluid"> -->
                Propaganda
            </div><!-- end banner-img -->
        </div><!-- end banner -->
    </div><!-- end widget -->
</div><!-- end sidebar -->
