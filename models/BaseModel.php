<?php
    class BaseModel
    {
        private $connection;
        private $query;
        private $params;

        public function __construct($query, $params)
        {
            $this->connection=new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE_NAME, DB_USERNAME, DB_PASSWORD);
            $this->query=$query;
            $this->params=$params;
        }
        public function requete()
        {
            $statement=$this->connection->prepare($this->query);
            $statement->execute($this->params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    