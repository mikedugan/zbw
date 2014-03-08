<?php

class ReferenceTableSeeder extends Seeder {

	public function run()
	{
		DB::table('_complexity_types')->truncate();
        DB::table('_news_audience')->truncate();
        DB::table('_news_types')->truncate();
        DB::table('_training_types')->truncate();
        DB::table('_workload_types')->truncate();
        DB::table('_weather_types')->truncate();

        ComplexityType::create(['type' => 'very_easy']);
        ComplexityType::create(['type' => 'easy']);
        ComplexityType::create(['type' => 'medium']);
        ComplexityType::create(['type' => 'hard']);
        ComplexityType::create(['type' => 'very_hard']);

        WeatherType::create(['type' => 'ifr']);
        WeatherType::create(['type' => 'vfr']);
        WeatherType::create(['type' => 'mvfr']);

        WorkloadType::create(['type' => 'light']);
        WorkloadType::create(['type' => 'medium']);
        WorkloadType::create(['type' => 'heavy']);

        TrainingType::create(['type' => 'sb_training']);
        TrainingType::create(['type' => 'sb_familiarization']);
        TrainingType::create(['type' => 'network_training']);

        AudienceType::create(['type' => 'both']);
        AudienceType::create(['type' => 'pilots']);
        AudienceType::create(['type' => 'controllers']);

        NewsType::create(['type' => 'event']);
        NewsType::create(['type' => 'news']);
        NewsType::create(['type' => 'policy']);
        NewsType::create(['type' => 'forum']);
        NewsType::create(['type' => 'staff']);
	}

}
