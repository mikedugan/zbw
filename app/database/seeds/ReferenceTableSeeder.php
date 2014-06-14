<?php

class ReferenceTableSeeder extends Seeder {

        public function run()
        {
            DB::table('_complexity_types')->truncate();
            DB::table('_audience_types')->truncate();
            DB::table('_news_types')->truncate();
            DB::table('_training_types')->truncate();
            DB::table('_workload_types')->truncate();
            DB::table('_weather_types')->truncate();
            DB::table('_cert_types')->truncate();
            DB::table('_training_facilities')->truncate();
            DB::table('_file_types')->truncate();
            DB::table('_message_types')->truncate();
            DB::table('_facilities')->truncate();
            DB::table('_subscription_types')->truncate();
            DB::table('_ratings')->truncate();

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

            SubscriptionType::create(['value' => 'Me']);
            SubscriptionType::create(['value' => 'Forum']);
            SubscriptionType::create(['value' => 'ExamRequest']);
            SubscriptionType::create(['value' => 'TrainingRequest']);
            SubscriptionType::create(['value' => 'TrainingAvailable']);
            SubscriptionType::create(['value' => 'ForumTopic']);
            SubscriptionType::create(['value' => 'ForumPost']);
            SubscriptionType::create(['value' => 'Message']);
            SubscriptionType::create(['value' => 'News']);

            Rating::create(['id' => '-1', 'short'=>'INA', 'medium'=>'INA', 'long'=>'Inactive', 'GRP'=>'Inactive']);
            Rating::create(['id' => '0', 'short'=>'SUS', 'medium'=>'SUS', 'long'=>'Suspended', 'GRP'=>'Suspended']);
            Rating::create(['id' => '1', 'short'=>'OBS', 'medium'=>'OBS', 'long'=>'Pilot/Observer', 'GRP'=>'Pilot/Observer']);
            Rating::create(['id' => '2', 'short'=>'S1', 'medium'=>'STU', 'long'=>'Student', 'GRP'=>'Tower Trainee']);
            Rating::create(['id' => '3', 'short'=>'S2', 'medium'=>'STU2', 'long'=>'Student 2', 'GRP'=>'Tower Controller']);
            Rating::create(['id' => '4', 'short'=>'S3', 'medium'=>'STU+', 'long'=>'Student 3', 'GRP'=>'TMA Controller']);
            Rating::create(['id' => '5', 'short'=>'C1', 'medium'=>'CTR', 'long'=>'Controller', 'GRP'=>'Enroute Controller']);
            Rating::create(['id' => '6', 'short'=>'C2', 'medium'=>'CTR2', 'long'=>'Controller 2', 'GRP'=>'Enroute Controller 2']);
            Rating::create(['id' => '7', 'short'=>'C3', 'medium'=>'CTR+', 'long'=>'Senior Controller', 'GRP'=>'Senior Controller']);
            Rating::create(['id' => '8', 'short'=>'I1', 'medium'=>'INS', 'long'=>'Instructor', 'GRP'=>'Instructor']);
            Rating::create(['id' => '9', 'short'=>'I2', 'medium'=>'INS2', 'long'=>'Instructor 2', 'GRP'=>'Instructor 2']);
            Rating::create(['id' => '10', 'short'=>'I3', 'medium'=>'INS+', 'long'=>'Senior Instructor', 'GRP'=>'Senior Instructor']);
            Rating::create(['id' => '11', 'short'=>'SUP', 'medium'=>'SUP', 'long'=>'Supervisor', 'GRP'=>'Supervisor']);
            Rating::create(['id' => '12', 'short'=>'ADM', 'medium'=>'ADM', 'long'=>'Administrator', 'GRP'=>'Administrator']);

	}

}
