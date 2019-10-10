<?php /*a:2:{s:62:"/var/www/fistWeb/tpblog/application/blog/view/index/index.html";i:1570459329;s:64:"/var/www/fistWeb/tpblog/application/blog/view/public/father.html";i:1570453428;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title><?php echo htmlentities((isset($Title) && ($Title !== '')?$Title:"默认标题")); ?></title>

    <link rel="stylesheet" type="text/css" href="/static/bootstrap/css/bootstrap.css" />
    <script type="text/javascript" src="/static/bootstrap/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="/static/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="/static/sweetalert/docs/assets/sweetalert/sweetalert.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/static/simditor/site/assets/styles/simditor.css" />

    <script type="text/javascript" src="/static/simditor/site/assets/scripts/module.js"></script>
    <script type="text/javascript" src="/static/simditor/site/assets/scripts/hotkeys.js"></script>
    <script type="text/javascript" src="/static/simditor/site/assets/scripts/uploader.js"></script>
    <script type="text/javascript" src="/static/simditor/site/assets/scripts/simditor.js"></script>

	<script type="text/javascript" src="/static/snow/snowfall.jquery.js"></script>


    <style>
        #ttop {
            opacity:0.5;
            display: none; /* 默认隐藏 */
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            /*background-color: #ffbde6; !* 设置背景颜色，你可以设置自己想要的颜色或图片 *!*/
            /*color: white; !* 文本颜色 *!*/
            cursor: pointer;
            padding: 15px;
            /*border-radius: 10px; !* 圆角 *!*/
        }
        pre {
            background: #a3b2f8;
        }
		body {
				background-image:url("/bg.jpg");
				background-attachment:fixed;
				background-repeat:no-repeat;
				background-position:center;
				background-size: cover;
		}
    </style>
    <style>
        .snowfall-flakes{animation:sakura 1s linear 0s infinite;}
        @keyframes sakura{
            0% {transform:rotate3d(0, 0, 0, 0deg);}
            25%{transform:rotate3d(1, 1, 0, 60deg);}
            50%{transform:rotate3d(1, 1, 0, 0deg);}
            75%{transform:rotate3d(1, 0, 0, 60deg);}
            100% {transform:rotate3d(1, 0, 0, 0deg);}
        }
    </style>
</head>
<body style="opacity:0.9;">
<div class="container-fluid" >
    <nav class="navbar navbar-inverse ">
        <div class="container-fluid"  >
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                    <input type="hidden" value="<?php echo htmlentities((app('session')->get('user_auth.uid') ?: 0)); ?>" id = "userId" >
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<a class="navbar-brand active" href="<?php echo url('blog/index/index'); ?>"><?php echo htmlentities((isset($SiteName) && ($SiteName !== '')?$SiteName:"Home")); ?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse nav-pills navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav  navbar-nav ">
                    <li id="user1" ><a href="<?php echo url('blog/blog/index'); ?>">社交 <span class="sr-only">(current)</span></a></li>
                    <li id="user2" ><a href="<?php echo url('blog/index/myBlog'); ?>">我的博文</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">社区 <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="https://learnku.com/thinkphp" target="_blank">ThinkPHP</a></li>
                            <li><a href="https://learnku.com/php" target="_blank">PHP</a></li>
                            <li><a href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
                <form  id='search' class="navbar-form navbar-left" method="get" action="<?php echo url('blog/blog/blogSearch'); ?>" >
                    <div  class="form-group"  >
                        <input required id='search1' name="search" type="text" style="width: 110px" class="form-control" placeholder="Search">
                    </div>
                    <button id='search0' type="submit" class="btn btn-default">Submit</button>
                </form>
                <?php if(app('session')->get('user_auth')): ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a>你好</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <img src="<?php echo htmlentities(app('session')->get('user_auth.userImg')); ?>" width="20">
                            <?php echo htmlentities((app('session')->get('user_auth.nickname') ?: "游客")); ?>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu" id="user">
                            <li><a href="<?php echo url('blog/user/myTweet',['uid'=>app('session')->get('user_auth.uid')]); ?>"><span class="glyphicon glyphicon-user"> </span>个人中心</a></li>
                            <li><a href="<?php echo url('blog/user/userData'); ?>"><span class="glyphicon glyphicon-cog"></span>编辑资料</a></li>
                            <li><a href="<?php echo url('blog/blog/blog'); ?>"><span class="glyphicon glyphicon-plus"></span>新建博客</a></li>
                            <li role="separator" class="divider"></li>
							<li><a href="<?php echo url('blog/user/loginOut'); ?>"><span class="glyphicon glyphicon-log-in"></span>退出登录</a></li>
                        </ul>
                    </li>
                </ul>
                <?php else: ?>
                <div class=" text-right" style="padding-top: 10px">
                    <a class="btn btn-default" href="<?php echo url('blog/user/login'); ?>">登录</a>
                    <a class="btn btn-default" href="<?php echo url('blog/user/regist'); ?>">注册</a>
                </div>
                <?php endif; ?>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
<div class="row" style="display: none" id="123">
    <div class="col-md-6 col-md-offset-3">
        <div class="alert alert-danger"  role="alert">
            <!--            <button type="button" class="close" data-dismiss="alert" aria-label="Close">-->
            <!--                <span aria-hidden="true">&times;</span>-->
            <!--            </button>-->
            <strong id="message">Warning!</strong>
        </div>
    </div>
</div>





<div class="container" style="padding-top: 2% ;margin-bottom: 100px;">
    <div class="row">
        <div class="col-md-3 col-md-push-9" >
            <div class="panel panel-info">
                <div class="panel-heading ">
                    社区动态
                </div>
                <ul class="nav nav-tabs">
                    <li role="presentation" class="active"><a href="#">公告</a></li>
                    <li role="presentation"><a href="#">热门</a></li>
                    <li role="presentation"><a href="#">Profile</a></li>
                </ul>
                <div class="panel-body" >
						<p style="font-weight:bold;" >
							<img src="https://gss0.baidu.com/-vo3dSag_xI4khGko9WTAnF6hhy/zhidao/pic/item/2cf5e0fe9925bc3171fa59615edf8db1ca1370a7.jpg" style="width:100px">
							李厚宾，众所周知，先礼后兵。<br>
							李厚宾是个傻，穿个蓝裤衩，没人和他耍！
						</p>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-md-pull-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>最近发表文章</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group" >
                            <ul class="list-group">
                                <?php if(is_array($blogList) || $blogList instanceof \think\Collection || $blogList instanceof \think\Paginator): $i = 0; $__LIST__ = $blogList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$blog): $mod = ($i % 2 );++$i;?>
                                <a href="<?php echo url('blog/index/blogRead',['blogId'=>$blog['id']]); ?>" class="list-group-item">
                                   <span><?php echo htmlentities($blog['title']); ?></span>
<!--                                    <span class="glyphicon glyphicon-heart" style=" "></span>-->
                                </a>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                    </div>
                    <div class="text-center"><?php echo $blogList; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>





<div style=" padding-left: 2%;padding-right: 2% ;bottom: 0;width: 100%; overflow:visible;position: relative" >
    <div class="row text-center">
        <p>
            免费？不存在的！别人总要从你那里拿走点什么，或者是名声或者是金钱。 ——原创<br>

            关于作者  875147715@qq.com
        </p>
    </div>
</div>
<div id="ttop"><button class="btn btn-default btn-lg " style="background: #ffbde6"><span class=" glyphicon glyphicon-chevron-up "></span></button> </div>



<script>
    if($('#userId').attr('value') == 0){
        $('#user1').hide();
        $('#user2').hide();
    }else {
        $('#user1').show();
        $('#user2').show();
    }
    $(document).ready(function(){
        $(window).scroll(function() {
            if ($(window).scrollTop() > 30)
                $('#ttop').show();
            else
                $('#ttop').hide();
        });
        $('#ttop').click(function() {
            $('html, body').animate({scrollTop: 0}, 1000,"swing");
            // topFunction();
        });
    });
    $(function () {
        $('#search1').focus(function () {
            $('#search1').animate({width:'250px'})
        });
        $('#search1').blur(function () {
            $('#search1').animate({width:'110px'})
        });
    });
    // 当网页向下滑动 20px 出现"返回顶部" 按钮
    // window.onscroll = function() {scrollFunction()};
    //
    // function scrollFunction() {console.log(121);
    //     if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    //         document.getElementById("ttop").style.display = "block";
    //     } else {
    //         document.getElementById("ttop").style.display = "none";
    //     }
    // }
    // // 点击按钮，返回顶部
    // function topFunction() {
    //     document.body.scrollTop = 0;
    //     document.documentElement.scrollTop = 0;
    // }
</script>

<script>
    $(function () {
        $(document).snowfall({image:"/img/1.png", flakeCount:10, minSpeed:1, minSize:8, maxSize:15,});
        $(document).snowfall({image:"/img/2.png", flakeCount:10, minSpeed:1, minSize:8, maxSize:15,});
        $(document).snowfall({image:"/img/3.png", flakeCount:10, minSpeed:1, minSize:8, maxSize:15,});
        $(document).snowfall({image:"/img/4.png", flakeCount:10, minSpeed:1, minSize:8, maxSize:15,});
    })
</script>

</body>
</html>
