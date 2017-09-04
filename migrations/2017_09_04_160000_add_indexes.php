<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DB::select(DB::raw('show keys from entities where key_name != "PRIMARY"')))
        {
            Schema::table('entities', function(Blueprint $table) {
                $table->index(['deleted_at','entity_type_id'], 'idx_delat_entypeid');
                $table->index(['deleted_at','slug'], 'idx_delat_slug');
            });
        }

        if (!DB::select(DB::raw('show keys from entity_fields where key_name != "PRIMARY"')))
        {
            Schema::table('entity_fields', function(Blueprint $table) {
                $table->index(['deleted_at','entity_type_id','field_slug','parent_field_id'],'idx_mix');
            });
        }

        if (!DB::select(DB::raw('show keys from entity_localisations where key_name != "PRIMARY"')))
        {
            Schema::table('entity_localisations', function(Blueprint $table) {
                $table->index(['deleted_at','entity_id','locale_id'], 'idx_delat_entid_lcid');
            });
        }

        if (!DB::select(DB::raw('show keys from entity_revisions where key_name != "PRIMARY"')))
        {
            Schema::table('entity_revisions', function(Blueprint $table) {
                $table->index('deleted_at','idx_deleted_at');
                $table->index(['entity_localisation_id','status'],'idx_entlocid_status');
                $table->index('created_at','idx_created_at');
            });
        }

        if (!DB::select(DB::raw('show keys from entity_types where key_name != "PRIMARY"')))
        {
            Schema::table('entity_types', function(Blueprint $table) {
                $table->index(['deleted_at','id'], 'idx_delat_id');
            });
        }

        if (!DB::select(DB::raw('show keys from field_data where key_name != "PRIMARY"')))
        {
            Schema::table('field_data', function(Blueprint $table) {
                $table->index(['field_id','entity_revision_id'],'idx_fid_enrevid');
                $table->index('deleted_at','idx_deleted_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (DB::select(DB::raw('show keys from entities where key_name = "idx_delat_entypeid"')))
        {
            Schema::table('entities', function(Blueprint $table) {
                $table->dropIndex('idx_delat_entypeid');
            });
        }

        if (DB::select(DB::raw('show keys from entities where key_name = "idx_delat_slug"')))
        {
            Schema::table('entities', function(Blueprint $table) {
                $table->dropIndex('idx_delat_slug');
            });
        }

        if (DB::select(DB::raw('show keys from entity_fields where key_name = "idx_mix"')))
        {
            Schema::table('entity_fields', function(Blueprint $table) {
                $table->dropIndex('idx_mix');
            });
        }

        if (DB::select(DB::raw('show keys from entity_localisations where key_name = "idx_delat_entid_lcid"')))
        {
            Schema::table('entity_localisations', function(Blueprint $table) {
                $table->dropIndex('idx_delat_entid_lcid');
            });
        }

        if (DB::select(DB::raw('show keys from entity_revisions where key_name = "idx_deleted_at"')))
        {
            Schema::table('entity_revisions', function(Blueprint $table) {
                $table->dropIndex('idx_deleted_at');
            });
        }

        if (DB::select(DB::raw('show keys from entity_revisions where key_name = "idx_entlocid_status"')))
        {
            Schema::table('entity_revisions', function(Blueprint $table) {
                $table->dropIndex('idx_entlocid_status');
            });
        }

        if (DB::select(DB::raw('show keys from entity_revisions where key_name = "idx_created_at"')))
        {
            Schema::table('entity_revisions', function(Blueprint $table) {
                $table->dropIndex('idx_created_at');
            });
        }

        if (DB::select(DB::raw('show keys from entity_types where key_name = "idx_delat_id"')))
        {
            Schema::table('entity_types', function(Blueprint $table) {
                $table->dropIndex('idx_delat_id');
            });
        }

        if (DB::select(DB::raw('show keys from field_data where key_name = "idx_fid_enrevid"')))
        {
            Schema::table('field_data', function(Blueprint $table) {
                $table->dropIndex('idx_fid_enrevid');
            });
        }

        if (DB::select(DB::raw('show keys from field_data where key_name = "idx_deleted_at"')))
        {
            Schema::table('field_data', function(Blueprint $table) {
                $table->dropIndex('idx_deleted_at');
            });
        }
    }
}
