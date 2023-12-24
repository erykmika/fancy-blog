<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../db_config.php';

use PHPUnit\Framework\TestCase;

final class DatabaseTest extends TestCase
{
    public function testDatabaseCanBeRetrieved(): void
    {
        $database = Database::getDatabase();
        $result = ( $database != null );
        $this->assertSame(true, $result);
    }

    public function testConnectionCanBeRetrieved(): void
    {
        $database = Database::getDatabase();
        $connection = $database->getCon();
        $result = ( $connection != null );
        $this->assertSame(true, $result);
    }
}