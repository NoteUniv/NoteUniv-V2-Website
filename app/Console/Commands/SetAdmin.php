<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SetAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set-admin {student_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the admin role to the specified user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $studentId = $this->argument('student_id');

        $user = User::where('student_id', $studentId)->first();

        if (!$user) {
            $this->error('User not found');
            return 1;
        }

        if ($user->is_admin === 0) {
            $user->is_admin = true;
            $this->info('User is now an admin');
        } else {
            $user->is_admin = false;
            $this->info('User is no longer an admin');
        }
        $user->save();

        return 0;
    }
}
