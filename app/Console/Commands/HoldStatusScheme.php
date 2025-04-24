<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SchemeModel;
use Carbon\Carbon;

class HoldStatusScheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'holdstatusactive:tbl_scheme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change hold status dective to active';

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
        $schemes = SchemeModel::where('hold_status','1')->where('status','1')->get();
        foreach($schemes as $scheme)
        {
            
            if(($scheme->hold_active_time == now()->format('Y-m-d H:i:s'))||( $scheme->hold_active_time < now()->format('Y-m-d H:i:s') )){
                SchemeModel::where('id',$scheme->id)->update(['hold_status'=>0]);
            }
        } 
        // return 0;
    }
}
