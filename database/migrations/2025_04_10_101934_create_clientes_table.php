<?php
    
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
    
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cli_clientes', function (Blueprint $table) {
            $table->Increments('cli_id');
            $table->char('cli_type',1);
            $table->string('cli_name',300);
            $table->string('cli_cpf_cnpjclear',20);
            $table->char('cli_ativo',1);
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }
    /*
    ->nullable();
    CREATE TABLE `cli_clientes` (
  `cli_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `cli_type` char(1) NOT NULL,
  `cli_name` varchar(300) NOT NULL,
  `cli_cpf_cnpj` varchar(30) NOT NULL,
  `cli_ativo` char(1) NOT NULL,
  `cli_deleted` char(1) NOT NULL,
  `cli_date_creation` timestamp NULL DEFAULT NULL,
  `cli_date_update` timestamp NULL DEFAULT NULL,
  `cli_date_delete` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cli_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
          
    */
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};