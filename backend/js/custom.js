// Setup CSRF token for all jQuery AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function handleSmsResponse(data) {
    if (data.success) {
        var html = '<div class="alert alert-success">' + data.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $('#flash_message').removeClass('d-none').html(html);
        setTimeout(function () {
            $('#flash_message').addClass('d-none');
        }, 3000);
    }
}

function handleSmsError(xhr) {
    var errorMsg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Failed to send SMS request.';
    var html = '<div class="alert alert-danger">' + errorMsg + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    $('#flash_message').removeClass('d-none').html(html);
    setTimeout(function () {
        $('#flash_message').addClass('d-none');
    }, 4000);
}

// Due Remainder
$('body').on('click', '#dueSms', function () {
    var due_user_id = $(this).data('id');
    $.ajax({
        url: "students/" + due_user_id + "/duesms",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: handleSmsResponse,
        error: handleSmsError
    });
});

// Today Class remainder
$('body').on('click', '#remainderSms', function () {
    var due_user_id = $(this).data('id');
    $.ajax({
        url: "students/" + due_user_id + "/remaindersms",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: handleSmsResponse,
        error: handleSmsError
    });
});

// New Class Schedule
$('body').on('click', '#scheduleSms', function () {
    var schedule_user_id = $(this).data('id');
    $.ajax({
        url: "students/" + schedule_user_id + "/schedulesms",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: handleSmsResponse,
        error: handleSmsError
    });
});

// Today Postpond
$('body').on('click', '#postpondSms', function () {
    var postpond_user_id = $(this).data('id');
    $.ajax({
        url: "students/" + postpond_user_id + "/todaypostpond",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: handleSmsResponse,
        error: handleSmsError
    });
});

// Tomorrow Postpond
$('body').on('click', '#TomorrowpostpondSms', function () {
    var postpond_user_id = $(this).data('id');
    $.ajax({
        url: "students/" + postpond_user_id + "/tomorrowpostpond",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: handleSmsResponse,
        error: handleSmsError
    });
});

// groupDuesms
$('body').on('click', '#groupDuesms', function () {
    var due_batch_id = $(this).data('id');
    $.ajax({
        url: "batchs/" + due_batch_id + "/groupduesms",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: handleSmsResponse,
        error: handleSmsError
    });
});

// group today postpond
$('body').on('click', '#groupTodayPostpond', function () {
    var postpond_user_id = $(this).data('id');
    $.ajax({
        url: "batchs/" + postpond_user_id + "/grouptodaypostpond",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: handleSmsResponse,
        error: handleSmsError
    });
});

// grouptomorrowpostpond
$('body').on('click', '#groupTomorrowPostpond', function () {
    var postpond_user_id = $(this).data('id');
    $.ajax({
        url: "batchs/" + postpond_user_id + "/grouptomorrowpostpond",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: handleSmsResponse,
        error: handleSmsError
    });
});

// Today Class remainder
$('body').on('click', '#grouptodayremainder', function () {
    var due_user_id = $(this).data('id');
    $.ajax({
        url: "batchs/" + due_user_id + "/grouptodayremainder",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: handleSmsResponse,
        error: handleSmsError
    });
});

// New Class Schedule
$('body').on('click', '#groupnewschedule', function () {
    var schedule_user_id = $(this).data('id');
    $.ajax({
        url: "batchs/" + schedule_user_id + "/groupnewschedule",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: handleSmsResponse,
        error: handleSmsError
    });
});