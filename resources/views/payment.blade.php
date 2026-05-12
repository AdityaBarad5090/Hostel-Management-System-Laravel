<!DOCTYPE html>
<html>

<head>
    <title>Pay Fee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body {
            background: #f5f5f5;
        }

        .pay-box {
            width: 350px;
        }

        .stripe-field {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        #card-errors {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow pay-box">

            <h5 class="mb-3">Pay Hostel Fee</h5>
            <p class="mb-1 text-muted small">Student: {{ $student->name }}</p>
            <p class="mb-3 text-muted small">Amount: ₹{{ $fee->amount }}</p>

            <label class="form-label small">Email</label>
            <input type="email" id="email" class="form-control mb-3" placeholder="Enter your email">

            <label class="form-label small">Card Number</label>
            <div id="card-number" class="stripe-field mb-3"></div>

            <div class="row g-2 mb-3">
                <div class="col-6">
                    <label class="form-label small">Expiry Date</label>
                    <div id="card-expiry" class="stripe-field"></div>
                </div>
                <div class="col-6">
                    <label class="form-label small">CVV</label>
                    <div id="card-cvc" class="stripe-field"></div>
                </div>
            </div>

            <div id="card-errors" class="mb-2"></div>

            <button id="pay-btn" class="btn btn-primary w-100">Pay Now</button>

        </div>
    </div>

    <script>
        const stripe = Stripe('{{ $stripeKey }}');
        const elements = stripe.elements();

        const cardNumber = elements.create('cardNumber');
        const cardExpiry = elements.create('cardExpiry');
        const cardCvc = elements.create('cardCvc');

        cardNumber.mount('#card-number');
        cardExpiry.mount('#card-expiry');
        cardCvc.mount('#card-cvc');

        [cardNumber, cardExpiry, cardCvc].forEach(el => {
            el.on('change', ({
                error
            }) => {
                document.getElementById('card-errors').textContent = error ? error.message : '';
            });
        });

        document.getElementById('pay-btn').addEventListener('click', async () => {
            const btn = document.getElementById('pay-btn');
            const email = document.getElementById('email').value;

            btn.disabled = true;
            btn.textContent = 'Processing...';

            const {
                paymentIntent,
                error
            } = await stripe.confirmCardPayment(
                '{{ $clientSecret }}', {
                    payment_method: {
                        card: cardNumber,
                        billing_details: {
                            email: email
                        }
                    }
                }
            );

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                btn.disabled = false;
                btn.textContent = 'Pay Now';
            } else if (paymentIntent.status === 'succeeded') {
                btn.textContent = '✓ Payment Successful';
                btn.classList.replace('btn-primary', 'btn-success');
                window.location.href = '/student/fees/pay-success?payment_intent=' + paymentIntent.id;
            }
        });
    </script>

</body>

</html>