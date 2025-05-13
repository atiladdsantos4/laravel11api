<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ClienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  [
            'cli_id' => $this->cli_id,
            'cli_type' => $this->cli_type == 1 ? 'Pessoa Fisica' : 'Pessoa Jurídica',
            'cli_name' => $this->cli_name,
            'cli_cpf_cnpj' => $this->cli_cpf_cnpj,
            'cli_ativo' => $this->cli_ativo,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:i:s'),
            'updated_at' => $this->updated_at != null ? Carbon::parse($this->updated_at)->format('d/m/Y H:i:s') : null,
            'deleted_at' => $this->deleted_at != null ? Carbon::parse($this->deleted_at)->format('d/m/Y H:i:s') : null,
            'action' => null //--> para o datatbes não quebrar <--//
            //'deleted_at' => $this->updated_at->format('d/m/Y H:i:s')
        ];
        return $data;
        //return parent::toArray($request);
        //'cli_type', 'cli_name', 'cli_cpf_cnpj', 'cli_ativo', 'created_at', 'updated_at', 'deleted_at'
    }
}
