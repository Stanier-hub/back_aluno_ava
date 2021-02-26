<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;
use App\Models\Filial;
use App\Models\Perfil;
use App\Models\Usuario;
use App\Models\User;
use App\Models\Permissions;
use Spatie\Permission\Models\Role;
use App\Models\Roles;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
   
        Perfil::factory(1)->create();
        Usuario::factory(1)->create();
        User::factory(1)->create();

       
        /* ###### LENGENDAS DAS PERMISSÕES ######
            c_      = Create
            r_      = Read
            ra_     = Read All
            u_      = Update
            d_      = Delete
            lock_   = Lock
            unlock_ = Unlock
            s_      = search 
        */




        /* ###### LENGENDAS DAS PERMISSÕES ######
            c_       = Create
            r_       = Read
            ra_      = Read All
            u_       = Update
            d_       = Delete
            lock_    = Lock
            unlock_  = Unlock
            give_    = give
            revoke_  = revoke
            assign_  = assign
            l_       = list
            l_by_id_ = list by id
        */

       

     
    }
}
