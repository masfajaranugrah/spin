<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Make winner records snapshot participant data so they survive
     * deletion of the participant (customer) they belong to.
     */
    public function up(): void
    {
        $this->addSnapshotColumns();
        $this->backfillSnapshotData();
        $this->detachParticipant();
    }

    private function addSnapshotColumns(): void
    {
        $columnNames = ['participant_name', 'participant_address', 'participant_phone'];

        $existing = DB::table('information_schema.columns')
            ->where('table_schema', DB::connection()->getDatabaseName())
            ->where('table_name', 'winners')
            ->whereIn('column_name', $columnNames)
            ->pluck('column_name')
            ->all();

        $missing = array_diff($columnNames, $existing);

        if (count($missing) === 0) {
            return;
        }

        Schema::table('winners', function (Blueprint $table) use ($missing) {
            $previous = 'participant_id';

            foreach ($missing as $column) {
                $table->string($column)->nullable()->after($previous);
                $previous = $column;
            }
        });
    }

    private function backfillSnapshotData(): void
    {
        DB::statement('UPDATE winners w LEFT JOIN participants p ON p.id = w.participant_id SET w.participant_name = p.name, w.participant_address = p.address, w.participant_phone = p.phone_number WHERE w.participant_name IS NULL');
    }

    private function detachParticipant(): void
    {
        $constraintExists = DB::table('information_schema.table_constraints')
            ->where('constraint_schema', DB::connection()->getDatabaseName())
            ->where('table_name', 'winners')
            ->where('constraint_name', 'winners_participant_id_foreign')
            ->where('constraint_type', 'FOREIGN KEY')
            ->exists();

        if ($constraintExists) {
            DB::statement('ALTER TABLE winners DROP FOREIGN KEY winners_participant_id_foreign');
            DB::statement('ALTER TABLE winners DROP INDEX winners_participant_id_foreign');
        }

        Schema::table('winners', function (Blueprint $table) {
            $table->unsignedBigInteger('participant_id')->nullable()->change();
            $table->foreign('participant_id')->references('id')->on('participants')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('winners', function (Blueprint $table) {
            $table->dropForeign(['participant_id']);
            $table->unsignedBigInteger('participant_id')->nullable(false)->change();
            $table->foreign('participant_id')->references('id')->on('participants')->cascadeOnDelete();
        });

        Schema::table('winners', function (Blueprint $table) {
            $table->dropColumn(['participant_name', 'participant_address', 'participant_phone']);
        });
    }
};