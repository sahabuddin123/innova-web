namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

public function run()
{
    $clients = [
        ['name' => 'Client 1', 'logo' => 'clients/client1.png', 'is_active' => true],
        ['name' => 'Client 2', 'logo' => 'clients/client2.png', 'is_active' => true],
        ['name' => 'Client 3', 'logo' => 'clients/client3.png', 'is_active' => true],
        ['name' => 'Client 4', 'logo' => 'clients/client4.png', 'is_active' => true],
        ['name' => 'Client 5', 'logo' => 'clients/client5.png', 'is_active' => true],
        ['name' => 'Client 6', 'logo' => 'clients/client6.png', 'is_active' => true],
        ['name' => 'Client 7', 'logo' => 'clients/client7.png', 'is_active' => true],
        ['name' => 'Client 8', 'logo' => 'clients/client8.png', 'is_active' => true],
        ['name' => 'Client 9', 'logo' => 'clients/client9.png', 'is_active' => true],
        ['name' => 'Client 10', 'logo' => 'clients/client10.png', 'is_active' => true],
    ];

    foreach ($clients as $client) {
        Client::create($client);
    }
}