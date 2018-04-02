$(function () {
    $.ajax({  
        type : "get",
        url : " http://wish.jblog.info/v1/wish/pubPage",  
        headers: {
            Accept: "application/json; charset=utf-8"
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
                $('.man').val(data.data.guy);
                $('.phone').val(data.data.phone);
                $('input[type="date"]').val(data.data.deadline_d);
                $('input[type="time"]').val(data.data.deadline_t);
            }
        },  
        error:function(){  
            alert('fail');  
        }  
    });


    var imgUrl = '';
    $('.uploadPic').on('change', function () {
        var options = {    
            url: "http://wish.jblog.info/v1/img/upload",    
            type: "post",  
            headers: {
                Accept: "application/json; charset=utf-8"
            },
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true,
            dataType: "json",  
            success: function(data, status, xhr) {
                console.log(data); 
                if(data.code == '2'){
                    window.location.href = 'login.html'
                }else if(data.code == '1'){
                    alert(data.message)
                }else{
                    imgUrl = data.data;
                    alert('图片上传成功');
                }   
            }  
        };  
      
        $("#jvForm").ajaxSubmit(options);  
    })
    
    $('#publish').on('click', function () {
        var deadline = '' + $('input[type="date"]').val() + ' '+ $('input[type="time"]').val();
        $.ajax({  
            type : "post",
            url : " http://wish.jblog.info/v1/wish/pub",  
            headers: {
                Accept: "application/json; charset=utf-8"
            },
            data:{
                "content": $('#content textarea').val(),
                "img": imgUrl,
                "guy": $('.man').val(),
                "phone": $('.phone').val(),
                "deadline": deadline
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
                    console.log(data);
                    alert('发布成功')
                    window.location.href = 'index.html'
                }
            },  
            error:function(){  
                alert('fail');  
            }  
        });
    })
})