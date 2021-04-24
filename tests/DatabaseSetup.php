<?php


namespace Tests;


use App\Http\Kernel;

trait DatabaseSetup
{

    protected static $migrated = false;

    public function setupDatabase()
    {
        if($this->isInMemory())
        {
            $this->setupInMemoryDatabase();
        }else{
            $this->setupTestDatabase();
        }
    }

    protected  function isInMemory()
    {

    }

    protected function setupTestDatabase()
    {
        if(!static::$migrated)
        {
            $this->whenMigrationsChange(function (){

                $this->artisan('migrate:fresh --seed');

                $this->app[Kernel::class]->setArtisan(null);
            });

            static::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }
}
