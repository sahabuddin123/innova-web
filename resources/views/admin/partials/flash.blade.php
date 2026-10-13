@php
    $errors = Session::get('error');
    $messages = Session::get('success');
    $info = Session::get('info');
    $warnings = Session::get('warning');

    $errorList = is_array($errors) ? $errors : ($errors ? [$errors] : []);
    $messageList = is_array($messages) ? $messages : ($messages ? [$messages] : []);
    $infoList = is_array($info) ? $info : ($info ? [$info] : []);
    $warningList = is_array($warnings) ? $warnings : ($warnings ? [$warnings] : []);
@endphp

@if ($errorList)
    @foreach($errorList as $value)
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button class="close" type="button" data-dismiss="alert">×</button>
            <strong>Error!</strong> {{ $value }}
        </div>
    @endforeach
@endif

@if ($messageList)
    @foreach($messageList as $value)
        <div class="alert alert-success alert-dismissible" role="alert">
            <button class="close" type="button" data-dismiss="alert">×</button>
            <strong>Success!</strong> {{ $value }}
        </div>
    @endforeach
@endif

@if ($infoList)
    @foreach($infoList as $value)
        <div class="alert alert-info alert-dismissible" role="alert">
            <button class="close" type="button" data-dismiss="alert">×</button>
            <strong>Info!</strong> {{ $value }}
        </div>
    @endforeach
@endif

@if ($warningList)
    @foreach($warningList as $value)
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button class="close" type="button" data-dismiss="alert">×</button>
            <strong>Warning!</strong> {{ $value }}
        </div>
    @endforeach
@endif