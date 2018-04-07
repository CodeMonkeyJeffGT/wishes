$(function () {
    $.ajax({  
        type : "get",
        url : " http://wish.jblog.info/v1/wish/list",  
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
               var acceptedItems = [];
               var unacceptedItems = [];
               for(var i = 0; i<data.data.accepted.length; i++){
                   acceptedItems[i] = '<li index='+data.data.accepted[i].id+'><div class="container"><div class="time"><div class="publish">'+data.data.accepted[i].time+'</div><div class="get">'+data.data.accepted[i].deadline+'</div></div><div class="content">'+data.data.accepted[i].content+'</div></div></li>'
               }
               for(var i = 0; i<data.data.unaccepted.length; i++){
                    unacceptedItems[i] = '<li index='+data.data.unaccepted[i].id+'><div class="container"><div class="time"><div class="publish">'+data.data.unaccepted[i].time+'</div><div class="get">'+data.data.unaccepted[i].deadline+'</div></div><div class="content">'+data.data.unaccepted[i].content+'</div></div></li>'
                }   
               $('.accepted').append(acceptedItems);
               $('.unaccepted').append(unacceptedItems)
           }
        },  
        error:function(){  
            alert('fail');  
        }  
    });

    $('ul').on('click', 'li', function () {
        localStorage.setItem('heartId',$(this).attr('index'));
        window.location.href = 'refuse.html'
    })
    $('#add').on('click', function () {
        window.location.href = 'new.html'
    })
})