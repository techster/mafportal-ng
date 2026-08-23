<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RepairMissingSlideImages extends Migration
{
    public function up()
    {
        DB::table('slides')
            ->where('image', '/uploads/admin/slider/cbac5643dd3acdba4d74664778392ca8.jpg')
            ->update(['image' => '/uploads/admin/slider/f254041f5054cd6bb5e6728029fa13bf.jpg']);
    }

    public function down()
    {
        // The missing image reference is not restored.
    }
}