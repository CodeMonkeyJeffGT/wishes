$(function () {
    var flag = 0;
    var evaluateValue = 'A'
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
            console.log(data.data)
            if(data.code == '2'){
                window.location.href = 'login.html'
            }else if(data.code == '1'){
                alert(data.message)
            }else{
                if(data.data.angel){
                    flag = 1;
                    $('title').html('完成心愿');
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
                    var man = '<li class="man"><span>联系人</span><div>'+data.data.guy+'</div></li>'
                    $('#phone').append(man);
                    var phone = '<li class="phone"><span>联系方式</span><div>'+data.data.phone+'</div></li>'
                    $('#phone').append(phone);
                    // var deadline = '<li><span>截止时间</span><span>'+data.data.deadline+'</span></li>'
                    // $('#time').append(deadline);
                    var relationman = '<li><span>认领人</span><div>'+data.data.angel.guy+'</div></li>'
                    $('#relation').append(relationman);
                    var relationphone = '<li><span>联系方式</span><div>'+data.data.angel.phone+'</div></li>'
                    $('#relation').append(relationphone);
                    if(data.data.angel.done == '1'){
                        $('#publish').css({'display': 'none'});
                    }else{
                        var quantum = '<li><span>志愿时长</span><div><input type="text" id="time-hour"><span>小时</span><input type="text" id="time-minute"><span>分钟</span></div></li>'
                        $('#quantum').append(quantum);
                        var evaluateNode = '<div class="evaluate"><span>评价</span><ul><li class="best-select"></li><li class="good"></li><li class="middle"></li><li class="bad"></li></ul></div>' 
                        $('#evaluate').append(evaluateNode);
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
    $('#evaluate').on('click', 'li', function () {
      if(this.className.indexOf('select') > 0){
        this.className = this.className.split('-')[0]
      }else{
        if(this.className == 'best'){
            evaluateValue = 'A'
        }else if(this.className == 'good'){
            evaluateValue = 'B'
        }else if(this.className == 'middle'){
            evaluateValue = 'C'
        }else{
            evaluateValue = 'D'
        }
        console.log(evaluateValue)
        this.className = this.className + '-select'
        for(var i in $(this).siblings()){
            $(this).siblings()[i].className =  $(this).siblings()[i].className.split('-')[0]
        }
      }
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
            if(!$('#time-hour')[0].value && !$('#time-minute')[0].value){
                alert('请填写时间')
            }else{
                console.log($('#time-hour')[0].value)
                $.ajax({  
                    type : "post",
                    url : " http://wish.jblog.info/v1/wish/confirm",  
                    headers: {
                        Accept: "application/json; charset=utf-8"
                    },
                    data:{
                        id:localStorage.getItem('heartId'),
                        time: $('#time-hour')[0].value * 60 + $('#time-minute')[0].value,
                        judge: evaluateValue,
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    crossDomain: true,
                    success : function(data){
                        console.log(data)
                        if(data.code == '2'){
                            window.location.href = 'login.html'
                        }else if(data.code == '1'){
                            alert(data.message)
                        }else{
                            alert('确认成功');
                            window.location.href = 'index.html';
                        }
                    },  
                    error:function(){  
                        alert('fail');  
                    }  
                });
            }
        }
    })
})