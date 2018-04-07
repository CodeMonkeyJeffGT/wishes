$(function () {
    $.ajax({  
        type : "post",
        url : " http://wish.jblog.info/v1/user/info",  
        headers: {
            Accept: "application/json; charset=utf-8"
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true,
        success : function(data){
            console.log(data);
            if(data.code == 2){
                window.location.href = 'http://nefuer.jblog.info?ope=http%3A%2F%2Fwish.jblog.info%2Fv1%2Fwish%2FnefuerPage'
            }else{
                var userInfo = '<li><span class="title">姓名</span><span class="value">'+data.data.name+'</span></li><li><span class="title">学号</span><span class="value">'+data.data.acc+'</span></li><li><span class="title">志愿总时长</span><span class="value">'+data.data.time+'</span></li>';
                $('#info').append(userInfo);
            }
        },  
        error:function(){  
            alert('fail');  
        }  
    });


    $('#footer').on('click', 'div', function () {
        window.location.href = this.className + '.html'
    })
})