<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:generate-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '快速生成token';

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
     * @return mixed
     */
    public function handle()
    {
        $customerId = $this->ask('输入用户 id');

        $customer = User::find($customerId);

        if (!$customer) {
            return $this->error('用户不存在');
        }

        // 一年以后过期
        $ttl = 365 * 24 * 60;
        $this->info(\Auth::guard('api')->setTTL($ttl)->fromUser($customer));
    }
}
