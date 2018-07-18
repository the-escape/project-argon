<?php

namespace App\Console\Commands;

use Escape\Argon\Authentication\UserRepository;
use Escape\Argon\Events\BeforeUserDelete;
use Escape\Argon\Events\UserDelete;
use Escape\Argon\Helpers\Skynet;
use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;

class SkynetTerminate extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skynet:terminate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users after a recent rollback';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Skynet $skynet)
    {
        if(!$skynet->isConnected())
        {
            $this->warning('Skynet configuration has not been found in your .env file. Run "php artisan skynet:connect".');

            return false;
        }

        $json = $skynet->getRememberedUsers();

        if (!isset($json->deleted_users) || !is_array($json->deleted_users))
        {
            $this->info('Something went wrong, try again later.');
        }
        elseif (!count($json->deleted_users))
        {
            $this->info('No users to delete.');
        }
        else
        {
            if (!$this->confirm('You are about to delete '.count($json->deleted_users).' users. Do you want to proceed'))
            {
                return false;
            }

            $this->deleted_users = $json->deleted_users;

            $results = $this->processUserDeletion();

            $count = 0;

            foreach ($results as $result) {
                $count++;
                $this->info(json_encode($result));
            }

            $msg = ($count === 1)
                ? "Terminated {$count} user."
                : "Terminated {$count} users.";

            $this->info($msg);
        }
    }

    public function processUserDeletion()
    {
        foreach ($this->deleted_users as $userId)
        {
            $response = $this->deleteUser($userId);

            yield [
                'action' => 'terminating',
                'user_id' => $userId,
                'status' => $response
            ];
        }
    }

    public function deleteUser($userId)
    {
        $request = request();
        $userRepository = app()->make(UserRepository::class);

        try
        {
            $user = $userRepository->find($userId);
        }
        catch (\Exception $e)
        {
            return 'not found or already deleted';
        }

        $result = event(new BeforeUserDelete($user, $request));

        if (!empty($result[0]->errors))
        {
            return 'failed';
        }

        $user->roles()->sync([]);

        $user->update([
            'name' => 'Deleted user',
            'email' => $user->id."@deleted.user",
        ]);

        $userRepository->delete($userId);

        event(new UserDelete($userId, $request));

        return 'success';
    }
}
