<?php 

use WHMCS\Database\Capsule;

function autonotify_activate () {
    if (!Capsule::schema()->hasTable('sr_autonotify_module_whmcs')) {
        Capsule::schema()->create('sr_autonotify_module_whmcs', function ($table) {
            $table->increments('id'); 
            $table->string('token', 255)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
            $table->boolean('status')->default(false);
        });
        Capsule::table("sr_autonotify_module_whmcs")->insert([
            "token" => ""
        ]);
    }


    $fieldExists = Capsule::table('tblcustomfields')
        ->where('fieldname', 'Aceita Notificações pelo WhatsApp? (Autonotify)')
        ->where('type', 'client')
        ->count();

    if ($fieldExists == 0) {
        Capsule::table('tblcustomfields')->insert([
            'type' => 'client', 
            'fieldname' => 'Aceita Notificações pelo WhatsApp? (Autonotify)',
            'fieldtype' => 'dropdown', 
            'description' => 'Informe se deseja receber notificações no WhatsApp.',
            'fieldoptions' => 'Sim,Não',
            'regexpr' => '',
            'adminonly' => '',
            'required' => '',
            'showorder' => '',
            'showinvoice' => '',
            'sortorder' => '0',
            'created_at' => Capsule::raw('now()'),
            'updated_at' => Capsule::raw('now()')
        ]);
    }

}

?>