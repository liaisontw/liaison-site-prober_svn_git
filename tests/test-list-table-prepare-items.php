<?php
/**
 * @group listtable
 */
class Test_LIAISIPR_List_Table_Prepare_Items extends WP_UnitTestCase {

    private $table;
    private $wpdb;

    public function setUp(): void {
        parent::setUp();

        global $wpdb;
        $this->wpdb  = $wpdb;
        $this->table = $wpdb->prefix . 'liaisipr_test_logs';

        $wpdb->query("
            CREATE TABLE {$this->table} (
                id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                created_at datetime NOT NULL,
                user_id bigint(20),
                ip varchar(100),
                action varchar(255),
                object_type varchar(255),
                description text,
                PRIMARY KEY  (id)
            ) ENGINE=InnoDB;
        ");

        $wpdb->insert( $this->table, [
            'created_at'  => '2025-01-01 12:00:00',
            'user_id'     => 1,
            'ip'          => '127.0.0.1',
            'action'      => 'login',
            'object_type' => 'user',
            'description' => 'User logged in'
        ]);
    }

    public function tearDown(): void {
        $this->wpdb->query("DROP TABLE IF EXISTS {$this->table}");
        parent::tearDown();
    }

    public function test_prepare_items_loads_rows() {

        //require_once __DIR__ . '/../wp-site-prober/admin/class-liaisipr-list-table.php';
        require_once __DIR__ . '/../includes/class-liaison-site-prober-list-table.php';

        // 建立 instance
        $list_table = new LIAISIPR_List_Table();
        $list_table->table_name = $this->table; // override 真正 table name

        $list_table->prepare_items();

        $this->assertNotEmpty( $list_table->items );
        $this->assertEquals( 'login', $list_table->items[0]['action'] );
    }
}
