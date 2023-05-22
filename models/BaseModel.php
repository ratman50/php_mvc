<?php
    class BaseModel
    {
        private $connection;
        private $query;
        private $params;
        private $rowsAffected;
        private $resultat;

        public function __construct($query, $params=[])
        {
            $this->connection=new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE_NAME, DB_USERNAME, DB_PASSWORD);
            $this->query=$query;
            $this->params=$params;
            $this->rowsAffected=0;
            $this->resultat=[];
        }
        public function requete()
        {
            $statement=$this->connection->prepare($this->query);
            $statement->execute($this->params);
            $this->rowsAffected=$statement->rowCount();
            $this->resultat=$statement->fetchAll(PDO::FETCH_ASSOC);;
        }
        public function getResultat(){
            return $this->resultat;
        }
        public function getRowsAffected(){
            return $this->rowsAffected;
        }
    }
    