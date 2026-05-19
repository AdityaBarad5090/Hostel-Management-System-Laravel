<!DOCTYPE html>
<html>
<head>
    <title>Subscription Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body class="bg-light d-flex justify-content-center mt-5">

    <div class="card p-4 shadow-sm" style="width: 100%; max-width: 400px;">
        <h5 class="mb-1">Hostel Fee Subscription</h5>
        <p class="text-muted small mb-4">Student: {{ $student->name }}</p>

        <div id="card-element" class="form-control mb-2" style="height: 42px; padding-top: 10px;"></div>
        <div id="card-errors" class="text-danger small mb-3"></div>

        <button id="subscribe-btn" class="btn btn-primary w-100">Subscribe</button>
        <button id="back-btn" class="btn btn-secondary w-100 mt-2" onclick="window.location.href='/student/fees'">Cancel</button>

    </div>

    <script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        document.getElementById('subscribe-btn').addEventListener('click', async () => {
            const btn = document.getElementById('subscribe-btn');
            btn.disabled = true;
            btn.innerText = 'Processing...';

            const { paymentMethod, error } = await stripe.createPaymentMethod({ type: 'card', card });

            if (error) {
                document.getElementById('card-errors').innerText = error.message;
                btn.disabled = false;
                btn.innerText = 'Subscribe';
                return;
            }

            fetch('/subscription', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    payment_method: paymentMethod.id,
                    student_id: "{{ $student->id }}"
                })
            })
            .then(res => res.json())
            .then(() => {
                alert('Subscription Successful!');
                window.location.href = '/student/fees';
            });
        });
    </script>
</body>
</html>