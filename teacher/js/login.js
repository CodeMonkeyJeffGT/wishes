$(function () {
    var rememberBtn = false;
    $('.check').on('click', function () {
        if(!rememberBtn){
            $(this).attr('src','img/svg/checked.svg')
            rememberBtn = true;
        }else{
            $(this).attr('src','img/svg/circle.svg')
            rememberBtn = false;
        }
        
    })

    $('#publish').on('click', function () {
        console.log('test')
        if($('.username input').val()=='' || $('.password input').val()==''){
            alert('请输入用户名或密码')
        }else{
            $.ajax({  
                type : "post",
                url : " http://wish.jblog.info/v1/user/login",  
                headers: {
                    Accept: "application/json; charset=utf-8"
                },
                xhrFields: {
                    withCredentials: true
                },
                crossDomain: true,
                data: {
                    account: $('.username input').val(),
                    password: $('.password input').val()
                },
                success : function(data){
                    if(data.code == '1'){
                        alert(data.message)
                    }else{
                        window.location.href = 'index.html';
                    }
                },  
                error:function(){  
                    alert('fail');  
                }  
            });
        }
        
    })
   
})