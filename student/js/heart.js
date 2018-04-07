$(function () {
    
    $.ajax({  
        type : "post",
        url : " http://wish.jblog.info/v1/wish/listAll",  
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
                var unacceptedItems = [];
                for(var i = 0; i<data.data.unaccepted.length; i++){
                    unacceptedItems[i] = '<li index='+data.data.unaccepted[i].id+'><div class="container"><div class="time"><div class="publish">'+data.data.unaccepted[i].time+'</div><div class="get">'+data.data.unaccepted[i].deadline+'</div></div><div class="content">'+data.data.unaccepted[i].content+'</div></div></li>'
                }   
                $('.unaccepted').append(unacceptedItems)
            }
        },  
        error:function(){  
            alert('fail');  
        }  
    });

    $('ul').on('click', 'li', function () {
        localStorage.setItem('heartId',$(this).attr('index'));
        window.location.href = 'detail.html'
    })

    $('#footer').on('click', 'div', function () {
        window.location.href = this.className + '.html'
    })
})