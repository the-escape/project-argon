<?php namespace Escape\Argon\Helpers;

use Escape\Argon\Authentication\User;
use Illuminate\Support\Facades\DB;

class GDPR
{
    private static $tables;
    private static $foreignKeys = [
        'user_id',
    ];

    public function __construct()
    {

    }


    public static function getAllTables($connection = null)
    {
        return collect(DB::connection($connection)->select('show tables'))->map(function ($val)
        {
            foreach ($val as $key => $table)
            {
                return $table !== 'users' ? $table : false;
            }
        });
    }

    public static function getAllTablesWithRelationshipToUserTable()
    {
        $tables = [];
        $allTables = self::getAllTables();

        foreach($allTables as $table)
        {
            $columns = DB::getSchemaBuilder()->getColumnListing($table);

            foreach(self::$foreignKeys as $foreignKey)
            {
                if(in_array($foreignKey, $columns))
                {
                    $tables[$table][] = $foreignKey;
                }
            }

            if(in_array('email', $columns))
            {
                $tables[$table][] = 'email';
            }
        }

        return $tables;
    }

    public static function getAllTablesWithUserData($user)
    {
        if(!is_object($user))
        {
            $user = User::first($user);
        }

        $tables = [];
        $userTables = self::getAllTablesWithRelationshipToUserTable();

        foreach($userTables as $table => $foreignKeys)
        {
            foreach($foreignKeys as $key)
            {
                if($key == 'email')
                {
                    $exists = DB::table($table)->where('email', $user->email)->count();
                }
                else
                {
                    $exists = DB::table($table)->where($key, $user->id)->count();
                }

                if(empty($tables[$table]))
                {
                    $tables[$table] = $exists;
                }
            }
        }

        return $tables;
    }
}