<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Escopo;

    class EscopoCustomRule implements Rule
    {
        public function passes($attribute, $value)
        {
            // Your validation logic here
            $existe = Escopo::where('esc_posicao',$value)->exists(); 
            return $existe == false;
            //$value == 'escopo_posicao';
        }
        
        public function message()
        {
            return 'A posição do escopo já foi definida';
        }
    }
?>    