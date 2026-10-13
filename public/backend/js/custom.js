// Due Remainder
$('body').on('click', '#dueSms', function () {
    var due_user_id = $(this).data('id');
    $.ajax({
        url:"students/"+due_user_id+"/duesms",
        
        success:function(data)
        {
            if(data.success)
            {
            var html = "";
            $('#flash_message').removeClass('d-none');
            html = '<div class="alert alert-success">' + data.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $('#flash_message').html(html);
            setTimeout(function(){
                $('#flash_message').addClass('d-none');
                }, 3000);
                
            }
        }
    });
});
// Today Class remainder
$('body').on('click', '#remainderSms', function () {
    var due_user_id = $(this).data('id');
    $.ajax({
        url:"students/"+due_user_id+"/remaindersms",
        
        success:function(data)
        {
            if(data.success)
            {
            var html = "";
            $('#flash_message').removeClass('d-none');
            html = '<div class="alert alert-success">' + data.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $('#flash_message').html(html);
            setTimeout(function(){
                $('#flash_message').addClass('d-none');
                }, 3000);
                
            }
        }
    });
});
// New Class Schedule
$('body').on('click', '#scheduleSms', function () {
    var schedule_user_id = $(this).data('id');
    $.ajax({
        url:"students/"+schedule_user_id+"/schedulesms",
        
        success:function(data)
        {
            if(data.success)
            {
            var html = "";
            $('#flash_message').removeClass('d-none');
            html = '<div class="alert alert-success">' + data.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $('#flash_message').html(html);
            setTimeout(function(){
                $('#flash_message').addClass('d-none');
                }, 3000);
                
            }
        }
    });
});

// Today Postpond
$('body').on('click', '#postpondSms', function () {
     var postpond_user_id = $(this).data('id');
    $.ajax({
        url:"students/"+postpond_user_id+"/todaypostpond",
       
        success:function(data)
        {
            if(data.success)
            {
            var html = "";
            $('#flash_message').removeClass('d-none');
            html = '<div class="alert alert-success">' + data.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $('#flash_message').html(html);
            setTimeout(function(){
                $('#flash_message').addClass('d-none');
                }, 3000);
                
            }
        }
    });
});
// Tomorrow Postpond
$('body').on('click', '#TomorrowpostpondSms', function () {
    var postpond_user_id = $(this).data('id');
   $.ajax({
       url:"students/"+postpond_user_id+"/tomorrowpostpond",
      
       success:function(data)
       {
           if(data.success)
           {
           var html = "";
           $('#flash_message').removeClass('d-none');
           html = '<div class="alert alert-success">' + data.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
           $('#flash_message').html(html);
           setTimeout(function(){
               $('#flash_message').addClass('d-none');
               }, 3000);
               
           }
       }
   });
});

// groupDuesms
$('body').on('click', '#groupDuesms', function () {
    var due_batch_id = $(this).data('id');
    $.ajax({
        url:"batchs/"+due_batch_id+"/groupduesms",
        
        success:function(data)
        {
            if(data.success)
            {
            var html = "";
            $('#flash_message').removeClass('d-none');
            html = '<div class="alert alert-success">' + data.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $('#flash_message').html(html);
            setTimeout(function(){
                $('#flash_message').addClass('d-none');
                }, 3000);
                
            }
        }
    });
});
//group today postpond
$('body').on('click', '#groupTodayPostpond', function () {
    var postpond_user_id = $(this).data('id');
    $.ajax({
        url:"batchs/"+postpond_user_id+"/grouptodaypostpond",
        
        success:function(data)
        {
            if(data.success)
            {
            var html = "";
            $('#flash_message').removeClass('d-none');
            html = '<div class="alert alert-success">' + data.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $('#flash_message').html(html);
            setTimeout(function(){
                $('#flash_message').addClass('d-none');
                }, 3000);
                
            }
        }
    });
});
//grouptomorrowpostpond
$('body').on('click', '#groupTomorrowPostpond', function () {
    var postpond_user_id = $(this).data('id');
    $.ajax({
        url:"batchs/"+postpond_user_id+"/grouptomorrowpostpond",
        
        success:function(data)
        {
            if(data.success)
            {
            var html = "";
            $('#flash_message').removeClass('d-none');
            html = '<div class="alert alert-success">' + data.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $('#flash_message').html(html);
            setTimeout(function(){
                $('#flash_message').addClass('d-none');
                }, 3000);
                
            }
        }
    });
});
// Today Class remainder
$('body').on('click', '#grouptodayremainder', function () {
    var due_user_id = $(this).data('id');
    $.ajax({
        url:"batchs/"+due_user_id+"/grouptodayremainder",
        
        success:function(data)
        {
            if(data.success)
            {
            var html = "";
            $('#flash_message').removeClass('d-none');
            html = '<div class="alert alert-success">' + data.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $('#flash_message').html(html);
            setTimeout(function(){
                $('#flash_message').addClass('d-none');
                }, 3000);
                
            }
        }
    });
});
// New Class Schedule
$('body').on('click', '#groupnewschedule', function () {
    var schedule_user_id = $(this).data('id');
    $.ajax({
        url:"batchs/"+schedule_user_id+"/groupnewschedule",
        
        success:function(data)
        {
            if(data.success)
            {
            var html = "";
            $('#flash_message').removeClass('d-none');
            html = '<div class="alert alert-success">' + data.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $('#flash_message').html(html);
            setTimeout(function(){
                $('#flash_message').addClass('d-none');
                }, 3000);
                
            }
        }
    });
});