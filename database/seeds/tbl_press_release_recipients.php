<?php

use Illuminate\Database\Seeder;

class tbl_press_release_recipients extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_press_release_recipients')->truncate();
        $statement = "INSERT INTO `tbl_press_release_recipients` (`recipient_id`,`media_type`) VALUES 
        	(1, 'Magazine'),
        	(2, 'Newspaper');
            (3, 'Telegrama');
            (4, 'News Agency');
            (4, 'Periodical');
            (5, 'Online Magazine')";
       	DB::statement($statement);
    }
}
