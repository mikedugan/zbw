<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTrackingToExamRecordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_records', function (Blueprint $table) {
            $table->string('SOP_assigned_by')->default(0);
            $table->string('SOP_checked_off_by')->default(0);
            $table->string('C_S1_assigned_by')->default(0);
            $table->string('C_S1_checked_off_by')->default(0);
            $table->string('V_S1_assigned_by')->default(0);
            $table->string('V_S1_checked_off_by')->default(0);
            $table->string('B_S1_assigned_by')->default(0);
            $table->string('B_S1_checked_off_by')->default(0);
            $table->string('C_S2_assigned_by')->default(0);
            $table->string('C_S2_checked_off_by')->default(0);
            $table->string('V_S2_assigned_by')->default(0);
            $table->string('V_S2_checked_off_by')->default(0);
            $table->string('B_S2_assigned_by')->default(0);
            $table->string('B_S2_checked_off_by')->default(0);
            $table->string('C_S3_assigned_by')->default(0);
            $table->string('C_S3_checked_off_by')->default(0);
            $table->string('V_S3_assigned_by')->default(0);
            $table->string('V_S3_checked_off_by')->default(0);
            $table->string('B_S3_assigned_by')->default(0);
            $table->string('B_S3_checked_off_by')->default(0);
            $table->string('C_assigned_by')->default(0);
            $table->string('C_checked_off_by')->default(0);
            $table->string('V_C_assigned_by')->default(0);
            $table->string('V_C_checked_off_by')->default(0);

            $table->timestamp('SOP_assigned_on')->nullable();
            $table->timestamp('SOP_checked_off_on')->nullable();
            $table->timestamp('C_S1_assigned_on')->nullable();
            $table->timestamp('C_S1_checked_off_on')->nullable();
            $table->timestamp('V_S1_assigned_on')->nullable();
            $table->timestamp('V_S1_checked_off_on')->nullable();
            $table->timestamp('B_S1_assigned_on')->nullable();
            $table->timestamp('B_S1_checked_off_on')->nullable();
            $table->timestamp('C_S2_assigned_on')->nullable();
            $table->timestamp('C_S2_checked_off_on')->nullable();
            $table->timestamp('V_S2_assigned_on')->nullable();
            $table->timestamp('V_S2_checked_off_on')->nullable();
            $table->timestamp('B_S2_assigned_on')->nullable();
            $table->timestamp('B_S2_checked_off_on')->nullable();
            $table->timestamp('C_S3_assigned_on')->nullable();
            $table->timestamp('C_S3_checked_off_on')->nullable();
            $table->timestamp('V_S3_assigned_on')->nullable();
            $table->timestamp('V_S3_checked_off_on')->nullable();
            $table->timestamp('B_S3_assigned_on')->nullable();
            $table->timestamp('B_S3_checked_off_on')->nullable();
            $table->timestamp('C_assigned_on')->nullable();
            $table->timestamp('C_checked_off_on')->nullable();
            $table->timestamp('V_C_assigned_on')->nullable();
            $table->timestamp('V_C_checked_off_on')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_records', function (Blueprint $table) {
            $table->dropColumn('SOP_assigned_by');
            $table->dropColumn('SOP_checked_off_by');
            $table->dropColumn('C_S1_assigned_by');
            $table->dropColumn('C_S1_checked_off_by');
            $table->dropColumn('V_S1_assigned_by');
            $table->dropColumn('V_S1_checked_off_by');
            $table->dropColumn('B_S1_assigned_by');
            $table->dropColumn('B_S1_checked_off_by');
            $table->dropColumn('C_S2_assigned_by');
            $table->dropColumn('C_S2_checked_off_by');
            $table->dropColumn('V_S2_assigned_by');
            $table->dropColumn('V_S2_checked_off_by');
            $table->dropColumn('B_S2_assigned_by');
            $table->dropColumn('B_S2_checked_off_by');
            $table->dropColumn('C_S3_assigned_by');
            $table->dropColumn('C_S3_checked_off_by');
            $table->dropColumn('V_S3_assigned_by');
            $table->dropColumn('V_S3_checked_off_by');
            $table->dropColumn('B_S3_assigned_by');
            $table->dropColumn('B_S3_checked_off_by');
            $table->dropColumn('C_assigned_by');
            $table->dropColumn('C_checked_off_by');
            $table->dropColumn('V_C_assigned_by');
            $table->dropColumn('V_C_checked_off_by');

            $table->dropColumn('SOP_assigned_on');
            $table->dropColumn('SOP_checked_off_on');
            $table->dropColumn('C_S1_assigned_on');
            $table->dropColumn('C_S1_checked_off_on');
            $table->dropColumn('V_S1_assigned_on');
            $table->dropColumn('V_S1_checked_off_on');
            $table->dropColumn('B_S1_assigned_on');
            $table->dropColumn('B_S1_checked_off_on');
            $table->dropColumn('C_S2_assigned_on');
            $table->dropColumn('C_S2_checked_off_on');
            $table->dropColumn('V_S2_assigned_on');
            $table->dropColumn('V_S2_checked_off_on');
            $table->dropColumn('B_S2_assigned_on');
            $table->dropColumn('B_S2_checked_off_on');
            $table->dropColumn('C_S3_assigned_on');
            $table->dropColumn('C_S3_checked_off_on');
            $table->dropColumn('V_S3_assigned_on');
            $table->dropColumn('V_S3_checked_off_on');
            $table->dropColumn('B_S3_assigned_on');
            $table->dropColumn('B_S3_checked_off_on');
            $table->dropColumn('C_assigned_on');
            $table->dropColumn('C_checked_off_on');
            $table->dropColumn('V_C_assigned_on');
            $table->dropColumn('V_C_checked_off_on');
        });
    }

}
