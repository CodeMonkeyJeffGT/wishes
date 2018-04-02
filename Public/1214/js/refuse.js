$(function () {
    var flag = 0;
    $.ajax({  
        type : "get",
        url : " http://wish.jblog.info/v1/wish/info",  
        headers: {
            Accept: "application/json; charset=utf-8"
        },
        data:{
            id:localStorage.getItem('heartId')
        },
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true,
        success : function(data){
            console.log(data);
            if(data.code == '2'){
                window.location.href = 'login.html'
            }else if(data.code == '1'){
                alert(data.message)
            }else{
                if(data.data.angel){
                    flag = 1;
                    $('title').html('取消心愿');
                    var text = '<div class="text">'+data.data.content+'</div>'
                    if(data.data.img != ''){
                        var photo = '<div class="photo">查看图片</div>'
                        $('#content').append(photo);
                        var img1 = '<img src="'+data.data.img+'" alt="">'
                        $('#dialog').append(img1);
                    }else{
                        // var photo = '<div class="photo">查看图片</div>'
                        // $('#content').append(photo);
                        
                    }
                    $('#content').append(text);
                    var man = '<li><span>联系人</span><div>'+data.data.guy+'</div></li>'
                    $('#phone').append(man);
                    var phone = '<li><span>联系方式</span><div>'+data.data.phone+'</div></li>'
                    $('#phone').append(phone);
                    var deadline = '<li><span>截止时间</span><span>'+data.data.deadline+'</span></li>'
                    $('#time').append(deadline);
                    var relationman = '<li><span>认领人</span><div>'+data.data.angel.guy+'</div></li>'
                    $('#relation').append(relationman);
                    var relationphone = '<li><span>联系方式</span><div>'+data.data.angel.phone+'</div></li>'
                    $('#relation').append(relationphone);
                    if(data.data.angel.done == '1'){
                        $('#publish').css({'display': 'none'});
                    }
                    $('#publish').html('完成');
                }else{
                    flag = 0;
                    $('title').html('取消心愿');
                    var text = '<div class="text">'+data.data.content+'</div>'
                    if(data.data.img != ''){
                        var photo = '<div class="photo">查看图片</div>'
                        $('#content').append(photo);
                        var img1 = '<img src="'+data.data.img+'" alt="">'
                        $('#dialog').append(img1);
                    }else{
                        // var photo = '<div class="photo">查看图片</div>'
                        // $('#content').append(photo);
                        
                    }
                    $('#content').append(text);
                    var man = '<li><span>联系人</span><div>'+data.data.guy+'</div></li>'
                    $('#phone').append(man);
                    var phone = '<li><span>联系方式</span><div>'+data.data.phone+'</div></li>'
                    $('#phone').append(phone);
                    var deadline = '<li><span>截止时间</span><span>'+data.data.deadline+'</span></li>'
                    $('#time').append(deadline);
                    $('#publish').html('取消');
                    var textarea = '<textarea name="" id="" placeholder="请输入原因"></textarea>';
                    $('.reason').append(textarea);
                }
            }
        },  
        error:function(){  
            alert('fail');  
        }  
    });
    $('#content').on('click','.photo', function() {
        $('#dialog').css({'display': 'block'})
    })
    $('#dialog').on('click', 'img', function () {
        $('#dialog').css({'display': 'none'})
    })
    $('#publish').on('click', function () {
        if(flag == 0){
            if($('textarea').val() == ''){
                alert('请填写原因')
            }else{
                $.ajax({  
                    type : "post",
                    url : " http://wish.jblog.info/v1/wish/cancel",  
                    headers: {
                        Accept: "application/json; charset=utf-8"
                    },
                    data:{
                        id:localStorage.getItem('heartId'),
                        reason: $('textarea').val()
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    crossDomain: true,
                    success : function(data){
                        if(data.code == '2'){
                            window.location.href = 'login.html'
                        }else if(data.code == '1'){
                            alert(data.message)
                        }else{
                            alert('取消成功');
                            window.location.href = 'index.html';
                        }
                    },  
                    error:function(){  
                        alert('fail');  
                    }  
                });
            }
            
        }else if(flag == 1){
            window.location.href = 'index.html';
        }
    })
})