<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UsuarioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Usuario::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => '1',
            'nome' => 'Admin',
            'sobrenome' => 'Admin',
            'cpf' => '12304465502',      
            'data_nascimento'=>'2021-01-14 12:40:04',      
            'email' => 'admin@admin.com',
            'status' => '1',
            'perfil_id' => '1',
       
              
        ];
    }
}
