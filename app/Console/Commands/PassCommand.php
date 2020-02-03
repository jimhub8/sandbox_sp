<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PassCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $chars = 'abcdefghijklmnopqrstuvwxyz';
        $size = 6;
        $combinations = array();

        # if it's the first iteration, the first set
        # of combinations is the same as the set of characters
        if (empty($combinations)) {
            $combinations = $chars;
        }

        # we're done if we're at size 1
        if ($size == 1) {
            return $combinations;
        }

        # initialise array to put new values in
        $new_combinations = array();

        # loop through existing combinations and character set to create strings
        foreach ($combinations as $combination) {
            foreach ($chars as $char) {
                $new_combinations[] = $combination . $char;
            }
        }

        # call same function again for the next iteration
        dd($chars, $size - 1, $new_combinations);

        // for ($i=0; $string < strlen($string); $i++) {
        //     dd($i, $string[$i], $string[$i+1]);

        // }

    }
}
