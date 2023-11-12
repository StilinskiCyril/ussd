<!DOCTYPE html>
<head>
    <title>Aguva Ussd Simulator</title>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
            integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
            crossorigin="anonymous"></script>

    <!-- jQuery.NumPad -->
    <link rel="stylesheet" href="{{ asset('ussd-assets/css/easy-numpad.css') }}">
    <script src="{{ asset('ussd-assets/js/easy-numpad.js') }}"></script>
</head>
<html>

<body style="font-size: 13px">

<div class="container-fluid">
    <div class="card mx-auto mt-3" style="width: 50%">
        <div class="card-header">
            <h6 class="text-center"><strong>Aguva USSD Simulator</strong></h6>

            <a href="{{route('test.simulatorPage')}}" class="btn btn-danger">New Session</a>
        </div>

        <div class="card-body">
            <form action=" {!! route('test.processPayload') !!}" method="post">
                @csrf
                <div class="form-group">
                    <label for="fname">Msisdn (254)</label>
                    <input type="text" id="msisdn" name="msisdn" value="{!! @$input['msisdn'] !!}"
                           placeholder="phone number" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="input">Session Id</label>
                    <input type="text" id="input" name="session_id" value="{!! @$input['session_id'] !!}"
                           placeholder="ussd session" required class="form-control">
                </div>

                <div class="form-group easy-get">
                    <label for="input">User Input</label>
                    <input type="text" name="input" placeholder="user input" required class="form-control easy-put"
                           readonly/>
                </div>
                <input type="submit" class="btn btn-primary btn-block" value="Send Request">
            </form>
        </div>
        <div class="card-footer" style="font-size: 15px">
            <h6><strong>USSD Response</strong></h6>
            @if(isset($text))
                {!! nl2br($text) !!}
            @endif
        </div>
    </div>
</div>
</body>
</html>