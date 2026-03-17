<?php

use yii\db\Migration;

final class m260317_000001_autoincrement_skill_ids extends Migration
{
    public function safeUp(): void
    {
        $this->ensureAutoIncrementPkId('Skill');

        // MySQL 8+ forbids modifying referenced columns under an active FK.
        $this->dropForeignKey('fk_Skill_SkillCathegory', 'Skill');
        $this->ensureAutoIncrementPkId('SkillCathegory');
        $this->addForeignKey(
            'fk_Skill_SkillCathegory',
            'Skill',
            'SkillCathegory_id',
            'SkillCathegory',
            'id'
        );
    }

    public function safeDown(): bool
    {
        echo "m260317_000001_autoincrement_skill_ids cannot be reverted safely.\n";

        return false;
    }

    private function ensureAutoIncrementPkId(string $table): void
    {
        $schema = $this->db->schema->getTableSchema($table);
        if ($schema === null) {
            throw new \RuntimeException("Table not found: {$table}");
        }

        $idColumn = $schema->columns['id'] ?? null;
        if ($idColumn === null) {
            throw new \RuntimeException("Column not found: {$table}.id");
        }

        // Keep existing base type to stay compatible with FKs (e.g. smallint vs int).
        $idDbType = $idColumn->dbType;
        if ($idDbType === null || $idDbType === '') {
            throw new \RuntimeException("Cannot determine dbType for {$table}.id");
        }

        // If PK is already id, don't try to re-add PRIMARY KEY (it triggers 1068).
        if ($schema->primaryKey === ['id']) {
            $this->execute("ALTER TABLE `{$table}` MODIFY `id` {$idDbType} NOT NULL AUTO_INCREMENT");
            return;
        }

        // Otherwise force id to be the PK (and in MySQL that also implies auto-increment).
        if (!empty($schema->primaryKey)) {
            $this->dropPrimaryKey("pk_{$table}", $table);
        }

        $this->addPrimaryKey("pk_{$table}", $table, 'id');
        $this->execute("ALTER TABLE `{$table}` MODIFY `id` {$idDbType} NOT NULL AUTO_INCREMENT");
    }
}

