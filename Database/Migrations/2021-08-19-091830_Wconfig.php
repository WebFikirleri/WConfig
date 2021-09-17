<?php

namespace WConfig\Database\Migrations;

use CodeIgniter\Database\Migration;

class Wconfig extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
			],
			'code' => [
				'type' => 'VARCHAR',
				'constraint' => 80,
			],
			'input_type' => [
				'type' => 'VARCHAR',
				'constraint' => 16,
				'null' => true,
			],
			'input_values' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'value' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'group' => [
				'type' => 'VARCHAR',
				'constraint' => 32,
				'null' => true,
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'deleted_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('wconfig');
		$this->populateData();
	}

	public function down()
	{
		$this->forge->dropTable('wconfig');
	}

	public function populateData()
	{
		$mdlWConfig = new \WConfig\Models\WConfig();
		if (env('app.multiLanguage') === TRUE) {
			$mdlWConfig->insert(['name'=>'WAdmin Panel Title','code'=>'WAdminTitle','input_type'=>'text','value'=>json_encode(['en'=>'Panel Title']),'group'=>'wadmin']);
		} else {
			$mdlWConfig->insert(['name'=>'WAdmin Panel Title','code'=>'WAdminTitle','input_type'=>'text','value'=>'Panel Title','group'=>'wadmin']);
		}
	}
}
