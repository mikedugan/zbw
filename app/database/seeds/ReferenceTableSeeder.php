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
            DB::table('_message_types')->truncate();

            ComplexityType::create(['value' => 'very_easy']);
            ComplexityType::create(['value' => 'easy']);
            ComplexityType::create(['value' => 'medium']);
            ComplexityType::create(['value' => 'hard']);
            ComplexityType::create(['value' => 'very_hard']);

            WeatherType::create(['value' => 'ifr']);
            WeatherType::create(['value' => 'vfr']);
            WeatherType::create(['value' => 'mvfr']);

            WorkloadType::create(['value' => 'light']);
            WorkloadType::create(['value' => 'medium']);
            WorkloadType::create(['value' => 'heavy']);

            TrainingType::create(['value' => 'sb_training']);
            TrainingType::create(['value' => 'sb_familiarization']);
            TrainingType::create(['value' => 'network_training']);

            AudienceType::create(['value' => 'both']);
            AudienceType::create(['value' => 'pilots']);
            AudienceType::create(['value' => 'controllers']);

            NewsType::create(['value' => 'event']);
            NewsType::create(['value' => 'news']);
            NewsType::create(['value' => 'policy']);
            NewsType::create(['value' => 'forum']);
            NewsType::create(['value' => 'staff']);

            CertType::create(['value' => 'SOP']);
            CertType::create(['value' => 'C_S1']);
            CertType::create(['value' => 'O_S1']);
            CertType::create(['value' => 'B_S1']);
            CertType::create(['value' => 'C_S2']);
            CertType::create(['value' => 'O_S2']);
            CertType::create(['value' => 'B_S2']);
            CertType::create(['value' => 'C_S3']);
            CertType::create(['value' => 'O_S3']);
            CertType::create(['value' => 'B_S3']);
            CertType::create(['value' => 'C_C1']);
            CertType::create(['value' => 'B_C1']);
            CertType::create(['value' => 'I1']);
            CertType::create(['value' => 'I3']);
            CertType::create(['value' => 'C3']);

            TrainingFacility::create(['value' => 'PVD_GND']);
            TrainingFacility::create(['value' => 'PWM_GND']);
            TrainingFacility::create(['value' => 'BDL_GND']);
            TrainingFacility::create(['value' => 'BOS_GND']);
            TrainingFacility::create(['value' => 'PVD_TWR']);
            TrainingFacility::create(['value' => 'PWM_TWR']);
            TrainingFacility::create(['value' => 'BDL_TWR']);
            TrainingFacility::create(['value' => 'BOS_TWR']);
            TrainingFacility::create(['value' => 'PVD_APP']);
            TrainingFacility::create(['value' => 'PWM_APP']);
            TrainingFacility::create(['value' => 'BDL_APP']);
            TrainingFacility::create(['value' => 'BOS_APP']);
            TrainingFacility::create(['value' => 'BOS_CTR']);

            FileType::create(['value' => 'image']);
            FileType::create(['value' => 'sector']);
            FileType::create(['value' => 'chart']);
            FileType::create(['value' => 'exe']);
            FileType::create(['value' => 'document']);

            MessageType::create(['value' => 'private']);
            MessageType::create(['value' => 'c_session']);
            MessageType::create(['value' => 'c_event']);
            MessageType::create(['value' => 'c_news']);
            MessageType::create(['value' => 'c_exam']);

            Facility::create(['value' => 'ZBW']);
            Facility::create(['value' => 'KBDL']);
            Facility::create(['value' => 'KPVD']);
            Facility::create(['value' => 'KMHT']);
            Facility::create(['value' => 'KBOS']);
            Facility::create(['value' => 'KBTV']);
            Facility::create(['value' => 'KPWM']);
            Facility::create(['value' => 'KBGR']);
            Facility::create(['value' => 'KSYR']);
            Facility::create(['value' => 'KALB']);

	}

}
