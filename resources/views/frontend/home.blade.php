<!-- Satisfied Clients Section -->
<section id="satisfied-clients" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Our Satisfied Clients</h2>
        <div class="row justify-content-center">
            @foreach($clients as $client)
                <div class="col-md-2 col-4 text-center mb-4">
                    <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}" class="img-fluid">
                </div>
            @endforeach
        </div>
    </div>
</section>