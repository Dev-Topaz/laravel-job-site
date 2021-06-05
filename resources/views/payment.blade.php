<!DOCTYPE html>
<html>

<head>
    <title>Laravel Stripe Payment Gateway Integrate Example</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">

                        @if (Session::has('success'))
                        <div class="alert alert-primary text-center">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @endif

                        <form role="form" method="post" class="stripe-payment"
                            data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="stripe-payment">
                            @csrf

                            <div class='form-row row'>
                                <div class='col-xs-12 form-group required'>
                                    <label class='control-label'>Name on Card</label> <input class='form-control'
                                        size='4' type='text'>
                                </div>
                            </div>

                            <div class='form-row row'>
                                <div class='col-xs-12 form-group card required'>
                                    <label class='control-label'>Card Number</label> <input autocomplete='off'
                                        class='form-control card-num' size='20' type='text'>
                                </div>
                            </div>

                            <div class='form-row row'>
                                <div class='col-xs-12 col-md-4 form-group cvc required'>
                                    <label class='control-label'>CVC</label>
                                    <input autocomplete='off' class='form-control card-cvc' placeholder='e.g 595'
                                        size='4' type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label'>Expiration Month</label> <input
                                        class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label'>Expiration Year</label> <input
                                        class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                                </div>
                            </div>

                            <div class='form-row row'>
                                <div class='col-md-12 hide error form-group'>
                                    <div class='alert-danger alert'>Fix the errors before you begin.</div>
                                </div>
                            </div>

                            <div class="row">
                                <button class="btn btn-success btn-lg btn-block" type="submit">Pay</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
    $(function(){var e=$(".stripe-payment");function r(r,t){if(t.error)$(".error").removeClass("hide").find(".alert").text(t.error.message);else{var a=t.id;e.find("input[type=text]").empty(),e.append("<input type='hidden' name='stripeToken' value='"+a+"'/>"),e.get(0).submit()}}$("form.stripe-payment").bind("submit",function(e){var t=$(".stripe-payment"),a=["input[type=email]","input[type=password]","input[type=text]","input[type=file]","textarea"].join(", "),i=t.find(".required").find(a),n=t.find("div.error");n.addClass("hide"),$(".has-error").removeClass("has-error"),i.each(function(r,t){var a=$(t);""===a.val()&&(a.parent().addClass("has-error"),n.removeClass("hide"),e.preventDefault())}),t.data("cc-on-file")||(e.preventDefault(),Stripe.setPublishableKey(t.data("stripe-publishable-key")),Stripe.createToken({number:$(".card-num").val(),cvc:$(".card-cvc").val(),exp_month:$(".card-expiry-month").val(),exp_year:$(".card-expiry-year").val()},r))})});

</script>

</html>