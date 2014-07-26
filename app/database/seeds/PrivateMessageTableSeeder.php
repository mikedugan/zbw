<?php

use Faker\Factory as Faker;

class PrivateMessageTableSeeder extends Seeder
{

    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('zbw_messages')->truncate();
        $faker = Faker::create();
        $cids = \User::lists('cid');
        foreach (range(1, 500) as $i) {
            $m = new \Message();
            $m->from = $faker->randomElement($cids);
            $m->to = $faker->randomElement($cids);
            $m->cid = $m->to;
            $m->subject = $faker->sentence();
            $m->content = $faker->paragraph();
            $m->has_attachments = $faker->boolean(5);
            $m->is_read = $faker->boolean(20);
            $m->save();
            $mm = new \Message();
            $mm->from = $m->from;
            $mm->to = $m->to;
            $mm->cid = $m->from;
            $mm->subject = $m->subject;
            $mm->content = $m->content;
            $mm->has_attachments = $m->has_attachments;
            $mm->is_read = $m->is_read;
            $mm->save();
        }

    }

}
