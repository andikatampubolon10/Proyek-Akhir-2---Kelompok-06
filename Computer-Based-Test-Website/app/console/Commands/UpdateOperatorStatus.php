<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateOperatorStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-operator-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $operators = Operator::all();
    
        foreach ($operators as $operator) {
            if (Carbon::now()->greaterThan($operator->expiry_date)) {
                $operator->status = 'inactive';
                $operator->save();
            }
        }
    
        $this->info('Operator status has been updated.');
    }    
}
