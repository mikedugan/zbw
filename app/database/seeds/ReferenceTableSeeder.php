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
        DB::table('_cert_types')->truncate();
        DB::table('_training_facilities')->truncate();
        DB::table('_file_types')->truncate();

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

        CertType::create(['type' => 'C_S1']);
        CertType::create(['type' => 'B_S1']);
        CertType::create(['type' => 'C_S2']);
        CertType::create(['type' => 'B_S2']);
        CertType::create(['type' => 'C_S3']);
        CertType::create(['type' => 'B_S3']);
        CertType::create(['type' => 'C1']);
        CertType::create(['type' => 'I1']);
        CertType::create(['type' => 'I3']);
        CertType::create(['type' => 'C3']);

        TrainingFacility::create(['facility' => 'PVD_GND']);
        TrainingFacility::create(['facility' => 'PWM_GND']);
        TrainingFacility::create(['facility' => 'BDL_GND']);
        TrainingFacility::create(['facility' => 'BOS_GND']);
        TrainingFacility::create(['facility' => 'PVD_TWR']);
        TrainingFacility::create(['facility' => 'PWM_TWR']);
        TrainingFacility::create(['facility' => 'BDL_TWR']);
        TrainingFacility::create(['facility' => 'BOS_TWR']);
        TrainingFacility::create(['facility' => 'PVD_APP']);
        TrainingFacility::create(['facility' => 'PWM_APP']);
        TrainingFacility::create(['facility' => 'BDL_APP']);
        TrainingFacility::create(['facility' => 'BOS_APP']);
        TrainingFacility::create(['facility' => 'BOS_CTR']);

        FileType::create(['type' => 'image']);
        FileType::create(['type' => 'sector']);
        FileType::create(['type' => 'chart']);
        FileType::create(['type' => 'exe']);
        FileType::create(['type' => 'document']);
	}

}
