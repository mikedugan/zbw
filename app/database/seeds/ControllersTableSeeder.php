<?php

class ControllersTableSeeder extends Seeder {


	public function run()
	{
		DB::table('controllers')->truncate();
		Eloquent::unguard();
		$faker = Faker\Factory::create();

		$rating_ids = ['I3', 'I1', 'C3', 'C1', 'S3', 'S2', 'S1', 'O'];

        $cids = [1146085, 1146708, 1147511, 1147798, 1147976, 1148107, 1148306, 1148707, 1149119, 1149333, 1149670, 1150803, 1152352, 1153449, 1155582, 1155731, 1156601, 1156611, 1156896, 1156948, 1157299, 1158189, 1158269, 1159065, 1160289, 1160343, 1160594, 1161277, 1161346, 1166740, 1168625, 1169430, 1170087, 1170384, 1170385, 1170482, 1171207, 1171964, 1172067, 1172700, 1172919, 1173568, 1174936, 1175131, 1175537, 1176263, 1176594, 1177693, 1177784, 1179029, 1179152, 1179253, 1179391, 1179531, 1179622, 1180095, 1180385, 1180469, 1180484, 1180691, 1181029, 1181045, 1181046, 1182255, 1182456, 1182693, 1182694, 1182861, 1182971, 1183497, 1183607, 1184035, 1184128, 1184731, 1185295, 1187093, 1187900, 1188397, 1188683, 1189189, 1189648, 1190326, 1190900, 1192040, 1192327, 1193074, 1193209, 1194503, 1195915, 1195991, 1196003, 1196182, 1196651, 1196738, 1197743, 1198440, 1200203, 1202437, 1203265, 1203735, 1204001, 1204419, 1205204, 1205977, 1207561, 1207994, 1208142, 1208589, 1208802, 1210592, 1211193, 1211486, 1211539, 1213078, 1213326, 1213327, 1214386, 1214472, 1214750, 1214972, 1216544, 1217396, 1217613, 1218929, 1219051, 1219061, 1219337, 1219937, 1220011, 1220610, 1221647, 1221758, 1223004, 1223921, 1225192, 1225528, 1227524, 1228863, 1229715, 1230904, 1232005, 1232215, 1232575, 1232983, 1233308, 1235522, 1236068, 1236115, 1236799, 1237265, 1237461, 1238001, 1238415, 1238892, 1240048, 1240830, 1242111, 1242510, 1242816, 1243449, 1243615, 1243780, 1244630, 1245591, 1245865, 1246257, 1246455, 1246736, 1246793, 1247186, 1249609, 1250947, 1251202, 1253785, 1253920, 1254414, 1256391, 1257208, 1258369, 1260193, 1260274, 1261353, 1262716, 1262816, 1264669, 1264846, 1266356, 1269192, 1270029, 1271775, 1275800, 1275828, 1278047, 1278048, 1278332, 1282683, 1284307, 1285031, 1286551];

		$c = new User();
		$c->cid = 1240047;
		$c->initials = "DA";
		$c->first_name = 'Mike';
		$c->last_name = 'Dugan';
		$c->username = $c->first_name . ' ' . $c->last_name;
		$c->password = Hash::make('q1w2e3r4');
		$c->email = 'mike@mjdugan.com';
		$c->rating_id = 6;
		$c->signature = 'Mike Dugan, Webmaster';
		$c->artcc = 5;
		$c->is_active = 1;
		$c->is_mentor = 1;
		$c->is_webmaster = 1;
		$c->is_staff = 1;
		$c->cert = 7;
		$c->save();

		$c = new User();
		$c->cid = 1170055;
		$c->initials = "BU";
		$c->first_name = 'Rich';
		$c->last_name = 'Bonneau';
		$c->username = strtoupper($c->first_name . ' ' . $c->last_name);
		$c->password = Hash::make('zbwatm2o14');
		$c->email = 'atm@bostonartcc.net';
		$c->signature = 'Rich Bonneau - ATM';
		$c->rating_id = 3;
		$c->artcc = "ZBW";
		$c->is_active = 1;
		$c->is_mentor = 1;
		$c->is_atm = 1;
		$c->is_staff = 1;
		$c->cert = 6;
		$c->save();

		$c = new User();
		$c->cid = 1544047;
		$c->initials = "WY";
		$c->first_name = 'Mike';
		$c->last_name = 'Willey';
		$c->username = $c->first_name . ' ' . $c->last_name;
		$c->password = Hash::make('zbwta20!4');
		$c->email = 'mwilley@gfgroup.net';
		$c->signature = "Mike Willey, TA";
		$c->rating_id = 5;
		$c->artcc = "ZBW";
		$c->is_active = 1;
		$c->is_ta = 1;
		$c->is_instructor = 1;
		$c->is_staff = 1;
		$c->cert = 14;
		$c->save();

    $c = new User();
    $c->cid = 1093141;
    $c->initials = "DB";
    $c->first_name = 'Francis';
    $c->last_name = 'Dube';
    $c->username = $c->first_name . ' ' . $c->last_name;
    $c->password = Hash::make('x');
    $c->email = 'dubef01@gmail.com';
    $c->signature = "Francis Dube, DATM";
    $c->rating_id = 5;
    $c->artcc = "ZBW";
    $c->is_active = 1;
    $c->is_datm = 1;
    $c->is_instructor = 1;
    $c->is_staff = 1;
    $c->cert = 13;
    $c->save();

    $c = new User();
    $c->cid = 1234567;
    $c->initials = "JT";
    $c->first_name = 'John';
    $c->last_name = 'Test';
    $c->username = $c->first_name . ' ' . $c->last_name;
    $c->password = Hash::make('zbw2014');
    $c->email = 'admin@bostonartcc.net';
    $c->signature = "John Test";
    $c->rating_id = 1;
    $c->artcc = "ZBW";
    $c->is_active = 1;
    $c->cert = 2;
    $c->save();

      foreach(range(1,199) as $i)
		{
        $first_name = $faker->firstName();
        $last_name = $faker->lastName();
        $initials = strtoupper($faker->randomLetter() . $faker->randomLetter());
			  \User::create([
            'cid' => $cids[$i - 1],
            'initials' => $initials,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'username' => $first_name . ' ' . $last_name,
            'password' => Hash::make($faker->word()),
            'email' => $faker->safeEmail(),
            'signature' => $first_name . ' ' . $last_name . '('.$initials.')',
            'rating_id' => $faker->numberBetween(0,6),
            'artcc' => 'ZBW',
            'is_active' => $faker->boolean(70),
            'is_mentor' => $faker->boolean(5),
        ]);
		}
	}

}
