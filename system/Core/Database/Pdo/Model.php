<?php declare( strict_types = 1 );
namespace Core\Database\Pdo;

use function Zpheur\DataTransforms\Dotenv\env;
use PDOStatement;
use PDO;

class Model
{
    protected PDO $pdo;
    protected PDOStatement $stmt;
    
    public function __construct( PDO $pdo )
    {
        $this->pdo = $pdo;
    }

    public static function new(): mixed
    {
        try
        {
            $dbHost = env('SQLDB_HOST');
            $dbName = env('SQLDB_NAME');
            $dbUser = env('SQLDB_USERNAME');
            $dbPass = env('SQLDB_PASSWORD');

            return new \PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass, [
                \PDO::ATTR_PERSISTENT => true
            ]);
        }
        catch( \PDOException )
        {
            return false;
        }
    }

    public static function query( string $query ): self
    {
        $model = new self(self::new());
        $model->prepare($query);

        return $model;
    }

    public static function exec( string $query ): bool
    {
        $model = new self(self::new());
        $model->exec($query);

        return true;
    }

    public function prepare( string $query )
    {
        $this->stmt = $this->pdo->prepare($query);
    }

    public function get(): PDOStatement
    {
        $this->stmt->fetch(PDO::FETCH_ASSOC);
        $this->stmt->execute();

        return $this->stmt;
    }
}