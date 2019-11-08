<!DOCTYPE html>
<!-- saved from url=(0026)https://www.lqxs.xyz/login -->
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env("APP_NAME") }}</title>
    <link href="/css/user/login.css" rel="stylesheet">
    <script src="/assets/js/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="/assets/css/sweetalert2.min.css">
    <script src="/assets/js/jquery.min.js"></script>
    <link rel="stylesheet" type='text/css' href="/assets/css/bootstrap.css?v=2019">
    <script src="/assets/vendor/layer-v3.1.1/layer.js"></script>
    <script src="/assets/js/help.js"></script>
</head>
<body>
<div class="wrapper">
    <div class="container">
        <h1>{{ env("APP_NAME") }}-管理员总后台</h1>
        <form  method="post">
            <input type="text" id="phone"  placeholder="联系电话" maxlength="11">
            <input type="password" id="pwd" placeholder="用户密码" maxlength="50">
            {{--<input type="text" id="captcha" maxlength="10"  placeholder="验证码" autocomplete="off">--}}
            {{--<img src="{{captcha_src()}}" onclick="this.src='/captcha/default?'+Math.random()" alt="验证码" id="img">--}}
            <input type="text" name="google_code" id="google_code" value="" placeholder="谷歌验证码，没有请忽略">
            <div>
              <input type="button" value="登录" id="btn">
            </div>
        </form>
    </div>
</div>
<script>
    $('#btn').click(function(){
        var phone = $('#phone').val();
        var pwd = $('#pwd').val();
//        var captcha = $('#captcha').val();
        var google_code = $('#google_code').val();

        if(phone.length==0){
            swal(
                '请输入手机号'
            );
            return;
        }

        if(pwd.length==0){
            swal(
                '请输入密码'
            );
            return;
        }

        var loadding = layerLoading()
        $.ajax({
            type: 'post',
            url:"{{ route('adminDoLogin') }}",
            data:{'phone': phone,'pwd':pwd,'google_code':google_code,'_token':'{{csrf_token()}}'},
            dataType:'json',
            async:true,
            success:function(result){
                var code = result.code;
                var msg  = result.msg
                if (code == 200) {
                    // 操作成功.
                    window.location.href=result.redirect
                } else {
                    layer.close(loadding);
                    // 操作失败.
                    $('#img').click();
                    swal(msg);

                }
            },
        });

    });


    $('input').keyup(function(event){
        var ent = event || window.event;
        if(ent.keyCode == 13){
            $('#btn').trigger('click')
        }
    })

</script>
</body>
</html>