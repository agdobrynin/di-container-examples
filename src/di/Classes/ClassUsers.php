<?php

declare(strict_types=1);

namespace Di\Classes;

class ClassUsers
{
    public function __construct(protected \PDO $pdo)
    {
    }

    public function createTable(): void
    {
        $this->pdo->query('CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name varchar(255)
        )');
    }

    public function addUser(string $name): bool
    {
        return $this->pdo
            ->prepare('insert into users (name) values (:name)')
            ->execute([':name' => $name]);
    }

    public function getUser(string $name): array
    {
        if ($sth = $this->pdo
            ->prepare('select * from users where name = :name')) {
            $sth->execute([':name' => $name]);

            return $sth->fetch(mode: \PDO::FETCH_ASSOC);
        }

        throw new \RuntimeException('Cannot prepare sql');
    }
}
