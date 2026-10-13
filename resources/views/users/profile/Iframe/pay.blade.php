<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
    <title>Payment</title>
    <style>
      .center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
      }

      button {
        background-color: red;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
      }
    </style>
</head>
<body>
  <div class="center">
    <input type="hidden" id="price" name="price" value="{{ $amount }}"><br><br>
    <button type="button" id="bKash_button">Pay with bKash</button>
  </div>
<script>
        var price = document.getElementById('price').value;
        console.log(price);
        var paymentID = '';
        bKash.init({
          paymentMode: 'checkout', //fixed value ‘checkout’
          //paymentRequest format: {amount: AMOUNT, intent: INTENT}
          //intent options
          //1) ‘sale’ – immediate transaction (2 API calls)
          //2) ‘authorization’ – deferred transaction (3 API calls)
          paymentRequest: {
            amount: price, //max two decimal points allowed
            intent: 'sale'
          },
          createRequest: function(request) { //request object is basically the paymentRequest object, automatically pushed by the script in createRequest method
           console.log("create working !!")
            $.ajax({
              url: 'bkash/create',
              type: 'GET',
              data: JSON.stringify(request),
              contentType: 'application/json',
              success: function(data) {
                data = JSON.parse(data);
                //console.log(data)
                if (data && data.paymentID != null) {
                  paymentID = data.paymentID;
                  bKash.create().onSuccess(data); //pass the whole response data in bKash.create().onSucess() method as a parameter
                } else {
                  bKash.create().onError();
                }
              },
              error: function() {
                bKash.create().onError();
              }
            });
          },
          executeRequestOnAuthorization: function() {
            console.log("execute working !!")
            $.ajax({
              url: 'bkash/execute',
              type: 'GET',
              contentType: 'application/json',
              data: JSON.stringify({
                "paymentID": paymentID
              }),
              success: function(data) {
                data = JSON.parse(data);
               //console.log(data)
                if (data && data.paymentID != null) {
                  console.log("trxID: ",data.trxID)
                   window.location.href = '{{ route('success') }}'; // Your redirect route when successful payment
                } else {
                    console.log("error ");
                    window.location.href = '{{ route('fail') }}'; // Your redirect route when fail payment
                    bKash.execute().onError();
                }
              },
              error: function() {
                bKash.execute().onError();
              }
            });
          },
          onClose: function(){
            window.location.href='/';  // Your redirect route when cancel payment may be cart 
          },
          });
</script>
</body>
</html>