<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=$args['header']['title']?></title>
    <meta name = "description" content = "<?=$args['header']['description']?>">

    <link rel = "canonical" href = "<?=$args['header']['canonical']?>" />
    <meta name="keywords" content="<?=$args['header']['keywords']?>" />
    <meta name="author" content="<?=$args['header']['author']?>" />


    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="/assets/lib/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/lib/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

    <script src="/assets/lib/js/jquery/jquery-3.6.4.min.js"></script>
    <script src="/assets/lib/js/tether.min.js"></script>
    <script src="/assets/lib/js/bootstrap/bootstrap.min.js"></script>

    <link rel="stylesheet" href="/assets/css/ownFramework.css">

        <!-- Custom styles for this template -->
     <link href="/assets/css/style.css" rel="stylesheet">

    <!-- Responsive styles for this template -->
    <link href="/assets/css/responsive.css" rel="stylesheet">

    <!-- Colors for this template -->
    <link href="/assets/css/colors.css" rel="stylesheet">

    <!-- Version Tech CSS for this template -->
    <link href="/assets/css/version/tech.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/custom.css">

    <!-- editor -->
    <link rel="stylesheet" href="/assets/dist/ckeditor/sample/styles.css">
    <script src="/assets/dist/ckeditor/build/ckeditor.js"></script>
    <!-- editor -->

    <style>
        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused){
            border: 0 !important;
        }
    </style>
    <script src="/assets/lib/js/axios.js"></script>
    <script src="/assets/js/header.js"></script>
    <script src="/assets/js/custom.js"></script>



</head>
<body>
<div id="wrapper">
    <?php
    ?>

<header class="tech-header header">
    <?php if(isset($_SESSION['login']) == true){ ?>
        <script src="/assets/js/online.js"></script>
    <?php } ?>
    <div class="container-fluid">
        <nav class="navbar navbar-toggleable-lg navbar-inverse fixed-top bg-inverse">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/"><img src="/assets/img/logo/tech-logo.png" alt=""></a>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item dropdown has-submenu menu-large hidden-md-down hidden-sm-down hidden-xs-down">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">News</a>
                        <ul class="dropdown-menu megamenu" aria-labelledby="dropdown01">
                            <li>
                                <div class="container">
                                    <div class="mega-menu-content clearfix">
                                        <div class="tab">
                                            <button class="tablinks active" onclick="openCategory(event, 'cat01')">Ciência</button>
                                            <button class="tablinks" onclick="openCategory(event, 'cat02')">Tecnologia</button>
                                            <button class="tablinks" onclick="openCategory(event, 'cat03')">Media Social</button>
                                            <button class="tablinks" onclick="openCategory(event, 'cat04')">Mundial</button>
                                        </div>

                                        <div class="tab-details clearfix">
                                            <div id="cat01" class="tabcontent active">
                                                <div class="row">
                                                    <?php
                                                        if($args['science']){
                                                        foreach ($args['science'] as $key => $value) {
                                                            $categoryScience = $value['category'];
                                                            $date_urlScience = $value['date_url'];
                                                            $slugScience = $value['slug'];
                                                            $titleScience = $value['title'];
                                                            $banner = $value['banner'];

                                                            $url = "/noticia/".$categoryScience."/".$date_urlScience."/".$slugScience;

                                                            if(strlen($titleScience) > 44) {
                                                                $titleScience = substr($titleScience, 0, 44)."...";
                                                            }
                                                    ?>
                                                        <div class='col-lg-3 col-md-6 col-sm-12 col-xs-12'>
                                                            <div class='blog-box'>
                                                                <div class='post-media'>
                                                                    <a href='<?=$url?>' title=''>
                                                                        <img src='<?=$banner?>' class='img-fluid'>
                                                                        <div class='hovereffect'>
                                                                        </div><!-- end hover -->
                                                                        <span class='menucat'><?=ucfirst($categoryScience)?></span>
                                                                    </a>
                                                                </div><!-- end media -->
                                                                <div class='blog-meta'>
                                                                    <h4><a href='<?=$url?>' title=''><?=$titleScience?></a></h4>
                                                                </div><!-- end meta -->
                                                            </div><!-- end blog-box -->
                                                        </div>
                                                    <?php }} ?>
                                                </div><!-- end row -->
                                            </div>
                                            <div id="cat02" class="tabcontent">
                                                <div class="row">

                                                    <?php
                                                        if($args['tecnology']){

                                                        foreach ($args['tecnology'] as $key => $value) {
                                                            $categoryTecnology = $value['category'];
                                                            $date_urlTecnology = $value['date_url'];
                                                            $slugTecnology = $value['slug'];
                                                            $titleTecnology = $value['title'];
                                                            $bannerTecnology = $value['banner'];

                                                            $url = "/noticia/".$categoryTecnology."/".$date_urlTecnology."/".$slugTecnology;

                                                            if(strlen($titleTecnology) > 44) {
                                                                $titleTecnology = substr($titleTecnology, 0, 44)."...";
                                                            }
                                                    ?>
                                                        <div class='col-lg-3 col-md-6 col-sm-12 col-xs-12'>
                                                            <div class='blog-box'>
                                                                <div class='post-media'>
                                                                    <a href='<?=$url?>' title=''>
                                                                        <img src='<?=$bannerTecnology?>' class='img-fluid'>
                                                                        <div class='hovereffect'>
                                                                        </div><!-- end hover -->
                                                                        <span class='menucat'><?=ucfirst($categoryTecnology)?></span>
                                                                    </a>
                                                                </div><!-- end media -->
                                                                <div class='blog-meta'>
                                                                    <h4><a href='<?=$url?>' title=''><?=$titleTecnology?></a></h4>
                                                                </div><!-- end meta -->
                                                            </div><!-- end blog-box -->
                                                        </div>
                                                    <?php } }?>

                                                </div><!-- end row -->
                                            </div>
                                            <div id="cat03" class="tabcontent">
                                                <div class="row">
                                                <?php
                                                        if($args['social_media']){

                                                        foreach ($args['social_media'] as $key => $value) {
                                                            $categorySocialMedia = $value['category'];
                                                            $date_urlSocialMedia = $value['date_url'];
                                                            $slugSocialMedia = $value['slug'];
                                                            $titleSocialMedia = $value['title'];
                                                            $bannerSocialMedia = $value['banner'];

                                                            $url = "/noticia/".$categorySocialMedia."/".$date_urlSocialMedia."/".$slugSocialMedia;

                                                            if(strlen($titleSocialMedia) > 44) {
                                                                $titleSocialMedia = substr($titleSocialMedia, 0, 44)."...";
                                                            }
                                                    ?>
                                                        <div class='col-lg-3 col-md-6 col-sm-12 col-xs-12'>
                                                            <div class='blog-box'>
                                                                <div class='post-media'>
                                                                    <a href='<?=$url?>' title=''>
                                                                        <img src='<?=$bannerSocialMedia?>' class='img-fluid'>
                                                                        <div class='hovereffect'>
                                                                        </div><!-- end hover -->
                                                                        <span class='menucat'><?=ucfirst($categorySocialMedia)?></span>
                                                                    </a>
                                                                </div><!-- end media -->
                                                                <div class='blog-meta'>
                                                                    <h4><a href='<?=$url?>' title=''><?=$titleSocialMedia?></a></h4>
                                                                </div><!-- end meta -->
                                                            </div><!-- end blog-box -->
                                                        </div>
                                                    <?php } }?>
                                                </div><!-- end row -->
                                            </div>
                                            <!--desuso-->
                                            <div id="cat04" class="tabcontent">
                                                <div class="row">
                                                    <?php
                                                        if($args['worldwide']){
                                                        foreach ($args['worldwide'] as $key => $value) {
                                                            $categoryWorldwide = $value['category'];
                                                            $date_urlWorldwide = $value['date_url'];
                                                            $slugWorldwide = $value['slug'];
                                                            $titleWorldwide = $value['title'];
                                                            $bannerWorldwide = $value['banner'];

                                                            $url = "/noticia/".$categoryWorldwide."/".$date_urlWorldwide."/".$slugWorldwide;

                                                            if(strlen($titleWorldwide) > 44) {
                                                                $titleWorldwide = substr($titleWorldwide, 0, 44)."...";
                                                            }
                                                    ?>
                                                        <div class='col-lg-3 col-md-6 col-sm-12 col-xs-12'>
                                                            <div class='blog-box'>
                                                                <div class='post-media'>
                                                                    <a href='<?=$url?>' title=''>
                                                                        <img src='<?=$bannerWorldwide?>' class='img-fluid'>
                                                                        <div class='hovereffect'>
                                                                        </div><!-- end hover -->
                                                                        <span class='menucat'><?=ucfirst($categoryWorldwide)?></span>
                                                                    </a>
                                                                </div><!-- end media -->
                                                                <div class='blog-meta'>
                                                                    <h4><a href='<?=$url?>' title=''><?=$titleWorldwide?></a></h4>
                                                                </div><!-- end meta -->
                                                            </div><!-- end blog-box -->
                                                        </div>
                                                    <?php } }?>
                                                </div><!-- end row -->
                                            </div>
                                            <div id="cat05" class="tabcontent">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="blog-box">
                                                            <div class="post-media">
                                                                <a href="tech-single.html" title="">
                                                                    <img src="/assets/uploads/image/tech.jpg" alt="" class="img-fluid">
                                                                    <div class="hovereffect">
                                                                    </div><!-- end hover -->
                                                                    <span class="menucat">Worldwide</span>
                                                                </a>
                                                            </div>
                                                            <div class="blog-meta">
                                                                <h4><a href="tech-single.html" title="">Grilled vegetable with fish prepared with fish</a></h4>
                                                            </div>
                                                        </div><!-- end blog-box -->
                                                    </div>

                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="blog-box">
                                                            <div class="post-media">
                                                                <a href="tech-single.html" title="">
                                                                    <img src="/assets/uploads/image/tech.jpg" alt="" class="img-fluid">
                                                                    <div class="hovereffect">
                                                                    </div><!-- end hover -->
                                                                    <span class="menucat">Worldwide</span>
                                                                </a>
                                                            </div>
                                                            <div class="blog-meta">
                                                                <h4><a href="tech-single.html" title="">The world's finest and clean meat restaurants</a></h4>
                                                            </div>
                                                        </div><!-- end blog-box -->
                                                    </div>

                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="blog-box">
                                                            <div class="post-media">
                                                                <a href="tech-single.html" title="">
                                                                    <img src="/assets/uploads/image/tech.jpg" alt="" class="img-fluid">
                                                                    <div class="hovereffect">
                                                                    </div><!-- end hover -->
                                                                    <span class="menucat">Worldwide</span>
                                                                </a>
                                                            </div>
                                                            <div class="blog-meta">
                                                                <h4><a href="tech-single.html" title="">Fried veal and vegetable dish</a></h4>
                                                            </div>
                                                        </div><!-- end blog-box -->
                                                    </div>

                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="blog-box">
                                                            <div class="post-media">
                                                                <a href="tech-single.html" title="">
                                                                    <img src="/assets/uploads/image/tech.jpg" alt="" class="img-fluid">
                                                                    <div class="hovereffect">
                                                                    </div><!-- end hover -->
                                                                    <span class="menucat">Worldwide</span>
                                                                </a>
                                                            </div>
                                                            <div class="blog-meta">
                                                                <h4><a href="tech-single.html" title="">Tasty pasta sauces and recipes</a></h4>
                                                            </div>
                                                        </div><!-- end blog-box -->
                                                    </div>
                                                </div><!-- end row -->
                                            </div>
                                            <!--desuso-->

                                        </div><!-- end tab-details -->
                                    </div><!-- end mega-menu-content -->
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/category/videos">Videos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/category/portfolio">Portfólio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/category/qualificacoes">Qualificações</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/category/reviews">Reviews</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="/contact">Contate me</a>
                    </li> -->
                </ul>
                <ul class="navbar-nav mr-2">
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.instagram.com/samuh.matos/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.linkedin.com/in/o-samuelmatos/" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mailto:samuhmatos@gmail.com"><i class="fa-regular fa-envelope" target="_blank"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://github.com/samuhmatos" target="_blank"><i class="fa-brands fa-github"></i></a>
                    </li>
                </ul>
                <?php if(isset($_SESSION['permition_level']) && $_SESSION['permition_level'] > 1){ ?>
                    <ul class="navbar-nav mr-r">
                        <li class="nav-item">
                            <a href="/dashboard" class="nav-link">Painel de controle</a>
                        </li>
                    </ul>
                <?php } ?>
                <?php
                    if(isset($_SESSION['login']) === true) {
                ?>
                     <ul class="navbar-nav mr2">
                        <li class="nav-item">
                            <button type="button" onclick="signOut()" id="btn-signOut" class="btn nav-link">Desconetar</button>
                        </li>
                    </ul>
                <?php }else{ ?>
                    <ul class="navbar-nav mr2">
                        <li class="nav-item">
                            <a href="/login/signIn" class="nav-link">Entrar</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="/login/signUp" class="nav-link">Cadastrar</a>
                        </li> -->
                    </ul>

                <?php } ?>



            </div>
        </nav>
    </div><!-- end container-fluid -->

</header><!-- end market-header -->
