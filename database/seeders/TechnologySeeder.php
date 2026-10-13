namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Technology;

class TechnologySeeder extends Seeder
{
    public function run()
    {
        $technologies = [
            ['name' => 'Laravel', 'icon' => 'technologies/laravel.png', 'is_active' => true],
            ['name' => 'JavaScript', 'icon' => 'technologies/js.png', 'is_active' => true],
            ['name' => 'jQuery', 'icon' => 'technologies/jquery.png', 'is_active' => true],
            ['name' => 'Joomla', 'icon' => 'technologies/joomla.png', 'is_active' => true],
            ['name' => 'HTML5', 'icon' => 'technologies/html5.png', 'is_active' => true],
            ['name' => 'CSS3', 'icon' => 'technologies/css3.png', 'is_active' => true],
            ['name' => 'CodeIgniter', 'icon' => 'technologies/codeigniter.png', 'is_active' => true],
            ['name' => 'CakePHP', 'icon' => 'technologies/cakephp.png', 'is_active' => true],
            ['name' => 'Bootstrap', 'icon' => 'technologies/bootstrap.png', 'is_active' => true],
            ['name' => 'Apple', 'icon' => 'technologies/apple.png', 'is_active' => true],
        ];
        foreach ($technologies as $technology) {
            Technology::create($technology);
        }
    }
}