<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // select user organization
        $users = DB::table('users')
            ->whereNotNull('organization_id')
            ->select('id as user_id', 'organization_id')
            ->get();
        
        // make pivot array values
        $pivotData = $users->map(function ($user) {
            return [
                'user_id' => $user->user_id,
                'organization_id' => $user->organization_id
            ];
        })->toArray();

        // insert to new table
        if (!empty($pivotData)) {
            DB::table('user_organization')->insert($pivotData);
        }

        // drop the organization_id column
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // re-add the organization_id column with null value as we dont know the original value
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('organization_id')->nullable()->constrained()->after('id');
        });
    }
};
