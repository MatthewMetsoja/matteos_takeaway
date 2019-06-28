<?php
        
        class Transaction{
            
            private $db;

            public function __construct()
            {
                $this->db = new Database;
            }


            public function addTransaction($data)
            { //Prepare query
                $this->db->query("INSERT INTO transactions (id, customer_id, items_ordered, amount, status) 
                VALUES( :id, :customer_id, :items_ordered, :amount, :status) " ); 

             //Bind Values
                $this->db->bind(':id', $data['id']);
                $this->db->bind(':customer_id', $data['customer_id']);
                $this->db->bind(':items_ordered',$data['items_ordered']);
                $this->db->bind(':amount', $data['amount']);
                $this->db->bind(':status', $data['status']);

             // Execute 
                    if($this->db->execute())
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }

            }


            
            public function getTransactions(){

                $this->db->query('SELECT * FROM transactions ORDER BY created_at DESC ');

                $results = $this->db->resultset();

                return $results;

            }


        }