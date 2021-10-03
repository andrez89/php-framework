<?php

namespace App\Core\Database;

use PDO;
use App\Core\App;

class QueryBuilder
{
    /**
     * The PDO instance.
     *
     * @var PDO
     */
    protected $pdo;

    /**
     * Create a new QueryBuilder instance.
     *
     * @param PDO $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Select all records from a database table.
     *
     * @param string $table
     */
    public function selectAll($table, $fields = "*", $order = "1", $limit = 500)
    {
        try {
            $statement = $this->pdo->prepare("select {$fields} from {$table} order by {$order} limit {$limit}");

            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            if (App::get('config')['server']['display_errors'] == 1) {
                die($e->getMessage());
            }
        }
    }

    /**
     * Select all records from a database table given a where condition.
     *
     * @param string $table
     * @param array $where
     */
    public function selectWhere($table, $where, $order = "1", $limit = 500)
    {
        try {
            $ps = array_keys($where);
            $pf = [];
            foreach ($ps as $p) {
                $pf[] = $p . " = :" . $p;
            }
            $ml = " ";

            $sql = sprintf(
                'select * from %s where (%s) order by %s limit %s',
                $table,
                implode(') AND (', array_values($pf)) . $ml,
                $order,
                $limit
            );

            $statement = $this->pdo->prepare($sql);

            $statement->execute($where);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            if (App::get('config')['server']['display_errors'] == 1) {
                var_dump($where);
                echo "<br>" . $sql . "<br>";
                die($e->getMessage());
            }
        }
    }


    public function select($table, $where, $fields = "*", $more = [], $less = [], $order = "1", $limit = 500)
    {
        try {
            $ps = array_keys($where);
            $pf = [];
            foreach ($ps as $p) {
                $pf[] = $p . " = :" . $p;
            }
            $ml = " ";
            foreach ($more as $m => $mV) {
                $ml .= " AND " . $m . " > :" . $m;
                $where[$m] = $mV;
            }
            foreach ($less as $m => $mV) {
                $ml .= " AND " . $m . " < :" . $m;
                $where[$m] = $mV;
            }

            $sql = sprintf(
                'select %s from %s where (%s) order by %s limit %s',
                $fields,
                $table,
                implode(') AND (', array_values($pf)) . $ml,
                $order,
                $limit
            );

            $statement = $this->pdo->prepare($sql);

            $statement->execute($where);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            if (App::get('config')['server']['display_errors'] == 1) {
                var_dump($where);
                echo "<br>" . $sql . "<br>";
                die($e->getMessage());
            }
        }
    }

    public function selectBetween($table, $where, $order = "1", $limit = 500, $between = [], $fields = "*")
    {
        try {
            $ps = array_keys($where);
            $pf = [];
            foreach ($ps as $p) {
                $pf[] = $p . " = :" . $p;
            }
            $bt = " ";
            foreach ($between as $b => $bp) {
                if (sizeof($bp) == 2) {
                    $bt .= " AND " . $b . " BETWEEN :" . $b . "1 AND :" . $b . "2 ";
                    $where[$b . "1"] = $bp[0];
                    $where[$b . "2"] = $bp[1];
                }
            }

            $sql = sprintf(
                'select %s from %s where %s order by %s limit %s',
                $fields,
                $table,
                implode(' AND ', array_values($pf)) . $bt,
                $order,
                $limit
            );

            $statement = $this->pdo->prepare($sql);

            $statement->execute($where);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            if (App::get('config')['server']['display_errors'] == 1) {
                var_dump($where);
                echo "<br>" . $sql . "<br>";
                die($e->getMessage());
            }
        }
    }

    public function selectGroup($table, $groupedFields, $where, $sums, $order = "1", $limit = 500, $between = [])
    {
        try {
            $ps = array_keys($where);
            $pf = [];
            foreach ($ps as $p) {
                $pf[] = $p . " = :" . $p;
            }
            $pf[] = "0 = 0";
            $bt = " ";
            foreach ($between as $b => $bp) {
                if (sizeof($bp) == 2) {
                    $bt .= " AND " . $b . " BETWEEN :" . $b . "1 AND :" . $b . "2 ";
                    $where[$b . "1"] = $bp[0];
                    $where[$b . "2"] = $bp[1];
                }
            }

            $sql = sprintf(
                'select %s from %s where %s group by %s order by %s limit %s',
                $groupedFields . "," . $sums,
                $table,
                implode(' AND ', array_values($pf)) . $bt,
                $groupedFields,
                $order,
                $limit
            );

            $statement = $this->pdo->prepare($sql);

            $statement->execute($where);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            if (App::get('config')['server']['display_errors'] == 1) {
                var_dump($where);
                echo "<br>" . $sql . "<br>";
                die($e->getMessage());
            }
        }
    }

    /**
     * Select all records from a database table given a where condition.
     *
     * @param string $table
     * @param array $where
     */

    public function selectLIKE($table, $where, $and = [], $fields = "*", $order = "1", $limit = 500)
    {
        try {
            $ps = array_keys($where);
            $pf = [];
            foreach ($ps as $p) {
                $pf[] = $p . " LIKE CONCAT('%', :" . $p . ", '%')";
            }
            $bt = " ";
            foreach ($and as $b => $bp) {
                $bt .= " AND " . $b . " = :" . $b;
                $where[$b] = $bp;
            }

            $sql = sprintf(
                'select ' . $fields . ' from %s where %s order by %s limit %s',
                $table,
                "( " . implode(' OR ', array_values($pf)) . " ) " . $bt,
                $order,
                $limit
            );

            $statement = $this->pdo->prepare($sql);

            $statement->execute($where);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            if (App::get('config')['server']['display_errors'] == 1) {
                var_dump($where);
                echo "<br>" . $sql . "<br>";
                die($e->getMessage());
            }
        }
    }

    /**
     * Select all records from a database table given a where condition.
     *
     * @param string $table
     * @param array $where
     */

    public function hasResult($table, $where)
    {
        try {
            $ps = array_keys($where);
            $pf = [];
            foreach ($ps as $p) {
                $pf[] = $p . " = :" . $p;
            }
            $sql = sprintf(
                'select * from %s where %s',
                $table,
                implode(' AND ', array_values($pf))
            );

            $statement = $this->pdo->prepare($sql);

            $statement->execute($where);

            return $statement->rowCount() > 0;
        } catch (\Exception $e) {
            if (App::get('config')['server']['display_errors'] == 1) {
                var_dump($where);
                echo "<br>" . $sql . "<br>";
                die($e->getMessage());
            }
        }
    }

    public function selectAllLessEqualThan($tblName, $whatId, $Idx)
    {
        try {
            $sql = "SELECT * FROM {$tblName} WHERE {$whatId} <= {$Idx}";

            $statement = $this->pdo->prepare($sql);

            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            if (App::get('config')['server']['display_errors'] == 1) {
                echo "<br>" . $sql . "<br>";
                die($e->getMessage());
            }
        }
    }

    public function selectByFKey($tableSel, $Idx)
    {
        try {
            $sql = "SELECT model FROM {$tableSel} WHERE id = {$Idx}";

            $statement = $this->pdo->prepare($sql);

            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            if (App::get('config')['server']['display_errors'] == 1) {
                echo "<br>" . $sql . "<br>";
                die($e->getMessage());
            }
        }
    }

    /*------------------------------------------------------------------------\
        Aim: Legge la riga dei dati di default relativa all'utente della ses-
        sione attiva.
    \------------------------------------------------------------------------*/

    public function getUserDefault()
    {
        try {
            $sql = "SELECT * FROM user_default WHERE dflt_userid = {$_SESSION['user_id']}";

            $statement = $this->pdo->prepare($sql);

            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            if (App::get('config')['server']['display_errors'] == 1) {
                echo "<br>" . $sql . "<br>";
                die($e->getMessage());
            }
        }
    }

    /*-----------------------------------------------------------------------*/

    /**
     * Insert a record into a table.
     *
     * @param  string $table
     * @param  array  $parameters
     */
    public function insert($table, $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        try {
            $statement = $this->pdo->prepare($sql);

            $statement->execute($parameters);
            return $this->pdo->lastInsertId();
        } catch (\Exception $e) {
            if (App::get('config')['server']['display_errors'] == 1) {
                echo "<br>" . $sql . "<br>";
                die($e->getMessage());
            }
        }
    }

    /**
     * Update records of a table.
     *
     * @param  string $table
     * @param  array  $parameters
     * @param  string $where
     */
    public function update($table, $parameters, $where)
    {

        $ps = array_keys($parameters);
        $pf = [];
        foreach ($ps as $p) {
            $pf[] = $p . " = :" . $p;
        }

        $sql = sprintf(
            'update %s SET %s where %s',
            $table,
            implode(', ', array_values($pf)),
            $where
        );

        //echo $sql;
        try {
            $statement = $this->pdo->prepare($sql);

            $statement->execute($parameters);
        } catch (\Exception $e) {
            if (App::get('config')['server']['display_errors'] == 1) {
                var_dump($parameters);
                echo "<br>" . $sql . "<br>";
                die($e->getMessage());
            }
        }
    }

    // Check if exist at least one row for the table: $tblName.
    // Se la tabella non ha alcun record, restituisce true, cioè
    // è vero che non contiene alcuna riga.

    public function IsThisTableEmpty($tblName)
    {

        $statement = $this->pdo->prepare("select * from {$tblName}");

        $statement->execute();

        $resultArray = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($resultArray) == 0)
            return true;

        else
            return false;
    }

    /**
     * Insert a record into a table.
     *
     * @param  string $sql
     * @param  array  $parameters
     */
    public function customQuery($sql, $parameters = [])
    {
        try {
            $statement = $this->pdo->prepare($sql);

            $statement->execute($parameters);

            if (strpos(strtoupper($sql), "SELECT") !== false) {
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return [];
            }
        } catch (\Exception $e) {
            if (App::get('config')['server']['display_errors'] == 1) {
                var_dump($parameters);
                echo "<br>" . $sql . "<br>";
                die($e->getMessage());
            }
        }
    }
}
