<?php

// Composer: "fzaninotto/faker": "v1.3.0"

class GroupsTableSeeder extends Seeder {

    public function run()
    {
	      DB::table('groups')->truncate();
        \Sentry::createGroup([
              'name' => 'Executive',
              'permissions' => [
                  'roster.all' => 1,
                  'news.all' => 1,
                  'forum.all' => 1,
                  'files.sector' => 1,
                  'sops.all' => 1,
                  'pages.all' => 1,
                  'groups.all' => 1,
                  'staff.all' => 1
              ]
          ]);
        \Sentry::createGroup([
            'name' => 'ATM',
            'permissions' => [
              'roster.all' => 1,
              'news.all' => 1,
              'forum.all' => 1,
              'files.sector' => 1,
              'sops.all' => 1,
              'pages.all' => 1,
              'groups.all' => 1,
              'staff.all' => 1
            ]
          ]);
        \Sentry::createGroup([
            'name' => 'DATM',
            'permissions' => [
              'roster.all' => 1,
              'news.all' => 1,
              'forum.all' => 1,
              'files.sector' => 1,
              'sops.all' => 1,
              'pages.all' => 1,
              'groups.all' => 1,
              'staff.all' => 1
            ]
          ]);
        \Sentry::createGroup([
            'name' => 'TA',
            'permissions' => [
              'roster.all' => 1,
              'news.all' => 1,
              'forum.all' => 1,
              'files.sector' => 1,
              'sops.all' => 1,
              'pages.all' => 1,
              'groups.all' => 1,
              'staff.all' => 1
            ]
          ]);
        \Sentry::createGroup([
            'name' => 'WEB',
            'permissions' => [
              'roster.all' => 1,
              'news.all' => 1,
              'forum.all' => 1,
              'files.sector' => 1,
              'sops.all' => 1,
              'pages.all' => 1,
              'groups.all' => 1,
              'staff.all' => 1
            ]
          ]);
        \Sentry::createGroup([
            'name' => 'FE',
            'permissions' => [
              'news.all' => 1,
              'files.sector' => 1,
            ]
          ]);
        \Sentry::createGroup([
              'name' => 'Facilities',
              'permissions' => [
                  'roster.view' => 1,
                  'news.create' => 1,
                  'files.sector' => 1
              ]
          ]);
        \Sentry::createGroup([
              'name' => 'Instructors',
              'permissions' => [
                'reports.create' => 1,
                'reports.view' => 1,
                'reports.update' => 1,
                'reports.delete' => 0,
                'reports.filter' => 1,
                'sessions.accept' => 1,
                'sessions.cancel' => 1
              ]
          ]);
        \Sentry::createGroup([
              'name' => 'Mentors',
              'permissions' => [
                  'reports.create' => 1,
                  'reports.view' => 1,
                  'reports.update' => 1,
                  'reports.delete' => 0,
                  'reports.filter' => 1,
                  'sessions.accept' => 1,
                  'sessions.cancel' => 0
              ]
          ]);
        \Sentry::createGroup([
              'name' => 'Events',
              'permissions' => [
                  'events.all' => 1
              ]
          ]);
        \Sentry::createGroup([
              'name' => 'Staff',
              'permissions' => [
                  'news.view' => 1
              ]
          ]);
        \Sentry::createGroup([
          'name' => 'Emeritus',
          'permissions' => [
            'news.view' => 1
          ]
        ]);
    }

}
